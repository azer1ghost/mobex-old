<?php

namespace App\Http\Controllers\Api;

use App\Models\Extra\Notification;
use App\Models\Package;
use App\Services\AzerpoctService;
use Illuminate\Http\Request;

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
            $this->validate($request, [
                'status_id'  => 'required',
                'scan_post_code' => 'required|string|max:10',
                'packages' => 'required|array',
                'vendor_id' => 'required|in:'.config('services.azerpost.vendor_id'),
            ]);

            $status_id = $request->get('status_id');

            $scan_post_code = $request->get('scan_post_code');

            $packages = $request->get('packages', []);

            logger('Login success');

            if ($packages)
            {
                foreach ($packages as $package)
                {
                    $package = Package::whereCustomAwb($package)->first();

                    if ($package) {
                        $package->update([
                            'azerpoct_status' => $status_id,
                            'azerpoct_response_log' => $scan_post_code,
                        ]);
                    }

                    if ($status_id == AzerpoctService::STATUS_AVAILABLE_FOR_PICKUP) {
                        Notification::sendPackage($package->getAttribute('id'), '9');
                    }
                }
            }

            return response(sizeof($packages). " Packages status updated", 200);
        }

        abort('403','Unauthorized request');
    }
}