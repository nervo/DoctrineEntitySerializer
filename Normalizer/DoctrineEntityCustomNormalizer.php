<?php

namespace Nervo\DoctrineEntitySerializer\Normalizer;

use Nervo\DoctrineEntitySerializer\Normalizer\DoctrineEntityNormalizableInterface;
use Nervo\DoctrineEntitySerializer\Normalizer\DoctrineEntityNormalizerInterface;
use Nervo\DoctrineEntitySerializer\Normalizer\DoctrineEntityDenormalizableInterface;
use Nervo\DoctrineEntitySerializer\Normalizer\DoctrineEntityDenormalizerInterface;

use Doctrine\ORM\Mapping\MappingException;

class DoctrineEntityCustomNormalizer extends DoctrineEntitySerializerAwareNormalizer implements DoctrineEntityNormalizerInterface, DoctrineEntityDenormalizerInterface
{
    protected $classMetadataCache = array();

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null)
    {
        $data = $object->normalize($this->serializer, $format);

        $classMetadata = $this->classMetadataCache[get_class($object)][$format];

        if (!$classMetadata->isInheritanceTypeNone()) {
            $data[$classMetadata->discriminatorColumn['name']] = $classMetadata->discriminatorValue;
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null)
    {
        $classMetadata = $this->classMetadataCache[$class][$format];

        if (!$classMetadata->isInheritanceTypeNone()) {
            $discriminatorColumnName = $classMetadata->discriminatorColumn['name'];

            if (isset($data[$discriminatorColumnName]) && isset($classMetadata->discriminatorMap[$data[$discriminatorColumnName]])) {
                $class = $classMetadata->discriminatorMap[$data[$discriminatorColumnName]];
            }
        }

        $object = new $class;
        $object->denormalize($this->serializer, $data, $format);

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        $class = get_class($data);

        if (isset($this->classMetadataCache[$class][$format])) {
            return (boolean) $this->classMetadataCache[$class][$format];
        }

        if ($data instanceof DoctrineEntityNormalizableInterface) {
            try {
                $this->classMetadataCache[$class][$format] = $this->serializer->getEntityManager()->getClassMetadata($class);
            } catch (MappingException $e) {
                $this->classMetadataCache[$class][$format] = null;
            }
        } else {
            $this->classMetadataCache[$class][$format] = null;
        }

        return (boolean) $this->classMetadataCache[$class][$format];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if (isset($this->classMetadataCache[$type][$format])) {
            return (boolean) $this->classMetadataCache[$type][$format];
        }

        $class = new \ReflectionClass($type);

        if ($class->isSubclassOf('Nervo\DoctrineEntitySerializer\Normalizer\DoctrineEntityDenormalizableInterface')) {
            try {
                $this->classMetadataCache[$type][$format] = $this->serializer->getEntityManager()->getClassMetadata($type);
            } catch (MappingException $e) {
                $this->classMetadataCache[$type][$format] = null;
            }
        } else {
            $this->classMetadataCache[$type][$format] = null;
        }

        return (boolean) $this->classMetadataCache[$type][$format];
    }
}

