<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\Video;

use Assert\Assertion;

final class PlayerLocation implements PlayerLocationInterface
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var string|null
     */
    private $allowEmbed;

    /**
     * @var string|null
     */
    private $autoPlay;

    /**
     * @param string $location
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($location)
    {
        Assertion::url($location);

        $this->location = $location;
    }

    public function location()
    {
        return $this->location;
    }

    public function allowEmbed()
    {
        return $this->allowEmbed;
    }

    public function autoPlay()
    {
        return $this->autoPlay;
    }

    /**
     * @param string $allowEmbed
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withAllowEmbed($allowEmbed)
    {
        $choices = [
            PlayerLocationInterface::ALLOW_EMBED_NO,
            PlayerLocationInterface::ALLOW_EMBED_YES,
        ];

        Assertion::choice($allowEmbed, $choices);

        $instance = clone $this;

        $instance->allowEmbed = $allowEmbed;

        return $instance;
    }

    /**
     * @param string $autoPlay
     *
     * @return static
     */
    public function withAutoPlay($autoPlay)
    {
        $instance = clone $this;

        $instance->autoPlay = $autoPlay;

        return $instance;
    }
    
    /**
     * @param string $location
     *
     * @throws \InvalidArgumentException
     *
     * @return PlayerLocation
     */
    public static function create($location) {
        return new PlayerLocation($location);
    }
}
