<?php
require_once "bootstrap.php";
use Sources\Entities\Fields;
use Sources\Entities\Listelement;

$entitytype = ucfirst(json_decode($_POST['entitytype'])->value);
$entityType = 'Sources\Entities\\' . $entitytype;
$id = json_decode($_POST['id'])->value;

foreach($_POST as $key => $value) {
  if($key != 'id' && $key != 'entitytype') {
    $json = json_decode($value);
    $values[$key] = $json->value;
  }
}

if($id != "") {
  $entity = $entityManager->getRepository($entityType)
    ->findOneBy(array('id' => $id));

  if ($entity === null) {
    $entity = new $entityType;
    $entity->setId($id);
  }

  foreach ($values as $key => $value) {
    $method = 'set' . ucfirst($key);
    $entity->{$method}($value);
  }

  $entityManager->persist($entity);
  $entityManager->flush();
} else {
  $entity = new $entityType;
  $entity->setId(555);
  
  foreach ($values as $key => $value) {
    echo $key . '<br>';
    $method = 'set' . ucfirst($key);
    $entity->{$method}($value);
  }

  $entityManager->persist($entity);
  $entityManager->flush();
}