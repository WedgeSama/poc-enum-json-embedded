<?php

namespace App\Form;

use App\Enum\Dental\PartEnum;
use App\Enum\Dental\ShapeEnum;
use App\Enum\Dental\TypeEnum;
use App\Model\DentalData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DentalDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('shape', EnumType::class, [
                'class' => ShapeEnum::class,
            ])
            ->add('type', EnumType::class, [
                'class' => TypeEnum::class,
            ])
            ->add('part', EnumType::class, [
                'class' => PartEnum::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DentalData::class,
        ]);
    }
}
