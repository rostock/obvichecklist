<?php

require_once "bootstrap.php";


use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

//get lists form excel
$reader = new Xlsx();
$reader->setReadDataOnly(true);
$reader->setLoadSheetsOnly(["Auswahllisten"]);
$spreadsheet = $reader->load("conf/conf.xlsx");
$worksheet = $spreadsheet->getActiveSheet();

$highestColumn = $worksheet->getHighestColumn();
$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
$highestRow = $worksheet->getHighestRow();

$listElements = [];


for($col = 1; $col <= $highestColumnIndex; $col++ ) {
  for ($row = 2; $row <= $highestRow; ++$row) {
    $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
    if($value === NULL) {
      break;
    } else {
      
      ${'confList' . $col}[$row] = $value;
    }
  }
}

//get lists from database
for($col = 1; $col <= $highestColumnIndex; $col++ ) {
  ${'list' . $col . 'Repository'} = $entityManager->getRepository('List' . $col);
  ${'list' . $col} = ${'list' . $col . 'Repository'}->findAll();
  ${'list_' . $col} = array();
  foreach (${'list' . $col} as $element) {
    ${'list_' . $col}[$element->getId()] = $element->getValue();
  }
}


//compare both lists
for($col = 1; $col <= $highestColumnIndex; $col++ ) {
    
  $results = array_diff_assoc(${'confList' . $col}, ${'list_' . $col});
  foreach ($results as $key => $result) {
    echo $key . " " . $result ."<br>";
    $classname = "List" . $col;
    $element = new $classname();
    $element->setId(intval($key));
    $element->setValue($result);

    $entityManager->persist($element);
    $entityManager->flush();
  }
}
  
