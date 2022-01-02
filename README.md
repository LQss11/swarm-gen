## Swarm-Gen
Swarm gen is obviously a docker swarm generator which eases the swarm creation for further tests along with the possibility of implementing services for monitoring and more.

### Notes
In order to create multiple containers for test
```sh
docker-compose -p swarm up  --scale slave=3 --build
```

```sh
docker swarm init
```
```sh
docker node ls
```



run this to create an nginx container replicated globally
```sh
docker service create   --mode global   --publish mode=host,target=80,published=8080   --name=nginx   nginx:latest
```

check containers
```sh
docker service ls
```