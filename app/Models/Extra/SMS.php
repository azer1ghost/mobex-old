<?php

namespace App\Models\Extra;

use App\Models\NotificationQueue;
use App\Models\SMSTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

/**
 * App\Models\Extra\SMS
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\SMS newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\SMS newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\SMS query()
 */
class SMS extends Model
{
    /**
     * @param $number
     * @param $text
     * @param null $type
     * @return \Psr\Http\Message\StreamInterface
     */
    public static function getData($number, $text, $type = null)
    {
        // Ignore limit for campaign
        $limit = $type == 'CAMPAIGN' ? 10000 : 265;

        $client = new \GuzzleHttp\Client();

        $text = str_limit(trim(str_replace("\r\n", "", $text)), $limit);

        $number = self::clearNumber($number);

        $request = @$client->get('http://www.poctgoyercini.com/api_http/sendsms.asp?user=' . env('SMS_USER') . '&password=' . env('SMS_PASSWORD') . '&gsm=' . $number . '&from=' . env('SMS_FROM') . '&text=' . $text);

        return $request->getBody();
    }

    /**
     * @param \App\Models\NotificationQueue $queue
     * @return bool
     */
    public static function sendByQueue(NotificationQueue $queue)
    {
        if ($queue && $queue->type == 'SMS') {
            self::getData(self::clearNumber($queue->to), $queue->content, $queue->send_for);

            return true;
        }

        return false;
    }

    /**
     * @param $number
     * @param $content
     * @param null $subject
     */
    public static function sendPureTextByNumber($number, $content, $subject = null)
    {
        NotificationQueue::create([
            'to'      => self::clearNumber($number),
            'content' => $content,
            'subject' => $subject,
            'type'    => 'SMS',
        ]);
    }

    /**
     * @param $number
     * @param array $data
     * @param $templateKey
     * @return bool|\Psr\Http\Message\StreamInterface
     */
    public static function sendByNumber($number, $data = [], $templateKey)
    {
        $template = SMSTemplate::where('key', $templateKey)->where('active', 1)->first();

        if (! $template) {
            return false;
        }

        $content = clarifyContent($template->content, $data);

        return self::getData(self::clearNumber($number), $content);
    }

    /**
     * @param $userId
     * @param $data
     * @param $templateKey
     * @return bool
     */
    public static function sendByUser($userId, $data, $templateKey)
    {
        $template = SMSTemplate::where('key', $templateKey)->where('active', 1)->first();

        if (! $template) {
            return false;
        }

        $user = User::find($userId);

        if (! $template || ! $user || ! $user->phone || ! $user->notification) {
            return false;
        }

        $content = clarifyContent($template->content, $data);
        $id = (isset($data['id']) ? $data['id'] : uniqid());

        $deviceId = $user->android_device_id ?: ($user->ios_device_id ?: null);
        $deviceName = $user->android_device_id ? 'ANDROID' : ($user->ios_device_id ? 'IOS' : null);

        if ($deviceId && $template->push_link) {
            $pushData = [
                'to'          => $deviceId,
                'extra_to'    => "https://mobex.az/" . $template->push_link,
                'hour_after'  => isset($data['after']) ? $data['after'] : null,
                'content'     => $content,
                'subject'     => $template->name . " #" . $deviceName . "_" . $id,
                'type'        => 'PUSH',
                'send_for_id' => $id,
                'user_id'     => $userId,
            ];
            NotificationQueue::create($pushData);
        }

        $data = [
            'to'          => self::clearNumber($user->phone),
            'hour_after'  => isset($data['after']) ? $data['after'] : null,
            'content'     => $content,
            'subject'     => $template->name . " #" . $id,
            'type'        => 'SMS',
            'send_for_id' => $id,
            'user_id'     => $userId,
        ];

        NotificationQueue::create($data);

        return true;
    }

    /**
     * @param $data
     * @param $templateKey
     * @return bool
     */
    public static function sendToAllUsers($data, $templateKey)
    {
        $template = SMSTemplate::where('key', $templateKey)->where('active', 1)->first();

        if (! $template) {
            return false;
        }

        $users = User::all();

        $content = clarifyContent($template->content, $data);
        foreach ($users as $user) {
            self::getData(self::clearNumber($user->phone), $content);
        }
    }

    /**
     * @param $number
     * @param bool $addPrefix
     * @param null $space
     * @return mixed
     */
    public static function clearNumber($number, $addPrefix = false, $space = null)
    {
        $number = explode(";", $number)[0];
        $number = explode(",", $number)[0];
        $number = explode("/", $number)[0];
        $number = explode('\\', $number)[0];

        $number = str_replace(" ", "", $number);
        $number = str_replace("_", "", $number);
        $number = str_replace("-", "", $number);
        $number = str_replace("(", "", $number);
        $number = str_replace(")", "", $number);
        $number = trim($number);

        if (substr($number, 0, 1) === '+') {
            $number = str_replace("+", "", $number);
        }

        if (substr($number, 0, 2) === '00') {
            $number = str_replace("00", "", $number);
        }

        if (substr($number, 0, 3) === '994') {
            $number = str_replace("994", "", $number);
        }

        if (substr($number, 0, 2) === '94') {
            $number = str_replace("94", "", $number);
        }

        if (strlen($number) == 10 || substr($number, 0, 1) === '0') {
            $number = substr($number, 1);
        }

        $number = preg_replace('/\D/', '', $number);

        if ($addPrefix && strlen($number) == 9) {
            $number = "994" . $space . $number;
        }

        if (strlen($number) < 9) {
            $number = null;
        }

        return $number;
    }

    /**
     * @param $number
     * @param $data
     * @return bool|\Psr\Http\Message\StreamInterface
     */
    public static function verifyNumber($number, $data)
    {
        $template = SMSTemplate::where('key', 'sms_verify')->where('active', 1)->first();

        if (! $template) {
            return false;
        }
        $content = clarifyContent($template->content, $data);

        return self::getData(self::clearNumber($number), $content);
    }

    /**
     * @param \App\Models\NotificationQueue $queue
     * @return bool
     */
    public static function sendPushByQueue(NotificationQueue $queue)
    {
        if ($queue && $queue->type == 'PUSH') {
            self::sendPushNotification($queue->to, $queue->content, $queue->extra_to);

            return true;
        }

        return false;
    }

    /**
     * @param $deviceId
     * @param $text
     * @param $url
     * @return bool|string
     */
    public static function sendPushNotification($deviceId, $text, $url)
    {
        $content = [
            "en" => $text,
        ];

        $fields = [
            'app_id'                        => env('ONESIGNAL_ID'),
            'include_player_ids'            => [
                $deviceId,
            ],
            'channel_for_external_user_ids' => 'push',
            'data'                          => ['url' => $url],
            'contents'                      => $content,
        ];

        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . env('ONESIGNAL_TOKEN'),
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
