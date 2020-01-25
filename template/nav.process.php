<?php  
if (empty($_SESSION['masuk']) AND @$_GET['module']) {
	if ($_GET['module'] == 'masuk') {
		include "module/masuk/index.php";
	}elseif ($_GET['module'] == 'tentangaplikasi') {
		include "module/tentangaplikasi/index.php";
	}elseif ($_GET['module'] == 'changelog') {
		include "module/changelog/index.php";
	}
	else {
		$_SESSION['execute'] = "<script> sweetAlert('Ehmm!', 'By Passed Detected!', 'error').then(function() {window.location = './?module=masuk'; }); </script>";
	}
}else {
	switch (@$_GET['module']) {

		case 'multiplefollowing':
		include "module/multiplefollowing/index.php";
		break;

		case 'multipleunfollow':
		include "module/multipleunfollow/index.php";
		break;

		case 'multipleuploadphoto':
		include "module/multipleuploadphoto/index.php";
		break;

		case 'multipledeletepost':
		include "module/multipledeletepost/index.php";
		break;

		case 'botlike':
		include "module/botlike/index.php";
		break;

		case 'laporan':
		include "module/laporan/index.php";
		break;

		case 'changelog':
		include "module/changelog/index.php";
		break;

		case 'tentangaplikasi':
		include "module/tentangaplikasi/index.php";
		break;

		case 'masuk':
		include "module/masuk/index.php";
		break;

		case 'userinfo':
		include "module/userinfo/index.php";
		break;

		default:
		include "module/dashboard/index.php";
		break;

	}
}
?>