<?php


namespace App\Form;


use App\Entity\Bank;
use App\Entity\Products;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductType extends AbstractType
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $translator = $this->container->get('translator');

        $builder
            ->add('name', TextType::class)

            ->add('status', ChoiceType::class, [
                'choices' => array_merge([
                    '----' => null
                ], array_reverse(
                    (new Products())->getPossibleReversed())
                )

            ]);
    }
}