#!/bin/sh
# 録音ツール 2021/06/09
#
# sh ex_rfriends.sh menu,ui,height,width
#
# menu 0:normal 1:lite
# menu 0:cui 1:tui
# height 20-100
# width 50-200
#
cd `dirname $0`
base=`pwd`/

ex=ex_rfriends
#opt=0,1,24,80
opt=0,1,0,0

sh ${base}$ex.sh $opt

echo done
