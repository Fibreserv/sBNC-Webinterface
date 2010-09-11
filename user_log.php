<?php
	require_once 'core/global.php';

	if (!$loggedin) {
		header('Location: '.$path, true, 307);
		exit(0);
	}

	$traffic = $sbnc->call("gettraffic");
	$nick = $sbnc->call("getvalue", array("nick"));
	$awaynick = $sbnc->call("getvalue", array("awaynick"));
	$server = $sbnc->call("getvalue", array("server"));
	$port = $sbnc->call("getvalue", array("port"));

	$breadcrumb = array($_SESSION['user'], $LANG['menu_log']);

	require_once 'templates/header.html';

	if (isset($_POST['erase'])) {
		$sbnc->call("eraselog")
?>
		<h3><?php echo $LANG['log_prompt']; ?></h3>
		<p><?php echo $LANG['log_erased']; ?></p>
<?php
	}
		
	$log = $sbnc->call("getlog", array("0", "end"));

	if (is_array($log)) {
?>
		<form action="user_log.php" method="post">
			<fieldset>
				<legend><?php echo $LANG['log_prompt']; ?></legend>
						
				<input type="submit" name="erase" value="<?php echo $LANG['log_prompt']; ?>" class="submit" />
			</fieldset>
		</form>
				
		<div class="awaylog">
<?php
		foreach ($log as $line) {
			$irc2html = new IRCtoHTML(utf8_decode($line));
?>
			<p><?php echo $irc2html->GetHTML(); ?></p>
<?php
		}
?>
		</div>
<?php
	}

	require_once 'templates/footer.html';
?>
