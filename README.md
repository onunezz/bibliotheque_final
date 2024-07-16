# bibliotheque_final


### Red del proyecto

**sudo docker network create mvc**

### Variables de entorno

Estos valores hay que colocarlos en el archivo .env, que debemos crear, por fuera de la carpeta app/
```
TZ=America/Argentina/Buenos_Aires
SQL_SERVER=database
MYSQL_ROOT_PASSWORD=root
PMA_HOST=mysqldb
SQL_DATABASE=my_db
SQL_USER=root
SQL_PASS=root
```

### Levantar el proyecto

**sudo docker-compose up -d**

### Accesos

+ http://localhost:8061 -> PhpMyAdmin
+ http://localhost:8060 -> servidor apache
