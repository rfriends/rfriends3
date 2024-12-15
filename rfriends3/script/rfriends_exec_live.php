<?php
 require_once("rf_inc.php"); $rfriends_mes = "ラジオ録音ツール"; global $base; $fl = file_get_contents($base.$rfriends); echo_prn(2, $fl); $st_tm = start_prn(1, "Rfriends Live Start (rfriends_exec_live)"); echo_prn(2, ""); if ($argc != 2) { echo_prn(2, "rfriends_exec_live parameter error"); exit(8); } $opt = $argv[1]; echo_prn(2, $opt); echo_prn(2, ""); $p = explode(",",$opt); $ex_type = $p[0]; $channel = $p[1]; $flg = $p[2]; $authtoken = $p[3]; $url = $p[4]; if ($ex_type == 1) { $opt = "-headers X-Radiko-Authtoken:$authtoken"; } else { $opt = ""; } echo_prn(2, "userbuf : $ffplay_userbuf sec"); if ($ffplay_userbuf == 0) { $rtbuf = ""; } else { $rtbuf = sprintf("-rtbufsize %5d",$ffplay_userbuf * 1)."M"; } $xdg = ""; if (rfgw_is_rasp() !== false) { $uid = getmyuid(); if ($uid !== false) { $uid = trim($uid); $xdg = "export XDG_RUNTIME_DIR=/run/user/$uid; "; } else { echo_prn(2,"user_id not found (rpi)"); } } $optx = "$rtbuf $ffplay_useropt"; $pl = $xdg."ffplay $optx -window_title rfriends_$channel"; $expgm = "$pl $opt \"$url\""; echo_prn(2, $expgm); $ret = external_program($expgm); echo_prn(2, "ret : $ret"); $en_tm = start_prn(1, "Rfriends Live End"); rf_statistics($st_tm, $en_tm); exit(0); 