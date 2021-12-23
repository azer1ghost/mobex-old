<?php
if (! function_exists('findAndReplace')) {
    function findAndReplace($string, $query)
    {
        return str_ireplace($query, "<span class='replace-it'>" . $query . "</span>", $string);
    }
}

if (! function_exists('errorText')) {
    function errorText($string)
    {
        return "<span class='error-text'>" . $string . "</span>";
    }
}

if (! function_exists('labelText')) {
    function labelText($string, $type)
    {
        return "<span class='label label-" . $type . "'>" . $string . "</span>";
    }
}

if (! function_exists('clearKey')) {
    function clearKey($key)
    {
        return ucfirst(str_replace("_", " ", $key));
    }
}

if (! function_exists('parseRelation')) {
    function parseRelation($item, $key)
    {
        $parsed = explode('.', $key);
        $_obj = $item;

        foreach ($parsed as $rel) {
            if (str_contains($rel, '()')) {
                $rel = str_replace('()', '', $rel);
                if ($_obj) {
                    $_obj = $_obj->{$rel}();
                }
            } elseif (str_contains($rel, 'translateOrDefault')) {
                $translateParse = explode('_', $rel);
                if ($_obj) {
                    $lang = isset($translateParse[1]) ? $translateParse[1] : 'en' ;
                    $_obj = $_obj->translateOrDefault($lang);
                }
            } else {
                if ($_obj) {
                    $_obj = $_obj->{$rel};
                }
            }
        }

        return $_obj;
    }
}

if (! function_exists('classActiveRoute')) {
    function classActiveRoute($route, $class = "active")
    {
        return Request::routeIs($route) ? ' class="' . $class . '"' : '';
    }
}

if (! function_exists('removeHttp')) {
    function removeHttp($url)
    {
        $disallowed = [
            'http://',
            'https://',
            'http:/',
            'htpp://',
            'https:/',
            'htp://',
            'htps://',
            'htpp://',
            'htpps://',
        ];
        foreach ($disallowed as $d) {
            if (strpos($url, $d) === 0) {
                return str_replace($d, '', $url);
            }
        }

        return $url;
    }
}

if (! function_exists('getDomain')) {
    function getDomain($url)
    {
        $url = explode("(", $url)[0];
        $pieces = parse_url('http://' . removeHttp($url));
        $domain = isset($pieces['host']) ? $pieces['host'] : '';

        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return $regs['domain'];
        }

        return false;
    }
}

if (! function_exists('getOnlyDomain')) {
    function getOnlyDomain($url)
    {
        $domain = getDomain($url);
        if ($domain) {
            $domain = ucfirst(strtolower(explode(".", $domain)[0]));
        } else {
            $domain = ucfirst(strtolower($url));
        }

        return $domain;
    }
}

if (! function_exists('clarifyContent')) {
    function clarifyContent($content, $data = [])
    {
        if (is_array($data) & ! empty($data)) {
            foreach ($data as $key => $value) {
                $content = str_replace(':' . $key, $value, $content);
            }
        }

        return $content;
    }
}
if (! function_exists('specialPrice')) {
    function specialPrice($number)
    {
        return str_replace(",", ".", number_format((float) $number, 2, ',', ''));
    }
}

function sendTGMessage($message, $reply_to_message_id = false)
{
    try {
        $telegram = new \Telegram\Bot\Api(env('TELEGRAM_BOT_TOKEN'));

        $data = [
            'chat_id'                  => env('CHANNEL_ID'),
            'text'                     => $message,
            'parse_mode'               => 'HTML',
            'disable_web_page_preview' => true,
        ];

        if ($reply_to_message_id) {
            $data['reply_to_message_id'] = $reply_to_message_id;
        }

        if (! env('TELEGRAM_NOTIFICATION', false)) {
            return null;
        }

        $response = json_decode($telegram->sendMessage($data), true);
        sleep(2);

        return array_key_exists('message_id', $response) ? $response['message_id'] : null;
    } catch (Exception $exception) {
        \Bugsnag::notifyException($exception);
    }
}

function getCurrencyRateForFree($currency, $date = false, $main = 'USD')
{
    if ($currency == $main) {
        return 1;
    }

    try {
        $date = $date ?: date('Y-m-d');
        $url = 'https://valyuta.com/api/calculator/' . $main . '/' . $currency . '/' . $date;
        $content = json_decode(file_get_contents($url), true);
        if (isset($content['body'][0]['result'])) {
            return $content['body'][0]['result'];
        }

        return false;
    } catch (Exception $exception) {
        return false;
    }
}

function getCurrencyRate($currencyIndex)
{
    if ($currencyIndex == 0) {
        return 1;
    }
    $currencies = ['USD', 'AZN', 'EUR', 'TRY', 'RUB', 'GBP', 'CNY'];
    $currency = $currencies[$currencyIndex];
    $rates = [
        'USD' => 1,
        'AZN' => 1.7,
        'EUR' => 0.9070377,
        'TRY' => 6.44385,
        'RUB' => 77.9033,
        'GBP' => 0.8137425,
        'CNY' => 7.0744902,
    ];

    try {
        $rate = \Cache::remember($currency, 60 * 60, function () use (
            $currency,
            $rates
        ) {
            $rate = getCurrencyRateForFree($currency);
            if ($rate) {
                return $rate;
            }

            $url = "http://apilayer.net/api/live?access_key=" . env('APILAYER') . "&currencies=TRY,AZN,GBP,RUB,EUR,AED,USD&source=USD&format=1";
            $content = json_decode(file_get_contents($url), true);

            if (isset($content['success']) && $content['success'] && isset($content['quotes']) && isset($content['quotes']['USD' . $currency]) && $content['quotes']['USD' . $currency] != 0) {
                return round($content['quotes']['USD' . $currency], 3);
            }

            return (isset($rates[$currency]) ? $rates[$currency] : 0);
        });

        return $rate;
    } catch (Exception $exception) {
        \Cache::forget($currency);

        return (isset($rates[$currency]) ? $rates[$currency] : 1);
    }
}

if (! function_exists('getOnlyDomainWithExt')) {
    function getOnlyDomainWithExt($url)
    {
        if (! $url) {
            return "-";
        }
        if (str_contains($url, '%3A')) {
            $url = urldecode($url);
        }

        preg_match("/[a-z0-9\-]{1,63}\.[a-z\.]{2,6}$/", parse_url($url, PHP_URL_HOST), $domain);

        $domain = (isset($domain[0]) && $domain[0]) ? strtolower($domain[0]) : null;

        if ($domain == 'ty.gl') {
            $domain = 'trendyol.com';
        }

        return $domain;
    }
}

function generateCells($json = true)
{
    $cells = [];
    foreach (cellStructure() as $let => $value) {
        for ($i = 1; $i <= $value; $i++) {
            $cell = $let . $i;
            if ($json) {
                $cells[] = '{value: "' . $cell . '", text: "' . $cell . '"}';
            } else {
                $cells[$cell] = $cell;
            }
        }
    }

    return $json ? '[' . implode(",", $cells) . ']' : $cells;
}

function luminance($steps)
{
    $steps = 255 - 3 * $steps;
    $hex = 'ff0000';
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color = hexdec($color); // Convert to decimal
        $color = max(0, min(255, $color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return substr($return, 0, 9);
}

function cleanString($string)
{
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

if (! function_exists('cutWords')) {
    /**
     * Limit the number of words in a string.
     *
     * @param string $value
     * @param int $words
     * @param string $end
     * @return string
     */
    function cutWords($value, $words = 12, $end = '...')
    {
        return \Illuminate\Support\Str::words(strip_tags($value), $words, $end);
    }
}

if (! function_exists('getInstagramName')) {

    function getInstagramName($value)
    {
        $regex = '/(?:(?:http|https):\/\/)?(?:www.)?(?:instagram.com|instagr.am)\/([A-Za-z0-9-_.]+)/im';

        $instagram_username = '@no_user_name';
        if (preg_match($regex, $value, $matches)) {

            $instagram_username = isset($matches[1]) ? ("@" . $matches[1]) : $instagram_username;
        }

        return $instagram_username;
    }
}

if (! function_exists('changeRouteByLang')) {

    function changeRouteByLang($lang)
    {
        $current = URL::current();
        $replace = env('DOMAIN_NAME') . "/" . app()->getLocale();

        if (str_contains($current, $replace)) {
            $current = str_replace($replace, (env('DOMAIN_NAME') . "/" . $lang), $current);
        } else {
            $current = str_replace(env('DOMAIN_NAME'), (env('DOMAIN_NAME') . "/" . $lang), $current);
        }

        return $current;
    }
}

function getCurlPart($name, $value, $boundary)
{
    $eol = "\r\n";

    $part = '--' . $boundary . $eol;
    $part .= 'Content-Disposition: form-data; name="' . $name . '"' . $eol;
    $part .= 'Content-Length: ' . strlen($value) . $eol . $eol;
    $part .= $value . $eol;

    return $part;
}

function getCurlBody($post, $boundary)
{
    $eol = "\r\n";

    $body = getCurlPart('a', 'b', $boundary);
    foreach ($post as $key => $value) {
        $body .= getCurlPart($key, $value, $boundary);
    }
    $body .= '--' . $boundary . '--' . $eol;

    return $body;
}

function curlPostRequest($url, $post)
{
    $curl = curl_init();

    $boundary = md5(uniqid());
    curl_setopt_array($curl, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => "",
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => "POST",
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => getCurlBody($post, $boundary),
        CURLOPT_HTTPHEADER     => [
            "content-type: multipart/form-data; boundary=" . $boundary,
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return false;
    } else {
        return $response;
    }
}

function getIP()
{
    if (isset($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }

    return $ip ?: '127.0.0.1';
}

function detectCardType($card)
{
    $cardTypes = [
        'electron'     => "/^(4026|417500|4405|4508|4844|4913|4917)\d+$/i",
        'maestro'      => "/^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/i",
        'dankort'      => "/^(5019)\d+$/i",
        'interpayment' => "/^(636)\d+$/i",
        'unionpay'     => "/^(62|88)\d+$/i",
        'visa'         => "/^4[0-9]{12}(?:[0-9]{3})?$/i",
        'mastercard'   => "/^5[1-5][0-9]{14}$/i",
        'amex'         => "/^3[47][0-9]{13}$/i",
        'diners'       => "/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/i",
        'discover'     => "/^6(?:011|5[0-9]{2})[0-9]{12}$/i",
        'jcb'          => "/^(?:2131|1800|35\d{3})\d{11}$/i",
    ];
    foreach ($cardTypes as $cardType => $regEx) {
        if (preg_match($regEx, $card)) {
            return $cardType;
        }
    }

    return 'unknown';
}

function cellStructure()
{
    $cells = config('ase.warehouse.cells');
    if (auth()->guard('admin')->check() && auth()->guard('admin')->user()->filial() && auth()->guard('admin')->user()->filial()->cells) {
        $decoded = \GuzzleHttp\json_decode(auth()->guard('admin')->user()->filial()->cells, true);
        if (is_array($decoded)) {
            $cells = $decoded;
        }
    }

    return $cells;
}


function cellStructureForWarehouse()
{
    $cells = config('ase.warehouse.main_cells');
    if (auth()->guard('worker')->check() && auth()->guard('worker')->user()->warehouse && auth()->guard('worker')->user()->warehouse->main_cells) {
        $decodedCells = \GuzzleHttp\json_decode(auth()->guard('worker')->user()->warehouse->main_cells, true);
        if (is_array($decodedCells)) {
            $cells = $decodedCells;
        }

    }
    $decodedLiquidCells = config('ase.warehouse.liquid_cells');
    if (auth()->guard('worker')->check() && auth()->guard('worker')->user()->warehouse->liquid_cells) {
        $decodedLiquidCells = \GuzzleHttp\json_decode(auth()->guard('worker')->user()->warehouse->liquid_cells, true);
        if (! is_array($decodedLiquidCells)) {
            $decodedLiquidCells = config('ase.warehouse.liquid_cells');
        }

    }
    $decodedBatteryCells = config('ase.warehouse.battery_cells');
    if (auth()->guard('worker')->check() && auth()->guard('worker')->user()->warehouse->battery_cells) {
        $decodedBatteryCells = \GuzzleHttp\json_decode(auth()->guard('worker')->user()->warehouse->battery_cells, true);
        if (! is_array($decodedBatteryCells)) {
            $decodedBatteryCells = config('ase.warehouse.battery_cells');
        }

    }

    $cells = array_merge($cells, $decodedLiquidCells, $decodedBatteryCells);

    return $cells;
}

function guid()
{
    if (function_exists('com_create_guid') === true) {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

function sayiyiYaziyaCevir(
    $sayi,
    $kurusbasamak = 2,
    $parabirimi = 'TRY',
    $parakurus = 'KR',
    $diyez = "",
    $bb1 = null,
    $bb2 = null,
    $bb3 = null
) {


    $b1 = ["", "bir", "iki", "üç", "dört", "beş", "altı", "yedi", "sekiz", "dokuz"];
    $b2 = ["", "on", "yirmi", "otuz", "kırk", "elli", "altmış", "yetmiş", "seksen", "doksan"];
    $b3 = ["", "yüz", "bin", "milyon", "milyar", "trilyon", "katrilyon"];

    if ($bb1 != null) { // farklı dil kullanımı yada farklı yazım biçimi için
        $b1 = $bb1;
    }
    if ($bb2 != null) { // farklı dil kullanımı
        $b2 = $bb2;
    }
    if ($bb3 != null) { // farklı dil kullanımı
        $b3 = $bb3;
    }

    $say1 = "";
    $say2 = ""; // say1 virgül öncesi, say2 kuruş bölümü
    $sonuc = "";

    $sayi = str_replace(",", ".", $sayi); //virgül noktaya çevrilir

    $nokta = strpos($sayi, "."); // nokta indeksi

    if ($nokta > 0) { // nokta varsa (kuruş)

        $say1 = substr($sayi, 0, $nokta); // virgül öncesi
        $say2 = substr($sayi, $nokta, strlen($sayi)); // virgül sonrası, kuruş

    } else {
        $say1 = $sayi; // kuruş yoksa
    }

    $son = null;
    $w = 1; // işlenen basamak
    $sonaekle = 0; // binler on binler yüzbinler vs. için sona bin (milyon,trilyon...) eklenecek mi?
    $kac = strlen($say1); // kaç rakam var?
    $sonint = null; // işlenen basamağın rakamsal değeri
    $uclubasamak = 0; // hangi basamakta (birler onlar yüzler gibi)
    $artan = 0; // binler milyonlar milyarlar gibi artışları yapar
    $gecici = null;

    if ($kac > 0) { // virgül öncesinde rakam var mı?

        for ($i = 0; $i < $kac; $i++) {

            $son = $say1[$kac - 1 - $i]; // son karakterden başlayarak çözümleme yapılır.
            $sonint = $son; // işlenen rakam Integer.parseInt(

            if ($w == 1) { // birinci basamak bulunuyor

                $sonuc = $b1[$sonint] . $sonuc;
            } else {
                if ($w == 2) { // ikinci basamak

                    $sonuc = $b2[$sonint] . $sonuc;
                } else {
                    if ($w == 3) { // 3. basamak

                        if ($sonint == 1) {
                            $sonuc = $b3[1] . $sonuc;
                        } else {
                            if ($sonint > 1) {
                                $sonuc = $b1[$sonint] . $b3[1] . $sonuc;
                            }
                        }
                        $uclubasamak++;
                    }
                }
            }

            if ($w > 3) { // 3. basamaktan sonraki işlemler

                if ($uclubasamak == 1) {

                    if ($sonint > 0) {
                        $sonuc = $b1[$sonint] . $b3[2 + $artan] . $sonuc;
                        if ($artan == 0) { // birbin yazmasını engelle
                            $sonuc = str_replace($b1[1] . $b3[2], $b3[2], $sonuc);
                        }
                        $sonaekle = 1; // sona bin eklendi
                    } else {
                        $sonaekle = 0;
                    }
                    $uclubasamak++;
                } else {
                    if ($uclubasamak == 2) {

                        if ($sonint > 0) {
                            if ($sonaekle > 0) {
                                $sonuc = $b2[$sonint] . $sonuc;
                                $sonaekle++;
                            } else {
                                $sonuc = $b2[$sonint] . $b3[2 + $artan] . $sonuc;
                                $sonaekle++;
                            }
                        }
                        $uclubasamak++;
                    } else {
                        if ($uclubasamak == 3) {

                            if ($sonint > 0) {
                                if ($sonint == 1) {
                                    $gecici = $b3[1];
                                } else {
                                    $gecici = $b1[$sonint] . $b3[1];
                                }
                                if ($sonaekle == 0) {
                                    $gecici = $gecici . $b3[2 + $artan];
                                }
                                $sonuc = $gecici . $sonuc;
                            }
                            $uclubasamak = 1;
                            $artan++;
                        }
                    }
                }
            }

            $w++; // işlenen basamak

        }
    } // if(kac>0)

    if ($sonuc == "") { // virgül öncesi sayı yoksa para birimi yazma
        $parabirimi = "";
    }

    $say2 = str_replace(".", "", $say2);
    $kurus = "";

    if ($say2 != "") { // kuruş hanesi varsa

        if ($kurusbasamak > 3) { // 3 basamakla sınırlı
            $kurusbasamak = 3;
        }
        $kacc = strlen($say2);
        if ($kacc == 1) { // 2 en az
            $say2 = $say2 . "0"; // kuruşta tek basamak varsa sona sıfır ekler.
            $kurusbasamak = 2;
        }
        if (strlen($say2) > $kurusbasamak) { // belirlenen basamak kadar rakam yazılır
            $say2 = substr($say2, 0, $kurusbasamak);
        }

        $kac = strlen($say2); // kaç rakam var?
        $w = 1;

        for ($i = 0; $i < $kac; $i++) { // kuruş hesabı

            $son = $say2[$kac - 1 - $i]; // son karakterden başlayarak çözümleme yapılır.
            $sonint = $son; // işlenen rakam Integer.parseInt(

            if ($w == 1) { // birinci basamak

                if ($kurusbasamak > 0) {
                    $kurus = $b1[$sonint] . $kurus;
                }
            } else {
                if ($w == 2) { // ikinci basamak
                    if ($kurusbasamak > 1) {
                        $kurus = $b2[$sonint] . $kurus;
                    }
                } else {
                    if ($w == 3) { // 3. basamak
                        if ($kurusbasamak > 2) {
                            if ($sonint == 1) { // 'biryüz' ü engeller
                                $kurus = $b3[1] . $kurus;
                            } else {
                                if ($sonint > 1) {
                                    $kurus = $b1[$sonint] . $b3[1] . $kurus;
                                }
                            }
                        }
                    }
                }
            }
            $w++;
        }
        if ($kurus == "") { // virgül öncesi sayı yoksa para birimi yazma
            $parakurus = "";
        } else {
            $kurus = $kurus . " ";
        }
        $kurus = $kurus . $parakurus; // kuruş hanesine 'kuruş' kelimesi ekler
    }

    $sonuc = ucwords($sonuc . " " . $parabirimi . " " . $kurus);

    return $sonuc;
}

function trNumber($num)
{
    return str_replace(".", ",", number_format($num, 2));
}

function randomProduct()
{
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = []; //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < rand(8, 11); $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }

    return implode($pass); //turn the array into a string
}

if (! function_exists('diffInDays')) {
    function diffInDays($date, $from = null, $format = 'Y-m-d H:i:s')
    {
        if ($date) {
            $end = $from ? \Carbon\Carbon::createFromFormat($format, $from) : \Carbon\Carbon::now();
            $days = $end->diffInDays(\Carbon\Carbon::createFromFormat($format, $date));

            return $days;
        }
    }
}

function getBrowser($user_agent = null)
{
    $user_agent = $user_agent ?: $_SERVER['HTTP_USER_AGENT'];

    $browser = "Unknown Browser";

    $browser_array = [
        '/msie/i'      => 'Internet Explorer',
        '/firefox/i'   => 'Firefox',
        '/safari/i'    => 'Safari',
        '/chrome/i'    => 'Chrome',
        '/edge/i'      => 'Edge',
        '/opera/i'     => 'Opera',
        '/netscape/i'  => 'Netscape',
        '/maxthon/i'   => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i'    => 'Handheld Browser',
    ];

    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    return $browser;
}

function getOS($user_agent = null)
{

    $user_agent = $user_agent ?: $_SERVER['HTTP_USER_AGENT'];

    $os_platform = "Unknown OS Platform";

    $os_array = [
        '/windows nt 10/i'      => 'Windows 10',
        '/windows nt 6.3/i'     => 'Windows 8.1',
        '/windows nt 6.2/i'     => 'Windows 8',
        '/windows nt 6.1/i'     => 'Windows 7',
        '/windows nt 6.0/i'     => 'Windows Vista',
        '/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     => 'Windows XP',
        '/windows xp/i'         => 'Windows XP',
        '/windows nt 5.0/i'     => 'Windows 2000',
        '/windows me/i'         => 'Windows ME',
        '/win98/i'              => 'Windows 98',
        '/win95/i'              => 'Windows 95',
        '/win16/i'              => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i'        => 'Mac OS 9',
        '/linux/i'              => 'Linux',
        '/ubuntu/i'             => 'Ubuntu',
        '/iphone/i'             => 'iPhone',
        '/ipod/i'               => 'iPod',
        '/ipad/i'               => 'iPad',
        '/android/i'            => 'Android',
        '/blackberry/i'         => 'BlackBerry',
        '/webos/i'              => 'Mobile',
    ];

    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }

    return $os_platform;
}
