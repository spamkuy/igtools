<?php  
if (@$_POST['byaccount']) {

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$headers = array();
	$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.75 Safari/537.36";
	$headers[] = "X-Csrftoken: ".get_csrftoken();
	$login = instagram(0, 0, 'https://www.instagram.com/accounts/login/ajax/', 0, "username={$username}&password={$password}&queryParams=%7B%7D",$headers);
	$header = $login[0];

	$login = json_decode($login[1]);
	if($login->authenticated == true){
		preg_match_all('%Set-Cookie: (.*?);%',$header,$d);
		$cookies = '';
		for($o=0;$o<count($d[0]);$o++){
			$cookies.=$d[1][$o].";";
		}
		$search  = ['csrftoken="";','target="";'];
		$cookies = str_replace($search,'', $cookies);

		// GET USER ID
		$getuserinfo = instagram(1, generate_useragent(), 'users/' . $username . '/usernameinfo', $cookies);
		$result = json_decode($getuserinfo[1]);
		$userid = $result->user->pk;
		$picture = $result->user->profile_pic_url;

		$csrftoken = get_csrftoken_cookies($cookies);
		$access_type = 'upass';

		// IF SUCCESS CREATE SESSION
		$_SESSION['masuk'] = true;
		$_SESSION['access_type'] = $access_type;
		$_SESSION['userid'] = $userid;
		$_SESSION['username'] = $username;
		$_SESSION['cookies'] = $cookies;
		$_SESSION['csrftoken'] = $csrftoken;
		$_SESSION['picture'] = $picture;
		$_SESSION['useragent'] = generate_useragent();
		$_SESSION['device_id'] = generateUUID(true);

		// CHECK FIRST IF USER ALREADY EXIST ON DATABASE
		$sql = "SELECT userid FROM tb_user WHERE userid='$userid'";
		$result = $mysql->query($sql);

		// IF EXIST UPDATE DATA
		if ($result->num_rows > 0) {

			$sql = "UPDATE tb_user SET username='$username', cookies='$cookies', csrftoken='$csrftoken', access_type='$access_type', status='Aktif' WHERE userid='$userid'";
			if ($mysql->query($sql) === TRUE) {
				sweetalert('Berhasil Masuk! Selamat Datang Kembali '.$username,'success');		
				header("Location: ./");
				exit;
			}
		}else {			
			// IF NOT EXIST CREATE NEW DATA
			$sql = "INSERT INTO tb_user
			VALUES ($userid, '$username', '$cookies', '$csrftoken', '$device_id', '$useragent', '$access_type','Aktif')";
			if ($mysql->query($sql) === TRUE) {
				sweetalert('Berhasil Masuk! Selamat Datang User Baru','success');		
				header("Location: ./");
				exit;
			}
		}

	} else {
		if ($login->user == true) {
			$message = "Password Salah !";
		}else {
			$message = "Username atau Password Salah !";
		}
		sweetalert(htmlentities($message),'error');
		header("Location: ./?module=masuk");
		exit;
	}
}elseif (@$_POST['bytoken']) {
	$token_url = $_POST['token'];
	$token_url = str_replace(['view-source:','#'], '', $token_url);
	parse_str(parse_url($token_url, PHP_URL_QUERY), $output);;

	if (empty($output['access_token'])) {
		sweetalert('Token Tidak Valid !','error');
		header("Location: ./?module=masuk");
		exit;
	}else {		
		$token = $output['access_token'];
	}

	// GET FB ID
	$getfbid = file_get_contents_curl("https://graph.facebook.com/me?fields=name,picture&access_token={$token}");
	$fbid = json_decode($getfbid);
	if (@$fbid->error->message) {
		sweetalert($fbid->error->message,'error');
		header("Location: ./?module=masuk");
		exit;
	}else {		
		$fbid = $fbid->id;
	}

	$headers = array();
	$headers[] = "X-Csrftoken: ".get_csrftoken();

	$login = instagram(0, 0, 'https://www.instagram.com/accounts/login/ajax/facebook/', 0, "accessToken={$token}&fbUserId={$fbid}&queryParams=%7B%7D", $headers);
	$header = $login[0];
	$result = json_decode($login[1]);

	if ($result->status == 'fail') {
		sweetalert('Facebook ini tidak terhubung dengan instagram !','error');
		header("Location: ./?module=masuk");
		exit;
	}

	preg_match_all('%Set-Cookie: (.*?);%',$header,$d);
	$cookies = '';
	for($o=0;$o<count($d[0]);$o++){
		$cookies.=$d[1][$o].";";
	}
	$search  = ['csrftoken="";','target="";'];
	$cookies = str_replace($search,'', $cookies);

	// GET USER NAME
	$getusername = instagram(0, 0, 'https://www.instagram.com/accounts/fb_profile/', 0 , "accessToken={$token}", $headers );
	$result = json_decode($getusername[1]);
	$username = $result->igAccount->username;
	$picture = $result->igAccount->profilePictureUrl;

	// GET USER ID
	$userid = instagram(1, generate_useragent(), 'users/' . $username . '/usernameinfo', $cookies);
	$userid = json_decode($userid[1]);
	$userid = $userid->user->pk;	

	$csrftoken = get_csrftoken_cookies($cookies);
	$access_type = 'token';

	// IF SUCCESS CREATE SESSION
	$_SESSION['masuk'] = true;
	$_SESSION['access_type'] = $access_type;
	$_SESSION['userid'] = $userid;
	$_SESSION['username'] = $username;
	$_SESSION['cookies'] = $cookies;
	$_SESSION['csrftoken'] = $csrftoken;
	$_SESSION['picture'] = $picture;
	$_SESSION['useragent'] = generate_useragent();
	$_SESSION['device_id'] = generateUUID(true);

	// CHECK FIRST IF USER ALREADY EXIST ON DATABASE
	$sql = "SELECT userid FROM tb_user WHERE userid='$userid'";
	$result = $mysql->query($sql);

	// IF EXIST UPDATE DATA
	if ($result->num_rows > 0) {

		$sql = "UPDATE tb_user SET username='$username', cookies='$cookies', csrftoken='$csrftoken', access_type='$access_type', status='Aktif' WHERE userid='$userid'";
		if ($mysql->query($sql) === TRUE) {
			sweetalert('Berhasil Masuk! Selamat Datang Kembali '.$username,'success');		
			header("Location: ./");
			exit;
		}
	}else {			
		// IF NOT EXIST CREATE NEW DATA
		$sql = "INSERT INTO tb_user
		VALUES ($userid, '$username', '$cookies', '$csrftoken', '$device_id', '$useragent', '$access_type','Aktif')";
		if ($mysql->query($sql) === TRUE) {
			sweetalert('Berhasil Masuk! Selamat Datang User Baru','success');		
			header("Location: ./");
			exit;
		}
	}

}elseif (@$_POST['bycookies']) {

	$cookies = $_POST['cookies'];
	$userid = get_userid_cookies($cookies);

	if (empty($userid)) {
		sweetalert('Bukan Cookies Nih !','error');
		header("Location: ./?module=masuk");
		exit;
	}

	$getusername = instagram(0,'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.75 Safari/537.36','https://www.instagram.com/graphql/query/?query_hash=7c16654f22c819fb63d1183034a5162f&variables=%7B%22user_id%22%3A%22'.$userid.'%22%2C%22include_chaining%22%3Atrue%2C%22include_reel%22%3Atrue%2C%22include_suggested_users%22%3Afalse%2C%22include_logged_out_extras%22%3Afalse%2C%22include_highlight_reels%22%3Afalse%7D',$cookies);

	if (strpos($getusername[0], 'HTTP/1.1 302 Found') !== false) {
		sweetalert('Cookies Tidak Valid !','error');
		header("Location: ./?module=masuk");
		exit;
	}elseif (strpos($getusername[0], 'HTTP/1.1 403 Forbidden') !== false) {
		sweetalert('Cookies Tidak Aktif !','error');
		header("Location: ./?module=masuk");
		exit;
	}
	else {

		$result = json_decode($getusername[1]);

		$username = $result->data->user->reel->owner->username;
		$picture = $result->data->user->reel->owner->profile_pic_url;

		$csrftoken = get_csrftoken_cookies($cookies);
		$device_id = generateUUID(true);
		$useragent = generate_useragent();
		$access_type = 'cookies';

		// IF SUCCESS CREATE SESSION
		$_SESSION['masuk'] = true;
		$_SESSION['access_type'] = $access_type;
		$_SESSION['userid'] = $userid;
		$_SESSION['username'] = $username;
		$_SESSION['cookies'] = $cookies;
		$_SESSION['csrftoken'] = $csrftoken;
		$_SESSION['picture'] = $picture;
		$_SESSION['useragent'] = $useragent;
		$_SESSION['device_id'] = $device_id;

		// CHECK FIRST IF USER ALREADY EXIST ON DATABASE
		$sql = "SELECT userid FROM tb_user WHERE userid='$userid'";
		$result = $mysql->query($sql);

		// IF EXIST UPDATE DATA
		if ($result->num_rows > 0) {

			$sql = "UPDATE tb_user SET username='$username', cookies='$cookies', csrftoken='$csrftoken', access_type='$access_type', status='Aktif' WHERE userid='$userid'";
			if ($mysql->query($sql) === TRUE) {
				sweetalert('Berhasil Masuk! Selamat Datang Kembali '.$username,'success');		
				header("Location: ./");
				exit;
			}
		}else {			
			// IF NOT EXIST CREATE NEW DATA
			$sql = "INSERT INTO tb_user
			VALUES ($userid, '$username', '$cookies', '$csrftoken', '$device_id', '$useragent', '$access_type','Aktif')";
			if ($mysql->query($sql) === TRUE) {
				sweetalert('Berhasil Masuk! Selamat Datang User Baru','success');		
				header("Location: ./");
				exit;
			}
		}

	}
}elseif (@$_POST['bycode']) {
	$code = $_POST['code'];

	$sql = "SELECT * FROM tb_user WHERE device_id='$code'";
	$result = $mysql->query($sql);
	$read = $result->fetch_assoc();

	$getusername = instagram(0,'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.75 Safari/537.36','https://www.instagram.com/graphql/query/?query_hash=7c16654f22c819fb63d1183034a5162f&variables=%7B%22user_id%22%3A%22'.$read['userid'].'%22%2C%22include_chaining%22%3Atrue%2C%22include_reel%22%3Atrue%2C%22include_suggested_users%22%3Afalse%2C%22include_logged_out_extras%22%3Afalse%2C%22include_highlight_reels%22%3Afalse%7D',$read['cookies']);

	if (strpos($getusername[0], 'HTTP/1.1 403 Forbidden') !== false) {
		sweetalert('Cookies Sudah Tidak Aktif !,\nSilahkan masuk melalui form lainnya !','error');
		header("Location: ./?module=masuk");
		exit;
	}
	else {

		$result = json_decode($getusername[1]);

		$picture = $result->data->user->reel->owner->profile_pic_url;

		// IF PICTURE HASBEN GET CREATE SESSION
		$_SESSION['masuk'] = true;
		$_SESSION['access_type'] = $read['access_type'];
		$_SESSION['userid'] = $read['userid'];
		$_SESSION['username'] = $read['username'];
		$_SESSION['cookies'] = $read['cookies'];
		$_SESSION['csrftoken'] = $read['csrftoken'];
		$_SESSION['picture'] = $picture;
		$_SESSION['useragent'] = $read['useragent'];
		$_SESSION['device_id'] = $read['device_id'];

		sweetalert('Berhasil Masuk! Selamat Datang Kembali','success');		
		header("Location: ./");
		exit;
	}				
}
?>