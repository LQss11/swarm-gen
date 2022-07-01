## Swarm-Gen
Swarm gen is obviously a docker swarm generator which eases the swarm creation for further tests along with the possibility of implementing services for monitoring and more.

### Quick start
In order to create multiple containers for the test
```sh
docker-compose -p swarm up  --scale slave=3 --build
```
## Manage a swarm
First, you will need to get inside the controller node created as a docker container run:
```sh
docker exec -it swarm-master-1 bash
```
then you can run these scripts to create a swarm:
```sh
/src/manage-swarm.sh
```
this script is interactive meaning that will have the ability to pass one of the IP addresses listed and user + password keeping in mind that the default user and pass created for those are `admin:admin`

Once done you can later join other nodes by rerunning the same script or you can join all nodes at a time
```sh
/src/join_all.sh
```
or purge all nodes:
```sh
/src/purge.sh
```

in case you manually want to leave swarm run:
```sh
docker swarm leave -f
```

run this to create an nginx container replicated globally
```sh
docker service create   --mode global   --publish mode=host,target=80,published=8080   --name=nginx   nginx:latest
```

check containers
```sh
docker service ls
```

# Info
This project is based on an old project, a lot of changes in environments have changed causing issues:
```
http://localhost:7777/LoginPage/loginh.php
```
you can check some info here
