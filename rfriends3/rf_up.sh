#!/bin/sh
# 録音ツール
cd `dirname $0`
base=`pwd`/

ex=rf_up
php ${base}script/$ex.php

echo done
