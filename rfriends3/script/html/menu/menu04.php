<?php
 $ex_type = $ex_radiru; switch ($sno) { case "s01": ht_subtitle("0401",""); $ht_jump_btn1_label = "削除"; rfmenu_rec_dsp($ex_type,0); break; case "s02": ht_subtitle("0402","($radiru_area_1)"); $ht_jump_btn1_label = "録音予約"; rfmenu_rec_today($ex_type, ""); break; case "s03": ht_subtitle("0403","($radiru_area_1)"); $ht_jump_btn1_label = "選択"; $ch = rfmenu_rec_ch($ex_type); if ($ch == "") { break; } if ($ch !== false) { rfmenu_rec_ch_ex($ex_type, $ch); } break; case "s04": ht_subtitle("0404",""); rfmenu_rec_kwsrc($ex_type); break; case "s05": ht_subtitle("0405",""); echo_msg(2, "キーワードを元に番組予約を行います。"); echo_msg(2, ""); ht_yesno("実行しますか?"); break; case "s06": ht_subtitle("0406",""); echo_msg(2, "キーワードを元に番組予約リスト作成を行います。"); echo_msg(2, " 実際の予約はしません。"); echo_msg(2, ""); ht_yesno("実行しますか?"); break; case "s07": ht_subtitle("0407",""); echo_msg(2, "エリア変更を行います。"); $ht_jump_btn1_label = "選択"; rfmenu_radiru_area(); rf_pause(); break; case "s08": ht_subtitle("0408",""); $ht_jump_btn1_label = "聴取"; $ht_jump_btn2 = 1; $ht_jump_btn2_label = "聴取(サーバ)"; rfmenu_onair($ex_type); break; case "s09": ht_subtitle("0409",""); $ht_jump_btn2 = 1; $ht_jump_btn1_label = "再生"; $ht_jump_btn2_label = "再生(サーバ)"; rf_menu_play($ex_type); break; default: break; } 