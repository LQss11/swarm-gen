## Swarm-Gen
Swarm gen is obviously a docker swarm generator which eases the swarm creation for further tests along with the possibility of implementing services for monitoring and more.

### Quick start
In order to create multiple containers for test
```sh
docker-compose -p swarm up  --scale slave=3 --build
```
## Manage swarm
First you will need to get inside the master node created as a docker container run:
```sh
docker exec -it swarm-master-1 bash
```
then you can run these scripts to create swarm:
```sh
/src/manage-swarm.sh
```
this script is interactve meaning that will have the ability to pass one of the ip addresses listed and user + password keeping in mind that default user and pass created for those are `admin:admin`

Once done you can later join other nodes by running the same script again or you can join all nodes at a time
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