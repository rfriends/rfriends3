<?php
 function copy_defusr($f, $fn) { global $defdir; global $cfgdir; $ret = copy_defusr_sub($f,$fn,$defdir,$cfgdir); return $ret; } function copy_defusr_sub($f,$fn,$srcdir,$dstdir) { $bak = ".bak"; $src = $srcdir.$fn; $src_ext = $srcdir.$fn.".ext"; $dst = $dstdir.$fn; if (file_exists($src_ext)) { $src = $src_ext; } if (!file_exists($src)) { echo_msg(2, "file not found : $src"); return (1); } if ($f == 1) { if (file_exists($dst)) { rf_move($dst, $dst.$bak); echo_msg(2, "rename : ".$dst.$bak); } rf_copy($src, $dst); echo_msg(2, "copy : $dst"); } else { if (!file_exists($dst)) { rf_copy($src, $dst); echo_msg(2, "copy : $dst"); } } return (0); } function copy_newkw_sub($f, $kw) { global $defkwdir; global $kwdir; global $station_kw; global $program_kw; $def = ""; $src = $defkwdir.$kw.$def; $dst = $kwdir.$kw; if (file_exists($dst)) { if ($f == 1) { rf_copy($src, $dst); } } else { rf_copy($src, $dst); } } function copy_newkw($f) { global $kw_dat; global $station_kw; global $program_kw; $def = ""; foreach ($kw_dat as $kw) { copy_newkw_sub($f, $kw); } } function copy_newkwzip($f) { global $kwbackupdir; global $defkwtemplatedir; $dir = $defkwtemplatedir."*.zip"; $files = array_filter(glob($dir), 'is_file'); if ($files === false) return; if (count_73($files) <= 0) return; foreach($files as $file) { $base_file = basename($file); $src = $file; $dst = $kwbackupdir.$base_file; if (file_exists($dst)) { if ($f == 1) { rf_copy($src, $dst); } } else { rf_copy($src, $dst); } } } function dir_init($p) { global $base; global $phpdir; global $cfgdir; global $rsvdir; global $tmpdir; global $etcdir; global $usrdir; global $kwdir; global $kwbackupdir; global $schdir; global $logdir; global $radiko_recdir; global $radiru_recdir; global $timefree_recdir; global $radiru_vod_recdir; global $radiru_gogaku_recdir; global $pcastdir; global $launchdir; rf_mkdir($tmpdir); rf_mkdir($rsvdir); rf_mkdir($etcdir); rf_mkdir($usrdir); rf_mkdir($logdir); rf_mkdir($radiko_recdir); rf_mkdir($radiru_recdir); rf_mkdir($timefree_recdir); rf_mkdir($radiru_vod_recdir); rf_mkdir($radiru_gogaku_recdir); rf_mkdir($pcastdir); rf_mkdir($kwdir); rf_mkdir($kwbackupdir); rf_mkdir($schdir); rf_mkdir($cfgdir); $exeos = get_rfriends_exeos(); switch ($exeos) { case "WIN": $dir = "C:/tmp"; @rf_mkdir($dir); $phpini = $base."php.ini.win"; $to = $phpdir."php.ini"; if (file_exists($phpini)) { @rename($phpini,$to); } break; case "OSX": @rf_mkdir($launchdir); break; case "LNX": break; default: echo "--- rfriends_exeos is not defined.\n"; exit(1); break; } } function rf_ini($ar, $key) { if (array_key_exists($key, $ar)) { $val = $ar[$key]; } else { $val = ""; } return $val; } function rf_ini_chk($ar1, $ar2, $key, $rmin, $rmax) { if (array_key_exists($key, $ar1)) { $val = floor($ar1[$key]); if ($val >= $rmin && $val <= $rmax) { return $val; } } if (array_key_exists($key, $ar2)) { $val = floor($ar2[$key]); if ($val >= $rmin && $val <= $rmax) { return $val; } } $val = ""; return $val; } function check_dir($dir) { global $DS; if ($dir == "") { return false; } $newdir = realpath($dir); if ($newdir === false) { return false; } $newdir = $newdir.$DS; return $newdir; } function custom_dir($def, $orgdir, $dir, $cpath) { global $DS; if (!file_exists($def)) { file_put_contents($def, $orgdir, LOCK_EX); } if ($dir == "") { return false; } $newdir = realpath($dir); if ($newdir === false) { return false; } if ($cpath == "no") { $newdir = $dir; } else { $newdir = $newdir.$DS; } $nowdir = file_get_contents($def); if ($newdir == $nowdir) { return $nowdir; } file_put_contents($def, $newdir, LOCK_EX); return $newdir; } function set_tagdata($tagdata, $tagdata1) { global $fr_fmt; global $to_fmt; global $dt_fmt; global $nm_fmt; global $tag_fr_fmt; global $tag_to_fmt; global $tag_dt_fmt; global $tag_title_fmt; global $tag_artist_fmt; global $tag_album_fmt; global $tag_albumat_fmt; global $tag_genre_fmt; global $tag_year_fmt; global $tag_comment_fmt; global $tag_comment_fmt2; global $tag_track_fmt; $fr_fmt = rf_ini($tagdata, "fr_fmt"); $to_fmt = rf_ini($tagdata, "to_fmt"); $dt_fmt = rf_ini($tagdata, "dt_fmt"); $nm_fmt = rf_ini($tagdata, "nm_fmt"); $tag_fr_fmt = rf_ini($tagdata, "tag_fr_fmt"); $tag_to_fmt = rf_ini($tagdata, "tag_to_fmt"); $tag_dt_fmt = rf_ini($tagdata, "tag_dt_fmt"); $tag_title_fmt = rf_ini($tagdata, "tag_title_fmt"); $tag_artist_fmt = rf_ini($tagdata, "tag_artist_fmt"); $tag_album_fmt = rf_ini($tagdata, "tag_album_fmt"); $tag_albumat_fmt= rf_ini($tagdata, "tag_albumat_fmt"); $tag_genre_fmt = rf_ini($tagdata, "tag_genre_fmt"); $tag_year_fmt = rf_ini($tagdata, "tag_year_fmt"); $tag_comment_fmt= rf_ini($tagdata, "tag_comment_fmt"); $tag_comment_fmt2= rf_ini($tagdata, "tag_comment_fmt2"); $tag_track_fmt = rf_ini($tagdata, "tag_track_fmt"); return 0; } function set_inidata($inidata, $inidata1) { global $base; global $DS; global $usrdef; global $tmpdef; global $editor; global $usrdir; global $tmpdir; global $wake_to_run; global $sch_battery; global $dont_sleep; global $sch_daily; global $sch_daily_h; global $sch_daily_m; global $sch_daily2; global $sch_daily_h2; global $sch_daily_m2; global $sch_head; global $at_que_no; global $sch_rsv_radiko; global $sch_rsv_radiru; global $sch_rsv_timefree; global $sch_rsv_radiru_vod; global $sch_rsv_radiru_gogaku; global $sch_rsv_podcast; global $reserve_limit; global $reserve_limit_atonce; global $allow_limit; global $premium_mode; global $iTunes_add; global $iTunes_dir; global $iTunes_radiko; global $iTunes_radiru; global $iTunes_timefree; global $rftrans; global $rftrans_s; global $rftrans_dir; global $rftrans_radiko; global $rftrans_radiru; global $rftrans_timefree; global $rftrans_radiru_vod; global $rftrans_radiru_gogaku; global $rftrans_podcast; global $rftrans_codec; global $rftrans_codec_opt; global $radiko_double_rec; global $radiru_double_rec; global $timefree_double_rec; global $radiru_vod_double_rec; global $radiru_gogaku_double_rec; global $ex_radiko_delay; global $ex_radiko_pre_margin; global $ex_radiko_post_margin; global $premium_delay; global $premium_pre_margin; global $premium_post_margin; global $premium_priority; global $radiko_auth_mode; global $radiko_auth_mode2_url; global $radiko_auth_mode2_url2; global $radiko_auth_mode2_pref; global $radiko_auth_mode3_dat; global $radiko_delay; global $radiko_pre_margin; global $radiko_post_margin; global $radiru_apikey; global $radiru_delay; global $radiru_pre_margin; global $radiru_post_margin; global $radiko_reserve_daily; global $radiru_reserve_daily; global $radiko_reserve_now; global $radiru_reserve_now; global $ex_radiko_genre; global $premium_genre; global $radiko_genre; global $radiru_genre; global $timefree_genre; global $radiru_vod_genre; global $radiru_gogaku_genre; global $timefree_ng_rec; global $timefree_radiko_del; global $radiru_vod_radiru_del; global $radiru_gogaku_radiru_del; global $timefree_keyword_type; global $radiru_vod_keyword_type; global $timefree_timestamp; global $timefree_sleep; global $radiru_vod_timestamp; global $radiru_vod_sleep; global $radiru_gogaku_timestamp; global $podcast_timestamp; global $podcast_days; global $podcast_cnt; global $rfriends_task_kill; global $split_program; global $retry_rec; global $radiko_ng_rec_auto; global $radiko_callsign; global $radiru_callsign; global $auth_life_time_sw; global $standby_time; global $standby_time_m; global $radiru_vod_ignore_time; global $radiru_gogaku_ouchi_nendo; global $webdav_sw; global $storage_control_exec; global $storage_control_disk; global $storage_control_count; global $storage_control_exec_tr; global $storage_control_disk_tr; global $storage_control_count_tr; global $access_type; global $rfriends_name_esc; global $rfriends_name; global $rfriends_name_color; global $editor_cui; global $editor_gui; global $snd_player; global $editor_cui_win; global $editor_gui_win; global $snd_player_win; global $editor_cui_lnx; global $editor_gui_lnx; global $snd_player_lnx; global $editor_cui_osx; global $editor_gui_osx; global $snd_player_osx; global $headless_browser; global $headless_browser_app; global $update_check; global $download_aac; global $send_mail_mode; global $send_mail_remain; global $send_mail_host; global $send_mail_port; global $send_mail_user; global $send_mail_pass; global $send_mail_from; global $send_mail_from_nm; global $send_mail_to; global $send_mail_to_nm; global $send_mail_line_mode; global $send_mail_line_token; global $scr_width; global $scr_height; global $textbox_width; global $textbox_height; global $fname_max; global $tagname_max; global $replace_char_space; global $replace_char_spacej; global $replace_char_underline; global $failed_record_flag; global $in_ng_flag; global $out_ng_flag; global $log_lifetime; global $rfbackup; global $rfbackup_mode; global $rfbackup_dir; global $rfmove_dup; global $user_process; global $user_process2; global $user_file; global $rftrans_job_mode; global $hls_type; global $hls_app; global $hls_appver; global $hls_user; global $hls_dev; global $wget_opt; global $wget_opt_ext; global $wget_user_agent; global $wget_proxy; global $ffmpeg_useropt; global $ffmpeg_seekable; global $ffplay_useropt; global $ffplay_userbuf; global $bd_utl; global $bd_name; global $bd_address; $usrdir = $base."usr".$DS; $tmpdir = $base."tmp".$DS; $ini_usrdir = rf_ini($inidata, "usrdir"); $ini_tmpdir = rf_ini($inidata, "tmpdir"); $ret = custom_dir($usrdef, $usrdir, $ini_usrdir, "yes"); if ($ret != false) { $usrdir = $ret; } $ret = custom_dir($tmpdef, $tmpdir, $ini_tmpdir, "yes"); if ($ret != false) { $tmpdir = $ret; } $sch_daily = rf_ini($inidata1, "sch_daily"); $sch_daily2 = rf_ini($inidata1, "sch_daily2"); $sch_head = rf_ini($inidata1, "sch_head"); $at_que_no = rf_ini($inidata1, "at_que_no"); $ini_sch_daily = rf_ini($inidata, "sch_daily"); $ini_sch_daily2 = rf_ini($inidata, "sch_daily2"); $ini_sch_head = rf_ini($inidata, "sch_head"); $ini_at_que_no = rf_ini($inidata, "at_que_no"); if (($ini_sch_daily = rf_check_time2($ini_sch_daily)) !== false) { $sch_daily = $ini_sch_daily; } if (($ini_sch_daily2 = rf_check_time2($ini_sch_daily2)) !== false) { $sch_daily2 = $ini_sch_daily2; } $sch_daily_h = substr($sch_daily, 0, 2); $sch_daily_m = substr($sch_daily, 3, 2); $sch_daily_h2 = substr($sch_daily2, 0, 2); $sch_daily_m2 = substr($sch_daily2, 3, 2); if ($ini_sch_daily2 == "") { $sch_daily2 = ""; } if (preg_match('/^[a-zA-Z0-9]+$/', $ini_sch_head)) { $sch_head = $ini_sch_head; } if (preg_match('/^[c-z]+$/', $ini_at_que_no)) { $at_que_no = $ini_at_que_no; } $sch_rsv_radiko = rf_ini($inidata1, "sch_rsv_radiko"); $sch_rsv_radiru = rf_ini($inidata1, "sch_rsv_radiru"); $sch_rsv_timefree = rf_ini($inidata1, "sch_rsv_timefree"); $sch_rsv_radiru_vod = rf_ini($inidata1, "sch_rsv_radiru_vod"); $sch_rsv_radiru_gogaku = rf_ini($inidata1, "sch_rsv_radiru_gogaku"); $sch_rsv_podcast = rf_ini($inidata1, "sch_rsv_podcast"); $ini_sch_rsv_radiko = rf_ini($inidata, "sch_rsv_radiko"); $ini_sch_rsv_radiru = rf_ini($inidata, "sch_rsv_radiru"); $ini_sch_rsv_timefree = rf_ini($inidata, "sch_rsv_timefree"); $ini_sch_rsv_radiru_vod = rf_ini($inidata, "sch_rsv_radiru_vod"); $ini_sch_rsv_radiru_gogaku = rf_ini($inidata, "sch_rsv_radiru_gogaku"); $ini_sch_rsv_podcast = rf_ini($inidata, "sch_rsv_podcast"); if (strtolower($ini_sch_rsv_radiko) == "off") { $sch_rsv_radiko = "off"; } if (strtolower($ini_sch_rsv_radiru) == "off") { $sch_rsv_radiru = "off"; } if (strtolower($ini_sch_rsv_timefree) == "off") { $sch_rsv_timefree = "off"; } if (strtolower($ini_sch_rsv_radiru_vod) == "off") { $sch_rsv_radiru_vod = "off"; } if (strtolower($ini_sch_rsv_radiru_gogaku) == "off") { $sch_rsv_radiru_gogaku = "off"; } if (strtolower($ini_sch_rsv_podcast) == "off") { $sch_rsv_podcast = "off"; } $iTunes_dir = rf_ini($inidata, "iTunes_dir"); if ($iTunes_dir != "") { $idir = realpath($iTunes_dir.$DS); if ($idir !== false && file_exists($idir)) { $iTunes_dir = $idir.$DS; } else { $iTunes_add = 0; } } else { $iTunes_add = 0; } $rftrans_dir = rf_ini($inidata, "rftrans_dir"); if ($rftrans_dir != "") { $idir = realpath($rftrans_dir.$DS); if ($idir !== false && file_exists($idir)) { $iTunes_dir = $idir.$DS; } else { $rftrans = 0; } } else { $rftrans = 0; } $premium_genre = rf_ini($inidata, "premium_genre"); $radiko_genre = rf_ini($inidata, "radiko_genre"); $radiru_genre = rf_ini($inidata, "radiru_genre"); $timefree_genre = rf_ini($inidata, "timefree_genre"); $radiru_vod_genre = rf_ini($inidata, "radiru_vod_genre"); $radiru_gogaku_genre = rf_ini($inidata, "radiru_gogaku_genre"); $radiru_gogaku_ouchi_nendo = 1; $rfriends_task_kill = rf_ini($inidata, "rfriends_task_kill"); $radiko_reserve_daily = rf_ini_chk($inidata, $inidata1, "radiko_reserve_daily", 1, 7); $radiru_reserve_daily = rf_ini_chk($inidata, $inidata1, "radiru_reserve_daily", 1, 7); $radiko_reserve_now = rf_ini_chk($inidata, $inidata1, "radiko_reserve_now", 1, 7); $radiru_reserve_now = rf_ini_chk($inidata, $inidata1, "radiru_reserve_now", 1, 7); $wake_to_run = rf_ini_chk($inidata, $inidata1, "wake_to_run", 0, 1); $sch_battery = rf_ini_chk($inidata, $inidata1, "sch_battery", 0, 1); $dont_sleep = rf_ini_chk($inidata, $inidata1, "dont_sleep", 0, 1); $reserve_limit = rf_ini_chk($inidata, $inidata1, "reserve_limit", 1, 20); $reserve_limit_atonce = rf_ini_chk($inidata, $inidata1, "reserve_limit_atonce", 1, 100); $allow_limit = rf_ini_chk($inidata, $inidata1, "allow_limit", 0, 60); $premium_mode = rf_ini_chk($inidata, $inidata1, "premium_mode", 0, 1); $iTunes_add = rf_ini_chk($inidata, $inidata1, "iTunes_add", 0, 1); $iTunes_radiko = rf_ini_chk($inidata, $inidata1, "iTunes_radiko", 0, 2); $iTunes_radiru = rf_ini_chk($inidata, $inidata1, "iTunes_radiru", 0, 2); $iTunes_timefree = rf_ini_chk($inidata, $inidata1, "iTunes_timefree", 0, 2); $rftrans = rf_ini_chk($inidata, $inidata1, "rftrans", 0, 3); $rftrans_s = rf_ini_chk($inidata, $inidata1, "rftrans_s", 0, 3); $rftrans_radiko = rf_ini_chk($inidata, $inidata1, "rftrans_radiko", 0, 2); $rftrans_radiru = rf_ini_chk($inidata, $inidata1, "rftrans_radiru", 0, 2); $rftrans_timefree = rf_ini_chk($inidata, $inidata1, "rftrans_timefree", 0, 2); $rftrans_radiru_vod = rf_ini_chk($inidata, $inidata1, "rftrans_radiru_vod", 0, 2); $rftrans_radiru_gogaku = rf_ini_chk($inidata, $inidata1, "rftrans_radiru_gogaku", 0, 2); $rftrans_podcast = rf_ini_chk($inidata, $inidata1, "rftrans_podcast", 0, 2); $rftrans_codec = rf_ini_chk($inidata, $inidata1, "rftrans_codec", 0, 1); $rftrans_codec_opt = rf_ini($inidata, "rftrans_codec_opt"); $timefree_ng_rec = rf_ini_chk($inidata, $inidata1, "timefree_ng_rec", 0, 2); $auth_life_time_sw = rf_ini_chk($inidata, $inidata1, "auth_life_time_sw", 0, 1); $standby_time = rf_ini_chk($inidata,$inidata1,"standby_time" ,1,10); $standby_time_m = rf_ini_chk($inidata,$inidata1,"standby_time_m" ,1,10); if ($standby_time_m > $standby_time) $standby_time_m = $standby_time; $scr_width = rf_ini_chk($inidata, $inidata1, "scr_width", 40, 200); $scr_height = rf_ini_chk($inidata, $inidata1, "scr_height", 20, 200); $textbox_width = rf_ini_chk($inidata, $inidata1, "textbox_width", 40, 100); $textbox_height = rf_ini_chk($inidata, $inidata1, "textbox_height", 20, 100); $fname_max = rf_ini_chk($inidata, $inidata1, "fname_max", 1, 1024); $tagname_max = rf_ini_chk($inidata, $inidata1, "tagname_max", 1, 255); $replace_char_space = rf_ini($inidata, "replace_char_space"); $replace_char_spacej = rf_ini($inidata, "replace_char_spacej"); $replace_char_underline = rf_ini($inidata, "replace_char_underline"); $failed_record_flag = rf_ini_chk($inidata, $inidata1, "failed_record_flag", 0, 1); $in_ng_flag = rf_ini_chk($inidata, $inidata1, "in_ng_flag", 0, 2); $out_ng_flag = rf_ini_chk($inidata, $inidata1, "out_ng_flag", 0, 2); $log_lifetime = rf_ini_chk($inidata, $inidata1, "log_lifetime", 0, 366); $rfbackup = rf_ini_chk($inidata, $inidata1, "rfbackup", 0, 366); $rfbackup_mode = rf_ini($inidata, "rfbackup_mode"); $rfbackup_dir = rf_ini($inidata, "rfbackup_dir"); $rfmove_dup = rf_ini_chk($inidata, $inidata1, "rfmove_dup", 0, 2); $user_process = rf_ini_chk($inidata, $inidata1, "user_process", 0, 1); $user_process2 = rf_ini_chk($inidata, $inidata1, "user_process2", 0, 1); $user_file = rf_ini($inidata, "user_file"); $rftrans_job_mode = rf_ini_chk($inidata, $inidata1, "rftrans_job_mode", 0, 1); $premium_delay = rf_ini_chk($inidata, $inidata1, "premium_delay", 0, 59); $premium_pre_margin = rf_ini_chk($inidata, $inidata1, "premium_pre_margin", 0, 59); $premium_post_margin = rf_ini_chk($inidata, $inidata1, "premium_post_margin", 0, 59); $premium_priority = rf_ini_chk($inidata, $inidata1, "premium_priority", 0, 1); $radiko_auth_mode = rf_ini_chk($inidata, $inidata1, "radiko_auth_mode", 0, 4); if ($radiko_auth_mode == 2) { $radiko_auth_mode2_url = rf_ini($inidata, "radiko_auth_mode2_url"); $radiko_auth_mode2_url2 = rf_ini($inidata, "radiko_auth_mode2_url2"); $radiko_auth_mode2_pref = rf_ini_chk($inidata, $inidata1, "radiko_auth_mode2_pref", 0, 47); if ($radiko_auth_mode2_url == "") $radiko_auth_mode = 0; if ($radiko_auth_mode2_pref == 0) $radiko_auth_mode = 0; } $radiko_auth_mode3_dat = ""; if ($radiko_auth_mode == 3) { $radiko_auth_mode3_dat = rf_ini($inidata, "radiko_auth_mode3_dat"); } if ($radiko_auth_mode3_dat == "") $radiko_auth_mode3_dat = $base."radiko_gps.dat"; $radiko_delay = rf_ini_chk($inidata, $inidata1, "radiko_delay", 0, 59); $radiko_pre_margin = rf_ini_chk($inidata, $inidata1, "radiko_pre_margin", 0, 59); $radiko_post_margin = rf_ini_chk($inidata, $inidata1, "radiko_post_margin", 0, 59); $radiru_apikey = rf_ini($inidata, "radiru_apikey"); $radiru_delay = rf_ini_chk($inidata, $inidata1, "radiru_delay", 0, 59); $radiru_pre_margin = rf_ini_chk($inidata, $inidata1, "radiru_pre_margin", 0, 59); $radiru_post_margin = rf_ini_chk($inidata, $inidata1, "radiru_post_margin", 0, 59); $split_program = rf_ini_chk($inidata, $inidata1, "split_program", 0, 12); $retry_rec = rf_ini_chk($inidata, $inidata1, "retry_rec", 0, 9); $radiko_ng_rec_auto = rf_ini_chk($inidata, $inidata1, "radiko_ng_rec_auto", 0, 1); $radiko_callsign = rf_ini_chk($inidata, $inidata1, "radiko_callsign", 0, 1); $radiru_callsign = rf_ini_chk($inidata, $inidata1, "radiru_callsign", 0, 1); $radiko_double_rec = 0; $radiru_double_rec = 0; $timefree_double_rec = 0; $radiru_vod_double_rec = 0; $radiru_gogaku_double_rec = 0; $timefree_radiko_del = 0; $radiru_vod_radiru_del = 0; $radiru_gogaku_radiru_del = 0; $timefree_keyword_type = 1; $radiru_vod_keyword_type = 1; $timefree_timestamp = 1; $timefree_sleep = 2; $radiru_vod_timestamp = 1; $radiru_vod_sleep = 2; $radiru_gogaku_timestamp = 1; $podcast_timestamp = 1; $podcast_days = 8; $podcast_cnt = 1; $radiru_vod_ignore_time = 1; $radiko_double_rec = rf_ini_chk($inidata, $inidata1, "radiko_double_rec", 0, 2); $radiru_double_rec = rf_ini_chk($inidata, $inidata1, "radiru_double_rec", 0, 2); $timefree_double_rec = rf_ini_chk($inidata, $inidata1, "timefree_double_rec", 0, 2); $radiru_vod_double_rec = rf_ini_chk($inidata, $inidata1, "radiru_vod_double_rec", 0, 2); $radiru_gogaku_double_rec = rf_ini_chk($inidata, $inidata1, "radiru_gogaku_double_rec", 0, 2); $timefree_radiko_del = rf_ini_chk($inidata, $inidata1, "timefree_radiko_del", 0, 4); $radiru_vod_radiru_del = rf_ini_chk($inidata, $inidata1, "radiru_vod_radiru_del", 0, 4); $timefree_keyword_type = rf_ini_chk($inidata, $inidata1, "timefree_keyword_type", 0, 1); $radiru_vod_keyword_type= rf_ini_chk($inidata, $inidata1, "radiru_vod_keyword_type", 0, 1); $timefree_timestamp = rf_ini_chk($inidata, $inidata1, "timefree_timestamp", 0, 1); $radiru_vod_timestamp = rf_ini_chk($inidata, $inidata1, "radiru_vod_timestamp", 0, 1); $radiru_gogaku_timestamp = rf_ini_chk($inidata, $inidata1, "radiru_gogaku_timestamp", 0, 1); $podcast_timestamp = rf_ini_chk($inidata, $inidata1, "podcast_timestamp", 0, 1); $podcast_days = rf_ini_chk($inidata, $inidata1, "podcast_days", 1, 366); $podcast_cnt = rf_ini_chk($inidata, $inidata1, "podcast_cnt", 0, 10); $timefree_sleep = rf_ini_chk($inidata, $inidata1, "timefree_sleep", 0, 10); $radiru_vod_sleep = rf_ini_chk($inidata, $inidata1, "radiru_vod_sleep", 0, 10); $radiru_vod_ignore_time = rf_ini_chk($inidata, $inidata1, "radiru_vod_ignore_time", 0, 1); $webdav_sw = "on"; $webdav_sw = rf_ini($inidata, "webdav_sw"); $storage_control_exec = "stop"; $storage_control_disk = 0; $storage_control_count = 0; $storage_control_exec = rf_ini($inidata, "storage_control_exec"); $storage_control_disk = rf_ini($inidata, "storage_control_disk"); $storage_control_count = rf_ini_chk($inidata, $inidata1, "storage_control_count", 0, 200); $storage_control_exec_tr = "stop"; $storage_control_disk_tr = 0; $storage_control_count_tr = 0; $storage_control_exec_tr = rf_ini($inidata, "storage_control_exec_tr"); $storage_control_disk_tr = rf_ini($inidata, "storage_control_disk_tr"); $storage_control_count_tr = rf_ini_chk($inidata, $inidata1, "storage_control_count_tr", 0, 200); $ex_radiko_genre = $radiko_genre; $ex_radiko_delay = $radiko_delay; $ex_radiko_pre_margin = $radiko_pre_margin; $ex_radiko_post_margin = $radiko_post_margin; $access_type = rf_ini_chk($inidata, $inidata1, "access_type", 0, 1); $rfriends_name_esc = rf_ini($inidata, "rfriends_name_esc"); $rfriends_name_color = rf_ini($inidata, "rfriends_name_color"); $rfriends_name = rf_ini($inidata, "rfriends_name"); $editor_cui_win = rf_ini($inidata, "editor_cui_win"); $editor_gui_win = rf_ini($inidata, "editor_gui_win"); $snd_player_win = rf_ini($inidata, "snd_player_win"); $editor_cui_lnx = rf_ini($inidata, "editor_cui_lnx"); $editor_gui_lnx = rf_ini($inidata, "editor_gui_lnx"); $snd_player_lnx = rf_ini($inidata, "snd_player_lnx"); $editor_cui_osx = rf_ini($inidata, "editor_cui_osx"); $editor_gui_osx = rf_ini($inidata, "editor_gui_osx"); $snd_player_osx = rf_ini($inidata, "snd_player_osx"); $headless_browser = rf_ini($inidata, "headless_browser"); $headless_browser_app = rf_ini($inidata, "headless_browser_app"); $headless_browser = strtolower($headless_browser); if ($headless_browser != "on") $headless_browser = "off"; $update_check = rf_ini_chk($inidata, $inidata1, "update_check", 0, 1); $download_aac = rf_ini_chk($inidata, $inidata1, "download_aac", 0, 1); $send_mail_mode = rf_ini_chk($inidata, $inidata1, "send_mail_mode", 0, 3); $send_mail_remain = rf_ini_chk($inidata, $inidata1, "send_mail_remain", 0, 1000); $send_mail_host = rf_ini($inidata, "send_mail_host"); $send_mail_port = rf_ini($inidata, "send_mail_port"); $send_mail_user = rf_ini($inidata, "send_mail_user"); $send_mail_pass = rf_ini($inidata, "send_mail_pass"); $send_mail_from = rf_ini($inidata, "send_mail_from"); $send_mail_from_nm = rf_ini($inidata, "send_mail_from_nm"); $send_mail_to = rf_ini($inidata, "send_mail_to"); $send_mail_to_nm = rf_ini($inidata, "send_mail_to_nm"); $send_mail_line_mode = rf_ini_chk($inidata, $inidata1, "send_mail_line_mode", 0, 1); $send_mail_line_token = rf_ini($inidata, "send_mail_line_token"); $send_mail_line_mode = 0; $hls_app = rf_ini($inidata, "hls_app"); $hls_appver = rf_ini($inidata, "hls_appver"); $hls_user = rf_ini($inidata, "hls_user"); $hls_dev = rf_ini($inidata, "hls_dev"); $wget_inet4_only = rf_ini_chk($inidata, $inidata1, "wget_inet4_only", 0, 2); $wget_no_check_certificate = rf_ini_chk($inidata, $inidata1, "wget_no_check_certificate", 0, 1); $wget_opt = rf_ini($inidata, "wget_opt"); $wget_opt_ext = rf_ini($inidata, "wget_opt_ext"); $wget_user_agent = rf_ini($inidata, "wget_user_agent"); $wget_proxy = rf_ini($inidata, "wget_proxy"); if ($wget_inet4_only == 1) { $wget_opt .= " --inet4-only"; $wget_opt_ext .= " --inet4-only"; } if ($wget_inet4_only == 2) { $wget_opt .= " --inet6-only"; $wget_opt_ext .= " --inet6-only"; } if ($wget_no_check_certificate == 1) { $wget_opt .= " --no-check-certificate"; } $ffplay_userbuf = rf_ini_chk($inidata, $inidata1, "ffplay_userbuf", 0, 180); $ffmpeg_seekable = rf_ini_chk($inidata, $inidata1, "ffmpeg_seekable", 0, 2); $bd_utl = rf_ini_chk($inidata, $inidata1, "bd_utl", 0, 1); $bd_name = rf_ini($inidata, "bd_name"); if ($bd_name == "") $bd_name = "unknown"; $bd_address = trim(rf_ini($inidata, "bd_address")); return 0; } 