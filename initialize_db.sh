#!/bin/bash

while ! mysqladmin ping -h"localhost" --silent; do
    sleep 1
done

RESULT=`mysqlshow -u root busdb | grep -v Wildcard | grep -o busdb`
if [ "$RESULT" != "busdb" ]; then
    echo "Initializing BUS DB"
    mysql -u root -e 'create database busdb'
    wget https://raw.githubusercontent.com/hergin/BusShuttleMainRepository/master/Resources/SchemaWithAuth.sql -P /app
    wget https://raw.githubusercontent.com/hergin/BusShuttleMainRepository/master/Resources/SampleUser.sql -P /app
    mysql -u root busdb < /app/SchemaWithAuth.sql
    mysql -u root busdb < /app/SampleUser.sql
fi
