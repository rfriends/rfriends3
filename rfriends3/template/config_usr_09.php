<?php
// -----------------------------------------------------------------
// rfriens設定ファイル
// 2017.10.21 by mapi
// 2020.03.24 by mapi 05
// 2020.06.02 by mapi 07
// 2022.01.26 by mapi 08
// =================================================================
// 以下は修正の必要はありません。
// アップデート時に新しいデータで上書きされます。
$product_name = "rfriends";
// =================================================================
// エラー
// =================================================================
//エラーを画面に表示する(1:on)
$rf_display_errors  = 1;
//エラーの種類(all)
$rf_error_reporting = E_ALL;
//エラーをログに出力する。(1:on)
$rf_log_errors      = 1;
// =================================================================
// シンボリックリンク
// =================================================================
$link_flg = 1; 
// =================================================================
// 変数
// =================================================================
// hungup check
//
$ds_retry_max = 10;
$ds_debug = 0;
// =================================================================
// Radiko
// =================================================================
$ext_const1 = "radiko";
//番組表リトライ回数
$prog_retry = 5;
//接続待ち時間
$prog_wait = 10;
//番組表リトライ回数
$radiko_prog_retry = 5;
//接続待ち時間
$radiko_prog_wait = 2;
// 一日の始まりの時間
$radiko_timeofbegin = 5;
// -------------------------------------
$prog_ext_mode = "rec";
$prog_ext_type = "with";
// -------------------------------------
//廃止2020/05/30
// 強制エリア設定 ON:1 OFF:0 ISO 3166-2:JP (JP1-JP9,JP11-JP47)
//$f_flag = 0;
//$f_area = "JP1";
// -------------------------------------
// 番組一覧
$radiko_today_disp_offset = 0;
$radiko_today_disp_dur = 24 * 60 * 60;
// -----------------------------------------------
// auth の維持時間　=0 で毎回取得
$auth_life_time  = 3600;
$auth_life_time2 = 300;
$auth_life_time3 = 300;
// =================================================================
// Radiru
// =================================================================
$ext_const2 = "radiru";
//番組表リトライ回数
$radiru_prog_retry = 5;
//接続待ち時間
$radiru_prog_wait = 2;
// 一日の始まりの時間
$radiru_timeofbegin = 5;
// -------------------------------------
// 番組一覧
$radiru_today_disp_offset = 0;
$radiru_today_disp_dur = 24 * 60 * 60;
// =================================================================
// Timefree
// =================================================================
// Timefree
// 二重録音スキップ skip:1 rec:0
// すでに録音済みの場合はスキップする
// -------------------------------------
// 廃止　2.6.3g 以降
//$doublerec_skip = 1;

// timefree ダウンロード時のタイムアウトレート、余裕
$tout_rate = 4;
$tout_allow = 120;
// -------------------------------------
// timefree の前後の余裕 sec
$timefree_pre_margin = 0;
$timefree_post_margin = 0;
// -------------------------------------
// timefree の1録音ごとの休み
$timefree_wait = 5;
// =================================================================
// Misc
// =================================================================
// radiru_vod の1録音ごとの休み
$radiru_vod_wait = 5;
// -------------------------------------
// premium login 有効期間（時間）
$premium_lifetime = 4;
// =================================================================
// Common
// =================================================================
$ext_const0 = "common";
// 1:ON,0:0ff htmlからtagを除いて比較する
$strip_tags_flag = 1;
// 1:ON,0:0ff スペースを除いて比較する
$strip_space_flag = 1;
// 1:ON,0:0ff 大小文字の区別をしないで比較する
$stripos_flag = 1;
// 1:ON,0:0ff 番組情報テキストを出力する
$infotext_flag = 1;
// タグを付加する yes:1 no:0
$add_tag = 1;
// イメージタグを付加する　yes:1 no:0;
$add_img = 1;
//$add_img_app_win = "neroAacTag";
$add_img_app_win = "AtomicParsley";
$add_img_app_osx = "AtomicParsley";
$add_img_app_lnx = "AtomicParsley";
//$add_img_app_osx = "mp4tags";
//$add_img_app_lnx = "mp4tags";
// 予約データ　ソート　しない:0 日付順:1 タイトル順:2
$sort_flag = 1;
//
// 成功したらログを消す 消す:2 消す:1(.logのみ残す) 消さない:0
$del_log = 1;
// n日前のログを消す（>=3） 廃止(2020/04/18 -> rfriends.ini)
//$clean_log = 3;
// -------------------------------------
// 配信番組の種類によりファイル名の先頭に付加 (ヘッダ不要の場合、"”)
// -------------------------------------
// okヘッダ
//$ok_head = "_ok";
$ok_head = "";

// ngヘッダ
$ng_head = "_ng";

// timefree フッタ
//$tf_footer = "@timefree";
$tf_footer = "";
// -------------------------------------
// ファイル名　全角->半角変換  1:する,  0:しない
//
// PHPのconvert_kana 参照
// "a" は「全角」英数字を「半角」に変換
// "s" は「全角」スペースを「半角」に変換
// -------------------------------------
$convert_kana = 1;
$convert_kana_para ="as";
$rec_sleep_pgm  = "rfriends_rec_sleep.php";
$rec_pgm        = "rfriends_rec.php";
$rec_fin_pgm    = "rfriends_rec_fin.php";
// -------------------------------------
// マージン（通常、変更の必要なし）
// -------------------------------------
// 番組開始時間より早くプログラム開始 (0-10)分
//$standby_time = 5;   rfriends.ini に移動(2.7.3)
// 検索開始オフセット
//$s_mkoffs = 120;
$s_mkoffs = $standby_time*60 + 70;
//$s_mkoffs = $standby_time_m*60 + 10;
// 検索時間
$s_mkdur = 3600*2;
// 番組開始時間のゆらぎ（0-10秒）
$standby_time_flu = 2;
// -------------------------------------
// 番組開始から登録までの時間(sec)
$f_rmargin = 1*60;
// 番組開始から登録までの時間(sec)
$t_rmargin = 2*60;
// -------------------------------------
// 録音ログ ON:1 OFF:0
$log = 0;
// 実行時のメッセージ　0:none 1:mes 2:all
$debug = 1;
// データフォルダの空きが指定以下だと録音中止 MB
$space_min = 50;
// tmpフォルダの空きが指定以下だと録音中止 MB
$tmp_space_min = 50;
//
$ex_limit = 5;
// -------------------------------------
// 予約最大数
$rsv_max = 400;
$rsv_max_timefree = 1000;
// -------------------------------------
//$rtmpdump_log = "-q";
//$rtmpdump_timeout = 0;
// -------------------------------------
$sec_name = array(
'unknown',
'common',
'timefree',
'radiko',
'radiko_timerec',
'radiru',
'radiru_vod',
'radiru_gogaku',
'common_ng',
'timefree_ng',
'radiko_ng',
'radiru_ng',
'radiru_vod_ng',
'radiru_gogaku_ng',
'radiru_main_station',
'radiru_station',
'radiru_timerec',
'radiru_other_timerec',
'radiru_tokyo',
'radiru_sendai',
'radiru_nagoya',
'radiru_osaka',
'radiru_sapporo',
'radiru_hiroshima',
'radiru_matsuyama',
'radiru_fukuoka',
'premium_main_station',
'premium_station',
'double_program_radiko',
'double_program_radiru',
'double_program_timefree',
'double_program_radiru_vod',
'double_program_radiru_gogaku',
'target_program',
'exception_program'
);
// ---------------------------------------------
// auth

$auth_sleep = 15;
$auth_retry = 5;
// auth 1:hls,0:player
$auth_type = 0;
// ---------------------------------------------
// 0:(>=0) 1:(>=1) 2:(>=2)
$msg_level = 1;
$dlmt = ";";
$end_log = 0;
// ---------------------------------------------
$dontsleep_timer = 30;
$dontsleep_timer_tf = 10;

$fin_sleep = 5;
// ---------------------------------------------
$sch_life_time = 3600;
$cfg_life_time = 3600;
// ---------------------------------------------
$cleanlog_fn = "rfriends_cleanlog";
$cleanlog_time = 3600 * 8;

$rec_extension = "m4a";
$dwn_extension = "m4a";
// ---------------------------------------------
$prohibit_mp3 = 1;
// ---------------------------------------------
$multi_sw = 1;   /* 0:single 1:multi */
// =================================================================
// macos launch (0:/bin/sh 1:Automator)
// =================================================================
$macos_launch_type = 0;
// =================================================================
// 定数
// =================================================================
// ---------------------------------------------
// 0:正常終了　$rec_normal_end
//11:正常終了　$rec_normal_end_plus
// 1:録音済    $rec_already_exist
// 2:配信なし  $rec_not_deliver
// 3:異常終了  $rec_abnormal_end
$rec_normal_end     = 0;
$rec_already_exist  = 1;
$rec_not_deliver    = 2;
$rec_abnormal_end   = 3;

$rec_normal_end_plus = 11;
// ---------------------------------------------
// ログヘッダ
// ---------------------------------------------
$loghead_short    = "[SHT]";
$loghead_bad      = "[BAD]";
$loghead_cancel   = "[CAN]";
$loghead_delay    = "[DLY]";
$loghead_abnormal = "[ABN]";
$loghead_skip     = "[SKP]";
$loghead_error    = "[ERR]";
// ---------------------------------------------
// ファイル置き場
// 廃止                           ";
// =================
// Radiko
// =================
// 配信方法の選択
//$radiko_hls = 1;    // hls:1 old:0
// -------------------------------------
$hls_type = 0;
// -------------------------------------
// 2022/02/11 -> rfriends.ini
//  
//$hls_user   = "test_stream"	; X-Radiko-User
//$hls_app    = "pc_html5"	; X-Radiko-App ここを変更すると多分動作しません。
//$hls_appver = "5.0.2"		; X-Radiko-App-Version
//$hls_dev    = "pc"		; X-Radiko-Device

//X-Radiko-User
//$hls_user   = "dummy_user";
//
//X-Radiko-App
//ここを変更すると多分動作しません。
//$hls_app    = "pc_html5";
//
//X-Radiko-App-Version
//$hls_appver = "0.0.1";
//
//X-Radiko-Device
//$hls_dev    = "pc";
// ---------------------------------------------
// wget option　
//
// オプション(通常、変更は不要)
//$wget_opt          = "-q --inet4-only -t 5 --no-dns-cache";
//$wget_opt          = "-q -t 5";
// 認証時オプション
//$wget_opt_ext      = "-q --inet4-only -t 10 -T 5 --connect-timeout=5 --waitretry=5 --no-dns-cache";
//$wget_opt_ext      = "-q -t 10 -T 5 --connect-timeout=5 --waitretry=5";
// エージェント
//$wget_user_agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:61.0) Gecko/20100101 Firefox/61.0";
// ---------------------------------------------
// radikoホストアドレス
$radiko_host = "radiko.jp";
// イメージアドレス
//$radiko_base_img = "http://radiko.jp/res/program/DEFAULT_IMAGE/";
$radiko_base_img = "https://radiko.jp/res/program/DEFAULT_IMAGE/";
// 番組表アドレス
//$prog_url = "http://radiko.jp/v3/program/date/";
$prog_url = "https://radiko.jp/v3/program/date/";
//$radiko_prog_url = "http://radiko.jp/v3/program/date/";
$radiko_prog_url = "https://radiko.jp/v3/program/date/";

$playlisturl  = "https://radiko.jp/v2/api/ts/playlist.m3u8?l=15&station_id=";
$playlisturl2 = "https://tf-f-rpaa-radiko.smartstream.ne.jp/tf/playlist.m3u8?l=15&type=b&station_id=";
//$playerurl = "http://radiko.jp/apps/js/flash/myplayer-release.swf";
$playerurl = "https://radiko.jp/apps/js/flash/myplayer-release.swf";
//$streamurl = "http://radiko.jp/v2/station/stream/";
//$fms1url = "https://radiko.jp/v2/api/auth1_fms";
//$fms2url = "https://radiko.jp/v2/api/auth2_fms";

//$swf_offset = "12";
/*
$header1 = "-q "
    . "--header=\"pragma: no-cache\" "
    . "--header=\"X-Radiko-App: pc_ts\" "
    . "--header=\"X-Radiko-App-Version: 4.0.0\" "
    . "--header=\"X-Radiko-User: test-stream\" "
    . "--header=\"X-Radiko-Device: pc\" "
    . "--no-check-certificate "
    . "--save-headers "
    . "--post-data='\r\n'";

$header2 = "-q "
    . "--header=\"pragma: no-cache\" "
    . "--header=\"X-Radiko-App: pc_ts\" "
    . "--header=\"X-Radiko-App-Version: 4.0.0\" "
    . "--header=\"X-Radiko-User: test-stream\" "
    . "--header=\"X-Radiko-Device: pc\" "
    . "--header=\"X-Radiko-AuthToken: %s\" "
    . "--header=\"X-Radiko-PartialKey: %s\" "
    . "--no-check-certificate "
    . "--post-data='\r\n'";
*/
$m3u8header = " -q "
    . "--header=\"pragma: no-cache\" "
    . "--header=\"Content-Type: application/x-www-form-urlencoded\" "
    . "--header=\"Referer: $playerurl\" "
    . "--no-check-certificate "
    . "--post-data='flash=1' ";
// ------------------------------------- hls
//$streamurlhls = "http://radiko.jp/v2/station/stream_smh_multi/";
$streamurlhls = "https://radiko.jp/v2/station/stream_smh_multi/";
$fms1urlhls = "https://radiko.jp/v2/api/auth1";
$fms2urlhls = "https://radiko.jp/v2/api/auth2";

//$playercommon = "http://radiko.jp/apps/js/playerCommon.js";
$playercommon = "https://radiko.jp/apps/js/playerCommon.js";

$xheader = "X-Radiko";

$header1hls = "-q  "
    . "--header=\"pragma: no-cache\" "
    . "--header=\"X-Radiko-App: pc_html5\" "
    . "--header=\"X-Radiko-App-Version: 0.0.1\" "
    . "--header=\"X-Radiko-User: dummy_user\" "
    . "--header=\"X-Radiko-Device: pc\" "
    . "--no-check-certificate "
    . "--save-headers ";
//  . "--post-data='\r\n'";

$header2hls = "-q "
    . "--header=\"pragma: no-cache\" "
    . "--header=\"X-Radiko-App: pc_html5\" "
    . "--header=\"X-Radiko-App-Version: 0.0.1\" "
    . "--header=\"X-Radiko-User: dummy_user\" "
    . "--header=\"X-Radiko-Device: pc\" "
    . "--header=\"X-Radiko-AuthToken: %s\" "
    . "--header=\"X-Radiko-PartialKey: %s\" "
    . "--no-check-certificate ";
//  . "--post-data='\r\n'";

$header1hlsx = "-q  "
    . "--header=\"pragma: no-cache\" "
    . "--header=\"X-Radiko-App: %s\" "
    . "--header=\"X-Radiko-App-Version: %s\" "
    . "--header=\"X-Radiko-User: %s\" "
    . "--header=\"X-Radiko-Device: %s\" "
    . "--no-check-certificate "
    . "--save-headers ";
//  . "--post-data='\r\n'";

$header2hlsx = "-q "
    . "--header=\"pragma: no-cache\" "
    . "--header=\"X-Radiko-App: %s\" "
    . "--header=\"X-Radiko-App-Version: %s\" "
    . "--header=\"X-Radiko-User: %s\" "
    . "--header=\"X-Radiko-Device: %s\" "
    . "--header=\"X-Radiko-AuthToken: %s\" "
    . "--header=\"X-Radiko-PartialKey: %s\" "
    . "--no-check-certificate ";
//  . "--post-data='\r\n'";

$header1hlsg = "-q "
    . "--header=\"pragma: no-cache\" "

    . "--header=\"X-Radiko-App: %s\" "
    . "--header=\"X-Radiko-App-Version: %s\" "
    . "--header=\"X-Radiko-User: %s\" "
    . "--header=\"X-Radiko-Device: %s\" "

    . "--no-check-certificate "
    . "--save-headers ";

$header2hlsg = "-q "
    . "--header=\"pragma: no-cache\" "

    . "--header=\"X-Radiko-App: %s\" "
    . "--header=\"X-Radiko-App-Version: %s\" "
    . "--header=\"X-Radiko-User: %s\" "
    . "--header=\"X-Radiko-Device: %s\" "
    . "--header=\"X-Radiko-Connection: %s\" "

    . "--header=\"X-Radiko-AuthToken: %s\" "
    . "--header=\"X-Radiko-Location: %s\" "
    . "--header=\"X-Radiko-PartialKey: %s\" "

    . "--no-check-certificate "
    . "--save-headers ";
/*
$m3u8headerhls = "-q "
    . "--header=\"pragma: no-cache\" "
    . "--header=\"Content-Type: application/x-www-form-urlencoded\" "
    . "--header=\"Referer: $playerurl\" "
    . "--no-check-certificate "
    . "--post-data='flash=1' ";
*/
//$login_url  = "https://radiko.jp/ap/member/login/login";
// 2022/10/05
$login_url      = "https://radiko.jp/v4/api/member/login";
$logout_url     = "https://radiko.jp/v4/api/member/logout";
$logincheck_url = "https://radiko.jp/ap/member/webapi/member/login/check";

$opt_login = "-q "
    . " --keep-session-cookies";

$opt_logout = "-q "
    . " --header=\"pragma: no-cache\""
    . " --header=\"Cache-Control: no-cache\""
    . " --header=\"Expires: Thu, 01 Jan 1970 00:00:00 GMT\""
    . " --header=\"Accept-Language: ja-jp\""
    . " --header=\"Accept-Encoding: gzip, deflate\""
    . " --header=\"Accept: application/json, text/javascript, */*; q=0.01\""
    . " --header=\"X-Requested-With: XMLHttpRequest\""
    . " --no-check-certificate";

$opt_logincheck = "-q "
//  . " --header=\"pragma: no-cache\""
//  . " --header=\"Cache-Control: no-cache\""
//  . " --header=\"Expires: Thu, 01 Jan 1970 00:00:00 GMT\""
//  . " --header=\"Accept-Language: ja-jp\""
//  . " --header=\"Accept-Encoding: gzip, deflate\""
//  . " --header=\"Accept: application/json, text/javascript, */*; q=0.01\""
//  . " --header=\"X-Requested-With: XMLHttpRequest\""
    . " --no-check-certificate";
// =================
$radiko_nhk = array("JOAK","JOAB","JOAK-FM","JOHK","JOCK","JOBK","JOIK","JOFK","JOZK","JOLK");
$radiko_nhk_r1 = array("JOAK","JOHK","JOCK","JOBK","JOIK","JOFK","JOZK","JOLK");
$radiko_nhk_fm = "JOAK-FM";
// =================
// Radiru
// ココにあるcallsignはradiru_callsign.csvとは別に必須
// =================
// radiruホストアドレス
$radiru_host = "nhk.or.jp";
//
$radiru_callsign_r1 = array(
"tokyo"     => "JOAK",
"sendai"    => "JOHK",
"nagoya"    => "JOCK",
"osaka"     => "JOBK",
"sapporo"   => "JOIK",
"hiroshima" => "JOFK",
"matsuyama" => "JOZK",
"fukuoka"   => "JOLK"
);
$radiru_callsign_r2 = "JOAB";
$radiru_callsign_fm = "-FM";
// -------------------------------------
$radiru_region = array(
"tokyo",
"sendai",
"nagoya",
"osaka",
"sapporo",
"hiroshima",
"matsuyama",
"fukuoka"
);

$radiru_r1 = "r1";
$radiru_r2 = "r2";
$radiru_r3 = "r3";

$radiru_ch = array($radiru_r1,$radiru_r2,$radiru_r3);
$radiru_ch_2 = array($radiru_r1,$radiru_r3);
// -------------------------------------
// イメージアドレス
//$radiru_base_img = "http://www2.nhk.or.jp/prog/img/";
$radiru_base_img = "http://www.nhk.or.jp/prog/img/";
// station logo
//$station_logo_url = 'http://radiko.jp/v2/static/station/logo/%1$s/224x100.png';
$station_logo_url = 'https://radiko.jp/v2/static/station/logo/%1$s/224x100.png';
//
// 番組表アドレス
//$radiru_prog_url = "http://www2.nhk.or.jp/hensei/api/sche.cgi?c=4&mode=xml";
$radiru_prog_url = "http://www.nhk.or.jp/hensei/api/sche.cgi?c=4&mode=xml";
//
//$radiru_prog_url_json = "http://api.nhk.or.jp/r2/pg/list/4/";
//$radiru_now_url_json  = "http://api.nhk.or.jp/r2/pg/now/4/";
// 2022/12/05
$radiru_prog_url_json   = "http://api.nhk.or.jp/r5/pg2/list/4/";
// 2023/06/24
//$radiru_prog_url_json = "https://api.nhk.or.jp/v2/pg/list/";
//
$radiru_now_url_json  = "http://api.nhk.or.jp/r5/pg2/now/4/";
// -------------------------------------
//$radiru_configurl = "http://www.nhk.or.jp/radio/config/config_web.xml";
$radiru_configurl  = "https://www.nhk.or.jp/radio/config/config_web.xml";
// -------------------------------------
//$radiru_vod_url = "https://www.nhk.or.jp/radioondemand/json/index_v/index.json";
//$radiru_vod_url = "https://www.nhk.or.jp/radioondemand/json/index_v3/index.json";
// 2024/06/05
// 新着
$radiru_vod_url          = "https://www.nhk.or.jp/radio-api/app/v1/web/ondemand/corners/new_arrivals";
// 日付リスト
$radiru_vod_url_datelist = "https://www.nhk.or.jp/radio-api/app/v1/web/ondemand/corners/onair_dates";
// 日付指定
$radiru_vod_url_date     = "https://www.nhk.or.jp/radio-api/app/v1/web/ondemand/corners?onair_date=";
// シリーズ指定
//$radiru_vod_url_series   = "https://www.nhk.or.jp/radio-api/app/v1/web/ondemand/series?site_id=1257&corner_site_id=01";
$radiru_vod_url_series   = "https://www.nhk.or.jp/radio-api/app/v1/web/ondemand/series?";
// -------------------------------------
//$radiru_gogaku_url   = "https://www2.nhk.or.jp/gogaku/";
$radiru_gogaku_url   = "https://www.nhk.or.jp/gogaku/";
//$radiru_gogaku_url_s = "https://www2.nhk.or.jp";
$radiru_gogaku_url_s = "https://www.nhk.or.jp";
// =================
// Common
// =================
// nict
$nict_url = "https://ntp-a1.nict.go.jp/cgi-bin/json";
//
$crontab_template = array(
"# rfriends crontab template (2023/06/24)".PHP_EOL,
"#".PHP_EOL,
"#SHELL=/bin/sh".PHP_EOL,
"#PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin".PHP_EOL,
"BASE_DIR=$base0".PHP_EOL,
"# m h  dom mon dow   command".PHP_EOL,
"#".PHP_EOL,
"$sch_daily_m $sch_daily_h * * * sh ".'$BASE_DIR'."/script/ex_rfriends.sh".PHP_EOL
);
$crontab_template2 = array(
"# second job".PHP_EOL,
"#".PHP_EOL,
"$sch_daily_m2 $sch_daily_h2 * * * sh ".'$BASE_DIR'."/script/ex_rfriends.sh".PHP_EOL
);
// -------------------------------------
// osx
// -------------------------------------
$launchdir = getenv("HOME")."/Library/LaunchAgents/";   // for osx
$launchuser = "";   // for osx
$launch_at_head = "local.rfriends.at";
$launch_crontab_head = "local.rfriends.crontab";

$launch_crontab_template = <<<EOF
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
// -------------------------------------
// ffmpeg PID
// プロセス状況
// -------------------------------------
// windows
//
$pid_ex_win       = "wmic process where \"Name LIKE '%ffmpeg.exe%'\" get /format:csv 2>nul";
$pid_ex_win_p     = "wmic process where \"Name LIKE '%ffplay.exe%'\" get /format:csv 2>nul";
$pid_ex_win_sleep = "wmic process where \"Name LIKE '%php.exe%'\" | findstr rfriends_dontsleep 2>nul";
$pid_dlm_win = ",";
//  最初のカラム
$pid_start_win = "Node";

$pid_cline_win = "CommandLine";
$pid_pid_win    = "ProcessId";
$pid_cdate_win = "CreationDate";
// -------------------------------------
// linux (廃止、2019/10/15)
//
$pid_ex_linux = "ps -ef";
$pid_dlm_linux = " ";
//  最初のカラム
$pid_start_linux = "UID";

$pid_cline_linux = "CMD";
$pid_pid_linux  = "PID";
$pid_cdate_linux = "STIME";
// -------------------------------------
// 都道府県コード
// -------------------------------------
$pref_code = array(
1 => "北海道", 2 => "青森県", 3 => "岩手県", 4 => "宮城県", 5 => "秋田県",
6 => "山形県", 7 => "福島県", 8 => "茨城県", 9 => "栃木県", 10 => "群馬県",
11 => "埼玉県", 12 => "千葉県", 13 => "東京都", 14 => "神奈川県", 15 => "新潟県",
16 => "富山県", 17 => "石川県", 18 => "福井県", 19 => "山梨県", 20 => "長野県",
21 => "岐阜県", 22 => "静岡県", 23 => "愛知県", 24 => "三重県", 25 => "滋賀県",
26 => "京都府", 27 => "大阪府", 28 => "兵庫県", 29 => "奈良県", 30 => "和歌山県",
31 => "鳥取県", 32 => "島根県", 33 => "岡山県", 34 => "広島県", 35 => "山口県",
36 => "徳島県", 37 => "香川県", 38 => "愛媛県", 39 => "高知県", 40 => "福岡県",
41 => "佐賀県", 42 => "長崎県", 43 => "熊本県", 44 => "大分県", 45 => "宮崎県",
46 => "鹿児島県", 47 => "沖縄県");

//$pref_url = "https://aginfo.cgk.affrc.go.jp/ws/rgeocode.php";
// 2022/07/06
$pref_url  = "https://mreversegeocoder.gsi.go.jp/reverse-geocoder/LonLatToAddress";
$pref_url2 = "https://nominatim.openstreetmap.org/reverse";
// -------------------------------------
// //drive parameter
// -------------------------------------
$gdrive_url = "https://github.com/gdrive-org/gdrive/releases/download/2.1.0/";
// -------------------------------------
// line notify parameter
// -------------------------------------
$line_url  = "https://notify-api.line.me/api/notify";
$line_auth = "--header \"Authorization: Bearer $send_mail_line_token\"";
// -------------------------------------
// ffmpeg buffer parameter 単位M
// -------------------------------------
$ffmpeg_buf_radiko = 0;
$ffmpeg_buf_radiru = 0;
$ffmpeg_buf_timefree = 0;
$ffmpeg_buf_radiru_vod = 0;
$ffmpeg_buf_radiru_gogaku = 0;
// -------------------------------------
// ffmpeg parameter
// -------------------------------------
// 順番に注意：-headers,-iはこの順番で先頭に
// このパラメータの後に出力ファイル名が付加される
//
// %1 stream_url    配信アドレス
// %2 timeout       タイムアウト
// %3 duration      配信時間
// %4 AuthToken     トークン(radiko)
//
// -loglevel quiet ログなし
//
//  ' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
//  ' -reconnect_delay_max 120' .
//  ' -headers "X-Radiko-AuthToken:%4$s"'   トークン
//  ' -i %1$s'                          入力ファイル
//  ' -t %3$s'                          録音時間
//  //' -timelimit %2$s'                タイムリミット（有効？）
//  ' -movflags faststart'              ストリーミング
//  ' -metadata encoder="radiko" '      識別
//  ' -vn'                              映像出力なし
//  //' -bsf:a aac_adtstoasc' .
//  ' -acodec copy'                     コピー
//  ' -y'                               出力ファイルの上書き
//
$ffmpeg_loglevel = "info";
$ffmpeg_loglevel_timefree = "fatal";

$ffmpeg_tag_opt = "-loglevel error -movflags +faststart  -acodec copy -vcodec copy  -id3v2_version 3 ";

$http_seekable = "-http_seekable 0";
$ffmpeg_re = "-re";

// 2024/09/14 from rfriends.ini
//ffmpeg_useropt   = " -reconnect 1  -reconnect_streamed 1 -reconnect_delay_max 120";
//ffplay_useropt   = " -nodisp -autoexit -loglevel warning";
$ffmpeg_useropt   = " -reconnect 1  -reconnect_streamed 1 -reconnect_delay_max 120 -nostdin";
$ffplay_useropt   = " -nodisp -autoexit -loglevel warning";
// -------------------------------------
// windows
//
$ffmpeg_radiko_opt_win =
    //' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
    //' -reconnect 1  -reconnect_streamed 1' .
    //' -reconnect_delay_max 120' .
    " $ffmpeg_re" .
    ' -headers "X-Radiko-AuthToken:%4$s"' .
    ' -vn' .
    ' -i "%1$s"' .
    ' -t %3$s' .
    //' -timelimit %2$s' .
    ' -movflags +faststart' .
    ' -metadata encoder="radiko" ' .
    ' -bsf:a aac_adtstoasc' .
    ' -acodec copy' .
    ' -y';

$ffmpeg_radiru_opt_win =
    //' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
    //' -reconnect 1  -reconnect_streamed 1' .
    //' -reconnect_delay_max 120' .
    " $ffmpeg_re" .
    ' -vn' .
    ' -i "%1$s"' .
    ' -t %3$s' .
    //' -timelimit %2$s' .
    ' -movflags +faststart' .
    ' -metadata encoder="radiru" ' .
    ' -bsf:a aac_adtstoasc' .
    ' -acodec copy' .
    ' -y';

$ffmpeg_radiru_vod_opt_win =
    //' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
    //' -reconnect 1  -reconnect_streamed 1' .
    //' -reconnect_delay_max 120' .
    " $http_seekable" .
    ' -vn' .
    ' -i "%1$s"' .
    //' -t %3$s' .
    //' -timelimit %2$s' .
    ' -movflags +faststart' .
    ' -metadata encoder="radiru_vod" ' .
    ' -bsf:a aac_adtstoasc' .
    ' -acodec copy' .
    ' -y';

$ffmpeg_radiru_gogaku_opt_win =
    //' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
    //' -reconnect 1  -reconnect_streamed 1' .
    //' -reconnect_delay_max 120' .
    " $http_seekable" .
    ' -vn' .
    ' -i "%1$s"' .
    //' -t %3$s' .
    //' -timelimit %2$s' .
    ' -movflags +faststart' .
    ' -metadata encoder="radiru_vod" ' .
    ' -bsf:a aac_adtstoasc' .
    ' -acodec copy' .
    ' -y';

$ffmpeg_timefree_opt_win =
    //' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
    //' -reconnect 1  -reconnect_streamed 1' .
    //' -reconnect_delay_max 120' .
    ' -headers "X-Radiko-AuthToken:%4$s"' .
    ' -vn' .
    ' -i "%1$s"' .
    ' -t %3$s' .
    //' -timelimit %2$s' .
    ' -movflags +faststart' .
    ' -metadata encoder="timefree" ' .
    ' -bsf:a aac_adtstoasc' .
    ' -acodec copy' .
    ' -y';
/*
$ffmpeg_timefree_opt_win =
    ' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
    ' -reconnect_delay_max 120' .
    ' -i "%1$s"' .
    //' -timelimit %2$s' .
    ' -movflags faststart' .
    ' -metadata encoder="timefree" ' .
    ' -vn' .
    ' -bsf:a aac_adtstoasc' .
    ' -acodec copy' .
    ' -y';
*/
// -------------------------------------
// linux
//
$ffmpeg_radiko_opt_lnx =
    //' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
    //' -reconnect 1  -reconnect_streamed 1' .
    //' -reconnect_delay_max 120' .
    " $ffmpeg_re" .
    ' -headers "X-Radiko-AuthToken:%4$s"' .
    ' -vn' .
    ' -i "%1$s"' .
    ' -t %3$s' .
    //' -timelimit %2$s' .
    ' -movflags +faststart' .
    ' -metadata encoder="radiko" ' .
    ' -bsf:a aac_adtstoasc' .
    ' -acodec copy' .
    ' -y';

$ffmpeg_radiru_opt_lnx =
    //' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
    //' -reconnect 1  -reconnect_streamed 1' .
    //' -reconnect_delay_max 120' .
    " $ffmpeg_re" .
    ' -vn' .
    ' -i "%1$s"' .
    ' -t %3$s' .
    //' -timelimit %2$s' .
    ' -movflags +faststart' .
    ' -metadata encoder="radiru" ' .
    ' -bsf:a aac_adtstoasc' .
    ' -acodec copy' .
    ' -y';

$ffmpeg_radiru_vod_opt_lnx =
    //' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
    //' -reconnect 1  -reconnect_streamed 1' .
    //' -reconnect_delay_max 120' .
    " $http_seekable" .
    ' -vn' .
    ' -i "%1$s"' .
    //' -t %3$s' .
    //' -timelimit %2$s' .
    ' -movflags +faststart' .
    ' -metadata encoder="radiru_vod" ' .
    ' -bsf:a aac_adtstoasc' .
    ' -acodec copy' .
    ' -y';

$ffmpeg_radiru_gogaku_opt_lnx =
    //' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
    //' -reconnect 1  -reconnect_streamed 1' .
    //' -reconnect_delay_max 120' .
    " $http_seekable" .
    ' -vn' .
    ' -i "%1$s"' .
    //' -t %3$s' .
    //' -timelimit %2$s' .
    ' -movflags +faststart' .
    ' -metadata encoder="radiru_vod" ' .
    ' -bsf:a aac_adtstoasc' .
    ' -acodec copy' .
    ' -y';

$ffmpeg_timefree_opt_lnx =
    //' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
    //' -reconnect 1  -reconnect_streamed 1' .
    //' -reconnect_delay_max 120' .
    ' -headers "X-Radiko-AuthToken:%4$s"' .
    ' -vn' .
    ' -i "%1$s"' .
    ' -t %3$s' .
    //' -timelimit %2$s' .
    ' -movflags +faststart' .
    ' -metadata encoder="timefree" ' .
    ' -bsf:a aac_adtstoasc' .
    ' -acodec copy' .
    ' -y';
/*
$ffmpeg_timefree_opt_lnx =
    ' -reconnect 1 -reconnect_at_eof 1 -reconnect_streamed 1' .
    ' -reconnect_delay_max 120' .
    ' -i "%1$s"' .
    //' -timelimit %2$s' .
    ' -movflags faststart' .
    ' -metadata encoder="timefree" ' .
    ' -vn' .
    ' -bsf:a aac_adtstoasc' .
    ' -acodec copy' .
    ' -y';
*/

// =================================================================
// 標準プレーヤ
// =================================================================
$default_editor_cui_win = $bindir.'nano';
$default_editor_gui_win = $bindir.'terapad';
$default_snd_player_win = 'wmplayer';

$default_editor_cui_osx = 'nano';
$default_editor_gui_osx = 'TextEdit.app';
$default_snd_player_osx = 'quicktime player.app';

$default_editor_cui_lnx = 'nano';
$default_editor_gui_lnx = 'gedit';
$default_snd_player_lnx = 'totem';
// =================================================================
// headless browser
// =================================================================
$default_headless_browser_win_app = 'chrome.exe';
$default_headless_browser_osx_app = 'chromium';
$default_headless_browser_lnx_app = 'chromium-browser';

$default_headless_browser_win_opt = '--headless' .
  ' --no-sandbox --disable-gpu --disable-software-rasterizer --disable-dev-shm-usage' .
  ' --disable-extensions --window-size=640,480' .
  ' --dump-dom';

$default_headless_browser_osx_opt = '--headless' .
  ' --no-sandbox --disable-gpu --disable-software-rasterizer --disable-dev-shm-usage' .
  ' --disable-extensions --window-size=640,480' .
  ' --dump-dom';

$default_headless_browser_lnx_opt = '--headless' .
  ' --no-sandbox --disable-gpu --disable-software-rasterizer --disable-dev-shm-usage' .
  ' --disable-extensions --window-size=640,480' .
  ' --dump-dom';
// =================================================================
// debug
// =================================================================
$debug_fin = 0;
// =================================================================
