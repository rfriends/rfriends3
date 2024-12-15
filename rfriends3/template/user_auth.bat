@echo off
rem -----------------------------------------
rem user auth
rem 2022/06/30
rem -----------------------------------------
rem 以下の部分を記述することにより
rem ユーザー独自のradiko認証が可能になります。
rem ここに実行内容を直接書かずに
rem 実行するプログラムのみ記述することをお勧めします。
rem -----------------------------------------
rem 呼び出し（例：user_auth.sh user_auth,13  loc=1-47,loc=0は現在地）
rem user_auth.sh user_auth,loc
rem 
rem リターン(XXXXXは任意メッセージ、user_auth1で判別、loc=99はエラー)
rem xxxxx
rem user_auth1,loc,token
rem xxxxx
rem -----------------------------------------
rem c:\Temp\uauth.bat %1 < nul
rem -----------------------------------------
rem 終了
exit
rem -----------------------------------------
