#!/bin/sh
# -----------------------------------------
# Rfriends (radiko radiru録音ツール)
# 2020/03/29
# 2021/02/26
# 2023/05/05
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

cat $ver
echo ベースディレクトリは　$base です
echo OSは $bit bitsバージョンです
echo 
echo これは arch linux 用です

# -----------------------------------------
# ツールのインストール
# -----------------------------------------
sudo pacman -Syu
# -----------------------------------------
#  php, ffmpeg, at, gpac, swftools,mp4v2-utils
# -----------------------------------------
echo
echo rfriends Setup Utility Ver. 2.00
echo
echo
echo php, ffmpeg, at, libmp4v2, wget, nano
echo
echo "上記ツールをインストールしますか　(y/n) ?"
read ans
if [ $ans = "y" ]; then
	sudo pacman -S php
	#sudo pacman -S php-cli
	#sudo pacman -S php-xml
	#sudo pacman -S php-zip
	#sudo pacman -S php-mbstring

	sudo pacman -S ffmpeg

	sudo pacman -S at

	sudo pacman -S extra/libmp4v2
	sudo pacman -S atomicparsley
	sudo pacman -S cronie
	sudo pacman -S wget
	sudo pacman -S curl
	sudo pacman -S nano

	#sudo pacman -S gpac
	#sudo pacman -S imagemagick
	#sudo pacman -S swftools
	#sudo pacman -S unzip
fi
# -----------------------------------------
# 終了
# -----------------------------------------
echo
echo finished
# -----------------------------------------
