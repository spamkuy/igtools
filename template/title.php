<?php  
// Title Declaration
switch (@$_GET['module']) {

case 'multiplepost':
	$title = "Multiple Post ". $type = !empty($_GET['type']) ? ucfirst($_GET['type']) : '';
	break;

	case 'multipledeletestatus':
	$title = "Multiple Delete Status";
	break;

	case 'bomlike':
	$title = "Bom Like";
	break;

	case 'addfriend':
	$title = "Add Friend ". $groupname = !empty($_GET['groupname']) ? "From Group ".$_GET['groupname'] : '';
	break;

	case 'multipleunfriend':
	$title = "Multiple Unfriend";
	break;

	case 'friendrequest':
	$title = "Friend Request";
	break;

	case 'joingroup':
	$q = @$_GET['q'] ? " Hasil Query ".$_GET['q'] : '';
	$title = "Join Grup". $q;
	break;

	case 'multipleleavegroup':
	$title = "Multiple Leave Group";
	break;

	case 'multipledeletepostgroup':
	$title = "Multiple Delete Post Group ". $groupname = !empty($_GET['groupname']) ? $_GET['groupname'] : '';;
	break;

	case 'multiplecomment':
	$title = "Multiple Comment";
	break;

	case 'scrapeuid':
	$title = "Scrape UID";
	break;

	case 'profileguard':
	$title = "Profile Guard";
	break;

	case 'botreaction':
	$title = "Bot Reaction";
	break;

	case 'botpostgroup':
	$title = "Bot Post Group";
	break;

	case 'laporan':
	$title = "Laporan ".$settings['title'];
	break;

	case 'tentangaplikasi':
	$title = "Tentang Aplikasi ".$settings['title'];
	break;

	case 'masuk':
	$title = "Masuk ".$settings['title'];
	break;

	case 'userinfo':
	$title = "User Info";
	break;

	default:
	$title = $settings['title'];
	break;
}
?>
<title><?= $title ?></title>   