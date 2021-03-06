<?php
namespace Tests;
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../app/config/const.php';
use App\Model\Movie as Movie;
use App\Services\MovieServices as MovieServices; 
use PHPUnit\Framework\TestCase;

class MoviesTest extends TestCase
{
    public $iworker ;
 
    public function testFilterMovies_ReturnEmpty_NoGenres()
    {
        $this->iworker = new MovieServices();
        $movies = array(new Movie("test movies",92,["Animation","Comedy"],["22:00:00+11:00"]));
        $result = $this->iworker->filter($movies,"Science Fiction & Fantasy","21:00:00+11:00");
        $this->assertTrue($result ==null);
    }
    public function testFilterMovies_ReturnEmpty_Timeover()
    {
        $this->iworker = new MovieServices();
        $movies = array(new Movie("test movies",92,["Animation","Comedy"],["19:00:00+11:00"]));
        $result = $this->iworker->filter($movies,"Animation","21:00:00+11:00");
        $this->assertTrue($result ==null);
    }
    public function testFilterMovies_Movies_HaveMovies()
    {
        $this->iworker = new MovieServices();
        $movies = array(
            new Movie("test movies",92,["Animation","Comedy"],["19:00:00+11:00"]),
            new Movie("test movies2",92,["Animation","Comedy"],["19:00:00+11:00"])
        );
        $result = $this->iworker->filter($movies,"Animation","18:00:00+11:00");
        $this->assertTrue(count($result) >0 );
    }
    public function testFilterMovies_Movies_CheckedReturnedMovies()
    {
        $this->iworker = new MovieServices();
        $movies = array(
            new Movie("test movies",92,["Animation","Comedy"],["19:00:00+11:00"]),
            new Movie("test movies2",92,["Animation","Comedy"],["21:00:00+11:00"])
        );
        $result = $this->iworker->filter($movies,"Animation","18:00:00+11:00");
        $this->assertTrue($result[0]->name == "test movies"  );
    }
    public function testFilterMovies_Movies_CheckOrderByRating()
    {
        $this->iworker = new MovieServices();
        $movies = array(
            new Movie("test movies",92,["Animation","Comedy"],["19:00:00+11:00"]),
            new Movie("test movies2",92,["Animation","Comedy"],["21:00:00+11:00"]),
            new Movie("test movies3",95,["Animation","Science Fiction & Fantasy"],["21:00:00+11:00"])
        );
        $result = $this->iworker->filter($movies,"Animation","20:00:00+11:00");
        $this->assertTrue(intval($result[0]->rating) < intval($result[1]->rating) );
    }

}
?>