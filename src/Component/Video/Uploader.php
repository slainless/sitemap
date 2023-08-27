<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\Video;

use Assert\Assertion;

final class Uploader implements UploaderInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $info;

    /**
     * @param string $name
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($name)
    {
        Assertion::string($name);
        Assertion::notBlank($name);

        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }

    public function info()
    {
        return $this->info;
    }

    /**
     * @param string $info
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withInfo($info)
    {
        Assertion::string($info);
        Assertion::notBlank($info);

        $instance = clone $this;

        $instance->info = $info;

        return $instance;
    }
    
    /**
     * @param string $name
     *
     * @throws \InvalidArgumentException
     *
     * @return Uploader
     */
    public static function create($name) {
        return new Uploader($name);
    }
}
