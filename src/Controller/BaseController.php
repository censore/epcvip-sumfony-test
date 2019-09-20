<?php

namespace App\Controller;

use App\DTO\ProductDTO;
use App\Entity\Customers;
use App\Entity\Products;
use App\Form\ProductType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseController extends AbstractController
{

    protected $container;
    protected $validator;
    protected $entityManager;

    public function __construct(ContainerInterface $container, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $this->container = $container;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    public function index(): Response
    {
        $customers = $this->getDoctrine()
            ->getRepository(Customers::class)
            ->findAll();

        return $this->render('customers/list-customers.twig', [
            'customers' => $customers
        ]);
    }

    public function showProducts(int $customer_id)
    {
        $products = $this->getDoctrine()
            ->getRepository(Products::class)
            ->findBy([
                'customer' => $customer_id
            ]);

        return $this->render('/products/list-products.twig', [
            'products' => $products,
            'customer_id' => $customer_id
        ]);
    }

    public function addProduct(int $customer_id, Request $request)
    {
        $repository = new Products();
        if($request->isMethod('POST')){
            $repository->setName($request->get('name'));
            $repository->setStatus($request->get('status'));
            $repository->setCustomerId($customer_id);

            $this->validator->validate($repository);
            $this->entityManager->persist($repository);
            $this->entityManager->flush();
        }
        return $this->render('/products/form.create.twig', [
            'customer_id' => $customer_id,
            'repository' => $repository,
        ]);
    }

    /**
     * I'm tried to do validation with DTO but it can spend more times, what i tried to made you can find in DTO/Services/Form directory
     *
     * @param int $customer_id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function saveProduct(int $customer_id, Request $request)
    {
        $dto = new ProductDTO();
        $form = $this->createForm(ProductType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }
        return $this->redirectToRoute('customer_products', ['customer_id' => $customer_id]);
    }
}