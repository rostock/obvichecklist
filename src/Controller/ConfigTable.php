<?php
namespace Sources\Controller;

use Doctrine\ORM\Query;

class ConfigTable {
  
  private $type;
  private $listId;
  private $entityManager;
  private $header;
  private $content;
  
  function __construct($type, $listId, $entityManager) {
    $this->type = $type;
    $this->listId = $listId;
    $this->entityManager = $entityManager;
    
    $this->buildTable();
  }

  function buildTable() {
    switch ($this->type) {
      case "fields":
        $this->buildFieldTable();
      case "list":  
        $this->buildListTable();
    }
  }
  
  function buildFieldTable() {
    $conn = $this->entityManager->getConnection();
    $sm = $conn->getSchemaManager();
    $columns = $sm->listTableColumns('fields');
    $this->buildHeader($columns);
       
    $qb = $this->entityManager->createQueryBuilder();
    $qb->select('u')
       ->from('Sources\Entities\Fields','u');
    $results = $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    $this->buildContent($results);
  }
  
  function buildListTable() {
    
  }
    
  function buildHeader($columns) {
    $this->header = [];
    if($columns) {
      foreach ($columns as $col) {
        array_push($this->header, $col->getName());
      }
    }
  }
  
  function buildContent($results) {
    $this->content = [];
    if($results) {
      foreach ($results as $result) {
        array_push($this->content, $result);
      }
    }
  }
  
  function getHTMLCode() {
    $html = '<button type="button" conf="new" class="btn btn-primary" data-toggle="modal" data-target="#confModal">
            <i class="bi bi-plus-square"></i>
          </button></td></tr><table class="table"><thead><tr>';
    
    foreach($this->header as $value) {
      $html = $html . '<th scope="col">' . $value . '</th>';
    }
    $html = $html . '<th></th></tr></thead><tbody>';
    
    foreach($this->content as $tupel) {
      $html = $html .'<tr>';
      $i = 0;
      foreach ($tupel as $value) {
        $html = $html . '<td col="' . $this->header[$i]. '">' . $value . '</td>';
        $i++;
      }
      $html = $html .'<td>'
        . '<button type="button" conf="update" class="btn btn-primary" data-toggle="modal" data-target="#confModal">
            <i class="bi bi-gear" data-toggle="modal" data-target="#confModal"></i>
          </button></td></tr>';
    }
    $html = $html . '</tbody></table>';
    return $html;
  }
  
  function getHTMLModal() {
    
    $html =  '<div class="modal fade" id="confModal" tabindex="-1" aria-labelledby="confModal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Konfiguration</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">';
     
    foreach ($this->header as $input) {
      $html = $html . '<div class="form-group">
                        <label title="' . $input . '" for="">' . $input . ': </label>
                        <input kind="text" type="text" class="form-control" id="' . $input . '" value="">
                    </div>';
    }
             
    $html = $html . '</div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">weiter bearbeiten</button>
              <button type="button" class="btn btn-primary" id="saveConfigBtn">Übernehmen</button>
            </div>
          </div>
        </div>
      </div>';
    
    return $html;
    
    
  }
}
