<?php
	require_once 'core/global.php';
	
	$path = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME);
	
	if (isset($_POST['user'], $_POST['pass']) && $sbnc->login($_POST['user'], $_POST['pass'])) {
		$_SESSION['user'] = $sbnc_user;
		$_SESSION['pass'] = $sbnc_pass;
		
		$lang = $sbnc->Call("getlang");
		if (file_exists('lang/'.$lang.'.php')) {
			$_SESSION['language'] = $lang;
		} else {
			$_SESSION['language'] = 'en';
		}
		
		unset($sbnc);
		
		header('Location: http://'.$_SERVER['HTTP_HOST'].$path.'/user.php', true, 307);
	} else {
		header('Location: http://'.$_SERVER['HTTP_HOST'].$path.'/', true, 307);
	}
?>