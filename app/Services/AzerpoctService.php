<?php

namespace App\Services;

use App\Models\Package;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

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

    protected string $baseUrl = 'https://api.azpost.co';

    public object $response;

    public function __construct($package)
    {
        $this->vendor_id = config('services.azerpost.vendor_id');
        $this->api_key = config('services.azerpost.api_key');

        $this->package = $package;

        $this->client = new Client([
            'headers' => [
                'x-api-key' => $this->api_key,
                'Content-Type' => 'application/json'
            ],
            'base_uri'  => $this->baseUrl,
        ]);

        return $this;
    }

    public function create()
    {
        try {
            $this->response = $this->client->post('order/create',  [
                'json' => [
                    "vendor_id"          => $this->vendor_id,
                    "package_id"         => $this->package->getAttribute('custom_id'),
                    "delivery_post_code" => "AZ".$this->package->getAttribute('zip_code'),
                    "package_weight"     => $this->package->getAttribute('weight'),
                    "customer_address"   => $this->package->user->getAttribute('address'),
                    "first_name"         => $this->package->user->getAttribute('name'),
                    "last_name"          => $this->package->user->getAttribute('surname'),
                    "email"              => $this->package->user->getAttribute('email'),
                    "phone_no"           => $this->package->user->getAttribute('phone'),
                    "user_passport"      => $this->package->user->getAttribute('passport'),
                    "delivery_type"      => 0,
                    "vendor_payment"     => $this->package->getAttribute('delivery_manat_price')
                ]
            ]);
        } catch (RequestException $exception) {
            $this->response = $exception->getResponse();
        }

        return $this->response;
    }

    public function vp_status()
    {
        try {
            $this->response = $this->client->post('order/vp-status', [
                'json' => [
                    "vendor_id"             => $this->vendor_id,
                    "package_id"            => $this->package->getAttribute('custom_id'),
                    "vendor_payment_status" => boolval($this->package->getAttribute('paid'))
                ]
            ]);
        } catch (RequestException $exception) {
            $this->response = $exception->getResponse();
        }

        return $this->response;
    }

    public function view()
    {
        try {
            $this->response = $this->client->post('order/view', [
                'json' => [
                    "vendor_id" => $this->vendor_id,
                    "package_id" => $this->package->getAttribute('custom_id')
                ]
            ]);
        } catch (RequestException $exception) {
            $this->response = $exception->getResponse();
        }

        return $this->response;
    }

    public function delete()
    {
        try {
            $this->response = $this->client->post(  'order/delete', [
                'json' => [
                    "vendor_id" => $this->vendor_id,
                    "package_id" => $this->package->getAttribute('custom_id')
                ]
            ]);
        } catch (RequestException $exception) {
            $this->response = $exception->getResponse();
        }

        return $this->response;
    }

}