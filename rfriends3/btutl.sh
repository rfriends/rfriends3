#!/bin/sh 
echo bluetooth utility ver. 0.01 
echo 
if [ $# = 0 ]; then
    echo usage:
    echo
    echo sh btutl.sh con  
    echo sh btutl.sh on   
    echo sh btutl.sh off  
    echo sh btutl.sh 50   
    echo
    exit 
fi 
if [ $# != 1 ]; then
    echo parameter error
    exit 
fi 
val=$1
if [ "$val" = "on" ]; then 
    amixer sset Master $val
    exit 
fi 
if [ "$val" = "off" ]; then 
    amixer sset Master $val
    exit 
fi
if [ "$val" != "con" ]; then 
    p="%"
    amixer sset Master $val$p
    exit
fi

CNT=`sudo bluetoothctl -- paired-devices | grep Device | wc -l` 
if [ "$CNT" = 0 ]; then 
    echo ペアリングされた機器がありません 
    exit 
fi 
echo 
sudo bluetoothctl -- paired-devices 
echo 
echo "接続したい機器の電源をONにしてください" 
echo "接続しますか(y/N) ?" 
read ans 
if [ "$ans" = "y" ]; then 
    sudo bluetoothctl -- paired-devices | grep Device | awk '{ print $2 }' | xargs -n 1 sudo bluetoothctl -- connect 
    echo 
    echo Connection successful と表示されたら成功です 
    echo 
fi
