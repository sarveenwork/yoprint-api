<?php

namespace App\Job;

use App\Models\File;
use App\Models\Detail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function handle()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 480);

        $file = File::find($this->file->id);
        if (!$file) {
            throw new \Exception("File not found with id: " . $this->file->id);
        }

        $file->status = 'processing';
        $file->save();

        try {
            $filePath = storage_path('app/' . $file->file_path);

            // Check if a previous version of the file exists
            $file2 = File::where('file_name', $file->file_name)
                ->where('status', 'completed')
                ->orderBy('id', 'desc')
                ->first();

            if ($file2) {
                $file2Path = storage_path('app/' . $file2->file_path);
                $this->compareAndProcessCSV($filePath, $file2Path);
            } else {
                $this->processSingleCSV($filePath);
            }

            // Update file status to 'completed'
            $file->status = 'completed';
            $file->updated_at = now();
            $file->save();
        } catch (\Throwable $e) {
            // If an error occurs, update file status to 'failed'
            $file->status = 'failed';
            $file->save();

            throw $e;
        }
    }

    private function compareAndProcessCSV($filePath1, $filePath2)
    {
        $csv1 = Reader::createFromPath($filePath1, 'r');
        $csv1->setHeaderOffset(0);
        $csv2 = Reader::createFromPath($filePath2, 'r');
        $csv2->setHeaderOffset(0);

        $records1 = iterator_to_array($csv1->getRecords());
        $records2 = iterator_to_array($csv2->getRecords());

        $headers = $csv1->getHeader();

        foreach ($records1 as $index => $record1) {
            $record2 = $records2[$index] ?? null;

            if ($record2 && $record1 != $record2) {
                // Process the difference
                $this->processRow($record1);
            }
        }
    }

    private function processSingleCSV($filePath)
    {
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $headers = $csv->getHeader();

        foreach ($csv as $row) {
            $data = array_combine($headers, $row);
            $this->processRow($data);
        }
    }

    private function processRow(array $row)
    {
        Detail::updateOrCreate(
            ['UNIQUE_KEY' => $this->removeNonUtf8Chars($row['UNIQUE_KEY'])],
            [
                'PRODUCT_TITLE' =>  $this->removeNonUtf8Chars($row['PRODUCT_TITLE']),
                'PRODUCT_DESCRIPTION' =>  $this->removeNonUtf8Chars($row['PRODUCT_DESCRIPTION']),
                'STYLE' =>  $this->removeNonUtf8Chars($row['STYLE#']),
                'SANMAR_MAINFRAME_COLOR' =>  $this->removeNonUtf8Chars($row['SANMAR_MAINFRAME_COLOR']),
                'SIZE' =>  $this->removeNonUtf8Chars($row['SIZE']),
                'COLOR_NAME' =>  $this->removeNonUtf8Chars($row['COLOR_NAME']),
                'PIECE_PRICE' =>  $this->removeNonUtf8Chars($row['PIECE_PRICE']),
            ]
        );
    }

    public function removeNonUtf8Chars($string)
    {
        $string = html_entity_decode($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Remove non-UTF-8 characters using regular expression
        $string = preg_replace('/[^\x{0000}-\x{007F}]+/u', '', $string);

        return $string;
    }
}
