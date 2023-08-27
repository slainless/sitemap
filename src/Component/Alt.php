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
    public function __construct($location, $language)
    {
        Assertion::url($location);
        Assertion::string($language);
        Assertion::notBlank($language);

        $this->location = $location;
        $this->language = $language;
    }

    public function location()
    {
        return $this->location;
    }

    public function language()
    {
        return $this->language;
    }
}
