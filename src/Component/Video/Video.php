<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\Video;

use Assert\Assertion;

final class Video implements VideoInterface
{
    /**
     * @var string
     */
    private $thumbnailLocation;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string|null
     */
    private $contentLocation;

    /**
     * @var PlayerLocationInterface|null
     */
    private $playerLocation;

    /**
     * @var GalleryLocationInterface|null
     */
    private $galleryLocation;

    /**
     * @var int|null
     */
    private $duration;

    /**
     * @var \DateTimeInterface|null
     */
    private $publicationDate;

    /**
     * @var \DateTimeInterface|null
     */
    private $expirationDate;

    /**
     * @var float|null
     */
    private $rating;

    /**
     * @var int|null
     */
    private $viewCount;

    /**
     * @var string|null
     */
    private $familyFriendly;

    /**
     * @var TagInterface[]
     */
    private $tags = [];

    /**
     * @var string|null
     */
    private $category;

    /**
     * @var RestrictionInterface|null
     */
    private $restriction;

    /**
     * @var PriceInterface[]
     */
    private $prices = [];

    /**
     * @var string|null
     */
    private $requiresSubscription;

    /**
     * @var UploaderInterface|null
     */
    private $uploader;

    /**
     * @var PlatformInterface|null
     */
    private $platform;

    /**
     * @var string|null
     */
    private $live;

    /**
     * @param string                       $thumbnailLocation
     * @param string                       $title
     * @param string                       $description
     * @param string|null                  $contentLocation
     * @param PlayerLocationInterface|null $playerLocation
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        $thumbnailLocation,
        $title,
        $description,
        $contentLocation = null,
        PlayerLocationInterface $playerLocation = null
    ) {
        Assertion::maxLength($title, VideoInterface::TITLE_MAX_LENGTH);
        Assertion::maxLength($description, VideoInterface::DESCRIPTION_MAX_LENGTH);
        Assertion::false($contentLocation === null && $playerLocation === null, \sprintf(
            'At least one of parameters "%s" needs to be specified',
            \implode('", "', [
                'contentLocation',
                'playerLocation',
            ])
        ));

        $this->thumbnailLocation = $thumbnailLocation;
        $this->title = $title;
        $this->description = $description;
        $this->contentLocation = $contentLocation;
        $this->playerLocation = $playerLocation;
    }

    public function thumbnailLocation()
    {
        return $this->thumbnailLocation;
    }

    public function title()
    {
        return $this->title;
    }

    public function description()
    {
        return $this->description;
    }

    public function contentLocation()
    {
        return $this->contentLocation;
    }

    public function playerLocation()
    {
        return $this->playerLocation;
    }

    public function galleryLocation()
    {
        return $this->galleryLocation;
    }

    public function duration()
    {
        return $this->duration;
    }

    public function publicationDate()
    {
        return $this->publicationDate;
    }

    public function expirationDate()
    {
        return $this->expirationDate;
    }

    public function rating()
    {
        return $this->rating;
    }

    public function viewCount()
    {
        return $this->viewCount;
    }

    public function familyFriendly()
    {
        return $this->familyFriendly;
    }

    public function tags()
    {
        return $this->tags;
    }

    public function category()
    {
        return $this->category;
    }

    public function restriction()
    {
        return $this->restriction;
    }

    public function prices()
    {
        return $this->prices;
    }

    public function requiresSubscription()
    {
        return $this->requiresSubscription;
    }

    public function uploader()
    {
        return $this->uploader;
    }

    public function platform()
    {
        return $this->platform;
    }

    public function live()
    {
        return $this->live;
    }

    /**
     * @param GalleryLocationInterface $galleryLocation
     *
     * @return static
     */
    public function withGalleryLocation(GalleryLocationInterface $galleryLocation)
    {
        $instance = clone $this;

        $instance->galleryLocation = $galleryLocation;

        return $instance;
    }

    /**
     * @param int $duration
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withDuration($duration)
    {
        Assertion::integer($duration);
        Assertion::greaterThan($duration, VideoInterface::DURATION_LOWER_LIMIT);
        Assertion::lessThan($duration, VideoInterface::DURATION_UPPER_LIMIT);

        $instance = clone $this;

        $instance->duration = $duration;

        return $instance;
    }

    /**
     * @param \DateTimeInterface $publicationDate
     *
     * @return static
     */
    public function withPublicationDate(\DateTimeInterface $publicationDate)
    {
        $instance = clone $this;

        $instance->publicationDate = clone $publicationDate;

        return $instance;
    }

    /**
     * @param \DateTimeInterface $expirationDate
     *
     * @return static
     */
    public function withExpirationDate(\DateTimeInterface $expirationDate)
    {
        $instance = clone $this;

        $instance->expirationDate = clone $expirationDate;

        return $instance;
    }

    /**
     * @param float $rating
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withRating($rating)
    {
        Assertion::numeric($rating);
        Assertion::greaterOrEqualThan($rating, VideoInterface::RATING_MIN);
        Assertion::lessOrEqualThan($rating, VideoInterface::RATING_MAX);

        $instance = clone $this;

        $instance->rating = $rating;

        return $instance;
    }

    /**
     * @param int $viewCount
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withViewCount($viewCount)
    {
        Assertion::integer($viewCount);
        Assertion::greaterOrEqualThan($viewCount, VideoInterface::VIEW_COUNT_MIN);

        $instance = clone $this;

        $instance->viewCount = $viewCount;

        return $instance;
    }

    /**
     * @param string $familyFriendly
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withFamilyFriendly($familyFriendly)
    {
        Assertion::same($familyFriendly, VideoInterface::FAMILY_FRIENDLY_NO);

        $instance = clone $this;

        $instance->familyFriendly = $familyFriendly;

        return $instance;
    }

    /**
     * @param TagInterface[] $tags
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withTags(array $tags)
    {
        Assertion::allIsInstanceOf($tags, TagInterface::class);
        Assertion::lessOrEqualThan(\count($tags), VideoInterface::TAG_MAX_COUNT);

        $instance = clone $this;

        $instance->tags = $tags;

        return $instance;
    }

    /**
     * @param string $category
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withCategory($category)
    {
        Assertion::string($category);
        Assertion::maxLength($category, VideoInterface::CATEGORY_MAX_LENGTH);

        $instance = clone $this;

        $instance->category = $category;

        return $instance;
    }

    /**
     * @param RestrictionInterface $restriction
     *
     * @return static
     */
    public function withRestriction(RestrictionInterface $restriction)
    {
        $instance = clone $this;

        $instance->restriction = $restriction;

        return $instance;
    }

    /**
     * @param PriceInterface[] $prices
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withPrices($prices)
    {
        Assertion::allIsInstanceOf($prices, PriceInterface::class);

        $instance = clone $this;

        $instance->prices = $prices;

        return $instance;
    }

    /**
     * @param string $requiresSubscription
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withRequiresSubscription($requiresSubscription)
    {
        $choices = [
            VideoInterface::REQUIRES_SUBSCRIPTION_NO,
            VideoInterface::REQUIRES_SUBSCRIPTION_YES,
        ];

        Assertion::choice($requiresSubscription, $choices);

        $instance = clone $this;

        $instance->requiresSubscription = $requiresSubscription;

        return $instance;
    }

    /**
     * @param UploaderInterface $uploader
     *
     * @return static
     */
    public function withUploader(UploaderInterface $uploader)
    {
        $instance = clone $this;

        $instance->uploader = $uploader;

        return $instance;
    }

    /**
     * @param PlatformInterface $platform
     *
     * @return static
     */
    public function withPlatform(PlatformInterface $platform)
    {
        $instance = clone $this;

        $instance->platform = $platform;

        return $instance;
    }

    /**
     * @param string $live
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withLive($live)
    {
        $choices = [
            VideoInterface::LIVE_NO,
            VideoInterface::LIVE_YES,
        ];

        Assertion::choice($live, $choices);

        $instance = clone $this;

        $instance->live = $live;

        return $instance;
    }

    /**
     * @param string                       $thumbnailLocation
     * @param string                       $title
     * @param string                       $description
     * @param string|null                  $contentLocation
     * @param PlayerLocationInterface|null $playerLocation
     *
     * @throws \InvalidArgumentException
     * 
     * @return Video
     */
    public function create(
        $thumbnailLocation,
        $title,
        $description,
        $contentLocation = null,
        PlayerLocationInterface $playerLocation = null
    ) {
        return new Video($thumbnailLocation, $title, $description, $contentLocation, $playerLocation);
    }
}
