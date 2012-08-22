<?php

namespace Nervo\DoctrineEntitySerializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

abstract class DoctrineEntitySerializerAwareNormalizer implements DoctrineEntitySerializerAwareInterface
{
    /**
     * @var DoctrineEntitySerializerInterface
     */
    protected $serializer;
    
    /**
     * {@inheritdoc}
     */
    public function setSerializer(DoctrineEntitySerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
}
