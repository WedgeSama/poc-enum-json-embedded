<?php

/*
 * This file is part of the embedded-json package.
 *
 * (c) Benjamin Georgeault
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

use App\Enum\Dental\PartEnum;
use App\Enum\Dental\ShapeEnum;
use App\Enum\Dental\TypeEnum;
use App\Validator\DentalData as DentalDataConstraint;

/**
 * Class DentalData
 *
 * @author Benjamin Georgeault
 */
#[DentalDataConstraint]
class DentalData
{
    private ?ShapeEnum $shape = null;
    private ?PartEnum $part = null;
    private ?TypeEnum $type = null;

    public function getShape(): ?ShapeEnum
    {
        return $this->shape;
    }

    public function setShape(?ShapeEnum $shape): static
    {
        $this->shape = $shape;
        return $this;
    }

    public function getPart(): ?PartEnum
    {
        return $this->part;
    }

    public function setPart(?PartEnum $part): static
    {
        $this->part = $part;
        return $this;
    }

    public function getType(): ?TypeEnum
    {
        return $this->type;
    }

    public function setType(?TypeEnum $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function isSameDental(self $other): bool
    {
        return $this->getShape() === $other->getShape()
            && $this->getPart() === $other->getPart()
        ;
    }

    public function __toString(): string
    {
        return sprintf(
            'shape%s_%s_%s',
            $this->getShape()?->value ?? '??',
            $this->getPart()?->value ?? '??',
            $this->getType()?->value ?? '??',
        );
    }
}
