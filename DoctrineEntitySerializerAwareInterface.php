<?php

namespace Nervo\DoctrineEntitySerializer;

interface DoctrineEntitySerializerAwareInterface
{
    /**
     * Sets the owning Serializer object
     *
     * @param DoctrineEntitySerializerInterface $serializer
     */
    public function setSerializer(DoctrineEntitySerializerInterface $serializer);
}
