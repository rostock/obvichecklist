<?php
require_once "bootstrap.php";
require "vendor/autoload.php";

use Sources\Controller\Fields;
use Sources\Controller\MetadataInfo;
use Sources\Controller\Breadcrumbs;
use Sources\Controller\Filter;

$knummer = null;
if(isset($_GET['knummer'])) {
  $knummer = $_GET['knummer'];
}
$metadata = new MetadataInfo($knummer, $entityManager);
$breadcrumbs = new Breadcrumbs($entityManager);
$filter = new Filter($entityManager);
$fields = new Fields($entityManager, $knummer);
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="lib/bootstrap-4.5.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="images/icons/bootstrap-icons.css">
    <link rel="stylesheet"  href="lib/jquery-ui-1.12.1.custom/jquery-ui.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>ÖBVI Checkliste</title>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">ÖBVI Checklist</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav view">
            <a class="nav-item nav-link" href="#">Filter an</a>
          </div>  
          <div class="navbar-nav view deactive">
            <a class="nav-item nav-link" href="#">Filter aus</a>
          </div>  
          <div class="navbar-nav">
            <a class="nav-item nav-link" href="listItems.php">Alle Einträge</a>
          </div>
          <div class="navbar-nav">
            <a class="nav-item nav-link" href="conf.php" title="Konfiguration"><i class="bi bi-gear"></i></a>
          </div>
           <?php
              echo $fields->getHTMLCode('navbar');
           ?>
        </div>
      </nav>
    </header>
    <div class="spinnerbox">
      <div class="spinner"></div>
    </div>
    <main>
      <div class="container">
        <div class="col-md-12 order-md-1">
          <div class="alert alert-primary" role="alert">
              <?php
                echo $metadata->getHTMLCode();
              ?>
          </div>
        </div>
      </div> 
        
      <div class="container" id="breadcrumb">
        <nav aria-label="...">
          <ul class="pagination pagination-lg justify-content-center">
            <?php
              echo $breadcrumbs->getHTMLCode();
            ?>
          </ul>
        </nav>
      </div>
      <div class="container deactive" id="filter">
        <div class="col-md-12 order-md-1">
          <?php 
            echo $filter->getCheckboxHTMLCode();
          ?>
        </div>
      </div>  
         
      <div class="container">
        <div class="col-md-12 order-md-1">
          <form class="needs-validation" novalidate="">
            <div class="container formcontainer" id="start">  
              <span class="d-block p-2 bg-dark text-white mb-3">
                <h4 id="sectionTitel" class="mb-3">Titel der unterschiedlichen Kategorien</h4>
              </span>
              <?php
                echo $fields->getHTMLCode('main');
              ?>
              <nav aria-label="Wizard navigation">
                <ul class="pagination justify-content-center">
                  <li class="page-item btnPrevious disabled">
                    <a class="page-link" href="#" tabindex="-1">Zurück</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link  bg-primary text-white" data-toggle="modal" data-target="#summaryModal">Übernehmen</a>
                  </li>
                  <li class="page-item btnNext">
                    <a class="page-link" href="#">Vor</a>
                  </li>
                </ul>
              </nav>
            </div>
          </form>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Zusammenfassung</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <?php 
                $fr = $filter->getDefaultHTMLCode();
                echo $fr;
                echo $fields->getHTMLCode('modal');
              ?>
             
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">weiter bearbeiten</button>
              <button type="button" class="btn btn-primary" id="<?php echo $fields->getType() . 'IssueBtn'?>">Übernehmen</button>
            </div>
          </div>
        </div>
      </div>  
    </main>
    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="#">Nach oben</a>
        </p>
      </div>
    </footer>  
    
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="lib/jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="lib/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="lib/bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/tooltip.js"></script>
    <script src="js/autocomplete.js"></script>
    <script src="js/createItem.js"></script>
  </body>
</html>