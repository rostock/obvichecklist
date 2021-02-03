<?php
require_once "bootstrap.php";
use Sources\Entities\Inhalt;
use Sources\Entities\Anmerkungen;
use Sources\Entities\Listelement;
use Sources\Entities\Metadata;

$values = [];

foreach($_POST as $key => $value) {
  $json = json_decode($value);
  $values[$key] = $json;
}
echo "CreateItem.php";
$knummer = $values['1'];

$query = $entityManager->createQuery('SELECT distinct(u.knummer) FROM Sources\Entities\Inhalt u');
$results = $query->getResult();

if(in_array_R($knummer->value,$results)) {
  echo "K-Nummer bereits vergeben, wechseln Sie in den Editor-Modus";
} else {
  //Werte der einzelnen Felder eintragen
  foreach ($values as $key => $val) {
    if($val->type !== 'comment') {
      createItem($knummer, $val, $entityManager);
    } else {
      createAnmerkung($knummer, $val, $entityManager);
    }
  }
  createMetadata($knummer->value, 'Erstellung', $entityManager);
}

/*
 * Object of $val:
 *  id: $( this ).attr('id').replace("comment_", ""),
 *  type:$( this ).attr('kind'),
 *  list:$( this ).attr('list'),
 *  value:$( this ).attr('value'),
 *  val:$( this ).val()
 */
function createItem($knummer, $item, $entityManager) {
  if($item->type == "autocomplete") {
    $valueContent = getValueContent($item, $entityManager);
  } else {
    $valueContent = $item->value;
  }
  
  $tupel = new Inhalt();
  $tupel->setKnummer($knummer->value);
  $tupel->setFieldId($item->id);
  $tupel->setValue($valueContent);
  
  $entityManager->persist($tupel);
  $entityManager->flush();
}

function createAnmerkung($knummer, $item, $entityManager) {
  // filtern das nur gefüllte kommentare angelegt werden
  if($item->value != "") {
    $tupel = new Anmerkungen();
    $tupel->setKnummer($knummer->value);
    $tupel->setFieldId($item->id);
    $tupel->setValue($item->value);
    $entityManager->persist($tupel);
    $entityManager->flush();
  }
}

function getValueContent($item, $entityManager) {
  if(isset($item->list) && isset($item->val) && $item->value == "") {
    //check if $item->val exists
    $queryBuilder = $entityManager->createQueryBuilder();
    $queryBuilder->select('u.value, u.id')
      ->from('Sources\Entities\Listelement',' u')
      ->where('u.listId = :id')
      ->andWhere('u.value = :val')
      ->setParameter('val', $item->val)
      ->setParameter('id', $item->list);
  
    $res = $queryBuilder->getQuery()->getResult();
       
    if(!isset($res[0]['value'])) {
    
      $tupel = new Listelement($item->list, $item->val);
      $entityManager->persist($tupel);
      $entityManager->flush();
      return $tupel->getId();
    } else {
      return $res[0]['id'];
    }  
  }
  return $item->value;
}

function createMetadata($knummer, $type, $entityManager) {
  echo "Metadata für " . $knummer . "  | ";
  $queryBuilder = $entityManager->createQueryBuilder();
  $queryBuilder->select('u.value')
    ->from('Sources\Entities\Inhalt',' u')
    ->where('u.knummer = :id')
    ->andWhere('u.fieldId = :fieldId')
    ->setParameter('id', $knummer)
    ->setParameter('fieldId', '0');
  
  $res = $queryBuilder->getQuery()->getResult();
  var_dump($res);
  echo $res[0]['value'];
  
  $tupel = new Metadata();
  $tupel->setKnummer($knummer);
  $tupel->setBearbeiter($res[0]['value']);
  $tupel->setType($type);
  $entityManager->persist($tupel);
  $entityManager->flush();
}