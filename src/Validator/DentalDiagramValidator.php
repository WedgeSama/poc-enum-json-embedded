<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class DentalDiagramValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof \App\Entity\DentalDiagram) {
            throw new UnexpectedValueException($value, \App\Entity\DentalDiagram::class);
        }

        if (!$constraint instanceof DentalDiagram) {
            throw new UnexpectedTypeException($value, DentalDiagram::class);
        }

        $toChecks = $value->getDatas();
        foreach ($value->getDatas() as $index => $data) {
            array_shift($toChecks);
            foreach ($toChecks as $otherIndex => $otherData) {
                if ($data->isSameDental($otherData)) {
                    $this->context->buildViolation($constraint->sameMessage)
                        ->setParameter('{{ dental }}', $data)
                        ->setParameter('{{ other }}', $otherData)
                        ->atPath(sprintf('datas[%d].shape', $index + $otherIndex + 1))
                        ->addViolation()
                    ;
                    break;
                }
            }
        }
    }
}
