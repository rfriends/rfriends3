@echo off
rem -----------------------------------------
rem Rfriends
rem 
rem 2017/11/05 by mapi
rem -----------------------------------------
cd /d %~dp0
set base=%CD%\

%base%bin\php\php %base%script\rf_up.php
echo done
pause
exit
