<?php


namespace App\Api\V1\Controller;


use App\Entity\Customers;
use App\Entity\Products;
use App\Repository\CustomersRepository;
use App\Repository\ProductsRepository;
use App\Transformer\CustomerTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ApiController extends BaseController
{
    protected $validator;

    protected $entityManager;

    /**
     * ApiController constructor.
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }
    public function consumersList()
    {
        $customers = $this->getDoctrine()
            ->getRepository(Customers::class)
            ->findAll();

        return new JsonResponse(CustomerTransformer::transform($customers));
    }

    public function createCustomer(Request $request)
    {
        $request = $this->parseJSONRequestBody($request);

        $entity = new Customers;

        $entity->setFirstName($request->get('firstName'));
        $entity->setLastName($request->get('lastName'));
        $entity->setDateOfBirth(new \DateTime($request->get('dateOfBirth')));

        $errors = $this->errorsToArray($this->validator->validate($entity));

        if (!empty($errors)) {
            return $this->validationErrorsJsonResponse($errors);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return new JsonResponse([
            'firstName' => $entity->getFirstName(),
            'lastName' => $entity->getLastName(),
            'dateOfBirth' => $entity->getDateOfBirth(),
            'status' => $entity->getStatus(),
            'created_at' =>$entity->getCreatedAt()->format('m-d-Y H:i:s'),
        ], 201);
    }

    public function createProductForCustomer(int $customer_id, Request $request)
    {
        $request = $this->parseJSONRequestBody($request);

        $entity = new Products();

        $entity->setCustomerId($customer_id);
        $entity->setName($request->get('name'));

        $errors = $this->errorsToArray($this->validator->validate($entity));

        if (!empty($errors)) {
            return $this->validationErrorsJsonResponse($errors);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return new JsonResponse([
            'name' => $entity->getName(),
            'customer' => [

            ],
            'status' => $entity->getStatus(),
            'created_at' =>$entity->getCreatedAt()->format('m-d-Y H:i:s'),
        ], 201);
    }

    public function combine( Request $request, CustomersRepository $customersRepository, ProductsRepository $productsRepository)
    {
        $request = $this->parseJSONRequestBody($request);

        if(!$customersRepository->find($request->get('customer_id')))
            throw new NotFoundResourceException('Customer not Found');

        if(!$productsRepository->find($request->get('product_id')))
            throw new NotFoundResourceException('Product "'.$request->get('product_id').'" not Found');

        $product = $this->getDoctrine()
            ->getRepository(Products::class)
            ->find($request->get('customer_id'));

        $product->setCustomerId($request->get('customer_id'));

        $errors = $this->errorsToArray($this->validator->validate($product));

        if (!empty($errors)) {
            return $this->validationErrorsJsonResponse($errors);
        }


        return new Response(null, 200);
    }
}