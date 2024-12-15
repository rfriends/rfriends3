<?php
 $fn_p = "rfriends.ini"; $fn_t = "rfriends_tag.ini"; switch ($sno) { case "s01a": ht_subtitle("090101",""); rfmenu_info_ini(); break; case "s01b": ht_subtitle("090102",""); $fn = "rfriends.ini"; $fl = $cfgdir.$fn; ht_textedit($fl,0,0); break; case "s01c": ht_subtitle("090103",""); rfmenu_info_ini_check(1); break; case "s01d": ht_subtitle("090104",""); break; case "s02a": ht_subtitle("090201",""); rfmenu_info_tag(); break; case "s02b": ht_subtitle("090202",""); $fn = "rfriends_tag.ini"; $fl = $cfgdir.$fn; ht_textedit($fl,0,0); break; case "s02c": ht_subtitle("090203",""); rfmenu_info_ini_check(2); break; case "s03a": ht_subtitle("090301","(WIN)"); echo_msg(2, "登録すると毎日自動で予約処理(radiko,radiru)と録音(timefree他)を行います。"); echo_msg(2, "実行時間の変更については、パラメータ設定を変更し、再度登録することで可能です。"); echo_msg(2, "実行1 : $sch_daily"); echo_msg(2, "実行2 : $sch_daily2"); ht_yesno("実行しますか？"); break; case "s03b": ht_subtitle("090302","(WIN)"); echo_msg(2,"デイリー処理の登録を取り消します。"); ht_yesno("実行しますか？"); break; case "s03c": ht_subtitle("090301","(OSX)"); $st = get_plist_crontab_osx(); if ($st === false) { echo_msg(2, "現在、デイリー処理は未登録です。"); } else { echo_msg(2, "現在、デイリー処理は $st[0]:$st[1] で登録済です。"); } echo_msg(2, ""); echo_msg(2, "登録すると毎日自動で予約処理(radiko,radiru)と録音(timefree)を行います。"); echo_msg(2, ""); ht_yesno("実行しますか？"); break; case "s03d": ht_subtitle("090302","(OSX)"); $st = get_plist_crontab_osx(); if ($st === false) { echo_msg(2, "現在、デイリー処理は未登録です。"); } else { echo_msg(2, "現在、デイリー処理は $st[0]:$st[1] で登録済です。"); } echo_msg(2, ""); echo_msg(2, "デイリー処理の登録を取り消します。"); echo_msg(2, ""); ht_yesno("実行しますか？"); break; case "s03e": ht_subtitle("090301","設定ファイル(crontab)編集・登録"); rf_get_crontab(); rf_append_crontab(); $ht_jump_btn1_label = "crontab登録"; $fl = $cfgdir.$crontabtxt; ht_textedit($fl,0,0); break; case "s03f": ht_subtitle("090302","設定ファイル(crontab)初期化"); echo_msg(2, ""); echo_msg(2, "設定ファイル(crontab)初期化します。"); echo_msg(2, ""); ht_yesno("実行しますか？"); break; case "s04a": ht_subtitle("090401",""); $fn = "radiko_callsign.csv"; $fl = $cfgdir.$fn; ht_textedit($fl,0,0); break; case "s04b": ht_subtitle("090402",""); $fn = "radiru_callsign.csv"; $fl = $cfgdir.$fn; ht_textedit($fl,0,0); break; case "s04c": ht_subtitle("090403","(ex:20220102,JP13)"); echo_msg(2,"この機能はデバッグ用です。入力データのチェック等は行っていません。"); ht_input("日付(yyyymmdd), areacode(JPXX)を入力してください : ",0); break; case "s04d": ht_subtitle("090404","(ex:20220102,130,r3)"); echo_msg(2,"この機能はデバッグ用です。入力データのチェック等は行っていません。"); echo_msg(2,""); echo_msg(2,"areakey : 札幌010,仙台040,東京130,名古屋230,大阪270,広島340,松山380,福岡400"); echo_msg(2,"netch : r1,r2,r3"); ht_input("日付(yyyymmdd), areakey, netchを入力してください : ",0); break; case "s04e": ht_subtitle("090405",""); $fn = "radiko_genre.dat"; $fl = $scrdir.$fn; ht_textdisp($fl,0,0); break; case "s04f": ht_subtitle("090406",""); $fn = "radiru_genre.dat"; $fl = $scrdir.$fn; ht_textdisp($fl,0,0); break; case "s04g": ht_subtitle("090407",""); $fn = "applepodcasts.dat"; $fl = $scrdir.$fn; ht_textdisp($fl,0,0); break; case "s04h": ht_subtitle("090408",""); $fn = "dirindex.css"; $fl = $cfgdir.$fn; ht_textedit($fl,0,0); break; case "s05a": ht_subtitle("090501",""); rfmenu_mail_ex(1); break; case "s05b": ht_subtitle("090502",""); $fn = "sendmail.ini"; $fl = $cfgdir.$fn; ht_textedit($fl,0,0); break; case "s05c": ht_subtitle("090503",""); rfmenu_mail_ex(3); break; case "s05d": ht_subtitle("090504",""); rfmenu_mail_ex(4); break; case "s06": ht_subtitle("0906",""); rfmenu_usrdir(); break; case "s07a": ht_subtitle("090701",""); if (ht_premium() === false) break; echo_msg(2, ""); $msg = "ラジコプレミアムに強制再ログインしますか? (y/N): "; $ans = echo_yesno(2, $msg); break; case "s07b": ht_subtitle("090702",""); $fn = "premium.ini"; $fl = $cfgdir.$fn; ht_textedit($fl,0,0); break; case "s08a": ht_subtitle("090801",""); rfmenu_setting_ex(1); break; case "s08b": $ht_jump_btn1_label = "復元"; ht_subtitle("090802",""); rfmenu_setting_ex(2); break; case "s08c": ht_subtitle("090803",""); echo_msg(2,"初期化する設定を選択してください。"); echo_msg(2,""); rfmenu_setting_ex(3); break; default: break; } 