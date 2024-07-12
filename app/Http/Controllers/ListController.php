<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;

// use DB;

class ListController extends Controller
{
    use ApiResponser;

    // public function index()
    // {
    //     $file = File::get();

    //     return $this->success(
    //         'Get File List',
    //         $file
    //     );
    // }

    // public function store(Request $request)
    // {

    //     $input = $request->all();
    //     $user = Auth::user();
    //     $validator = Validator::make($input, [
    //         'name' => 'required',
    //         'address_1' => 'required',
    //         'dial_code' => 'required',
    //         'phone' => 'required',
    //         'postcode' => 'required',
    //         'city' => 'required',
    //         'state' => 'required',
    //         'country' => 'required',
    //         // 'defaultBilling' => 'required',
    //         // 'defaultDelivery' => 'required',
    //     ]);
    //     if ($validator->fails()) {
    //         return $this->error(
    //             implode(' ', $validator->messages()->all()),
    //             '',
    //             422
    //         );
    //     }

    //     $input['user_id'] = $user->main_user_id ?? $user->id;
    //     $input['created_by'] =  $user->id;
    //     $input['is_delete'] = 0;
    //     $input['billing_entity_id'] = $user->default_billing_entity_id;



    //     $address = AddressBook::create($input);

    //     if ($input['defaultBilling'] || $input['defaultDelivery']) {
    //         $billingEntity = BillingEntity::where('id', $user->default_billing_entity_id)->first();
    //         if ($input['defaultBilling']) {
    //             $billingEntity->billing_address_book_id = $address->id;
    //         }
    //         if ($input['defaultDelivery']) {
    //             $billingEntity->default_delivery_address_book_id = $address->id;
    //         }
    //         $billingEntity->save();
    //     }
    //     //log
    //     AuditLogController::addLog('Create', 'Address', $address->id, $address->id, $address->id, "", $address, "Create #" . $address->id);

    //     //success
    //     return $this->success(
    //         'Address Create Successfully',
    //         // $address
    //     );
    // }

    // public function update(Request $request, $id)
    // {
    //     $input = $request->all();

    //     $validator = Validator::make($input, [
    //         'name' => 'required',
    //         'address_1' => 'required',
    //         'dial_code' => 'required',
    //         'phone' => 'required',
    //         'postcode' => 'required',
    //         'city' => 'required',
    //         'state' => 'required',
    //         'country' => 'required',
    //         // 'defaultBilling' => 'required',
    //         // 'defaultDelivery' => 'required',
    //     ]);
    //     if ($validator->fails()) {
    //         return $this->error(
    //             implode(' ', $validator->messages()->all()),
    //             '',
    //             422
    //         );
    //     }
    //     try {
    //         $id = Crypt::decrypt($id);
    //     } catch (DecryptException $e) {
    //         return $this->error(
    //             'Something went wrong'
    //         );
    //     }
    //     $address = AddressBook::where('id', $id)->where('is_delete', 0)->first();
    //     $user = Auth::user();


    //     $input['updated_by'] = $user->id;


    //     if ($address) {
    //         if ($input['defaultBilling'] || $input['defaultDelivery']) {
    //             $billingEntity = BillingEntity::where('id', $user->default_billing_entity_id)->first();
    //             if ($input['defaultBilling']) {
    //                 $billingEntity->billing_address_book_id = $address->id;
    //             }
    //             if ($input['defaultDelivery']) {
    //                 $billingEntity->default_delivery_address_book_id = $address->id;
    //             }
    //             $billingEntity->save();
    //         }

    //         if ($address->update($input)) {

    //             //log
    //             $data = AddressBook::where('id', $id)->first();
    //             AuditLogController::addLog('Update', 'Address', $data->id, $data->id, $data->id, "", $data, "Update #" . $data->id);
    //         } else {
    //             return $this->error(
    //                 'Address Update Failed'
    //             );
    //         }
    //     } else {
    //         return $this->error(
    //             'Address Not Found'
    //         );
    //     }

    //     //success
    //     return $this->success(
    //         'Address Update Successfully'
    //     );
    // }

    // public function destroy($id)
    // {
    //     try {
    //         $id = Crypt::decrypt($id);
    //     } catch (DecryptException $e) {
    //         return $this->error(
    //             'Something went wrong'
    //         );
    //     }
    //     $user = Auth::user();

    //     $billingEntity = BillingEntity::where(function ($query) use ($id) {
    //         $query->where('default_delivery_address_book_id', $id)
    //             ->orWhere('billing_address_book_id', $id);
    //     })->first();

    //     if ($billingEntity) {
    //         return $this->error(
    //             'Default Address Cannot be Deleted'
    //         );
    //     }

    //     $address = AddressBook::where('id', $id)->where('is_delete', 0)->first();

    //     if ($address) {
    //         $address->is_delete = 1;
    //         $address->deleted_at = Carbon::now()->format('Y-m-d H:i:s');
    //         $address->deleted_by = $user->id;
    //         $address->save();

    //         //log
    //         AuditLogController::addLog('Delete', 'Address', $address->id, $address->id, $address->id, "", $address, "Delete #" . $address->id);
    //     } else {
    //         return $this->error(
    //             'Address Not Found'
    //         );
    //     }

    //     //success
    //     return $this->success(
    //         'Address Removed'
    //     );
    // }
}
