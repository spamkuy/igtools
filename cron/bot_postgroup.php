<?php  
// Include
include "../config/i.function.php";
include "../config/liveprocess.php";
include "../config/timezone.php";
include "../config/mysql.php";

// CHECK FIRST IF USER ALREADY EXIST ON DATABASE
$sql = "SELECT * FROM tb_bot_postgroup INNER JOIN tb_user ON tb_bot_postgroup.userid=tb_user.userid WHERE status='on'";
$result = $mysql->query($sql);

if ($result->num_rows > 0) {
	while ($read = $result->fetch_array()) {

		if ($read['time'] == 'setting_jam') {
			$jamsekarang = date('H');
			$tanggal = date('d-m-Y H');
			$tanggal_lastrun = date('d-m-Y H', strtotime($read['lastrun']));
			$time_setting =  explode(',', $read['time_setting']);

			// IF TIME IS TIME AND LAST RUN NOT THIS TIME
			if (in_array($jamsekarang, $time_setting) AND $tanggal != $tanggal_lastrun) {
				// LOOP GROUP
				$groupsid = json_decode($read['groupid']);
				foreach ($groupsid as $groupid) { 
					$url = "https://graph.facebook.com/{$groupid}/feed";
					$data = "message=" . spin($read['message'])
					. "&fields=permalink_url&access_token={$read[token]}";
					$curl = file_get_contents_curl($url,$data);
					$result = json_decode($curl);

					if ($result->id) {
						$status = 'Sukses';
					}else {
						$status = 'Gagal';
					}

					$lastrun = date('d-m-Y H:i:s');	

					$sql = "UPDATE tb_bot_postgroup SET lastrun='$lastrun' WHERE userid='$read[userid]'";

					if ($mysql->query($sql)) {
						// SUCCESS UPDATE
					}

					$sql = "INSERT INTO tb_laporan
					VALUES ('$read[userid]', '$lastrun', 'Bot Post Group')";

					if ($mysql->query($sql)) {
						// SUCCESS UPDATE
					}

				}
			}
		}elseif ($read['time'] == 'setting_hari') {
			$jamsekarang = date('H');
			$tanggal = date('d-m-Y');
			$tanggal_lastrun = date('d-m-Y', strtotime($read['lastrun']));
			// IF TIME IS TIME AND LAST RUN NOT THIS TIME
			if ($jamsekarang == $read['time_setting'] AND $tanggal != $tanggal_lastrun) {
				// LOOP GROUP
				$groupsid = json_decode($read['groupid']);
				foreach ($groupsid as $groupid) { 
					$url = "https://graph.facebook.com/{$groupid}/feed";
					$data = "message=" . spin($read['message'])
					. "&fields=permalink_url&access_token={$read[token]}";
					$curl = file_get_contents_curl($url,$data);
					$result = json_decode($curl);

					if ($result->id) {
						$status = 'Sukses';
					}else {
						$status = 'Gagal';
					}

					$lastrun = date('d-m-Y H:i:s');	

					$sql = "UPDATE tb_bot_postgroup SET lastrun='$lastrun' WHERE userid='$read[userid]'";

					if ($mysql->query($sql)) {
						// SUCCESS UPDATE
					}

					$sql = "INSERT INTO tb_laporan
					VALUES ('$read[userid]', '$lastrun', 'Bot Post Group')";

					if ($mysql->query($sql)) {
						// SUCCESS UPDATE
					}

				}
			}
		}elseif ($read['time'] == 'setting_minggu') {
			$jamsekarang = date('H');
			$harisekarang = date('l');
			$tanggal = date('d-m-Y H');
			$tanggal_lastrun = date('d-m-Y H', strtotime($read['lastrun']));
			$time_settings = explode('_', $read['time_setting']);
			$hari_setting =$time_settings[0];
			$time = $time_settings[1];
			$time_setting =  explode(',', $hari_setting);

			// IF TIME IS TIME AND LAST RUN NOT THIS TIME
			if (in_array($harisekarang, $time_setting) AND $jamsekarang == $time AND $tanggal != $tanggal_lastrun) {
				// LOOP GROUP
				$groupsid = json_decode($read['groupid']);
				foreach ($groupsid as $groupid) { 
					$url = "https://graph.facebook.com/{$groupid}/feed";
					$data = "message=" . spin($read['message'])
					. "&fields=permalink_url&access_token={$read[token]}";
					$curl = file_get_contents_curl($url,$data);
					$result = json_decode($curl);

					if ($result->id) {
						$status = 'Sukses';
					}else {
						$status = 'Gagal';
					}

					$lastrun = date('d-m-Y H:i:s');	

					$sql = "UPDATE tb_bot_postgroup SET lastrun='$lastrun' WHERE userid='$read[userid]'";

					if ($mysql->query($sql)) {
						// SUCCESS UPDATE
					}

					$sql = "INSERT INTO tb_laporan
					VALUES ('$read[userid]', '$lastrun', 'Bot Post Group')";

					if ($mysql->query($sql)) {
						// SUCCESS UPDATE
					}

				}
			}
		}
	}
}	
?>