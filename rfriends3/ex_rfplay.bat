@echo off
rem -----------------------------------------
rem Rfriends
rem 
rem 2017/11/05 by mapi
rem -----------------------------------------
rem 録音ツール 2021/04/10
rem
rem ex_rfriends.bat "menu,ui,height,width"
rem
rem menu 0:normal 1:lite
rem menu 0:cui
rem height 20-100
rem width 50-200
rem
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
rem %base%bin\php\php %base%script\rfriends_check.php
rem if %errorlevel% neq 0 (
rem 	pause
rem 	exit
rem )
rem
rem color 1F
:loop
cls
%base%bin\php\php %base%script\play\rfplay.php %1
rem pause
if %errorlevel% equ 0 (
	goto loop
)
echo done
pause
exit
