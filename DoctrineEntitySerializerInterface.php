<?php

namespace Nervo\DoctrineEntitySerializer;

use Doctrine\ORM\EntityManager;

interface DoctrineEntitySerializerInterface
{
    /**
     * Get entity manager
     * 
     * @return EntityManager
     */
    public function getEntityManager();
}
