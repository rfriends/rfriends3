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

echo %ver% �t�@�C��������܂���
echo �f�B���N�g���\�����Ԉ���Ă��܂��B
echo.
pause
exit

:st
rem type %ver%
rem echo �x�[�X�f�B���N�g���́@%base% �ł��B
rem 
title %ver%

rem
rem color 1F

cls
%base%bin\php\php %base%script\rf_gdriveinit.php

echo done
pause
exit
