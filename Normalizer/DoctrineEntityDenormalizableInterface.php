<?php

namespace Nervo\DoctrineEntitySerializer\Normalizer;

interface DoctrineEntityDenormalizableInterface
{
    public function denormalize(DoctrineEntityDenormalizerInterface $denormalizer, $data, $format = null);
}
