<?php
 function dispsch_lnx($atqueno, $typ) { $n = 0; return $n; } function rf_get_editno($fn) { global $kwdir; global $cfgdir; global $base; global $edit_fn; if (array_key_exists($fn, $edit_fn)) { $val = $edit_fn[$fn]; return $val[0]; } else { return false; } } function rf_ps_lnx($dat) { global $tmpdir; global $scrdir; $nostime = 0; $op1 = strtolower("uid,pid,stime,command"); $ex = "ps x -o $op1"; exec($ex." 2>/dev/null", $data, $ret); if ($ret != 0) { $nostime = 1; $op2 = strtolower("uid,pid,time,command"); $ex = "ps x -o $op2"; exec($ex." 2>/dev/null", $data, $ret); if ($ret != 0) { return false; } } foreach ($data as $val) { if (strpos($val,$dat) !== false) { return $val; } } return false; } function rf_ffmpeg_pid_lnx($mode) { global $tmpdir; global $scrdir; $nostime = 0; $op1 = strtolower("uid,pid,stime,command"); $ex = "ps x -o $op1"; exec($ex." 2>/dev/null", $data, $ret); if ($ret != 0) { $nostime = 1; $op2 = strtolower("uid,pid,time,command"); $ex = "ps x -o $op2"; exec($ex." 2>/dev/null", $data, $ret); if ($ret != 0) { return array(); } } $pid_data = array(); foreach ($data as $val) { $val2 = preg_replace('/\s+/', ' ', trim($val)); $dat = explode(" ", $val2); if (count_73($dat) < 4) { continue; } if (strpos($dat[3], "ffmpeg") === false) { continue; } $ret1 = rf_val_search($dat, $tmpdir); if ($ret1 === false) { continue; } if ($nostime == 1) { $dat[2] = ""; } $t = $dat[2]; $dat[2] = str_replace('.', ':', $t); $ret2 = rf_val_search($dat, "encoder"); if ($ret2 === false) { $encoder = "unknown"; } else { $encoder = $dat[$ret2]; } $fmt = "$dat[1],$encoder,$dat[2],$dat[$ret1]"; $pid_data[] = $fmt; } if ($mode != 1) { return $pid_data; } $dontsleep = $scrdir."rfriends_dontsleep.php"; $pid_data2 = array(); foreach ($data as $val) { $val2 = preg_replace('/\s+/', ' ', trim($val)); $dat2 = explode(" ", $val2); if (count_73($dat2) < 6) { continue; } $pid = $dat2[1]; $tim = $dat2[2]; $cmd1 = $dat2[3]; $cmd2 = $dat2[4]; $cmd3 = $dat2[5]; if (strpos($cmd2, $dontsleep) === false) { continue; } $dat3 = explode(",", $cmd3); if (count_73($dat3) < 2) { continue; } $fn = $dat3[1]; $hit = 0; foreach ($pid_data as $pdat) { if (strpos($pdat, $fn) !== false) { $hit = 1; break; } } if ($hit == 0) { $encoder = "standby"; $fmt = "$pid,$encoder,$tim,$fn"; $pid_data2[] = $fmt; } } $pid_data = array_merge($pid_data, $pid_data2); return $pid_data; } function rf_ffplay_pid_lnx() { global $tmpdir; global $scrdir; $nostime = 0; $op1 = strtolower("uid,pid,command"); $ex = "ps x -o $op1"; $data = array(); exec($ex." 2>/dev/null", $data, $ret); $cnt = count_73($data); if ($ret != 0 || $cnt <= 1) { $ex = "ps ax -o $op1"; $data = array(); exec($ex." 2>/dev/null", $data, $ret); $cnt = count_73($data); if ($ret != 0 || $cnt <= 1) { return array(); } } $pid_data = array(); foreach ($data as $val) { $val2 = preg_replace('/\s+/', ' ', trim($val)); $dat = explode(" ", $val2); $n = count_73($dat); if ($n < 3) { continue; } if (strpos($dat[2], "ffplay") === false) { continue; } if (($p = strpos($val2, "-window_title")) === false) { continue; } $val2 = substr($val2,$p); if (($p = strpos($val2, "rfriends")) === false) { continue; } $val2 = substr($val2,$p); $val3 = explode(" ",$val2,2); $ch = str_replace("rfriends_","",$val3[0]); $fil = $dat[$n-1]; $fmt = "$dat[1],$ch,$fil"; $pid_data[] = $fmt; } return $pid_data; } function rf_get_at_jobsh($jobno) { for($i= 0;$i<5;$i++) { $jobsh = @exec("at -c $jobno 2>/dev/null", $retval); if ($jobsh !== false) break; sleep(1); } if ($jobsh === false) { return false; } $jobsh2 = explode(" ", $jobsh); if (count_73($jobsh2) != 2) { $retvaln = count_73($retval); if ($retvaln < 2) { return false; } $jobsh = $retval[$retvaln - 2]; $jobsh2 = explode(" ", $jobsh); if (count_73($jobsh2) != 2) { return false; } } if ($jobsh2[0] != "sh") { return false; } if (strpos($jobsh2[1], ".sh") === false) { return false; } if (!file_exists($jobsh2[1])) { return false; } return $jobsh; } function rf_schdsp_linux_sub($jobno) { $ret = rf_get_at_jobsh($jobno); if ($ret === false) { return null; } $jobsh2 = explode(" ", $ret); $jobsh3 = str_replace(".sh", ".dat", $jobsh2[1]); if (file_exists($jobsh3)) { $wdata = file_get_contents($jobsh3); } else { $jobsh = exec("atrm $jobno"); $wdata = null; } return $wdata; } function get_schdata_cnt_linux($atqueno, $ex_type) { $schdata_cnt = 0; exec("atq -q $atqueno", $output, $ret); foreach ($output as $value) { $job = explode("\t", $value); $wdata = rf_schdsp_linux_sub($job[0]); if ($wdata != null) { $schdata_cnt++; } } return $schdata_cnt; } function get_schdata_cnt_linux_simple($atqueno) { $schdata_cnt = 0; exec("atq -q $atqueno", $output, $ret); return count_73($output); } function at_reserve_lnx($atqueno, $sttime, $fnm, $bs) { global $scrdir; global $base; global $wake_to_run; $at_arg = "sh $bs"; $jobno = rfgw_at_check($atqueno, $at_arg); if ($jobno < 0) { $dat = str_replace(".sh","dat",$bs); fin_unlink($bs); fin_unlink($dat); return 0; } if ($jobno > 0) { rfgw_at_rm($jobno); } $at = "at -q $atqueno ".date('H:i m/d/Y', $sttime); echo_msg(0, "$at : $at_arg"); $desc = array( 0 => array("pipe", "r"), 1 => array("pipe", "w"), 2 => array("pipe", "w") ); if (($proc = proc_open($at, $desc, $pipe))) { fputs($pipe[0], $at_arg); fclose($pipe[0]); fclose($pipe[2]); fclose($pipe[1]); proc_close($proc); } $ret = 0; return $ret; } function get_schdata_linux($atqueno, $ex_type, $typ) { $schdata = array(); @exec("atq -q $atqueno", $output, $ret); if ($ret != 0) { sleep(1); @exec("atq -q $atqueno", $output, $ret); if ($ret != 0) return $schdata; } foreach ($output as $value) { $job = explode("\t", $value); $wdata = rf_schdsp_linux_sub($job[0]); if ($wdata == null) continue; $para = get_para($wdata, $ex_type); $para[12] = $job[0]; $wdata = put_para($para, $ex_type); $schdata[] = $wdata; } return $schdata; } function rf_update_sub_tool_lnx($rpath, $tmpdir_rf, $upbtxt_fl, $ty) { global $usrdir; global $tmpdir; echo_msg(2, ""); echo_msg(2, "番組録音中の更新は不可。"); echo_msg(2, ""); $ans = echo_yesno(2, "TOOL(Linux)を更新しますか? (y/N): "); echo_msg(2, ""); if ($ans == "y" || $ans == "Y") { $ret = rfgw_update_bin($rpath, $ty); if ($ret == 0) { echo_msg(2, "更新成功"); } else { echo_msg(2, "更新失敗"); } rf_update_fin_tool(); echo_msg(2, ""); echo_msg(2, "一旦終了します。"); return(1); } else { return(0); } } function rf_update_bin_lnx($rpath, $ty) { global $tmpdir; global $scrdir; global $base; global $rfriends; global $rfproduct; global $DS; $upbtxt_fl = "update_bin.txt"; $upbin_fl = "update_bin.zip"; $tmpdir_rf = $tmpdir.$rfproduct; $fl = $scrdir."up_tools.sh"; if (file_exists($fl)) { echo_msg(2, "アップデート(bin)....."); $expgm = "sh $fl"; external_sys($expgm); } echo_msg(2, "アップデート(bin)完了"); return(0); } function rfmenu_config_linux() { global $ttl_no; global $ttl_mes; global $cfgdir; global $rf_stp; global $crontab_template; global $crontabtxt; echo_msg(2, "毎日自動で行う処理の設定を行います。"); echo_msg(2, "（1 -> 2 -> 3 の順で設定）"); echo_msg(2, ""); $mnu = array("読込","編集","書出"); $msel = rf_sel_menu($mnu,1); if ($msel < 0) { return; } $ttl_no[0] = 3; $ttl_no[3] = $msel; $ttl_mes[3] = $mnu[$msel-1]; $tempfile = $cfgdir."crontab"; if ($msel == 1) { rfmenu_subtitle("デイリー処理読込(crontab読込)"); echo_msg(2, "現在のcrontabの内容をtempファイルに読み込みます。"); echo_msg(2, ""); $ans = echo_yesno(2, "実行しますか? (y/N): "); if ($ans == "y" || $ans == "Y") { rf_get_crontab(); rf_append_crontab(); echo_msg(2, ""); $tempfile = $cfgdir.$crontabtxt; $lines = file($tempfile,FILE_IGNORE_NEW_LINES); echo_msg(2, "--------------------"); foreach($lines as $l){ echo_msg(2,$l); } echo_msg(2, "--------------------"); rf_pause(); $ans = echo_yesno(2, "この内容を編集せずにcrontabに書き出しますか？(y/N): "); if ($ans == "y" || $ans == "Y") { rf_put_crontab(); rf_pause(); } } } if ($msel == 2) { rfmenu_subtitle("デイリー処理編集(crontab編集)"); echo_msg(2, "tempファイルを編集します。"); echo_msg(2, "[デイリー処理書出]をしないとcrontabは変更されません。"); echo_msg(2, ""); $ans = echo_yesno(2, "実行しますか? (y/N): "); if ($ans == "y" || $ans == "Y") { rfgw_play_text($cfgdir.$crontabtxt); } } if ($msel == 3) { rfmenu_subtitle("デイリー処理書出(crontab変更)"); echo_msg(2, "tempファイルの内容をcrontabに書き出します。。"); echo_msg(2, "crontabの内容が変更されるので十分注意してください。"); echo_msg(2, ""); echo_msg(2, "意味が理解できない場合は実行しないでください。"); echo_msg(2, ""); $ans = echo_yesno(2, "実行しますか? (y/N): "); if ($ans == "y" || $ans == "Y") { rf_put_crontab(); rf_pause(); } } } function rf_play_text_lnx($fn, $flg) { global $tmpdir; global $editor; global $editor_cui; global $editor_gui; global $snd_player; global $editor_cui_lnx; global $editor_gui_lnx; global $snd_player_lnx; global $cmd_which; if (!file_exists($fn)) { echo_msg(2, "file not found $fn"); return 1; } if ($flg == 0) { $pl = $editor_gui_lnx; if ($pl == "") { $pl = $editor_gui; } system("$cmd_which $pl", $ret); if ($ret == 0) { rfgw_ret_extsys($pl, $fn); } else { $flg = 1; } } if ($flg != 0) { $ppid = rfgw_get_ppid(); if ($ppid != -1) { $pl = $editor_cui_lnx; if ($pl == "") { $pl = $editor_cui; } file_put_contents($editor, $pl, LOCK_EX); file_put_contents($tmpdir."edit_fnam_$ppid", $fn, LOCK_EX); $rf_stp = 99; exit($rf_stp); } } return 0; } function rf_play_snd_lnx($fn, $flg) { global $editor_cui; global $editor_gui; global $snd_player; global $editor_cui_lnx; global $editor_gui_lnx; global $snd_player_lnx; global $scrdir; global $tmpdir; global $cmd_which; if (!file_exists($fn)) { echo_msg(2, "file not found $fn"); return 1; } if ($flg == 0) { $pl = $snd_player_lnx; if ($pl == "") { $pl = $snd_player; } system("$cmd_which $pl", $ret); if ($ret == 0) { rfgw_ret_extsys($pl, $fn); } else { echo_msg(2, "再生プログラムがありません。（ $pl ）"); } } else { system("$cmd_which pulseaudio", $ret); if ($ret == 0) { echo_msg(2, ""); echo_msg(2, "再生するためには、pulseaudioの設定が済んでいる必要があります。"); $ans = echo_yesno(2,"pulseaudio経由で再生しますか？(y/N) "); if ($ans != "y" && $ans != "Y" ) { return 0; } $piddata = rfmenu_play_abort_all(); $opt_fn = make_fn("playfile"); $tfn = $tmpdir.$opt_fn.".dat"; fin_unlink($tfn); file_put_contents($tfn, $fn,LOCK_EX); $nam = "rfriends_exec_play"; $opt = "13 \"$opt_fn\""; $ex = "ex_rfriends"; rfgw_batsh_sub($scrdir, $ex, $opt, 1, 1); echo_msg(2, ""); echo_msg(2, "再生処理を開始しました"); echo_msg(2, "処理はバックグラウンドで行われます"); } else { echo_msg(2, "この環境では再生できません。"); } } return 0; } function rm_atque_linux($dsp) { global $rsvdir; global $at_que_no; $exque = get_at_que_no($at_que_no); $jobs0 = rfgw_atjobs($exque[0]); $jobs1 = rfgw_atjobs($exque[1]); $jobs2 = rfgw_atjobs('='); $jobs = array_merge($jobs0,$jobs1,$jobs2); $schdata_cnt = 0; foreach ($jobs as $sh => $job) { if (!file_exists($sh)) { $jobsh = @exec("atrm $job"); if ($dsp == 1) echo_msg(2, "clear job : $job : $sh"); unset($jobs[$sh]); $schdata_cnt++; } } $files = glob($rsvdir."*.sh"); foreach($files as $sh) { if (!array_key_exists($sh,$jobs)) { $dat = str_replace(".sh",".dat",$sh); if ($dsp == 1) echo_msg(2, "clear data : $sh"); fin_unlink($sh); fin_unlink($dat); $schdata_cnt++; } } return $schdata_cnt; } function rf_ffmpeg_43() { $ret = @external_exec("ffmpeg -version"); if ($ret === false) { rf_error_log("ffmpeg v: err -1"); return -1; } $ans = explode(' ',$ret[0]); if (count_73($ans) < 3) { rf_error_log("ffmpeg v: err -1 ".$ret[0]); return -1; } $ver = $ans[2]; $ver2 = explode('-',$ver); $nos = explode('.',$ver2[0]); $cnt = count_73($nos); if ($cnt <= 0) { rf_error_log("ffmpeg v: err 2 ".$ret[0]); return 2; } for ($i=0;$i<$cnt;$i++) { $no = trim($nos[$i]); if (!is_numeric($no)) { rf_error_log("ffmpeg v: err 2 ".$ret[0]); return 2; } $nos[$i] = $no; } if ($cnt == 1) { $nos[1] = 0; } if ($nos[0] < 4) return 0; if ($nos[0] > 4) return 1; if ($nos[1] < 3) return 0; return 1; } 