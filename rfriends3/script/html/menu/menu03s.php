<?php
 $ex_type = $ex_timefree; ht_subtitle($subno,""); switch ($subno) { case "0301": $ht_jump_btn2 = 1; $ht_jump_btn3 = 1; $ht_jump_btn1_label = "録音"; $ht_jump_btn2_label = "聴取"; $ht_jump_btn3_label = "聴取(サーバ)"; $r = rfmenu_rec_date_calc($ex_type); $ch = $val; $dt = $r[0]; $cnt = $r[1]; $dt = strtotime("$dt day"); ht_radiko_program("放送済番組一覧 [$ch] ",$multi_sw,$ch, $dt, $cnt); break; case "0302": $ht_jump_btn2 = 1; $ht_jump_btn3 = 1; $ht_jump_btn1_label = "録音"; $ht_jump_btn2_label = "聴取"; $ht_jump_btn3_label = "聴取(サーバ)"; ht_rec_kwsrc("検索結果",$multi_sw,$ex_type,$val,$val2); break; case "00303": if (is_array($val)) { $dat0 = $val; } else { $dat0[] = $val; } echo_msg(2, "録音日付"); if ($sel == 1) { $cnt = 1; $dt = ""; foreach($dat0 as $dat) { $dt0 = date("Ymd", $dat); echo_msg(2, "$dt0"); $dt .= $dt0."_"; } if ($dt == "") { echo_msg(2,"データがありません。"); break; } $dt = substr($dt,0,strlen($dt)-1); rf_batsh_rec($ex_type, 2, $dt, $cnt, ""); } else { $r = rfmenu_rec_date_calc($ex_type); $dt = $r[0]; $cnt = $r[1]; $fmt1 = rfmenu_rec_date_fmt($dt); $fmt2 = rfmenu_rec_date_fmt($dt+$cnt-1); rf_batsh_rec($ex_type, 1, $dt, $cnt, ""); echo_msg(2, "$fmt1 - $fmt2"); } echo_msg(2,""); echo_msg(2, "タイムフリー録音（キーワードファイル）を開始しました。"); break; case "0304": if ($sel == 1) { ht_webaudio($val,$timefree_recdir); } else if ($sel == 2) { ht_play_server($val,$timefree_recdir); } break; default: ht_development($subno,$val,2); break; } 