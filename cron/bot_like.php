<?php  
// Include
include "../config/function.php";
include "../config/liveprocess.php";
include "../config/timezone.php";
include "../config/mysql.php";


// CHECK FIRST IF USER ALREADY EXIST ON DATABASE
$sql = "SELECT * FROM tb_bot_like INNER JOIN tb_user ON tb_bot_like.userid=tb_user.userid WHERE tb_bot_like.status='on'";
$result = $mysql->query($sql);

if ($result->num_rows > 0) {

	while ($read = $result->fetch_assoc()) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/graphql/query/?query_hash=13ab8e6f3d19ee05e336ea3bd37ef12b&variables=%7B%7D");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		// Recode Result
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

		$headers = array();
		$headers[] = "Cookie: ".$read['cookies'];
		$headers[] = "Accept-Encoding: gzip, deflate, br";
		$headers[] = "Accept-Language: en-US,en;q=0.9,id;q=0.8";
		$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.75 Safari/537.36";
		$headers[] = "Accept: */*";
		$headers[] = "Referer: https://www.instagram.com/";
		$headers[] = "Authority: www.instagram.com";
		$headers[] = "X-Requested-With: XMLHttpRequest";
		$headers[] = "X-Instagram-Gis: d056ed0241eb4ef3f4c4cd67c0906ecd";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$resultfeed_o = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);

		$resultfeed = json_decode($resultfeed_o);

		//IF COOKIES EXPIRED
		if (empty($resultfeed_o)) {

			$error = 'error';
			$lastrun = date('d-m-Y H:i:s');

			$sql = "UPDATE tb_bot_like SET status='$error', lastrun='$lastrun' WHERE userid='$read[userid]'";

			if ($mysql->query($sql)) {
				// SUCCESS UPDATE
			}

		}else {

			foreach ($resultfeed->data->user->edge_web_feed_timeline->edges as $key => $media) {
				if (@$media->node->id) {
					$status = ($media->node->viewer_has_liked === false ? 'tolike' : 'nolikeagain');
					if ($status == 'tolike') {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/web/likes/{$media->node->id}/like/");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

						$headers = array();
						$headers[] = "Origin: https://www.instagram.com";
						$headers[] = "Accept-Encoding: gzip, deflate, br";
						$headers[] = "Accept-Language: en-US,en;q=0.9";
						$headers[] = "X-Requested-With: XMLHttpRequest";
						$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.75 Safari/537.36";
						$headers[] = "Cookie: ".$read['cookies']."";
						$headers[] = "X-Csrftoken: ".$read['csrftoken'];
						$headers[] = "X-Instagram-Ajax: c2d8f4380025";
						$headers[] = "Content-Type: application/x-www-form-urlencoded";
						$headers[] = "Accept: */*";
						$headers[] = "Referer: https://www.instagram.com/";
						$headers[] = "Authority: www.instagram.com";
						$headers[] = "Content-Length: 0";
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

						$resultlike = curl_exec($ch);
						if (curl_errno($ch)) {
							echo 'Error:' . curl_error($ch);
						}
						curl_close ($ch);

						$resultok = json_decode($resultlike);
						if (@$resultok->status == 'ok') {
							//echo "Sukses Like Media https://instagram.com/p/" . $media->node->shortcode . "<br/>";
						}else {
							//echo "Terjadi Kesalahan, Kode :" . $resultlike . "<br/>";
						}
					}else {
						//echo "Duplikat Like Media https://instagram.com/p/". $media->node->shortcode . "<br/>";
					}
				}
			}

			$lastrun = date('d-m-Y H:i:s');	

			$sql = "UPDATE tb_bot_like SET lastrun='$lastrun' WHERE userid='$read[userid]'";

			if ($mysql->query($sql)) {
				// SUCCESS UPDATE
			}

			$sql = "INSERT INTO tb_laporan
			VALUES ('$read[userid]', '$lastrun', 'Bot Like')";

			if ($mysql->query($sql)) {
				// SUCCESS UPDATE
			}

		}
	}

}	
?>