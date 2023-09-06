FROM mariadb:10.10

ARG MYSQL_DBNAME

RUN echo "CREATE DATABASE IF NOT EXISTS $MYSQL_DBNAME;" > /docker-entrypoint-initdb.d/setup.sql

CMD ["--default-authentication-plugin=mysql_native_password"]