<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component;

use Assert\Assertion;

final class Sitemap implements SitemapInterface
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var \DateTimeInterface|null
     */
    private $lastModified;

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

    public function lastModified()
    {
        return $this->lastModified;
    }

    /**
     * @param \DateTimeInterface $lastModified
     *
     * @return static
     */
    public function withLastModified(\DateTimeInterface $lastModified)
    {
        $instance = clone $this;

        $instance->lastModified = clone $lastModified;

        return $instance;
    }
    
    /**
     * @param string $location
     *
     * @throws \InvalidArgumentException
     *
     * @return Sitemap
     */
    public static function create($location) {
        return new Sitemap($location);
    }
}
