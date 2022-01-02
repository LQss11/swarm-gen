#!/bin/bash
while true
do
	if [ $(echo azerty123 | sudo -S -u lqss  docker service ls | grep portainer/portainer | grep 1/1)!="" ]
	then
		sleep 30
		continue
	 else 
		echo "azerty123" | sudo -S -u lqss sshpass -p azerty123 ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no lqss@localhost echo 'azerty123' | sudo -S curl --include --request POST http://localhost:9000/api/users/admin/init --data '{"Username":"lqss","Password":"azerty123"}'
		break
	fi
done