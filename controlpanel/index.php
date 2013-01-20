<?php

function loadClass($class)
{
	include 'inc/' . strtolower($class) . '.class.php';
}

spl_autoload_register('loadClass');

include_once 'settings.php';
$database = new Database(MySQL_server, MySQL_username, MySQL_password, MySQL_database, MySQL_port);
$database->connect();

$warns = $database->getEntries(MySQL_prefix . 'warns', array('deleted = 0'), array('date DESC'));
?><!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<title>DynWarn - Panel</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
		<link href="css/bootstrap-responsive.css" rel="stylesheet">
	</head>
	<body>

		<div id="wrap">
			<div class="container">
				<div class="page-header">
					<h1>Warnings</h1>
				</div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Username</th>
							<th>Warner</th>
							<th>Reason</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($warns as $warn)
						{
							?>
							<tr>
								<td><?php echo $warn['username']; ?></td>
								<td><?php echo $warn['username_warner']; ?></td>
								<td><?php echo $warn['reason']; ?></td>
								<td><?php echo date('d.m.Y H:i:s', $warn['date']); ?></td>
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
				<p class="muted credit">Panel by <a href="mailto:bubelbub@gmail.com">Bubelbub</a> and <a href="http://forums.bukkit.org/members/raldo94.11403/">Raldo94</a>. - 
					<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.de"><img alt="Creative Commons Lizenzvertrag" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/80x15.png" /></a></p>
			</div>
		</div>
	</body>
</html>