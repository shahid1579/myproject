<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/products', name: 'get_product', methods: ['GET'])]
    public function getProducts(): JsonResponse
    {

    $products = $this->entityManager->getRepository(Product::class)->findAll();

       if (!$products) {
        throw new NotFoundHttpException('No products found.');
    }
       $responseDate = [];
       foreach ($products as $product) {
           $responseDate[] = [
               'id' => $product->getId(),
               'product_id' => $product->getProductId(),
               'product_name' => $product->getProductName(),
           ];
       }

       return new JsonResponse(['products' => $responseDate]);
    }

}
