<?php
$port = fopen("COM3", "w");
fwrite($port, "1");
fclose($port);
?>