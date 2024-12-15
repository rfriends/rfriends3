<?php
 $path = $_SERVER["SCRIPT_FILENAME"]; if(preg_match("/\.html$/", $path)){ chdir(dirname($path)); return require($path); } return false; 