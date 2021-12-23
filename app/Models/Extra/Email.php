<?php

namespace App\Models\Extra;

use App\Models\EmailTemplate;
use App\Models\NotificationQueue;
use App\Models\SMSTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

/**
 * App\Models\Extra\Email
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\Email newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\Email newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\Email query()
 */
class Email extends Model
{
    /**
     * @param \App\Models\NotificationQueue $queue
     * @return bool
     */
    public static function sendByQueue(NotificationQueue $queue)
    {
        if ($queue && $queue->type == 'EMAIL') {
            $newData = [
                'email'   => $queue->to,
                'subject' => $queue->subject,
                'content' => $queue->content,
            ];

            @Mail::send('front.mail.notification', $newData, function ($message) use ($newData) {
                $message->from('noreply@' . env("DOMAIN_NAME"), env('APP_NAME'));
                $message->to($newData['email']);
                $message->subject($newData['subject']);
            });

            return true;
        }

        return false;
    }

    /**
     * @param $userId
     * @param $data
     * @param $templateKey
     * @return bool
     */
    public static function sendByUser($userId, $data, $templateKey)
    {
        $template = EmailTemplate::where('key', $templateKey)->where('active', 1)->first();

        $user = User::find($userId);

        if (! $template || ! $user || ! $user->email || ! $user->notification) {
            return false;
        }

        $content = clarifyContent($template->content, $data);

        $id = (isset($data['id']) ? $data['id'] : uniqid());

        $exists = false;
        $data = [
            'to'          => $user->email,
            'hour_after'  => isset($data['after']) ? $data['after'] : null,
            'subject'     => $template->name . " #" . $id,
            'content'     => $content,
            'type'        => 'EMAIL',
            'send_for_id' => $id,
            'user_id'     => $userId,
        ];

        /* if (0 && $templateKey != 'package_status_alert') {
             $exists = NotificationQueue::where($data)->first();
         }*/

        if (! $exists) {

            NotificationQueue::create($data);
        }

        return true;
    }

    /**
     * @param $email
     * @param $data
     * @param $templateKey
     * @return bool
     */
    public static function sendByAddress($email, $data, $templateKey)
    {
        $template = EmailTemplate::where('key', $templateKey)->where('active', 1)->first();

        if (! $template) {
            return false;
        }

        $content = clarifyContent($template->content, $data);

        NotificationQueue::create([
            'to'      => $email,
            'subject' => $template->name . " #" . (isset($data['id']) ? $data['id'] : uniqid()),
            'content' => $content,
            'type'    => 'EMAIL',
        ]);

        return true;
    }

    /**
     * @param $data
     * @param $templateKey
     * @return bool
     */
    public static function sendToAllUsers($data, $templateKey)
    {
        $template = EmailTemplate::where('key', $templateKey)->where('active', 1)->first();

        if (! $template) {
            return false;
        }

        $users = User::all();
        $content = clarifyContent($template->content, $data);

        $newData = [
            'content' => $content,
        ];

        foreach ($users as $user) {
            @Mail::send('front.mail.notification', $newData, function ($message) use ($newData, $user) {
                $message->from('noreply@' . env('DOMAIN_NAME'));
                $message->to($user->email);
                $message->subject($newData['content']);
            });
        }

        return true;
    }
}
