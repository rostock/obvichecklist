<?php
require_once "bootstrap.php";

$data = [];
foreach ($_POST as $key => $value) {
  array_push($data,$value);
}

foreach ($data as $key => $id) {
  /*
   * delete all Anmerkungen with knummer
   */
  $qb = $entityManager->createQueryBuilder();
  $q = $qb->delete('Sources\Entities\Anmerkungen', 'u')
    ->where('u.knummer = :knummer')
    ->setParameter('knummer', $id);  
  $p = $q->getQuery()->execute();
  
  /*
   * delete all Inhalt with knummer
   */
  $qb = $entityManager->createQueryBuilder();
  $q = $qb->delete('Sources\Entities\Inhalt', 'u')
    ->where('u.knummer = :knummer')
    ->setParameter('knummer', $id);  
  $p = $q->getQuery()->execute();

  /*
   * delete all Metadata with knummer
   */
  $q = $qb->delete('Sources\Entities\Metadata', 'u')
    ->where('u.knummer = :knummer')
    ->setParameter('knummer', $id);  
  $p = $q->getQuery()->execute();  
}



?>
