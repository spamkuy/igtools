<?php  
/* INSTAGRAM FUNCTION */
function instagram($ighost, $useragent, $url, $cookie = 0, $data = 0, $httpheader = array(), $proxy = 0, $userpwd = 0, $is_socks5 = 0)
{
	$url = $ighost ? 'https://i.instagram.com/api/v1/' . $url : $url;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	if($proxy) curl_setopt($ch, CURLOPT_PROXY, $proxy);
	if($userpwd) curl_setopt($ch, CURLOPT_PROXYUSERPWD, $userpwd);
	if($is_socks5) curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	if($httpheader) curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	if($cookie) curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	if ($data):
		curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	endif;
	$response = curl_exec($ch);
	$httpcode = curl_getinfo($ch);
	if(!$httpcode) return false; else{
		$header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		$body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		curl_close($ch);
		return array($header, $body);
	}
}

function generateDeviceId($seed)
{
	$volatile_seed = filemtime(__DIR__);
	return 'android-'.substr(md5($seed.$volatile_seed), 16);
}

function generateSignature($data)
{
	$hash = hash_hmac('sha256', $data, 'b4946d296abf005163e72346a6d33dd083cadde638e6ad9c5eb92e381b35784a');
	return 'ig_sig_key_version=4&signed_body='.$hash.'.'.urlencode($data);
}

function generateSignature_Upload($data)
{
	$hash = hash_hmac('sha256', $data, '5ad7d6f013666cc93c88fc8af940348bd067b68f0dce3c85122a923f4f74b251');

	return 'ig_sig_key_version=4&signed_body='.$hash.'.'.urlencode($data);
}

function generate_useragent()
{
	return 'Instagram 12.0.0.7.91 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)';
}

function generate_useragent_mobile()
{
	return 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.75 Mobile Safari/537.36';
}

function get_csrftoken()
{
	$fetch = instagram(1, 0 ,'si/fetch_headers/?challenge_type=signup');
	$header = $fetch[0];
	if (!preg_match('#Set-Cookie: csrftoken=([^;]+)#', $fetch[0], $token)) {
		return json_encode(array('result' => false, 'content' => 'Missing csrftoken'));
	} else {
		return substr($token[0], 22);
	}
}
function generateUUID($type)
{
	$uuid = sprintf(
		'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff),
		mt_rand(0, 0x0fff) | 0x4000,
		mt_rand(0, 0x3fff) | 0x8000,
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff)
		);

	return $type ? $uuid : str_replace('-', '', $uuid);
}
function generateUploadId()
{
	return number_format(round(microtime(true) * 1000), 0, '', '');
}

function find_string_in_array ($arr, $string) {

	return array_filter($arr, function($value) use ($string) {
		return strpos($value, $string) !== false;
	});

}

function get_csrftoken_cookies($cookies){
	$cookies_to_arr = explode(';', $cookies);
	$result = find_string_in_array($cookies_to_arr, 'csrftoken');
	if (count($result) > 1) {
		$result = array_slice($result, 1);
	}
	$result_csrftoken = implode("", $result);
	$csrftoken = substr(trim($result_csrftoken), 10);
	return $csrftoken;
}

function get_userid_cookies($cookies){
	$cookies_to_arr = explode(';', $cookies);
	$result = find_string_in_array($cookies_to_arr, 'ds_user_id');
	if (count($result) > 1) {
		$result = array_slice($result, 1);
	}
	$result_userid = implode("", $result);
	$userid = substr(trim($result_userid), 11);
	return $userid;
}

function get_headers_token($cookies,$csrftoken)
{
	$headers = array();
	$headers[] = "Cookie: ".$cookies;
	$headers[] = "X-Csrftoken: ".$csrftoken;
	return $headers;
}

function build_data_files($boundary, $fields, $files){
	$data = '';
	$eol = "\r\n";

	$delimiter = '----WebKitFormBoundary' . $boundary;

	foreach ($fields as $name => $content) {
		$data .= "--" . $delimiter . $eol
		. 'Content-Disposition: form-data; name="' . $name . "\"".$eol.$eol
		. $content . $eol;
	}


	foreach ($files as $name => $content) {
		$data .= "--" . $delimiter . $eol
		. 'Content-Disposition: form-data; name="photo"; filename="' . $name . '"' . $eol
            //. 'Content-Type: image/png'.$eol
		. 'Content-Transfer-Encoding: binary'.$eol
		;

		$data .= $eol;
		$data .= $content . $eol;
	}
	$data .= "--" . $delimiter . "--".$eol;


	return $data;
}
?>