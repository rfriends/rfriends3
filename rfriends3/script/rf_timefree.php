<?php
 function timefree_disp($timefreenw_dat) { global $ex_timefree; $lines = file($timefreenw_dat, FILE_IGNORE_NEW_LINES); sort($lines); $ex_type = $ex_timefree; $i2 = 0; $n = count_73($lines); echo_prn(1, ""); for ($i = 0; $i < $n; $i++) { $wdata = $lines[$i]; if (substr($wdata, 0, 1) == "#" || $wdata == "") { continue; } $i2 += 1; $para = get_para($wdata, $ex_type); $rsv_msg = ""; $fnm = get_fnam($para, $ex_type); $title = $para[7]; $kw = $para[10]; rf_reserve_disp($rsv_msg, $fnm, $title, $kw); } echo_prn(1, ""); echo_prn(1, "Program Count(s) : $i2"); return $i2; } function timefree_rsv_ex_file($timefree_dat, $kwdat,$kwdat_ng, $dt1, $cnt) { global $sort_flag; global $area_code; global $radiko_nhk; global $rsv_max; global $rsv_max_timefree; $rmax = $rsv_max_timefree; $rsvdata = radiko_rsv_ex($area_code, $kwdat,$kwdat_ng, $dt1, $cnt, 0, 0, 1,$rmax); if ($sort_flag == 1) { asort($rsvdata); } elseif ($sort_flag == 2) { ksort($rsvdata); } $now = time(); $wdat = array(); foreach ($rsvdata as $key => $val) { $wdata = $rsvdata[$key].PHP_EOL; $para = get_para($wdata, 5); $channel = strtoupper($para[6]); if (array_search($channel,$radiko_nhk) !== false) continue; $entm = $para[1]; $entime = get_mktime($entm) + 300; if ($now > $entime) { $wdat[] = $wdata; } } rf_put_wdat_all($timefree_dat, $wdat); $rsv_cnt = count_73($wdat); return $rsv_cnt; } function calc_timefree_timeout($duration) { global $tout_rate; global $tout_allow; $toutr = $tout_rate; if ($toutr < 1) { $toutr = 1; } if ($toutr > 100) { $toutr = 100; } $touta = $tout_allow; if ($touta < 0) { $touta = 0; } if ($touta > 3600) { $touta = 3600; } $tout = intval($duration/$toutr) + $touta; return $tout; } function timefree_kwrec_ex($timefree_dat, $chk) { global $rec_normal_end; global $rec_normal_end_plus; global $rec_already_exist; global $rec_not_deliver; global $rec_abnormal_end; global $timefree_sleep; global $timefree_radiko_del; global $scrdir; global $tmpdir; global $logdir; global $del_log; global $msg_level; global $auth_token; global $ex_timefree; global $area_code; global $premium_area; $cnt_normal_end = 0; $cnt_alredy_exist = 0; $cnt_not_deliver = 0; $cnt_abnormal_end = 0; $cnt_all = 0; $cnt_radiko_del = 0; if (file_exists($timefree_dat)) { $lines = file($timefree_dat, FILE_IGNORE_NEW_LINES); } else { echo_prn(1, "$timefree_dat file not found"); return false; } $title_flag = 1; $ffmpeg_ver = rfgw_info_ffmpeg(); $ex_type = $ex_timefree; $i2 = 0; $n = count_73($lines); for ($i = 0; $i < $n; $i++) { $wdata = $lines[$i]; if (substr($wdata, 0, 1) == "#") { continue; } if ($wdata == "") { continue; } $i2 += 1; $para = get_para($wdata, $ex_type); $nw = time(); if ($chk == 1) { $ret = timefree_check($nw, $para, 0); if ($ret != 0) { continue; } } $cnt_all++; $fn_head = make_fn("tf"); $fnm = get_fnam($para, $ex_type)."_".$fn_head; $recfiletemp = $tmpdir.$fnm; $reg_dur = $para[2]; $ret = rfriends_downloader($ex_type, $fnm, $reg_dur, $para, $title_flag, $ffmpeg_ver); $title_flag = 0; $smart_wait = 0; switch ($ret) { case $rec_normal_end: $cnt_normal_end++; $lines[$i]= "#"; $smart_wait = 1; break; case $rec_normal_end_plus; $cnt_normal_end++; $cnt_radiko_del++; $lines[$i]= "#"; $smart_wait = 1; break; case $rec_already_exist: $cnt_alredy_exist++; $lines[$i]= "#"; break; case $rec_not_deliver: $cnt_not_deliver++; $lines[$i]= "#"; break; case $rec_abnormal_end: default: $cnt_abnormal_end++; $smart_wait = 1; break; } $recfiletmp = $tmpdir.$fnm; fin_unlink("$recfiletmp.ttl"); fin_unlink("$recfiletmp.skp"); if (file_exists("$recfiletmp.can")) { fin_unlink("$recfiletmp.can"); fin_unlink($timefree_dat); echo_prn(1, ""); echo_prn(1, "##### timefree 録音を中止します。 #####"); exit; } if ($smart_wait == 1) { echo_prn(1, ""); time_prn(1, "sleep $timefree_sleep sec($ret)"); sleep($timefree_sleep); } } fin_unlink($timefree_dat); file_put_contents($timefree_dat, implode("\n", $lines), LOCK_EX); echo_prn(1, str_repeat("=", 80)); echo_prn(1,"正常終了 : $cnt_normal_end"); echo_prn(1,"録音済   : $cnt_alredy_exist"); echo_prn(1,"配信なし : $cnt_not_deliver"); echo_prn(1,"異常終了 : $cnt_abnormal_end"); echo_prn(1,"計       : $cnt_all"); if (($timefree_radiko_del == 1) || ($timefree_radiko_del == 2)) { echo_prn(1, ""); echo_prn(1, "radiko 削除 : $cnt_radiko_del"); } if (($timefree_radiko_del == 3) || ($timefree_radiko_del == 4)) { echo_prn(1, ""); echo_prn(1, "radiko 移動 : $cnt_radiko_del"); } return true; } function timefree_check($nw, $para, $mes) { global $ex_timefree; global $t_rmargin; global $timefree_ng_rec; global $tf_footer; global $rec_normal_end; global $rec_already_exist; global $rec_not_deliver; global $rec_abnormal_end; global $rec_extension; global $failed_record_flag; global $in_ng_flag; global $out_ng_flag; global $loghead_abnormal; $totime = $para[1]; $failed_record = $para[3]; $in_ng = $para[4]+0; $out_ng = $para[5]+0; $recdir = get_recdir(5); $ng = set_ng($failed_record, $in_ng, $out_ng); $output = fnam_edit($ex_timefree,$para); $recf = $ng.$output.$tf_footer; $recfile = $recdir.$recf; $ext = $rec_extension; $t_rgtime = get_mktime($totime) + $t_rmargin; $df = $t_rgtime - $nw; if ($df > 0) { if ($mes == 1) { echo_prn(1, "not yet delivered($df)"); } return $rec_not_deliver; } echo_prn(1, "ng_head : $ng"); echo_prn(1, "program : $failed_record $in_ng $out_ng"); echo_prn(1, "valid   : $failed_record_flag $in_ng_flag $out_ng_flag"); echo_prn(1, ""); if ($failed_record > $failed_record_flag || $in_ng > $in_ng_flag || $out_ng > $out_ng_flag) { echo_prn(1, "Delivery error"); return $rec_normal_end; } return $rec_normal_end; } function get_timefree_stream_url($channel, $fromtime, $totime, $recfiletmp, $authtoken,$org) { global $timefree_pre_margin; global $timefree_post_margin; global $m3u8header; global $playlisturl; global $playlisturl2; global $auth_token; global $ui_mode; $stream_url = ""; if ($timefree_pre_margin == 0 && $timefree_post_margin == 0) { $rectime = "$channel&ft=$fromtime&to=$totime"; } else { $t_fr = get_mktime($fromtime) - $timefree_pre_margin; $t_to = get_mktime($totime) + $timefree_post_margin; $t_fr2 = date("YmdHis", $t_fr); $t_to2 = date("YmdHis", $t_to); $rectime = "$channel&ft=$t_fr2&to=$t_to2"; } $purl = $playlisturl.$rectime; if ($org == 1) { return $purl; } file_put_contents("$recfiletmp.txt", $purl, LOCK_EX); $opt = $m3u8header . "--header=\"X-Radiko-AuthToken: $authtoken\" "; $exec_cmd = "wget -i $recfiletmp.txt -O $recfiletmp.m3u8 $opt "; $ret = external_program($exec_cmd); if ($ret != 0) { fin_unlink("$recfiletmp.txt"); fin_unlink("$recfiletmp.m3u8"); return $stream_url; } fin_unlink("$recfiletmp.txt"); $url = file("$recfiletmp.m3u8"); foreach ($url as $value) { if (substr($value, 0, 1) == "#") { continue; } if (substr($value, 0, 4) == "http" && strpos($value, "m3u8") !== false) { $value = str_replace(array("\r", "\n"), "", $value); $stream_url = $value; break; } } if ($stream_url == "") { return $stream_url; } fin_unlink("$recfiletmp.m3u8"); return $stream_url; } function timefree_start($mes) { echo_prn(1,str_repeat("#",100)); $st_tm = start_prn(1, $mes); return $st_tm; } function timefree_end($st_tm,$timefreenw_dat,$mes) { fin_unlink($timefreenw_dat); $en_tm = start_prn(1, $mes); echo_prn(1,str_repeat("#",100)); echo_prn(1, ""); rf_statistics($st_tm, $en_tm); } function timefree_go($area_code, $timefreenw_dat, $kwdat1,$kwdat1_ng, $dt, $cnt) { global $nowarea; global $area_code; global $rftrans; global $rftrans_timefree; global $ex_timefree; $pref = rf_edit_area($area_code); $narea = "$area_code,$pref($area_code)"; $kwcnt = count_73($kwdat1); if ($kwcnt == 0) { echo_prn(1, ""); echo_prn(1, "キーがありません。"); return false; } $nmax = timefree_rsv_ex_file($timefreenw_dat, $kwdat1,$kwdat1_ng, $dt, $cnt); $i2 = timefree_disp($timefreenw_dat); start_prn(1, "TimeFreeRec Start"); $ret = timefree_kwrec_ex($timefreenw_dat, 0); start_prn(1, "TimeFreeRec End"); echo_prn(2, " "); echo_prn(2, "[ 異常終了分を再実行します。]"); $i2 = timefree_disp($timefreenw_dat); if ($i2 > 0) { start_prn(1, "TimeFreeRec Start"); $ret = timefree_kwrec_ex($timefreenw_dat, 0); start_prn(1, "TimeFreeRec End"); } return; } function timefree_ex($dtdate,$cnt) { global $nowarea; global $area_code; global $rftrans; global $rftrans_timefree; global $ex_timefree; global $tmpdir; global $premium_areafree; global $premium_home_area_code; $ex_type = $ex_timefree; $dt = strtotime($dtdate); $ver = "2.1.0"; $start_mes = "Rfriends(tf $ver) timefree Start [$dtdate - $cnt]"; $end_mes = "Rfriends(tf $ver) timefree End   [$dtdate - $cnt]"; rf_error_log($start_mes); $st_tm = timefree_start($start_mes); $head = "timefree_area"; $fn = make_fn("rfriends_timefree"); $timefreenw_dat = $tmpdir.$fn.".dat"; echo_prn(1, " "); echo_prn(1, $timefreenw_dat); if (premium_check() > 0 && $premium_areafree == 1) { $area_code = $premium_home_area_code; $pref = rf_edit_area($area_code); $narea = "$area_code,$pref"; $secmes = "ラジコプレミアム  メインステーション : $narea"; rf_disp_section($secmes, "+"); } else { $pref = rf_edit_area($area_code); $narea = "$area_code,$pref"; $secmes = "ラジコ : $narea"; rf_disp_section($secmes, "+"); } $main_area = $area_code; $kwdat1_ng = merge_keyword($ex_timefree,1); $kwdat1 = merge_keyword($ex_timefree,0); echo_prn(2, ""); timefree_go($area_code, $timefreenw_dat, $kwdat1,$kwdat1_ng, $dt, $cnt); fin_unlink($timefreenw_dat); if (premium_check() < 1 || $premium_areafree == 0) { timefree_end($st_tm, $timefreenw_dat, $end_mes); rf_error_log($end_mes); return; } $sta = rf_get_keyword('premium_station'); if (count_73($sta) == 0) { echo_prn(1, "premium_station が定義されていません。"); timefree_end($st_tm, $timefreenw_dat, $end_mes); rf_error_log($end_mes); return; } echo_prn(2, ""); foreach ($sta as $area) { $no = rf_convjp($area); if ($no == 0) { echo_prn(1, "premium_station 設定エラー ($area)"); continue; } $area_code = $area; $pref = rf_edit_area($area_code); $narea = "$area,$pref"; $secmes = "ラジコプレミアム  ステーション  : $narea"; rf_disp_section($secmes, "+"); if ($area == $main_area) { echo_prn(1, "このエリアは main_station と重複しています。"); } $area = strtolower($area_code); $parea = "premium_$area"; echo_prn(2, ""); $kwdat1_ng = merge_keyword_area($area_code, $ex_timefree,1); $kwdat1 = merge_keyword_area($area_code, $ex_timefree,0); timefree_go($area_code, $timefreenw_dat, $kwdat1,$kwdat1_ng, $dt, $cnt); fin_unlink($timefreenw_dat); } timefree_end($st_tm, $timefreenw_dat, $end_mes); rf_error_log($end_mes); return; } 