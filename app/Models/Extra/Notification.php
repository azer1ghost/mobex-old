<?php

namespace App\Models\Extra;

use App\Models\Link;
use App\Models\NotificationQueue;
use App\Models\Order;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 *
 * @package App\Models\Extra
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extra\Notification query()
 */
class Notification extends Model
{
    /**
     * @param $number
     * @param $data
     */
    public static function verify($number, $data)
    {
        SMS::verifyNumber($number, $data);
    }

    /**
     * @param $data
     * @param string $templateKey
     * @return bool
     */
    public static function sendToAllUsers($data, $templateKey = 'registration')
    {
        if (env('EMAIL_NOTIFICATION')) {
            Email::sendToAllUsers($data, $templateKey);
        }
        if (env('SMS_NOTIFICATION')) {
            SMS::sendToAllUsers($data, $templateKey);
        }

        return true;
    }

    /**
     * @param $packageId
     * @param $status
     * @param $after
     * @return bool
     */
    public static function sendPackage($packageId, $status, $after = 0)
    {
        $package = Package::find($packageId);

        if (! $package || ! $package->user) {
            return false;
        }

        $data = [
            'id'                => $package->id,
            'after'             => $after,
            'warehouse_comment' => $package->warehouse_comment,
            'cwb'               => $package->custom_id,
            'customs_type'      => $package->customs_type,
            'track_code'        => $package->tracking_code,
            'user'              => $package->user->full_name,
            'fin'               => $package->user->fin,
            'code'              => $package->user->customer_id,
            'city'              => $package->user->city_name,
            'filial'            => $package->user->filial_name,
            'invoice_price'     => $package->shipping_org_price,
            'delivery_price'    => $package->delivery_price,
            'price'             => $package->merged_delivery_price,
            'total_price'       => $package->total_price,
            'web_site'          => getOnlyDomain($package->website_name),
            'weight'            => $package->weight_with_type,
            'number_items'      => $package->number_items,
            'country'           => (isset($package->warehouse) && isset($package->warehouse->country)) ? $package->warehouse->country->name : 'Türkiyə',
        ];
        $template = ($status == 'no_declaration') ? $status : ('package_status_' . $status);

        return self::sendBoth($package->user_id, $data, $template);
    }

    /**
     * @param $userID
     * @param $data
     * @param $status
     * @return bool
     */
    public static function sendPackageManually($userID, $data, $status)
    {
        return self::sendBoth($userID, $data, 'package_status_' . $status);
    }

    /**
     * @param $orderID
     * @param int $status
     * @return bool
     */
    public static function sendOrder($orderID, $status = 0)
    {
        $order = Order::find($orderID);

        if (! $order || ! $order->user) {
            return false;
        }

        $data = [
            'id'       => $order->id,
            'order_id' => $order->id,
            'price'    => $order->total_price,
            'user'     => $order->user->full_name,
        ];

        return self::sendBoth($order->user_id, $data, 'order_status_' . $status);
    }

    /**
     * @param $linkId
     * @param int $status
     * @return bool
     */
    public static function sendLink($linkId, $status = 0)
    {
        $link = Link::find($linkId);
        $order = $link->order;

        if (! $link || ! $link->order || ! $link->order->user) {
            return false;
        }

        $data = [
            'id'       => $link->id,
            'order_id' => $order->id,
            'link'     => $link->url,
            'amount'   => $link->amount,
            'color'    => $link->color,
            'size'     => $link->size,
            'order'    => $order->id,
            'price'    => $link->total_price,
            'user'     => $order->user->full_name,
        ];

        return self::sendBoth($order->user_id, $data, 'link_status_' . $status);
    }

    /**
     * @param $userID
     * @param $data
     * @param $status
     * @return bool
     */
    public static function sendOrderManually($userID, $data, $status)
    {
        return self::sendBoth($userID, $data, 'order_status_' . $status);
    }

    /* ================== ORDERS ================== */

    /**
     * @param $userID
     * @param $data
     * @param $template
     * @return bool
     */
    public static function sendBoth($userID, $data, $template)
    {
        $userID = self::determineUser($userID);
        @self::sendEmail($userID, $data, $template);
        @self::sendSMS($userID, $data, $template);

        return true;
    }

    /**
     * @param \App\Models\NotificationQueue $queue
     * @return bool
     */
    public static function sendBothForQueue(NotificationQueue $queue)
    {
        @self::sendQueueEmail($queue);
        @self::sendQueueSMS($queue);
        @self::sendQueuePush($queue);

        return true;
    }

    /**
     * @param $userID
     * @param $data
     * @param $template
     * @return bool|void
     */
    public static function sendEmail($userID, $data, $template)
    {
        $userID = self::determineUser($userID);

        return env('EMAIL_NOTIFICATION') ? Email::sendByUser($userID, $data, $template) : false;
    }

    /**
     * @param $userID
     * @param $data
     * @param $template
     * @return bool|\Psr\Http\Message\StreamInterface
     */
    public static function sendSMS($userID, $data, $template)
    {
        $userID = self::determineUser($userID);

        return env('SMS_NOTIFICATION') ? SMS::sendByUser($userID, $data, $template) : false;
    }

    /**
     * @param \App\Models\NotificationQueue $queue
     * @return bool
     */
    public static function sendQueueEmail(NotificationQueue $queue)
    {
        return env('EMAIL_NOTIFICATION') ? Email::sendByQueue($queue) : false;
    }

    /**
     * @param \App\Models\NotificationQueue $queue
     * @return bool
     */
    public static function sendQueueSMS(NotificationQueue $queue)
    {
        return env('SMS_NOTIFICATION') ? SMS::sendByQueue($queue) : false;
    }

    /**
     * @param \App\Models\NotificationQueue $queue
     * @return bool
     */
    public static function sendQueuePush(NotificationQueue $queue)
    {
        return env('PUSH_NOTIFICATION') ? SMS::sendPushByQueue($queue) : false;
    }

    /**
     * @param $userId
     * @return int|mixed|null
     */
    public static function determineUser($userId)
    {
        $user = User::find($userId);

        return ($user && $user->parent_id) ? $user->parent_id : $userId;
    }
}
