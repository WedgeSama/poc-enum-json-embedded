<?php

/*
 * This file is part of the embedded-json package.
 *
 * (c) Benjamin Georgeault
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig\Extension;

use App\Twig\Runtime\SerializerRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class SerializerExtension
 *
 * @author Benjamin Georgeault
 */
class SerializerExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('serialize', [SerializerRuntime::class, 'serialize']),
        ];
    }
}
