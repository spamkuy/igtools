<?php  
require_once "../../config/liveprocess.php";
require_once "../../config/function.php";
require_once "../../config/session.php";

$cookies = @$_SESSION['cookies'];
$csrftoken = @$_SESSION['csrftoken'];
$access_type = @$_SESSION['access_type'];
$target = @$_POST['target'];
$target_count = count($target);
$count_kali = 100 / $target_count;

if ($target == 0) {
	$response = array('message' => 'error', 'progress' => 100, 'code' => 'Silahkan Pilih Data Untuk Di proses !');
	echo json_encode($response);
	exit;
}

$success = 0;
$error = 0;
$nomor = 0;

foreach ($target as $key => $userid) {	

	$unfollow = instagram(1, $_SESSION['useragent'], 'friendships/destroy/' . $userid . "/", $cookies, generateSignature('{"user_id":"' . $userid . '"}'));		
	//$unfollow = instagram(0, 0, "https://www.instagram.com/web/friendships/{$userid}/unfollow/", 0, 1, get_headers_token($cookies,$csrftoken));

	$result = json_decode($unfollow[1]);

	if ($result->status == 'ok') {
		$success = $success + 1;
	}else {
		$error = $error + 1;
	}

	sleep(60);
	$processed = ceil($count_kali * $nomor);
	$response = array('message' => $processed . '% complete. execute user id : ' . $userid, 'progress' => $processed);
	echo json_encode($response);	

	if ($count_kali === 1) {
		sleep(1);
	}

	$nomor++;

}

sleep(1);
$response = array('message' => 'Complete', 'progress' => 100, 'success' => $success, 'error' => $error);
echo json_encode($response);
?>