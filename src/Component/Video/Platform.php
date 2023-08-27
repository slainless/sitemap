<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\Video;

use Assert\Assertion;

final class Platform implements PlatformInterface
{
    /**
     * @var string
     */
    private $relationship;

    /**
     * @var array
     */
    private $types = [];

    /**
     * @param string $relationship
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($relationship)
    {
        $choices = [
            PlatformInterface::RELATIONSHIP_ALLOW,
            PlatformInterface::RELATIONSHIP_DENY,
        ];

        Assertion::choice($relationship, $choices);

        $this->relationship = $relationship;
    }

    public function relationship()
    {
        return $this->relationship;
    }

    public function types()
    {
        return $this->types;
    }

    /**
     * @param array $types
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withTypes(array $types)
    {
        $choices = [
            PlatformInterface::TYPE_MOBILE,
            PlatformInterface::TYPE_TV,
            PlatformInterface::TYPE_WEB,
        ];

        Assertion::allChoice($types, $choices);
        Assertion::same($types, \array_unique($types));

        $instance = clone $this;

        $instance->types = $types;

        return $instance;
    }
    
    /**
     * @param string $relationship
     *
     * @throws \InvalidArgumentException
     *
     * @return Platform
     */
    public static function create($relationship) {
        return new Platform($relationship);
    }
}
