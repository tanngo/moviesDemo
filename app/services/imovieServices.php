<?php
namespace App\Services;
    interface IMovieServices{
        public function getListRecommendedMovies($inputTime, $inputGenre);
        public function printMovies($movies);
        public function filterMovies($listMovies,$inputGenre,$inputTime);
    }
?>