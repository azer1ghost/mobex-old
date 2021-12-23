<?php

namespace App\Console\Commands;

use App\Models\Extra\Custom;
use App\Models\Extra\Notification;
use App\Models\Order;
use App\Models\Package;
use App\Models\Parcel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Class CustomSystem
 *
 * @package App\Console\Commands
 */
class CustomSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom {--type=insert} {--cwb=} {--user=} {--days=} {--w_id=} {--awb=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var \App\Models\Extra\Custom
     */
    protected $custom;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->custom = new Custom();

        if (env('APP_ENV') == 'local') {
            $this->custom->testMode();
        }

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $time_start = microtime(true);

        if ($this->option('type') == 'delete_old') {
            $this->deleteOldPackages();
        } elseif ($this->option('type') == 'depo') {
            $this->inWarehouse();
        } elseif ($this->option('type') == 'packages') {
            $this->packages();
        } elseif ($this->option('type') == 'resent') {
            $this->resentPackages();
        } elseif ($this->option('type') == 'declared') {
            $this->declared();
        } elseif ($this->option('type') == 'depesh') {
            $this->sentToCustoms();
        } elseif ($this->option('type') == 'update-depesh') {
            $this->updateAirwayBill();
        } elseif ($this->option('type') == 'notify') {
            $this->notify();
        } elseif ($this->option('type') == 'delete_old_decs') {
            $this->deleteOldEarlyDeclarations();
        }

        $time_end = microtime(true);

        $time = ceil(($time_end - $time_start));
        $this->error($time . ' secs');
    }

    /**
     * Update depesh info on parcel change
     */
    public function updateAirwayBill()
    {
        $changedParcel = Parcel::where('awb_changed', true)->latest()->first();

        if (! $changedParcel) {
            exit();
        }

        $awb = $changedParcel->awb;

        if (! $awb || ! $changedParcel->sent) {
            $changedParcel->awb_changed = false;
            $changedParcel->save();

            exit();
        }
        $allPackages = $changedParcel->packages();

        $allPackages->chunk(50, function ($packages) use ($awb, $changedParcel) {
            foreach ($packages as $package) {
                $data[] = [
                    'cwb'        => $package->custom_id,
                    'airWaybill' => $awb,
                ];
            }

            $res = $this->custom->updateDepesh($data);
            sendTGMessage("✈️✈️✈️ #SmartCustoms. Toplam " . count($data) . " paket yeniden " . $awb . " (#" . $changedParcel->id . ") awb nömrəsi ilə depesh edildi.");
        });

        $changedParcel->awb_changed = false;
        $changedParcel->save();

    }

    /**
     * Resent user's packages again if fin has been changed
     */
    public function resentPackages()
    {
        $userId = $this->option('user');
        if ($userId != null) {
            $user = User::find($userId);
        } else {
            $user = User::where('refresh_customs', true)->orderBy('updated_at', 'asc')->first();
        }

        $count = 0;
        if ($user) {
            $packages = Package::where('custom_status', 0)->where('user_id', $user->id)->get();
            foreach ($packages as $package) {
                $data = $this->custom->deletePackage($package->custom_id);

                if ($data && ($data['code'] == 200 || (isset($data['exception']['code']) && $data['exception']['code'] == '042'))) {
                    $package->custom_status = null;
                    $package->save();
                    $count++;
                    sendTGMessage("🆘 #SmartCustom  " . $package->custom_id . " gömrük sistemindən yenilənməsi üçün silindi!");
                } else {
                    if ($package->reg_number) {
                        $package->custom_status = 1;
                        $package->save();
                    }

                    sendTGMessage("🆘 #SmartCustom  " . $package->custom_id . " silmek olmur!");
                }
            }

            if ($count) {
                sendTGMessage("🚨 #SmartCustom  " . $user->full_name . " adlı müştərimizin bağlamaları gömrükdən silindi!");
                $this->inWarehouse();
            }
            $user->refresh_customs = false;
            $user->save();
        }
    }

    /**
     * Notify again not declared owners
     */
    public function notify()
    {
        $total = 0;
        $ignored = 0;
        $packages = Package::whereHas('parcel')->whereNotNull('weight')->where('status', 0)->whereNull('reg_number')->latest()->get();
        if ($packages->count()) {
            foreach ($packages as $key => $package) {
                if ($package->notified < 3) {
                    $this->line($key . ") " . $package->custom_id . " :: " . $package->reg_number);
                    Notification::sendPackage($package->id, 'alert');
                    $package->notified = $package->notified + 1;
                    $package->save();
                    $total++;
                } else {
                    $ignored++;
                }
            }

            if ($total) {
                sendTGMessage("🆘 #SmartCustom təkrar bəyan etmələri üçün " . $total . " ədəd paket sahibinə bildiriş göndərildi!");
            }

            if ($ignored) {
                sendTGMessage("🆘🆘 #SmartCustom 4 gündən artıq bəyan etmədikləri üçün " . $ignored . " paket ignore edildi!");
            }
        }
    }

    /**
     * Get Declared packages
     */
    public function declared()
    {
        $days = $this->option('days') ?: 1;
        $end = ($days - 15);
        $end = $end > 0 ? $end : 0;

        $response = $this->custom->getDeclaredPackages($days, $end);

        if (! isset($response['data'])) {
            // Error
            //sendTGMessage("🆘 #SmartCustom Declare error. No data #key! Taylor? " . \GuzzleHttp\json_encode($response, true));
            exit();
        }

        $addBox = [];
        $this->line("======================================================");
        foreach ($response['data'] as $key => $res) {
            $package = Package::whereCustomId($res['trackingNumber'])->first();
            if ($package) {

                $save = false;
                // dump($res['goodsList'][0], $package->custom_id);
                if (isset($res['goodsList'][0])) {
                    $currency = array_search($res['goodsList'][0]['currencyType'], config('ase.attributes.customs_currencies'));
                    $invoicePrice = $res['goodsList'][0]['invoicePrice'];
                    if ($currency == $package->shipping_amount_cur && $package->shipping_amount != $invoicePrice) {
                        $this->error("Found  " . $invoicePrice . " :: " . $package->shipping_amount . " :: " . $package->custom_id);
                        if (! $package->shipping_amount) {
                            $save = true;
                            $package->shipping_amount = $invoicePrice;
                        }
                    }
                }

                if (! $package->reg_number) {
                    $save = true;
                    $package->reg_number = $res['regNumber'];
                    if ($package->custom_status == 0) {
                        $this->line(($key + 1) . ") " . $res['regNumber'] . ' :: ' . $res['trackingNumber'] . " boxa əlavə edildi..");
                        $addBox[] = [
                            'regNumber'      => $res['regNumber'],
                            'trackingNumber' => $res['trackingNumber'],
                        ];
                        $package->custom_status = 1;
                    }
                }

                if ($save) {
                    $package->save();
                }
            }
        }

        if ($addBox) {
            $this->line("======================================================");
            $responseAddBox = $this->custom->addToBoxes($addBox);

            if (isset($responseAddBox['code']) && $responseAddBox['code'] == 200) {
                $this->line("Toplam " . count($addBox) . " bağlama boxa əlavə edildi!");
                $message = "📦 #SmartCustom " . count($addBox) . " bağlama boxa əlavə edildi!";

                $total = Package::select(\DB::raw("count(id) AS total"), \DB::raw("sum(weight) AS total_weight"))->whereHas('parcel')->where('status', 0)->first();
                $totalToday = Package::select(\DB::raw("count(id) AS total"), \DB::raw("sum(weight) AS total_weight"))->whereHas('parcel')->whereNotNull('weight')->whereNotNull('user_id')->where('status', 0)->where('arrived_at', '>=', Carbon::today())->first();
                $declared = Package::select(\DB::raw("count(id) AS total"), \DB::raw("sum(weight) AS total_weight"))->where('status', 0)->where('custom_status', 1)->first();
                if ($total && $total->total) {
                    $message .= "\n\n - Bu gün daxil olan: " . $totalToday->total . " ( " . round($totalToday->total_weight, 1) . " kq )";
                    $message .= "\n - Toplam depodakı mal: " . $total->total . " ( " . round($total->total_weight, 1) . " kq )";
                    $message .= "\n - Gömrükdə bəyan etmə: " . $declared->total . " ( " . round($declared->total_weight, 1) . " kq )";
                    $message .= "\n - Paket sayına görə bəyan edilmə faizi: " . round(100 * $declared->total / $total->total, 2) . "%";
                    $message .= "\n - Çəkiyə görə bəyan edilmə faizi: " . round(100 * $declared->total_weight / $total->total_weight, 2) . "%";
                }

                sendTGMessage($message);
            } else {
                sendTGMessage("🆘 #SmartCustom Declare status error. Taylor wtf? " . $responseAddBox['code']);
            }
        }
    }

    /**
     *
     */
    public function inWarehouse()
    {
        $this->line("Stared Custom inserting");

        while (true) {
            $cwb = $this->option('cwb');
            if ($cwb != null) {
                $packages = Package::where('custom_id', $cwb)->get();
            } else {
                $packages = Package::where('status', 0)->whereNull('custom_status')->take(25)->latest()->get();
            }

            /*foreach ($packages as $package) {
                if ($package->delivery_price && $package->weight && $package->user) {
                    continue;
                } else {
                    sendTGMessage("WARNING : " . $package->custom_id . " depoda olsa da ya müştərisi yoxdur, ya çəkisi!!");
                }
            }*/
            $this->line("");
            $this->info("Depoya daxil olmuş bağlamaların gömrüyə bildirilməsi başlandı.. ");

            if ($packages->count()) {
                $inserted = $this->custom->sendJustArrivedPackages($packages);

                if (is_array($inserted) && ! empty($inserted)) {
                    $check = $this->checkPackageStatus($inserted, $packages, 0);
                    if ($check) {
                        break;
                    }
                } else {
                    dump($inserted);
                    break;
                }
            } else {
                break;
            }

            break;
        }
    }

    /**
     * Depesh method
     */
    public function sentToCustoms()
    {
        $count = 0;
        $ignored = [0];
        while (true) {
            $changeStatus = 2;
            $packages = Package::whereNotIn('id', $ignored)->where('custom_status', ($changeStatus - 1))->where('status', 1)->take(25)->get();
            //$packages = Package::where('custom_id', 'CFX5677749')->get();
            $totalPackage = 0;

            $this->line("======================================================");
            $this->line("Toplam " . $packages->count() . " bağlama depesh edildi. (Gömrüyə göndərildi)");
            $this->line("======================================================");
            $goingToDepesh = 0;
            if (! $packages->count()) {
                break;
            }
            foreach ($packages as $package) {
                $awb = $package->parcel->count() && $package->parcel->first()->awb ? $package->parcel->first()->awb : ($package->custom_awb ?: null);
                $depeshNumber = $package->parcel->count() ? $package->parcel->first()->custom_id : ($package->custom_parcel_number ?: null);
                $insert = [
                    "regNumber"      => $package->reg_number,
                    "trackingNumber" => $package->custom_id,
                    "airWaybill"     => $awb,
                    "depeshNumber"   => $depeshNumber,
                ];

                if ($insert['regNumber'] && $insert['trackingNumber'] && $insert['airWaybill'] && $insert['depeshNumber']) {
                    $goingToDepesh++;
                    $this->warn(" - " . $package->user->fullname . " : " . $package->user->fin . " : " . $package->reg_number . " sistemə əlavə üçün yığıldı...");
                } else {
                    dump($insert);
                    $ignored[] = $package->id;
                    sendTGMessage("🆘 #SmartCustom #Depesh  Reg|Track|airWayBill|DepNum " . $package->custom_id . ".");
                }
            }
            //die;
            if ($goingToDepesh) {
                $response = $this->custom->depesh($packages);
                $this->line("==================zzzz=============================");
                dump($response);
                $this->line("======================================================");
                if ($response) {
                    if (isset($response['code']) && $response['code'] == 200) {

                        foreach ($packages as $package) {
                            if ($package->custom_status != 0) {
                                $this->info($package->custom_id . " depeshed");
                                $package->custom_status = $changeStatus;
                                $package->save();
                                $totalPackage++;
                                $count++;
                            }
                        }

                        $this->info("Toplam " . $packages->count() . " depesh edilib, Bakıya göndərildi.");
                    } else {
                        // Error
                        if (isset($response['data']) && $response['data']) {
                            $totalPackage = 0;
                            foreach ($response['data'] as $cwb => $error) {
                                $pack = Package::whereCustomId($cwb)->where('custom_status', '!=', 0)->first();
                                if (in_array($error, ['200', '048'])) {
                                    $this->error($cwb . " " . $error);
                                    if ($pack) {
                                        $pack->custom_status = $changeStatus;
                                        $pack->save();
                                        $totalPackage++;
                                    }
                                } elseif (in_array($error, ['042'])) {
                                    //$data = $this->custom->getAllPackages(15, 0, $cwb);
                                    //dd($data);
                                    $regNumber = $this->custom->getRegNumber($cwb);
                                    sendTGMessage("🆘 #SmartCustom 042 ERROR " . $cwb . ". RM was : " . $pack->reg_number . " and changed to " . $regNumber);
                                    if ($regNumber) {
                                        $pack->reg_number = $regNumber;
                                        $pack->save();
                                    } /*else {
                                        $ignored[] = $pack->id;
                                    }*/
                                } else {
                                    $this->error($cwb . " " . $error);
                                    sendTGMessage("🆘 #SmartCustom Adding to the box again " . $cwb . ".");
                                    $addBox[] = [
                                        'regNumber'      => $pack->reg_number,
                                        'trackingNumber' => $pack->custom_id,
                                    ];
                                    $this->info("Adding to box " . $pack->custom_id);
                                    $responseAddBox = $this->custom->addToBoxes($addBox);
                                }
                            }
                        } else {
                            sendTGMessage("🆘 #SmartCustom #Depesh error. No data key. Sir? ");
                        }
                    }
                    if ($totalPackage) {
                        sendTGMessage("✈️✈️✈️ #SmartCustoms. Toplam " . $totalPackage . " paket depesh edilib, Bakıya göndərildi.");
                    }
                }
            }

            sleep(10);
        }
    }

    /**
     * Delete old packages
     */
    public function deleteOldPackages()
    {
        $cwb = $this->option('cwb');
        /* $data = $this->custom->getAllPackages(15, 0, $cwb);
         dd($data);*/
        if ($cwb != null) {
            //$packages = Package::where('custom_id', $cwb)->get();
            $packages = Package::withTrashed()->where('created_at', '>=', '2021-01-15 00:00:00')->where('status', '!=', '6')->where(function (
                $q
            ) {
                $q->where('custom_status', 0)->orWhereNull('custom_status');
            })->where('custom_id', $cwb)->get();
        } else {
            $packages = Package::withTrashed()->where('custom_status', 0)->whereNotNull('custom_status')->where('deleted_at', '!=', null)->get();
        }

        foreach ($packages as $package) {
            $data = $this->custom->deletePackage($package->custom_id);
            //dump($data);
            $package->custom_status = null;
            $package->save();

            if ($data['code'] == 200 || $data['exception']['code'] == '042') {
                $this->error("🆘 #SmartCustom  " . $package->custom_id . " gömrük sistemindən üçün silindi!");
            } else {
                $this->error("🆘 #SmartCustom  " . $package->custom_id . " silmek olmur!");
            }
            sleep(1);
        }
    }

    /**
     * @param $inserted
     * @param $packages
     * @param int $customStatus
     * @param \App\Models\Parcel|null $parcel
     * @return bool
     */
    public function checkPackageStatus($inserted, $packages, $customStatus = 0, Parcel $parcel = null)
    {
        if (isset($inserted['status']) && $inserted['status'] == 200) {
            $totalPackage = count($packages);

            $this->info("Parcel inserted : " . $totalPackage . " packages");
            if ($parcel) {
                $parcel->customs_sent = true;
                $parcel->save();
            }
            $added = 0;
            $ignored = 0;
            foreach ($packages as $package) {
                if ($package->delivery_price && $package->weight && $package->user) {
                    $package->custom_status = $customStatus;
                    $package->save();
                    $added++;
                } else {
                    $ignored++;
                }
            }

            if ($added) {
                $message = "✅✅✅ #SmartCustom -da " . $added . " bağlama sistemə əlavə edildi. " . $ignored . " ignore edildi.";
                sendTGMessage($message);
                $this->line($message);
            }

            return true;
        } else {
            //$status = $inserted['status'] == 400 ? $customStatus : -1;

            if (isset($inserted['data'])) {
                foreach ($inserted['data'] as $statusOfPackage) {
                    $package = Package::whereCustomId(trim($statusOfPackage['id']))->first();

                    if ($package) {
                        $package->custom_status = $customStatus;
                        $package->custom_comment = $statusOfPackage['error'];
                        $package->save();

                        $this->warn("Removed :" . $statusOfPackage['id']);
                        $this->error("Error " . $statusOfPackage['error']);

                        Custom::errorTgMessage('Error : Parcel :: ' . $statusOfPackage['id'] . " Error : " . $statusOfPackage['error']);
                    }
                }
            }
        }

        return false;
    }

    public function deleteOldEarlyDeclarations()
    {
        $packages = Package::whereStatus(6)->where('created_at', '<', Carbon::now()->subDays(90))->get();
        $orders = Order::where('paid', 0)->where('created_at', '<', Carbon::now()->subDays(90))->get();

        if ($packages->count()) {
            foreach ($packages as $key => $package) {
                $this->line($key . " ) " . $package->custom_id);
                $package->delete();
            }

            $message = "🦷🦷🦷 #System " . $packages->count() . " bağlama köhnə bəyannamə olduğu üçün sistemdən çıxarıldı.";
            sendTGMessage($message);
        }
        if ($orders->count()) {
            foreach ($orders as $key => $order) {
                $this->line($key . " ) " . $order->id);
                $order->delete();
            }

            $message = "🦷🦷🦷 #System " . $orders->count() . " sifarişin vaxtı keçdiyi üçün sistemdən çıxarıldı.";
            sendTGMessage($message);
        }
    }


    public function packages()
    {
        $d = $this->custom->getDeclaredPackages(24 * 15, 0, 'MBX347627279');
        dd($d);
        die;
        $found = [];
        $depeshed = [];
        $after = Carbon::now()->subDays(3);
        $datas = [];

        for ($i = 5; $i <= 15; $i += 5) {
            $datas[] = $this->custom->getAllPackages($i - 5, $i);
            sleep(5);
        }

        $sent = Package::where('status', 1)->where('sent_at', ">=", $after)->where('custom_status', 2)->get();

        foreach ($datas as $data) {
            foreach ($data as $packages) {
                if (is_array($packages)) {
                    foreach ($packages as $package) {
                        if ($package['status'] == '3' && ! in_array($package['trackinG_NO'], $depeshed)) {
                            $depeshed[] = $package['trackinG_NO'];
                        } else {
                            $this->warn($package['trackinG_NO'] . " :: " . $package['status']);
                        }
                    }
                }
            }
        }

        $this->line($sent->count() . " depeshed");
        foreach ($sent as $sentPackage) {
            if (! in_array($sentPackage->custom_id, $depeshed)) {
                $this->error($sentPackage->custom_id);
                $message = "🆘🆘🆘 #SmartCustom -da " . $sentPackage->custom_id . " Depesh edilmeyib. Sizin sisteminizi ...";
                sendTGMessage($message);
            }
        }
        $this->error(count($depeshed) . " depeshed");
    }
}
