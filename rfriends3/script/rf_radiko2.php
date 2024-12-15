<?php
 function ext_radiko_auth_mode2($mode,$area_code) { global $radiko_auth_mode; global $radiko_auth_mode2_url; global $radiko_auth_mode2_pref; global $home_area_code; global $nowarea; global $tmpdir; if ($area_code == "") { $area_code = sprintf("JP%d", $radiko_auth_mode2_pref); $home_area_code = $area_code; return true; } $dat = ext_radiko_auth_check($mode,$area_code,0); if ($dat !== false) { $dt = $dat[0]; $authtoken = $dat[1]; $area = $dat[2]; $diff = $dat[5]; echo_prn(1,"use prev. token"); return $authtoken; } for ($i=0;$i<5;$i++) { $dat = ext_radiko_auth_mode2_wget(1,$area_code); if ($dat !== false) break; $dat = ext_radiko_auth_mode2_wget(2,$area_code); if ($dat !== false) break; sleep(1); } if ($dat === false) { echo_prn(1,"Failed to get token(1)"); return false; } $dt = $dat[0]; $authtoken = $dat[1]; $area = $dat[2]; $url = $dat[5]; if ($authtoken === false) { echo_prn(1,"Failed to get token(2)"); return false; } rf_put_auth($authtoken); echo_prn(1,"new(".$i.") token dt:$dt  auth:$authtoken  area:$area  addr:$url"); return $authtoken; } function ext_radiko_auth_mode2_wget($no,$area_code) { global $radiko_auth_mode; global $radiko_auth_mode2_url; global $radiko_auth_mode2_url2; global $tmpdir; if ($no == 1) { if ($radiko_auth_mode2_url == "") { return false; } $mode2_url = $radiko_auth_mode2_url; } else { if ($radiko_auth_mode2_url2 == "") { return false; } $mode2_url = $radiko_auth_mode2_url2; } $url = "http://".$mode2_url."/buddy/auth.php?mode=2\&pref=".$area_code; $out = rf_wget_out_exec($url, ""); if ($out === false) { return false; } if (strlen($out) < 3) { return false; } if (substr($out,0,3) != "dap") { return false; } $out = substr($out,3)."="; $ans = base64_decode($out); if ($ans === false) { return false; } for ($i=0;$i<strlen($ans);$i++) { $d = $ans[$i]; $d = $d ^ chr(0xff); $ans[$i] = $d; } $ans2 = @gzuncompress($ans); if ($ans2 === false) { return false; } $dat = explode(",",$ans2); if (count_73($dat) != 7) { return false; } $buddy = $dat[0]; $ret = $dat[1]; $authtoken = $dat[2]; $area = $dat[3]; $pref_kan = $dat[4]; $pref_asc = $dat[5]; $get_time = $dat[6]; if (substr($buddy,0,5) != "buddy") { return false; } if ($ret != 0) { return false; } $dat2[0] = date("YmdHis",$get_time); $dat2[1] = $authtoken; $dat2[2] = $area; $dat2[3] = $pref_kan; $dat2[4] = $pref_asc; $dat2[5] = $mode2_url; return $dat2; } function ext_radiko_auth_check($mode,$area_code,$force) { global $radiko_auth_mode; global $auth_token_dat; global $auth_life_time; global $auth_life_time2; global $auth_life_time3; if ($force == 1) { fin_unlink($auth_token_dat); echo_prn(2,"delete token"); return false; } $ret = rf_get_auth(); if (is_null($ret)) { echo_prn(2,"token not found"); return false; } $dt = $ret[0]; $authtoken = $ret[1]; $area = $ret[2]; $diff = time() - strtotime($dt); if ($mode == 0 && $area_code != $area) { fin_unlink($auth_token_dat); echo_prn(1,"change area from $area to $area_code"); return false; } $life_time = $auth_life_time; if ($radiko_auth_mode == 2) $life_time = $auth_life_time2; if ($radiko_auth_mode == 3) $life_time = $auth_life_time3; echo_prn(1,"prev.  token dt:$dt  auth:$authtoken  area:$area  diff:$diff ? $life_time"); if ($diff < 0 || $diff > $life_time) { fin_unlink($auth_token_dat); echo_prn(1,"expire token diff:$diff > $life_time"); return false; } $ret[5] = $diff; return $ret; } function rf_radiko_auth_hls_f($area, $head) { global $tmpdir; global $extdir; global $DS; global $ext_const0; global $ext_constp; global $fms1urlhls; global $fms2urlhls; global $svcmode; $mgc = $svcmode["service_mgc"]; if ($mgc === false) $mgc = ""; if ($ext_const0 != $mgc) { echo_msg(2, "error ext_const"); return null; } if (($no = rf_convjp($area)) == 0) { echo_msg(2, "error area ($area)"); return null; } $dat = rf_device_info(); $ans = rf_device_f_lat_lon($no); $lat = $ans[0]; $lon = $ans[1]; $loc = "$lat,$lon,gps"; $ans = rf_get_pref($lat, $lon); $pcode = $ans[0]; $addr = $ans[1]; echo_prn(1, "$no:$pcode $lat,$lon $addr"); $auth1 = $tmpdir.$head.".auth1"; $auth2 = $tmpdir.$head.".auth2"; fin_unlink($auth1); fin_unlink($auth2); $opt = ext_device_header1($dat); echo_prn(1, "$opt"); if (rf_wget($fms1urlhls, $auth1, $opt) === false) { echo_prn(1, "auth1 error"); fin_unlink($auth1); return null; } if (!file_exists($auth1)) { echo_prn(1, "not exists $auth1"); return null; } $auth = file_get_contents($auth1); fin_unlink($auth1); $ret = get_auth1_value($auth); if ($ret[0] != 0) { echo_prn(1, "auth1_value error"); return null; } $atk = $ret[1]; $ofs = $ret[3]; $len = $ret[4]; $pkey = rf_device_pkey($ofs, $len); if ($pkey === false) { echo_prn(1, "partialkey error : $ofs,$len"); return null; } $opt = ext_device_header2($dat, $atk, $loc, $pkey); if (rf_wget($fms2urlhls, $auth2, $opt) === false) { echo_prn(1, "auth2 error"); return null; } if (!file_exists($auth2)) { echo_prn(1, "not exists $auth2"); return null; } $auth = file_get_contents($auth2); fin_unlink($auth2); return $atk; } function rf_device_pkey($ofs, $len) { global $scrdir; $fil = [ 'mercury', 'venus', 'earth', 'mars', 'jupiter', 'saturn' ]; $n1 = intval($ofs / 3200); $n2 = intval(($ofs+$len-1) / 3200); $ofs2 = $ofs - ($n1 * 3200); if ($n1 < 0 || $n1 > 5) return false; $fl = $scrdir.$fil[$n1]; if (!file_exists($fl)) { return false; } $keyf1 = file_get_contents($fl); if ($n2 == ($n1+1)) { $fl = $scrdir.$fil[$n2]; if (!file_exists($fl)) { return false; } $keyf2 = file_get_contents($fl); $keyf1 .= $keyf2; unset($keyf2); } else if ($n2 != $n1) { return false; } $dt = substr($keyf1, $ofs2, $len); for ($i=0;$i<strlen($dt);$i++) { $d = $dt[$i]; $d = $d ^ chr(0xff); $dt[$i] = $d; } $pkey = base64_encode($dt); unset($keyf1); return $pkey; } function rf_device_f_lat_lon($no) { $pref_lat = [ 43.063968, 40.824623, 39.703531, 38.268839, 39.718600, 38.240437, 37.750299, 36.341813, 36.565725, 36.391208, 35.857428, 35.605058, 35.689521, 35.447753, 37.902418, 36.695290, 36.594682, 36.065219, 35.664158, 36.651289, 35.391227, 34.976978, 35.180188, 34.730283, 35.004531, 35.021004, 34.686316, 34.691279, 34.685333, 34.226034, 35.503869, 35.472297, 34.661772, 34.396560, 34.186121, 34.065770, 34.340149, 33.841660, 33.559705, 33.606785, 33.249367, 32.744839, 32.789828, 33.238194, 31.911090, 31.560148, 26.212401 ]; $pref_lon = [ 141.347899, 140.740593, 141.152667, 140.872103, 140.102334, 140.363634, 140.467521, 140.446793, 139.883565, 139.060156, 139.648933, 140.123308, 139.691704, 139.642514, 139.023221, 137.211338, 136.625573, 136.221642, 138.568449, 138.181224, 136.722291, 138.383054, 136.906565, 136.508591, 135.868590, 135.755608, 135.519711, 135.183025, 135.832744, 135.167506, 134.237672, 133.050499, 133.934675, 132.459622, 131.470500, 134.559303, 134.043444, 132.765362, 133.531080, 130.418314, 130.298822, 129.873756, 130.741667, 131.612591, 131.423855, 130.557981, 127.680932 ]; if ($no < 1 || $no > 47) { return false; } $dlat = ((mt_rand() / mt_getrandmax()) - 0.5) / 500; $dlon = ((mt_rand() / mt_getrandmax()) - 0.5) / 500; $lat = round(trim($pref_lat[$no - 1]) + $dlat, 6); $lon = round(trim($pref_lon[$no - 1]) + $dlon, 6); return [$lat,$lon]; } function rf_device_lat_lon() { global $usrdir; global $tmpdir; $geo = $usrdir."geodata"; if (!file_exists($geo)) { echo ("geo data not found : $geo \n"); return false; } $dat = explode(",", file_get_contents($geo)); if (empty($dat)) { echo ("geo data empty error : $geo \n"); return false; } if (count_73($dat) != 3) { echo ("geo data error : $geo \n"); return false; } $loc = $dat[0]; $lat = (double)$dat[1]; $lon = (double)$dat[2]; return [$lat,$lon]; } function rf_device_info() { $app = "aSmartPhone7a"; $version = ["7.1.0", "7.1.1", "7.1.2"]; $device1 = "25.NDE63"; $device2 = ["P", "H", "L", "V", "X"]; $connect = ["mobile","wifi"]; $n = ext_device_rnd(count_73($version)); $ver = $version[$n]; $n = mt_rand(); $usr = md5($n); $n = ext_device_rnd(count_73($device2)); $dev = $device1.$device2[$n]; $n = ext_device_rnd(count_73($connect)); $con = $connect[$n]; return [$app,$ver,$usr,$dev,$con]; } function rf_get_pref_gsi($lat, $lon) { global $pref_url; $pcode = 0; $addr = ""; $exurl = '"'.$pref_url."?"."lat=$lat"."&"."lon=$lon".'"'; $out = rf_wget_out_once($exurl, "-q -t 1 -T 10"); $json_data = @json_decode($out,true); if ($json_data != null) { if (isset($json_data["results"]["muniCd"]) !== false) { $pcode = $json_data["results"]["muniCd"]; } if (isset($json_data["results"]["lv01Nm"]) !== false) { $nam = explode(",",$json_data["results"]["lv01Nm"]); $addr = trim($nam[0]); } } if ($addr == "") $addr = "n/a"; return [$pcode,$addr]; } function rf_get_pref_osm($lat, $lon) { global $pref_url2; $pcode = 0; $addr = ""; $exurl2 = '"'.$pref_url2."?"."lat=$lat"."&"."lon=$lon"."&"."format=json".'"'; $out = rf_wget_out_once($exurl2, "-q -t 1 -T 10"); $json_data = @json_decode($out,true); if ($json_data != null) { if (isset($json_data["address"]["ISO3166-2-lvl4"]) !== false) { $pcode = $json_data["address"]["ISO3166-2-lvl4"]; } $pcode = str_replace("JP-","",$pcode); if (isset($json_data["display_name"]) !== false) { $nam = explode(",",$json_data["display_name"]); $addr = trim($nam[0]); } } if ($addr == "") $addr = "n/a"; return [$pcode,$addr]; } function rf_get_pref($lat, $lon) { global $radiko_auth_mode3_dat; $pcode = 0; $addr = ""; $prev_mode3_dat = $radiko_auth_mode3_dat."_prev"; $prev_gps = rf_get_pref_check($radiko_auth_mode3_dat,$prev_mode3_dat); if ($prev_gps !== false) { $pcode = $prev_gps[0]; $addr = $prev_gps[1]; return [$pcode,$addr]; } $ret = rf_get_pref_gsi($lat, $lon); $pcode = $ret[0]; $addr = $ret[1]; if ($pcode != 0 && $addr != "") { $ret = rf_put_pref($radiko_auth_mode3_dat, $prev_mode3_dat, $pcode,$addr,"gsi"); return [$pcode,$addr]; } rf_error_log("rf_get_pref data error(gsi) : $lat,$lon"); $ret = rf_get_pref_osm($lat, $lon); $pcode = $ret[0]; $addr = $ret[1]; if ($pcode != 0 && $addr != "") { $ret = rf_put_pref($radiko_auth_mode3_dat, $prev_mode3_dat, $pcode,$addr,"osm"); return [$pcode,$addr]; } rf_error_log("rf_get_pref data error(osm) : $lat,$lon"); return [$pcode,$addr]; } function rf_get_pref_check($mode3_dat, $prev_mode3_dat) { if (!file_exists($mode3_dat)) return false; if (!file_exists($prev_mode3_dat)) return false; $out = rf_get_mode3_dat($mode3_dat); if ($out === false) return false; $lat = $out[0]; $lon = $out[1]; $out = @file_get_contents($prev_mode3_dat); if ($out === false) return false; $prev_gps = explode(",",$out); if (count_73($prev_gps) < 5) return false; $lat2 = trim($prev_gps[0]); $lon2 = trim($prev_gps[1]); $pcode = trim($prev_gps[2]); $addr = trim($prev_gps[3]); $ref = trim($prev_gps[4]); if ("$lat" == "$lat2" && "$lon" == "$lon2") { return [$pcode,$addr]; } return false; } function rf_put_pref($mode3_dat, $prev_mode3_dat, $pcode,$addr,$ref) { $out = rf_get_mode3_dat($mode3_dat); if ($out === false) return false; $lat = $out[0]; $lon = $out[1]; $ret = file_put_contents($prev_mode3_dat, "$lat,$lon,$pcode,$addr,$ref", LOCK_EX); if ($ret === false) return false; return true; } function rf_get_mode3_dat($mode3_dat) { if (!file_exists($mode3_dat)) return false; $out = @file_get_contents($mode3_dat); if ($out === false) return false; $gps = explode(",",trim($out)); if (count_73($gps) < 2) return false; $lat = trim($gps[0]); $lon = trim($gps[1]); return [$lat,$lon]; } 