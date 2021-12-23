<?php

namespace App\Models\Payments;

use App\Models\Delivery;
use App\Models\Package;

/**
 * Class PortManat
 *
 * @package App\Models\Payments
 */
class PortManat
{
    /**
     * @var string
     */
    private $mainUrl = 'https://psp.mps.az/process';

    /**
     * @var mixed|string|null
     */
    private $client_ip = null;

    /**
     * @var \Illuminate\Config\Repository|int|mixed|null
     */
    private $service_id = null;

    /**
     * @var
     */
    private $hash;

    /**
     * @var
     */
    private $client_rrn;

    /**
     * @var
     */
    private $amount;

    /**
     * @var \Illuminate\Config\Repository|int|mixed
     */
    private $secret_key;

    /**
     * PortManat constructor.
     */
    public function __construct()
    {
        ## Kullanıcının IP adresi
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        $this->service_id = config('services.portmanat.service_id');
        $this->secret_key = config('services.portmanat.key');
        $this->client_ip = env('APP_ENV') == 'local' ? '82.102.16.142' : $ip;
    }

    /**
     * Generate payment form
     *
     * @param \App\Models\Package $package
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     */
    public function generateForm(Package $package)
    {
        if (! $package || ! isset($package->id)) {
            return null;
        }

        if ($package && $package->status != 2) {
            return null;
        }

        if ($package && $package->paid) {
            return null;
        }

        $action_adr = $this->mainUrl;

        $this->client_rrn = $package->id . "_p_" . uniqid();
        $this->amount = env('APP_ENV') == 'local' ? 0.2 : $package->delivery_manat_price;

        $this->hash = hash_hmac('sha256', $this->service_id . $this->client_rrn . $this->amount, $this->secret_key);

        $args = [
            'service_id' => $this->service_id,
            'client_rrn' => $this->client_rrn,
            'amount'     => $this->amount,
            'client_ip'  => $this->client_ip,
            'hash'       => $this->hash,
        ];

        $args_array = [];
        foreach ($args as $key => $value) {
            $args_array[] = '<input type="hidden" name="' . trim($key) . '" value="' . trim($value) . '" />';
        }

        return view('front.widgets.portmanat', compact('action_adr', 'args_array', 'args'));
    }

    /**
     * Payment form for courier
     *
     * @param \App\Models\Delivery $delivery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     */
    public function generateFormForCourier(Delivery $delivery)
    {
        if (! $delivery || ! isset($delivery->id)) {
            return null;
        }

        if ($delivery && $delivery->paid) {
            return null;
        }
        if ($delivery && $delivery->status != 0) {
            return null;
        }

        $action_adr = $this->mainUrl;

        $this->client_rrn = $delivery->id . "_c_" . uniqid();
        $this->amount = env('APP_ENV') == 'local' ? 0.2 : $delivery->total_price;

        $this->hash = hash_hmac('sha256', $this->service_id . $this->client_rrn . $this->amount, $this->secret_key);

        $args = [
            'service_id' => $this->service_id,
            'client_rrn' => $this->client_rrn,
            'amount'     => $this->amount,
            'client_ip'  => $this->client_ip,
            'hash'       => $this->hash,
        ];

        $args_array = [];
        foreach ($args as $key => $value) {
            $args_array[] = '<input type="hidden" name="' . trim($key) . '" value="' . trim($value) . '" />';
        }

        return view('front.widgets.portmanat', compact('action_adr', 'args_array', 'args'));
    }
}
