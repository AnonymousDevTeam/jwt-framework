<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2019 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Jose\Component\Signature\Serializer;

use Assert\Assertion;

class JWSSerializerManagerFactory
{
    /**
     * @var JWSSerializer[]
     */
    private $serializers = [];

    /**
     * @param string[] $names
     */
    public function create(array $names): JWSSerializerManager
    {
        $serializers = [];
        foreach ($names as $name) {
            Assertion::keyExists($this->serializers, $name, \Safe\sprintf('Unsupported serialiser "%s".', $name));
            $serializers[] = $this->serializers[$name];
        }

        return new JWSSerializerManager($serializers);
    }

    /**
     * @return string[]
     */
    public function names(): array
    {
        return \array_keys($this->serializers);
    }

    /**
     * @return JWSSerializer[]
     */
    public function all(): array
    {
        return $this->serializers;
    }

    public function add(JWSSerializer $serializer): void
    {
        $this->serializers[$serializer->name()] = $serializer;
    }
}
