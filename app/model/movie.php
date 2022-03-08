<?php
namespace App\Model;
class Movie {
    public $name;
    public $rating;
    public $genres;
    public $showings;

    function __construct($name,$rating,$genres ,$showings){
        $this->name = $name;
        $this->rating = $rating;
        $this->genres = $genres;
        $this->showings = $showings;
    }
   
}
?>