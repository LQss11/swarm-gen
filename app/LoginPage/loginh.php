<html>

<head>
	<link rel="stylesheet" href="./loginc.css">
	<title>Sign in</title>
</head>

<body>
	<header id="header">
		<div class="inner">
			<a href="#" class="logo">CLINISYS</a>
		</div>
	</header>
	<div class="main">
		<p class="sign" align="center">Sign in</p>
		<form name="submitForm" action="../HomePage/indexloc.php" class="form1" method="post">
			<p class="quote" align="center">Login through a local user to initialize a <b>Swarm</b> deploy <b>Services</b> or manage <b>Docker Environment</b></p>
			<input class="un " type="text" align="center" placeholder="Username" name="usr" required>
			<input class="pass" type="password" align="center" placeholder="Password" name="pss" required>
			<input type="submit" name="submit" class="submit" value="Sign in" />
		</form>
	</div>
</body>

</html>


<?php
	include("login.php");
?>