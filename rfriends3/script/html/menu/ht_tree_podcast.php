<?php
 echo <<<EOM
<form method="GET" action="menu_s.html">
<ul class="ht-tree">
<li>podcast ($pcastdir)

<ul>
  <li><input type="submit" name=val value="user">(プリセット)</>
  <li><input type="submit" name=val value="google"></>
  <li><input type="submit" name=val value="audee"></>
  <li><input type="submit" name=val value="lfr">(ニッポン放送)</>
</ul>
</li>
</ul>
<input type='hidden' name=subno value="$ht_jump_no">
</form>
<br>
EOM;
?>
