<?php

namespace App\Console\Commands;

use App\Models\Extra\Notification;
use App\Models\Extra\SMS;
use App\Models\Order;
use App\Models\Package;
use App\Models\Promo;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Class Daily
 *
 * @package App\Console\Commands
 */
class Daily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily {--type=stats}';

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
     * @throws \Exception
     */
    public function handle()
    {
        if ($this->option('type') == 'promo') {
            $this->removePromo();
        } elseif ($this->option('type') == 'dept') {
            $this->notifyDept();
        } else {
            $this->promos();
            $this->stats();
        }

    }

    /**
     * Promo statistic notification
     */
    public function promos()
    {
        $promos = Promo::withCount('users')->where('status', 'ACTIVE')->get();

        $message = "🔊🔊🔊 <b>Promos</b> " . chr(10);
        foreach ($promos as $promo) {
            if ($promo->users_count) {
                $this->line($promo->code . " :: " . $promo->users_count);
                $message .= chr(10) . $promo->title . " (" . $promo->code . ")  :: <b>" . $promo->users_count . " users</b> (" . $promo->efficiency . ")";
            }
        }

        sendTGMessage($message);

        sleep(5);
    }

    /**
     * General statistic notification
     */
    public function stats()
    {
        //SMS::getData();
        $prev = (Carbon::now())->subDays(2)->format("Y-m-d");
        $start = (Carbon::now())->subDays(1)->format("Y-m-d");
        $end = (Carbon::now())->format("Y-m-d");

        $typeNames = ['CASH', 'PAY_TR', 'PAYMES', 'PORTMANAT', 'POST_TERMINAL'];

        $orders = Order::where('paid', 1)->where('created_at', '>=', $start)->where('created_at', '<', $end)->count();
        $packages = Package::where('created_at', '>=', $start)->where('created_at', '<', $end)->count();
        $users = User::where('created_at', '>=', $start)->where('created_at', '<', $end)->count();
        $items = Transaction::where('created_at', '>=', $start)->where('created_at', '<', $end)->get();
        $income = [
            'count'  => 0,
            'amount' => 0,
        ];
        $outcome = [
            'count'  => 0,
            'amount' => 0,
        ];
        $total = [
            'count'  => 0,
            'amount' => 0,
        ];

        $types = [];

        foreach ($items as $transaction) {
            $transaction->admin_amount;
            if ($transaction->admin_amount > 0) {
                $income['amount'] += $transaction->admin_amount;
                $income['count']++;
            } elseif ($transaction->admin_amount < 0) {
                $outcome['amount'] += $transaction->admin_amount;
                $outcome['count']++;
            }

            if (in_array($transaction->paid_by, $typeNames)) {
                if (isset($types[$transaction->paid_by])) {
                    $types[$transaction->paid_by] += $transaction->admin_amount;
                } else {
                    $types[$transaction->paid_by] = $transaction->admin_amount;
                }
            }

            $total['amount'] += $transaction->admin_amount;
            $total['count']++;
        }

        $ordersPrev = Order::where('paid', 1)->where('created_at', '>=', $prev)->where('created_at', '<', $start)->count();
        $packagesPrev = Package::where('created_at', '>=', $prev)->where('created_at', '<', $start)->count();
        $usersPrev = User::where('created_at', '>=', $prev)->where('created_at', '<', $start)->count();
        $itemsPrev = Transaction::where('created_at', '>=', $prev)->where('created_at', '<', $start)->get();
        $incomePrev = [
            'count'  => 0,
            'amount' => 0,
        ];
        $outcomePrev = [
            'count'  => 0,
            'amount' => 0,
        ];
        $totalPrev = [
            'count'  => 0,
            'amount' => 0,
        ];

        $typesPrev = [];

        foreach ($itemsPrev as $transaction) {
            if ($transaction->admin_amount > 0) {
                $incomePrev['amount'] += $transaction->admin_amount;
                $incomePrev['count']++;
            } elseif ($transaction->admin_amount < 0) {
                $outcomePrev['amount'] += $transaction->admin_amount;
                $outcomePrev['count']++;
            }
            if (in_array($transaction->paid_by, $typeNames)) {
                if (isset($typesPrev[$transaction->paid_by])) {
                    $typesPrev[$transaction->paid_by] += $transaction->admin_amount;
                } else {
                    $typesPrev[$transaction->paid_by] = $transaction->admin_amount;
                }
            }

            $totalPrev['amount'] += $transaction->admin_amount;
            $totalPrev['count']++;
        }

        $totalPercentTotal = $totalPrev['amount'] ? round(100 * ($total['amount'] / $totalPrev['amount'] - 1), 2) : 0;
        $incomePercentTotal = $incomePrev['amount'] ? round(100 * ($income['amount'] / $incomePrev['amount'] - 1), 2) : 0;
        $outcomePercentTotal = $outcomePrev['amount'] ? round(100 * ($outcome['amount'] / $outcomePrev['amount'] - 1), 2) : 0;
        $usersPercentTotal = $usersPrev ? round(100 * ($users / $usersPrev - 1), 2) : 0;
        $packagesPercentTotal = $packagesPrev ? round(100 * ($packages / $packagesPrev - 1), 2) : 0;
        $ordersPercentTotal = $ordersPrev ? round(100 * ($orders / $ordersPrev - 1), 2) : 0;

        $up = '🔹';
        $down = '🔻';
        $message = "<b>#Stats of " . $start . "</b>";

        $message .= chr(10) . chr(10) . "<b>InCome</b> : <i>" . $income['amount'] . " AZN </i>" . ($incomePercentTotal > 0 ? $up : $down) . " " . $incomePercentTotal . "%";
        $message .= chr(10) . "<b>OutCome</b> : <i>" . $outcome['amount'] . " AZN </i>" . ($outcomePercentTotal > 0 ? $up : $down) . " " . $outcomePercentTotal . "%";
        $message .= chr(10) . "<b>Total</b> : <i>" . $total['amount'] . " AZN </i>" . ($totalPercentTotal > 0 ? $up : $down) . " " . $totalPercentTotal . "%";
        $message .= chr(10) . chr(10) . "<b>New Users</b> : <i>" . $users . " users </i>" . ($usersPercentTotal > 0 ? $up : $down) . " " . $usersPercentTotal . "%";
        $message .= chr(10) . "<b>New Packages</b> : <i>" . $packages . " packages </i>" . ($packagesPercentTotal > 0 ? $up : $down) . " " . $packagesPercentTotal . "%";
        $message .= chr(10) . "<b>New Paid Orders</b> : <i>" . $orders . " orders </i>" . ($ordersPercentTotal > 0 ? $up : $down) . " " . $ordersPercentTotal . "%";
        sendTGMessage($message);
        sleep(5);
    }

    /**
     * @throws \Exception
     */
    public function removePromo()
    {
        // Deactive expired promos
        $promos = Promo::where('status', 'ACTIVE')->whereNotNull('end_date')->where('end_date', '<=', Carbon::now())->get();

        foreach ($promos as $promo) {
            $promo->status = 'PASSIVE';
            $promo->save();
        }



        $promos = Promo::where('status', 'PASSIVE')->where('checked', false)->pluck('id')->all();
        $users = User::whereIn('promo_id', $promos)->get();
        $count = $users->count();

        if ($count) {
            foreach ($users as $user) {

                if ($user->promo) {
                    $this->line($user->full_name . " :: " . $user->discount . " :: " . $user->promo->title);
                    if ($user->promo->action) {
                        //$user->promo_id = null;
                        if ($user->promo->discount) {
                            $user->discount = null;
                            $user->save();

                            // Delete non used Order Balance
                            if ($user->promo->order_balance) {
                                $transactions = Transaction::whereUserId($user->id)->where('paid_by', 'ORDER_BALANCE')->count();
                                if (! $transactions) {
                                    Transaction::whereUserId($user->id)->where('paid_for', 'ORDER_BALANCE')->where('paid_by', 'BONUS')->delete();
                                }
                            }
                        }


                    }

                }

                $promo = Promo::find($user->promo_id);
                if ($promo) {
                    $promo->checked = true;
                    $promo->save();
                }
            }

            $message = "🤞🤞🤞 #System " . $count . " müştərinin promo endirimi ləğv edildi.";
            sendTGMessage($message);
        }

    }

    /**
     * Dept alert notifications
     */
    public function notifyDept()
    {
        $users = [];
        $packages = Package::whereNotNull('scanned_at')->where('status', 2)->latest()->get();

        foreach ($packages as $package) {
            $days = diffInDays($package->scanned_at);
            $user = User::find($package->user_id);
            if ($user->dealer) {
                $user = $user->dealer;
            }

            if (in_array($days, [8, 11, 14])) {
                //if ($days > 8) {
                if (isset($users[$user->id])) {
                    $users[$user->id]['amount'] += 1;
                } else {
                    $users[$user->id] = [
                        'amount' => 1,
                        'days'  => $days,
                        'user'  => $user->full_name,
                    ];
                }
            }
        }


        foreach ($users as $userId => $data) {
            $user = User::find($userId);
            $this->line($user->full_name . "(" . $user->customer_id . ")" . " .. " . $data['amount'] . " :: " . $data['days']);
            Notification::sendBoth($userId, $data, 'dept_alert');
        }

        if (count($users)) {
            $message = "🆘🆘🆘 <b>" . count($users) . "</b> müştərimizin paketlərini ən az 8 gündür depodan almadıqları üçün bildiriş göndərildi.";
            sendTGMessage($message);
        }
    }
}
