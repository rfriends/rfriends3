<?php
 function rf_error_sleep() { } function dir_check($dir,$dir_init) { global $iniusrdir; if (!array_key_exists($dir, $iniusrdir)) { return $dir_init; } $str = trim($iniusrdir[$dir]); $str = mb_convert_kana($str, "as"); if (strlen($str) !== mb_strlen($str)) { return $dir_init; } $chrs = array('\\','/',':','*','?','"','<','>','|',' '); $str = str_replace($chrs,"_",$str); return $str; } $ptedir = $base0."_pte".$DS; $os_s = PHP_OS; $os_l = php_uname(); $cfgdir = $base."config".$DS; $defdir = $base."template".$DS; $scrdir = $base."script".$DS; $etcdir = $base."etc".$DS; $rsvdir = $base."rsv".$DS; $extdir = $base."ext".$DS; $defkwdir = $defdir."kw".$DS; $defkwtemplatedir = $defdir."kw_template".$DS; $schdir = $rsvdir."sch".$DS; $htmldir = $scrdir."html".$DS; $usrdir_link = $htmldir."temp".$DS."usr".$DS; $usrdir_sys = $base."usr".$DS; $tmpdir_sys = $base."tmp".$DS; $usrdef = $etcdir."usrdef"; $tmpdef = $etcdir."tmpdef"; $pcastdef = $etcdir."pcastdef"; $editor = $etcdir."rf_editor"; $rfriendsini = "rfriends.ini"; $rfriendsforceini = "rfriends_force.ini"; $rfplayini = "rfplay.ini"; $rfriendstag = "rfriends_tag.ini"; $rfriendstxt = $rfproduct.".txt"; $premiumini = "premium.ini"; $crontabtxt = "crontab"; $sendmailini = "sendmail.ini"; $usrdirini = "usrdir.ini"; $serviceini = "service.ini"; $common_kw = "common.dat"; $radiko_kw = "radiko.dat"; $radiru_kw = "radiru.dat"; $radiru_other_kw = "radiru_other.dat"; $radiru_vod_kw = "radiru_vod.dat"; $radiru_gogaku_kw = "radiru_gogaku.dat"; $timefree_kw = "timefree.dat"; $station_kw = "station.dat"; $program_kw = "program.dat"; $premium_kw = "premium.dat"; $delivery_kw = "delivery.dat"; $radiko_callsigndat = "radiko_callsign.csv"; $radiru_callsigndat = "radiru_callsign.csv"; $podcastdat = "podcast.dat"; $radiko_genredat = "radiko_genre.dat"; $radiru_genredat = "radiru_genre.dat"; $dirindexdat = "dirindex.css"; $google_podcastsdat ="google_podcasts.dat"; $kw_dat = array( "station" => $station_kw, "common" => $common_kw, "radiko" => $radiko_kw, "radiru" => $radiru_kw, "radiru_other" => $radiru_other_kw, "timefree" => $timefree_kw, "radiru_vod" => $radiru_vod_kw, "radiru_gogaku" => $radiru_gogaku_kw, "premium" => $premium_kw, "program" => $program_kw, "delivery" => $delivery_kw, ); $kw_name_dat = array( "station" => "放送局", "common" => "共通", "radiko" => "ラジコ", "timefree" => "タイムフリー", "premium" => "エリアフリー", "radiru" => "らじる", "radiru_other" => "地域", "radiru_vod" => "聞き逃し", "radiru_gogaku" => "ゴガク", "program" => "重複番組", "delivery" => "番組配送", ); $setting_name_dat = array( "rfriends.ini" => "パラメータ設定" ,"rfriends_tag.ini" => "タグ設定" ,"radiko_callsign.csv" => "ラジココールサイン設定" ,"radiru_callsign.csv" => "らじるコールサイン設定" ,"podcast.dat" => "ポッドキャスト設定" ,"sendmail.ini" => "メール設定" ,"usrdir.ini" => "録音ディレクトリ設定" ,"premium.ini" => "ラジコプレミアム設定" ,"user_process.bat" => "ユーザプロセス(win)" ,"user_process.sh" => "ユーザプロセス(linux)" ,"user_process2.bat" => "ユーザプロセス2(win)" ,"user_process2.sh" => "ユーザプロセス2(linux)" ,"crontab" => "デイリー処理設定(linux)" ,"rfplay.ini" => "パラメータ(rfplay)設定" ); $auth_token = ""; $home_area_code = ""; $area_code = "JPXX"; $nowarea = "JPXX,Japan"; $radiru_area_1 = "tokyo"; $ex_dummy = -99; $ex_daily = -1; $ex_clean = 0; $ex_radiko = 1; $ex_radiru = 2; $ex_timefree = 5; $ex_radiru_vod = 8; $ex_radiru_gogaku = 9; $ex_podcast = 10; $svcmode["service_mode"] = 0; set_rfriends_dir(); if (!file_exists($base.$rfriends)) { echo "file not found : $base.$rfriends".$DS; exit(1); } $rfriends_ver = trim(file_get_contents($base.$rfriends)); $rfriends_parts = explode(" ", $rfriends_ver); $fl0 = $scrdir.$rfriendsini; $fl1 = $defdir.$rfriendsini; $fl2 = $cfgdir.$rfriendsini; copy_defusr(0, $rfriendsini); copy_defusr(0, $rfplayini); $inidata1 = @parse_ini_file($fl0); if ($inidata1 === false) { echo "\n"; echo "システム設定が間違っています。: $fl0 \n"; exit(1); } $inidata2 = @parse_ini_file($fl2); if ($inidata2 === false) { $inidata2 = array(); echo "\n"; echo "ユーザ設定が間違っています。: $fl2 \n"; echo "設定を無視します。\n"; rf_error_sleep(); } $inidata = array_merge($inidata1, $inidata2); $ret = set_inidata($inidata, $inidata1); $ini_usrdir = rf_ini($inidata, "usrdir"); $ini_tmpdir = rf_ini($inidata, "tmpdir"); $fl0 = $scrdir.$usrdirini; $fl1 = $defdir.$usrdirini; $fl2 = $cfgdir.$usrdirini; copy_defusr(0, $usrdirini); if ($ini_usrdir == "" && $ini_tmpdir == "") { if (file_exists($fl2)) { $iniusrdir = @parse_ini_file($fl2); if ($iniusrdir === false) { echo "\n"; echo "録音ディレクトリ設定が間違っています。: $fl2 \n"; echo "設定を無視します。\n"; $iniusrdir = array(); rf_error_sleep(); } $ini_usrdir2 = ""; $ini_tmpdir2 = ""; $ini_pcastdir2 = ""; if (array_key_exists("usrdir", $iniusrdir)) { $ini_usrdir2 = $iniusrdir["usrdir"]; } if (array_key_exists("tmpdir", $iniusrdir)) { $ini_tmpdir2 = $iniusrdir["tmpdir"]; } $ini_cpath = "yes"; if (array_key_exists("convertpath", $iniusrdir)) { $ini_cpath = strtolower($iniusrdir["convertpath"]); if ($ini_cpath != "no") $ini_cpath = "yes"; } $usrdir = $base."usr".$DS; $tmpdir = $base."tmp".$DS; $pcastdir = $usrdir."podcast".$DS; $tmpusrdir = $tmpdir."usr".$DS; $ret = custom_dir($usrdef, $usrdir, $ini_usrdir2, $ini_cpath); if ($ret !== false) { if (file_exists($ret)) { $usrdir = $ret; $pcastdir = $usrdir."podcast".$DS; } } $ret = custom_dir($tmpdef, $tmpdir, $ini_tmpdir2, $ini_cpath); if ($ret !== false) { if (file_exists($ret)) { $tmpdir = $ret; $tmpusrdir = $tmpdir."usr".$DS; } } } $dir_log = "log"; $dir_radiko = "radiko"; $dir_radiru = "radiru"; $dir_timefree = "timefree"; $dir_radiru_vod = "radiru_vod"; $dir_radiru_gogaku = "radiru_gogaku"; $dir_kw = "kw"; $dir_kwbackup = "kwbackup"; $dir_podcast = "podcast"; $dir_change = dir_check("dir_change","off"); if ($dir_change == "on") { $dir_log = dir_check("dir_log","log"); $dir_radiko = dir_check("dir_radiko","radiko"); $dir_radiru = dir_check("dir_radiru","radiru"); $dir_timefree = dir_check("dir_timefree","timefree"); $dir_radiru_vod = dir_check("dir_radiru_vod","radiru_vod"); $dir_radiru_gogaku = dir_check("dir_radiru_gogaku","radiru_gogaku"); $dir_kw = dir_check("dir_kw","kw"); $dir_kwbackup = dir_check("dir_kwbackup","kwbackup"); $dir_podcast = dir_check("dir_podcast","podcast"); } } $fl0 = $scrdir.$rfriendstag; $fl1 = $defdir.$rfriendstag; $fl2 = $cfgdir.$rfriendstag; copy_defusr(0, $rfriendstag); $tagdata1 = @parse_ini_file($fl0); if ($tagdata1 === false) { echo "\n"; echo "システムタグ設定が間違っています。: $fl0 \n"; exit(1); } $tagdata2 = @parse_ini_file($fl2); if ($tagdata2 === false) { $tagdata2 = array(); echo "\n"; echo "ユーザタグ設定が間違っています。: $fl2 \n"; echo "設定を無視します。\n"; rf_error_sleep(); } $tagdata = array_merge($tagdata1, $tagdata2); $ret = set_tagdata($tagdata, $tagdata1); $radiko_pre = "K_"; $radiru_pre = "R_"; $sch_exrecord = "ExRecord"; $schrfriends_head = "\\$sch_head\\$sch_exrecord"; $schradiko_head = "\\$sch_head\\radiko\\$radiko_pre"; $schradiru_head = "\\$sch_head\\radiru\\$radiru_pre"; $auth_token_dat = $tmpdir."rfriends_auth_token"; $logdir = $usrdir.$dir_log.$DS; $radiko_recdir = $usrdir.$dir_radiko.$DS; $radiru_recdir = $usrdir.$dir_radiru.$DS; $timefree_recdir = $usrdir.$dir_timefree.$DS; $radiru_vod_recdir = $usrdir.$dir_radiru_vod.$DS; $radiru_gogaku_recdir = $usrdir.$dir_radiru_gogaku.$DS; $kwdir = $usrdir.$dir_kw.$DS; $kwbackupdir = $usrdir.$dir_kwbackup.$DS; $radiru_gogaku_recdir = $usrdir.$dir_radiru_gogaku.$DS; $podcast_recdir = $usrdir.$dir_podcast.$DS; $common_keyword_dat = $kwdir.$common_kw ; $radiko_keyword_dat = $kwdir.$radiko_kw; $radiru_keyword_dat = $kwdir.$radiru_kw; $radiru_other_keyword_dat = $kwdir.$radiru_other_kw; $timefree_keyword_dat = $kwdir.$timefree_kw; $station_keyword_dat = $kwdir.$station_kw; $double_keyword_dat = $kwdir.$program_kw; $premium_keyword_dat = $kwdir.$premium_kw; $radiru_vod_keyword_dat = $kwdir.$radiru_vod_kw; $radiru_gogaku_keyword_dat= $kwdir.$radiru_gogaku_kw; $edit_fn = array( $rfriendsini => array(21,$cfgdir), $rfriendstag => array(22,$cfgdir), $rfriendstxt => array(23,$base), $common_kw => array(24,$kwdir), $radiko_kw => array(25,$kwdir), $radiru_kw => array(26,$kwdir), $radiru_other_kw=> array(27,$kwdir), $timefree_kw => array(28,$kwdir), $station_kw => array(29,$kwdir), $premiumini => array(30,$cfgdir), $premium_kw => array(31,$kwdir), $crontabtxt => array(32,$cfgdir), $sendmailini => array(33,$cfgdir), $usrdirini => array(34,$cfgdir), $radiru_vod_kw=> array(35,$kwdir), $radiru_gogaku_kw=> array(36,$kwdir), $program_kw => array(37,$kwdir), $radiko_callsigndat => array(38,$cfgdir), ); $edit_fnam = ""; $radiruareafile = $tmpdir."rfriends_radiruarea"; premium_initialize(); $fl2 = $usrdir.$serviceini; $svcmode = array(); $svcmode["service_mode"] = 0; $svcmode["service_ext"] = 0; $svcmode["service_key"] = ""; $svcmode["service_mgc"] = ""; $svcmode["service_maintenance"] = 0; $svcmode["service_update_beta"] = 0; $svcmode["service_update_beta_mgc"] = ""; $svcmode["service_update_forbid"] = 0; $svcmode["service_log_errors"] = 0; $svcmode["service_log_ffmpeg"] = 0; $svcmode["service_debug"] = 0; $svcmode["service_ajax"] = 0; if (file_exists($fl2)) { $iniservice = @parse_ini_file($fl2); if ($iniservice !== false) { if (array_key_exists("service_mode", $iniservice)) { if ($iniservice["service_mode"] == 1) $svcmode["service_mode"] = 1; } if (array_key_exists("service_ext", $iniservice)) { if ($iniservice["service_ext"] == 1) $svcmode["service_ext"] = 1; } if (array_key_exists("service_key", $iniservice)) { $svcmode["service_key"] = $iniservice["service_key"]; } if (array_key_exists("service_mgc", $iniservice)) { $svcmode["service_mgc"] = $iniservice["service_mgc"]; } if (array_key_exists("service_maintenance", $iniservice)) { if ($iniservice["service_maintenance"] == 1) $svcmode["service_maintenance"] = 1; } if (array_key_exists("service_update_beta", $iniservice)) { if ($iniservice["service_update_beta"] == 1) $svcmode["service_update_beta"] = 1; } if (array_key_exists("service_update_beta_mgc", $iniservice)) { $svcmode["service_update_beta_mgc"] = $iniservice["service_update_beta_mgc"]; } if (array_key_exists("service_update_forbid", $iniservice)) { if ($iniservice["service_update_forbid"] == 1) $svcmode["service_update_forbid"] = 1; } if (array_key_exists("service_log_errors", $iniservice)) { if ($iniservice["service_log_errors"] == 1) $svcmode["service_log_errors"] = 1; } if (array_key_exists("service_log_ffmpeg", $iniservice)) { if ($iniservice["service_log_ffmpeg"] == 1) $svcmode["service_log_ffmpeg"] = 1; } if (array_key_exists("service_debug", $iniservice)) { if ($iniservice["service_debug"] == 1) $svcmode["service_debug"] = 1; } if (array_key_exists("service_ajax", $iniservice)) { if ($iniservice["service_ajax"] == 1) $svcmode["service_ajax"] = 1; } } } $fl0 = $scrdir.$sendmailini; $fl1 = $defdir.$sendmailini; $fl2 = $cfgdir.$sendmailini; copy_defusr(0, $sendmailini); $send_mail_mode = 0; $send_mail_remain = 0; $send_mail_host = ""; $send_mail_port = 0; $send_mail_user = ""; $send_mail_pass = ""; $send_mail_from = ""; $send_mail_from_nm = ""; $send_mail_to = ""; $send_mail_to_nm = ""; if (file_exists($fl2)) { $inisendmail = @parse_ini_file($fl2); if ($inisendmail === false) { echo "\n"; echo "sendmail設定が間違っています。: $fl2 \n"; echo "設定を無視します。\n"; rf_error_sleep(); } else { if (array_key_exists("send_mail_mode", $inisendmail)) { $send_mail_mode = $inisendmail["send_mail_mode"]; } if (array_key_exists("send_mail_remain", $inisendmail)) { $send_mail_remain = $inisendmail["send_mail_remain"]; } if (array_key_exists("send_mail_host", $inisendmail)) { $send_mail_host = $inisendmail["send_mail_host"]; } if (array_key_exists("send_mail_port", $inisendmail)) { $send_mail_port = $inisendmail["send_mail_port"]; } if (array_key_exists("send_mail_user", $inisendmail)) { $send_mail_user = $inisendmail["send_mail_user"]; } if (array_key_exists("send_mail_pass", $inisendmail)) { $send_mail_pass = $inisendmail["send_mail_pass"]; } if (array_key_exists("send_mail_from", $inisendmail)) { $send_mail_from = $inisendmail["send_mail_from"]; } if (array_key_exists("send_mail_from_nm", $inisendmail)) { $send_mail_from_nm = $inisendmail["send_mail_from_nm"]; } if (array_key_exists("send_mail_to", $inisendmail)) { $send_mail_to = $inisendmail["send_mail_to"]; } if (array_key_exists("send_mail_to_nm", $inisendmail)) { $send_mail_to_nm = $inisendmail["send_mail_to_nm"]; } if ($send_mail_mode < 0) { $send_mail_mode = 0; } if ($send_mail_mode > 3) { $send_mail_mode = 3; } if (array_key_exists("send_mail_line_mode", $inisendmail)) { $send_mail_line_mode = $inisendmail["send_mail_line_mode"]; } if (array_key_exists("send_mail_line_token", $inisendmail)) { $send_mail_line_token = $inisendmail["send_mail_line_token"]; } if ($send_mail_line_mode < 0) { $send_mail_line_mode = 0; } if ($send_mail_line_mode > 3) { $send_mail_line_mode = 3; } } } $radiko_callsign_db = array(); copy_defusr(0, $radiko_callsigndat); if ($radiko_callsign == 1) { $fl = $cfgdir.$radiko_callsigndat; $radiko_callsign_db = rf_get_csv($fl); } $radiru_callsign_db = array(); copy_defusr(0, $radiru_callsigndat); if ($radiru_callsign == 1) { $fl = $cfgdir.$radiru_callsigndat; $radiru_callsign_db = rf_get_csv($fl); } $fl = $scrdir.$radiru_genredat; $radiru_genre_db = rf_get_csv($fl); copy_defusr(0, $podcastdat); copy_defusr(0, $dirindexdat); rf_copy_newonly($defdir.$dirindexdat,$htmldir.$dirindexdat); copy_defusr(0, "user_process.bat"); copy_defusr(0, "user_process.sh"); copy_defusr(0, "user_process2.bat"); copy_defusr(0, "user_process2.sh"); 