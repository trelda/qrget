<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/connect.php";
use Zxing\QrReader;

$count = count($_FILES['files']['tmp_name']);
function header_a() {
    $head = [
        'Mozilla/5.0 (Linux; Android 4.4.4; ALCATEL ONETOUCH 7033D Build/KOT49H) AppleWebKit/533.5 (KHTML, like Gecko) Chrome/52.0.2416.300 Mobile Safari/601.6',
        'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 7_5_6; en-US) Gecko/20100101 Firefox/72.0',
        'Mozilla/5.0 (iPod; CPU iPod OS 9_7_2; like Mac OS X) AppleWebKit/535.9 (KHTML, like Gecko) Chrome/52.0.1672.384 Mobile Safari/534.9',
        'Mozilla/5.0 (compatible; MSIE 9.0; Windows; Windows NT 6.0; x64 Trident/5.0)',
        'Mozilla/5.0 (Windows; Windows NT 6.2; Win64; x64; en-US) AppleWebKit/603.3 (KHTML, like Gecko) Chrome/48.0.3479.161 Safari/600.2 Edge/9.41461',
        'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_0_2; en-US) AppleWebKit/603.46 (KHTML, like Gecko) Chrome/54.0.3891.233 Safari/537',
        'Mozilla/5.0 (Linux; U; Android 5.1.1; Nexus 5 Build/LRX22C) AppleWebKit/600.50 (KHTML, like Gecko) Chrome/51.0.2927.194 Mobile Safari/602.3',
        'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 7_2_7) AppleWebKit/534.26 (KHTML, like Gecko) Chrome/54.0.1826.343 Safari/602',
        'Mozilla/5.0 (Linux x86_64) Gecko/20130401 Firefox/68.1',
        'Mozilla/5.0 (Linux; Android 6.0.1; SAMSUNG SM-G9350I Build/MDB08L) AppleWebKit/601.41 (KHTML, like Gecko) Chrome/48.0.2398.159 Mobile Safari/536.6'
    ];
    return $head[rand(0, count($head)-1)];
}

function headers() {
    return array(
        'cache-control: max-age=0',
	    'upgrade-insecure-requests: 1',
	    'user-agent: '.header_a(),
    	'sec-fetch-user: ?1',
	    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
	    'x-compress: null',
	    'sec-fetch-site: none',
	    'sec-fetch-mode: navigate',
	    'accept-encoding: deflate, br',
	    'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
    );
}

function curl($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, headers());
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_exec($ch);
    curl_close($ch);
};

function addRecord($text) {
    global $mysqli;
    $text = str_replace("'", "", $text);
    $query = "insert into links (url) values ('".$text."')";
    try {
        $mysqli->query($query);
    } catch (Exception $e) {
        return false;
    }
    return true;
}

$result = '';

for($i = 0; $i < $count; $i++) {
    $qrcode = new QrReader($_FILES['files']['tmp_name'][$i]);
    $text = $qrcode->text();
    $response = $_FILES['files']['name'][$i];
    if ($text != '') {
        if (addRecord($text)) {
            curl($text);
            $response = $text;
        } else {
            $response = 'Присутствует в базе';
        }
    } else {
        $response = $_FILES['files']['name'][$i]. ' - Код не распознан';
    }
    $result .= ($text != '') ? "<a href=". $text . ">" . $response . "</a></br>" : $response . "</br>";
}

echo $result;