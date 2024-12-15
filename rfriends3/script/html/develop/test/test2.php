<?php
 $cs1 = $_GET['cs1']; $cs2 = $_GET['cs2']; $ty1 = $_GET['ty1']; $cs1a = $cs1."add1_".$ty1; $cs2a = $cs2."add2_".$ty1; $data = array(); $data['form']['cs1'] = $cs1a; $data['form']['cs2'] = $cs2a; $json = json_encode($data); echo $json; exit; ?>
