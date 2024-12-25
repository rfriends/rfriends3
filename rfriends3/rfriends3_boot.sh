#!/bin/sh
# ------------------------------------------------
# rfriends3 boot処理 for raspberry pi
# 2023/08/11
# 2024/12/25
# ------------------------------------------------
dir=$(cd $(dirname $0);pwd)
log=$dir/rfriends3_boot.log
echo `date` rfriends_boot.sh start $dir > $log

homedir=`cd $dir/../;pwd`
user=`echo "$dir" | cut -d'/' -f3`
echo homedir: $homedir user: $user >> $log

sdir=s%rfriendshomedir%${homedir}%g
susr=s%rfriendsuser%$user%g
# ------------------------------------------------
cd $dir
if [ -f $dir/rfriends3_boot.txt ]; then
  mode=`head -1 $dir/rfriends3_boot.txt`
  mode=`echo $mode`
else
  mode=bis
fi
echo mode: $mode >> $log
#
systemctl stop apache2
systemctl stop php7.4-fpm
systemctl stop nginx
systemctl stop lighttpd
#
# built in server
#
if [ ${mode} = "bis" ]; then
    shl=$dir/rfriends3_server.sh
    su -l ${usr} -c "sh ${shl} ${ip}:${port} > /dev/null 2>&1" &
    echo start built in server >> $log
#
# apache2
#
elif [ ${mode} = "apache" ]; then
    conf=/etc/apache2/ports.conf
    rm ${conf}
    echo '# rfrieds3' > ${conf}
    echo "Listen ${ip}:${port}" >> ${conf}
    systemctl start apache2
    echo start apache2 >> $log
#
# nginx
#
elif [ ${mode} = "nginx" ]; then
    systemctl start php7.4-fpm
    #systemctl start php8.1-fpm
    systemctl start nginx
    echo start nginx >> $log
#
# lighttpd
#
elif [ ${mode} = "lighttpd" ]; then
    cat $dir/lighttpd.conf        | sed -e $sdir | sed -e $susr | sudo tee /etc/lighttpd/lighttpd.conf > /dev/null
    cat $dir/15-fastcgi-php.conf  | sed -e $sdir | sudo tee /etc/lighttpd/conf-available/15-fastcgi-php.conf > /dev/null
    #chown ${usr}:${usr} /run/lighttpd
    systemctl start lighttpd
    echo start lighttpd >> $log
fi

exit 0
