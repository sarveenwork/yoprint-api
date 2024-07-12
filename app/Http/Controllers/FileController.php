<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Job\ProcessFile;
use Log;

class FileController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $file = File::orderBy('id', 'desc')->get();

        return $this->success(
            'Get File List',
            $file
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'File Uploaded Failed'
            );
        }
        $file = $request->file('file');

        $newFile = new File();
        $newFile->file_name = $file->getClientOriginalName();
        $newFile->file_path = $file->store('uploads');
        $newFile->mime_type = $file->getClientMimeType();
        $newFile->status = 'pending';
        $newFile->save();

        ProcessFile::dispatch($newFile);

        return $this->success(
            'File Uploaded Successfully'
        );
    }
}
