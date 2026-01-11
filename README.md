# SOFDITECH PROHUMANOS SOFTWARE

## 1. SOFTWARE REQUIREMENTS
  1. **Docker**
  2. **docker-compose**


## 2. INSTALL DEV ENVIROMENT
  1. Make file dotenv in root project ".env" with this content
  ```
    # ------------------------------------------------------------------------------
    # CERTIFICATE SSL
    # ------------------------------------------------------------------------------
    SERVER_CRT=dev/server.crt
    SERVER_KEY=dev/server.key
    SERVER_CA=dev/server.crt


    # ------------------------------------------------------------------------------
    # ACCESS DB
    # ------------------------------------------------------------------------------
    DB_DRIVER=mysql
    DB_HOST=sofditech-prohumanos-db
    DB_PORT=53306
    DB_NAME=prohumanos
    DB_USER=root
    DB_PASSWORD=root
    DB_CHARSET=utf8mb4

    # ------------------------------------------------------------------------------
    # APP CONFIG
    # ------------------------------------------------------------------------------
    APP_HOST=http://sofditech.prohumanos.com:9080
    APP_URL=/
    APP_SAFE=true
    APP_KEY=$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$
    APP_TIMEZONE=America/Bogota
    APP_DEBUG=true
    APP_TIMEOUT=60000
    APP_PORT=9080
    APP_NAME=Prohumanos App

    # ------------------------------------------------------------------------------
    # PROVIDERS CONFIG
    # ------------------------------------------------------------------------------
    PROVIDER_MAIL_HOST=smtp.gmail.com
    PROVIDER_MAIL_PORT=465
    PROVIDER_MAIL_USER=
    PROVIDER_MAIL_PASSWORD=
    PROVIDER_MAIL_FROM=DevProhumanos
    PROVIDER_MAIL_SMTP_AUTH=true
    PROVIDER_MAIL_SMTP_SECURE=ssl

    PROVIDER_SMS_CLIENT=
    PROVIDER_SMS_PASSWORD=

  ``` 

  2. **execute command "UP" to build containers**
  ```
  docker-compose up --build
  ```
   
  3. Add line "127.0.0.1   sofditech.prohumanos.com" in hosts file /etc/hosts. use nano editor "sudo nano /etc/hosts"
  ```                                
    127.0.0.1       localhost
    127.0.0.1       sofditech.prohumanos.com

    # The following lines are desirable for IPv6 capable hosts
    ::1     ip6-localhost ip6-loopback
    fe00::0 ip6-localnet
    ff00::0 ip6-mcastprefix
    ff02::1 ip6-allnodes
    ff02::2 ip6-allrouters
  ```   

## 3. Execute Application
  - http://sofditech.prohumanos.com:9080/

## 4. User Development
  - username: developer
  - password: Developer*1
 