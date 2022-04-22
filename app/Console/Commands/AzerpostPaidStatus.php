<?php

namespace App\Console\Commands;

use App\Models\Package;
use App\Services\AzerpoctService;
use Illuminate\Console\Command;

class AzerpostPaidStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'azerpost:paid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //config('ase.attributes.package.status');

        Package::query()
            ->whereIn('status',  [8, 9])
            ->where('paid', '>', 0)
            ->where('azerpoct_vendor_payment_status', false)
            ->whereNotNull('zip_code')
            ->get()
            ->each(function ($package) {
                $response = (new AzerpoctService($package))->vp_status();
                if ($response->getStatusCode() == 200) {
                    $package->setAttribute('azerpoct_vendor_payment_status', true);
                    $package->setAttribute('azerpoct_response_log', $response->getBody()->getContents());
                } else {
                    $package->setAttribute('azerpoct_response_log', $response->getBody()->getContents());
                }
                $package->save();
            });
    }
}
