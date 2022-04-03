<?php

namespace App\Http\Controllers\Api;

use App\Models\Extra\Notification;
use App\Models\Package;
use App\Services\AzerpoctService;
use Illuminate\Http\Request;
use Validator;

class AzerpoctController extends Controller
{
    public function ping()
    {
        return "pong";
    }

    public function update(Request $request)
    {
        logger( $request->all() );

        if ($request->header('x-api-key') === config('services.azerpost.secret'))
        {
            $validator = Validator::make($request->all(), [
                'status_id'  => 'required',
                'scan_post_code' => 'required|string|max:10',
                'packages' => 'required|array',
                'vendor_id' => 'required|in:'.config('services.azerpost.vendor_id'),
            ]);

            if ($validator->fails()) {
                return response($validator->errors());
            }

            $status_id = $request->get('status_id');

            $updatedCount = 0;

            foreach ($request->get('packages', []) as $package)
            {
                $package = Package::whereCustomId($package)->first();

                if ($package)
                {
                    $package->setAttribute('azerpoct_status', $status_id);
                    $package->setAttribute('azerpoct_response_log', $request->get('scan_post_code'));

                    if ($package->save()){
                        $updatedCount++;
                    }

                    if ($status_id == AzerpoctService::STATUS_AVAILABLE_FOR_PICKUP) {
                        Notification::sendPackage($package->getAttribute('id'), '9');
                    }
                }
            }


            return response($updatedCount. " Packages status updated", 200);
        }

        abort('403','Unauthorized request');
    }
}