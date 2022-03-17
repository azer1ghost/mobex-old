<?php

namespace App\Services;

use App\Models\Package;
use GuzzleHttp\Client;

class AzerpoctService
{
    public const STATUS_ORDER_PLACED = 0;
    public const STATUS_ORDER_ACCEPTED = 1;
    public const STATUS_PICKED_UP = 2;
    public const STATUS_IN_TRANSIT = 3;
    public const STATUS_AVAILABLE_FOR_PICKUP = 4;
    public const STATUS_DELIVERED = 5;
    public const STATUS_CANCELED = 6;


    private string $vendor_id;
    private string $api_key;

    protected Package $package;

    protected Client $client;

    protected string $baseUrl =  'https://api.azpost.co/order/';

    public function __construct(Package $package)
    {
        $this->vendor_id = config('services.azerpost.vendor_id');
        $this->api_key = config('services.azerpost.api_key');

        $this->package = $package;

        $this->client = new Client([
            'base_uri'      => $this->baseUrl,
            'Authorization' => 'Bearer ' . $this->api_key,
            'Accept'        => 'application/json',
        ]);

        return $this;
    }

    public function create()
    {
        return $this->client->post('create', [
            "vendor_id"          => $this->vendor_id,
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
            "vendor_payment"     => $this->package->getAttribute('paid'),
        ]);
    }

    public function vp_status()
    {
        return $this->client->post('vp-status', [
            "vendor_id"             => $this->vendor_id,
            "package_id"            => $this->package->getAttribute('custom_id'),
            "vendor_payment_status" => $this->package->getAttribute('paid')
        ]);
    }

//    public function view()
//    {
//        $response = $this->client->post( $this->baseUrl . 'view', [
//            "vendor_id" => self::VENDOR_ID,
//            "package_id" => $this->package->getAttribute('custom_id'),
//        ])->getBody();
//    }

//    public function delete()
//    {
//        $response = $this->client->post( $this->baseUrl . 'delete', [
//            "vendor_id"  => self::VENDOR_ID,
//            "package_id" => $this->package->getAttribute('custom_id'),
//        ])->getBody();
//    }
}