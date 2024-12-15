#!/bin/sh
# -----------------------------------------
# rfriends3 (radiko radiru録音ツール)
# ipv4を取得しrfriends_serverを実行する
# ポートを指定する場合は、rf3server.sh 8000
# -----------------------------------------
port=8000

if [ $# -eq 1 ]; then
    port=$1
fi

ip=`sh getIP.sh`
server=${ip}:${port}
# -----------------------------------------
sh rfriends3_server.sh ${server}
# -----------------------------------------
