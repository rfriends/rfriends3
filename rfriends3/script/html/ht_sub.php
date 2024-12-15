<?php
 function ht_buff($para) { if ($para == 1) { header('Cache-Control: public'); ob_end_clean(); ob_implicit_flush(false); } else { ob_end_clean(); ob_implicit_flush(true); msgx("test メッセージ"); echo <<<EOM
<script>
document.getElementsByTagName("li").style("list-style:none");
</script>
EOM;
} } function ht_print($xs,$mes) { echo_msg(2,$mes); foreach($xs as $x) { $ttl = $x['title']; $val = $x['val']; echo_msg(2,"title : $ttl   val : $val"); } } function ht_print_r($x,$mes) { echo_msg(2,$mes); msgx('<pre>'); print_r($x); msgx('</pre>'); } function ht_sub_btm($mes,$fn) { echo_msg(2,$mes); $alert = "<a href='$fn.html'>" . "<button type='button'>実行</button>" . "</a>　　" . "<a href='can.html'>" . "<button type='button'>キャンセル</button>" . "</a>"; echo $alert; } function ht_development($subno,$val,$no) { $mes = "?????($no)"; if ($no == 1) $mes = "工事中"; if ($no == 2) $mes = "未定義"; echo_msg(2,"$mes : $subno"); echo_msg(2,"val : $val"); } function ht_substart($subno,$sno,$val,$val2,$sel,$mes) { global $svcmode; global $ht_jump_cur; if ($svcmode["service_debug"] == 1) { echo_msg(2,"cur : $ht_jump_cur  subno : $subno  sno : $sno  sel : $sel [$mes]"); if (is_array($val)) { ht_print_r($val,"val"); ht_print_r($val2,"val2"); } else { echo_msg(2,"val : $val  val2 : $val2"); } msgx("<hr>"); } } function ht_subend($subno,$sno,$val,$val2,$sel,$mes) { global $svcmode; global $ht_jump_cur; if ($svcmode["service_debug"] == 1) { msgx("<hr>"); echo_msg(2,"cur : $ht_jump_cur  subno : $subno  sno : $sno  sel : $sel [$mes]"); echo_msg(2,"val : $val  val2 : $val2"); } } function ht_subtitle($strno,$addmes) { global $ttl_no; global $ht_jump_addr; global $ht_jump_addr_s; global $ht_jump_no; global $ht_jump_val; global $ht_jump_val2; global $htmldir; global $webdav_sw; $ht_jump_no = $strno; ht_ttlno_set($strno); $menu = ht_menu_init(); $ans = ht_menu($ttl_no[1],$ttl_no[2],$ttl_no[3]); $mnav = $ans[0]; echo "<h3>"; echo "$mnav"; echo "</h3>".PHP_EOL; $svr = $_SERVER['SERVER_SOFTWARE']; echo "<h2>"; if ($strno == "00") { echo "<a href=index.html>"; echo "<img src=images/home.png title='$svr' align=top></a>"; if (file_exists("$htmldir/webdav") && $webdav_sw == "on") { echo "&nbsp;&nbsp;&nbsp;"; echo "<a href='/webdav/' target='_blank'>"; echo "<img src=images/webdav.png title='webdav' align=top></a>"; } echo "&nbsp;&nbsp;&nbsp;"; } else { echo "<a href=index.html>"; echo "<img src=images/home.png title='$svr' align=top></a>"; echo "&nbsp;&nbsp;"; echo "<a href='#' onclick='history.back(-1);return false;'>"; echo "<img src=/images/arrow_left.png width=16 align=top></a>"; echo "&nbsp;&nbsp;"; } echo $ans[1]." ".$addmes; echo "</h2>".PHP_EOL; } function ht_rec_start($type,$wdat,$ex_type) { if (is_array($wdat)) { $wdat0 = $wdat; } else { ht_wdat_pgm_disp($wdat,$ex_type,2); $wdat0[] = $wdat; } switch ($type) { case 'rsv': rfmenu_rec_sel_rsv($ex_type, $wdat0); break; case 'rec': rf_batsh_rec($ex_type, 0, 0, 0, $wdat0); foreach($wdat0 as $wd) { ht_wdat_pgm_disp($wd,$ex_type,2); } echo_msg(2,""); echo_msg(2, "番組の録音を開始しました。"); break; default: echo_msg(2, ""); echo_msg(2, "パラメータエラー"); break; } return; } function ht_ttlno_set($strno) { global $ttl_no; $n1 = 0; $n2 = 0; $n3 = 0; $ttl_no[0]= 0; $ttl_no[1]= $n1+0; $ttl_no[2]= $n2+0; $ttl_no[3]= $n3+0; if ($strno == "00") return; $n = strlen($strno); if ($n == 2) { $n1 = $strno; $ttl_no[0]= 1; } else if ($n == 4 || $n == 5) { $n1 = substr($strno,0,2); $n2 = substr($strno,2,2); $ttl_no[0]= 2; } else if ($n == 6) { $n1 = substr($strno,0,2); $n2 = substr($strno,2,2); $n3 = substr($strno,4,2); $ttl_no[0]= 3; } $ttl_no[1]= $n1+0; $ttl_no[2]= $n2+0; $ttl_no[3]= $n3+0; } function ht_menu_init() { $menu_xml= "menu_h.xml"; $xml = file_get_contents($menu_xml); $obj = simplexml_load_string($xml); $json = json_encode($obj); $rf_define = json_decode($json,TRUE); $menu1 = $rf_define['menu']; if (PHP_OS == "Linux") { $menu1[8]['sub']['menu'][2]['sub']['menu'][0]['title'] = "読込"; $menu1[8]['sub']['menu'][2]['sub']['menu'][0]['msg'] = "crontabの読込を行います。"; $menu1[8]['sub']['menu'][2]['sub']['menu'][1]['title'] = "編集"; $menu1[8]['sub']['menu'][2]['sub']['menu'][1]['msg'] = "crontabの編集を行います。"; $menu1[8]['sub']['menu'][2]['sub']['menu'][2]['title'] = "書出"; $menu1[8]['sub']['menu'][2]['sub']['menu'][2]['msg'] = "crontabの書出を行います。"; } return $menu1; } function ht_menu($n1,$n2,$n3) { global $ttl_no; global $ttl_mes; if ($n1 == 0) return ["ホーム",""]; $menu0 = ht_menu_init(); $ttl = "-"; $msg = "-"; if($n1 != 0) { if (isset($menu0[$n1 - 1])) { $menu1 = $menu0[$n1 - 1]; $ttl1 = $menu1['title']; $msg1 = $menu1['msg']; $ttl = "[$n1] $ttl1"; $msg = $msg1; $ttl_no[0] = 1; $ttl_no[1] = $n1; $ttl_mes[1] = $ttl1; } } if($n2 != 0) { if (isset($menu0[$n1 - 1]['sub']['menu'][$n2 - 1])) { $menu2 = $menu0[$n1 - 1]['sub']['menu'][$n2 - 1]; $ttl2 = $menu2['title']; $msg2 = $menu2['msg']; $ttl = "[$n1-$n2] ".$ttl1."　＞　".$ttl2; $msg = $msg2; $ttl_no[0] = 2; $ttl_no[2] = $n2; $ttl_mes[2] = $ttl2; } } if($n3 != 0) { if (isset($menu0[$n1 - 1]['sub']['menu'][$n2 - 1]['sub']['menu'][$n3 - 1])) { $menu3 = $menu0[$n1 - 1]['sub']['menu'][$n2 - 1]['sub']['menu'][$n3 - 1]; $ttl3 = $menu3['title']; $msg3 = $menu3['msg']; $ttl = "[$n1-$n2-$n3]　".$ttl1."　＞　".$ttl2."　＞　".$ttl3; $msg = $msg3; $ttl_no[0] = 3; $ttl_no[3] = $n3; $ttl_mes[3] = $ttl3; } } return [$ttl,$msg]; } function ht_menu_test() { $menu_xml= "menu_h.xml"; $xml = file_get_contents($menu_xml); $obj = simplexml_load_string($xml); $json = json_encode($obj); $rf_define = json_decode($json,TRUE); $menu1 = $rf_define['menu']; $nmax1 = count_73($menu1); for($i=0;$i<$nmax1;$i++) { $ttl = $menu1[$i]['title']; echo_msg(2,"[$i]$ttl"); $menu2 = $menu1[$i]['sub']['menu']; $nmax2 = count_73($menu2); for($j=0;$j<$nmax2;$j++) { $ttl = $menu2[$j]['title']; echo_msg(2,"[$i][$j]$ttl"); if (!array_key_exists('sub',$menu2[$j])) continue; $menu3 = $menu2[$j]['sub']['menu']; $nmax3 = count_73($menu3); for($k=0;$k<$nmax3;$k++) { $ttl = $menu3[$k]['title']; echo_msg(2,"[$i][$j][$k]$ttl"); $menu4 = $menu3[$k]; $nmax4 = count_73($menu4); } } } } function ht_menu_brand($no) { global $scrdir; $menu_xml= $scrdir."menu.xml"; $xml = file_get_contents($menu_xml); $obj = simplexml_load_string($xml); $json = json_encode($obj); $rf_define = json_decode($json,TRUE); $menudef = $rf_define['menu']; $menudefmax = count_73($menudef); $pgm = $menudef[6]['sub']['menu'][$no]; return $pgm; } function ht_yesno($mes) { $mes = str_replace("(y/N):","",$mes); $mes = str_replace("(y/N)","",$mes); ht_confirm($mes,'Yes'); } function ht_confirm($mes,$btn) { global $ht_jump_addr; global $ht_jump_no; global $ht_jump_val; global $ht_jump_val2; global $sno; echo_msg(2, "$mes"); msgx("<form method='get' action='$ht_jump_addr'>"); msgx("<p><br><button class='btn_ex' type='submit'>$btn</button>"); msgx("</p>"); msgx("<INPUT type='hidden' name='subno' value='$ht_jump_no'>"); msgx("<INPUT type='hidden' name='val'   value='$ht_jump_val'>"); msgx("<INPUT type='hidden' name='val2'  value='$ht_jump_val2'>"); msgx("<INPUT type='hidden' name='sno'   value='$sno'>"); msgx("</form>"); echo_msg(2,""); } function ht_ask_list($flist,$opt) { global $ht_jump_addr; global $ht_jump_no; global $ht_jump_val; global $ht_jump_val2; global $ht_jump_confirm; global $ht_jump_selid; global $ht_jump_ret; global $ht_jump_reset; global $ht_jump_btn1; global $ht_jump_btn1_label; global $ht_jump_btn2; global $ht_jump_btn2_label; global $textbox_width; global $textbox_height; $ttl = $opt["title" ]; $mode = $opt["mode"]; $multi = $opt["multi"]; $cf = $opt["confirm"]; $selid = $opt["ht_selid"]; $num = 0; if (array_key_exists('num', $opt)) { $num = $opt["num"]; } $htwidth = 0; if (array_key_exists('ht_width', $opt)) { $htwidth = $opt["ht_width"]; if ($htwidth <= 0) $htwidth = 0; if ($htwidth >= 200) $htwidth = 200; } $confirm = $ht_jump_confirm; if ($confirm == "") $confirm = "確認 : 実行しますか？"; $nmax = count_73($flist); $col = $textbox_width; $row = 15; if ($row > $nmax) $row = $nmax; if ($multi == 0) { $mtd = "get"; $mlt = ""; $v = 'val'; } else { $mtd = "post"; $mlt = "multiple"; $v = 'val[]'; } echo_msg(2,"&nbsp;&nbsp;$ttl"); if ($cf == 0) { msgx("<form class=asklist method=$mtd action='$ht_jump_addr'>".PHP_EOL); } else { msgx("<form class=asklist method=$mtd action='$ht_jump_addr' onSubmit='return ht_check()'>".PHP_EOL); } $ty = 0; if (array_key_exists('kind1',$opt)) { $ty = 1; } if ($ty == 1) { $kind1 = $opt['kind1']; $kind1name = $opt['kind1name']; $kind2 = $opt['kind2']; $kind2name = $opt['kind2name']; echo <<<EOMKEY
<input type="radio" name="val2" value="$kind1" checked/>$kind1name
<input type="radio" name="val2" value="$kind2" />$kind2name

EOMKEY;
} $req = 'required="required"'; $minw = 'style="min-width:350px;"'; if ($selid != "") { msgx("<select name='$v' "."id=$selid"." size=$row $mlt $req $minw>".PHP_EOL); } else { msgx("<select name='$v' size=$row $mlt $req $minw>".PHP_EOL); } for ($i=1; $i<=$nmax; $i++) { if ($mode == 0) { $ttl = $flist[$i - 1]; $val = $i; } else { $ttl = $flist[$i - 1]['title']; $val = $flist[$i - 1]['val']; } if ($num == 1) { $ii = sprintf("%3d",$i); $ii = str_replace(" ","&nbsp;",$ii); $ttl = $ii."&nbsp;&nbsp;".$ttl; } else { if (substr($ttl,0,1) == ' ') $ttl = '&nbsp;'.substr($ttl,1); } if ($htwidth > 0) { $ttl = mb_strimwidth($ttl,0,$htwidth,"…","UTF-8"); } if ($i == 1) { $sel = "selected"; } else { $sel = ""; } if ($val == '') { $sel = 'disabled'; msgx("<option value='$val' $sel style='background-color:gray;color:white'>$ttl&nbsp;</option>".PHP_EOL); } else { msgx("<option value='$val' $sel>$ttl&nbsp;</option>".PHP_EOL); } } msgx("</select>".PHP_EOL); ht_button($ty,$multi); echo <<<EOM
</form>

<script>
function ht_check(){
    //if (selvalue == 1) {
	    if(window.confirm("$confirm")){
		    return true;
	    }
	    else{
		    return false;
	    }
    //}
}
</script>
EOM;
return ""; } function ht_input($msg,$ty) { global $ht_jump_addr; global $ht_jump_no; global $ht_jump_val2; global $sno; global $premium_timefree30; echo_msg(2,""); echo <<<EOM0
<form method='get' action='$ht_jump_addr'>
<p>$msg</p>
<p>&nbsp;</p>
EOM0;
switch ($ty) { case 0: echo <<<EOM0
<INPUT type='hidden' name='val2' value='$ht_jump_val2'>
EOM0;
break; case 1: echo <<<EOM1
<p>&nbsp;
<input type="checkbox" name="val2[]" value="r1" checked>&nbsp;r1&nbsp;
<input type="checkbox" name="val2[]" value="r2">&nbsp;r2&nbsp;
<input type="checkbox" name="val2[]" value="r3">&nbsp;r3&nbsp;
</p>
EOM1;
break; case 2: echo <<<EOM2
<p>&nbsp;
<input type="radio" name="val2" value="2" >&nbsp;2日間&nbsp;
<input type="radio" name="val2" value="4" checked>&nbsp;4日間&nbsp;
<input type="radio" name="val2" value="7" >&nbsp;7日間&nbsp;
</p>
EOM2;
break; case 3: if ($premium_timefree30 == 1) { $tf30 = ""; } else { $tf30 = 'disabled="disabled"'; } echo <<<EOM3
<p>&nbsp;
<input type="radio" name="val2" value="7" checked>&nbsp;7日間&nbsp;
<input type="radio" name="val2" value="30" $tf30>&nbsp;30日間&nbsp;
</p>
EOM3;
break; default: break; } echo <<<EOM9
<p><input class='inp_no' type='text' name='val' value='' style='width:300px;text-align:left;'></p>
<p align=left><button class='btn_ex' type='submit'>実行</button></p>
<input type='hidden' name=subno value=$ht_jump_no>
<INPUT type='hidden' name='sno' value='$sno'>
</form>
EOM9;
echo_msg(2,""); return ""; } function ht_button($ty,$multi) { global $ht_jump_addr; global $ht_jump_no; global $ht_jump_val; global $ht_jump_val2; global $ht_jump_val3; global $ht_jump_confirm; global $ht_jump_ret; global $ht_jump_reset; global $ht_jump_btn1; global $ht_jump_btn1_label; global $ht_jump_btn2; global $ht_jump_btn2_label; global $ht_jump_btn3; global $ht_jump_btn3_label; global $sno; $m = ""; if ($multi == 1) $m = '<img src="/images/multi.png" height ="20" width="20" align=top />&nbsp;'; msgx("<p><br/>"); if ($ht_jump_ret == 1) { msgx("<a href='#' onclick='history.back(-1);return false;'>".PHP_EOL); msgx("<img src=/images/arrow_left_32.png width=32 align=top></a>".PHP_EOL); } msgx("<button class=btn_ex type=submit name=sel value=1 onclick='selvalue=1'>$m$ht_jump_btn1_label</button>".PHP_EOL); if ($ht_jump_btn2 == 1) { msgx("　<button class=btn_ex type=submit name=sel value=2 onclick='selvalue=2'>$ht_jump_btn2_label</button>".PHP_EOL); } if ($ht_jump_btn3 == 1) { msgx("　<button class=btn_ex type=submit name=sel value=3 onclick='selvalue=2'>$ht_jump_btn3_label</button>".PHP_EOL); } if ($ht_jump_reset == 1) { msgx("　<button class=btn_ex type=reset>リセット</button>".PHP_EOL); } if ($ty == 0) { msgx("<input type='hidden' name=val2 value=$ht_jump_val2>"); } echo <<<EOM
<input type='hidden' name=subno  value=$ht_jump_no>
<input type='hidden' name=exname value=$ht_jump_addr>
<INPUT type='hidden' name='sno'  value='$sno'>
</p>
EOM;
} function ht_output_program($ty,$val) { global $logdir; global $DS; $ret = false; $fn = ""; switch($ty) { case 1: $ans = explode(",",$val); if (count_73($ans) != 2) { echo_msg(2,"input error : $val"); break; } $ymd = $ans[0]; $area_code = strtoupper($ans[1]); $plistdir = $logdir."plist"; if (!is_dir($plistdir)) mkdir ($plistdir); $fn = $plistdir.$DS."radiko_".$ymd."_".$area_code.".xml"; echo_msg(2,"日付      : $ymd"); echo_msg(2,"area_code : $area_code"); echo_msg(2,"file : $fn"); $ret = rfmenu_radiko_plisting($fn,$ymd,$area_code); break; case 2: $ans = explode(",",$val); if (count_73($ans) != 3) { echo_msg(2,"input error : $val"); break; } $ymd = $ans[0]; $areakey = strtoupper($ans[1]); $netch = $ans[2]; if (!@is_dir($logdir."plist")) mkdir($logdir."plist"); $fn = $logdir."plist".$DS."radiru_".$ymd."_".$areakey."_".$netch.".json"; echo_msg(2,"日付    : $ymd"); echo_msg(2,"areakey : $areakey"); echo_msg(2,"netch   : $netch"); echo_msg(2,"file : $fn"); $ret = rfmenu_radiru_plisting($fn,$ymd,$areakey,$netch); break; default: return; break; } if ($ret === false) { echo_msg(2,"$fn の出力に失敗しました。"); } else { echo_msg(2,"$fn を出力しました。"); } } function ht_textedit($fl,$rows,$cols) { global $ht_jump_addr; global $ht_jump_no; global $ht_jump_val; global $ht_jump_val2; global $ht_jump_btn1_label; global $textbox_width; global $textbox_height; global $sno; $lbl = "保存"; if ($ht_jump_btn1_label != "") $lbl = $ht_jump_btn1_label; $row = $rows; $col = $cols; if ($rows == 0) $row = $textbox_height; if ($cols == 0) $col = $textbox_width; $fl2 = str_replace("\\","/",$fl); echo_msg(2,"File : $fl2"); if ($lbl == "保存") { $fl_mes = $fl2." \\n を保存しても良いですか?"; } else { $fl_mes = $fl2." \\n ".$lbl."を実行しますか?"; } if (!file_exists($fl)) { echo_msg(2,"ファイルがありません。"); return false; } $txts = file_get_contents($fl); echo <<<EOM1
<br>
<form method="POST" action="$ht_jump_addr" onSubmit="return ht_check()">
    <input type='hidden' name='fl'   value="$fl" />
    <textarea name=txts rows=$row cols=$col class="lines-number" data-type="note" data-lines="number">
EOM1;
echo $txts; echo <<<EOM2
    </textarea>
    <br><br>
    <input class=btn_ex type="submit" value="$lbl">
    <input type='hidden' name='subno' value='$ht_jump_no'>
    <input type='hidden' name='val'   value='$ht_jump_val'>
    <input type='hidden' name='val2'  value='$ht_jump_val2'>
    <INPUT type='hidden' name='sno'   value='$sno'>
</form>

<script>
function ht_check(){
	if(window.confirm("$fl_mes")){
		return true;
	}
	else{
		return false;
	}
}
</script>
EOM2;
} function ht_textdisp($fl,$rows,$cols) { global $textbox_width; global $textbox_height; $row = $rows; $col = $cols; if ($row == 0) $row = $textbox_height; if ($col == 0) $col = $textbox_width; $txts = file_get_contents($fl); $fl2 = str_replace("\\","/",$fl); echo_msg(2,"file : $fl2"); if (!file_exists($fl)) { echo_msg(2,"ファイルがありません。"); return false; } msgx("<textarea name=txts rows=$row cols=$col readonly class='lines-number' data-type='note' data-lines='number'>"); msgx("$txts"); msgx("</textarea><br><br>"); } function ht_wdat_pgm_disp($wdat,$ex_type,$ty) { $para = get_para($wdat, $ex_type); $fr = date("Y/m/d H:i",strtotime($para[0])); $to = date("Y/m/d H:i",strtotime($para[1])); switch($ty) { case 2: echo_msg(2,$para[7]); break; case 1: default: echo <<<EOM1
<table>
<tr><td>日付</td>  <td>&nbsp;:&nbsp;</td><td>$fr - $to</td></tr>
<tr><td>CH</td>    <td>&nbsp;:&nbsp;</td><td>$para[6]</td></tr>
<tr><td>番組名</td><td>&nbsp;:&nbsp;</td><td>$para[7]</td></tr>
EOM1;
if ($para[8] != ";") { msgx("<tr><td></td>      <td>&nbsp;:&nbsp;</td><td>$para[8]</td></tr>"); } msgx("</table>"); break; } } function ht_pgm_disp($pgm) { echo_msg(2, "番組名 : $pgm"); echo_msg(2, ""); } function ht_play_file($fn,$ty) { global $DS; $filepath = pathinfo($fl); $dir = ""; if (array_key_exists('dirname',$filepath)) { $dir = $filepath['dirname']; if (substr($dir,-1) != $DS) $dir = $dir.$DS; } $fl2 = ""; if (array_key_exists('basename',$filepath)) { $fl2 = $filepath['basename']; } ht_webaudio($fl2,$dir); } function ht_webaudio($val,$dir) { global $htmldir; global $usrdir; global $usrdir_link; global $link_flg; $piddata = rfmenu_play_abort_all(); $fn = $dir.$val; $lflg = ""; if ($link_flg == 1) { $p = strpos($fn,$usrdir); if ($p !== false && $p == 0) { $fn = str_replace($usrdir,$usrdir_link,$fn); $lflg = " ,"; } } $ext = pathinfo($fn,PATHINFO_EXTENSION); $sndfile = "temp/tempsound"; $fnximg = "$sndfile".".jpg"; $temp_fnimg = $htmldir.$fnximg; $p = strpos($fn,$htmldir); if ($p === false) { $fnx = "$sndfile.$ext"; $temp_fn = $htmldir.$fnx; $ret = copy($fn,$temp_fn); if ($ret === false) { echo_msg(2,"再生に失敗しました。"); return; } $r = rand(10000,99999); $fnx = $fnx.'?'.$r; } else { $pn = strlen($htmldir); $fnx = substr($fn,$pn); } fin_unlink($temp_fnimg); $ret = external_program_null("ffmpeg -i $fn $temp_fnimg"); if ($ret != 0) { copy($htmldir."images/tempsound.jpg",$temp_fnimg); } ht_pgm_disp($val.$lflg); echo <<<EOM1
<p><img id='sndimg'   src='$fnximg'></p>
<audio  id='audioimg' src='$fnx' type='audio/$ext' controls>
</audio>
EOM1;
} function ht_webaudio2($fn,$pic) { $piddata = rfmenu_play_abort_all(); $ext = pathinfo($fn,PATHINFO_EXTENSION); echo <<<EOM
<p>
<img id='sndimg' src="$pic">
</p>
<br clear=left>

EOM;
if ($fn != "") { echo <<<EOM2
<audio src="$fn" id='audioimg' type="audio/$ext" controls></audio>
EOM2;
} else { echo_msg(2,"音声の配信がありません。"); } } function ht_live($wdat,$ex_type) { global $ex_radiko; global $ex_radiru; $para = get_para($wdat, $ex_type); echo_msg(2,"時間によっては次の番組になっている可能性があります。"); echo_msg(2,""); ht_wdat_pgm_disp($wdat,$ex_type,1); rfriends_live($ex_type,$para,0); } function ht_play_server($fn,$dir) { global $scrdir; global $tmpdir; echo_msg(2,"再生（サーバ）です。"); echo_msg(2, "サーバ側で音が出ます。"); echo_msg(2, "サーバによっては音が出ません。"); echo_msg(2, ""); echo_msg(2, "番組名 : $fn"); $piddata = rfmenu_play_abort_all(); $fn2 = $dir.$fn; $opt_fn = make_fn("playfile"); $tfn = $tmpdir.$opt_fn.".dat"; fin_unlink($tfn); file_put_contents($tfn, $fn2,LOCK_EX); $nam = "rfriends_exec_play"; $opt = "13 \"$opt_fn\""; $ex = "ex_rfriends"; rfgw_batsh_sub($scrdir, $ex, $opt, 1, 1); echo_msg(2, ""); ht_confirm("再生を中止しますか？",'中止'); } function ht_live_server($wdat,$ex_type) { global $ex_podcast; echo_msg(2,"聴取（サーバ）です。"); echo_msg(2, "サーバ側で音が出ます。(少し時間がかかります)"); msgx("<p>音量調節："); msgx("<a href=menu.html?mno=01&sno=s01c><img src=images/speaker.png width=20 height=20 align=top></a>"); msgx("</p>"); echo_msg(2, ""); if ($ex_type != $ex_podcast) { ht_wdat_pgm_disp($wdat,$ex_type,1); echo_msg(2,""); } $para = get_para($wdat, $ex_type); $flg = 0; $auto = 0; rfriends_live_sub($ex_type,$para,$flg,$auto); ht_confirm("聴取を中止しますか？",'中止'); } function ht_live_timefree($wdat,$ex_type) { echo_msg(2, "現在、この機能(聴取)は動作しません。"); echo_msg(2, "聴取（サーバ）は動作します。"); echo_msg(2, ""); ht_wdat_pgm_disp($wdat,$ex_type,1); $para = get_para($wdat, $ex_type); rfriends_live($ex_type,$para,0); } function ht_live_radiru_vod($wdat,$ex_type) { ht_wdat_pgm_disp($wdat,$ex_type,1); $para = get_para($wdat, $ex_type); rfriends_live($ex_type,$para,0); } function ht_delrsv($dat,$ex_type) { global $ex_radiko; global $ex_radiru; global $schradiko_head; global $schradiru_head; if ($ex_type == $ex_radiko) { $head = $schradiko_head; } else if ($ex_type == $ex_radiru) { $head = $schradiru_head; } else { return; } if (is_array($dat)) { $wdat0 = $dat; } else { $wdat0[] = $dat; } foreach($wdat0 as $wdat) { $para = get_para($wdat, $ex_type); ht_pgm_disp($para[7]); $test_mode = 0; $ret = rfgw_program_del($test_mode, $ex_type, $para, $head); switch ($ret) { case 0: $mes = "削除しました"; break; case 1: $mes = "削除できませんでした"; break; default: $mes = "削除エラー"; break; } } } function ht_writefl2($val) { $fl = $_POST['fl']; $txts = $_POST['txts']; $txtln = strlen($txts); echo_msg(2,"file : $fl"); echo_msg(2,"size : $txtln byte(s)"); echo_msg(2,""); if ($txtln < 20) { echo_msg(2,"$fl を初期化します。"); fin_unlink($fl); ht_restart(); exit; } $ret = rf_writefl($fl,$txts); if ($ret === false) { echo_msg(2,"file put error ($fl)"); } else { echo_msg(2,"保存しました。"); } ht_restart(); exit; } function ht_writefl($val) { $fl = $_POST['fl']; $txts = $_POST['txts']; $txtln = strlen($txts); echo_msg(2,"file : $fl"); echo_msg(2,"size : $txtln byte(s)"); echo_msg(2,""); $ret = rf_writefl($fl,$txts); if ($ret === false) { echo_msg(2,"file put error ($fl)"); exit; } echo_msg(2,"保存しました。"); ht_restart(); exit; } function ht_exaudio_test($url,$token,$partialkey) { $dat = rf_device_info(); $app = $dat[0]; $ver = $dat[1]; $user = $dat[2]; $dev = $dat[3]; $con = $dat[4]; $app = "pc_html5"; $ver = "0.0.1"; $user = "dummy_user"; $dev = "pc"; $referer = "https://radiko.jp/"; $opts = array( 'https' => array( 'method' => "GET", 'header' => "Referer: ". $referer ) ); $context = stream_context_create($opts); echo <<<EOM1
<script src="https://cdn.jsdelivr.net/npm/hls.js@canary"></script>
<audio id="audioimg" controls preload=metadata></audio>
<script>
  var audio = document.getElementById('audioimg');
  var audioSrc = '$url';
EOM1;
if ($token != "") { echo <<<EOM2
    var config = {
        xhrSetup: xhr => {
        //xhr.setRequestHeader("User-Agent",            "Mozilla/5.0 (Macintosh; Intel Mac OS X 13_0_1; Valve Steam GameOverlay/1679680416) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36");
        //xhr.setRequestHeader("paragram",            "no-cache");
        //xhr.setRequestHeader("X-Radiko-App",        "$app");
        //xhr.setRequestHeader("X-Radiko-App-Version","$ver");
        //xhr.setRequestHeader("X-Radiko-User",       "$user");
        //xhr.setRequestHeader("X-Radiko-Device",     "$dev");
        xhr.setRequestHeader("X-Radiko-AuthToken",  "$token");
        //xhr.setRequestHeader("X-Radiko-PartialKey", "$partialkey");
        }
    };
EOM2;
} else { echo <<<EOM3
    var config = {
    };
EOM3;
} echo <<<EOM4
  if (Hls.isSupported()) {
      var hls = new Hls(config);
      hls.loadSource(audioSrc);
      hls.attachMedia(audio);
  } else if (audio.canPlayType('application/vnd.apple.mpegurl')) {
    audio.src = audioSrc;
  }
</script>
EOM4;
} function ht_exaudio($url,$token,$partialkey) { rfmenu_play_abort_all(); echo <<<EOM1
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<audio id="audioimg" controls preload=metadata>
</audio>
<script>
  var audio = document.getElementById('audioimg');
  var audioSrc = '$url';
EOM1;
if ($token != "") { echo <<<EOM2
    var config = {
        xhrSetup: xhr => {
        xhr.setRequestHeader("X-Radiko-AuthToken",  "$token")
        }
    };
EOM2;
} else { echo <<<EOM3
    var config = {
    };
EOM3;
} echo <<<EOM4
  if (Hls.isSupported()) {
      var hls = new Hls(config);
      hls.loadSource(audioSrc);
      hls.attachMedia(audio);
  } else if (audio.canPlayType('application/vnd.apple.mpegurl')) {
    audio.src = audioSrc;
  } else {
    audio.src = audioSrc;
  }
</script>
EOM4;
} function ht_audio_volume_amixer() { global $ht_jump_addr; global $ht_jump_no; global $ht_jump_val2; global $sno; $ty = 1; $v = ht_audio_get_volume(); echo <<<EOM

<form method='get' action='$ht_jump_addr'>
    <input type="range" id="volume" min="0" max="100" step="5" name='val' style="width:400px;">
    <div id="volume-value"></div>

    <p>&nbsp;</p>
    <button class='btn_ex' type='submit'>音量設定</button>
    <input type='hidden' name=subno  value='$ht_jump_no'>
    <INPUT type='hidden' name='sno'  value='$sno'>
    <INPUT type='hidden' name='val2' value='$ty'>
</form>

<script>

function rangeOnChange(e) {
  setCurrentValue(e.target.value);
}

function setCurrentValue(val) {
  currentValueElem.innerText = '音量 ' + val;
}

window.onload = function () {
  inputElem.addEventListener('input', rangeOnChange); // スライダー変化時
  setCurrentValue(inputElem.value); // ページ読み込み時
}

const inputElem        = document.getElementById('volume');
const currentValueElem = document.getElementById('volume-value');

inputElem.value = $v[0];
</script>
EOM;
} function ht_audio_volume_ncpamixer() { global $ht_jump_addr; global $ht_jump_no; global $ht_jump_val2; global $sno; $ty = 2; $v = array(0,0); echo <<<EOM

<form method='get' action='$ht_jump_addr'>
    <input type="range" id="volume" min="0" max="100" step="5" name='val' style="width:300px;">
    <div id="volume-value"></div>

    <p>&nbsp;</p>
    <button class='btn_ex' type='submit'>音量設定</button>
    <input type='hidden' name=subno  value='$ht_jump_no'>
    <INPUT type='hidden' name='sno'  value='$sno'>
    <INPUT type='hidden' name='val2' value='$ty'>
</form>

<script>

function rangeOnChange(e) {
  setCurrentValue(e.target.value);
}

function setCurrentValue(val) {
  currentValueElem.innerText = '音量 ' + val;
}

window.onload = function () {
  inputElem.addEventListener('input', rangeOnChange); // スライダー変化時
  setCurrentValue(inputElem.value); // ページ読み込み時
}

const inputElem        = document.getElementById('volume');
const currentValueElem = document.getElementById('volume-value');

inputElem.value = $v[0];
</script>
EOM;
} function ht_audio_get_volume() { $v = rf_amixer_get_volume(); return $v; } function ht_audio_set_volume($vol,$mute) { $dev = rf_amixer_get_dev(); if ($dev == '') return array(0,0); $cmd = "amixer sset $dev $vol"."% $mute"; echo_msg(2,$cmd); $outs = external_exec($cmd); $v = ht_audio_now_volume($outs); return $v; } function ht_audio_now_volume($outs) { $l = 0; $r = 0; foreach($outs as $out) { $v = explode(' ',trim($out).'     '); if ($v[0] == 'Mono:') { $v = str_replace(array('[','%]'),'',$v[3],$cnt); $l = $v; $r = $v; if ($cnt != 2) continue; break; } if ($v[0] != 'Front') continue; $v4 = str_replace(array('[','%]'),'',$v[4],$cnt); if ($cnt != 2) continue; if ($v[1] == 'Left:') { $l = $v4; } else if ($v[1] == 'Right:') { $r = $v4; } } return array($l,$r); } function ht_ouchi($course_no) { global $multi_sw; $flist = rfmenu_rec_gogaku_new3_lesson("weekly3",$course_no); $cnt = count_73($flist); if ($cnt <= 0) { echo_msg(2,"レッスンがありません。"); return; } $opt = array( "title" => "レッスン一覧（$cnt 件）", "input_type" => 1, "page_control" => 1, "return_mes" => "戻る", "input_mes" => "レッスンを選択してください", "mode" => 1, "multi" => $multi_sw, "confirm" => 0, "ht_selid" => "" ); $no = rf_pctl_disp($flist, $opt); } function ht_sel_menu($mes,$menus,$multi,$confirm) { global $DS; global $ht_jump_btn1_label; $flists = array(); foreach($menus as $menu => $val) { $flists[] = array('title' => $menu,'val' => $val); } $cnt = count_73($flists); $opt = array( "title" => "$mes", "mode" => 1, "multi" => $multi, "confirm" => $confirm, "ht_selid" => "" ); $ht_jump_btn1_label = "選択"; ht_ask_list($flists,$opt); } function ht_sel_usrdir($base,$dir,$multi,$confirm,$ty) { global $usrdir; global $DS; global $multi_sw; $flists = ht_files_usrdir($base,$dir,$ty); $cnt = count_73($flists); if ($cnt <= 0) { echo_msg(2,"ファイルがありません。"); } $opt = array( "title" => "ファイル一覧 ($dir $cnt 件)", "mode" => 1, "multi" => $multi, "confirm" => $confirm, "ht_selid" => "" ); $ht_jump_btn1_label = "選択"; ht_ask_list($flists,$opt); } function ht_files_usrdir($base,$dir,$ty) { global $usrdir; global $DS; $dir2 = $base.$dir.$DS; if ($ty == 1) { $fls = rfget_flists($dir2); $files = array(); foreach($fls as $fl) { $filepath = pathinfo($fl); $ext = ""; if (array_key_exists('extension',$filepath)) { $ext = $filepath['extension']; } if ($ext == "mp3" || $ext == "m4a") { $files[] = $fl; } } } else { $files = rfget_flists($dir2); if ($dir == 'log') { rsort($files); } } $cnt = count_73($files); $flists = array(); foreach ($files as $file) { $bn = basename($file); $fl = str_replace($base,"",$file,$cnt); if ($ty == 0) { $flists[] = array('title' => "$file",'val' => "$file"); } else { $flists[] = array('title' => "$fl" ,'val' => "$fl"); } } return $flists; } function ht_update_sub_mes($ret,$mes) { switch($ret) { case 0: $mes[] = "アップデートに成功しました。"; break; case 1: $mes[] = "アップデートに失敗しました。"; break; case 2: $mes[] = "アップデートファイルがありません。"; break; case 3: $mes[] = "アップデートファイルが異常です。"; break; case 4: $mes[] = "アップデートファイルの内容が正しくありません。"; break; case 5: $mes[] = "アップデートファイルのバージョンが一致しません。"; break; case 8: $mes[] = "アップデートがありません。"; break; case 9: $mes[] = "入力が間違っています。"; break; case 10: $mes[] = "初期化が終了しました。"; $mes[] = ""; $mes[] = "一旦終了します。"; break; case 11: $mes[] = "初期化が異常終了しました。"; $mes[] = ""; $mes[] = "一旦終了します。"; break; case 21: $mes[] = "updateサイトにアクセスできません"; break; case 22: $mes[] = "更新できません。"; break; case 23: $mes[] = "更新ファイルがありません。"; break; default: $mes[] = "不明なエラーです。（$ret）"; break; } return $mes; } function ht_sitecheck() { global $tmpdir; global $rfriends; global $ui_mode; $ty = 0; $rf = $rfriends.".flg"; $url = rf_get_down_url2(); if ($url === false) { return false; } $updt = rf_update_dir(); $ret = rf_update_get_sys($url.$updt,$rf, $tmpdir, $ty); if ($ret !== false) { return $url; } return false; } function ht_update_sub($val) { global $base; global $svcmode; $mes = array(); $url = ht_sitecheck(); if ($url == false) { ht_update_sub_mes(21,$mes); return 21; } $updt = rf_update_dir(); $url0 = $url.$updt; $updb = rfmenu_update_db($url0,0); $upmax = count_73($updb); if ($upmax == 0) { ht_update_sub_mes(22,$mes); return 22; } $i = $val - 1; if ($i < 0 || $i >= $upmax) { ht_update_sub_mes(22,$mes); return 22; } $title = $updb[$i]['title']; $upval = $updb[$i]['val']; $upname = $updb[$i]['upname']; $rf_fl = $updb[$i]['rf_fl']; $up_fl = $updb[$i]['up_fl']; $up_fln = $updb[$i]['up_fln']; $upflg = $updb[$i]['upflg']; $update_ver = $updb[$i]['update_ver']; $update_dat = $updb[$i]['update_dat']; $mes[] = "$upname : $update_ver"; $mes[] = ""; if ($upflg == 0) { ht_update_sub_mes(23,$mes); return 23; } $rpath = realpath($base."../"); $ftpass = ""; $up_fl = $updb[$i]['up_fl']; $update_dat = $updb[$i]['update_dat']; if ($svcmode["service_mode"] == 1 && $svcmode["service_update_beta"] == 1) { $ftpass = $svcmode["service_update_beta_mgc"]; } if ($ftpass != "") { $up_fl = $updb[$i]['up_fln']; } $ret = rf_update_script($url0, $update_dat, $up_fl, $rpath, $ftpass, 0); $mes = ht_update_sub_mes($ret,$mes); if ($ret == 0) { $mes2 = ht_update_para_all_auto(); array_merge($mes,$mes2); } return $mes; } function ht_update_para_all_auto() { global $defkwdir; global $kwdir; global $program_kw; $lists = [ [1,"rfriends.ini", "パラメータ"], [2,"rfriends_tag.ini","タグ" ], [3,"usrdir.ini", "ユーザdir" ], [4,"premium.ini", "プレミアム"], [5,"sendmail.ini", "メール" ], [6,"rfplay.ini", "パラメータ"] ]; $mes = array(); $mes[] = ""; $mes[] = "設定ファイルを最新にします。"; $mes[] = "ただし、現在のユーザ設定値は保持します。"; $mes[] = ""; foreach($lists as $list) { $no = $list[0]; $file = $list[1]; $name = rf_strimwidth($list[2] . str_repeat(" ",12),0,12); $txt = sprintf("%s(%s)",$name,$file); $ret = rfmenu_update_para($no,$file); if ($ret === false) { $mes[] = "・失敗 : ".$txt; } else{ $mes[] = "・成功 : ".$txt; } } $defpgm = $defkwdir.$program_kw; $pgm = $kwdir.$program_kw; $ft_defpgm = filemtime($defpgm); $ft_pgm = filemtime($pgm); if ($ft_defpgm > $ft_pgm) { $mes[] = ""; $mes[] = "重複番組設定の更新データがあります。"; $mes[] = "現在のデータ : ".date ("Y/m/d H:i:s", $ft_pgm); $mes[] = "更新データ   : ".date ("Y/m/d H:i:s", $ft_defpgm); $mes[] = ""; $ret = rf_move($pgm,$pgm.".bak"); if ($ret === false) { $mes[] = "更新に失敗しました。"; } else{ $mes[] = "更新しました。"; } } return $mes; } function ht_prtest($val) { msgx('<pre>'); print_r($val); msgx('</pre>'); } function ht_config($subno) { global $cfgdir; global $crontabtxt; $exeos = get_rfriends_exeos(); switch ($exeos) { case "WIN": switch ($subno) { case "090301": rfgw_config_sch_reg(); echo_msg(2,"デイリー処理を登録しました。"); break; case "090302": rfgw_config_sch_can(); echo_msg(2,"デイリー処理を取消しました。"); break; } break; case "OSX": switch ($subno) { case "090301": crontab_reserve_osx("on"); echo_msg(2,"デイリー処理を登録しました。"); break; case "090302": crontab_reserve_osx("off"); echo_msg(2,"デイリー処理を取消しました。"); break; } break; case "LNX": switch ($subno) { case "090301": $txts = $_POST['txts']; $txts = str_replace("\r","",$txts); $fl = $cfgdir.$crontabtxt; echo_msg(2,"file : $fl"); echo_msg(2,""); $ret = file_put_contents($fl,$txts,LOCK_EX); if ($ret === false) { echo_msg(2,"file put error ($fl)"); exit; } rf_put_crontab(); echo_msg(2,"デイリー処理を登録しました。"); break; case "090302": rf_init_crontab(); echo_msg(2,"デイリー処理を取消しました。"); echo_msg(2,""); echo_msg(2,"crontabを初期化しました。"); break; } break; } } function ht_autojump($addr,$subno,$val,$val2,$sno,$sel) { echo <<<EOM
<form method="GET" action="$addr">
    <input type="submit" name='dmy'   value=''  id="jump"></button>
    <input type='hidden' name='sel'   value='$sel'>
    <input type='hidden' name='subno' value='$subno'>
    <input type='hidden' name='val'   value='$val'>
    <input type='hidden' name='val2'  value='$val2'>
    <INPUT type='hidden' name='sno'   value='$sno'>
</form>
<script>
document.getElementById('jump').click();
</script>
EOM;
} function ht_restart() { echo <<<EOM1
<p>&nbsp;</p>
<form action='index.html'>
<p style='width:300px'>rfriendsのリスタートボタンを押してください。</p>
<p>&nbsp;</p>
<button class='btn_ex' type='submit'>リスタート</button>
</form>
EOM1;
} function ht_construction($subno) { global $ht_demo; global $scrdir; if ($ht_demo == 0) return; $htmdir = $scrdir.'html/'; $list = file($htmdir.'construction.txt',FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES); foreach($list as $no) { $n = strlen($no); $subno2 = substr($subno,0,$n); if ($subno2 == $no) { echo_msg(2,"no:$no  subno:$subno);"); echo_msg(2,"＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝"); echo_msg(2,"　この機能は現在開発中です。実行できません。"); echo_msg(2,"＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝"); exit; } } } function ht_rec_abort() { global $tmpdir; global $ht_jump_btn1_label; $nw = time(); $fmt_data = rfmenu_rec($nw, 1, 0); $n = count_73($fmt_data); if ($n < 1) { echo_msg(2, "実行中の録音がありません。"); return; } $flist = array(); foreach($fmt_data as $fmt) { $fmt = ltrim($fmt); $fmt = str_replace("  "," ",$fmt); $fmt = str_replace("  "," ",$fmt); $flist[] = array('title' => $fmt, 'val' => $fmt); } $ht_jump_btn1_label = "中止"; $opt = array( "title" => "録音中リスト", "mode" => 1, "multi" => 1, "confirm" => 1, "ht_selid" => "" ); ht_ask_list($flist,$opt); } function ht_play_abort_server($mes) { echo_msg(2,$mes."（サーバ）です。"); ht_play_abort(1); echo_msg(2,""); echo_msg(2,$mes."を中止しました。"); } function ht_play_abort($mode) { global $ht_jump_val; if ($mode == 1) { if (($piddata = rfgw_ffplay_pid()) === false) return; if (rf_ffplay_pid_disp($piddata) < 1) return; rf_ffplay_pid_can($piddata); return; } $piddata = rfgw_ffplay_pid(); if ($piddata === false) { echo_msg(2,"エラーが発生しました。"); return; } $n = rf_ffplay_pid_disp($piddata); if ($n < 1) { echo_msg(2, "再生中のプロセスがありません。"); return; } $ht_jump_val = $piddata[0]; echo_msg(2,""); ht_yesno("再生を中止しますか？"); } function ht_links() { msgx("<hr />"); echo_msg(2,""); echo_msg(2,"rfriendsに関する情報は以下のリンクよりお願いします。"); echo_msg(2,""); echo <<<EOM
<table border="1">
<tr>
<td><strong><span style="color: #2196f3;"><a href="https://twitter.com/rfriends2017" target="_blank" style="color: #2196f3;">&nbsp;X(twitter)&nbsp;</a></span></strong></td>
<td>
<p>&nbsp;リリース情報、障害情報、TIPS等を発信します&nbsp;</p>
</td>
</tr>
<tr>
<td><strong><span style="color: #2196f3;"><a href="http://ceres.s501.xrea.com/wforum/wforum.cgi" target="_blank" style="color: #2196f3;">&nbsp;掲示板&nbsp;</a></span></strong></td>
<td>&nbsp;質問、要望などはこちらにおねがいします&nbsp;</td>
</tr>
<tr>
<td><strong><a href="https://rfriends.hatenablog.com/" target="_blank">&nbsp;hatenablog&nbsp;</a></strong></td>
<td>&nbsp;詳細な変更内容、使い方等を中心に発信します&nbsp;</td>
</tr>
<tr>
<td><strong><a href="http://ceres.s501.xrea.com/wp_rfriends/" target="_blank">&nbsp;WordPress&nbsp;</a></strong></td>
<td>&nbsp;インストール、マニュアルはWPにまとめました&nbsp;</td>
</tr>
</table>
EOM;
echo_msg(2,""); echo_msg(2,"rfriendsをワンコインで応援してください。"); echo_msg(2,""); echo_msg(2,"・PayPay 送金"); echo_msg(2,"　PayPayID  :  rfriends"); msgx('　<a href=https://paypay.ne.jp/guide/send/>paypay送金ガイド</a>'); echo_msg(2,""); echo_msg(2,"・amazonギフト（そのままだと高額になるので要注意、ワンコインで）"); msgx('　<a href=https://www.amazon.co.jp/dp/B09TVHNLHX target="_blank" rel="noopener noreferrer">https://www.amazon.co.jp/dp/B09TVHNLHX</a>'); echo_msg(2,"　email  :  rfriends2017@ymail.ne.jp"); echo_msg(2,""); msgx("<hr />"); } function ht_headless_test() { global $headless_browser; echo_msg(2,""); echo_msg(2,"ヘッドレスブラウザのテストを行います。"); echo_msg(2,""); echo_msg(2,"headless_browser : $headless_browser"); echo_msg(2,""); if ($headless_browser != 'on') { echo_msg(2,"ヘッドレスブラウザのSWがOFFなのでテストを中止します。"); } $msg = "urlを入力してください。"; ht_input($msg,0); } function ht_rss_test() { echo_msg(2,""); echo_msg(2,"rssの表示を行います。"); echo_msg(2,""); $msg = "rssのurlを入力してください。"; ht_input($msg,0); } function ht_audio_test_s($ex_type,$para,$flg) { global $station_logo_url; global $ex_radiko; global $ex_radiru; global $ex_timefree; global $ex_radiru_vod; global $ex_radiru_gogaku; global $nowarea; global $auth_token; global $ui_mode; global $scrdir; $org = 0; switch($ex_type) { case $ex_radiko: $opt = rfriends_live_radiko($ex_type,$para,$flg); break; case $ex_timefree: $opt = rfriends_live_timefree($ex_type,$para,$flg,$org); break; case $ex_radiru: $opt = rfriends_live_radiru($ex_type,$para,$flg); break; case $ex_radiru_vod: case $ex_radiru_gogaku: $opt = rfriends_live_radiru_vod($ex_type,$para,$flg); break; default: return false; break; } if ($opt === false) return false; if ($ui_mode == 22) { if ($para[9] != ";") { msgx('<p><img src='.$para[9].' id="sndimg"></p>'); } else if($ex_type == $ex_radiru || $ex_type == $ex_radiru_vod) { $ch_cs = callsign2($para[6]); if ($ch_cs != "UNKNOWN") { $img = sprintf($station_logo_url, $ch_cs); msgx('<p><img src='.$img.' id="sndimg"></p>'); } } $tmp = explode(",",$opt); $url = str_replace('"','',$tmp[4]); if ($ex_type == $ex_radiko || $ex_type == $ex_timefree) { $nw = explode(",",$nowarea); $area = $nw[0]; $channel = $para[6]; $auth_token = rfriends_auth_audio($ex_type,$area,$channel); if ($auth_token === false) { echo_msg(2,"auth error"); } ht_exaudio($url,$auth_token,""); } else { ht_exaudio($url,"",""); } exit; } $piddata = rfmenu_play_abort_all(); $nam = "rfriends_exec_live"; echo_msg(2,$para[6]); echo_msg(2,$para[7]); echo_msg(2,$para[8]); $ex = "ex_rfriends"; rfgw_batsh_sub($scrdir, $ex, $opt, 1, 1); echo_msg(2, "聴取を開始しました..."); echo_msg(2, "音が出るまで少し時間がかかります"); echo_msg(2, "処理はバックグラウンドで行われます"); return true; } function ht_audio_test() { global $ex_timefree; echo <<<EOM
 <div class="select">
    <input id="file1" type="file" accept=".mp3,.m4a,.aac,.wav,.flac">
    <button onclick="play()" class="btn active">再生</button>
  </div>
EOM;
} function ht_val_check($val) { if (is_array($val)) { $files = $val; } else { $files = array(); $files[] = $val; } return $files; } function ht_download($fl) { if (!file_exists($fl)) return false; header('Content-Description: File Transfer'); header('Content-Type: application/octet-stream'); header('Content-Disposition: attachment; filename="'.basename($fl).'"'); header('Expires: 0'); header('Cache-Control: must-revalidate'); header('Pragma: public'); header('Content-Length: ' . filesize($fl)); while (ob_get_level()) { ob_end_clean(); } readfile($fl); exit; return true; } function ht_filer($fl) { global $DS; $filepath = pathinfo($fl); $ext = ""; if (array_key_exists('extension',$filepath)) { $ext = $filepath['extension']; } $fl2 = ""; if (array_key_exists('basename',$filepath)) { $fl2 = $filepath['basename']; } $dir = dirname($fl,1); if (substr($dir,-1) != $DS) $dir = $dir.$DS; if ($ext == "log" || $ext == "txt" || $ext == "dat") { ht_textedit($fl,0,0); } else if ($ext == "mp3" || $ext == "m4a") { ht_webaudio($fl2,$dir); } else { return false; } return true; } function ht_input_pref() { global $home_area_code; global $nowarea; global $ui_mode; global $ht_jump_addr; global $ht_jump_btn1_label; global $ht_jump_no; global $sno; $ht_jump_btn1_label = "選択"; global $pref_code; echo <<<EOM1
<form method='get' action='$ht_jump_addr'>
<select name=val size=10 style='width:300px' required>
EOM1;
foreach ($pref_code as $key => $val) { $val2 = $val; msgx("<option value='$key,$val2'>&nbsp;$val2(JP$key)</option>".PHP_EOL); } echo <<<EOM2
</select>
<p><br>
<button class='btn_ex' type='submit' name=sel value=1>$ht_jump_btn1_label</button>
</p>
<INPUT type='hidden' name='subno' value='$ht_jump_no'>
<INPUT type='hidden' name='sno'   value='$sno'>
</p>
</form>
EOM2;
exit; } function ht_pref_view() { global $pref_code; $i = 1; $j = 0; $jmax = 5; $str = ""; msgx("<table>"); foreach ($pref_code as $key => $val) { $val2 = mb_ereg_replace("県","",$val); $val2 = mb_ereg_replace("府","",$val2); $val2 = mb_ereg_replace("東京都","東京",$val2); $j++; if ($j >= $jmax) { $str .= sprintf("<td>%2s</td><td></td><td>%s</td><td></td>", $key, $val2); msgx("<tr>$str</tr>"); $str = ""; $j = 0; } else { $str .= sprintf("<td>%2s</td><td></td><td>%s</td><td></td>", $key, $val2); } } msgx("<tr>$str</tr>"); msgx("</table>"); } function ht_premium() { global $premium_area; global $premium; global $premium_mail; global $premium_password; global $premium_areafree; global $premium_timefree30; echo_msg(2, "現在のプレミアム設定は以下のとおりです。"); echo_msg(2, ""); echo_msg(2, "premium : $premium"); echo_msg(2, "premium_mail : $premium_mail"); $pp = ""; if ($premium_password != "") $pp = "********"; echo_msg(2, "premium_password  : $pp"); echo_msg(2, ""); echo_msg(2, "premium_areafree : $premium_areafree"); echo_msg(2, "premium_timefree30 : $premium_timefree30"); if (premium_check() <= 0) { echo_msg(2, ""); echo_msg(2, "プレミアムユーザ設定を行ってください。"); return false; } $ret = premium_logincheck(); if ($ret == true) { echo_msg(2, ""); echo_msg(2, "ラジコプレミアムにログイン中です。"); } echo_msg(2, ""); echo_msg(2, "現在のプレミアムエリア : $premium_area"); return true; } function ht_dom($html,$ty,$fl) { global $logdir; switch($ty) { case 'dom': $domDocument = new DOMDocument(); @$domDocument->loadHTML($html);; return $domDocument; break; case 'xml': $domDocument = new DOMDocument(); $domDocument->formatOutput = true; $internalErrors = libxml_use_internal_errors(true); $domDocument->loadHTML($html); libxml_use_internal_errors($internalErrors); $xmlString = $domDocument->saveXML(); $xmlObject = rf_simplexml_load_string($xmlString); return $xmlObject; break; case 'xpath': $domDocument = new DOMDocument(); @$domDocument->loadHTML($html); $xpath = new DOMXPath($domDocument); return $xpath; break; case 'dom2': $doc0 = new DOMDocument('1.0'); $doc0->formatOutput = true; @$doc0->loadHTML($html); $xmlString = $doc0->saveXML(); $doc = new DOMDocument('1.0'); $doc->formatOutput = true; @$doc->loadXML($xmlString); $root = $doc->createElement('book'); $root = $doc->appendChild($root); $title = $doc->createElement('title'); $title = $root->appendChild($title); $text = $doc->createTextNode('This is the title'); $text = $title->appendChild($text); $doc->save($fl."_xml2.xml"); break; default: break; } return false; } function ht_print_dom($fl,$dat) { ob_start(); print_r($dat); $buffer = ob_get_contents(); ob_end_clean(); file_put_contents($fl,$buffer); } function ht_audee_xpath($url,$q,$m0,$m1) { $lists = array(); $xpath = url2xpath($url); $result = @$xpath->query($q); $cnt1 = $result->length; if ($cnt1 < 1) { return false; } foreach($result as $val) { $href = (string)$val->attributes->item($m0)->textContent; $result2 = @$xpath->query('.//p',$val); $cnt2 = $result2->length; if ($cnt2 < 1) continue; $p = (string)$result2->item($m1)->textContent; $p = utf8mac2utf8($p); $lists[] = array('title'=>$p,'val'=>"$href"); } return $lists; } function ht_audee_xml($url,$q) { $lists = array(); $xmlObject = url2xml($url); $result = @$xmlObject->xpath($q); foreach($result as $val) { $href = (string)$val->attributes()->href; $p = (string)$val->p; $p = utf8mac2utf8($p); $lists[] = array('title'=>$p,'val'=>"$href"); } return $lists; } function ht_timefree_live($wdat) { global $ex_timefree; if (count_73($wdat) <= 0) { echo_msg(2,"リストが空です。"); return; } sort($wdat); $confirm = 0; $ttl = "放送済番組"; $mode = 2; $flist = rfmenu_program_list($ex_timefree, $wdat,$mode); $n = count_73($flist); $opt = array( "title" => "$ttl ($n 件)", "input_type" => 1, "page_control" => 1, "return_mes" => "", "input_mes" => "", "mode" => 1, "multi" => 0, "confirm" => $confirm, "ht_selid" => "selpgm" ); $ans = ht_ask_list($flist,$opt); return; } function ht_set_val($val) { if (is_array($val)) { $val0 = $val; } else { $val0[] = $val; } return $val0; } function ht_get_rss_info($doc,$ty) { $itemlists = array(); if ($ty == 0 || $ty == 1) { $title0 = (string)$doc -> channel ->title; $description0 = (string)$doc -> channel ->description; $pubDate0 = ""; $url0 = ""; $image0 = (string)$doc -> channel ->image -> url; $pos = strpos($image0,'?'); if ($pos != false ) $image0 = substr($image0,0,$pos); $itemlists[] = array ( 'title' => $title0, 'description' => $description0, 'pubDate' => $pubDate0, 'url' => $url0, 'image' => $image0 ); } if ($ty == 0 || $ty == 2) { foreach($doc ->channel->item as $item) { $title = (string)$item ->title; $description = (string)$item ->description; $pubDate = (string)$item ->pubDate; $enclosure = $item -> enclosure; $url = (string)$enclosure['url']; $pos = strpos($url,'?'); if ($pos != false ) $url = substr($url,0,$pos); $otherNode = $item->children('itunes', TRUE); $image = (string)$otherNode->image->attributes()->href; $pos = strpos($image,'?'); if ($pos != false ) $image = substr($image,0,$pos); $itemlists[] = array ( 'title' => $title, 'description' => $description, 'pubDate' => $pubDate, 'url' => $url, 'image' => $image ); } } return $itemlists; } function ht_rss_exec($sel,$rss) { global $cfgdir; global $podcastdat; global $ht_jump_btn2; global $ht_jump_btn3; global $ht_jump_btn1_label; global $ht_jump_btn2_label; global $ht_jump_btn3_label; global $ht_jump_val2; global $multi_sw; $parse = rf_pcast_info_rss($rss,""); if ($parse === false) { echo_msg(2,"rss : $rss"); echo_msg(2,"rssファイルが壊れています。"); echo_msg(2,"処理を中止します。"); return; } $title = $parse['title']; $desc = $parse['desc']; $count = $parse['count']; $image = $parse['image']; echo_msg(2,"$title($rss)"); if ($image != "") { echo "<img src='$image' width=60 align=top>"; } echo_msg(2,$desc); echo_msg(2,""); $lists = rf_pcast_rss_detail($rss,0); if ($lists === false) { echo_msg(2,"エピソードがありません。"); return; } if ($sel == 2) { $pcastfile = $cfgdir.$podcastdat; file_put_contents($pcastfile,"$title,$rss\n",FILE_APPEND); echo_msg(2,"プリセットに登録しました。"); return; } $ht_jump_btn2 = 1; $ht_jump_btn3 = 1; $ht_jump_btn1_label = "録音"; $ht_jump_btn2_label = "聴取"; $ht_jump_btn3_label = "聴取(サーバ)"; $ht_jump_val2 = $rss; $opt = array( "title" => "タイトル一覧($count 件)", "mode" => 1, "multi" => $multi_sw, "confirm" => 0, "ht_selid" => "", "ht_width" => 80 ); ht_ask_list($lists,$opt); } function ht_audee_exec($sel,$val,$val2) { global $cfgdir; global $podcastdat; global $ht_jump_addr; global $ht_jump_btn2; global $ht_jump_btn1_label; global $ht_jump_btn2_label; global $ht_jump_val; global $ht_jump_val2; global $ht_jump_no; global $multi_sw; global $headless_browser; $v = explode(",",$val); if (count_73($v) == 3) { $url = $v[0]; $st = $v[1]; $en = $v[2]; } else { $url = $val; $st = 1; $en = 1; } $url = rf_podcast_audee_voice_url($url); if ($url === false) { echo_msg(2,"$val2 にはエピソードがありません。"); return; } echo_msg(2,"$val2 ($url) $st,$en"); echo_msg(2,""); if ($sel == 2) { $pcastfile = $cfgdir.$podcastdat; file_put_contents($pcastfile,"$val2,$url\n",FILE_APPEND); echo_msg(2,"プリセットに登録しました。"); return; } $headless = 0; if ($headless_browser == 'on') { if (rfgw_headless_examine() == 1) { $headless = 1; } } if ($headless == 0) { echo_msg(2,"ヘッドレスブラウザが動作していないので最新９件までになります。"); echo_msg(2,""); ht_audee_detail("Audee Podcast(タイトル一覧)",$multi_sw,$url,1,1); return; } $ht_jump_btn1_label = "選択"; $ht_jump_addr = "menu_ss.html"; $ht_jump_no = "070300"; $ht_jump_val2 = $val2; ht_audee_page('Audee Podcast(ページ一覧)',0,$url,$val2); } function ht_symlink() { global $DS; global $usrdir; global $htmldir; global $usrdir_link; global $link_flg; if ($link_flg != 1) return false; $html_tmpdir = $htmldir.'temp'.$DS; $link = 'usr'; $usrdir_link = $html_tmpdir.$link.$DS; $dir = rfgw_symlink_status($html_tmpdir,$link); if ($dir !== false) { if ($dir == $usrdir) { return true; } if (rfgw_symlink_remove($html_tmpdir,$link) === false) { rf_error_log("error remove : $html_tmpdir.$link"); $link_flg = 0; return false; } } $ret = rfgw_symlink_make($html_tmpdir,$link,$usrdir); if ($ret === true) { rf_error_log("success make : $usrdir"); return true; } rf_error_log("error make : $usrdir"); $link_flg = 0; return false; } function ht_rasp_expand() { echo_msg(2,""); echo_msg(2,"rasp_expand"); echo_msg(2,""); $mdl = rfgw_is_rasp(); if ($mdl === false) { echo_msg(2,"この機能はraspberry pi 専用です。"); return; } echo_msg(2,"model : $mdl"); echo_msg(2,""); ht_yesno("Raspberry Piの領域を拡張しますか？"); } function ht_get_program() { echo_msg(2,""); echo_msg(2,"番組表refresh"); echo_msg(2,""); ht_yesno("番組表を更新しますか？"); } function ht_get_server() { echo_msg(2,""); ht_print_r($_SERVER,'$_server'); } function ht_rpi_exec($cmd,$mode) { if ($mode == 0) { exec($cmd, $output, $retval); } else { echo_msg(2,"cmd : $cmd"); $retval = 0; $output[0] = 'test mode'; } if ($retval == 0) { return $output; } else { return false; } } function ht_input_cmd() { echo_msg(2,""); echo_msg(2,"input_cmd"); echo_msg(2,""); $exeos = get_rfriends_exeos(); switch ($exeos) { case "WIN": break; case "LNX": break; case "OSX": echo_msg(2,"この機能は動作しません。"); return; break; default: echo_msg(2,"この機能は動作しません。"); return; break; } echo <<<EOF
<form method='get' action='menu_ss.html'>
<p>キーワードまたはジャンルを入力してください。</p>

<p><input class='inp_no' type='text' name='val' value='' style='width:300px;text-align:left;'></p>
<p align=left><button class='btn_ex' type='submit'>実行</button></p>
<input type='hidden' name=subno value=010703>
<input type='hidden' name=val2  value=10>
<INPUT type='hidden' name='sno' value='s01'>
</form><li>&nbsp;</li>
EOF;
} function ht_applepodcasts() { global $cfgdir; global $scrdir; global $podcastdat; $fl = $scrdir."applepodcasts.dat"; $dat = file($fl); $flist = array(); $ttl = "全て"; $category = "0000,全て"; $flist[] = array('title' => $ttl, 'val' => $category); foreach($dat as $dt) { if (substr($dt,0,1) == ";") continue; $cat = explode(",",$dt); if (count_73($cat) != 3) continue; $no = $cat[0]; $ttl = $cat[1]; $ttle = $cat[2]; $category = "$no,$ttl"; $flist[] = array('title' => $ttl, 'val' => "$category"); } $count = count_73($flist); $opt = array( "title" => "カテゴリ一覧($count 件)", "input_type" => 0, "page_control" => 1, "return_mes" => "戻る", "input_mes" => "カテゴリを選択してください", "mode" => 1, "multi" => 0, "confirm" => 0, "ht_selid" => "" ); $no = rf_pctl_disp($flist, $opt); $ans0 = $no[0]; if ($ans0 == "r") { return false; } $ttl = $flist[$ans0-1]['title']; $val = $flist[$ans0-1]['val']; $category = $flist[$ans0-1]['category']; echo_msg(2,"$ttl,$val,$category"); return false; } function ht_applepodcasts_id($category,$name,$limit) { global $cfgdir; global $scrdir; global $podcastdat; $itunes = "https://itunes.apple.com/jp/rss/toppodcasts/"; $limit2 = $limit; if (1 > $limit2) $limit2 = 1; if ($category == "0000") { $url = $itunes."limit=$limit2/json"; } else { $url = $itunes."genre=$category/limit=$limit2/json"; } if (($json = rf_get_json($url)) === false) { return false; } $json = str_replace('"im:id"','"imid"',$json); $ranking = @json_decode($json); if (is_null($ranking)) return false; $lists = $ranking->feed->entry; $cnt = count_73($lists); foreach($lists as $list) { $title = $list->title->label; $title = str_replace(",",".",$title); $id = $list->id->attributes->imid; $flist[] = array('title' => $title,'val' => $id); } $count = count_73($flist); $opt = array( "title" => "ポッドキャスト一覧(カテゴリ:$name , $count 件)", "input_type" => 0, "page_control" => 1, "return_mes" => "戻る", "input_mes" => "ポッドキャストを選択してください", "mode" => 1, "multi" => 0, "confirm" => 0, "ht_selid" => "", "ht_width" => 80, "num" => 1 ); $no = rf_pctl_disp($flist, $opt); $ans0 = $no[0]; if ($ans0 == "r") { return false; } $ttl = $flist[$ans0-1]['title']; $val = $flist[$ans0-1]['val']; echo_msg(2,"$ttl,$val"); return false; } function ht_get_asound_list() { $lists = array(); $out = cmd_prn(2,"sound","cat /proc/asound/modules"); if ($out === false) { return $lists; } $cards = explode("\n",$out); foreach($cards as $card) { $card = trim($card); if ($card == "") continue; $cdat = explode(' ',$card); if (count_73($cdat) < 2) continue; $lists[] = $cdat[0].",".$cdat[1]; } return $lists; } function ht_now_asound_no() { $user = get_current_user(); $fil = "/home/$user/.asoundrc"; if (!file_exists($fil)) { return 0; } $out = cmd_prn(2,"card","cat $fil | grep card"); if ($out === false) { return 0; } $cards = explode("\n",$out); if (count_73($cards) < 2) { return 0; } $card = explode(' ',trim($cards[1])); if (count_73($card) < 2) { return 0; } return $card[1]; } 