image:
  file: Dockerfile
ports:
  - port: 8001
    onOpen: ignore
  - port: 3306
    onOpen: ignore
tasks:
  - init: composer install
    command: echo "Hallo"
  - name: MySQL
    command: >
        mysqld
  - name: Apache
    command: >
        apachectl start;
        multitail /var/log/apache2/error.log -I /var/log/apache2/access.log