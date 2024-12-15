@echo off
rem -----------------------------------------
rem Rfriends
rem 
rem 2017/11/05 by mapi
rem -----------------------------------------
cd /d %~dp0
set base=%CD%\
set ver=%base%_Rfriends3
if exist %ver% goto st

echo %ver% ファイルがありません
echo ディレクトリ構成が間違っています。
echo.
pause
exit

:st
rem type %ver%
rem echo ベースディレクトリは　%base% です。
rem 
title %ver%

rem
rem color 1F

cls
%base%bin\php\php %base%script\rf_gdriveinit.php

echo done
pause
exit
