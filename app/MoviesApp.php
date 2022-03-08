<?php
namespace App;
require __DIR__.'/../vendor/autoload.php';
Use App\services\MovieServices as MovieServices;
//get list of recomended movies
$imovieServices = new MovieServices();
$returnMovies = $imovieServices->getListRecommendedMovies("16:30:00+11:00","Animation");
//print out base on format
$imovieServices->printMovies($returnMovies);  
  

?>