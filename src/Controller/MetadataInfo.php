<?php
namespace Sources\Controller;

class MetadataInfo {
    
  private $metadata;
  private $entityManager;
  
  function __construct($knummer, $entityManager) {
    $this->entityManager = $entityManager;
    $this->metadata = [];
        
    $qb = $this->entityManager->createQueryBuilder();
    $qb->select('u.datetime, u.type, u.bearbeiter')
       ->from('Sources\Entities\Metadata','u')
       ->where('u.knummer = :id')
       ->setParameter('id', $knummer);
    $results = $qb->getQuery()->getResult();
    
    foreach ($results as $result) {
      array_push($this->metadata, [$result['type'], $result['bearbeiter'], $result['datetime']]);
    };
  }
  
  public function getHTMLCode() {
    $htmlCode = "";
    $i = 0;
    
    foreach ($this->metadata as $meta) {   
      $user = new ListValue($meta[1], $this->entityManager);
      $htmlCode = $htmlCode . '<p>' . $meta[0] . ' von ' . $user->getValue() . ' am ' . $meta[2]->format('Y-m-d H:i:s') . '</p>';
      $i++;
    }
    if($i === 0) {
      $htmlCode = "Neuer Antrag K-Nummer noch nicht vergeben";
    }
    return $htmlCode;
  } 
}
