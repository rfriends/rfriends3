#!/bin/sh
# =========================================
# install rfriends for ubuntu
# =========================================
# 3.0 2023/06/23
# 3.1 2023/07/10 remove chromium-browser
# 3.2 2023/07/12 renew
# 3.3 2023/08/04 add p7zip-full
# 3.4 2024/02/23 full
# 3.5 2024/02/24 add openssh-server
# 3.6 2024/10/29 add webdav
# 3.7 2024/11/04 add dirindex.css
# 4.0 2024/12/13 github
# 4.3 2025/01/02 sub
# 4.4 2025/01/23 renew
ver=4.4
# -----------------------------------------
echo
echo rfriends3 for linux $ver
echo `date`
echo
# -----------------------------------------
if [ -z "$distro" ]; then
  distro="ubuntu"
fi
#
if [ -z "$cmd" ]; then
  cmd="apt-get"
fi
#
sys=`pgrep -o systemd`
if [ $? -ne 0 ]; then
sys=0
fi
# -----------------------------------------
if [ -z "$optlighttpd" ]; then
  optlighttpd="on"
fi
if [ -z "$optsamba" ]; then
  optsamba="on"
fi
if [ "$optlighttpd" != "on" ]; then
  optlighttpd="off"
fi
if [ "$optsamba" != "on" ]; then
  optsamba="off"
fi
#
dir=$(cd $(dirname $0);pwd)
user=`whoami`
group=`groups | cut -d " " -f 1`
port=8000

if [ -z $HOME ]; then
  homedir=`sh -c 'cd && pwd'`
else
  homedir=$HOME
fi
#
#SITE=https://github.com/rfriends/rfriends3/releases/latest/download
SCRIPT=rfriends3_latest_script.zip
# =========================================
echo
echo install tools
echo
# =========================================
sudo $cmd update && sudo $cmd -y install \
unzip p7zip-full nano vim dnsutils iproute2 tzdata \
at cron wget curl atomicparsley \
php-cli php-xml php-zip php-mbstring php-json php-curl php-intl \
ffmpeg
sudo $cmd -y install chromium-browser 
sudo $cmd -y install openssh-server
# -----------------------------------------
# .vimrcを設定する
# -----------------------------------------
cd $homedir
mv -n .vimrc .vimrc.org
cat <<EOF > .vimrc
set encoding=utf-8
set fileencodings=iso-2022-jp,euc-jp,sjis,utf-8
set fileformats=unix,dos,mac
EOF
chmod 644 .vimrc
# =========================================
echo
echo install rfriends3
echo
# =========================================
cd $homedir
rm -f $SCRIPT
#wget $SITE/$SCRIPT
unzip -q -o $SCRIPT

mkdir -p $homedir/tmp/
cat <<EOF > $homedir/rfriends3/config/usrdir.ini
usrdir = "$homedir/rfriends3/usr/"
tmpdir = "$homedir/tmp/"
EOF
# -----------------------------------------
echo
echo install samba
echo
# -----------------------------------------
echo $optsamba
if [ $optsamba = "on" ]; then
sudo $cmd -y install samba
sudo mkdir -p /var/log/samba
sudo chown root:adm /var/log/samba

sudo cp -p /etc/samba/smb.conf /etc/samba/smb.conf.org
sed -e s%rfriendshomedir%$homedir%g $dir/smb.conf.skel > $dir/smb.conf
sed -i s%rfriendsuser%$user%g $dir/smb.conf
sudo cp -p $dir/smb.conf /etc/samba/smb.conf
sudo chown root:root /etc/samba/smb.conf

mkdir -p $homedir/smbdir/usr2/
cat <<EOF > $homedir/rfriends3/config/usrdir.ini
usrdir = "$homedir/smbdir/usr2/"
tmpdir = "$homedir/tmp/"
EOF

if [ $sys -eq 1 ]; then
  sudo systemctl enable smbd
  sudo systemctl restart smbd
else 
  sudo service smbd restart
fi
fi
# -----------------------------------------
echo
echo install lighttpd
echo
# -----------------------------------------
echo $optlighttpd
if [ $optlighttpd = "on" ]; then
sudo $cmd -y install lighttpd lighttpd-mod-webdav php-cgi
cd $dir
sudo cp -p /etc/lighttpd/conf-available/15-fastcgi-php.conf /etc/lighttpd/conf-available/15-fastcgi-php.conf.org
sed -e s%rfriendshomedir%$homedir%g 15-fastcgi-php.conf.skel > 15-fastcgi-php.conf
sudo cp -p 15-fastcgi-php.conf /etc/lighttpd/conf-available/15-fastcgi-php.conf
sudo chown root:root /etc/lighttpd/conf-available/15-fastcgi-php.conf

sudo cp -p /etc/lighttpd/lighttpd.conf /etc/lighttpd/lighttpd.conf.org
sed -e s%rfriendshomedir%$homedir%g lighttpd.conf.skel > lighttpd.conf
sed -i s%rfriendsuser%$user%g lighttpd.conf
sed -i s%rfriendsgroup%$group%g lighttpd.conf
sed -i s%rfriendsport%$port%g lighttpd.conf
sudo cp -p lighttpd.conf /etc/lighttpd/lighttpd.conf
sudo chown root:root /etc/lighttpd/lighttpd.conf

mkdir -p $homedir/lighttpd/uploads/
cd $homedir/rfriends3/script/html
ln -nfs temp webdav
cd $homedir
sudo lighttpd-enable-mod fastcgi
sudo lighttpd-enable-mod fastcgi-php
echo lighttpd > $homedir/rfriends3/rfriends3_boot.txt

if [ $sys -eq 1 ]; then
  sudo systemctl enable lighttpd
  sudo systemctl restart lighttpd
else 
  sudo service lighttpd restart
fi
fi
# -----------------------------------------
# systemd or service
# -----------------------------------------
if [ $sys -eq 1 ]; then
  sudo systemctl enable atd
  sudo systemctl enable cron
else 
  sudo service atd restart
  sudo service cron restart
fi
# -----------------------------------------
echo
echo "distro : $distro"
if [ $sys -eq 1 ]; then
  echo "type : systemd" 
else 
  echo "type : initd"
fi
echo
echo samba : $optsamba
echo lighttpd : $optlighttpd
echo
echo user  : $user
echo group : $group
echo port  : $port
echo home directry : $homedir
echo current directry : $dir
# -----------------------------------------
#  アクセスアドレス
# -----------------------------------------
#cd $homedir
#ip=`sh $homedir/rfriends3/getIP.sh`
#server=${ip}:${port}
# -----------------------------------------
# finish
# -----------------------------------------
echo `date`
echo finished rfriends_rfriends3
echo
# -----------------------------------------
