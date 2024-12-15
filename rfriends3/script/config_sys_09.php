<?php
 $product_name = "rfriends"; $rf_display_errors = 1; $rf_error_reporting = E_ALL; $rf_log_errors = 1; $link_flg = 1; $ds_retry_max = 10; $ds_debug = 0; $ext_const1 = "radiko"; $prog_retry = 5; $prog_wait = 10; $radiko_prog_retry = 5; $radiko_prog_wait = 2; $radiko_timeofbegin = 5; $prog_ext_mode = "rec"; $prog_ext_type = "with"; $radiko_today_disp_offset = 0; $radiko_today_disp_dur = 24 * 60 * 60; $auth_life_time = 3600; $auth_life_time2 = 300; $auth_life_time3 = 300; $ext_const2 = "radiru"; $radiru_prog_retry = 5; $radiru_prog_wait = 2; $radiru_timeofbegin = 5; $radiru_today_disp_offset = 0; $radiru_today_disp_dur = 24 * 60 * 60; $tout_rate = 4; $tout_allow = 120; $timefree_pre_margin = 0; $timefree_post_margin = 0; $timefree_wait = 5; $radiru_vod_wait = 5; $premium_lifetime = 4; $ext_const0 = "common"; $strip_tags_flag = 1; $strip_space_flag = 1; $stripos_flag = 1; $infotext_flag = 1; $add_tag = 1; $add_img = 1; $add_img_app_win = "AtomicParsley"; $add_img_app_osx = "AtomicParsley"; $add_img_app_lnx = "AtomicParsley"; $sort_flag = 1; $del_log = 1; $ok_head = ""; $ng_head = "_ng"; $tf_footer = ""; $convert_kana = 1; $convert_kana_para ="as"; $rec_sleep_pgm = "rfriends_rec_sleep.php"; $rec_pgm = "rfriends_rec.php"; $rec_fin_pgm = "rfriends_rec_fin.php"; $s_mkoffs = $standby_time*60 + 70; $s_mkdur = 3600*2; $standby_time_flu = 2; $f_rmargin = 1*60; $t_rmargin = 2*60; $log = 0; $debug = 1; $space_min = 50; $tmp_space_min = 50; $ex_limit = 5; $rsv_max = 400; $rsv_max_timefree = 1000; $sec_name = array( 'unknown', 'common', 'timefree', 'radiko', 'radiko_timerec', 'radiru', 'radiru_vod', 'radiru_gogaku', 'common_ng', 'timefree_ng', 'radiko_ng', 'radiru_ng', 'radiru_vod_ng', 'radiru_gogaku_ng', 'radiru_main_station', 'radiru_station', 'radiru_timerec', 'radiru_other_timerec', 'radiru_tokyo', 'radiru_sendai', 'radiru_nagoya', 'radiru_osaka', 'radiru_sapporo', 'radiru_hiroshima', 'radiru_matsuyama', 'radiru_fukuoka', 'premium_main_station', 'premium_station', 'double_program_radiko', 'double_program_radiru', 'double_program_timefree', 'double_program_radiru_vod', 'double_program_radiru_gogaku', 'target_program', 'exception_program' ); $auth_sleep = 15; $auth_retry = 5; $auth_type = 0; $msg_level = 1; $dlmt = ";"; $end_log = 0; $dontsleep_timer = 30; $dontsleep_timer_tf = 10; $fin_sleep = 5; $sch_life_time = 3600; $cfg_life_time = 3600; $cleanlog_fn = "rfriends_cleanlog"; $cleanlog_time = 3600 * 8; $rec_extension = "m4a"; $dwn_extension = "m4a"; $prohibit_mp3 = 1; $multi_sw = 1; $macos_launch_type = 0; $rec_normal_end = 0; $rec_already_exist = 1; $rec_not_deliver = 2; $rec_abnormal_end = 3; $rec_normal_end_plus = 11; $loghead_short = "[SHT]"; $loghead_bad = "[BAD]"; $loghead_cancel = "[CAN]"; $loghead_delay = "[DLY]"; $loghead_abnormal = "[ABN]"; $loghead_skip = "[SKP]"; $loghead_error = "[ERR]"; $hls_type = 0; $radiko_host = "radiko.jp"; $radiko_base_img = "https://radiko.jp/res/program/DEFAULT_IMAGE/"; $prog_url = "https://radiko.jp/v3/program/date/"; $radiko_prog_url = "https://radiko.jp/v3/program/date/"; $playlisturl = "https://radiko.jp/v2/api/ts/playlist.m3u8?l=15&station_id="; $playlisturl2 = "https://tf-f-rpaa-radiko.smartstream.ne.jp/tf/playlist.m3u8?l=15&type=b&station_id="; $playerurl = "https://radiko.jp/apps/js/flash/myplayer-release.swf"; $m3u8header = " -q " . "--header=\"pragma: no-cache\" " . "--header=\"Content-Type: application/x-www-form-urlencoded\" " . "--header=\"Referer: $playerurl\" " . "--no-check-certificate " . "--post-data='flash=1' "; $streamurlhls = "https://radiko.jp/v2/station/stream_smh_multi/"; $fms1urlhls = "https://radiko.jp/v2/api/auth1"; $fms2urlhls = "https://radiko.jp/v2/api/auth2"; $playercommon = "https://radiko.jp/apps/js/playerCommon.js"; $xheader = "X-Radiko"; $header1hls = "-q  " . "--header=\"pragma: no-cache\" " . "--header=\"X-Radiko-App: pc_html5\" " . "--header=\"X-Radiko-App-Version: 0.0.1\" " . "--header=\"X-Radiko-User: dummy_user\" " . "--header=\"X-Radiko-Device: pc\" " . "--no-check-certificate " . "--save-headers "; $header2hls = "-q " . "--header=\"pragma: no-cache\" " . "--header=\"X-Radiko-App: pc_html5\" " . "--header=\"X-Radiko-App-Version: 0.0.1\" " . "--header=\"X-Radiko-User: dummy_user\" " . "--header=\"X-Radiko-Device: pc\" " . "--header=\"X-Radiko-AuthToken: %s\" " . "--header=\"X-Radiko-PartialKey: %s\" " . "--no-check-certificate "; $header1hlsx = "-q  " . "--header=\"pragma: no-cache\" " . "--header=\"X-Radiko-App: %s\" " . "--header=\"X-Radiko-App-Version: %s\" " . "--header=\"X-Radiko-User: %s\" " . "--header=\"X-Radiko-Device: %s\" " . "--no-check-certificate " . "--save-headers "; $header2hlsx = "-q " . "--header=\"pragma: no-cache\" " . "--header=\"X-Radiko-App: %s\" " . "--header=\"X-Radiko-App-Version: %s\" " . "--header=\"X-Radiko-User: %s\" " . "--header=\"X-Radiko-Device: %s\" " . "--header=\"X-Radiko-AuthToken: %s\" " . "--header=\"X-Radiko-PartialKey: %s\" " . "--no-check-certificate "; $header1hlsg = "-q " . "--header=\"pragma: no-cache\" " . "--header=\"X-Radiko-App: %s\" " . "--header=\"X-Radiko-App-Version: %s\" " . "--header=\"X-Radiko-User: %s\" " . "--header=\"X-Radiko-Device: %s\" " . "--no-check-certificate " . "--save-headers "; $header2hlsg = "-q " . "--header=\"pragma: no-cache\" " . "--header=\"X-Radiko-App: %s\" " . "--header=\"X-Radiko-App-Version: %s\" " . "--header=\"X-Radiko-User: %s\" " . "--header=\"X-Radiko-Device: %s\" " . "--header=\"X-Radiko-Connection: %s\" " . "--header=\"X-Radiko-AuthToken: %s\" " . "--header=\"X-Radiko-Location: %s\" " . "--header=\"X-Radiko-PartialKey: %s\" " . "--no-check-certificate " . "--save-headers "; $login_url = "https://radiko.jp/v4/api/member/login"; $logout_url = "https://radiko.jp/v4/api/member/logout"; $logincheck_url = "https://radiko.jp/ap/member/webapi/member/login/check"; $opt_login = "-q " . " --keep-session-cookies"; $opt_logout = "-q " . " --header=\"pragma: no-cache\"" . " --header=\"Cache-Control: no-cache\"" . " --header=\"Expires: Thu, 01 Jan 1970 00:00:00 GMT\"" . " --header=\"Accept-Language: ja-jp\"" . " --header=\"Accept-Encoding: gzip, deflate\"" . " --header=\"Accept: application/json, text/javascript, */*; q=0.01\"" . " --header=\"X-Requested-With: XMLHttpRequest\"" . " --no-check-certificate"; $opt_logincheck = "-q " . " --no-check-certificate"; $radiko_nhk = array("JOAK","JOAB","JOAK-FM","JOHK","JOCK","JOBK","JOIK","JOFK","JOZK","JOLK"); $radiko_nhk_r1 = array("JOAK","JOHK","JOCK","JOBK","JOIK","JOFK","JOZK","JOLK"); $radiko_nhk_fm = "JOAK-FM"; $radiru_host = "nhk.or.jp"; $radiru_callsign_r1 = array( "tokyo" => "JOAK", "sendai" => "JOHK", "nagoya" => "JOCK", "osaka" => "JOBK", "sapporo" => "JOIK", "hiroshima" => "JOFK", "matsuyama" => "JOZK", "fukuoka" => "JOLK" ); $radiru_callsign_r2 = "JOAB"; $radiru_callsign_fm = "-FM"; $radiru_region = array( "tokyo", "sendai", "nagoya", "osaka", "sapporo", "hiroshima", "matsuyama", "fukuoka" ); $radiru_r1 = "r1"; $radiru_r2 = "r2"; $radiru_r3 = "r3"; $radiru_ch = array($radiru_r1,$radiru_r2,$radiru_r3); $radiru_ch_2 = array($radiru_r1,$radiru_r3); $radiru_base_img = "http://www.nhk.or.jp/prog/img/"; $station_logo_url = 'https://radiko.jp/v2/static/station/logo/%1$s/224x100.png'; $radiru_prog_url = "http://www.nhk.or.jp/hensei/api/sche.cgi?c=4&mode=xml"; $radiru_prog_url_json = "http://api.nhk.or.jp/r5/pg2/list/4/"; $radiru_now_url_json = "http://api.nhk.or.jp/r5/pg2/now/4/"; $radiru_configurl = "https://www.nhk.or.jp/radio/config/config_web.xml"; $radiru_vod_url = "https://www.nhk.or.jp/radio-api/app/v1/web/ondemand/corners/new_arrivals"; $radiru_vod_url_datelist = "https://www.nhk.or.jp/radio-api/app/v1/web/ondemand/corners/onair_dates"; $radiru_vod_url_date = "https://www.nhk.or.jp/radio-api/app/v1/web/ondemand/corners?onair_date="; $radiru_vod_url_series = "https://www.nhk.or.jp/radio-api/app/v1/web/ondemand/series?"; $radiru_gogaku_url = "https://www.nhk.or.jp/gogaku/"; $radiru_gogaku_url_s = "https://www.nhk.or.jp"; $nict_url = "https://ntp-a1.nict.go.jp/cgi-bin/json"; $crontab_template = array( "# rfriends crontab template (2023/06/24)".PHP_EOL, "#".PHP_EOL, "#SHELL=/bin/sh".PHP_EOL, "#PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin".PHP_EOL, "BASE_DIR=$base0".PHP_EOL, "# m h  dom mon dow   command".PHP_EOL, "#".PHP_EOL, "$sch_daily_m $sch_daily_h * * * sh ".'$BASE_DIR'."/script/ex_rfriends.sh".PHP_EOL ); $crontab_template2 = array( "# second job".PHP_EOL, "#".PHP_EOL, "$sch_daily_m2 $sch_daily_h2 * * * sh ".'$BASE_DIR'."/script/ex_rfriends.sh".PHP_EOL ); $launchdir = getenv("HOME")."/Library/LaunchAgents/"; $launchuser = ""; $launch_at_head = "local.rfriends.at"; $launch_crontab_head = "local.rfriends.crontab"; $launch_crontab_template = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
    <key>Label</key>
    <string>%s</string>
    <key>StartCalendarInterval</key>
    <dict>
    <key>Hour</key>
    <integer>%s</integer>
    <key>Minute</key>
    <integer>%s</integer>
    </dict>
    <key>KeepAlive</key>
        <false/>
    <key>ProgramArguments</key>
    <array>
        <string>/bin/sh</string>
        <string>%s</string>
    </array>
</dict>
</plist>
EOF;
$launch_crontab_template2 = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
    <key>Label</key>
    <string>%s</string>
    <key>StartCalendarInterval</key>
    <array>
    <dict>
    <key>Hour</key>
    <integer>%s</integer>
    <key>Minute</key>
    <integer>%s</integer>
    </dict>
    <dict>
    <key>Hour</key>
    <integer>%s</integer>
    <key>Minute</key>
    <integer>%s</integer>
    </dict>
    </array>
    <key>KeepAlive</key>
        <false/>
    <key>ProgramArguments</key>
    <array>
        <string>/bin/sh</string>
        <string>%s</string>
    </array>
</dict>
</plist>
EOF;
$launch_at_template = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
    <key>Label</key>
    <string>%s</string>
    <key>StartCalendarInterval</key>
    <dict>
    <key>Month</key>
    <integer>%s</integer>
    <key>Day</key>
    <integer>%s</integer>
    <key>Hour</key>
    <integer>%s</integer>
    <key>Minute</key>
    <integer>%s</integer>
    </dict>
    <key>KeepAlive</key>
        <false/>
    <key>LaunchOnlyOnce</key>
        <true/>
    <key>ProgramArguments</key>
    <array>
        <string>%s</string>
        <string>%s</string>
        <string>%s</string>
        <string>%s</string>
    </array>
</dict>
</plist>
EOF;
$pid_ex_win = "wmic process where \"Name LIKE '%ffmpeg.exe%'\" get /format:csv 2>nul"; $pid_ex_win_p = "wmic process where \"Name LIKE '%ffplay.exe%'\" get /format:csv 2>nul"; $pid_ex_win_sleep = "wmic process where \"Name LIKE '%php.exe%'\" | findstr rfriends_dontsleep 2>nul"; $pid_dlm_win = ","; $pid_start_win = "Node"; $pid_cline_win = "CommandLine"; $pid_pid_win = "ProcessId"; $pid_cdate_win = "CreationDate"; $pid_ex_linux = "ps -ef"; $pid_dlm_linux = " "; $pid_start_linux = "UID"; $pid_cline_linux = "CMD"; $pid_pid_linux = "PID"; $pid_cdate_linux = "STIME"; $pref_code = array( 1 => "北海道", 2 => "青森県", 3 => "岩手県", 4 => "宮城県", 5 => "秋田県", 6 => "山形県", 7 => "福島県", 8 => "茨城県", 9 => "栃木県", 10 => "群馬県", 11 => "埼玉県", 12 => "千葉県", 13 => "東京都", 14 => "神奈川県", 15 => "新潟県", 16 => "富山県", 17 => "石川県", 18 => "福井県", 19 => "山梨県", 20 => "長野県", 21 => "岐阜県", 22 => "静岡県", 23 => "愛知県", 24 => "三重県", 25 => "滋賀県", 26 => "京都府", 27 => "大阪府", 28 => "兵庫県", 29 => "奈良県", 30 => "和歌山県", 31 => "鳥取県", 32 => "島根県", 33 => "岡山県", 34 => "広島県", 35 => "山口県", 36 => "徳島県", 37 => "香川県", 38 => "愛媛県", 39 => "高知県", 40 => "福岡県", 41 => "佐賀県", 42 => "長崎県", 43 => "熊本県", 44 => "大分県", 45 => "宮崎県", 46 => "鹿児島県", 47 => "沖縄県"); $pref_url = "https://mreversegeocoder.gsi.go.jp/reverse-geocoder/LonLatToAddress"; $pref_url2 = "https://nominatim.openstreetmap.org/reverse"; $gdrive_url = "https://github.com/gdrive-org/gdrive/releases/download/2.1.0/"; $line_url = "https://notify-api.line.me/api/notify"; $line_auth = "--header \"Authorization: Bearer $send_mail_line_token\""; $ffmpeg_buf_radiko = 0; $ffmpeg_buf_radiru = 0; $ffmpeg_buf_timefree = 0; $ffmpeg_buf_radiru_vod = 0; $ffmpeg_buf_radiru_gogaku = 0; $ffmpeg_loglevel = "info"; $ffmpeg_loglevel_timefree = "fatal"; $ffmpeg_tag_opt = "-loglevel error -movflags +faststart  -acodec copy -vcodec copy  -id3v2_version 3 "; $http_seekable = "-http_seekable 0"; $ffmpeg_re = "-re"; $ffmpeg_useropt = " -reconnect 1  -reconnect_streamed 1 -reconnect_delay_max 120 -nostdin"; $ffplay_useropt = " -nodisp -autoexit -loglevel warning"; $ffmpeg_radiko_opt_win = " $ffmpeg_re" . ' -headers "X-Radiko-AuthToken:%4$s"' . ' -vn' . ' -i "%1$s"' . ' -t %3$s' . ' -movflags +faststart' . ' -metadata encoder="radiko" ' . ' -bsf:a aac_adtstoasc' . ' -acodec copy' . ' -y'; $ffmpeg_radiru_opt_win = " $ffmpeg_re" . ' -vn' . ' -i "%1$s"' . ' -t %3$s' . ' -movflags +faststart' . ' -metadata encoder="radiru" ' . ' -bsf:a aac_adtstoasc' . ' -acodec copy' . ' -y'; $ffmpeg_radiru_vod_opt_win = " $http_seekable" . ' -vn' . ' -i "%1$s"' . ' -movflags +faststart' . ' -metadata encoder="radiru_vod" ' . ' -bsf:a aac_adtstoasc' . ' -acodec copy' . ' -y'; $ffmpeg_radiru_gogaku_opt_win = " $http_seekable" . ' -vn' . ' -i "%1$s"' . ' -movflags +faststart' . ' -metadata encoder="radiru_vod" ' . ' -bsf:a aac_adtstoasc' . ' -acodec copy' . ' -y'; $ffmpeg_timefree_opt_win = ' -headers "X-Radiko-AuthToken:%4$s"' . ' -vn' . ' -i "%1$s"' . ' -t %3$s' . ' -movflags +faststart' . ' -metadata encoder="timefree" ' . ' -bsf:a aac_adtstoasc' . ' -acodec copy' . ' -y'; $ffmpeg_radiko_opt_lnx = " $ffmpeg_re" . ' -headers "X-Radiko-AuthToken:%4$s"' . ' -vn' . ' -i "%1$s"' . ' -t %3$s' . ' -movflags +faststart' . ' -metadata encoder="radiko" ' . ' -bsf:a aac_adtstoasc' . ' -acodec copy' . ' -y'; $ffmpeg_radiru_opt_lnx = " $ffmpeg_re" . ' -vn' . ' -i "%1$s"' . ' -t %3$s' . ' -movflags +faststart' . ' -metadata encoder="radiru" ' . ' -bsf:a aac_adtstoasc' . ' -acodec copy' . ' -y'; $ffmpeg_radiru_vod_opt_lnx = " $http_seekable" . ' -vn' . ' -i "%1$s"' . ' -movflags +faststart' . ' -metadata encoder="radiru_vod" ' . ' -bsf:a aac_adtstoasc' . ' -acodec copy' . ' -y'; $ffmpeg_radiru_gogaku_opt_lnx = " $http_seekable" . ' -vn' . ' -i "%1$s"' . ' -movflags +faststart' . ' -metadata encoder="radiru_vod" ' . ' -bsf:a aac_adtstoasc' . ' -acodec copy' . ' -y'; $ffmpeg_timefree_opt_lnx = ' -headers "X-Radiko-AuthToken:%4$s"' . ' -vn' . ' -i "%1$s"' . ' -t %3$s' . ' -movflags +faststart' . ' -metadata encoder="timefree" ' . ' -bsf:a aac_adtstoasc' . ' -acodec copy' . ' -y'; $default_editor_cui_win = $bindir.'nano'; $default_editor_gui_win = $bindir.'terapad'; $default_snd_player_win = 'wmplayer'; $default_editor_cui_osx = 'nano'; $default_editor_gui_osx = 'TextEdit.app'; $default_snd_player_osx = 'quicktime player.app'; $default_editor_cui_lnx = 'nano'; $default_editor_gui_lnx = 'gedit'; $default_snd_player_lnx = 'totem'; $default_headless_browser_win_app = 'chrome.exe'; $default_headless_browser_osx_app = 'chromium'; $default_headless_browser_lnx_app = 'chromium-browser'; $default_headless_browser_win_opt = '--headless' . ' --no-sandbox --disable-gpu --disable-software-rasterizer --disable-dev-shm-usage' . ' --disable-extensions --window-size=640,480' . ' --dump-dom'; $default_headless_browser_osx_opt = '--headless' . ' --no-sandbox --disable-gpu --disable-software-rasterizer --disable-dev-shm-usage' . ' --disable-extensions --window-size=640,480' . ' --dump-dom'; $default_headless_browser_lnx_opt = '--headless' . ' --no-sandbox --disable-gpu --disable-software-rasterizer --disable-dev-shm-usage' . ' --disable-extensions --window-size=640,480' . ' --dump-dom'; $debug_fin = 0; 