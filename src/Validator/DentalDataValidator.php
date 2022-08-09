<?php

namespace App\Validator;

use App\Enum\Dental\PartEnum;
use App\Enum\Dental\TypeEnum;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class DentalDataValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof \App\Model\DentalData) {
            throw new UnexpectedValueException($value, \App\Model\DentalData::class);
        }

        if (!$constraint instanceof DentalData) {
            throw new UnexpectedTypeException($value, DentalData::class);
        }

        if ((null === $type = $value->getType()) || (null === $part = $value->getPart())) {
            return;
        }

        if (TypeEnum::MISSING === $type && PartEnum::ROOT === $part) {
            $this->context->buildViolation($constraint->partTypeExcludeMessage)
                ->setParameter('{{ part }}', $part->value)
                ->setParameter('{{ type }}', $type->value)
                ->atPath('type')
                ->addViolation()
            ;
        }
    }
}
