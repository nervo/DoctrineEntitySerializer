<?php

namespace Nervo\DoctrineEntitySerializer\Normalizer;

use PapierCarbone\Bundle\Serializer\DoctrineEntityCustomNormalizer;

abstract class DoctrineInheritableEntityCustomNormalizer extends DoctrineEntityCustomNormalizer
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null)
    {
        $data = parent::normalize($object, $format);
        
        $discriminatorColumn = $this->normalizerClassMetadataCache[get_class($object)][$format]->discriminatorColumn;
        
        if ($discriminatorColumn) {
            $data[$discriminatorColumn['name']] = $this->normalizerClassMetadataCache[get_class($object)][$format]->discriminatorValue;
        }
        
        return $data;
    }
}
