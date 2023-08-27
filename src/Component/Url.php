<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component;

use Assert\Assertion;
use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\Video\VideoInterface;

final class Url implements UrlInterface
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var string|null
     */
    private $lastModified;

    /**
     * @var string|null
     */
    private $changeFrequency;

    /**
     * @var string|null
     */
    private $priority;

    /**
     * @var ImageInterface[]
     */
    private $images = [];

    /**
     * @var NewsInterface[]
     */
    private $news = [];

    /**
     * @var VideoInterface[]
     */
    private $videos = [];

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

    public function changeFrequency()
    {
        return $this->changeFrequency;
    }

    public function priority()
    {
        return $this->priority;
    }

    public function images()
    {
        return $this->images;
    }

    public function news()
    {
        return $this->news;
    }

    public function videos()
    {
        return $this->videos;
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
     * @param string $changeFrequency
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withChangeFrequency($changeFrequency)
    {
        $choices = [
            UrlInterface::CHANGE_FREQUENCY_ALWAYS,
            UrlInterface::CHANGE_FREQUENCY_HOURLY,
            UrlInterface::CHANGE_FREQUENCY_DAILY,
            UrlInterface::CHANGE_FREQUENCY_WEEKLY,
            UrlInterface::CHANGE_FREQUENCY_MONTHLY,
            UrlInterface::CHANGE_FREQUENCY_YEARLY,
            UrlInterface::CHANGE_FREQUENCY_NEVER,
        ];

        Assertion::choice($changeFrequency, $choices);

        $instance = clone $this;

        $instance->changeFrequency = $changeFrequency;

        return $instance;
    }

    /**
     * @param float $priority
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withPriority($priority)
    {
        Assertion::float($priority);
        Assertion::greaterOrEqualThan($priority, UrlInterface::PRIORITY_MIN);
        Assertion::lessOrEqualThan($priority, UrlInterface::PRIORITY_MAX);
        Assertion::same($priority, \round($priority, 1));

        $instance = clone $this;

        $instance->priority = $priority;

        return $instance;
    }

    /**
     * @param ImageInterface[] $images
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withImages(array $images)
    {
        Assertion::allIsInstanceOf($images, ImageInterface::class);
        Assertion::lessOrEqualThan(\count($this->images), UrlInterface::IMAGE_MAX_COUNT);

        $instance = clone $this;

        $instance->images = $images;

        return $instance;
    }

    /**
     * @param NewsInterface[] $news
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withNews(array $news)
    {
        Assertion::allIsInstanceOf($news, NewsInterface::class);

        $instance = clone $this;

        $instance->news = $news;

        return $instance;
    }

    /**
     * @param VideoInterface[] $videos
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withVideos(array $videos)
    {
        Assertion::allIsInstanceOf($videos, VideoInterface::class);

        $instance = clone $this;

        $instance->videos = $videos;

        return $instance;
    }
    
    /**
     * @param string $location
     *
     * @throws \InvalidArgumentException
     *
     * @return Url
     */
    public static function create($location) {
        return new Url($location);
    }
}
