#!/usr/bin/php
<?php

/*
 * Usage:
 *      ods2csv.php uno.ods#mappe
 * 
 * Deve essere abilitato in php.ini
 * extension=zip.so
 * 
 */

include_once('spreadsheet-reader/SpreadsheetReader.php');
require_once(__DIR__ . '/lib/csv_gd.class.php');

function ods_to_array($filename, $sheet_name = 0) {
// extract values from an ods file to an array
// using SpreadsheetReader.php
    $out = array();


    $Spreadsheet = new SpreadsheetReader($filename);
    $Sheets = $Spreadsheet->Sheets();

    $sheet_index = array_search($sheet_name, $Sheets);

    $Spreadsheet->ChangeSheet($sheet_index);
  
    foreach ($Spreadsheet as $Row) {
      
        $out[] = $Row;
    }


    return associate_first_row($out);
}

function associate_first_row($array_in) {
//	return an array with the keys taken from the first row
    $out = array();
    $ident = array_shift($array_in);
    foreach ($array_in as $key_r => $row) {
        foreach ($row as $key_c => $cell) {
            $out[$key_r][$ident[$key_c]] = $cell;
        }
    }
    return $out;
}

function load_from_source($quiz_filename, $quiz_sheet = "") {
//load data from a source file

    if (!file_exists($quiz_filename)) {
        die("Source file -$quiz_filename- not found");
    }

    $ext = pathinfo($quiz_filename, PATHINFO_EXTENSION);
    if (strtoupper($ext) == "CSV") {
// is a 
        $data_quiz_src = $this->csv_to_array($quiz_filename);
    } elseif (strtoupper($ext) == "ODS") {

        $data_quiz_src = ods_to_array($quiz_filename, $quiz_sheet);
    } elseif (strtoupper($ext) == "SQLITE") {
        $quiz_name = isset($file_data[1]) ? $file_data[1] : "";
        //    $data_quiz_src = sqlite_to_array($quiz_filename, $quiz_name);
    } else {
        die("$quiz_name: Unkown format");
    }

    return $data_quiz_src;
}

// ------------------------------------   MAIN ------------------------------


$file_data = explode("#", $argv[1]);
$quiz_filename = $file_data[0];
$quiz_sheet = isset($file_data[1]) ? $file_data[1] : "";
$a_in = load_from_source($quiz_filename,$quiz_sheet);


$output_file = substr($quiz_filename, 0, -4).'-' .$quiz_sheet. '.csv';
$csv_file = new csv_gd($output_file);

// output only selected keys
$output_keys = array(
    'id',
    'question',
    'correct_answer',
    'wrong_answer',
    'difficult_level',
    'response_type',
    'if_correct',
    'if_wrong',
    'tags'
);

$index = 0;


foreach ($a_in as $single_quiz) {
    $out[$index] = array();
    foreach ($output_keys as $single_key) {
        $out[$index][$single_key] = isset($single_quiz[$single_key]) ? $single_quiz[$single_key] : "";
    }

    $index++;
}

$csv_file->array_to_csv($out);






