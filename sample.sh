#!/bin/bash
# =========================================
# install rfriends for linux
#
# sample.sh
#
# 1.0 2025/01/23 new
# =========================================
ver=1.0
echo start $ver
echo
# -----------------------------------------
distro=ubuntu
cmd=apt-get
optlighttpd="on"
optsamba="on"
# -----------------------------------------
export distro
export cmd
export optlighttpd
export optsamba
#
rm -rf rfriends3
git clone http://github.com/rfriends/rfriends3.git
cd rfriends3
sh install_rfriends3.sh 2>&1 | tee install_rfriends3.log
mv rfriends3 ../../
# -----------------------------------------
# finish
echo
echo finished
# -----------------------------------------
