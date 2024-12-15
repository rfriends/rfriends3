#!/bin/sh
# -----------------------------------------
# rfriends3 録音ツール
# 
# ipアドレス、ポートを指定する場合は
# rfriends3_server.txt に記述してください。
# 例：
# 192.168.1.1:8001
# 
# 2023/07/10 by mapi
# -----------------------------------------
cd `dirname $0`
base=`pwd`/
#
if [ $# -eq 1 ]; then
  server=$1
elif [ -f rfriends3_server.txt ]; then
  server=`head -1 rfriends3_server.txt`
else
  server=localhost:8000
fi

echo rfriends3_server start
echo
echo ${server}
echo

php -S ${server} -t ${base}script/html/ ${base}script/html/router.php

echo
echo rfriends3_server end
