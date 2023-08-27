<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\Image;

use Assert\Assertion;

final class Image implements ImageInterface
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var string|null
     */
    private $caption;

    /**
     * @var string|null
     */
    private $geoLocation;

    /**
     * @var string|null
     */
    private $licence;

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

    public function title()
    {
        return $this->title;
    }

    public function caption()
    {
        return $this->caption;
    }

    public function geoLocation()
    {
        return $this->geoLocation;
    }

    public function licence()
    {
        return $this->licence;
    }

    /**
     * @param string $title
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withTitle($title)
    {
        Assertion::string($title);
        Assertion::notBlank($title);

        $instance = clone $this;

        $instance->title = $title;

        return $instance;
    }

    /**
     * @param string $caption
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withCaption($caption)
    {
        Assertion::string($caption);
        Assertion::notBlank($caption);

        $instance = clone $this;

        $instance->caption = $caption;

        return $instance;
    }

    /**
     * @param string $geoLocation
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withGeoLocation($geoLocation)
    {
        Assertion::string($geoLocation);
        Assertion::notBlank($geoLocation);

        $instance = clone $this;

        $instance->geoLocation = $geoLocation;

        return $instance;
    }

    /**
     * @param string $licence
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withLicence($licence)
    {
        Assertion::string($licence);
        Assertion::notBlank($licence);

        $instance = clone $this;

        $instance->licence = $licence;

        return $instance;
    }

    /**
     * @param string $location
     *
     * @throws \InvalidArgumentException
     *
     * @return Image
     */
    public static function create($location) {
        return new Image($location);
    }
}
