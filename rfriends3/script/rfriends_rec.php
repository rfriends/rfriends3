<?php
 require_once("rf_inc.php"); require_once("rf_radiko.php"); require_once("rf_radiko2.php"); require_once("rf_radiko3.php"); require_once("rf_radiru.php"); require_once("rf_downloader.php"); require_once("rf_reserve.php"); require_once("rf_menu_sub.php"); require_once("rf_gdrive.php"); $rfriends_mes = "ラジオ録音ツール"; if ($argc != 2) { echo_prn(2, "radiko_rec parametaer error"); exit(1); } $p = explode(",", $argv[1]); if (count_73($p) == 4) { $test_mode = $p[0]; $msg_level = $p[1]; $ex_type = $p[2]; $fnm = $p[3]; } else { echo_prn(2, "radiko_rec parametaer error"); exit(1); } rf_system_info($ex_type); rfgw_caffeinate($ex_type, $fnm); $dt = date_default_timezone_get(); if ($dt != 'Asia/Tokyo') { echo_prn(2, "timezone error $dt"); } $st_tm = start_prn(1, "rfriends_rec start"); $pt = get_include_path(); $recfiletmp = $tmpdir.$fnm; $flg = $tmpdir.$fnm.".flg"; $wdata = rf_get_wdata($fnm, $ex_type); if ($ex_type == $ex_radiko || $ex_type == $ex_radiru) { if (file_exists($flg)) { echo_prn(2, "file already exist : $flg"); echo_prn(2, "２重起動の可能性があります。"); echo_prn(2, "$wdata"); echo_prn(2, ""); echo_prn(2, "[rfriends abnormal end]"); exit(1); } } rf_touch($flg); $para = get_para($wdata, $ex_type); $duration = $para[2]; $failed_record = $para[3]; if ($failed_record == "?") { echo_prn(1,"***** delay check mode (set delay = 0) *****"); $premium_delay = 0; $premium_pre_margin = 0; $premium_post_margin = 0; $radiko_delay = 0; $radiko_pre_margin = 0; $radiko_post_margin = 0; $radiru_delay = 0; $radiru_pre_margin = 0; $radiru_post_margin = 0; } $mgn = 0; $reg_dur = dur_calc($ex_type, $duration, $mgn); $title_flag = 1; $ffmpeg_ver = rfgw_info_ffmpeg(); $ret = rfriends_downloader($ex_type, $fnm, $reg_dur, $para, $title_flag, $ffmpeg_ver); $dfl = $rsvdir."$fnm.dat"; fin_unlink($dfl); $dfl = $tmpdir."$fnm.dat"; fin_unlink($dfl); if ($ret == $rec_normal_end || $ret == $rec_already_exist || $ret == $rec_not_deliver) { fin_unlink($flg); } $en_tm = start_prn(1, "all done"); rf_statistics($st_tm, $en_tm); exit(0); 