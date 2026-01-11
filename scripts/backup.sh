#!/bin/bash

CONTAINER_NAME='sofditech-prohumanos-db'
MYSQL_DB='prohumanos'
MYSQL_USER='root'
MYSQL_PSW='root'

MYSQL_CONTAINER=$(docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' $CONTAINER_NAME)
MYSQL_CONN="-u${MYSQL_USER} -p${MYSQL_PSW} -h${MYSQL_CONTAINER}"


V_ANO=`date +%Y`
V_MES=`date +%m`
V_DIA=`date +%d`
FECHA=`date +%Y%m%d%H%M`
ARCHIVO=${MYSQL_DB}_full_$FECHA.sql
V_DIRECTORIO=~/db/${MYSQL_DB}/$V_ANO/$V_MES/$V_DIA

mkdir -p $V_DIRECTORIO

mysqldump ${MYSQL_CONN} \
    --column-statistics=0 \
    --add-drop-database \
    --single-transaction \
    --triggers \
    --routines \
    --events \
    --databases ${MYSQL_DB} > $V_DIRECTORIO/$ARCHIVO