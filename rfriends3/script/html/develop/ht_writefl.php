<?php  $fl = $_POST['fl']; $txts = $_POST['txts']; echo_msg(2,"file : $fl"); echo_msg(2,""); $ret = file_put_contents($fl.".new",$txts,LOCK_EX); if ($ret === false) { echo_msg(2,"file put error ($fl.new)"); exit; } fin_unlink($fl.".bak"); echo_msg(2,"exit"); exit; $ret = rename($fl,$fl.".bak"); if ($ret === false) { echo_msg(2,"rename error ($fl => $fl.bak)"); exit; } $ret = rename($fl.".new",$fl); if ($ret === false) { echo_msg(2,"rename error ($fl.new => $fl)"); exit; } ?>
