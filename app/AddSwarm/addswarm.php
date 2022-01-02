<?php
session_start();

$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
function check_url($url)
{
	$headers = @get_headers($url);
	$headers = (is_array($headers)) ? implode("\n ", $headers) : $headers;

	return (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers);
}

if (!(isset($_SESSION['user'], $_SESSION['pass']))) {
	header('Location: ../LoginPage/loginh.php');
}
if (!(shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " 'docker node ls 2>&1 | grep Use'") != "")) {
	header('Location: ../LoginPage/loginh.php');
}
?>


<html>

<head>
	<title>Add Swarm</title>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>


	<link rel="stylesheet" href="./addswarm.css">
</head>

<body>
	<!--div class="loading">Loading&#8230;</div-->
	<header id="header">
		<div class="inner">
			<a href="http://localhost:7777/HomePage/indexloc.php" class="logo">CLINISYS</a>
			<nav id="nav">
				<a href="http://localhost:7777/HomePage/indexloc.php">Home</a>
				<a href="http://localhost:7777/LoginPage/loginh.php">Other user</a>
				<a>Welcome,<?php echo $_SESSION['user']; ?></a>
			</nav>
		</div>
	</header>
	<?php echo "<h1>" . $user . "</h1>"; ?>
	<div class="container">
		<br />
		<br />

		<h2 align="center">CREATE NEW SWARM</h2><br />
		<div class="form-group">
			<form name="form1" method="post">
				<div class="table-responsive">
					<table class="table table-bordered" id="Leader_Table">

						<tr>
							<th>
								<center>choose an IP address to advertise </center>
							</th>
						</tr>
						<tr>
							<td>
								<center><input type="text" name="adv" required /></center>
						</tr>

					</table>
					<hr>
					<center>
						<h3>MANAGER NODES</h3>
					</center>
					<hr>
					<table class="table table-bordered">

						<center><button type="button" class="w3-btn w3-green" type="button" id="addm">Would You Like To Add A New Manager </button></center>

						<center><button type="button" class="w3-btn w3-green" type="button" id="addmdm">Would You Like To Add A New Manager docker machine</button></center>


					</table>

					<table class="table table-bordered" id="add_man">
						<tr>
							<th>SSH Username</th>
							<th>SSH IP</th>
							<th>SSH Password</th>
							<th>Docker-Machine Name</th>
							<th>Remove</th>
						</tr>
					</table>
					<hr>
					<center>
						<h3>WORKER NODES</h3>
					</center>
					<hr>
					<table class="table table-bordered">

						<center> <button type="button" class="w3-btn w3-green" name="addw" id="addw">Would You Like To Add A New Worker</button></center>

						<center> <button type="button" class="w3-btn w3-green" name="addwdm" id="addwdm">Would You Like To Add A New Worker docker machine</button></center>

					</table>

					<table class="table table-bordered" id="add_wor">
						<tr>
							<th>SSH Username</th>
							<th>SSH IP</th>
							<th>SSH Password</th>
							<th>Docker-Machine Name</th>
							<th>Remove</th>
						</tr>
					</table>
					<br>
					<hr>
					<center>
						<h3>Services</h3>
					</center>
					<hr><br>
					<?php
					if (!check_url("http://localhost:9000"))
						echo '
							<table class="table table-bordered">
							<tr>
								<th colspan="3"><center>Swarm management</center></th>
								<th>Monitoring</th>
								<th>Logging</th></th>
							<tr>
							<tr>
								<td style="color:black; padding-bottom:20px;"><input type="radio" id="Portainer" class="form-radio" name="Portainer" value="PINSTANCE" ><b>Deploy Portainer to the swarm<b></td>
								<td style="color:black; padding-bottom:20px;"><input type="radio" id="portagent" class="form-radio" name="Portainer" value="PAGENT" checked><b>Deploy Portainer as an endpoint to an existing instance<b></td>
								<td style="color:black; padding-bottom:20px;"><input type="radio" id="pnull" class="form-radio" name="Portainer" value="PNULL" ><b>Not Deploying Portainer</td>
						';
					if (!check_url("http://localhost:3000"))
						echo '		<td style="color:black; padding-bottom:20px;"><input type="checkbox" name="SwarmProm" id="swap" class="form-checkbox" value="SwarmProm" checked><b>Deploy swarmprom stack<b></td>';
					if (!check_url("http://localhost/app/kibana")) {
						echo '		<td style="color:black; padding-bottom:20px;"><input type="checkbox" name="ELK" class="form-checkbox" value="ELK" checked><b>Deploy ELK + logspout<b></tr></table></td>';
						/*if (shell_exec(" echo " . $pass . " | sudo -S -u " . $user . " docker service ls | grep elasticsearch/elasticsearch |grep 1/1")!="")
						echo "<p style=\"color:red;\"'>error</p>";*/
					}
					echo '<br>';
					if (!check_url("http://localhost:9000"))
						echo '<table><tr><td><button type="button" class="collapsible" id="port" >Portainer Parameters</button>
						<div class="content" id="pag">
							<table>
								<tr>
									<th id="pox">
										<h4>agent name</h4>
									</th>
									
									<th id="poy">
										<h4>Portainer admin</h4>
									</th>
									<th>
										<h4>Portainer pass</h4>
									</th>
									<!--th id="po1">
										<h4>Machine User</h4>
									</th-->
									<th id="po2">
										<h4>Machine IP</h4>
									</th>
									<!--th id="po3">
										<h4>Machine Password</h4>
									</th-->
									<th id="po4">
										<h4>Endpoint Name</h4>
									</th>
								</tr>
								<tr>
									<td><input type="text" name="AG" placeholder="Name of agent service"  /></td>
									<td><input type="text" id="poxx" name="PA" placeholder="Admin"  required/></td>
									<td><input type="password" id="poyy" name="PP" placeholder="Pass"  required/></td><div id="po">
									<!--td><input type="text" id="po11" name="machuser" placeholder="SSH USER"  required/></td-->
									<td><input type="text" id="po22" name="machip" placeholder="SSH IP"  required/></td>
									<!--td><input type="password" id="po33" name="machpass" placeholder="SSH PASS"  required/></td-->
									<td><input type="text" id="po44" name="EN" placeholder="Endpoint name"  required/></td>
								</tr>
							</table>
						</div></td>';

					if (!check_url("http://localhost:3000"))
						echo '<td><button type="button" class="collapsible" id="SP" >SwarmProm Parameters</button>
						<div class="content" id="SPC" style="  padding: 0 200px;">
							<table>
								<tr>
									<th><h4>Swarmprom admin</h4></th>
									<th><h4>Swarmprom pass</h4></th>
									<th><h4>Slack URL</h4></th>
									<th><h4>Slack Channel</h4></th>
									<th><h4>Slack Username</h4></th>
								</tr>
								<tr>
									<td><input type="text" name="SA" placeholder="Admin=Admin by default"  /></td>
									<td><input type="password" name="SP" placeholder="PASS=Admin by default"  /></td>
									<td><input type="text" name="SU" placeholder="Slack URL"  /></td>
									<td><input type="text" name="SC" placeholder="Slack Channel"  /></td>
									<td><input type="text" name="SM" placeholder="Slack Alertmanager username"  /></td>
								</tr>
							</table>
						</div></td></tr></table><br>';
					?>
					<center><input type="submit" name="submit" formaction="./addswarm.php" id="submit" value="Submit" /></center>
				</div>
			</form>

		</div>
	</div>
	<div class="ex2">





		<?php

		echo ">>Output <br>";
		/*---------------------------------------------------------------------------------------------LEADER----------------------------------------------------------------------------------------------------*/

		if (isset($_POST['adv'])) {
			shell_exec("../exec.sh " . $user. " " . $pass ."  \" docker swarm init --advertise-addr " . $_POST["adv"] . "\""); # create a swarm with the adv addr

			echo " Swarm Created Successfully <br>";

			$jtwork = "docker swarm join --token " . rtrim(shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] ."  'docker swarm join-token worker -q'")) . " " . $_POST["adv"] . ":2377"; #maybe add a field to modify port
			$jtman = "docker swarm join --token " . rtrim(shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] ."  'docker swarm join-token manager -q'")) . " " . $_POST["adv"] . ":2377";

			/*---------------------------------------------------------------------------------------------MANAGERS----------------------------------------------------------------------------------------------------*/


			/*--------------------------------------------------------------------------------MANAGERS---MACHINES--------------------------------------------------------------------------*/
			if (isset($_POST['mu'], $_POST['mip'], $_POST['mp'])) {
				for ($n = 0, $count = count($_POST['mu']); $n < $count; $n++) {
					$manu  = $_POST['mu'][$n];
					$manip  = $_POST['mip'][$n];
					$manp  = $_POST['mp'][$n];
					shell_exec("../ssh.sh " .  $manu . " " . $manp ."@". $manip );
					shell_exec("../ssh.sh " .  $manu . " " . $manp ."@". $manip . " \"". $jtman ."\"");
					echo ' <br> <b>node ' . $manu . ' with ip ' . $manip . ' is trying to join the swarm as manager </br><br> ';

					/*---------------------FOR---ELASTICSEARCH---vm.max_map_count--------------------*/

					if (isset($_POST['ELK'])) {
						shell_exec("../ssh.sh " .  $manu . " " . $manp ."@". $manip ." \"sysctl -w vm.max_map_count=262144\" ");
					}
				}
			}
			/*---------------------------------------------------------------------------MANAGERS---DOCKER---MACHINES--------------------------------------------------------------------*/

			if (isset($_POST['dmmu'], $_POST['dmmip'], $_POST['dmmp'], $_POST['dmm'])) {
				for ($n1 = 0, $count1 = count($_POST['dmmu']); $n1 < $count1; $n1++) {
					$dmmanu  = $_POST['dmmu'][$n1];
					$dmmanip  = $_POST['dmmip'][$n1];
					$dmmanp  = $_POST['dmmp'][$n1];
					$dockm  = $_POST['dmm'][$n1];
					
					echo shell_exec("../ssh.sh " .  $dmmanu . " " . $dmmanp ."@". $dmmanip ." \"docker-machine ssh  " . $dockm . " " . $jtman . "\" 2>&1 ");

					echo ' <br> <b>node ' . $dmmanu . ' with ip ' . $dmmanip . ' with docker machine name ' . $dockm . ' is trying to join the swarm as manager </br><br>';

					/*---------------------FOR---ELASTICSEARCH---vm.max_map_count--------------------*/

					if (isset($_POST['ELK'])) {
						shell_exec("../ssh.sh " .  $dmmanu . " " . $dmmanp ."@". $dmmanip ." \"docker-machine ssh  " . $dockm . " 'sudo  sysctl -w vm.max_map_count=262144' \" ");
					}
				}
			}
			echo "<br>";




			/*-----------------------------------------------------------------------------------------------WORKERS---------------------------------------------------------------------------------------------------*/


			/*----------------------------------------------------------------------------------WORKERS---MACHINES--------------------------------------------------------------------------*/
			if (isset($_POST['wu'], $_POST['wip'], $_POST['wp'])) {
				for ($m2 = 0, $count2 = count($_POST['wu']); $m2 < $count2; $m2++) {
					$worku  = $_POST['wu'][$m2];
					$workip  = $_POST['wip'][$m2];
					$workp  = $_POST['wp'][$m2];
					
					shell_exec("../ssh.sh " .  $worku . " " . $workp ."@". $workip ." \" " . $jtwork . "\"");

					echo ' <br> <b>node ' . $worku . ' with ip ' . $workip . ' is trying to join the swarm as worker </br><br>';

					/*---------------------FOR---ELASTICSEARCH---vm.max_map_count--------------------*/

					if (isset($_POST['ELK'])) {
						shell_exec("../ssh.sh " .  $worku . " " . $workp ."@". $workip ." \" sysctl -w vm.max_map_count=262144\"");
					}
				}
			}

			/*-----------------------------------------------------------------------------WORKERS---DOCKER---MACHINES--------------------------------------------------------------------------*/
			if (isset($_POST['dmwu'], $_POST['dmwip'], $_POST['dmwp'], $_POST['dmw'])) {
				for ($m3 = 0, $count3 = count($_POST['dmwu']); $m3 < $count3; $m3++) {
					$dmworku  = $_POST['dmwu'][$m3];
					$dmworkip  = $_POST['dmwip'][$m3];
					$dmworkp  = $_POST['dmwp'][$m3];
					$dockw  = $_POST['dmw'][$m3];
					
					shell_exec("../ssh.sh " .  $dmworku . " " . $dmworkp ."@". $dmworkip ." \" docker-machine ssh  " . $dockw . " " . $jtwork . "\" ");

					echo ' <br> <b>node ' . $dmworku . ' with ip ' . $dmworkip . ' with docker machine name ' . $dockw . ' is trying to join the swarm as worker </br><br>';

					/*---------------------FOR---ELASTICSEARCH---vm.max_map_count--------------------*/

					if (isset($_POST['ELK'])) {
						shell_exec("../ssh.sh " .  $dmworku . " " . $dmworkp ."@". $dmworkip ." \" docker-machine ssh  " . $dockw . " 'sudo sysctl -w vm.max_map_count=262144' \" ");
					}
				}
			}
		}

		/*-------------------------------------------------------------------------------------------------SERVICES------------------------------------------------------------------------------------------------*/

		/*---------------------------------------------------------------------------------------ELK---STACK---------------------------------------------------------------------*/


		if (isset($_POST['ELK'])) {
			echo 'Starting ELK Stack for LOGS <br>';
			shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " sysctl -w vm.max_map_count=262144");

			shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " 'echo \"version: '3'

services:
  elasticsearch:
    image: docker.elastic.co/elasticsearch/elasticsearch:6.5.0 
    environment:
      ES_JAVA_OPTS: '-Xms256m -Xmx256m'
      xpack.security.enabled: 'false'
      xpack.monitoring.enabled: 'false'
      xpack.graph.enabled: 'false'
      xpack.watcher.enabled: 'false'
    volumes:
      - esdata:/usr/share/elasticsearch/data
    deploy:
      replicas: 1

  logstash:
    image: docker.elastic.co/logstash/logstash:6.5.0
    volumes:
      - ./logstash.conf:/usr/share/logstash/pipeline/logstash.conf
    depends_on:
      - elasticsearch
    deploy:
      replicas: 1

  logspout:
    image: bekt/logspout-logstash
    environment:
      ROUTE_URIS: 'logstash://logstash:5000'
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock
    depends_on:
      - logstash
    deploy:
      mode: global
      restart_policy:
        condition: on-failure
        delay: 30s

  kibana:
    image: docker.elastic.co/kibana/kibana:6.5.0
    ports:
      - '80:5601'
    depends_on:
      - elasticsearch
    environment:
      ELASTICSEARCH_URL: 'http://elasticsearch:9200'
      XPACK_SECURITY_ENABLED: 'false'
      XPACK_MONITORING_ENABLED: 'false'
    deploy:
      replicas: 1

volumes:
  esdata:
    driver: local \" > logstack.yml'");

			/*-----------------*/

			shell_exec('../exec.sh ' . $_SESSION['user'] . ' ' . $_SESSION['pass'] . ' "echo \'input {
  udp {
    port  => 5000
    codec => json
  }
}

filter {
  if [docker][image] =~ /logstash/ {
    drop { }
  }
}

output {
  elasticsearch { hosts => ["elasticsearch:9200"] }
  stdout { codec => rubydebug }
}\' > logstash.conf"');

			/*-----------------*/

			$cl = "../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . "  'docker stack deploy -c logstack.yml elk' ";
			addFunction($cl);
		}

		/*-----------------------------------------------------------------------------------------PORTAINER---------------------------------------------------------------------*/


		if (isset($_POST['Portainer']) && ($_POST['Portainer'] == "PINSTANCE")) {

			if ($_POST['AG']) {
				$LID = $_POST['AG'];
			} else {
				$LID = trim(shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " 'docker node ls | grep Leader|  awk \"{print $1}\"'"));
			}

			shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " 'echo \"version: '3.2'

services:
  " . $user . "" . $LID . ":
    image: portainer/agent
    environment:
      AGENT_CLUSTER_ADDR: tasks." . $user . "" . $LID . "
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock
      - /var/lib/docker/volumes:/var/lib/docker/volumes
    networks:
      - portainer_agent
    deploy:
      mode: global
      placement:
        constraints: [node.platform.os == linux]

  portainer:
    image: portainer/portainer
    command: -H tcp://tasks." . $user . "" . $LID . ":9001 --tlsskipverify
    ports:
      - \"9000:9000\"
    volumes:
      - portainer_data:/data
    networks:
      - portainer_agent
    deploy:
      mode: replicated
      replicas: 1
      placement:
        constraints: [node.role == manager]

networks:
  portainer_agent:
    driver: overlay
    attachable: true

volumes:
  portainer_data:
 \" > portagent.yml'");


			$cl = "../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " 'docker stack deploy -c portagent.yml portainer' ";
			addFunction($cl);
			/*-----setup---portainer---pass-----*/

			$ppass = $_POST["PP"];
			$padmin = $_POST["PA"];
			file_put_contents('script.sh', '#!/bin/bash
while true
do

	if [ $(echo sshpass -p ' . $pass . ' ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no ' . $user . '@localhost  docker service ls | grep portainer/portainer | grep 1/1)!="" ]
	then
		sleep 30
		continue
	 else 
		echo sshpass -p "' . $pass . '" ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no ' . $user .'@localhost echo \'' . $pass . '\' | sudo -S curl --include --request POST http://localhost:9000/api/users/admin/init --data \'{"Username":"' . $padmin . '","Password":"' . $ppass . '"}\'
		break
	fi
done');

			shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " 'sudo -S chmod +777 script.sh'");
			echo shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " 'bash script.sh'");
		}




		/*---------------------------------------------------------------------------------/****ELSE AGENT ONLY****\-------------------------------------------------------*/

		/*ELSE AGENT ONLY*/ else if (isset($_POST['Portainer']) && ($_POST['Portainer'] == "PAGENT")) {
			echo 'Creating a new Portainer endpoint. <br>';

			/*---------------------------------------------------PORTAINER---AGENT-------------------------------------------------*/

			if (shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " 'docker service ls | grep portainer/agent'") == "") {
				if ($_POST['AG']) {
					$LID = $_POST['AG'];
				} else {
					$LID = trim(shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " 'docker node ls | grep Leader|  awk \"{print $1}\"'"));
				}


				shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " 'echo \"version: '3.2'

services:
  " . $user . "" . $LID . ":
    image: portainer/agent
    environment:
      AGENT_CLUSTER_ADDR: tasks." . $user . "" . $LID . "
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock
      - /var/lib/docker/volumes:/var/lib/docker/volumes
    ports:
      - target: 9001
        published: 9001
        protocol: tcp
        mode: host
    networks:
      - portainer_agent
    deploy:
      mode: global
      placement:
        constraints: [node.platform.os == linux]

networks:
  portainer_agent:
    driver: overlay
    attachable: true
 \" > portagent.yml'");


				$cl = "../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " 'docker stack deploy -c portagent.yml portainer '";
				addFunction($cl);
			} else {
				echo "Portainer agent service already exists<br>";
			}

			/*---------------------------------------ADD---THE---AGENT---TO---THE---EXISTING---PORTAINER-------------------------------------------------*/

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'http://192.168.99.118:9000/api/auth');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"Username\":\"" . $_POST['PA'] . " \",\"Password\":\"" . $_POST['PP'] . "\"}");
			curl_setopt($ch, CURLOPT_POST, 1);

			$headers = array();
			$headers[] = 'Content-Type: application/x-www-form-urlencoded';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (shell_exec("echo " . $result . " | grep Invalid credentials ") == "Invalid credentials") {
				echo "Invalid username or password<br>";
			} else {
				echo "Trying to join as an endpoint<br>";
				$result2 = trim(shell_exec("echo \"" . $result . " \" | grep ey | cut -d '}' -f 1 | cut -d ':' -f 2"));

				if (curl_errno($ch)) {
					echo 'Error:' . curl_error($ch);
				}
				curl_close($ch);

				$adv = trim(shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " \" docker node inspect self --format '{{ .Status.Addr  }}' &\""));
				if (shell_exec("../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " \"sudo -S curl -kL -X POST " . $_POST['machip'] . ":9000/api/endpoints -H 'Authorization: Bearer " . $result2 . "' -H 'accept: application/json'  --form Name=" . $_POST['EN'] . " --form EndpointType=2 --form URL=tcp://" . $_POST['adv'] . ":9001 --form TLS=true --form TLSSkipVerify=true --form TLSSkipClientVerify=true 2>&1\" | grep Containers") != "") {
					echo " Endpoint added successfully <br>";
				} else {
					echo "error occured while trying to join as an endpoint <br>";
				}
			}
		}

		/*-----------------------------------------------------------------------------------------SWARMPROM---------------------------------------------------------------------*/

		if (isset($_POST['SwarmProm'])) {
			echo 'Checking for SWARMPROM <br>';
			$cl = "../exec.sh " . $_SESSION['user'] . " " . $_SESSION['pass'] . " ' git clone https://github.com/stefanprodan/swarmprom.git'";
			addFunction($cl);

			chdir('swarmprom');

			echo 'Starting SwarmProm Stack for monitoring <br>';
			if (isset($_POST['SA'], $_POST['SP'])) {
				if ($_POST['SU'] && $_POST['SM'] && $_POST['SC']) {
					
					$cl = '../exec.sh ' . $_SESSION['user'] . ' ' . $_SESSION['pass'] . ' \" ADMIN_USER=' . $_POST["SA"] . ' ADMIN_PASSWORD=' . $_POST["SP"] . ' SLACK_URL=' . $_POST["SU"] . ' SLACK_CHANNEL=' . $_POST["SC"] . ' SLACK_USER=' . $_POST["SM"] . ' docker stack deploy -c docker-compose.yml mon\"';
				} else {
					$cl = '../exec.sh ' . $_SESSION['user'] . ' ' . $_SESSION['pass'] . ' \" ADMIN_USER=' . $_POST["SA"] . ' ADMIN_PASSWORD=' . $_POST["SP"] . ' SLACK_URL=https://hooks.slack.com/services/TOKEN SLACK_CHANNEL=devops-alerts SLACK_USER=alertmanager docker stack deploy -c docker-compose.yml mon\"';
				}
			} else {
				if ($_POST['SU'] && $_POST['SM'] && $_POST['SC']) {
					$cl = '../exec.sh ' . $_SESSION['user'] . ' ' . $_SESSION['pass'] . ' \" ADMIN_USER=admin ADMIN_PASSWORD=admin SLACK_URL=' . $_POST["SU"] . ' SLACK_CHANNEL=' . $_POST["SC"] . ' SLACK_USER=' . $_POST["SM"] . ' docker stack deploy -c docker-compose.yml mon\"';
				} else {
					$cl = '../exec.sh ' . $_SESSION['user'] . ' ' . $_SESSION['pass'] . ' \" ADMIN_USER=admin ADMIN_PASSWORD=admin SLACK_URL=https://hooks.slack.com/services/TOKEN SLACK_CHANNEL=devops-alerts SLACK_USER=alertmanager docker stack deploy -c docker-compose.yml mon\"';
				}
			}
			addFunction($cl);
		}






		/*function to output code*/


		function addFunction($cmd)
		{
			while (@ob_end_flush()); // end all output buffers if any

			$proc = popen($cmd, 'r');
			echo '<pre>';
			while (!feof($proc)) {
				echo fread($proc, 4096);
				@flush();
			}
			echo '</pre>';
		}

		?>





	</div>
</body>

</html>

<!-- #---------------------------------------------------------------------------------------- # Script #-------------------------------------------------------------------------------------- -->

<script>
	$(document).ready(function() {

		/*---------------------------------------------------------------------------------------------MANAGERS----------------------------------------------------------------------------------------------------*/

		var i = 0,
			i1 = 0;
		/*--------------------------------------------------------------------------------MANAGER---MACHINES--------------------------------------------------------------------------*/
		$('#addm').click(function() {
			i++;
			$('#add_man').append('<tr id="rowm' + i + '"><td><input type="text" name="mu[]" placeholder="Shell user example : (root)"  required/></td><td><input type="text" name="mip[]" placeholder="SSH IP example: 192.168.2.222"  required/></td><td><input type="password" name="mp[]" placeholder="SSH Pass"required/></td> <td style="color:black;" >THIS IS NOT A DOCKER-MACHINE</td><td><button type="button" id="' + i + '" class="btn_removem1">X</button></td></tr>');
		});

		$(document).on('click', '.btn_removem1', function() {
			var button_id = $(this).attr("id");
			$('#rowm' + button_id + '').remove();
		});
		/*---------------------------------------------------------------------------MANAGER---DOCKER---MACHINES--------------------------------------------------------------------------*/
		$('#addmdm').click(function() {
			i1++;
			$('#add_man').append('<tr id="rowdm' + i1 + '"><td><input type="text" name="dmmu[]" placeholder="Shell user example : (root)"  required/></td><td><input type="text" name="dmmip[]" placeholder="SSH IP example: 192.168.2.222"  required/></td><td><input type="password" name="dmmp[]" placeholder="SSH Pass" required/></td> <td><input type="text" name="dmm[]" placeholder="Name of Docker-machine:"  required/></td><td><button type="button" id="' + i1 + '" class="btn_removem">X</button></td></tr>');
		});


		$(document).on('click', '.btn_removem', function() {
			var button_id = $(this).attr("id");
			$('#rowdm' + button_id + '').remove();
		});

		/*---------------------------------------------------------------------------------------------WORKERS----------------------------------------------------------------------------------------------------*/

		var j = 0,
			j1 = 0;
		/*--------------------------------------------------------------------------------WORKERS---MACHINES--------------------------------------------------------------------------*/
		$('#addw').click(function() {
			j++;
			$('#add_wor').append('<tr id="roww' + j + '"><td><input type="text" name="wu[]" placeholder="Shell user example : (root)" required/></td><td><input type="text" name="wip[]" placeholder="SSH IP example: 192.168.2.222" required/></td><td><input type="password" name="wp[]" placeholder="SSH Pass"  required/></td><td style="color:black;" >THIS IS NOT A DOCKER-MACHINE</td><td><button type="button" name="remove" id="' + j + '" class="btn_remove1">X</button></td></tr>');
		});

		$(document).on('click', '.btn_remove1', function() {
			var button_id = $(this).attr("id");
			$('#roww' + button_id + '').remove();
		});
		/*-----------------------------------------------------------------------------WORKERS---DOCKER---MACHINES--------------------------------------------------------------------------*/
		$('#addwdm').click(function() {
			j1++;
			$('#add_wor').append('<tr id="rowdw' + j1 + '"><td><input type="text" name="dmwu[]" placeholder="Shell user example : (root)" required/></td><td><input type="text" name="dmwip[]" placeholder="SSH IP example: 192.168.2.222" required/></td><td><input type="password" name="dmwp[]" placeholder="SSH Pass"  required/></td><td><input type="text" name="dmw[]" placeholder="Name of Docker-machine:"  required/></td><td><button type="button" name="remove" id="' + j1 + '" class="btn_remove">X</button></td></tr>');
		});

		$(document).on('click', '.btn_remove', function() {
			var button_id = $(this).attr("id");
			$('#rowdw' + button_id + '').remove();
		});




	});





	var coll = document.getElementsByClassName("collapsible");
	var i;

	for (i = 0; i < coll.length; i++) {
		coll[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var content = this.nextElementSibling;
			if (content.style.maxHeight) {
				content.style.maxHeight = null;
			} else {
				content.style.maxHeight = content.scrollHeight + "px";
			}
		});
	}





	$(document).ready(function() {

		$('#portagent').click(function() {
			if ($('#portagent').is(':checked')) {
				$('#port').show();
				$('#pag').show();
				$('#po2').show();
				$('#po4').show();
				$('#po22').show();
				$('#po22').prop('required', true);
				$('#po44').show();
				$('#po44').prop('required', true);
				$('#poxx').prop('required', true);
				$('#poyy').prop('required', true);
			}
		});
		$('#pnull').click(function() {
			if ($('#pnull').is(':checked')) {
				$('#port').hide();
				$('#pag').hide();
				$('#poxx').prop('required', false);
				$('#poyy').prop('required', false);
				$('#po22').prop('required', false);
				$('#po44').prop('required', false);
			}
		});
		$('#Portainer').click(function() {
			if ($('#Portainer').is(':checked')) {
				$('#port').show();
				$('#pag').show();
				$('#po2').hide();
				$('#po4').hide();
				$('#po22').hide();
				$('#po22').prop('required', false);
				$('#po44').hide();
				$('#po44').prop('required', false);
				$('#poxx').prop('required', true);
				$('#poyy').prop('required', true);
			}
		});
		$('#swap').click(function() {
			var $this = $(this);
			if ($this.is(':checked')) {
				$('#SP').show();
				$('#SPC').show();
			} else {
				$('#SP').hide();
				$('#SPC').hide();
			}
		});
	});
</script>



<!-- 
#----------------------------------------------------------------------------------------
#	CSS
#--------------------------------------------------------------------------------------
-->



<style>
	input[type][disabled] {
		background-color: #f9f9f9;
		color: #ddd;
		cursor: default;
	}

	input[type][disabled]+label {
		color: #999;
		cursor: default;
	}

	.form-checkbox {
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		display: inline-block;
		position: relative;
		background-color: #f1f1f1;
		color: #28D93A;
		top: 10px;
		height: 30px;
		width: 30px;
		border: 0;
		border-radius: 3px;
		cursor: pointer;
		margin-right: 7px;
		outline: none;
	}

	.form-checkbox:checked::before {
		position: absolute;
		font: 13px/1 'Open Sans', sans-serif;
		left: 11px;
		top: 7px;
		content: '\02143';
		transform: rotate(40deg);
	}

	.form-checkbox:hover {
		background-color: #f7f7f7;
	}

	.form-checkbox:checked {
		background-color: #28D93A;
	}

	label {
		font: 15px/1.7 'Open Sans', sans-serif;
		color: #333;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
		cursor: pointer;
	}

	.form-radio {
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		display: inline-block;
		position: relative;
		background-color: #f1f1f1;
		color: #28D93A;
		top: 10px;
		height: 30px;
		width: 30px;
		border: 0;
		border-radius: 50px;
		cursor: pointer;
		margin-right: 7px;
		outline: none;
	}

	.form-radio:checked::before {
		position: absolute;
		font: 13px/1 'Open Sans', sans-serif;
		left: 11px;
		top: 7px;
		content: '\02143';
		transform: rotate(40deg);
	}

	.form-radio:hover {
		background-color: #f7f7f7;
	}

	.form-radio:checked {
		background-color: #28D93A;
	}

	label {
		font: 15px/1.7 'Open Sans', sans-serif;
		color: #333;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
		cursor: pointer;
	}

	.table {
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		border-collapse: collapse;
		width: 100%;
	}

	.table td,
	.table th {
		border: 1px solid #ddd;
		padding: 8px;
	}

	.table tr {
		background-color: #FFFFFF;
	}

	.table tr:nth-child(even) {
		background-color: #f2f2f2;
	}

	.table tr:hover {
		background-color: #ddd;
	}

	.table th {
		padding-top: 12px;
		padding-bottom: 12px;
		text-align: left;
		background-color: #28546C
			/*#4CAF50*/
		;
		color: white;
	}

	h2 {
		color: black;
	}

	body {
		width: 100wh;
		height: 90vh;
		color: #fff;
		background: linear-gradient(-45deg, #49a09d, #5f2c82);
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

	div.ex2 {
		height: 200px;
		overflow: scroll;
		border: 1px solid gray;
		padding: 8px;
		text-indent: 50px;
		text-align: justify;
		letter-spacing: 3px;
		background: black;
		color: green;
		font-size: 20px;
		color: white;
		font-size: medium;
		font-family: Consolas, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New, monospace;
		width: 100%;
		display: inline-block;
	}

	.collapsible {
		background-color: #777;
		color: white;
		cursor: pointer;
		padding: 18px;
		width: 100%;
		border: none;
		text-align: left;
		outline: none;
		font-size: 15px;
	}

	.active,
	.collapsible:hover {
		background-color: #555;
	}

	.collapsible:after {
		content: '\002B';
		color: white;
		font-weight: bold;
		float: right;
		margin-left: 5px;
	}

	.active:after {
		content: "\2212";
	}

	.content {
		padding: 0 50px;
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.2s ease-out;
		background-color: #443d3d;
	}
</style>