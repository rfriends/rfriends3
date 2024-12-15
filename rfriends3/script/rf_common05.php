<?php
 function callsign2($channel) { global $radiru_callsign_r1; global $radiru_callsign_r2; global $radiru_callsign_fm; global $radiru_ch; global $radiru_r1; global $radiru_r2; global $radiru_r3; global $radiru_area_1; $chx = explode("_", $channel); $ch = $chx[0]; if (count_73($chx) <= 1) { $area = $radiru_area_1; } else { $area = $chx[1]; } switch ($ch) { case $radiru_r1: $ch_cs = $radiru_callsign_r1[$area]; break; case $radiru_r2: $ch_cs = $radiru_callsign_r2; break; case $radiru_r3: $ch_cs = $radiru_callsign_r1[$area].$radiru_callsign_fm; break; default: $ch_cs = "UNKNOWN"; break; } return $ch_cs; } function rf_capacity_check($fromtime,$totime) { global $usrdir; global $tmpdir; global $space_min; global $tmp_space_min; $sunit = 6; $fsusr = f_space($usrdir) - $space_min; $fstmp = f_space($tmpdir) - $tmp_space_min; if ($fsusr < 0 ) $fsusr = 0; if ($fstmp < 0 ) $fstmp = 0; $est = strtotime($totime) - strtotime($fromtime); if ($est < 0) $est += (24 * 3600); $estm = floor(($est + 59)/60); $estsize = floor(($est * $sunit + 1023)/1024); echo_prn(1, "$usrdir : $fsusr MB"); echo_prn(1, "$tmpdir : $fstmp MB"); echo_prn(1, "required capacity: $estsize MB ($estm min)"); if ($fsusr < $estsize) { return false; } if ($fstmp >= $estsize) return true; return false; } function rf_space_check($fn) { global $space_min; global $tmp_space_min; global $DS; $fs = floor( filesize($fn) / 1024 / 1024 ); $dir = dirname($fn).$DS; $fsdir = f_space($dir) - $tmp_space_min; echo_prn(1, ""); echo_prn(1, "file size : $fs MB"); echo_prn(1, "$dir : $fsdir MB"); if ($fsdir < $fs) { return false; } return true; } function check_atomicparsley_img($file) { if ($file == null) return false; $part = file_get_contents($file, FALSE, NULL, 0, 8); if ($part === false) return false; if (strncmp($part,"\x89\x50\x4E\x47\x0D\x0A\x1A\x0A",8) == 0) return true; if (strncmp($part,"\xFF\xD8\xFF\xE0",4) == 0) return true; if (strncmp($part,"\xFF\xD8\xFF\xE1",4) == 0) return true; echo_prn(1,"image type error : ".bin2hex($part)); return false; } function set_tag_img($ex_type, $tmpfn, $ext, $para, $para2, $rf_head, $rf_foot) { global $add_img; global $ex_podcast; $app = rfgw_addimg_app(); if ($ex_type == $ex_podcast) $app = ""; if ($app == "AtomicParsley") { echo_prn(1, str_repeat("-", 40)); time_prn(1, "AtomicParsley addtag start"); $tag_ar = tag_edit($app, $para, $ex_type, $rf_head, $rf_foot); $fn = null; if ($add_img == 1) { $fn = get_art_img($tmpfn, $ext, $para2); if ($fn === false) { echo_prn(1, "addtag_img error (invalid image or not found)"); } else { $tag_ar["artwork"] = $fn; } } $ret = set_tag($app, $tmpfn, $ext, $tag_ar, $para); if ($ret != 0) { echo_prn(2, "add tag error"); } if ($fn != null) fin_unlink($fn); return; } $tmpfnext = $tmpfn.'.'.$ext; echo_prn(1, str_repeat("-", 40)); time_prn(1, "addtag start"); $ret = get_metadata("genre",$tmpfnext); if ($ret !== false) { echo_prn(1,"すでにtagが設定されています。"); } else { $app = "ffmpeg"; $tag_ar = tag_edit($app, $para, $ex_type, $rf_head, $rf_foot); $ret = set_tag($app, $tmpfn, $ext, $tag_ar, $para); if ($ret != 0) { echo_prn(2, "add tag error"); } } if ($add_img == 1) { echo_prn(1, str_repeat("-", 40)); time_prn(1,"add image start"); if ($ex_type == $ex_podcast) { $ret = get_artwork($tmpfnext,$tmpfn.'.jpg'); fin_unlink($tmpfn.'.jpg'); if ($ret !== false) { echo_prn(1,"すでにartworkが設定されています。"); return; } $fn = get_art_img($tmpfn, $ext, $para2); if ($fn === false) { echo_prn(1, "addtag_img error (invalid image or not found)"); return; } $app = 'ffmpeg'; echo_msg(2,"$tmpfn  $ext  $fn"); $ret = addtag_img($app, $tmpfn, $ext, $fn); fin_unlink($fn); } else { $ret = rf_addimg($tmpfn, $ext, $para2); } if ($ret != 0) { echo_prn(2, "add image error"); } } } function get_art_img($output, $ext, $para) { global $base; global $station_logo_url; $img = $para[9]; $iext = pathinfo($img, PATHINFO_EXTENSION); if ($iext == null) { $fn = $output; } else { $fn = "$output.$iext"; } echo_prn(1, "get_art_img $img"); if (get_art_img_s($img,$fn) !== false) { echo_prn(1, "[ok] $img"); echo_prn(1, "$img -> $fn"); $ret = check_atomicparsley_img($fn); if ($ret !== false) { return $fn; } else { if ($iext == "jpg" || $iext == "jpeg") { $fn2 = $output.".png"; $ret = rf_ffmpeg_conv($fn,$fn2); if ($ret === true) { echo_prn(1, "jpg -> png"); return $fn2; } } echo_prn(1, "[err chk type] $img"); } } else { echo_prn(1, "[err get] $img"); } fin_unlink($fn); $channel = $para[6]; $ch_cs = callsign2($channel); if ($ch_cs == "UNKNOWN") { $ch_cs = $channel; } $img = sprintf($station_logo_url, $ch_cs); $iext = pathinfo($img, PATHINFO_EXTENSION); if ($iext == null) { $fn = $output; } else { $fn = "$output.$iext"; } if (get_art_img_s($img,$fn) !== false) { echo_prn(1, "[ok ch] $img"); echo_prn(1, "$img -> $fn"); $ret = check_atomicparsley_img($fn); if ($ret !== false) { return $fn; } else { echo_prn(1, "[err ch chk type] $img"); } } else { echo_prn(1, "[err ch get] $img"); } fin_unlink($fn); return false; } function get_art_img_s($img,$fn) { if (strlen($img) < 5) return false; if (($npos = strpos($img, "http")) === false) { if (rf_copy($img, $fn) === false) { fin_unlink($fn); return false; } } else { if (rf_wget($img, $fn, "") === false) { fin_unlink($fn); return false; } } if (!file_exists($fn)) { return false; } rf_touch($fn); return true; } function addtag_img($app, $output, $ext, $fn) { if ($app == "ffmpeg") { $tag = " -i $fn -disposition:v:1 attached_pic -map 0 -map 1 -c copy -id3v2_version 3 "; $exec_cmd = "$app -i $output.$ext $tag $output.tmp.$ext"; echo_prn(1, "$exec_cmd"); $ret = external_program_null($exec_cmd); if ($ret != 0) { echo_prn(1, "$app addtag (with image) $ret"); return $ret; } $ret = rf_move("$output.tmp.$ext", "$output.$ext"); if ($ret === false) return 1; return 0; } if ($app == "neroAacTag") { $tag = " -add-cover:front:$fn"; $exec_cmd = "$app $tag $output.$ext"; echo_prn(1, "$exec_cmd"); $ret = external_program($exec_cmd); } if ($app == "mp4tags") { $tag = " -picture $fn"; $exec_cmd = "$app $tag $output.$ext"; echo_prn(1, "$exec_cmd"); $ret = external_program($exec_cmd); } if ($app == "AtomicParsley") { $exec_cmd = "$app $output.$ext --artwork $fn --overWrite"; echo_prn(1, "$exec_cmd"); $ret = external_program_null($exec_cmd); } return $ret; } function set_tag($app, $output, $ext, $tag_ar, $para) { switch($app) { case "mp4tags": $ret = set_mp4tags_tag($output, $ext, $tag_ar, $para); break; case "AtomicParsley": $ret = set_atomicparsley_tag($output, $ext, $tag_ar, $para); break; case "ffmpeg": default: $ret = set_ffmpeg_tag($output, $ext, $tag_ar, $para); break; } return $ret; } function set_atomicparsley_tag($output, $ext, $tag_ar, $para) { global $ffmpeg_tag_opt; global $add_img; $app = "AtomicParsley"; $tag = ""; foreach ($tag_ar as $key => $val) { $tagval = " --$key \"$val\""; $tag .= $tagval; } $exec_cmd = "$app $output.$ext $tag --overWrite"; echo_msg(2, "$exec_cmd"); $ret = external_program_null($exec_cmd); if ($ret != 0) { echo_msg(2, "add_tag error"); return 0; } return 0; } function rf_ffmpeg_conv($in,$out) { $exec_cmd = "ffmpeg -i $in $out"; $ret = external_program_null($exec_cmd); if ($ret != 0) { fin_unlink($out); return false; } $ret = check_atomicparsley_img($out); if ($ret === true) { fin_unlink($in); rf_touch($out); } else { fin_unlink($out); } return $ret; } function set_ffmpeg_tag($output, $ext, $tag_ar, $para) { global $ffmpeg_tag_opt; global $add_img; $app = "ffmpeg"; $tag = ""; foreach ($tag_ar as $key => $val) { $tagval = " -metadata \"$key\"=\"$val\""; $tag .= $tagval; } $exec_cmd = "$app -i $output.$ext $ffmpeg_tag_opt $tag -y $output.tmp.$ext"; echo_msg(2, "$exec_cmd"); $ret = external_program($exec_cmd); if ($ret != 0) { echo_msg(2, "add_tag error"); fin_unlink("$output.tmp.$ext"); return 0; } fin_unlink("$output.$ext"); echo_msg(2, "$output.tmp.$ext -> $output.$ext"); rf_move("$output.tmp.$ext", "$output.$ext"); return 0; } function set_mp4tags_tag($output, $ext, $tag_ar, $para) { global $add_img; global $base; global $station_logo_url; $app = "mp4tags"; $tag = ""; foreach ($tag_ar as $key => $val) { $tagval = " -$key \"$val\""; $tag .= $tagval; } if ($add_img == 1) { $img = $para[9]; echo_prn(1, "para9 $img"); if (strlen($img) < 5) { $channel = $para[6]; $ch_cs = get_radiru_callsign($channel); if ($ch_cs == "UNKNOWN") { $ch_cs = $channel; } $img = sprintf($station_logo_url, $ch_cs); echo_prn(1, "$ch_cs $img"); } $iext = pathinfo($img, PATHINFO_EXTENSION); $fn = "$output.$iext"; $fn2 = "$output.png"; echo_prn(1, "$img -> $fn"); $url = "\"$img\""; if (rf_wget($url, $fn, "") === true) { } } $exec_cmd = "$app $tag $output.$ext"; echo_msg(2, "$exec_cmd"); $ret = external_program($exec_cmd); fin_unlink($fn); echo_prn(1, "$app addtag"); return 0; } function get_genre($ex_type) { global $ex_radiko_genre; global $radiko_genre; global $radiru_genre; global $timefree_genre; global $radiru_vod_genre; global $radiru_gogaku_genre; global $ex_radiko; global $ex_radiru; global $ex_timefree; global $ex_radiru_vod; global $ex_radiru_gogaku; switch ($ex_type) { case $ex_radiko: case 3: $genre = $ex_radiko_genre; break; case $ex_radiru: case 4: case 6: $genre = $radiru_genre; break; case $ex_timefree: $genre = $timefree_genre; break; case $ex_radiru_vod: $genre = $radiru_vod_genre; break; case $ex_radiru_gogaku: $genre = $radiru_gogaku_genre; break; default: $genre = "radio"; break; } return $genre; } function get_short_title($ex_type,$title) { global $ex_radiko; global $ex_radiru; global $ex_timefree; global $ex_radiru_vod; global $ex_radiru_gogaku; global $replace_char_space; $ttl[0] = $title; $ttl_delm = $replace_char_space; switch ($ex_type) { case $ex_radiko: case 3: break; case $ex_radiru: case 4: case 6: $ttl = explode($ttl_delm, $title); break; case $ex_timefree: break; case $ex_radiru_vod: $ttl = explode($ttl_delm, $title); break; case $ex_radiru_gogaku: $ttl = explode($ttl_delm, $title); break; default: break; } return $ttl[0]; } function tag_edit($app, $para, $ex_type, $rf_head, $rf_foot) { global $tag_fr_fmt; global $tag_to_fmt; global $tag_dt_fmt; global $tag_title_fmt; global $tag_artist_fmt; global $tag_album_fmt; global $tag_albumat_fmt; global $tag_genre_fmt; global $tag_year_fmt; global $tag_comment_fmt; global $tag_comment_fmt2; global $tag_track_fmt; global $dlmt; global $ex_podcast; $ft = $para[0]; $tt = $para[1]; $duration = $para[2]; $channel = fn_edit($para[6]); $title = fn_edit($para[7]); $artist = fn_edit($para[8]); $kw = fn_edit($para[10]); if ($artist == $dlmt) { $artist = " "; } if ($kw == $dlmt) { $kw = " "; } $ft2 = date($tag_fr_fmt, get_mktime($ft)); $tt2 = date($tag_to_fmt, get_mktime($tt)); $dt2 = date($tag_dt_fmt, get_mktime($ft)); $fromtime = fn_edit($ft2); $totime = fn_edit($tt2); $dttime = fn_edit($dt2); $genre = get_genre($ex_type); $wno = date("W", strtotime($ft)); $short_title = get_short_title($ex_type,$title); $musiclist = fn_edit($para[18]); if ($musiclist == $dlmt) $musiclist = ""; $p[0] = $fromtime; $p[1] = $totime; $p[2] = $duration; $p[3] = $channel; $p[4] = $title; $p[5] = $artist; $p[6] = $kw; $p[7] = $dttime; $p[8] = $genre; $p[9] = $wno; $p[10] = $short_title; $p[11] = $musiclist; if ($ex_type == $ex_podcast) { $p[10] = $p[11]; } $t_title = $rf_head.vsprintf($tag_title_fmt, $p).$rf_foot; $t_artist = vsprintf($tag_artist_fmt, $p); $t_album = vsprintf($tag_album_fmt, $p); $t_albumartist = vsprintf($tag_albumat_fmt, $p); $t_genre = vsprintf($tag_genre_fmt, $p); $t_year = vsprintf($tag_year_fmt, $p); $t_comment = vsprintf($tag_comment_fmt, $p); $t_tracknum = vsprintf($tag_track_fmt, $p); if ($t_comment == "") $t_comment = vsprintf($tag_comment_fmt2, $p); switch ($app) { case "mp4tags": $tag_ar = array( "song" => $t_title, "artist" => $t_artist, "album" => $t_album, "albumartist" => $t_albumartist, "genre" => $t_genre, "year" => $t_year, "comment" => $t_comment, "track" => $t_tracknum ); break; case "AtomicParsley": $tag_ar = array( "title" => $t_title, "artist" => $t_artist, "album" => $t_album, "albumArtist" => $t_albumartist, "genre" => $t_genre, "year" => $t_year, "comment" => $t_comment, "tracknum" => $t_tracknum ); break; case "ffmpeg": default: $tag_ar = array( "title" => $t_title, "artist" => $t_artist, "album" => $t_album, "album_artist" => $t_albumartist, "genre" => $t_genre, "date" => $t_year, "comment" => $t_comment, "track" => $t_tracknum ); break; } return $tag_ar; } function copy_config() { global $defdir; global $cfgdir; global $config_def; global $config_bas; global $ext_sys; global $ext_usr; global $config_user; global $config_u; $def = ""; $bak = ".bak"; $src = $defdir.$config_def.$ext_usr.$def; $dst = $cfgdir.$config_def.$ext_usr; if (!file_exists($dst)) { rf_copy($src, $dst); echo_msg(2, "copy : $dst"); } $src = $defdir.$config_bas.$ext_usr.$def; $dst = $cfgdir.$config_bas.$ext_usr; if (file_exists($dst)) { rf_move($dst, $dst.$bak); echo_msg(2, "rename : $dst.$bak"); } rf_copy($src, $dst); echo_msg(2, "copy : $dst"); } function rfmenu_title($nw) { global $usrdir; global $tmpdir; global $area_code; global $home_area_code; global $nowarea; global $rfriends_ver; global $rfriends_parts; global $sch_head; global $at_que_no; global $radiru_area_1; global $radiru_main_station; global $launch_at_head; global $premium; global $cookiefile; global $rfname; global $premium_home_area_code; global $radiko_auth_mode; global $hls_type; global $hls_user; global $rftitle; global $rfsubtitle; global $ui_mode; global $scr_width; global $scr_height; global $wget_opt_https_proxy; global $wget_opt_proxy_user; global $wget_opt_proxy_pass; global $radiko_auth_mode3_dat; $dt = date("y/m/d(D) H:i:s", $nw); $temp = rfgw_rasp_temp(); $tx11 = $rfriends_parts[0]; $tx12 = ""; $tx13 = $rfriends_parts[3]; $tx2 = ""; $tx3 = ""; $tx4 = ""; if ($temp > 0) { $tx4 = " $temp"."ﾟC"; } if (premium_check() > 0) { $hls_type = 0; } $ver = rf_ext_ver(); if ($ver !== false) { $tx2 = "G"; } if ($scr_width < 50) { $dt = date("m/d H:i:s", $nw); $rftitle = "$tx11 $tx13 [$dt]"; } else { $rftitle = "$tx11$tx12 $tx13 [$dt$tx3$tx4]"; } $rfsubtitle = array(); $lists = array(); if ($ui_mode == 0) { echo_scr(2, ""); echo_scr(2, "$rftitle"); } else if ($ui_mode == 2) { $dt1 = date("Y/m/d  (D)", $nw); $tm1 = date("H:i:s", $nw); $lists['Date'] = $dt1; $lists['Time'] = $tm1; if ($tx4 != '') { $lists['Temp'] = $tx4; } $lists['Ver.'] = "$tx13"; $lists['-'] = ""; } $msg1 = $rfname; $pmode = premium_check(); if ($pmode > 0) { if(file_exists($cookiefile)) { $login_status = "(+)"; } else { $login_status = ""; } $ptest= ""; if ($pmode == 2) $ptest = "_t"; if ($pmode == 2 && $tx2 == "G") $ptest = "_x"; if ($ui_mode == 2) { $lists["premium".$ptest.$login_status] = "main: $premium_home_area_code  home: $home_area_code"; } else { echo_msg(2," premium".$ptest.$login_status."  main: $premium_home_area_code  home: $home_area_code"); } } $radiko_ext = ""; switch($radiko_auth_mode) { case 0: break; case 1: $radiko_ext .= "_1"; break; case 2: $radiko_ext .= "_2"; break; case 3: $radiko_ext .= "_3"; break; case 4: $radiko_ext .= "_4"; break; default: $radiko_ext .= "_?"; break; } if ($wget_opt_https_proxy != "") { $radiko_ext .= "_@"; } $radiko_ttl = "$nowarea"; if ($radiru_area_1 == $radiru_main_station) { $radiru_ttl = $radiru_area_1; } else { $radiru_ttl = $radiru_area_1."(m:".$radiru_main_station.")"; } if ($ui_mode == 0) { echo_msg(2," radiko: $radiko_ttl  radiru: $radiru_ttl"); } else if ($ui_mode == 2) { if ($radiko_auth_mode == 3) { $gps = rf_get_mode3_dat($radiko_auth_mode3_dat); if ($gps === false) { $lat = 0; $lon = 0; } else { $lat = $gps[0]; $lon = $gps[1]; } $radiko_ttl .= "($lat,$lon)"; } $lists['radiko'.$radiko_ext] = $radiko_ttl; $lists['radiru'] = $radiru_ttl; $ttl = ""; rf_tabledisp($ttl,$lists,"left"); } } function rf_tabledisp($ttl,$flists,$al) { global $ui_mode; if ($ttl != "") { echo_msg(2,$ttl); echo_msg(2,""); } if ($ui_mode == 2) { msgx("<table>"); foreach($flists as $key => $val) { if ($key == "-") { msgx("<tr>"); msgx("<td>　</td>"); msgx("<td> </td>"); msgx("<td> </td>"); msgx("</tr>"); } else { msgx("<tr>"); msgx("<td>$key</td>"); msgx("<td> : </td>"); msgx("<td align=$al>&nbsp;$val</td>"); msgx("</tr>"); } } msgx("</table>"); } else { $ln = 0; foreach($flists as $key => $val) { $ln2 = mb_strlen($key); if ($ln2 > $ln) $ln = $ln2; } foreach($flists as $key => $val) { $key2 = mb_substr($key.str_repeat("　",$ln),0,$ln); echo_msg(2,"$key2 : $val"); } } } function rf_system_info($ex_type) { global $rfriends_ver; global $os_s; global $os_l; global $usrdir; global $tmpdir; global $wake_to_run; global $sch_battery; global $dont_sleep; global $nowarea; global $area_code; global $home_area_code; global $premium_area; global $premium; global $premium_areafree; global $premium_timefree30; global $premium_home_area_code; global $ex_radiko; global $ex_timefree; echo_prn(1, $rfriends_ver); $free_space = f_space($usrdir); $fs_mb = number_format($free_space); echo_prn(1, "usrdir  : $usrdir   (free $fs_mb MB)"); echo_prn(1, "tmpdir  : $tmpdir"); switch ($ex_type) { case $ex_radiko: case $ex_timefree: auth_ex(0); $p = premium_check(); echo_prn(1, ""); echo_prn(1, "area_code : $area_code  home_area_code : $home_area_code"); if ($p > 0) { if ($premium_home_area_code == "") $premium_home_area_code = $home_area_code; echo_prn(1, ""); echo_prn(1, "premium              : $premium"); echo_prn(1, "premium_areafree     : $premium_areafree"); echo_prn(1, "premium_timefree30   : $premium_timefree30"); echo_prn(1, "premium_main_station : $premium_home_area_code"); } break; default: break; } echo_prn(1, ""); echo_prn(1, "スリープ: 解除:$wake_to_run 監視:$dont_sleep battery駆動:$sch_battery"); } function rf_val_search($data, $val) { for ($i=0; $i<count_73($data); $i++) { $n = strpos($data[$i], $val); if ($n === false) { continue; } return $i; } return false; } function rf_get_wdata($fnm, $ex_type) { global $rsvdir; global $tmpdir; global $ex_radiko; global $ex_radiru; global $ex_timefree; global $ex_radiru_vod; global $ex_radiru_gogaku; $fn = "$fnm.dat"; switch($ex_type) { case $ex_timefree: case $ex_radiru_vod: case $ex_radiru_gogaku: $fnp = $tmpdir.$fn; break; case $ex_radiko: case $ex_radiru: default: $fnp = $rsvdir.$fn; break; } if (!file_exists($fnp)) { echo_msg(2, "Reservation file not found : $fnp"); exit(1); } $wdat = file($fnp); if ($wdat === false) { echo_msg(2, "Reservation file read error : $fnp"); exit(1); } $wdata = rtrim($wdat[0]); return $wdata; } function rf_put_wdata($fnm, $wdata) { global $rsvdir; $fn = $rsvdir. $fnm.".dat"; $ret = file_put_contents($fn, $wdata."\n", LOCK_EX); return $ret; } function rf_put_wdat_all($fn, $wdat) { fin_unlink($fn); rf_touch($fn); foreach ($wdat as $wdata) { file_put_contents($fn, $wdata.PHP_EOL, FILE_APPEND | LOCK_EX); } return; } function rf_put_wdat_all_tmpdir($opt_fn, $wdat) { global $tmpdir; $fn = $tmpdir.$opt_fn.".dat"; rf_put_wdat_all($fn, $wdat); return; } function rf_make_wdata( $ft, $to, $dur, $failed_record, $in_ng, $out_ng, $chx, $title, $artist, $img, $kw, $prog_id, $jobno, $jparea, $area, $album, $genre, $genrec, $musiclist ) { $wdata = "$ft $to $dur $failed_record $in_ng $out_ng $chx $title $artist $img $kw $prog_id $jobno $jparea $area $album $genre $genrec $musiclist"; return $wdata; } function rf_simplexml_load_string($xml) { libxml_use_internal_errors(true); $obj = simplexml_load_string($xml); if ($obj !== false) { libxml_use_internal_errors(false); return $obj; } libxml_use_internal_errors(false); return $obj; } 