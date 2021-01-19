<?php
echo "updateItem.php<br>";

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

$knummer = $values['1']->value;

$query = $entityManager->createQuery('SELECT distinct(u.knummer) FROM Sources\Entities\Inhalt u');
$results = $query->getResult();

if(in_array_R($knummer, $results)) {
  foreach ($values as $key => $val) {
    var_dump($val);
    echo "<br>";
    echo "<br>";
    if($val->type !== 'comment') {
      updateItem($knummer, $val, $entityManager);
    } else {
      updateAnmerkung($knummer, $val, $entityManager);
    }
  }
  createMetadata($knummer, 'Aktualisierung', $entityManager);
  echo "K-Nummer aktualisiert";
} else {
  echo "K-Nummer noch nicht vergeben, wechseln Sie in den Anlegen-Modus";
}

/*
 * Object of $val:
 *  id: $( this ).attr('id').replace("comment_", ""),
 *  type:$( this ).attr('kind'),
 *  list:$( this ).attr('list'),
 *  value:$( this ).attr('value'),
 *  val:$( this ).val()
 */
function updateItem($knummer, $item, $entityManager) {
  
  if($item->type == "autocomplete") {
    $valueContent = getValueContent($item, $entityManager);
  } else {
    $valueContent = $item->value;
  }
  
  $id = $item->id;
  $qb = $entityManager->createQueryBuilder();
  $q = $qb->update('Sources\Entities\Inhalt', 'u')
    ->set('u.value', ':husten')
    ->where('u.knummer = :knummer')
    ->andWhere('u.fieldId = :fieldid')
    ->setParameter('husten', $valueContent )
    ->setParameter('knummer', $knummer)
    ->setParameter('fieldid', $id);  
  $p = $q->getQuery()->execute();
}

function updateAnmerkung($knummer, $item, $entityManager) {
    // filtern das nur gefüllte Kommentare angelegt werden
  if($item->value != "") {
    $entity = $entityManager->getRepository('Sources\Entities\Anmerkungen')
      ->findOneBy(array('knummer' => $knummer, 'fieldId' => $item->id));
      
    if ($entity === null) {
      $entity = new  Anmerkungen();   
    }
    
    $entity->setKnummer($knummer);
    $entity->setFieldId($item->id);
    $entity->setValue($item->value);
    $entityManager->persist($entity);
    $entityManager->flush();

  }
}
/*
 * Funktion rausnehmen und dafür die Klassen verwenden
 */
function getValueContent($item, $entityManager) {
  if(isset($item->list) && isset($item->val) && $item->value == "") {
    //check if $item->val exists
    $queryBuilder = $entityManager->createQueryBuilder();
    $queryBuilder->select('u.value, u.elementId')
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
      return $tupel->getElementId();
    } else {
      return $res[0]['elementId'];
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
    
  $tupel = new Metadata();
  $tupel->setKnummer($knummer);
  $tupel->setBearbeiter($res[0]['value']);
  $tupel->setType($type);
  $entityManager->persist($tupel);
  $entityManager->flush();
}