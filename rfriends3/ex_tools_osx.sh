#!/bin/sh
# -----------------------------------------
# Rfriends (radiko radiru録音ツール)
# 2020/03/30
# 2021/02/26
# 2022/02/04
# 2023/07/12 rfriends3 対応
# 2023/07/17 7z 追加
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
echo これは OSX 用です
# -----------------------------------------
# ツールのインストール
# -----------------------------------------
brew update
# -----------------------------------------
#  php, ffmpeg,
# -----------------------------------------
echo
echo rfriends Setup Utility Ver. 2.10
echo
echo
echo php, ffmpeg, , wget
echo
echo "上記ツールをインストールしますか　(y/n) ?"
read ans
if [ $ans = "y" ]; then
	brew install php@8.1
	brew link php@8.1
	#brew link php@8.1 --force

	brew install wget
	brew install atomicparsley
    brew install pidof
	brew install ffmpeg
    brew install chromium
    brew install p7zip
fi
# -----------------------------------------
# 終了
# -----------------------------------------
echo
echo finished
# -----------------------------------------
