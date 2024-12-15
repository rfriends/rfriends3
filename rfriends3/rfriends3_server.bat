@echo off
rem -----------------------------------------
rem rfriends3 録音ツール
rem 
rem ipアドレス、ポートを指定する場合は
rem rfriends3_server.txt に記述してください。
rem 例：
rem 192.168.1.1:8001
rem 
rem 2023/06/06 by mapi
rem -----------------------------------------
cd /d %~dp0
set base=%CD%\
rem set ver=%base%_Rfriends3
set ver=_Rfriends3
if exist %ver% goto st

echo %ver% ファイルがありません
echo ディレクトリ構成が間違っています。
echo.
pause
exit

:st
if not "%1"=="" (
  set server=%1
) else if exist rfriends3_server.txt (
  set /p server=<rfriends3_server.txt
) else (
  set server=localhost:8000
)
echo. 
echo buit-in server start %server%
echo.
rem %base%bin\php\php -S %server% -t %base%script\html\ %base%script\html\router.php
bin\php\php -S %server% -t script\html\ script\html\router.php
