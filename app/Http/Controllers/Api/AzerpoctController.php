<?php

namespace App\Http\Controllers\Api;

use App\Models\Extra\Notification;
use App\Models\Package;
use App\Services\AzerpoctService;

class AzerpoctController extends Controller
{
    public function ping()
    {
        return "pong";
    }

    public function update(\Request $request)
    {
        logger( $request->all() );

        if (
            $request->get('azerpost_shared_secret') == config('services.azerpost.secret') &&
            $request->get('vendor_id') == config('services.azerpost.vendor_id')
        ) {
            $status_id = $request->get('status_id');

            $scan_post_code = $request->get('scan_post_code');

            $packages = $request->get('packages', []);

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

            return response('1', 200);
        }

        abort('403');
    }
}