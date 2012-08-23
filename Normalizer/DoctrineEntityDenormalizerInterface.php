<?php

namespace Nervo\DoctrineEntitySerializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

interface DoctrineEntityDenormalizerInterface extends DenormalizerInterface
{
    /**
     * Get entity manager
     *
     * @return EntityManager
     */
    public function getEntityManager();
}

