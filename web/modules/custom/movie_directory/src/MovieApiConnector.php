<?php

namespace Drupal\movie_directory;

use Drupal\Core\Http\ClientFactory;
use GuzzleHttp\Exception\RequestException;

class MovieApiConnector {

    private $client;
    private $apiKey;

    public function __construct(ClientFactory $clientFactory, $apiKey) {
        $this->apiKey = $apiKey;

        $this->client = $clientFactory->fromOptions([
            'base_uri' => 'https://api.themoviedb.org',
            'query' => ['api_key' => $this->apiKey],
        ]);
    }

    public function discoverMovies() {
        $data = [];
        $endpoint = '/3/movie/550';
        $options = ['query' => ['api_key' => $this->apiKey]];
    
        try {
            $request = $this->client->get($endpoint, $options);
            $statusCode = $request->getStatusCode();
    
            if ($statusCode == 200) {
                $result = $request->getBody()->getContents();
                \Drupal::logger('movie_directory')->debug('API Response: @response', ['@response' => $result]);
                $data = json_decode($result);
            } else {
                \Drupal::logger('movie_directory')->error('API request failed with status code: @statusCode', ['@statusCode' => $statusCode]);
            }
        } catch (RequestException $e) {
            \Drupal::logger('movie_directory')->error($e->getMessage());
        }
    
        return $data;
    }
    

    
}
