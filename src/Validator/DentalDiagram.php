<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class DentalDiagram extends Constraint
{
    public string $sameMessage = 'Cannot add same dental "{{ dental }}" and "{{ other }}".';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
