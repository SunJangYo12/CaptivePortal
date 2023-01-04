<?php

function xreadFile($src) {
    $_data = fopen($src, "r") or die("Gagal membuka file!");
    $data = fread($_data, filesize($src));
    fclose($_data);

    return $data;
}

function xwriteFile($src, $data) {
    $_data = fopen($src, "a");
    fwrite($_data, $data."\n");
    fclose($_data);
}

xwriteFile("/var/www/html/result.txt", $_POST['key1']);

echo "<h3>Please wait...</h3>";

?>
