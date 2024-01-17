<?php
namespace Drupal\movie_directory\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\movie_directory\MovieApiConnector;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MovieListing extends ControllerBase {

    private $apiConnector;

    public function __construct(MovieApiConnector $apiConnector) {
        $this->apiConnector = $apiConnector;
    }

    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('movie_directory.api_connector')
        );
    }

    public function view() {
        $movies = $this->listMovies();
        $content = [
            'movies' => $movies,
            'name' => 'I am Supriya',
        ];

        return [
            '#theme' => 'movie_listing',
            '#content' => $content, 
        ];
    }

    public function listMovies() {
        $movie_list = $this->apiConnector->discoverMovies();
        var_dump($movie_list);

        if (!empty($movie_list->results)) {
            return $movie_list->results;
        }

        return [];
    }
}



?>
