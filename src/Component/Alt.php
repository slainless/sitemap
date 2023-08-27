<?php

/*
 * Copyright (c) 2023 slainless@github.com.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Slainless\Sitemap\Component;

use Assert\Assertion;

final class Alt implements AltInterface
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var string|null
     */
    private $language;

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

    public function language()
    {
        return $this->language;
    }

    /**
     * @param string $title
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withLanguage($language)
    {
        Assertion::string($language);
        Assertion::notBlank($language);

        $instance = clone $this;

        $instance->language = $language;

        return $instance;
    }

    /**
     * @param string $location
     *
     * @throws \InvalidArgumentException
     *
     * @return Alt
     */
    public static function create($location) {
        return new Alt($location);
    }
}
