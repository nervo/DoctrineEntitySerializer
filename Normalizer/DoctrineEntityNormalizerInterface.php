<?php

namespace Nervo\DoctrineEntitySerializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

interface DoctrineEntityNormalizerInterface extends NormalizerInterface
{
    /**
     * Get entity manager
     *
     * @return EntityManager
     */
    public function getEntityManager();
}

