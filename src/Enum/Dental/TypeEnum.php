<?php

/*
 * This file is part of the embedded-json package.
 *
 * (c) Benjamin Georgeault
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Enum\Dental;

/**
 * Enum TypeEnum
 *
 * @author Benjamin Georgeault
 */
enum TypeEnum: string
{
    case CLEAN = 'clean';
    case CARRIE = 'carrie';
    case MISSING = 'missing';
    case ROOT = 'root';
    case MOVABLE = 'movable';
}
