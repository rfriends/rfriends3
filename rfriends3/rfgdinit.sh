#!/bin/sh
# 録音ツール
cd `dirname $0`
base=`pwd`/
usrdir=`cat ${base}etc/usrdef`
tmpdir=`cat ${base}etc/tmpdef`

ex=rf_gdriveinit

#echo -e "\033[44m"

clear
php ${base}script/$ex.php

#echo "Press any key "
#read  ans
#echo -e "\033[m"
#clear
echo done
