<?php

namespace Nervo\DoctrineEntitySerializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;

abstract class DoctrineEntityCustomNormalizer extends DoctrineEntitySerializerAwareNormalizer  implements NormalizerInterface, DenormalizerInterface
{
    protected $normalizerClassMetadataCache = array();
    
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null)
    {
        return $object->normalize($this->serializer, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null)
    {
        $object = new $class;
        $object->denormalize($this->serializer, $data, $format);

        return $object;
    }
    
    /**
     * Checks if the given class implements the NormalizableInterface.
     *
     * @param mixed  $data   Data to normalize.
     * @param string $format The format being (de-)serialized from or into.
     * @return Boolean
     */
    public function supportsNormalization($data, $format = null)
    {
        $class = get_class($data);
        
        if (isset($this->normalizerClassMetadataCache[$class][$format])) {
            return (boolean) $this->normalizerClassMetadataCache[$class][$format];
        }
        
        if ($data instanceof NormalizableInterface) {
            $this->normalizerClassMetadataCache[$class][$format] = $this->serializer->getEntityManager()->getClassMetadata($class);
        } else {
            $this->normalizerClassMetadataCache[$class][$format] = null;
        }
        
        return (boolean) $this->normalizerClassMetadataCache[$class][$format];;
    }
    
    /**
     * {@inheritdoc}
     */
    
    /*
    public function supportsDenormalization($data, $type, $format = null)
    {
        $class = new \ReflectionClass($type);

        return $class->isSubclassOf('Symfony\Component\Serializer\Normalizer\DenormalizableInterface');
    }
    */
    
    /**
     * Checks if the given class implements the NormalizableInterface.
     *
     * @param mixed  $data   Data to denormalize from.
     * @param string $type   The class to which the data should be denormalized.
     * @param string $format The format being deserialized from.
     * @return Boolean
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        $class = new \ReflectionClass($type);

        return $class->isSubclassOf('Symfony\Component\Serializer\Normalizer\DenormalizableInterface');
    }
}
