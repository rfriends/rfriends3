#!/bin/bash
# =========================================
# install rfriends for ubuntu
# =========================================
# 1.0 2025/01/03 new
ver=1.0
echo start $ver
echo
# -----------------------------------------
optlighttpd="on"
optsamba="on"
export optlighttpd
export optsamba
#
sh ubuntu_install.sh 2>&1 | tee ubuntu_install.log
# -----------------------------------------
# finish
echo
echo finished
# -----------------------------------------
