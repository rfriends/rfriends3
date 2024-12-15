#!/bin/sh
# -----------------------------------------
# rfriends3 (radiko radiru録音ツール)
# ipを使用してipv4を取得する
# hostname -Iは未対応の機種があるため使用しない
#
# 2023/07/19 macのipコマンドに対応（scopeなし）
# 2024/10/21 termuxのipコマンドエラーに対応（security）
# -----------------------------------------
ip=`ip a | grep "inet " | grep -m1 -v "127.0.0.1" | sed -e 's/^ *//' | cut -d\  -f 2 | cut -d/ -f 1`
#
if [ "${ip}" = "" ]; then
ip=`ifconfig | grep "inet " | grep -m1 -v "127.0.0.1" | sed -e 's/^ *//' | cut -d\  -f 2 | cut -d/ -f 1`
fi
#
echo -n ${ip}
# -----------------------------------------
