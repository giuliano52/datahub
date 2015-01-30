#!/usr/bin/php
<?php

/*
 * Usage:
 *      ods2csv-image-quiz.php uno.ods#mappe
 * come ods2csv.php solo che genera il campo 'question' a partire dalle immagini in img1 img2 img3 img4 img5 ...
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
$image_tags_DELETE = array(
	'img1',
	'img2',
	'img3',
	'img4',
	'img5',
);

$index = 0;





foreach ($a_in as $single_quiz) {

	$out[$index] = array();
	
	// riempio i altri campi dal file odt
	foreach ($output_keys as $single_key) {
        $out[$index][$single_key] = isset($single_quiz[$single_key]) ? $single_quiz[$single_key] : "";
    }
	
    	
	// genero la domanda in base alle colonne img riempite
	
	if(isset($single_quiz['img1']) && !empty($single_quiz['img1'])) {
		// se sono presenti le immagini svuoto il campo 'question' perché viene riempito dopo nel ciclo for
		$out[$index]['question'] = '' ;
	}
	
	for ($i=1;$i<10;$i++) {
		$nome_colonna = 'img'.$i;
		if(isset($single_quiz[$nome_colonna]) && !empty($single_quiz[$nome_colonna])) {
			$out[$index]['question'] .= isset($single_quiz['question'])? $single_quiz['question'].'<br>' : '';
			$out[$index]['question'] .= '<img src="'.$single_quiz[$nome_colonna].'" height="300">';
			// se è impostato il campo 'caption' inserisco la didascalia
			if(isset($single_quiz['caption'])) {
				$out[$index]['question'] .= '<div style="text-align: center;">'.$single_quiz['caption'].'</div>';
				}
		$out[$index]['question'] .= '|';
		}
			
		
		
	}

    

	
    $index++;
}

$csv_file->array_to_csv($out);






