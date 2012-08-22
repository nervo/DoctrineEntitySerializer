<?php

namespace Nervo\DoctrineEntitySerializer;

use Symfony\Component\Serializer\Serializer;

use Doctrine\ORM\EntityManager;

class DoctrineEntitySerializer extends Serializer implements DoctrineEntitySerializerInterface
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
        
        parent::__construct(array(), $encoders);
        
        foreach ($normalizers as $normalizer) {
            if ($normalizer instanceof DoctrineEntitySerializerAwareInterface) {
                $normalizer->setSerializer($this);
            }
        }

        $this->normalizers = $normalizers;
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
    /*
    public function denormalize($data, $type, $format = null)
    {
        var_dump('ahahah');
        die;
        return $this->denormalizeObject($data, $type, $format);
    }
    */
}
