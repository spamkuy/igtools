<?php  
include "../config/mysql.php";
if ($mysql) {
	$sql = $mysql->query("
		CREATE TABLE IF NOT EXISTS `tb_bot_like` (
		`userid` varchar(255) NOT NULL,
		`status` text NOT NULL,
		`lastrun` text NOT NULL,
		PRIMARY KEY (`userid`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");

	$sql.= $mysql->query("
		CREATE TABLE IF NOT EXISTS `tb_laporan` (
		`userid` text NOT NULL,
		`tanggal` text NOT NULL,
		`type` text NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");

	$sql.= $mysql->query("
		CREATE TABLE IF NOT EXISTS `tb_user` (
		`userid` varchar(255) NOT NULL,
		`username` text NOT NULL,
		`cookies` text NOT NULL,
		`csrftoken` text NOT NULL,
		`device_id` text NOT NULL,
		`useragent` text NOT NULL,
		`access_type` text NOT NULL,
		`status` text NOT NULL,
		PRIMARY KEY (`userid`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");

	if ($sql) {
		header("location: ../index.php");
	}else {
		echo "Tidak Dapat Membuat Table";
	}
}
?>