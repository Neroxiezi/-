docker pull koolob/swoole-docker
docker build -t swoole-server:0.1 .
docker run -t -i -p 8080:8080 swoole-server:0.1