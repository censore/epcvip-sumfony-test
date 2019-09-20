<?php

namespace App\Validator;

use App\Repository\CustomersRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CustomerExistsValidator extends ConstraintValidator
{
    private $customersRepository;

    public function __construct(CustomersRepository $customersRepository)
    {
        $this->customersRepository = $customersRepository;
    }

    public function validate($value, Constraint $constraint)
    {

        $exists = $this->customersRepository->find($value);

        if(!$exists)
            throw new EntityNotFoundException($constraint->message);
    }
}
