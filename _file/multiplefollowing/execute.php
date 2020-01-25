<?php  
require_once "../../config/liveprocess.php";
require_once "../../config/function.php";
require_once "../../config/session.php";

$cookies = @$_SESSION['cookies'];
$csrftoken = @$_SESSION['csrftoken'];
$access_type = @$_SESSION['access_type'];
$useragent = @$_SESSION['useragent'];
$target = @$_POST['target'];
$target_count = count($target);
$count_kali = 100 / $target_count;
$delay = 5;

if ($target == 0) {
	$response = array('message' => 'error', 'progress' => 100, 'code' => 'Silahkan Pilih Data Untuk Di proses !');
	echo json_encode($response);
	exit;
}

$success = 0;
$error = 0;
$nomor = 0;
foreach ($target as $key => $userid) {	

	// $followyoucheck = instagram(1, $useragent, 'friendships/show/' . $userid, $cookies);
	// $result = json_decode($followyoucheck[1]);
	// if (@$result->followed_by == true AND @$result->following == false) {

		$headers = array();
		$headers[] = "Origin: https://www.instagram.com";
		$headers[] = "Accept-Encoding: gzip, deflate, br";
		$headers[] = "Accept-Language: en-US,en;q=0.9";
		$headers[] = "X-Requested-With: XMLHttpRequest";
		$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.75 Safari/537.36";
		$headers[] = "Cookie: ".$cookies;
		$headers[] = "X-Csrftoken: ".$csrftoken;
		$headers[] = "X-Instagram-Ajax: 5bb0f8253ce1";
		$headers[] = "Content-Type: application/x-www-form-urlencoded";
		$headers[] = "Accept: */*";
		$headers[] = "Authority: www.instagram.com";
		$headers[] = "Content-Length: 0";

		$follow = instagram(0, 0, "https://www.instagram.com/web/friendships/{$userid}/follow/", 0, 1, $headers);

		$result = json_decode($follow[1]);

		if ($result->status == 'ok') {
			$success = $success + 1;
		}else {
			$error = $error + 1;
		}


	// }

	sleep($delay);
	$processed = ceil($count_kali * $nomor);
	$response = array('message' => $processed . '% complete. execute user id : ' . $userid, 'progress' => $processed);
	echo json_encode($response);	
	flush();

	if ($target_count === 1) {
		sleep(1);
	}

	$nomor++;
	
}

sleep(1);
$response = array('message' => 'Complete', 'progress' => 100, 'success' => $success, 'error' => $error);
echo json_encode($response);
?>