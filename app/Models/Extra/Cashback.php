<?php

namespace App\Models\Extra;

/**
 * Class Cashback
 *
 * @package App\Models\Extra
 */
class Cashback
{
    /**
     * @var string
     */
    protected static $url = 'https://bon.az/api/';

    /**
     * @return mixed
     */
    public static function balance()
    {
        return self::curlRequest('balance');
    }

    /**
     * @return mixed
     */
    public static function orders()
    {
        return self::curlRequest('conversions');
    }

    /**
     * @param $endPoint
     * @param array $params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function curlRequest($endPoint, $params = [])
    {
        $url = self::$url . $endPoint;
        $client = new \GuzzleHttp\Client();
        $params['token'] = env('CASHBACK_TOKEN', false);

        if (! $params['token']) {
            return null;
        }

        $response = $client->request('GET', $url, ['query' => $params]);

        $statusCode = $response->getStatusCode();
        $content = \GuzzleHttp\json_decode($response->getBody(), true);

        return $content;
    }
}
