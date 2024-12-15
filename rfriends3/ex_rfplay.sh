#!/bin/sh
# 録音ツール 2021/04/10
#
# sh ex_rfriends.sh menu,ui,height,width
#
# menu 0:normal 1:lite
# menu 0:cui 1:tui
# height 20-100
# width 50-200
#
para=$1
cd `dirname $0`
base=`pwd`/
usrdir=`cat ${base}etc/usrdef`
tmpdir=`cat ${base}etc/tmpdef`

#ex=rfriends_check
#php ${base}script/$ex.php
#ret=$?
#if [ $ret -eq 1 ] ;then
#	exit
#fi

ex=rfplay

export NEWT_COLORS='
root=white,blue
window=white,black
border=white,black
textbox=white,black
#button=white,black
title=white,black
'

#echo -e "\033[44m"
stp=0
while [ $stp -eq 0 ]
do
	clear
        #echo $para
	php ${base}script/play/$ex.php $para
	ret=$?
	case $ret in
		 0 ) stp=0;;
		 1 ) stp=1;;
		 * ) ed=`php ${base}script/rfriends_get_editfn.php $ret`
	   	     if [ -n "$ed" ]; then
			edit=`cat ${base}etc/rf_editor`
			#echo $ed
			#echo $ret
		     	$edit $ed
		     else
			stp=1
		     fi
	         ;;
	esac
done
