<?php

require_once "bootstrap.php";
require "vendor/autoload.php";

//Database
use Sources\Controller\Fields;
use Sources\Controller\MetadataInfo;
use Sources\Controller\Breadcrumbs;
use Sources\Controller\Filter;

//Office Excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//Exceldokument vorbereiten
$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()
    ->setCreator("KVLA HRO")
    ->setLastModifiedBy("ÖbVI Checkliste")
    ->setTitle("Statistik ÖbVI Checkliste")
    ->setSubject("")
    ->setDescription(
        "Document zur Statistikauswertung."
    )
    ->setKeywords("ÖbVI Checklist")
    ->setCategory("Statistik");

$worksheet = $spreadsheet->getSheetByName('Worksheet');
$worksheet->setTitle('Statistik');


//Tabellenköpfe setzen
$query = $entityManager->createQuery('SELECT u.label, u.id, u.listId FROM Sources\Entities\Fields u');
$resultsFields = $query->getResult();

$col = 0;
foreach ($resultsFields as $key => $value) {
  $spreadsheet->getActiveSheet()
    ->getCellByColumnAndRow($col, 1)
    ->setValue($value["label"]);
  $col++;
}

//Inhalte setzen
$query = $entityManager->createQuery('SELECT distinct(u.knummer) FROM Sources\Entities\Inhalt u');
$knummern = $query->getResult();

$row = 2;
foreach ($knummern as $key => $value) {
  $query = $entityManager->createQuery('SELECT u.value, u.fieldId FROM Sources\Entities\Inhalt u where u.knummer = :id');
  $query->setParameter('id', $value[1]);
  $content = $query->getResult();
  
  foreach ($content as $key => $dataset) {
    //KNummer ablegen oder Wert ablegen
    if($dataset['fieldId'] == 1) {
      echo $value[1];
      $cellvalue = $value[1];
    } else {
      //Listenwert ermitteln
      $query = $entityManager->createQuery('SELECT u.value FROM Sources\Entities\Listelement u where u.id = :id');
      $query->setParameter('id', $dataset['value']);
      $content = $query->getResult();
      $cellvalue = $content[0]['value'];
    }
    $spreadsheet->getActiveSheet()
    ->getCellByColumnAndRow($dataset["fieldId"], $row)
    ->setValue($cellvalue);
  }
  $row++;
}

// Exceldatei anlegen und speichern
$writer = new Xlsx($spreadsheet);
$writer->save('statistik.xlsx');
?>