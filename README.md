# bibliotheque_final

### Red del proyecto

**sudo docker network create mvc**

### Variables de entorno

Estos valores hay que colocarlos en el archivo .env, que debemos crear, por fuera de la carpeta app/

```
TZ=America/Argentina/Buenos_Aires
MYSQL_SERVER=mvc-db
MYSQL_ROOT_PASSWORD=root
PMA_HOST=mysqldb
MYSQL_DATABASE=bibliotheque
MYSQL_USER=root
MYSQL_PASS=root
```

### Levantar el proyecto

**sudo docker-compose up -d**

### Accesos

- http://localhost:8061 -> PhpMyAdmin
- http://localhost:8060 -> servidor apache
