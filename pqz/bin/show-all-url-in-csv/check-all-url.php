<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo "Inizio";
 
 
$filename = '../../conf/congratulation-frozen-2.csv';

require_once('../../../../phphub/lib/csv_gd.class.php');
require_once('../../../../phphub/lib/common.lib.php');



$csv_file = new csv_gd($filename);
$a_csv = $csv_file->csv_to_array();



foreach($a_csv as $field) {
    echo "<div style=\"border: 1px solid black\">";
    $url = $field['url'];
    echo "$url<br>";
    echo "<img src=\"$url\" width=\"150\" ><br>";
    echo "</div>";
}

