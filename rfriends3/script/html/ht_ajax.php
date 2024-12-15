<?php
 function ht_rec_kwsrc($ttl,$multi,$ex_type,$val,$val2) { $range = rfmenu_rec_kwsrc_range($ex_type,$val2); $dt = $range[0]; $cnt = $range[1]; $rmax = $range[2]; if ($cnt > 0) { $cnt2 = $cnt - 1; $d_en = strtotime("$cnt2 day", $dt); $fmt1 = rfmenu_rec_date_fmt2($dt); $fmt2 = rfmenu_rec_date_fmt2($d_en); if ($rmax == 0) { echo_msg(2,"検索範囲　 : $fmt1 - $fmt2 (max : 無制限)"); } else { echo_msg(2,"検索範囲　 : $fmt1 - $fmt2 (max : $rmax)"); } } echo_msg(2,"キーワード : '$val'"); echo_msg(2,""); ht_ajax_sub(1,"rec_kwsrc",$ttl,$multi,$ex_type,$val,$val2); } function ht_audee_detail($ttl,$multi,$url,$st,$en) { global $ht_jump_btn2; global $ht_jump_btn3; global $ht_jump_btn1_label; global $ht_jump_btn2_label; global $ht_jump_btn3_label; $ht_jump_btn2 = 1; $ht_jump_btn3 = 1; $ht_jump_btn1_label = "録音"; $ht_jump_btn2_label = "聴取"; $ht_jump_btn3_label = "聴取(サーバ)"; ht_ajax_sub(1,"audee_detail",$ttl,$multi,$url,$st,$en); } function ht_audee_src($ttl,$multi,$home,$kw) { global $ht_jump_btn2; global $ht_jump_btn1_label; global $ht_jump_btn2_label; ht_ajax_sub(1,"audee_src",$ttl,$multi,$home,$kw,1); } function ht_audee_src_url($ttl,$multi,$url,$q,$mode) { global $ht_jump_btn2; global $ht_jump_btn1_label; global $ht_jump_btn2_label; echo_msg(2,""); $q2 = urlencode($q); ht_ajax_sub(1,"audee_src_url",$ttl,$multi,$url,$q2,$mode); } function ht_audee_keylist($ttl,$multi,$url,$key) { global $ht_jump_btn2; global $ht_jump_btn1_label; global $ht_jump_btn2_label; ht_ajax_sub(1,"audee_keylist",$ttl,$multi,$url,$key,0); } function ht_update($ttl,$multi,$para1,$para2,$para3) { ht_ajax_sub(2,"update",$ttl,$multi,$para1,$para2,$para3); } function ht_pcast_rss_lfr($ttl,$multi,$url,$home) { ht_ajax_sub(1,"pcast_rss_lfr",$ttl,$multi,$url,$home,0); } function ht_radiko_program($ttl,$multi,$ch, $dt, $cnt) { ht_ajax_sub(1,"radiko_program",$ttl,$multi,$ch, $dt, $cnt); } function ht_google_top($ttl,$multi,$url) { ht_ajax_sub(1,"google_top",$ttl,$multi,$url,0,0); } function ht_audee_page($ttl,$multi,$url,$pgm) { ht_ajax_sub(1,"audee_page",$ttl,$multi,$url,$pgm,0); } function ht_ajax_sub($subtype,$func,$ttl,$multi,$para1,$para2,$para3) { global $ht_jump_addr; global $ht_jump_no; global $ht_jump_val; global $ht_jump_val2; global $ht_jump_val3; global $ht_jump_confirm; global $ht_jump_ret; global $ht_jump_reset; global $sno; global $ht_jump_btn1; global $ht_jump_btn1_label; global $ht_jump_btn2; global $ht_jump_btn2_label; global $ht_jump_btn3; global $ht_jump_btn3_label; global $svcmode; if ($multi == 0) { $mtd = "get"; $mlt = ""; $v = 'val'; $micon = ''; } else { $mtd = "post"; $mlt = "multiple"; $v = 'val[]'; $micon = '<img src="/images/multi.png" height ="20" width="20" align=top />&nbsp;'; } if ($svcmode["service_ajax"] == 1) { ht_ajax_sub_test($subtype,$func,$ttl,$multi,$para1,$para2,$para3); return; } echo <<<EOM1
<div class="ht_ajax_sub01_div1">
<div class="loading_circle"></div>
実行中、しばらくお待ちください。...
</div>

<div id="ht_ajax_sub01_div2"></div>

EOM1;
if ($subtype == 1) { echo <<<SEOM11
<form method=$mtd id='ht_ajax_sub01_form1' style="display:none" action='$ht_jump_addr'>
<select id="ht_ajax_sub01_select1" name=$v $mlt size=2 style="min-width:350px" onchange="chgval2(this)">
</select>
<p><br>
<button class='btn_ex' type='submit' name=sel value=1>$micon$ht_jump_btn1_label</button>
SEOM11;
if ($ht_jump_btn2 == 1) { echo "　"; echo "<button class='btn_ex' type='submit' name=sel value=2>$ht_jump_btn2_label</button>".PHP_EOL; } if ($ht_jump_btn3 == 1) { echo "　"; echo "<button class='btn_ex' type='submit' name=sel value=3>$ht_jump_btn3_label</button>".PHP_EOL; } echo <<<SEOM12
</p>
<INPUT type='hidden' name='subno' value='$ht_jump_no'>
<INPUT type='hidden' id='ht_ajax_val2' name='val2'  value='$ht_jump_val2'>
<INPUT type='hidden' name='sno' value='$sno'>
</p>
</form>
SEOM12;
} if ($subtype == 2 && $para1 == 1) { echo <<<SEOM21
<p>&nbsp;</p>
<form action='index.html' id='ht_ajax_sub01_form1' style="display:none" >
<p style='width:300px'>rfriendsのリスタートボタンを押してください。</p>
<p>&nbsp;</p>
<button class='btn_ex' type='submit'>リスタート</button>
</form>
SEOM21;
} if ($subtype == 3) { $para1= rawurlencode($para1); $ext = pathinfo($para1,PATHINFO_EXTENSION); echo <<<EOM31
<p><img id='sndimg'   src='$fnximg' style="display:none"></p>
<audio  id='audioimg' src='$fnx' type='audio/$ext' style="display:none" controls>
</audio>
EOM31;
} echo <<<EOM2

<script>
    $(function(){
        let dt1 = Date.now();
        $.ajax({
            url: "/ht_ajax_ex.php",
            type: 'POST',
            data: { "func" : "$func","title" : "$ttl","para1" : "$para1","para2" : "$para2" ,"para3" : "$para3"},
            dataType: 'json',
            timeout: 180000,
        }).done(function(data1){
            let dt2 = Date.now();
            $(".ht_ajax_sub01_div1").text("　");
            //$(".result3").html('<input type="button" onclick=test() value="yyy">　');
            // "json"を指定すると、JavaScriptオブジェクトを返す
            let dt3 = (dt2 - dt1)/1000;
            //console.log(dt3);
            //console.log(data1);
            let obj = data1;
            kwsel(obj,dt3);
            //$("#img1").remove();
        }).fail(function(jqXHR, textStatus, errorThrown){
            let dt2 = Date.now();
            let dt3 = (dt2 - dt1)/1000;
            $(".ht_ajax_sub01_div1").text("実行失敗。ステータス：" + jqXHR.status + " " + textStatus + " " + errorThrown.message + " " + dt3 + " sec");
        });
    });

function chgval2(obj) {
    const ajax_val2 = document.getElementById('ht_ajax_val2');
    var idx = obj.selectedIndex;
    var text  = obj.options[idx].text;  // 表示テキスト
    ajax_val2.value = text;
    //console.log(text);
}

function kwsel(obj,dt3) {
//const jsondata = JSON.stringify(obj);
var n = obj.length;
$(".ht_ajax_sub01_div1").text("$ttl (" + n + "件 " + dt3 +" sec)");

if (n < 1) {
    $(".ht_ajax_sub01_div1").text("結果が空です。");
    return;
}
if (n > 15) {
    n = 15;
}
EOM2;
if ($subtype == 1) { echo <<<SEOM13
const selectpgm = document.getElementById('ht_ajax_sub01_select1');

var i = 0;
obj.forEach((v) => {
  const option = document.createElement('option');
  option.value = v.val;
  option.textContent = " " + v.title + " ";
  if (v.val == "") option.disabled = true;
  if (v.val == "") option.textContent = "========== " + v.title + " ==========";
  selectpgm.appendChild(option);
  i++;
});
//if (n == 1) {
  const ajax_val2 = document.getElementById('ht_ajax_val2');
  var text = selectpgm.options[0].textContent;
  ajax_val2.value = text;
  //console.log(text);
//}
selectpgm.options[0].selected = true;
selectpgm.size = n;
SEOM13;
} if ($subtype == 2) { echo <<<SEOM22
const selectpgm = document.getElementById('ht_ajax_sub01_div2');
obj.forEach((v) => {
  const mes = document.createElement('p');
  mes.textContent = " " + v.title + " ";
  selectpgm.appendChild(mes);
});
SEOM22;
} if ($subtype == 1 || $subtype == 2) { echo <<<SEOM15
const exform = document.getElementById('ht_ajax_sub01_form1');
exform.style = "";
SEOM15;
} if ($subtype == 3) { echo <<<SEOM32
const exform1 = document.getElementById('sndimg');
const exform2 = document.getElementById('audioimg');
exform1.style = "";
exform2.style = "";
SEOM32;
} echo <<<EOM4
};
</script>
EOM4;
} function ht_ajax_sub_test($subtype,$func,$ttl,$multi,$para1,$para2,$para3) { global $ht_jump_addr; global $ht_jump_no; global $ht_jump_val; global $ht_jump_val2; global $ht_jump_confirm; global $ht_jump_ret; global $ht_jump_reset; global $ht_jump_btn1; global $ht_jump_btn1_label; global $ht_jump_btn2; global $ht_jump_btn2_label; echo_msg(2,"ボタンを押すと開始します。"); echo <<<EOM
<form method='post' action="ht_ajax_ex.php">
<button class='btn_ex' type='submit'>開始</button>
<INPUT type='hidden' name='func'   value="$func">
<INPUT type='hidden' name='title'  value="ttl">
<INPUT type='hidden' name='para1'  value="$para1">
<INPUT type='hidden' name='para2'  value="$para2">
<INPUT type='hidden' name='para3'  value="$para3">
</form>
EOM;
} 