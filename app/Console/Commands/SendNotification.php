<?php

namespace App\Console\Commands;

use App\Models\Extra\Notification;
use App\Models\NotificationQueue;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendNotification
 *
 * @package App\Console\Commands
 */
class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:send {--type=}';

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
        $type = $this->option('type');
        /* Just in case ignore repeated  */
        while (true) {
            $nots = NotificationQueue::selectRaw('subject, count(id) as ss')->where('created_at', '>=', Carbon::today())->where('send_for', '!=', 'CAMPAIGN')->where('type', $type)->groupBy('subject')->having('ss', '>', 1)->get();

            if (! $nots->count()) {
                break;
            }

            foreach ($nots as $note) {
                $this->error($note->subject);
                $not = NotificationQueue::where('subject', $note->subject)->where('type', $type)->latest()->first();
                $not->delete();
            }
        }
        sleep(5);


        $hour = (int) Carbon::now()->format('H');
        //if (10 <= $hour && $hour <= 22) {
        if (1) {
            $count = 40;//$type == 'SMS' ? 40 : 24;

            $queues = NotificationQueue::where('sent', 0)->where('type', $type)->orderBy('send_for', 'asc')->orderBy('id', 'asc')->take($count)->get();

            foreach ($queues as $queue) {
                try {
                    if (Carbon::now() > $queue->created_at->addHours($queue->hour_after)) {
                        $this->line($queue->id . " :: " . $queue->to . " => " . $queue->subject);
                        Notification::sendBothForQueue($queue);
                        $queue->sent = 1;
                        $queue->save();
                        sleep(2);
                    }
                } catch (\Exception $exception) {
                    $queue->sent = 1;
                    $queue->save();
                    $message = null;
                    $message .= "🆘 <b>Error by sending notification</b> " . $queue->to;
                    $message .= chr(10) . $exception->getMessage();
                    $queue->error_message = $exception->getMessage();
                    $queue->save();

                    sendTGMessage($message);
                }
            }

            if (count($queues)) {
                /* Send notification */
                $message = null;
                $message .= "🆘 <b>Error by sending notification</b>";
                //sendTGMessage($message);
            }
        } else {
            $this->error("Out of time");
        }
    }
}
