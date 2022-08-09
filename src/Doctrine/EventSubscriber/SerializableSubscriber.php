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

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class SerializableSubscriber
 *
 * @author Benjamin Georgeault
 */
class SerializableSubscriber implements EventSubscriber
{
    private ?PropertyAccessor $propertyAccessor = null;

    public function __construct(
        private SerializerInterface $serializer,
    ) {
        if (!$this->serializer instanceof NormalizerInterface) {
            throw new \InvalidArgumentException(sprintf(
                'The given serializer for "%s" must implement "%s".',
            static::class,
                NormalizerInterface::class,
            ));
        }

        if (!$this->serializer instanceof DenormalizerInterface) {
            throw new \InvalidArgumentException(sprintf(
                'The given serializer for "%s" must implement "%s".',
            static::class,
                DenormalizerInterface::class,
            ));
        }
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::preUpdate,
            Events::prePersist,
            Events::postUpdate,
            Events::postPersist,
            Events::postLoad,
        ];
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->doSerialize($args);
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->doSerialize($args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->doDeserialize($args);
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->doDeserialize($args);
    }

    public function postLoad(LifecycleEventArgs $args): void
    {
        $this->doDeserialize($args);
    }

    private function doSerialize(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $metadata = $this->getClassMetadata($entity, $args);

        foreach ($metadata->getFieldNames() as $fieldName) {
            $mapping = $metadata->getFieldMapping($fieldName);
            if (array_key_exists('serializable_json', $mapping)) {
                foreach ($mapping['serializable_json'] as $serializableMapping) {
                    $value = $this->getPropertyAccessor()->getValue($entity, $serializableMapping['target_property']);
                    $normalizedValue = $this->serializer->normalize($value, 'json');
                    $this->getPropertyAccessor()->setValue($entity, $fieldName, $normalizedValue);
                }
            }
        }
    }

    private function doDeserialize(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $metadata = $this->getClassMetadata($entity, $args);

        foreach ($metadata->getFieldNames() as $fieldName) {
            $mapping = $metadata->getFieldMapping($fieldName);
            if (array_key_exists('serializable_json', $mapping)) {
                foreach ($mapping['serializable_json'] as $serializableMapping) {
                    $value = $this->getPropertyAccessor()->getValue($entity, $fieldName);

                    $type = $serializableMapping['class'];
                    if ($serializableMapping['collection']) {
                        $type .= '[]';
                    }

                    $denormalizedValue = $this->serializer->denormalize($value, $type, 'json');
                    $this->getPropertyAccessor()->setValue($entity, $serializableMapping['target_property'], $denormalizedValue);
                }
            }
        }
    }

    private function getClassMetadata(object $entity, LifecycleEventArgs $args): ClassMetadata
    {
        $om = $args->getObjectManager();
        return $om->getClassMetadata($entity::class);
    }

    private function getPropertyAccessor(): PropertyAccessor
    {
        if (null === $this->propertyAccessor) {
            $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        return $this->propertyAccessor;
    }
}
