<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\LoadImage;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    #[Route('/admin/load-product', name: 'load-product')]
    public function index(Request $request, EntityManagerInterface $manager, LoadImage $loadImage): ?Response
    {
        $name = $request->request->get('name');
        $description = $request->request->get('description');
        $price = $request->request->get('price');
        if (!$request->request->has('name') && !$request->request->has('description') && $request->request->has('price')) {
            return new JsonResponse('not data', 403);
        }
        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);

        $imageFiles = $request->request->all()['image'];
        $product->setImage($loadImage->setImages($imageFiles));
        $manager->persist($product);
        $manager->flush();

        return new JsonResponse('OK');
    }

    #[Route('/admin/delete-product/{id}')]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteProduct(
        int $id,
        ProductRepository $repository,
        EntityManagerInterface $entityManager,
        LoadImage $loadImage
    ): ?Response
    {
        $product = $repository->find($id);
        $loadImage->deleteImages($product->getImage());
        $entityManager->remove($product);
        $entityManager->flush();
        return new Response('delete '. $id);
    }
}
