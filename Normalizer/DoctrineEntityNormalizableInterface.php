<?php

namespace Nervo\DoctrineEntitySerializer\Normalizer;

interface DoctrineEntityNormalizableInterface
{
    public function normalize(DoctrineEntityNormalizerInterface $normalizer, $format = null);
}
