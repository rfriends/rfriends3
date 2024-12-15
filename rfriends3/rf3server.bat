@echo off
rem -----------------------------------------
rem rfriends3 録音ツール
rem 
rem ポートを指定する場合は、rf3server.bat 8000
rem 
rem 2023/07/19 by mapi
rem -----------------------------------------
echo rf3server Ver. 1.10

set port=8000
if not "%1"=="" (
  set port=%1
)

for /F "usebackq delims=: tokens=2" %%a in (`ipconfig ^| findstr "IPv4"`) do set server=%%a
set server2=%server:~1%

echo -----------------------------------------------
echo ipv4を取得しWeb サーバを実行します。
echo 複数実行すると、サーバが複数起動します。
echo ctrl-c で1つ以外は終了させてください。
echo.
echo サーバの起動後、ブラウザに
echo %server%:%port%
echo と入力するとrfriends3を実行します。
echo -----------------------------------------------

rem prohibit lighttpd 2024/07/07
rem set target=bin\lighttpd\lighttpd.exe
set target=bin\lighttpd\lighttpd.exe.dummy

set base=%~dp0
cd /d %~dp0

if not exist %target%  (
    rfriends3_server.bat %server%:%port%
) else (
     rfriends3_lighttpd.bat %server%:%port%
)
exit
