<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;



require_once "vendor/autoload.php";

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Entities"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);


// database configuration parameters
$conn = array(
  'driver' => 'pdo_sqlite',
  'path' => __DIR__ . '/conf/db.sqlite',
);


$testVari = "Boxershorts";
// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

function in_array_r($needle, $haystack, $strict = false) {
  foreach ($haystack as $item) {
    if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
      return true;
    }
  }
  return false;
}
