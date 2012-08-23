<?php

namespace Nervo\DoctrineEntitySerializer;

use Symfony\Component\Serializer\Serializer;

use Nervo\DoctrineEntitySerializer\Normalizer\DoctrineEntityNormalizerInterface;
use Nervo\DoctrineEntitySerializer\Normalizer\DoctrineEntityDenormalizerInterface;

use Doctrine\ORM\EntityManager;

class DoctrineEntitySerializer extends Serializer implements DoctrineEntitySerializerInterface, DoctrineEntityNormalizerInterface, DoctrineEntityDenormalizerInterface
{
    /**
     * Entity manager
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param array $normalizers
     * @param array $encoders
     */
    public function __construct(EntityManager $entityManager, array $normalizers = array(), array $encoders = array())
    {
        $this->entityManager = $entityManager;

        parent::__construct($normalizers, $encoders);

        foreach ($this->normalizers as $normalizer) {
            if ($normalizer instanceof DoctrineEntitySerializerAwareInterface) {
                $normalizer->setSerializer($this);
            }
        }
    }

    /**
     * Get entity manager
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $type, $format = null)
    {
        // Use alias namespace ?
        if (strrpos($type, ':') !== false) {
            list($namespaceAlias, $simpleClassName) = explode(':', $type);

            $type = $this->entityManager->getConfiguration()->getEntityNamespace($namespaceAlias) . '\\' . $simpleClassName;
        }

        return parent::denormalize($data, $type, $format);
    }
}
