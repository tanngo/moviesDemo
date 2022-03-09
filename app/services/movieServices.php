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
    // I am not sure if need to time base on which timezone and 
    //whether to show all available showing that meet the condition
    public function show($movies, $inputTime){
        date_default_timezone_set(LOCAL_TIMEZONE);
        if($movies!=null and count($movies)>0){
          
          foreach($movies as $movie){
            echo $movie->name .", show at ";
            $count=1;
            foreach($movie->showings as $showing){
              if(strtotime( $inputTime) - strtotime($showing . ' - 30 minutes') <0)
              {
                if($count> 1) {
                  echo ", and ";
                }
                $count++;
                echo date("g:ia", strtotime($showing));                 
              }
               
            }
            echo "\n";
          }
        }else{
          echo No_Recomeneded_Movies;
        }
    }

    
}
?>