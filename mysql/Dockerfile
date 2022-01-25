FROM mariadb:10.3
#####################################
ADD init/createdb_init.sql /docker-entrypoint-initdb.d/createdb_init.sql

ARG TZ="America/Santo_Domingo"
ENV TZ ${TZ}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone && chown -R mysql:root /var/lib/mysql/
COPY my.cnf /etc/mysql/conf.d/my.cnf

RUN chmod -R 644 /etc/mysql/conf.d/my.cnf

CMD ["mysqld"]

EXPOSE 3306
