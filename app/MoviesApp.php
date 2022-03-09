<?php
namespace App;
require __DIR__.'/../vendor/autoload.php';
Use App\services\MovieServices as MovieServices;
//get list of recomended movies
$iworker = new MovieServices();
$inputTime="16:30:00+11:00";
$genre = "Animation";
$returnMovies = $iworker->getListRecommended($inputTime,$genre);
//print out base on format
$iworker->show($returnMovies,$inputTime);  
  
//echo preg_replace("+[0-9\:]{2}$", "","16:30:00+11:00");  
?>