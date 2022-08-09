<?php

/*
 * This file is part of the embedded-json package.
 *
 * (c) Benjamin Georgeault
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Doctrine\EventSubscriber;

use App\Doctrine\Attributes\Serializable;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class MappingSerializableSubscriber
 *
 * @author Benjamin Georgeault
 */
class MappingSerializableSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $event): void
    {
        /** @var ClassMetadata $metadata */
        $metadata = $event->getClassMetadata();
        $refClass = $metadata->getReflectionClass();

        foreach ($metadata->getFieldNames() as $fieldName) {
            $refProp = $refClass->getProperty($fieldName);
            $this->updateMapping($metadata, $fieldName, $refProp->getAttributes(Serializable::class));
        }
    }

    /**
     * @param array<\ReflectionAttribute<Serializable>> $serializables
     */
    private function updateMapping(ClassMetadata $metadata, string $fieldName, array $serializables): void
    {
        $serializableMapping = [];

        foreach ($serializables as $config) {
            /** @var Serializable $serializable */
            $serializable = $config->newInstance();

            $serializableMapping[] = [
                'class' => $serializable->getClass(),
                'target_property' => $serializable->getTargetProperty(),
                'groups' => $serializable->getGroups(),
                'context' => $serializable->getContext(),
                'collection' => $serializable->isCollection(),
            ];
        }

        if (!empty($serializableMapping)) {
            // Add serialization mapping info to Doctrine mapping.
            // Prevent to reload it at each app request.
            $metadata->fieldMappings[$fieldName]['serializable_json'] = $serializableMapping;
        }
    }
}
