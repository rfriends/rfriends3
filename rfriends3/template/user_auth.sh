#!/bin/sh
# -----------------------------------------
# user auth
# 2022/06/30
# -----------------------------------------
# 以下の部分を記述することにより
# ユーザー独自のradiko認証が可能になります。
# ここに実行内容を直接書かずに
# 実行するプログラムのみ記述することをお勧めします。
# -----------------------------------------
# 呼び出し（例：user_auth.sh user_auth,13  loc=1-47,loc=0は現在地）
# user_auth.sh user_auth,loc
#
# リターン(XXXXXは任意メッセージ、user_auth1で判別、loc=99はエラー)
# xxxxx
# user_auth1,loc,token
# xxxxx
# -----------------------------------------
#sh /home/pi/uauth.sh $1 >> /home/pi/uauth.log
# -----------------------------------------
# 終了
exit
# -----------------------------------------