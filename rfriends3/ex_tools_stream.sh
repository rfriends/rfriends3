#!/bin/sh
# -----------------------------------------
# rfriends3 (radiko radiru録音ツール)
# 修正　2023/06/06
# 確認　
# -----------------------------------------
echo
echo "これは CentOS Stream 8 用です"
echo "これは Rocky Linux 8   用です"
echo
# -----------------------------------------
cd `dirname $0`
base=`pwd`
ver=$base/_Rfriends3
bit=`getconf LONG_BIT`

if [ ! -f $ver ]; then
	echo $ver ファイルがありません
	echo ディレクトリ構成が間違っています。
	echo
	exit
fi
# -----------------------------------------
cat $ver
echo ベースディレクトリは　$base です
echo OSは $bit bitsバージョンです
echo
echo "リポジトリを追加しますか　(y/n) ?"
read ans
if [ "$ans" = "y" ]; then
    sudo yum install https://dl.fedoraproject.org/pub/epel/epel-release-latest-8.noarch.rpm
    sudo yum install https://download1.rpmfusion.org/free/el/rpmfusion-free-release-8.noarch.rpm https://download1.rpmfusion.org/nonfree/el/rpmfusion-nonfree-release-8.noarch.rpm
    sudo yum install http://rpmfind.net/linux/epel/7/x86_64/Packages/s/SDL2-2.0.14-2.el7.x86_64.rpm
fi
# -----------------------------------------
# ツールのインストール
# -----------------------------------------
echo
echo "yum update します"
echo
sudo yum update
# -----------------------------------------
echo
echo rfriends Setup Utility Ver. 3.00
echo
echo php, ffmpeg, at, AtomicParsley,...
echo

echo "上記ツールをインストールしますか　(y/n) ?"
read ans
if [ "$ans" = "y" ]; then

    sudo yum -y install unzip
    sudo yum -y install at
    sudo yum -y install nano
    sudo yum -y install vim
    sudo yum -y install dnsutils
    sudo yum -y install iproute2
    sudo yum -y install tzdata
    sudo yum -y install wget
    sudo yum -y install curl
    sudo yum -y install atomicparsley
    sudo yum -y install libxml2-utils
    sudo yum -y install ffmpeg
    sudo yum -y install chromium-browser

    #sudo yum -y install php
    sudo yum -y install php-cli
    sudo yum -y install php-xml
    sudo yum -y install php-zip
    sudo yum -y install php-mbstring
    sudo yum -y install php-json
    sudo yum -y install php-curl
    sudo yum -y install php-intl
    #sudo yum -y install php-openssl

    # -----------------------------------------
    #sudo yum -y install pulseaudio
    #sudo yum -y install pulseaudio-module-bluetooth
    #sudo yum -y install dnsutils

    #sudo yum -y install apache2
    #sudo yum -y install libapache2-mod-php

    #sudo yum -y install samba
fi
# -----------------------------------------
# 終了
# -----------------------------------------
echo
echo finished
# -----------------------------------------
