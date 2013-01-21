<?php

function loadClass($class)
{
	include 'inc/' . strtolower($class) . '.class.php';
}

spl_autoload_register('loadClass');

include_once 'settings.php';

// Initialize translator
$translator = new Translator(isset($_REQUEST['lang']) ? $_REQUEST['lang'] : null);

// Initialize database
$database = new Database(MySQL_server, MySQL_username, MySQL_password, MySQL_database, MySQL_port);
$database->connect();

$warns = $database->getEntries(MySQL_prefix . 'warns', array('deleted = 0'), array('date DESC'));
?><!DOCTYPE HTML>
<html lang="<?php echo $translator->getLanguage(); ?>">
	<head>
		<title><?php echo $translator->trans('title'); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php echo $translator->trans('description'); ?>" />
		<meta name="keywords" content="<?php echo $translator->trans('keywords'); ?>" />
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.css" rel="stylesheet">
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/main.js" type="text/javascript"></script>
	</head>
	<body>

		<div id="wrap">
			<div class="container">
				<div class="page-header">
					<h1><?php echo $translator->trans('warnings'); ?></h1>
					<div class="languageMenu">
						<a href="?lang=de"><img src="img/flags/de.png" /></a>
						<a href="?lang=en"><img src="img/flags/gb.png" /></a>
					</div>
				</div>
				<?php echo $translator->trans('search'); ?>: <input type="text" value="" class="warnSearch" />
				<table id="warns" class="table table-hover">
					<thead>
						<tr>
							<th><?php echo $translator->trans('username'); ?></th>
							<th><?php echo $translator->trans('warner'); ?></th>
							<th><?php echo $translator->trans('reason'); ?></th>
							<th><?php echo $translator->trans('date'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($warns as $warn)
						{
							?>
							<tr class="warn">
								<td class="warn_username"><?php echo htmlentities($warn['username']); ?></td>
								<td class="warn_username_warner"><?php echo htmlentities($warn['username_warner']); ?></td>
								<td class="warn_reason"><?php echo htmlentities($warn['reason']); ?></td>
								<td class="warn_date"><?php echo date($translator->trans('dateformat'), $warn['date']); ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>

			<div id="push"></div>
		</div>

		<div id="footer">
			<div class="container">
				<p class="muted credit">Panel <?php echo $translator->trans('by'); ?> <a href="mailto:bubelbub@gmail.com">Bubelbub</a> <?php echo $translator->trans('and'); ?> <a href="http://forums.bukkit.org/members/raldo94.11403/">Raldo94</a>. - 
					<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.de"><img alt="Creative Commons Lizenzvertrag" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/80x15.png" /></a></p>
			</div>
		</div>
	</body>
</html>