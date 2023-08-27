<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Component;

use Slainless\Sitemap\Component\AltInterface;

/**
 * @link https://support.google.com/webmasters/answer/183668?hl=en
 * @link http://www.sitemaps.org/protocol.html#xmlTagDefinitions
 */
interface UrlInterface
{
    /**
     * Constants for change frequencies.
     *
     * @link http://www.sitemaps.org/protocol.html#xmlTagDefinitions
     */
    const CHANGE_FREQUENCY_ALWAYS = 'always';
    const CHANGE_FREQUENCY_HOURLY = 'hourly';
    const CHANGE_FREQUENCY_DAILY = 'daily';
    const CHANGE_FREQUENCY_WEEKLY = 'weekly';
    const CHANGE_FREQUENCY_MONTHLY = 'monthly';
    const CHANGE_FREQUENCY_YEARLY = 'yearly';
    const CHANGE_FREQUENCY_NEVER = 'never';

    /**
     * Constants for minimum and maximum priority.
     *
     * @link http://www.sitemaps.org/protocol.html#xmlTagDefinitions
     */
    const PRIORITY_MIN = 0.0;
    const PRIORITY_MAX = 1.0;

    /**
     * Constant for maximum number of images.
     *
     * @link https://support.google.com/webmasters/answer/178636?hl=en
     */
    const IMAGE_MAX_COUNT = 1000;

    /**
     * @return string
     */
    public function location();

    /**
     * @return \DateTimeInterface|null
     */
    public function lastModified();

    /**
     * @return string|null
     */
    public function changeFrequency();

    /**
     * @return string|null
     */
    public function priority();

    /**
     * @return Image\ImageInterface[]
     */
    public function images();

    /**
     * @return News\NewsInterface[]
     */
    public function news();

    /**
     * @return Video\VideoInterface[]
     */
    public function videos();
    
    /**
     * @return AltInterface[]
     */
    public function alternatives();
}
