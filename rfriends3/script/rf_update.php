<?php
function rf_update() { global $base; global $etcdir; $dmy = "アップデート"; $chkfl = $base."_update"; if (!file_exists($chkfl)) { return; } fin_unlink($chkfl); } 