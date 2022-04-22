<?php

namespace App\Models\Extra;

use App\Models\Extra\SMS;
use App\Models\PackageType;
use GuzzleHttp\Client;
use function simple_html_dom\dump_html_tree;

/**
 * Class Smart Customs
 *
 * @package App\Models\Extra
 */
class Custom
{
    /**
     * Default mode
     *
     * @var string
     */
    protected $mode = 'production';

    /**
     *
     * Production port
     *
     * @var string
     */
    protected $port = '7545';

    /**
     * @var string
     */
    protected $version = 'v2';

    /**
     * Test Mode
     */
    public function testMode()
    {
        $this->port = "7540";
        $this->mode = "test";
    }

    /**
     * Get Current Mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function updateDepesh($data = [])
    {
        $this->version = 'v2';

        $requestEncodedData = [];

        foreach ($data as $value) {
            $requestEncodedData[] = [
                "tracking_no" => $value['cwb'],
                "airwaybill"  => $value['airWaybill'],
            ];
        }

        $response = $this->request(null, $requestEncodedData, 'put');

        return $response;
    }

    // Send just arrived packages to your warehouse

    /**
     * send Just Arrived Packages
     *
     * @param $packages
     * @return array
     */
    public function sendJustArrivedPackages($packages)
    {

        $requestEncodedData = [];
        $packageIds = [];
        $errors = [];

        foreach ($packages as $key => $package) {

            if ($package->delivery_price && $package->weight && $package->user) {
                $goods_traffic_fr = isset($package->warehouse->country->custom_id) ? $package->warehouse->country->custom_id : 792;

                $goodsList = [];

                if ($package->categories) {

                    $categories_id = explode(',', $package->categories);

                    $categories = PackageType::whereIn('custom_id', $categories_id)->get(); // we should work on it
                    foreach ($categories as $category) {
                        $goodsList[] = [
                            'goods_id'      => $category->custom_id,
                            'name_of_goods' => $category->translateOrDefault('az')->name,
                        ];
                    }
                } else {
                    $goodsList[] = ['goods_id' => 471, 'name_of_goods' => 'Digər'];
                }

                $packageIds[] = $package->custom_id;
                $goods_traffic_to = '031';

                $requestEncodedData[] = [
                    "direction"         => "1",
                    "tracking_no"       => $package->custom_id,
                    "transp_costs"      => $package->delivery_price ?: 0,
                    "weight_goods"      => $package->weight,
                    "invoys_price"      => isset(config('ase.attributes.customs_currencies')[$package->shipping_amount_cur]) ? ($package->shipping_amount ?: 0) : ($package->shipping_converted_price ?: 0),
                    "currency_type"     => isset(config('ase.attributes.customs_currencies')[$package->shipping_amount_cur]) ? config('ase.attributes.customs_currencies')[$package->shipping_amount_cur] : '840',
                    "quantity_of_goods" => $package->number_items,
                    'document_type'     => 'PinCode',
                    "fin"               => $package->user ? $package->user->fin : '-',
                    "idxaL_NAME"        => $package->user ? str_limit($package->user->full_name, 190) : '-',
                    "idxal_adress"      => $package->user ? str_limit($package->user->address, 190) : '-',
                    "phone"             => $package->user ? SMS::clearNumber($package->user->phone, true, "") : null,
                    "ixrac_name"        => $package->website_name ? getOnlyDomain($package->website_name) : 'Trendyol',
                    "ixrac_adress"      => $package->fake_address ?: ($package->website_name ? getOnlyDomain($package->website_name) : 'Trendyol'),
                    "goods_traffic_fr"  => $goods_traffic_fr,
                    "goods_traffic_to"  => $goods_traffic_to,
                    "goodslist"         => [$goodsList][0],
                ];
            }
        }
        if (empty($requestEncodedData)) {
            return [];
        }

        $response = $this->request(null, $requestEncodedData);

        if (isset($response['code']) && $response['code'] != 200) {
            if (isset($response['exception']) && isset($response['exception']['validationError']) && is_array($response['exception']['validationError'])) {
                foreach ($response['exception']['validationError'] as $eKey => $error) {
                    if (str_contains($eKey, "].")) {
                        $index = (int) filter_var($eKey, FILTER_SANITIZE_NUMBER_INT);
                        if (isset($packageIds[$index])) {
                            $errors[] = [
                                'id'    => $packageIds[$index],
                                'error' => $error,
                            ];
                        } else {
                            $this->errorTgMessage("Depo No index : " . $index . "," . $eKey);
                        }
                    } else {
                        $errors[] = [
                            'id'    => $eKey,
                            'error' => 'Artıq əlavə edilib',
                        ];
                    }
                }
            } else {
                return [
                    'status' => 0,
                ];
            }

            return [
                'status' => 400,
                'data'   => $errors,
            ];
        }

        return [
            'status' => 200,
        ];
    }

    /**
     * Get All Packages
     *
     * @param int $days
     * @param int $from
     * @param string $trackingNumber
     * @return mixed
     */
    public function getAllPackages($days = 1, $from = 0, $trackingNumber = null)
    {
        $date = $from ? date("Y-m-d", strtotime("-" . (int) $from . " days")) : date("Y-m-d");
        $dateFrom = date("Y-m-d", strtotime("-" . (int) $days . " days"));
        $requestEncodedData = [
            "dateFrom"       => $dateFrom . "T00:01:00.423Z",
            "dateTo"         => $date . "T23:59:59.423Z",
            "trackingNumber" => $trackingNumber,
        ];

        dump($requestEncodedData);

        return $this->request('carriersposts/0/100', $requestEncodedData);
    }

    /**
     * @param $cwb
     * @return bool|mixed
     */
    public function getRegNumber($cwb)
    {
        $data = self::getDeclaredPackages(360, 0, $cwb);
        if (isset($data['code']) && $data['code'] == 200) {
            if (isset($data['data'][0])) {
                $package = $data['data'][0];

                return $package['regNumber'];
            }

            return false;
        }

        return false;
    }

    // Protection of package deletion which has been added to a parcel

    /**
     * Add to Box
     *
     * @param $requestEncodedData
     * @return mixed
     */
    public function addToBoxes($requestEncodedData)
    {
        return $this->request('addtoboxes', $requestEncodedData);
    }

    /**
     * Delete Package
     *
     * @param $id
     * @return mixed
     */
    public function deletePackage($id)
    {
        return $this->request($id, [], 'delete');
    }

    // Get Declared Packages

    /**
     *
     * Get all Declared Packages
     *
     * @param int $hours
     * @param int $from
     * @param null $trackingNumber
     * @return mixed
     */
    public function getDeclaredPackages($hours = 1, $from = 0, $trackingNumber = null)
    {
        $dateTo = str_replace(" ", "T", date("Y-m-d H:i:s", strtotime("+2 hours"))) . ".423Z";
        $dateFrom = str_replace(" ", "T", date("Y-m-d H:i:s", strtotime("-" . (int) $hours. " hours"))) . ".423Z";

        $requestEncodedData = [
           /* "dateFrom"       => $dateFrom,
            "dateTo"         => $dateTo,*/
            "trackingNumber" => $trackingNumber,
        ];

        return $this->request('declarations/0/100', $requestEncodedData);
    }

    /**
     * Get all Deleted packages
     *
     * @param $days
     * @return mixed
     */
    public function getDeletedPackages($days)
    {
        $date = date("Y-m-d");
        $dateFrom = date("Y-m-d", strtotime("-" . (int) $days . " days"));
        $requestEncodedData = [
            "dateFrom" => $dateFrom . "T00:01:00.423Z",
            "dateTo"   => $date . "T23:59:59.423Z",
        ];

        return $this->request('deleteddeclarations/0/100', $requestEncodedData);
    }

    // Packages which has Declared and Ready to fly.

    /**
     * Depesh
     *
     * @param $packages
     * @return mixed
     */
    public function depesh($packages)
    {
        $requestEncodedData = [];

        foreach ($packages as $package) {
            $awb = $package->parcel->count() && $package->parcel->first()->awb ? $package->parcel->first()->awb : ($package->custom_awb ?: null);
            $depeshNumber = $package->parcel->count() ? $package->parcel->first()->custom_id : ($package->custom_parcel_number ?: null);

            $insert = [
                "regNumber"      => $package->reg_number,
                "trackingNumber" => $package->custom_id,
                "airWaybill"     => $awb,
                "depeshNumber"   => $depeshNumber,
            ];
            if ($insert['regNumber'] && $insert['trackingNumber'] && $insert['airWaybill'] && $insert['depeshNumber']) {
                $requestEncodedData[] = $insert;
            } else {
                dump($insert);
            }
        }

        return $this->request('depesh', $requestEncodedData);
    }

    /**
     * Request
     *
     * @param null $api
     * @param array $requestEncodedData
     * @param string $method
     * @return mixed
     */
    public function request($api = null, $requestEncodedData = [], $method = 'post')
    {
        $apiUrl = 'https://ecarrier-fbusiness.customs.gov.az:' . $this->port . '/api/' . $this->version . '/carriers';

        $api = $api ? $apiUrl . "/" . $api : $apiUrl;
        dump($api);

        $client = new Client([
            'base_uri'    => $api,
            'timeout'     => 300,
            'http_errors' => false,
        ]);

        $contentType = 'json';
        if ($this->mode == 'test') {
            $contentType = "json-patch+" . $contentType;
        }

        $headerRequest = [
            "Content-Type" => "application/" . $contentType,
            "accept"       => "application/json",
            "lang"         => "az",
            "ApiKey"       => env('CUSTOM_API_KEY'),
        ];

        $data = [
            'headers' => $headerRequest,
        ];
        if ($requestEncodedData) {
            $data['body'] = \GuzzleHttp\json_encode($requestEncodedData, true);
        }
        $response = $client->{$method}('', $data);

        sleep(2);
        try {
            $body = $response->getBody();
            $result = \GuzzleHttp\json_decode($body, true);

            return $result;
        } catch (\Exception $exception) {
            \Bugsnag::notifyException($exception);
            sendTGMessage("🆘🆘🆘 Gömrüyün serverini tokdan çıxartdılar.");
        }
    }

    /**
     * @return array
     */
    public function categories()
    {
        $result_array = $this->request('goodsgroupslist', [], 'get');
        $array = [];

        foreach ($result_array["data"] as $cat) {

            $array[$cat["id"]] = [
                "id"        => $cat["id"],
                "parentId"  => $cat["parentId"],
                "az"        => $cat["goodsNameAz"],
                "ru"        => $cat["goodsNameRu"],
                "en"        => $cat["goodsNameEn"],
                "isDeleted" => 0,
            ];
        }

        return $array;
    }

    /**
     * @param $function
     */
    public static function errorTgMessage($function)
    {
        /* Send notification */
        $message = null;
        $message .= "🆘 #SmartCustom -da #Function : " . $function . ".";

        sendTGMessage($message);
    }
}
