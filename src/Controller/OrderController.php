<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\ProductController;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order', methods: ['POST'])]
    public function order(Request $request): JsonResponse
    {
        $productId = $request->request->get('product_id');
        $quantity = $request->request->get('quantity');

        $product = new ProductController();
        $productDetails = $product->getProduct($productId);

        if($productDetails->getStatusCode() !== 200) {
            return new JsonResponse(['error' => 'Product not found.'], 404);
        }

        if($productDetails->stock_available === false) {
            return new JsonResponse(['error' => 'Product out of stock.'], 400);
        }
        else {
            return new JsonResponse(['order' => 'Your order has been placed.']);
        }


        
    }
}
