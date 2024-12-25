<?php
 $ex_type = ""; ht_subtitle($subno,""); switch ($subno) { case "010101": echo_msg(2, "録音を中止します。"); echo_msg(2,""); $dat0 = ht_set_val($val); foreach($dat0 as $dat) { echo_msg(2, "$dat"); rfmenu_rec_abort_ex($dat); } echo_msg(2, ""); echo_msg(2, "録音を中止しました。"); break; case "010102": echo_msg(2, "再生を中止します。"); echo_msg(2,""); $dat0 = ht_set_val($val); $piddata = $dat0; rf_ffplay_pid_can($piddata); echo_msg(2, ""); echo_msg(2, "再生を中止しました。"); break; case "010103": if ($val2 == 1) { echo_msg(2, "再生音量を設定します。(amixer)"); $dev = rf_amixer_get_dev(); if ($dev == '') { echo_msg(2,"sound device not found"); break; } $cmd = "amixer sset $dev $val"."%"; echo_msg(2,""); $outs = external_exec($cmd); foreach($outs as $out) { echo_msg(2,$out); } echo_msg(2,""); $ht_jump_addr = "menu_s.html"; $ht_jump_no = "010103"; $sno = "s01c"; $ty = 1; ht_audio_volume_amixer(); } else if ($val2 == 2) { echo_msg(2, "再生音量を設定します。(ncpamixer)"); echo_msg(2,""); echo_msg(2,"音量 : $val"); $val = floor($val / 10); if ($val < 0) $val = 0; if ($val > 9) $val = 9; $cmd = "echo $val"."q | ncpamixer > /dev/null 2>&1"; $outs = external_exec($cmd); } else { echo_msg(2, ""); echo_msg(2, "音量設定を中止しました。"); break; } echo_msg(2, ""); echo_msg(2, "再生音量を設定しました。"); break; case "010202": $ht_jump_btn2 = 1; $ht_jump_btn1_label = "再生/表示"; $ht_jump_btn2_label = "download"; ht_sel_usrdir($usrdir,$val,0,0,0); break; case "010203": $ht_jump_btn1_label = "削除"; ht_sel_usrdir($usrdir,$val,1,1,0); break; case "0103": if (isset($_POST['check']) && is_array($_POST['check'])) { $check = $_POST['check']; } else { $check = array(); } $v = array(); for($i=0;$i<7;$i++) $v[$i] = 0; foreach($check as $chk) { if($chk < 0) continue; if($chk > 6) continue; $v[$chk] = 1; } $ex = ""; for($i=0;$i<6;$i++) { $ex .= $v[$i].","; } $ex .= $v[6]; if ($ex == '0,0,0,0,0,0,0') { echo_msg(2,"デイリー処理が選択されていません。"); break; } echo_msg(2,"デイリー処理($ex)を開始しました。"); rf_batsh_rec($ex_daily, $ex, 0, 0, 0); echo_msg(2,""); echo_msg(2,"処理はバックグラウンドで行います。"); break; case "010401": echo_msg(2,"重複データ（完全）の移動を開始しました。"); rf_error_log("remove_duplicate(full)"); $ex = "ex_rfriends"; $opt = "16 1"; rfgw_batsh_sub($scrdir, $ex, $opt, 1, 1); echo_msg(2,""); echo_msg(2,"処理はバックグラウンドで行います。"); echo_msg(2,"$logdir : duplicate"); break; case "010402": echo_msg(2,"重複データ（部分）の移動を開始しました。"); rf_error_log("remove_duplicate(part)"); $ex = "ex_rfriends"; $opt = "16 2"; rfgw_batsh_sub($scrdir, $ex, $opt, 1, 1); echo_msg(2,""); echo_msg(2,"処理はバックグラウンドで行います。"); echo_msg(2,"$logdir : duplicate"); break; case "010403": echo_msg(2,"重複データを削除します。"); rfmenu_info_double_del_s(); break; case "0105": echo_msg(2,"番組配送処理を実行しました。( $val )"); rfmenu_info_delivery_s($val); break; case "0106": $ans1 = "dummy"; $nam = "rfriends_exec_backup"; $opt = "15 \"$ans1\""; $ex = "ex_rfriends"; rfgw_batsh_sub($scrdir, $ex, $opt, 1, 1); echo_msg(2, " バックアップ処理を開始しました。"); break; case "010701": ht_subtitle("010701",""); $ret = rf_network_test($val,0); echo_msg(2, ""); if ($ret == 0) { echo_msg(2, "接続テストを正常終了しました。"); } else { echo_msg(2, "接続テストを異常終了しました。"); } break; case "010702": ht_subtitle("010702",""); switch($val) { case 1: echo "<p>領域拡張を行います。</p>"; echo "<p></p>"; echo "<p>使用しているmicroSDを最大まで拡張する処理です。</p>"; echo "<p></p>"; echo "<p>Raspberry Piの緑色のランプが消えて、再起動すると「再度」緑色のランプが点灯します。</p>"; echo "<p>その後、緑色のランプが点滅し領域拡張を行います。</p>"; echo "<p>拡張処理にはmicroSDの容量が大きいほど時間がかかります。</p>"; echo "<p>32GBのmicroSDで約2分</p>"; break; case 2: echo "<p>Raspberry Piのシャットダウンを行います</p>"; echo "<p></p>"; echo "<p>Raspberry Piの緑色のランプが消えるまでお待ちください。</p>"; break; case 3: echo "<p>Raspberry Piの再起動を行います。</p>"; echo "<p></p>"; echo "<p>Raspberry Piの緑色のランプが消えて、「再度」緑色のランプが点灯するまでお待ちください。</p>"; echo "<p>約1-2分</p>"; break; case 4: echo "<p>Swap領域のクリアを行います。</p>"; echo "<p></p>"; $out = cmd_prn(2,"memory","free -k"); if ($out === false) { echo "<p>free コマンドエラー</p>"; break; } $out = str_replace("\n","<br/>",$out); echo_msg(2, "<p>$out</p>"); echo "<p></p>"; $p = strpos($out,'Swap:'); if ($p === false) { echo "<p>Swap コマンドエラー</p>"; echo "<p>処理を中止します。(1)</p>"; break 2; } $out2 = substr($out,$p); $out3 = preg_replace('/\s+/', ' ', $out2); $swapdat = explode(' ',$out3); $cnt = count_73($swapdat); if ($cnt != 4) { echo "<p>Swap コマンドエラー</p>"; echo "<p>処理を中止します。(2)</p>"; break 2; } if ($swapdat[1] == 0) { echo "<p>Swap領域が設定されていません。</p>"; echo "<p>処理を中止します。</p>"; break 2; } if ($swapdat[2] == 0) { echo "<p>Swap領域が未使用です。</p>"; echo "<p>処理を中止します。</p>"; break 2; } echo "<p>Swap領域をクリアします。</p>"; break; case 5: echo "<p>hostnameの変更をおこないます。</p>"; echo "<p>&nbsp;</p>"; $out = cmd_prn(2,"hostname","cat /etc/hostname"); if ($out === false) { echo "<p>hostname1 コマンドエラー</p>"; break 2; } $hname = str_replace("\n","",$out); echo_msg(2, "<p>現在のhostname : $hname</p>"); break; case 6: echo "<p>audio cardの選択をおこないます。</p>"; echo "<p>&nbsp;</p>"; $ht_jump_no = "01070206"; $ht_jump_btn1_label = "選択"; $cards = ht_get_asound_list(); if (count_73($cards) <= 0) { echo "<p>サウンドカードがみつかりません。</p>"; break 2; } $lists = array(); foreach($cards as $card) { $cdat = explode(',',$card); $lists[] = array('title'=>"$cdat[0] : $cdat[1]",'val'=>$cdat[0]); } $n = ht_now_asound_no(); $opt = array( "title" => "audio card一覧(現在 : $n)", "mode" => 1, "multi" => 0, "confirm" => 0, "ht_selid" => "" ); ht_ask_list($lists,$opt); break 2; default: break; } if ($val == 5) { echo <<<EOF1
<form method='get' action='menu_ss.html' style='width=400'>
New hostname : <INPUT type=text name='val2' value='$hname' style='border:1px solid'>
<li><br/>変更しますか?&nbsp&nbsp&nbsp;</li>
<p><br><button class='btn_ex' type='submit'>変更</button></p>
<INPUT type='hidden' name='subno' value='010702'>
<INPUT type='hidden' name='val'   value=$val>
<INPUT type='hidden' name='sno'   value='s07'>
</form>
<li>&nbsp;</li>
<li>&nbsp;</li>
EOF1;
} else { echo <<<EOF2
<form method='get' action='menu_ss.html'>
<li><br/>実行しますか?&nbsp&nbsp&nbsp;</li>
<p><br><button class='btn_ex' type='submit'>実行</button></p>
<INPUT type='hidden' name='subno' value='010702'>
<INPUT type='hidden' name='val'   value=$val>
<INPUT type='hidden' name='val2'  value=''>
<INPUT type='hidden' name='sno'   value='s07'>
</form>
<li>&nbsp;</li>
<li>&nbsp;</li>
EOF2;
} break; case "010703": ht_subtitle("010703",""); switch($val) { case 1: $ht_jump_val2 = 1; ht_headless_test(); break; case 2: $ht_jump_val2 = 2; ht_rss_test(); break; case 3: $ht_jump_val2 = 3; ht_audio_test(); break; case 4: $ht_jump_val2 = 4; ht_audio_volume_amixer(); break; case 5: $ht_jump_val2 = 5; ht_rasp_expand(); break; case 6: $ht_jump_val2 = 6; ht_get_program(); break; case 7: $ht_jump_val2 = 7; ht_get_server(); break; case 8: $ht_jump_val2 = 8; echo_msg(2,""); phpinfo(); break; case 9: $ht_jump_val2 = 9; rfmenu_info_service(); break; case 10: $ht_jump_val2 = 10; ht_input_cmd(); break; default: break; } break; default: ht_development($subno,$val,2); break; } 