<?php
 $val = ""; switch ($sno) { case "s01": ht_subtitle("0801",""); $val = "station"; break; case "s02": ht_subtitle("0802",""); $val = "common"; break; case "s03a": ht_subtitle("080301",""); $val = "radiko"; break; case "s03b": ht_subtitle("080302",""); $val = "timefree"; break; case "s03c": ht_subtitle("080303",""); $val = "premium"; break; case "s04a": ht_subtitle("080401",""); $val = "radiru"; break; case "s04b": ht_subtitle("080402",""); $val = "radiru_other"; break; case "s04c": ht_subtitle("080403",""); $val = "radiru_vod"; break; case "s04d": ht_subtitle("080404",""); $val = "radiru_gogaku"; break; case "s05": ht_subtitle("0805",""); $val = "program"; break; case "s06": ht_subtitle("0806",""); $val = "delivery"; break; case "s07a": ht_subtitle("080701",""); rfmenu_kw_manage_ex(1); return; break; case "s07b": ht_subtitle("080702",""); $ht_jump_btn1_label = "復元"; rfmenu_kw_manage_ex(2); return; break; case "s07c": ht_subtitle("080703",""); rfmenu_kw_manage_ex(3); return; break; case "s07d": ht_subtitle("080704",""); rfmenu_kw_manage_ex(4); return; break; default: return; break; } if ($val != "") { $kwn = $kw_name_dat[$val]; $fl = $usrdir."kw/".$kw_dat[$val]; $ht_jump_val = $val; ht_textedit($fl,0,0); } 