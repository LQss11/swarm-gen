<?php
session_start();

ob_start();
include '../LoginPage/loginh.php';
ob_end_clean();
if (isset($user, $pass)) {
	$_SESSION['user'] = $user;
	$_SESSION['pass'] = $pass;
}
?>




<html>

<head>
	<link rel="stylesheet" href="./index.css">
	<title>Home</title>
	<style>
		.buttonx {
			background-color: #4CAF50;
			/* Green */
			border: none;
			color: white;
			padding: 16px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			-webkit-transition-duration: 0.4s;
			/* Safari */
			transition-duration: 0.4s;
			cursor: pointer;
		}

		.buttonx1 {
			background-color: white;
			color: black;
			border: 2px solid #4CAF50;
		}

		.buttonx1:hover {
			background-color: #4CAF50;
			color: white;
		}
	</style>
	<style>
		h2 {
			color: black;
		}

		body {
			width: 100wh;
			height: 90vh;
			color: #fff;
			background: linear-gradient(-45deg, #00e4aa, #ff4848);
			background-size: 400% 400%;
			-webkit-animation: Gradient 15s ease infinite;
			-moz-animation: Gradient 15s ease infinite;
			animation: Gradient 15s ease infinite;
		}

		@-webkit-keyframes Gradient {
			0% {
				background-position: 0% 50%
			}

			50% {
				background-position: 100% 50%
			}

			100% {
				background-position: 0% 50%
			}
		}

		@-moz-keyframes Gradient {
			0% {
				background-position: 0% 50%
			}

			50% {
				background-position: 100% 50%
			}

			100% {
				background-position: 0% 50%
			}
		}

		@keyframes Gradient {
			0% {
				background-position: 0% 50%
			}

			50% {
				background-position: 100% 50%
			}

			100% {
				background-position: 0% 50%
			}
		}
	</style>
</head>

<body>
	<header id="header">
		<div class="inner">
			<a href="http://localhost:9999/FOLDER/HomePage/indexloc.php" class="logo">CLINISYS</a>
			<nav id="nav">
				<a href="http://localhost:9999/FOLDER/HomePage/indexloc.php">Home</a>
				<a href="http://localhost:9999/FOLDER/LoginPage/loginh.php">Other user</a>
				<a>Welcome,<?php if (!isset($_SESSION['user'])) {
								header('Location: ../LoginPage/loginh.php');
							} else {
								echo $_SESSION['user'];
							} ?></a>
			</nav>
		</div>
	</header>
	<br>
	<div class="all">
		<h1 class="ax" style="margin-top:100px;" align="center">WELCOME, you are now logged in as "<?php echo $_SESSION['user'] . "@" . shell_exec("hostname"); ?>"</h1>





		<?php

echo shell_exec("../exec.sh");


		if (shell_exec("echo " . $_SESSION['pass'] . " | sudo -S -u " . $_SESSION['user'] . " docker node ls 2>&1 | grep Worker") != "") {
			echo '
					<table>
						<tr>
							<td>
								<h3>this node exists in a swarm as a worker would you like to leave swarm?</h3>
							</td>
							<td>
								<input   type="submit" name="submitx5" class="buttonx buttonx1" id="submit"  value="Leave swarm" />
							</td>
						</tr>
					</table>';
		} else if (shell_exec("echo " . $_SESSION['pass'] . " | sudo -S -u " . $_SESSION['user'] . " docker node ls 2>&1 | grep Use") != "") {

			echo '
			<form name="noneform"  class="form1"  method="post" >
				<div align="center">
					<h2 class="y" ><p>This node doesn\'t belong to any swarm would you like to create a new swarm?</p></h2>
					<input   type="submit" class="buttonx buttonx1" name="submitx1" formaction="../AddSwarm/addswarm.php" id="submit" value="CREATE" />
				</div>
			</form>
		';
		} else if ((trim(shell_exec("echo " . $_SESSION['pass'] . " | sudo -S -u " . $_SESSION['user'] . " docker node ls | grep '*' |awk '{print $2}'")) == "*")) {
			echo '
			<form name="managerform"  class="form1"  method="post" >
				<div align="center">
					<h2 class="y" ><p>This node is a manager node would you like to manage your swarm?</p></h2>
					<input   type="submit" class="buttonx buttonx1" name="submitx3" formaction="../ManageSwarm/manageswarm.php" id="submit"  value="MANAGE SWARM" />
				</div>
			</form>
		';
		} else {
			echo '
			<form name="errorform"  class="form1"  method="post" >
				<div align="center">
					<h2 class="y" ><p>there is an error in this swarm click if you want to see error code!!!</p></h2>
					<input   type="submit" class="buttonx buttonx1" name="submitx4" id="submit"  value="DISPLAY" />
				</div>
			</form>
		';
		}
		if (isset($_POST['submitx4'])) {
			echo '<h3>ERROR CODE</h3><br>';
			echo "<h3 style=\"border-style: solid;border-color: black; background-color: black;\">";
			echo shell_exec("echo " . $_SESSION['pass'] . " | sudo -S -u " . $_SESSION['user'] . " docker node ls 2>&1");
			echo "</h3>";
			echo '
			<form name="errorform2"  class="form1"  method="post" >
			
					<table>
						<tr>
							<td>
								<h2 class="y" ><p>Would you like to leave the swarm which is not a good idea, or try to connect with another machine</p></h2>
							</td>
							<td>
								<input   type="submit" name="submitx5" class="buttonx buttonx1" id="submit"  value="Leave swarm" />
							</td>
						</tr>
					</table>
					
					
				
			</form>
		';
		}
		if (isset($_POST['submitx5'])) {
			echo shell_exec("echo " . $_SESSION['pass'] . " | sudo -S -u " . $_SESSION['user'] . " docker swarm leave -f");
			header('Location: ../HomePage/indexloc.php');
		}

		?>
	</div>
</body>

</html>