<?php

/*
 * This file is part of the embedded-json package.
 *
 * (c) Benjamin Georgeault
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig\Runtime;

use Symfony\Component\Serializer\SerializerInterface;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Class SerializerRuntime
 *
 * @author Benjamin Georgeault
 */
class SerializerRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private SerializerInterface $serializer,
    ) {}

    public function serialize(mixed $data, array|string|null $groups = null, string $format = 'json', array $context = [], bool $pretty = true): string
    {
        if (!empty($groups)) {
            $context['groups'] = (array) $groups;
        }

        if ($pretty) {
            $context['json_encode_options'] = \JSON_PRETTY_PRINT;
        }

        return $this->serializer->serialize($data, $format, $context);
    }
}
