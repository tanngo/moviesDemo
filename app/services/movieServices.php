<?php

namespace App\Services;
require_once(__DIR__."/../config/const.php");
use App\Helper\CurlHelper as CurlHelper;
use App\Services\IWorker as IWorker;
class MovieServices implements IWorker {
    public function getListRecommended($inputTime, $inputGenre){
        try{
            $action = "GET";
            $url = ListMoviesUrl;
            $parameters = array();
            $curlHelper = new CurlHelper();
            $result = $curlHelper->perform_http_request($action, $url, $parameters);
            //echo $result;
            $listMovies= json_decode($result);
            $returnMovies = $this->filter($listMovies,$inputGenre,$inputTime);

            return $returnMovies;
            
        }
        catch( Exception $e){
            error_log( 'Caught exception: ',  $e->getMessage(), "\n",3);
            return null;
        }
        
    }
    public function filter($listMovies,$inputGenre,$inputTime){
      $returnMovies = array();
      foreach($listMovies as $movie){
        $search_array = array_map('strtolower', $movie->genres);
        if (in_array(strtolower($inputGenre),$search_array)){
            $showings = $movie->showings;
            if($showings !=null and count($showings) >0){
              foreach($showings as $showing){
                if(strtotime( $inputTime) - strtotime($showing . ' - 30 minutes') <0){
                    array_push($returnMovies, $movie); 
                    break;
                }
              } 
            }
       
        };
      }
       //sort by rating if multiple movies returned
       if($returnMovies!=null and count($returnMovies)>0)
       {
           usort($returnMovies, function($a, $b) {return strcmp($a->rating, $b->rating);});
       }
        return $returnMovies;
    }
    public function show($movies){
        date_default_timezone_set(LOCAL_TIMEZONE);
        if($movies!=null and count($movies)>0){
          
          foreach($movies as $movie){
            echo $movie->name .", show at ".date("g:ia", strtotime($movie->showings[0])) ."\n";
          }
        }else{
          echo No_Recomeneded_Movies;
        }
    }

    
}
?>