@echo off
rem -----------------------------------------
rem rfriends3 �^���c�[��
rem 
rem �|�[�g���w�肷��ꍇ�́Arf3server.bat 8000
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
echo ipv4���擾��Web �T�[�o�����s���܂��B
echo �������s����ƁA�T�[�o�������N�����܂��B
echo ctrl-c ��1�ȊO�͏I�������Ă��������B
echo.
echo �T�[�o�̋N����A�u���E�U��
echo %server%:%port%
echo �Ɠ��͂����rfriends3�����s���܂��B
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
