<?php

require_once "bootstrap.php";
//require_once 'src/Entities/Listelement.php';
//require_once 'src/Entities/Fields.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Sources\Entities\Listelement;
use Sources\Entities\Fields;


//get lists form excel
$reader = new Xlsx();
$reader->setReadDataOnly(true);
$reader->setLoadSheetsOnly(["Fields", "Auswahllisten"]);
$spreadsheet = $reader->load("conf/conf.xlsx");
/*
 * init Fields
 */

$worksheet = $spreadsheet->getSheetByName("Fields");
$highestColumn = $worksheet->getHighestColumn();
$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
$highestRow = $worksheet->getHighestRow();

$fields = [];

for($row = 2; $row <= $highestRow; $row++ ) {
  $values = [];
  for ($col = 1; $col <= $highestColumnIndex; $col++) {
    $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue() ?? "";
    array_push($values, $value);
  }
  array_push($fields, $values);
}

foreach($fields as $item) {
  //$id, $label, $description, $category, $type, $listId, $comments, $commentson, $area
  $comment = FALSE;
  if($item[6] === "Ja") {
    $comment = TRUE;
  } 
  $element = new Fields($item[0], $item[1], $item[2], $item[3], $item[4], $item[5], $comment, $item[7], $item[8]);
  $entityManager->persist($element);
  $entityManager->flush();
}

/*
 * init ListElements
 */
$worksheet = $spreadsheet->getSheetByName('Auswahllisten');

$highestColumn = $worksheet->getHighestColumn();
$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
$highestRow = $worksheet->getHighestRow();



/**
 * col => listId
 */
$listElements = [];

for($col = 1; $col <= $highestColumnIndex; $col++ ) {
  for ($row = 2; $row <= $highestRow; $row++) {
    $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
    if($value === NULL) {
      break;
    } else {
      $id_value_list = [];
      $id_value_list['listId'] = $col; 
      $id_value_list['value'] = $value;  
      array_push($listElements, $id_value_list);
    }
  }
}

foreach($listElements as $item) {
  echo $item['listId'] . " " . $item['value'] . "<br>";
  $element = new Listelement($item['listId'], $item['value']);
  $entityManager->persist($element);
  $entityManager->flush();
}

