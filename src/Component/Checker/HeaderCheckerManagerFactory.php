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

namespace Jose\Component\Checker;

use Assert\Assertion;

class HeaderCheckerManagerFactory
{
    /**
     * @var HeaderChecker[]
     */
    private $checkers = [];

    /**
     * @var TokenTypeSupport[]
     */
    private $tokenTypes = [];

    /**
     * This method creates a Header Checker Manager and populate it with the header parameter checkers found based on the alias.
     * If the alias is not supported, an InvalidArgumentException is thrown.
     *
     * @param string[] $aliases
     */
    public function create(array $aliases): HeaderCheckerManager
    {
        $checkers = [];
        foreach ($aliases as $alias) {
            Assertion::keyExists($this->checkers, $alias, \Safe\sprintf('The header checker with the alias "%s" is not supported.', $alias));
            $checkers[] = $this->checkers[$alias];
        }

        return new HeaderCheckerManager($checkers, $this->tokenTypes);
    }

    /**
     * This method adds a header parameter checker to this factory.
     * The checker is uniquely identified by an alias. This allows the same header parameter checker to be added twice (or more)
     * using several configuration options.
     */
    public function add(string $alias, HeaderChecker $checker): void
    {
        $this->checkers[$alias] = $checker;
    }

    /**
     * This method adds a token type support to this factory.
     */
    public function addTokenTypeSupport(TokenTypeSupport $tokenType): void
    {
        $this->tokenTypes[] = $tokenType;
    }

    /**
     * Returns all header parameter checker aliases supported by this factory.
     *
     * @return string[]
     */
    public function aliases(): array
    {
        return \array_keys($this->checkers);
    }

    /**
     * Returns all header parameter checkers supported by this factory.
     *
     * @return HeaderChecker[]
     */
    public function all(): array
    {
        return $this->checkers;
    }
}
