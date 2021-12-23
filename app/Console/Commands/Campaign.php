<?php

namespace App\Console\Commands;

use App\Models\Extra\Notification;
use App\Models\Extra\SMS;
use App\Models\NotificationQueue;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Class Campaign
 *
 * @package App\Console\Commands
 */
class Campaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:check';

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
        $campaign = \App\Models\Campaign::where('sent', 0)->latest()->first();

        if ($campaign) {
            // 4:42
            // 5:42
            // 4:42 - 1 >= 4:42 + 1

            if ($campaign->created_at <= Carbon::now()->subHours($campaign->send_after)) {
                $this->info($campaign->title);
                $id = explode(",", $campaign->users);
                $users = User::whereIn('id', $id)->where('campaign_notifications', 1)->get();
                foreach ($users as $user) {
                    $content = $campaign->content;
                    $content = str_replace("{name}", $user->full_name, $content);
                    $content = str_replace("{code}", $user->customer_id, $content);
                    $content = str_replace("{email}", $user->email, $content);

                    if ($user->cleared_phone) {
                        $content = str_replace("{phone}", "+" . $user->cleared_phone, $content);
                    } else {
                        $content = str_replace("{phone}", "", $content);
                    }
                    if ($user->passport) {
                        $content = str_replace("{passport}", $user->passport, $content);
                    } else {
                        $content = str_replace("{passport}", "", $content);
                    }

                    if ($user->city_name) {
                        $content = str_replace("{city}", $user->city_name, $content);
                    } else {
                        $content = str_replace("{city}", "", $content);
                    }

                    $to = $campaign->type == 'SMS' ? SMS::clearNumber($user->phone) : $user->email;
                    $type = $campaign->type == 'SMS' ?: 'EMAIL';



                    if ($to) {
                        $data = [
                            'to'          => $to,
                            'subject'     => $campaign->title,
                            'content'     => $content,
                            'type'        => $type,
                            'send_for_id' => $campaign->id,
                            'send_for'    => 'CAMPAIGN',
                            'user_id'     => $user->id,
                        ];
                        $exists = NotificationQueue::where($data)->first();

                        if (! $exists) {
                            NotificationQueue::create($data);
                            //$this->info($user->id . " :: " . $to);
                            sleep(1);
                        }

                    }
                }

                $campaign->sent = 1;
                $campaign->save();
            }
        }
    }
}
