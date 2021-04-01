<?php

require_once "bootstrap.php";

$query = $entityManager->createQuery("SELECT u.id, u.value FROM Sources\Entities\Listelement u where u.listId='" . $_GET['list'] . "' and u.value LIKE :term")
  ->setParameter('term', '%' . $_GET['term'] . '%');
$results = $query->getResult();

$json = [];
foreach($results as $result){
  $item = array('id' => $result['id'], 'label' => $result['value'], 'value' => $result['value'], );
  array_push($json, $item);
}

echo json_encode($json);
?>

