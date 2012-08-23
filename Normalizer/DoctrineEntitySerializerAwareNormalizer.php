<?php

namespace Nervo\DoctrineEntitySerializer\Normalizer;

use Nervo\DoctrineEntitySerializer\DoctrineEntitySerializerAwareInterface;
use Nervo\DoctrineEntitySerializer\DoctrineEntitySerializerInterface;

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

    /**
     * {@inheritdoc}
     */
    public function getEntityManager()
    {
        return $this->serializer->getEntityManager();
    }
}

