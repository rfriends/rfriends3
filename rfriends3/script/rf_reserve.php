<?php
 function at_reserve($ex_type, $tn, $stt, $fnm, $wdata,$mode) { global $rsvdir; global $scrdir; global $logdir; global $tmpdir; global $DS; global $wake_to_run; global $msg_level; global $base; global $standby_time; global $standby_time_m; global $at_que_no; global $ex_radiko; global $ex_radiru; global $ex_timefree; global $ex_radiru_vod; $nwt = time(); $nowsec = date("s", $nwt) + 0; $nw = strtotime(date("YmdHi00", $nwt)) + 60; if ($nowsec > 50) { $nw = $nw + 60; } $st = strtotime(date("YmdHi00", $stt)); if ($mode == 0) { $stsec = $standby_time * 60; } else { $stsec = $standby_time_m * 60; } $sttime = $st - $stsec; if ($sttime < $nw) { $oldst = date("Y/m/d H:i:s", $sttime); $newst = date("Y/m/d H:i:s", $nw); $sttime = $nw; } $lf = PHP_EOL; $ret = rf_put_wdata($fnm, $wdata); if ($ret == false) { echo_msg(2, "Reservation failure : $fnm"); return 1; } $bs = rfgw_ext_batsh($fnm); $bsdat = rfgw_get_batsh($ex_type, $fnm); if (file_put_contents($bs, $bsdat, LOCK_EX) === false) { echo_msg(2, "Reservation failure : $bs"); return 1; } $pm = 0755; $ret = rfgw_chmod($bs,$pm); $exque = get_at_que_no($at_que_no); if ($ex_type == $ex_radiko || $ex_type == 3) { $atqueno = $exque[0]; } else { $atqueno = $exque[1]; } $ret = rfgw_at_reserve($tn, $atqueno, $sttime, $fnm, $bs); return $ret; } function rf_set_genre($ex_type,$genre,$genrec) { global $ex_radiko; global $ex_radiru; global $ex_timefree; global $ex_radiru_vod; global $ex_radiru_gogaku; global $radiru_genre_db; $gen = $genre; switch($ex_type) { case "$ex_radiko": case "$ex_timefree": if ($genrec == ";" || $genrec == "") return $gen; $gen = $genre." ".$genrec; break; case "$ex_radiru": if ($genre == ";" || $genre == "") return $gen; $gr = explode(",",$genre); $gen = ""; foreach($gr as $g) { $g = strtoupper(trim($g)); if (array_key_exists($g,$radiru_genre_db)) { $g2 = ",".$radiru_genre_db[$g]; } else { $g2 = ",????"; } $gen .= " ".$g.$g2; } $gen = substr($gen,1); break; default: $gen = ""; break; } return $gen; } function rf_get_radiru_genre($st) { if (!array_key_exists("genre",$st)) return ""; $rg1 = $st["genre"]; if (!is_array($rg1)) return "g".$rg1; if (count_73($rg1) <= 0) return ""; $rg3 = ""; foreach($rg1 as $rg2) { $rg3 .= ",g".$rg2; } return substr($rg3,1); } function rf_compare_rexp($xml, $kw) { global $strip_tags_flag; global $strip_space_flag; global $stripos_flag; $xml2 = $xml->asXML(); $xml2 = str_replace(array("\r\n", "\r", "\n"), '', $xml2); if ($strip_space_flag == 1) { $xml2 = rf_strip_space($xml2); } if ($strip_tags_flag == 1) { $xml2 = rf_strip_tags($xml2); } $regs = array(); $kw2 = substr($kw,1); if ($stripos_flag == 1) { $ret = @mb_eregi($kw2, $xml2, $regs); } else { $ret = @mb_ereg($kw2, $xml2, $regs); } if ($regs == array()) { return null; } return $regs[0]; } function rf_get_kw($kw) { $b_kw = array(); $a_kw = explode(",", $kw); foreach ($a_kw as $kw) { $val = trim($kw); if (strlen($val) == 0) { return null; } $flag = substr($val, 0, 1); if (strlen($val) == 1) { if ($flag == "!" || $flag == "+" || $flag == "@") { return null; } } if ($flag == "!" || $flag == "+" || $flag == "@") { $val = trim(substr($val, 1)); } else { $flag = ""; } $b_kw[] = array($flag,$val); } if (count_73($b_kw) == 0) { return null; } return $b_kw; } function rf_compare_ttl($ttl, $kw) { $hit = 0; if ($kw == "") { return null; } $b_kw = rf_get_kw($kw); if ($b_kw == null) { return null; } foreach ($b_kw as $value) { $flag = $value[0]; $val = $value[1]; $xml2 = array("title" => $ttl); $key = rf_compare($xml2, $val); if ($flag == "!") { if ($key != null) { return null; } } else { if ($key == null) { return null; } } } if (count_73($b_kw) == 1) { $hit = $key; } else { $hit = "multi"; } return $hit; } function rf_compare_multi_dlvy($xml, $kw) { if ($kw == "*") { $hit = "all"; return $hit; } $hit = rf_compare_multi($xml, $kw); return $hit; } function rf_hit($prog_org,$prog,$kwdat,$kwdat_ng) { $hit = ""; foreach ($kwdat_ng as $kw) { if ($kw == "") { continue; } if (substr($kw, 0, 1) == "/") { $hit = rf_compare_rexp($prog_org, $kw); } else { $hit = rf_compare_multi($prog, $kw); } if ($hit != "") { break; } } if ($hit != "") return ""; $hit = ""; foreach ($kwdat as $kw) { if ($kw == "") { continue; } if (substr($kw, 0, 1) == "/") { $hit = rf_compare_rexp($prog_org, $kw); } else { $hit = rf_compare_multi($prog, $kw); } if ($hit != "") { $hit = $hit.":".fn_edit($kw); break; } } return $hit; } function rf_compare_multi($xml, $kw) { if ($kw == "") return ""; $b_kw = rf_get_kw($kw); if (is_null($b_kw)) return ""; $selch = ""; foreach ($b_kw as $value) { $flag = $value[0]; $val = $value[1]; switch($flag) { case "+": $ttl = $xml["title"]; $xml2 = array("title" => $ttl); $key = rf_compare($xml2, $val); if (is_null($key)) return ""; break; case "@": $ch = $xml["ch"]; $chx = explode(",",$ch); $v2 = strtoupper($val); if (count_73($chx) <= 1) { if (strtoupper($ch) != $v2) return ""; $key = "CH"; break; } foreach($chx as $chx2) { if (strtoupper($chx2) == $v2) { $key = "CH"; $chx2 = strtolower($chx2); $selch = "_".$chx2."_($ch)"; break 2; } } return ""; break; default: $key = rf_compare($xml, $val); if ($flag == "!") { if (!is_null($key)) return ""; } else { if (is_null($key)) return ""; } break; } } if (count_73($b_kw) == 1) { $hit = $key; } else { $hit = "multi"; } if ($selch != "") $hit .= "$selch"; return $hit; } function rf_compare($prog, $kw) { global $strip_tags_flag; global $strip_space_flag; global $stripos_flag; $kw2 = $kw; if ($strip_space_flag == 1) { $kw2 = rf_strip_space($kw2); } if ($kw2 == "") return null; $kw2A = mb_convert_kana($kw2, "A"); foreach ($prog as $key => $value) { if ($strip_tags_flag == 1) { $value = rf_strip_tags($value); } if ($strip_space_flag == 1) { $value = rf_strip_space($value); } if ($stripos_flag == 1) { if (mb_stripos($value, $kw2) !== false) { return $key; } if (mb_stripos($value, $kw2A) !== false) { return $key; } } else { if (mb_strpos($value, $kw2) !== false) { return $key; } if (mb_stripos($value, $kw2A) !== false) { return $key; } } } return null; } function rf_reserve_disp($rsv_msg, $fnm, $title, $kw) { if (strlen($fnm) < 30) { $fnm = mb_substr($fnm . "          ", 0, 30); } $rsv_msg = substr($rsv_msg."      ",0,6); echo_prn(1, "$rsv_msg $fnm $title [$kw]"); } function rf_get_radiru_station() { global $radiru_area_1; $url_xml = rf_get_config_radiru(); $sta = rf_get_keyword('radiru_station'); $sta2 = array(); for ($i=0; $i<count_73($sta); $i++) { $area = strtolower($sta[$i]); if ($area == $radiru_area_1) { continue; } if (!array_key_exists($area, $url_xml)) { continue; } $sta2[] = $area; } return $sta2; } function rf_get_radiru_main_station($flg) { global $radiru_area_1; global $radiruareafile; $area = ""; $fl = $radiruareafile; if (($flg == 1) && file_exists($fl)) { $area = file_get_contents($fl); } else { $sta = rf_get_keyword('radiru_main_station'); if (count_73($sta) > 0) { $area = $sta[0]; } else { $sta2 = rf_get_keyword('radiru_station'); if (count_73($sta2) > 0) { $area = $sta2[0]; } } } if ($area == "") { $area = "tokyo"; } $parea = strtolower(trim($area)); $url_xml = rf_get_config_radiru(); if (array_key_exists($parea, $url_xml)) { } else { $parea = "tokyo"; } return $parea; } function rf_timerec($area_code, $test_mode, $ex_type, $nw, $lines, $sta) { global $keyword; start_prn(1, "timerec check start"); $rsvdata = array(); foreach ($lines as $line) { $wdata = get_time_rec($area_code, $ex_type, $nw, $line, $sta); if ($wdata != null) { $para = get_para($wdata, $ex_type); $ft = $para[0]; $to = $para[1]; $ch = $para[6]; $title = $para[7]; $idx = $ch."_".$title."_".$ft."_".$to; $rsvdata[$idx] = $wdata; echo "$wdata \n"; } } start_prn(1, "timerec check end"); return $rsvdata; } function rf_ex_reserve($test_mode, $ex_type, $rsvdata, $fr_nw, $to_nw) { global $ex_radiko; global $ex_radiru; global $ex_timefree; global $ex_radiru_vod; global $ex_radiru_gogaku; global $split_program; global $sort_flag; global $radiko_double_rec; global $radiru_double_rec; global $timefree_double_rec; global $radiru_vod_double_rec; global $radiru_gogaku_double_rec; switch($ex_type) { case $ex_radiko: $dbl = $radiko_double_rec; break; case $ex_radiru: $dbl = $radiru_double_rec; break; case $ex_timefree: $dbl = $timefree_double_rec; $dbl = 0; break; case $ex_radiru_vod: $dbl = $radiru_vod_double_rec; $dbl = 0; break; case $ex_radiru_gogaku: $dbl = $radiru_gogaku_double_rec; $dbl = 0; break; default: $dbl = 0; break; } if ($ex_type == $ex_radiko) { $rsvdata = rf_sta_rsvdata($ex_type, $rsvdata); } $rsvdata = rf_sel_rsvdata($ex_type, $rsvdata, $fr_nw, $to_nw); $rsvcnt0 = count_73($rsvdata); $dt1 = date("Y/m/d H:i:s", $fr_nw); $dt2 = date("Y/m/d H:i:s", $to_nw); echo_prn(1, ""); echo_prn(1, "Period : $dt1 - $dt2"); echo_prn(1, ""); if ($dbl == 1) { $rsvdata = rf_dbl_rsvdata($ex_type, $rsvdata); $rsvcnt1 = $rsvcnt0 - count_73($rsvdata); echo_prn(1, ""); echo_prn(1, "Candidate Program : $rsvcnt0"); echo_prn(1, "Exclude   Program : $rsvcnt1"); } if ($split_program > 0) { $rsvdata = rf_split_rsvdata($ex_type, $rsvdata, $split_program); } if ($sort_flag == 1) { asort($rsvdata); } elseif ($sort_flag == 2) { ksort($rsvdata); } $rsvcnt = count_73($rsvdata); echo_prn(1, ""); start_prn(1, "Reserved Program : $rsvcnt"); echo_prn(1, ""); $n = rf_rsv_sub($ex_type, $rsvdata, $test_mode, ""); } function rf_rsv_list($ex_type) { global $schradiko_head; global $schradiru_head; global $at_que_no; global $dlmt; global $ex_radiko; global $ex_radiru; global $ex_timefree; global $ex_radiru_vod; $cnt = 0; $rsvdata = array(); $exque = get_at_que_no($at_que_no); switch ($ex_type) { case $ex_radiko: $head = $schradiko_head; $atqueno = $exque[0]; break; case $ex_radiru: $head = $schradiru_head; $atqueno = $exque[1]; break; default: return $rsvdata; } $rsvdata = rfgw_rsv_limit_check($ex_type, $head, $atqueno); return $rsvdata; } function rf_rsv_all($ex_type) { global $schradiko_head; global $schradiru_head; global $at_que_no; global $ex_radiko; global $ex_radiru; $rsvdata = array(); $exque = get_at_que_no($at_que_no); $head = $schradiko_head; $atqueno = $exque[0]; $rsvdata1 = rfgw_rsv_limit_check($ex_radiko, $head, $atqueno); $head = $schradiru_head; $atqueno = $exque[1]; $rsvdata2 = rfgw_rsv_limit_check($ex_radiru, $head, $atqueno); $rsvdata3 =rf_rsv_limit_check_now($ex_type); $rsvdata = array_merge($rsvdata1,$rsvdata2,$rsvdata3); return $rsvdata; } function rfget_rsv_list($fr,$to) { global $rsvdir; $rsvdata = array(); $files = glob($rsvdir.'*.dat'); foreach ($files as $dat) { $sch = str_replace($rsvdir, "", $dat); $tim = explode('_',$sch); if (count_73($tim) < 4) continue; $rsv_fr = strtotime($tim[0].$tim[1]); $rsv_to = strtotime($tim[0].$tim[2]); if ($rsv_fr > $rsv_to) $rsv_to += 60*60*24; if ($rsv_to <= $fr) continue; if ($to <= $rsv_fr) break; $wdata = @file_get_contents($dat); if ($wdata === false) continue; $rsvdata[] = $wdata; } return $rsvdata; } function rf_rsv_limit_check($ex_type, $fnm, $fr, $to, $reserve_limit,$rsvdata) { $cnt = 0; $rsv = array(); foreach ($rsvdata as $wdata) { if (substr($wdata, 0, 1) == "#") { continue; } if (($para = get_para($wdata, 1)) == null) { continue; } $rsv_fr = strtotime($para[0]); if ($to <= $rsv_fr) { continue; } $rsv_to = strtotime($para[1]); if ($rsv_to <= $fr) { continue; } $rsv_fnm = get_fnam($para, $ex_type); if ($fnm == $rsv_fnm) { return 0; } $cnt++; $rsv[] = array("fr" => $rsv_fr, "to" => $rsv_to); } if ($cnt < $reserve_limit) return $cnt; $cnt_max = rf_max_reserve($rsv,$reserve_limit); if ($cnt_max < $reserve_limit) { $fmt_fr = date("Y/m/d H:i:s",$fr); $fmt_to = date("Y/m/d H:i:s",$to); } return $cnt_max; } function rf_max_reserve($rsv,$reserve_limit) { array_multisort(array_column($rsv,'fr'),SORT_ASC,$rsv); $rec_slot = array(); $cnt_max = 0; $cnt = 0; foreach($rsv as $rec) { if ($cnt > 0) { $fr = $rec['fr']; for ($i=0;$i<$cnt;$i++) { $slot_to = $rec_slot[$i]['to']; if ($slot_to <= $fr) { unset($rec_slot[$i]); } } $rec_slot = array_values($rec_slot); } $rec_slot[] = $rec; $cnt = count_73($rec_slot); if ($cnt > $cnt_max) $cnt_max = $cnt; } return $cnt_max; } function rf_rsv_limit_check_now($ex_type) { $rsvdata = array(); for ($i=0;$i<19;$i++) { $para[$i] = 0; } $nw = time(); $y = date('Y',$nw); $fmt_data = rfmenu_rec($nw, 0, 1); if (count_73($fmt_data) < 1) { return $rsvdata; } foreach($fmt_data as $dt) { $dt = trim(str_replace("  "," ",$dt)); $fmt = explode(" ",$dt); if (count_73($fmt) < 3) continue; $tim = explode("_",$fmt[2]); if (count_73($tim) < 4) continue; $para[0] = $y.$tim[0].$tim[1]."00"; $para[1] = $y.$tim[0].$tim[2]."00"; if (count_73($fmt) >= 4) { $para[7] = $fmt[3]; } else { $para[7] = ""; } $rsvdata[] = put_para($para, $ex_type); } return $rsvdata; } function rf_program_rsv($test_mode, $ex_type, $para, $head, $rty) { global $tmpdir; global $ex_radiko_delay; global $ex_radiko_pre_margin; global $radiru_pre_margin; global $radiru_delay; global $reserve_limit; global $standby_time; global $standby_time_m; $nw = time(); $totime = $para[1]; $to = strtotime($totime); $to2 = $to - 3*60; if ($to2 <= $nw) { return 2; } $fromtime = $para[0]; $fr = strtotime($fromtime); $fnm = get_fnam($para, $ex_type); $dr = $para[2] + 0; $ret =0; $nowsec = date("s", $nw) + 0; $nowdt = strtotime(date("YmdHi00", $nw)) + 60; if ($nowsec > 40) { $nowdt = $nowdt + 60; } $sttime = $nowdt + ($standby_time * 60); $sttime_m = $nowdt + ($standby_time_m * 60); $regtime = regtime_calc($ex_type, $fromtime, 0); if ($regtime >= $sttime) { $mode = 0; $regt = $regtime; $ret = 0; } elseif ($regtime >= $sttime_m) { $mode = 1; $regt = $regtime; $ret = 0; } else { $mode = 1; $ret = 1; $frt = fr_calc($ex_type, $sttime_m, 0); $dur = $to - $frt; if ($dur <= 0) { return 2; } $fromtime = date("YmdHis", $frt); $duration = sprintf("%05d", $dur); $para[0] = $fromtime; $para[2] = $duration; $regt = regtime_calc($ex_type, $fromtime, 0);; $fr = strtotime($fromtime); $fnm = get_fnam($para, $ex_type); if ($rty == 1) { $fnm = $fnm."_retry"; } else { $para[10] = "manual"; $fnm = $fnm."_manual"; } } $rsv_all = rfget_rsv_list($fr,$to); $cnt = rf_rsv_limit_check($ex_type, $fnm, $fr, $to, $reserve_limit,$rsv_all); if ($cnt >= $reserve_limit) { return 3; } $wdata = put_para($para, $ex_type); $tn = $head.$fnm; $pgm = explode("_", $fnm); echo_msg(2, "$pgm[1]-$pgm[2] $para[6] $para[7]"); at_reserve($ex_type, $tn, $regt, $fnm, $wdata, $mode); return $ret; } function rf_program_onair_check($para) { $fromtime = $para[0]; $totime = $para[1]; $fr = strtotime($fromtime); $to = strtotime($totime); $nw = time(); if ($to < $nw) { return false; } if ($fr > $nw) { return false; } return true; } function rf_program_archive_check($para) { $fromtime = $para[0]; $totime = $para[1]; $fr = strtotime($fromtime); $to = strtotime($totime); $nw = time(); if ($to < $nw) { return true; } return false; } function rf_program_date($ex_type, $fr_nw, $to_nw) { global $radiko_timeofbegin; global $radiru_timeofbegin; global $radiko_reserve_daily; global $radiru_reserve_daily; global $ex_radiko; global $ex_radiru; global $ex_timefree; global $ex_radiru_vod; switch ($ex_type) { case $ex_radiko: case 3: $timeofbegin = $radiko_timeofbegin; $rd = $radiko_reserve_daily; break; case $ex_radiru: case 4: case 6: $timeofbegin = $radiru_timeofbegin; $rd = $radiru_reserve_daily; break; } $frh = floor($fr_nw/3600); $toh = floor(($to_nw+3600)/3600); $durh = $toh - $frh; $tm = $timeofbegin - date("H", $fr_nw); if ($tm > 0) { $dt = -1; $cnt = 1; $durh = $durh - $tm; if ($durh < 0) { $durh = 0; } } else { $dt = 0; $cnt = 0; } $cnt = $cnt + $rd; $ret[0] = strtotime("$dt day"); $ret[1] = $cnt; return $ret; } function rf_sta_rsvdata($ex_type, $rsvdata) { $n = 0; $rsvdata2 = array(); foreach ($rsvdata as $key => $wdata) { $para = get_para($wdata, $ex_type); $fromtime = $para[0]; $totime = $para[1]; $channel = $para[6]; $fr = get_mktime($fromtime); $to = get_mktime($totime); $channel_l = strtolower($channel); if (!valid_chk($ex_type, $channel_l)) { continue; } $rsvdata2[$key] = $wdata; } return $rsvdata2; } function rf_dbl_rsvdata($ex_type, $rsvdata) { global $rec_extension; echo_prn(1, "Check Duplicated Program [SKP  ]:current dir  [SKP-p]:parent dir"); echo_prn(1, ""); $n = 0; $rsvdata2 = array(); foreach ($rsvdata as $key => $wdata) { $para = get_para($wdata, $ex_type); $fromtime = $para[0]; $totime = $para[1]; $channel = $para[6]; $title = $para[7]; $kw = $para[10]; $fr = get_mktime($fromtime); $to = get_mktime($totime); $ext = $rec_extension; $out = fnam_edit($ex_type,$para); if ($kw == "manual") { $out = $out."_m"; } if (rf_check_double_rec($ex_type, $out, $ext, $channel, $title, 0, 0) === true) { echo_prn(2, "[SKP  ] $out"); } else { if (rf_check_double_rec($ex_type, $out, $ext, $channel, $title, 1, 0) === true) { echo_prn(2, "[SKP-p] $out"); } else { $rsvdata2[$key] = $wdata; } } } return $rsvdata2; } function rf_sel_rsvdata($ex_type, $rsvdata, $fr_nw, $to_nw) { $n = 0; $rsvdata2 = array(); foreach ($rsvdata as $key => $wdata) { $para = get_para($wdata, $ex_type); $fromtime = $para[0]; $totime = $para[1]; $channel = $para[6]; $fr = get_mktime($fromtime); $to = get_mktime($totime); if ($fr < $fr_nw || $fr > $to_nw) { continue; } $rsvdata2[$key] = $wdata; } return $rsvdata2; } function rf_split_rsvdata($ex_type, $rsvdata, $sp_time) { $sp = $sp_time; if ($sp <= 0) { return $rsvdata; } if ($sp >12) { $sp = 12; } $sp = $sp * 3600; $n = 0; $rsvdata2 = array(); foreach ($rsvdata as $key => $wdata) { $para = get_para($wdata, $ex_type); $fromtime = $para[0]; $totime = $para[1]; $duration = $para[2]; $title = $para[7]; $fr = get_mktime($fromtime); $to = get_mktime($totime); if ($sp >= $duration) { $rsvdata2[$key] = $wdata; } else { $split_cnt = floor(($duration + $sp - 1) / $sp); $split_dur = $duration; $split_tim = $fr; while ($split_dur > 0) { $n = $n+1; $split_fr = date("YmdHis", $split_tim); $split_to = date("YmdHis", $split_tim + $sp); $para[0] = $split_fr; $para[1] = $split_to; $para[2] = $sp; $para[7] = $title . sprintf("_@%02d", $n); $wdata = put_para($para, $ex_type); $rsvdata2[$key] = $wdata; $split_tim += $sp; $split_dur -= $sp; if ($split_dur < $sp) { $sp = $split_dur; } } } } return $rsvdata2; } function rf_rsv_sub($ex_type, $rsvdata, $test_mode, $sfx) { global $schradiko_head; global $schradiru_head; global $reserve_limit; global $ex_radiko; global $ex_radiru; global $ex_timefree; global $ex_radiru_vod; switch ($ex_type) { case $ex_radiko: case 3: case $ex_timefree: $head = $schradiko_head; break; case $ex_radiru: case 4: case 6: $head = $schradiru_head; break; } $n = 0; $rsv_cnt = 0; $skp_cnt = 0; foreach ($rsvdata as $key => $wdata) { $para = get_para($wdata, $ex_type); $fromtime = $para[0]; $totime = $para[1]; $duration = $para[2]; $channel = $para[6]; $title = $para[7]; $kw = $para[10]; $fr = get_mktime($fromtime); $to = get_mktime($totime); $n = $n+1; $fnm = get_fnam($para, $ex_type).$sfx; $tn = $head.$fnm; $mgn = 0; $reg_time = regtime_calc($ex_type, $fromtime, $mgn); $rsv_msg = "   "; if ($test_mode == 0) { $rsv_all = rfget_rsv_list($fr,$to); $cnt = rf_rsv_limit_check($ex_type, $fnm, $fr, $to, $reserve_limit,$rsv_all); if ($cnt >= $reserve_limit) { $rsv_msg = "DUP".$cnt; $skp_cnt++; } else { $at_st = time(); at_reserve($ex_type, $tn, $reg_time, $fnm, $wdata, 0); $at_en = time(); $at_diff = $at_en - $at_st; $rsv_cnt++; } } else { $at_diff = 0; $rsv_cnt++; } rf_reserve_disp($rsv_msg, $fnm, $title, $kw); } echo_prn(1, ""); echo_prn(1, "Reserved : $rsv_cnt task(s)   Skipped [ > $reserve_limit ] : $skp_cnt task(s) "); rfgw_dispsch($ex_type); return $n; } function rf_make_2day($nw) { $today0 = strtotime("today", $nw); $tomorrow0 = strtotime("tomorrow", $nw); $dt[0] = date("Y/m/d", $today0); $dt[1] = date("Y/m/d", $tomorrow0); return $dt; } function rf_rsv_timerec($arae_code, $test_mode, $kw_station, $lines, $ex_type, $area, $dt0, $n_k) { global $split_program; global $s_mkoffs; global $ex_radiko; global $ex_radiru; global $ex_timefree; global $ex_radiru_vod; start_prn(1, "timerec check start"); $nk = $n_k; if ($nk < 1) { $nk = 1; } if ($nk > 8*24) { $nk = 8 * 24; } $nw = time(); $fr_nw = $nw + $s_mkoffs; $to_nw = $fr_nw + $nk*3600; switch ($ex_type) { case $ex_radiru: $sta = $radiru_ch; break; case $ex_radiko: default: $sta = rf_radiko_station($area); break; } echo_prn(1, ""); $rsvdata = array(); foreach ($lines as $line) { $wdata = get_time_rec($area_code, $ex_type, $nw, $line, $sta); if ($wdata != null) { $para = get_para($wdata, $ex_type); $ft = $para[0]; $ch = $para[6]; $title = $para[7]; $idx = $ch."_".$title."_".$ft; $rsvdata[$idx] = $wdata; } } start_prn(1, "timerec check end"); $rsvcnt = count_73($rsvdata); $dt1 = date("Y/m/d H:i:s", $fr_nw); $dt2 = date("Y/m/d H:i:s", $to_nw); echo_prn(1, ""); echo_prn(1, "Timerec 予約期間($dt1 - $dt2)"); $rsvdata = rf_sel_rsvdata($ex_type, $rsvdata, $fr_nw, $to_nw); $rsvcnt = count_73($rsvdata); if ($split_program > 0) { $rsvdata = rf_split_rsvdata($ex_type, $rsvdata, $split_program); $rsvcnt = count_73($rsvdata); } $rsvn = count_73($rsvdata); if ($rsvn > 0) { echo_prn(1, ""); $n = rf_rsv_sub($ex_type, $rsvdata, $test_mode, "_timerec"); } } function get_time_rec($area_code, $ex_type, $nw, $line, $station) { global $radiru_ch; global $radiru_ch_2; global $dlmt; global $ex_radiko; global $ex_radiru; global $ex_timefree; global $ex_radiru_vod; $youbi = array( "sun", "mon", "tue", "wed", "thu", "fri", "sat" ); $ln = trim($line); if (strlen($ln) <= 4) { return null; } echo_prn(1, ""); echo_prn(1, "$ln"); if (substr($ln,0,1) == "?") { $delay_test = 1; $ln = substr($ln,1); } else { $delay_test = 0; } $ln2 = str_replace(";", "", $ln); $ln2 = str_replace("_", "-", $ln2); $kw = explode(",", $ln2); if (count_73($kw) == 4) $kw[4] = "-"; if (count_73($kw) == 5) $kw[5] = ""; if (count_73($kw) != 6) { echo_prn(1, "-- パラメータの数が違います ".count_73($kw)); echo_prn(1, ""); return null; } for ($i=0; $i<count_73($kw); $i++) { $key = trim($kw[$i]); $kw[$i] = $key; } $sta= strtoupper($kw[0]); $stal= strtolower($kw[0]); if ($kw[1] == "") { $yb = strtolower($youbi[date('w')]); } else { $yb = strtolower($kw[1]); } $st = $kw[2]; $en = $kw[3]; $pn = str_replace(" ", "-", $kw[4]); if ($pn == "") $pn = "-"; $mc = str_replace(" ", "-", $kw[5]); $pic = ";"; $comment ="timerec"; $failed_record = "0"; if ($delay_test == 1) { $pn = "(delaytest)".$pn; $failed_record = "?"; } $c1 = ""; $c2 = ""; $c3 = ""; $c4 = ""; $c5 = ""; $c6 = ""; $ccnt = 0; if (array_search($yb, $youbi) === false) { echo_prn(1, "-- 曜日が間違っています $yb"); $c2 = "?"; $ccnt++; } $st_dt = rf_check_time($st); if ($st_dt === false) { echo_prn(1, "-- 開始時間が間違っています [$st]"); $c3 = "?"; $ccnt++; } $en_dt = rf_check_time($en); if ($en_dt === false) { echo_prn(1, "-- 終了時間が間違っています [$en]"); $c4 = "?"; $ccnt++; } switch ($ex_type) { case $ex_radiru: $sta = $stal; $ret = in_array($sta, $station); if ($ret == false) { echo_prn(1, "-- 局名が間違っています [$sta]"); $c1 = "?"; $ccnt++; } break; case $ex_radiko: $ret = array_key_exists($sta, $station); if ($ret == false) { echo_prn(1, "-- 局名が間違っています [$sta]"); $c1 = "?"; $ccnt++; } break; default: echo_prn(1, "-- 局名が間違っています [$ex_type , $sta]"); $c1 = "?"; $ccnt++; break; } $cfmt = '%s[%s] %s[%s] %s[%s] %s[%s] %s[%s] %s[%s]'; $cstr = sprintf($cfmt, $c1, $sta, $c2, $yb, $c3, $st, $c4, $en, $c5, $pn, $c6, $mc); if ($ccnt != 0) { return false; } $dt = date('Ymd ', strtotime("this $yb")); $dtst = strtotime($dt.$st_dt); $dten = strtotime($dt.$en_dt); if ($dtst < $nw + 120) { if ($kw[1] == "") { $dt = date('Ymd ', strtotime("next day")); } else { $dt = date('Ymd ', strtotime("next $yb")); } $dtst = strtotime($dt.$st_dt); $dten = strtotime($dt.$en_dt); } $dur = $dten - $dtst; if ($dur <= 0) { $dten += (24 * 60 * 60); } $st = date("YmdHis", $dtst); $en = date("YmdHis", $dten); $duration = sprintf("%05d", $dten - $dtst); $wdata = rf_make_wdata($st, $en, $duration, $failed_record, 0, 0, $sta, $pn, $mc, $pic, $comment, $dlmt, $dlmt, $dlmt, $area_code, $dlmt, $dlmt, $dlmt, $dlmt); return $wdata; } function rf_sch_expire_radiko($mode,$tm, $exp, $pat,$pr) { foreach (glob($pat) as $fn) { if (!file_exists($fn)) continue; $fn2 = basename($fn); $dr = explode("_", $fn2); $df = $tm - strtotime($dr[0]); if ($df >= $exp) { if ($pr == 1) echo_msg(2, "expire $fn"); fin_unlink($fn); continue; } if ($mode == 0) continue; $tmp = @file_get_contents($fn); if ($tmp === false) { if ($pr == 1) echo_msg(2, "broken $fn"); fin_unlink($fn); continue; } $tmp2 = str_replace(array("\r","\n","\t"), '', $tmp); $xmltmp = @simplexml_load_string($tmp2); if ($xmltmp === false) { if ($pr == 1) echo_msg(2, "broken $fn"); fin_unlink($fn); continue; } } } function rf_sch_expire_radiru($mode,$tm, $exp, $pat,$pr) { foreach (glob($pat) as $fn) { if (!file_exists($fn)) continue; $fn2 = basename($fn); $dr = explode("_", $fn2); $df = $tm - strtotime($dr[0]); if ($df >= $exp) { if ($pr == 1) echo_msg(2, "expire $fn"); fin_unlink($fn); continue; } if ($mode == 0) continue; $tmp = @file_get_contents($fn); if ($tmp === false) { if ($pr == 1) echo_msg(2, "broken $fn"); fin_unlink($fn); continue; } $json_tmp = json_decode($tmp, true); if (is_null($json_tmp)) { if ($pr == 1) echo_msg(2, "broken $fn"); fin_unlink($fn); continue; } } } function rf_sch_delete($pat) { foreach (glob($pat) as $fn) { echo_msg(2, "delete $fn"); fin_unlink($fn); } } function rf_que_list($ex_type) { global $schradiko_head; global $schradiru_head; global $at_que_no; global $ex_radiko; global $ex_radiru; $rsvdata = array(); $exque = get_at_que_no($at_que_no); switch ($ex_type) { case $ex_radiko: $head = $schradiko_head; $atqueno = $exque[0]; break; case $ex_radiru: $head = $schradiru_head; $atqueno = $exque[1]; break; default: return $rsvdata; } $auto = 0; $rsvdata = rfgw_rec_dsp($ex_type, $head, $atqueno,$auto); return $rsvdata; } 