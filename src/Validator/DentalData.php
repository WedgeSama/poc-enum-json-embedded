<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class DentalData extends Constraint
{
    public string $partTypeExcludeMessage = 'The part "{{ part }}" cannot be set with type "{{ type }}".';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
