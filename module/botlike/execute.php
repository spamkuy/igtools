<?php  
if (@$_POST['saveaccount']) {

	$userid = $_SESSION['userid'];
	$status = !empty($_POST['status']) ? $_POST['status'] : 'off';

	// CHECK FIRST IF USER ALREADY EXIST ON DATABASE
	$sql = "SELECT userid FROM tb_bot_like WHERE userid='$userid'";
	$result = $mysql->query($sql);


	// IF EXIST UPDATE DATA
	if ($result->num_rows > 0) {

		$sql = "UPDATE tb_bot_like SET status='$status' WHERE userid='$userid'";
		if ($mysql->query($sql) === TRUE) {
			sweetalert('Berhasil Mengupdate Reaction','success');		
			header("Location: ./?module=botlike");
			exit;
		}
	}else {			
		// IF NOT EXIST CREATE NEW DATA
		$sql = "INSERT INTO tb_bot_like
		VALUES ($userid, '$status', '')";
		if ($mysql->query($sql) === TRUE) {
			sweetalert('Berhasil Mengatur Reaction','success');		
			header("Location: ./?module=botlike");
			exit;
		}
	}	
}
?>