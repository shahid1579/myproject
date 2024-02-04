<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiController extends AbstractController
{
    #[Route('/api/posts', name: 'app_api_posts')]
    public function getPosts(): JsonResponse
    {
        $client = new Client();
        try {
            $response = $client->request('GET', 'https://jsonplaceholder.typicode.com/posts');
            
            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Error: ' . $response->getStatusCode());
            }

            $data = json_decode($response->getBody()->getContents(), true);


            $search = 'minima';
            $filteredPosts = $this->filterposts($data, $search);

            $filteredPosts = array_values($filteredPosts);
            return new JsonResponse(array('posts' => $filteredPosts));
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    public function filterposts($posts, $search): array
    {
        return array_filter($posts, function ($post) use ($search) {
            return strpos($post['body'], $search) !== false;
        });
    }
}
