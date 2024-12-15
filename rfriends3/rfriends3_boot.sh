#!/bin/sh
#
# rfriends3 boot処理 for raspberry pi
# 2023/08/11
#
usr=rpi
#
if [ -f /home/${usr}/rfriends3/rfriends3_boot.txt ]; then
  mode=`head -1 /home/${usr}/rfriends3/rfriends3_boot.txt`
  mode=`echo $mode`
else
  mode=bis
fi

ip=`hostname -I | cut -d\  -f 1`
port=8000
#
systemctl stop apache2
systemctl stop php7.4-fpm
systemctl stop nginx
systemctl stop lighttpd
#
# built in server
#
if [ ${mode} = "bis" ]; then
    shl=/home/${usr}/rfriends3/rfriends3_server.sh
    su -l ${usr} -c "sh ${shl} ${ip}:${port} > /dev/null 2>&1" &
#
# apache2
#
elif [ ${mode} = "apache" ]; then
    conf=/etc/apache2/ports.conf
    rm ${conf}
    echo '# rfrieds3' > ${conf}
    echo "Listen ${ip}:${port}" >> ${conf}
    systemctl start apache2
#
# nginx
#
elif [ ${mode} = "nginx" ]; then
    systemctl start php7.4-fpm
    #systemctl start php8.1-fpm
    systemctl start nginx
#
# lighttpd
#
elif [ ${mode} = "lighttpd" ]; then
    cp /home/${usr}/rfriends3/lighttpd.conf /etc/lighttpd/.
    cp /home/${usr}/rfriends3/15-fastcgi-php.conf /etc/lighttpd/conf-available/.
    #chown ${usr}:${usr} /run/lighttpd
    systemctl start lighttpd
fi

# add 2024/09/09 for wifi power management off
/sbin/iwconfig wlan0 power off
#/sbin/iw dev wlan0 set power_save off

