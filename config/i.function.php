<?php
function sweetalert($message,$type,$redirect = false){

	if ($redirect !== false) {
		return $_SESSION['execute'] = "
		<script> 
			sweetAlert('Message !', '".$message."', '".$type."').then(function() {window.location = './".$redirect."'; });
		</script>";
	}else {
		return $_SESSION['execute'] = '
		<script> 
			sweetAlert("Message !", "'.$message.'", "'.$type.'");
		</script>';
	}

}

function spin($pass){
	$mytext = $pass;
	while(inStr("}",$mytext)){
		$rbracket = strpos($mytext,"}",0);
		$tString = substr($mytext,0,$rbracket);
		$tStringToken = explode("{",$tString);
		$tStringCount = count($tStringToken) - 1;
		$tString = $tStringToken[$tStringCount];
		$tStringToken = explode("|",$tString);
		$tStringCount = count($tStringToken) - 1;
		$i = rand(0,$tStringCount);
		$replace = $tStringToken[$i];
		$tString = "{".$tString."}";
		$mytext = str_replaceFirst($tString,$replace,$mytext);
	}
	return $mytext;
}
function str_replaceFirst($s,$r,$str){
	$l = strlen($str);
	$a = strpos($str,$s);
	$b = $a + strlen($s);
	$temp = substr($str,0,$a) . $r . substr($str,$b,($l-$b));
	return $temp;
}
function inStr($needle, $haystack){
	return @strpos($haystack, $needle) !== false;
}

function file_get_contents_curl($url, $post=null, $req=null) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	if ($req != null) {
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $req);
	}
	if($post != null) {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function truncate($string, $limit) {
	if(strlen($string) > $limit) 
	{
		return substr($string, 0, $limit) . "..."; 
	}
	else 
	{
		return $string;
	}
}

function get_redirect_target($url)
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_NOBODY, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Instagram 12.0.0.7.91 Android (18/4.3; 320dpi; 720x1280; Xiaomi; HM 1SW; armani; qcom; en_US)');
	$headers = curl_exec($ch);
	curl_close($ch);
	if (preg_match('/^Location: (.+)$/im', $headers, $matches))
		return trim($matches[1]);
	return $url;
}

function get_redirect_final_target($url)
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow redirects
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // set referer on redirect
    curl_exec($ch);
    $target = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    if ($target)
    	return $target;
    return false;
}

function dateid ($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
	if (trim ($timestamp) == '')
	{
		$timestamp = time ();
	}
	elseif (!ctype_digit ($timestamp))
	{
		$timestamp = strtotime ($timestamp);
	}
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
	$date_format = preg_replace ("/S/", "", $date_format);
	$pattern = array (
		'/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
		'/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
		'/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
		'/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
		'/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
		'/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
		'/April/','/June/','/July/','/August/','/September/','/October/',
		'/November/','/December/',
		);
	$replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
		'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
		'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
		'Januari','Februari','Maret','April','Juni','Juli','Agustus','September',
		'Oktober','November','Desember',
		);
	$date = date ($date_format, $timestamp);
	$date = preg_replace ($pattern, $replace, $date);
	$date = "{$date} {$suffix}";
	return $date;
} 

// https://stackoverflow.com/questions/6225351/how-to-minify-php-page-html-output/6225382
function sanitize_output($buffer) {

    $search = array(
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        '/<!--(.|\s)*?-->/' // Remove HTML comments
    );

    $replace = array(
        '>',
        '<',
        '\\1',
        ''
    );

    $buffer = preg_replace($search, $replace, $buffer);

    return $buffer;
}


// https://stackoverflow.com/questions/2820723/how-to-get-base-url-with-php
function home_base_url(){   
	$base_url = (isset($_SERVER['HTTPS']) &&
		$_SERVER['HTTPS']!='off') ? 'https://' : 'http://';
	$tmpURL = dirname(__FILE__);
	$tmpURL = str_replace(chr(92),'/',$tmpURL);
	$tmpURL = str_replace($_SERVER['DOCUMENT_ROOT'],'',$tmpURL);
	$tmpURL = ltrim($tmpURL,'/');
	$tmpURL = rtrim($tmpURL, '/');
	if (strpos($tmpURL,'/')){
		$tmpURL = explode('/',$tmpURL);
		$tmpURL = $tmpURL[0];
	}
	if ($tmpURL !== $_SERVER['HTTP_HOST'])
		$base_url .= $_SERVER['HTTP_HOST'].'/'.$tmpURL.'/';
	else
		$base_url .= $tmpURL.'/';
	return $base_url; 
}
?>