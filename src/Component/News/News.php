<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component\News;

use Assert\Assertion;

final class News implements NewsInterface
{
    /**
     * @var PublicationInterface
     */
    private $publication;

    /**
     * @var \DateTimeInterface
     */
    private $publicationDate;

    /**
     * @var string
     */
    private $title;

    /**
     * @var bool
     */
    private $access;

    /**
     * @var array
     */
    private $genres = [];

    /**
     * @var array
     */
    private $keywords = [];

    /**
     * @var array
     */
    private $stockTickers = [];

    /**
     * @param PublicationInterface $publication
     * @param \DateTimeInterface   $publicationDate
     * @param string               $title
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(PublicationInterface $publication, \DateTimeInterface $publicationDate, $title)
    {
        Assertion::string($title);
        Assertion::notBlank($title);

        $this->publication = $publication;
        $this->publicationDate = $publicationDate;
        $this->title = $title;
    }

    public function publication()
    {
        return $this->publication;
    }

    public function publicationDate()
    {
        return clone $this->publicationDate;
    }

    public function title()
    {
        return $this->title;
    }

    public function access()
    {
        return $this->access;
    }

    public function genres()
    {
        return $this->genres;
    }

    public function keywords()
    {
        return $this->keywords;
    }

    public function stockTickers()
    {
        return $this->stockTickers;
    }

    /**
     * @param string $access
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withAccess($access)
    {
        $choices = [
            NewsInterface::ACCESS_REGISTRATION,
            NewsInterface::ACCESS_SUBSCRIPTION,
        ];

        Assertion::choice($access, $choices);

        $instance = clone $this;

        $instance->access = $access;

        return $instance;
    }

    /**
     * @param array $genres
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withGenres(array $genres)
    {
        $choices = [
            NewsInterface::GENRE_BLOG,
            NewsInterface::GENRE_OP_ED,
            NewsInterface::GENRE_OPINION,
            NewsInterface::GENRE_SATIRE,
            NewsInterface::GENRE_USER_GENERATED,
        ];

        Assertion::allChoice($genres, $choices);
        Assertion::same($genres, \array_unique($genres));

        $instance = clone $this;

        $instance->genres = $genres;

        return $instance;
    }

    /**
     * @param array $keywords
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withKeywords(array $keywords)
    {
        Assertion::allString($keywords);
        Assertion::allNotBlank($keywords);

        $instance = clone $this;

        $instance->keywords = $keywords;

        return $instance;
    }

    /**
     * @param array $stockTickers
     *
     * @throws \InvalidArgumentException
     *
     * @return static
     */
    public function withStockTickers(array $stockTickers)
    {
        Assertion::allString($stockTickers);
        Assertion::allNotBlank($stockTickers);
        Assertion::lessOrEqualThan(\count($stockTickers), NewsInterface::STOCK_TICKERS_MAX_COUNT);

        $instance = clone $this;

        $instance->stockTickers = $stockTickers;

        return $instance;
    }
    
    /**
     * @param PublicationInterface $publication
     * @param \DateTimeInterface   $publicationDate
     * @param string               $title
     *
     * @throws \InvalidArgumentException
     *
     * @return News
     */
    public static function create(PublicationInterface $publication, \DateTimeInterface $publicationDate, $title) {
        return new News($publication, $publicationDate, $title);
    }
}
