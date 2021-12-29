## Swarm-Gen
Swarm gen is obviously a docker swarm generator which eases the swarm creation for further tests along with the possibility of implementing services for monitoring and more.

### Notes
In order to create multiple containers for test
```sh
docker-compose -p swarm up  --scale machine=3
```

```sh
docker swarm init
```
```sh
docker node ls
```