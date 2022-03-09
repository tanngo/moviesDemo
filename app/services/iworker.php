<?php
namespace App\Services;
    interface IWorker{
        public function getListRecommended($inputTime, $inputGenre);
        public function show($movies,$inputTime);
        public function filter($listMovies,$inputGenre,$inputTime);
    }
?>