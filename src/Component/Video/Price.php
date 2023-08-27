<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\Video;

use Assert\Assertion;

final class Price implements PriceInterface
{
    /**
     * @var float
     */
    private $value;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $resolution;

    /**
     * @param float  $value
     * @param string $currency
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($value, $currency)
    {
        Assertion::float($value);
        Assertion::greaterOrEqualThan($value, PriceInterface::VALUE_MIN);

        $this->value = $value;
        $this->currency = $currency;
    }

    public function value()
    {
        return $this->value;
    }

    public function currency()
    {
        return $this->currency;
    }

    public function type()
    {
        return $this->type;
    }

    public function resolution()
    {
        return $this->resolution;
    }

    /**
     * @param string $type
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withType($type)
    {
        $choices = [
            PriceInterface::TYPE_OWN,
            PriceInterface::TYPE_RENT,
        ];

        Assertion::choice($type, $choices);

        $instance = clone $this;

        $instance->type = $type;

        return $instance;
    }

    /**
     * @param string $resolution
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withResolution($resolution)
    {
        $choices = [
            PriceInterface::RESOLUTION_HD,
            PriceInterface::RESOLUTION_SD,
        ];

        Assertion::choice($resolution, $choices);

        $instance = clone $this;

        $instance->resolution = $resolution;

        return $instance;
    }

    /**
     * @param float  $value
     * @param string $currency
     *
     * @throws \InvalidArgumentException
     *
     * @return Price
     */
    public static function create($value, $currency) {
        return new Price($value, $currency);
    }
}
