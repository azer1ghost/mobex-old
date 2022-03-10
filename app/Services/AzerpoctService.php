<?php

namespace App\Services;

use App\Models\Package;
use GuzzleHttp\Client;

class AzerpoctService
{
    private const VENDOR_ID = '12345';

    protected Package $package;

    protected Client $client;

    protected string $baseUrl = 'https://test/'; // 'https://api.azpost.co/order/';

    public function __construct(Package $package)
    {
        $this->package = $package;

        $this->client = new Client();

        return $this;
    }

    public function create()
    {
        $response = $this->client->post( $this->baseUrl . 'create', [
            "vendor_id"          => self::VENDOR_ID,
            "package_id"         => $this->package->getAttribute('custom_id'),
            "delivery_post_code" => $this->package->user->getAttribute('zip_code'),
            "package_weight"     => $this->package->getAttribute('weight'),
            "customer_address"   => $this->package->user->getAttribute('address'),
            "first_name"         => $this->package->user->getAttribute('name'),
            "last_name"          => $this->package->user->getAttribute('surname'),
            "email"              => $this->package->user->getAttribute('email'),
            "phone_no"           => $this->package->user->getAttribute('phone'),
            "user_passport"      => $this->package->user->getAttribute('passport'),
            "delivery_type"      => 0,
            "vendor_payment"     => $this->package->getAttribute('paid')
        ])->getBody();
    }


    public function view()
    {
        $response = $this->client->post( $this->baseUrl . 'view', [
            "vendor_id" => self::VENDOR_ID,
            "package_id" => $this->package->getAttribute('custom_id'),
        ])->getBody();
    }

    public function update()
    {
        $response = $this->client->post( $this->baseUrl . 'update', [
            "vendor_id"  => self::VENDOR_ID,
            "package_id" => $this->package->getAttribute('custom_id'),
            "status"     => 0,
            "details"    => ""
        ])->getBody();

//        0 - Order Placed
//        1 - Order Accepted
//        2 - Picked Up
//        3 - In Transit
//        4 - Available for Pickup
//        5 - Delivered
//        6 - Cancelled
    }

    public function delete()
    {
        $response = $this->client->post( $this->baseUrl . 'delete', [
            "vendor_id"  => self::VENDOR_ID,
            "package_id" => $this->package->getAttribute('custom_id'),
        ])->getBody();
    }

    public function vp_status()
    {
        $response = $this->client->post( $this->baseUrl . 'vp-status', [
            "vendor_id"             => self::VENDOR_ID,
            "package_id"            => $this->package->getAttribute('custom_id'),
            "vendor_payment_status" => $this->package->getAttribute('paid')
        ])->getBody();
    }

    public function charge_status()
    {
        $response = $this->client->post( $this->baseUrl . 'vp-status', [
            "vendor_id"     => self::VENDOR_ID,
            "package_id"    => $this->package->getAttribute('custom_id'),
            "charge_status" => $this->package->getAttribute('paid')
        ])->getBody();
    }

    public static function statusEventEndpoint(\Request $request)
    {
        if ($request->get('vendor_id') == self::VENDOR_ID)
        {
            $status_id = $request->get('status_id');

            $scan_post_code = $request->get('scan_post_code');

            $packages = $request->get('packages');

            // loop packages and save their statuses
        }
    }
}