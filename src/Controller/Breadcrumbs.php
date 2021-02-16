<?php
namespace Sources\Controller;

class Breadcrumbs {
  
  private $entityManager;
  private $breadcrumbs;
  
  function __construct($entityManager) {
    $this->entityManager = $entityManager;
    $this->breadcrumbs = [];
    
    $qb = $this->entityManager->createQueryBuilder();
    $qb->select('u.category')
       ->from('Sources\Entities\Fields','u')
       ->distinct();
    $results = $qb->getQuery()->getResult();
    
    foreach ($results as $result) {
      if($result['category'] != '') {
        array_push($this->breadcrumbs, $result['category']);
      }
    } 
  }
  
  public function getHTMLCode() {
    $htmlCode = "";
    $i = 1;
    foreach ($this->breadcrumbs as $breadcrumb) {
      $fieldcategory = str_replace(" ","_", $breadcrumb);
      $fieldcategory = preg_replace('/[^A-Za-z0-9\_]/', '', $fieldcategory);
      
      $htmlCode = $htmlCode . '<li class="breadcrumbs page-item page-item-breadcrumb" fieldCategory="' . $fieldcategory . '" formPageId="' . $breadcrumb . '" data-toggle="tooltip" title="' . $breadcrumb . '"><a class="page-link" href="#">' . $i . '</a></li>';
      $i++;
    }
    return $htmlCode;
  }
}
