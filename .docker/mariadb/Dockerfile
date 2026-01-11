FROM mariadb:10.3

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    wget \
    curl \
    unzip \
    tar \
    bash-completion \
    && apt-get clean

# Configurar la zona horaria
RUN ln -fs /usr/share/zoneinfo/America/Bogota /etc/localtime \
&& dpkg-reconfigure -f noninteractive tzdata
