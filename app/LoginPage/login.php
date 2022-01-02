<?php




if (isset($_POST["submit"])) {
	if ((isset($_POST['usr'], $_POST['pss'])) && (shell_exec("awk -F':' '{ print $1}' /etc/passwd | grep " . $_POST['usr']) != "") && ((shell_exec("awk -F':' '{ print $1}' /etc/passwd | grep " . $_POST['usr'])) == (shell_exec("sshpass -p " . $_POST['pss'] . " ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no " . $_POST["usr"] . "@localhost whoami")))) {
		$pass = $_POST["pss"];
		$user = $_POST["usr"];
        putenv("USER=".$user);
        putenv("PASS=".$pass);


	} else {
		header('Location: ../LoginPage/loginh.php');
	}
}
