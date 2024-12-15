<?php
 echo <<<EOM
<form method="GET" action="menu_s.html">
<ul class="ht-tree">
<li>usrdir ($usrdir)

<ul>
  <li><input type="submit" name=val value="radiko">
  <li><input type="submit" name=val value="timefree">
  <li><input type="submit" name=val value="radiru">
  <li><input type="submit" name=val value="radiru_vod">
  <li><input type="submit" name=val value="radiru_gogaku">
  <li><input type="submit" name=val value="podcast">
  <li><input type="submit" name=val value="log">
  <li><input type="submit" name=val value="kw">
</ul>
</li>
</ul>
<input type='hidden' name=subno value="$ht_jump_no">
</form>
<br>
EOM;
?>
