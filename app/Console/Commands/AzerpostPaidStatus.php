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
        $packages = Package::query()
            ->where('status', '>=', config('ase.attributes.package.status.8'))
            ->where('azerpoct_vendor_payment_status', false)
            ->where('paid', true)
            ->get();

        foreach ($packages as $package){

            $response = (new AzerpoctService($package))->vp_status();

            if ($response->getStatusCode() == 200) {
                $package->setAttribute('azerpoct_vendor_payment_status', true);
            } else {
                $package->setAttribute('azerpoct_response_log', $response->getBody()->getContents());
            }

            $package->save();
        }

    }
}