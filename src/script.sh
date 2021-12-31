#!/bin/bash

read -p "Would you like to create a new swarm? [Yes/No]" create_swarm
case "$create_swarm" in
Yes)
    docker swarm init
    ;;
No)
    ls
    ;;
*)
    echo "Wrong Input please enter 'Yes' or 'No'"
    ;;
esac


TOKEN=$(docker swarm join-token worker | grep token) # get full worker token

re='^[0-9]+$' # Regular expression for number

while read -p "What is the number of the machine you want to join as a worker? [0 to exit]" machine_number; do
    if ! [[ $machine_number =~ $re ]]; then
        echo "error: Not a number" >&2
    elif [[ $machine_number -eq 0 ]]; then
        #exit
        break
    else
        sshpass -p  root  ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no  root@swarm_slave_$machine_number $TOKEN
    fi
done

#TOKEN=$(docker swarm join-token worker | grep token)

#sshpass -p  root  ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no  root@swarm_slave_3 $TOKEN
