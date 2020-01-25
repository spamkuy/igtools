<?php  
require_once "../../config/liveprocess.php";
require_once "../../config/function.php";
require_once "../../config/session.php";

$caption = @$_POST['caption'];
$cookies = @$_SESSION['cookies'];
$csrftoken = @$_SESSION['csrftoken'];
$folder = '../../files/images/';

if (empty($_FILES['file']['name'])) {
	$response = array('message' => 'error', 'progress' => 100, 'code' => 'File Tidak Ditemukan');
	echo json_encode($response);
	exit;
}

// VALIDATION BRAY
foreach ($_FILES['file']['name'] as $key => $filename) {

	// Validation File
	$allowed =  array('gif','png' ,'jpg');
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	if(!in_array($ext,$allowed) ) {
		$response = array('message' => 'error', 'progress' => 100, 'code' => 'Format File Tidak Valid, Pastikan Semua File Bertipe Gambar !');
		echo json_encode($response);
		exit;		
	}

}

$success = 0;
$error = 0;
$nomor = 0;
$target_count = count($_FILES['file']['name']);
$count_kali = 100 / $target_count;
foreach ($_FILES['file']['name'] as $key => $filename) {

	$filetmp = $_FILES['file']['tmp_name'][$key];
	$generateUploadId = generateUploadId();


	$filename = $folder.$generateUploadId.".".$ext;
	$newfile = $folder.$generateUploadId.".jpg";
	if (!!$filetmp) {
		if (move_uploaded_file($filetmp, $filename)) {
			// Check Extension
			if ($ext != 'jpg') {
				imagejpeg(imagecreatefromstring(file_get_contents($filename)), $newfile);
				unlink($filename);
			}
		}
	}

	/**
	*
	* Process Post
	*
	*/

	/**
	*
	* Curl to Post Image
	*
	*/		

	$fields = array("upload_id"=>$generateUploadId, "media_type"=>"1");

	$filenames = array($newfile);;

	$files = array();
	foreach ($filenames as $f){
		$files[$f] = file_get_contents($f);
	}

	$boundary = uniqid();
	$delimiter = '----WebKitFormBoundary' . $boundary;

	$post_data = build_data_files($boundary, $fields, $files);

	$headers = array();
	$headers[] = "Cookie: ".$cookies;
	$headers[] = "X-Csrftoken: ".$csrftoken;
	$headers[] = "Content-Type: multipart/form-data; boundary=" . $delimiter;
	$headers[] = "Content-Length: " . strlen($post_data);

	$postimages = instagram(0, 0, "https://www.instagram.com/create/upload/photo/", 0, $post_data, $headers);


	/**
	*
	* Curl to Post Caption
	*
	*/

	$headers = array();
	$headers[] = "Cookie: ".$cookies;
	$headers[] = "X-Csrftoken: ".$csrftoken;
	$headers[] = "Content-Type: application/x-www-form-urlencoded";

	$postcaption = instagram(0, 0, "https://www.instagram.com/create/configure/", 0, "upload_id={$generateUploadId}&caption={$caption}&usertags=", $headers);

	$result = json_decode($postcaption[1]);

	if ($result->status == 'ok') {
		$success = $success + 1;
	}else {
		$error = $error + 1;
	}

	sleep(1);
	$processed = ceil($count_kali * $nomor);
	$response = array('message' => $processed . '% complete. execute post with id : ' . $generateUploadId, 'progress' => $processed);
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