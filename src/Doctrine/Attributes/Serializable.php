<?php

/*
 * This file is part of the embedded-json package.
 *
 * (c) Benjamin Georgeault
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Doctrine\Attributes;

/**
 * Class Serializable
 *
 * @author Benjamin Georgeault
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Serializable
{
    private array $groups;

    public function __construct(
        private string $targetProperty,
        private string $class,
        private bool   $collection = false,
        array|string   $groups = [],
        private array  $context = [],
    ) {
        $this->groups = (array) $groups;
    }

    public function getTargetProperty(): string
    {
        return $this->targetProperty;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function isCollection(): bool
    {
        return $this->collection;
    }

    /** @return string[] */
    public function getGroups(): array
    {
        return $this->groups;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
