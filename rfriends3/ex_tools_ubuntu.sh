#!/bin/sh
# -----------------------------------------
# rfriends3 (radiko radiru録音ツール)
# 修正　2023/06/06
# 修正　2023/07/12
# 確認　
# -----------------------------------------
echo
echo "これは ubuntu,debian 用です"
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
# -----------------------------------------
# ツールのインストール
# -----------------------------------------
#echo
#echo "apt update します"
#echo
#sudo apt update
# -----------------------------------------
echo
echo rfriends Setup Utility Ver. 3.00
echo
echo php, ffmpeg, at, AtomicParsley,...
echo

echo "上記ツールをインストールしますか　(y/n) ?"
read ans
if [ "$ans" = "y" ]; then

    sudo apt -y install unzip
    sudo apt -y install at
    sudo apt -y install nano
    sudo apt -y install vim
    sudo apt -y install wget
    sudo apt -y install curl
    sudo apt -y install atomicparsley
    sudo apt -y install libxml2-utils
    sudo apt -y install ffmpeg
    sudo apt -y install chromium-browser

    sudo apt -y install php
    sudo apt -y install php-cli
    sudo apt -y install php-xml
    sudo apt -y install php-zip
    sudo apt -y install php-mbstring
    sudo apt -y install php-json
    sudo apt -y install php-curl
    sudo apt -y install php-intl
    #sudo apt -y install php-openssl
    # -----------------------------------------
    #sudo apt -y install pulseaudio
    #sudo apt -y install pulseaudio-module-bluetooth
    #sudo apt -y install dnsutils

    #sudo apt -y install apache2
    #sudo apt -y install libapache2-mod-php

    #sudo apt -y install samba
fi
# -----------------------------------------
# 終了
# -----------------------------------------
echo
echo finished
# -----------------------------------------
