# Docker安装Tars



### 下载镜像



```shell
 docker pull mysql:5.6

 docker pull  tarscloud/tars:dev

docker pull tarscloud/tars-node:dev
```



###  创建mysql容器

```shell
docker run --name mysql -e MYSQL_ROOT_PASSWORD=password -d -p 3306:3306 -v /home/pfinal/tars_test/mysql_data:/var/lib/mysql mysql:5.6
```



### 创建tars容器

```
docker run -d -it --name tars --link mysql  --env DBIP=mysql --env DBPort=3306 --env DBUser=root --env DBPassword=password -p 3000:3000 -v /home/maocong90/tars_test/tars_data:/data tarscloud/tars:dev
```



```
docker exec -it tars bash
```



​	