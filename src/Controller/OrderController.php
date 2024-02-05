<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\ProductController;
use Doctrine\ORM\EntityManagerInterface;

class OrderController extends AbstractController
{
    private $entityManager ;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/order', name: 'app_order', methods: ['POST'])]
    public function order(Request $request): JsonResponse
    {
        $productId = $request->request->get('product_id');
        $quantity = $request->request->get('quantity');

        $product = new ProductController($this->entityManager);
        $productDetails = $product->getProduct($productId);


        if($productDetails->getStatusCode() !== 200) {
            return new JsonResponse(['error' => 'Product not found.'], 404);
        }

        $productDetails = json_decode($productDetails->getContent(), true);

        if($productDetails["product"]["stock_available"] -$quantity >= 0) {
            return new JsonResponse(['order' => 'Your order has been placed.'], 400);
        }
        else {
            return new JsonResponse(['error' => 'Product out of stock.']);
        }


        
    }
}
