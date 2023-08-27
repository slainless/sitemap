<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer;

use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\UrlInterface;
use Refinery29\Sitemap\Component\Video\VideoInterface;
use Refinery29\Sitemap\Component\AltInterface;
use Refinery29\Sitemap\Writer\Image\ImageWriter;
use Refinery29\Sitemap\Writer\News\NewsWriter;
use Refinery29\Sitemap\Writer\Video\VideoWriter;
use Slainless\Sitemap\Writer\AltWriter;

/**
 * @link https://support.google.com/webmasters/answer/183668?hl=en
 *
 * @internal
 */
class UrlWriter
{
    /**
     * @var ImageWriter
     */
    private $imageWriter;

    /**
     * @var NewsWriter
     */
    private $newsWriter;

    /**
     * @var VideoWriter
     */
    private $videoWriter;

    /**
     * @var AltWriter
     */
    private $altWriter;

    public function __construct(
        ImageWriter $imageWriter = null,
        NewsWriter $newsWriter = null,
        VideoWriter $videoWriter = null,
        AltWriter $altWriter = null
    ) {
        $this->imageWriter = $imageWriter ?: new ImageWriter();
        $this->newsWriter = $newsWriter ?: new NewsWriter();
        $this->videoWriter = $videoWriter ?: new VideoWriter();
        $this->altWriter = $altWriter ?: new AltWriter();
    }

    public function write(UrlInterface $url, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('url');

        $this->writeLocation($xmlWriter, $url->location());
        $this->writeLastModified($xmlWriter, $url->lastModified());
        $this->writeChangeFrequency($xmlWriter, $url->changeFrequency());
        $this->writePriority($xmlWriter, $url->priority());
        $this->writeImages($xmlWriter, $url->images());
        $this->writeNews($xmlWriter, $url->news());
        $this->writeVideos($xmlWriter, $url->videos());
        $this->writeAlternatives($xmlWriter, $url->alternatives());

        $xmlWriter->endElement();
    }

    private function writeLocation(\XMLWriter $xmlWriter, $location)
    {
        $xmlWriter->startElement('loc');
        $xmlWriter->text($location);
        $xmlWriter->endElement();
    }

    private function writeLastModified(\XMLWriter $xmlWriter, \DateTimeInterface $lastModified = null)
    {
        if ($lastModified === null) {
            return;
        }

        $xmlWriter->startElement('lastmod');
        $xmlWriter->text($lastModified->format('c'));
        $xmlWriter->endElement();
    }

    private function writeChangeFrequency(\XMLWriter $xmlWriter, $changeFrequency = null)
    {
        if ($changeFrequency === null) {
            return;
        }

        $xmlWriter->startElement('changefreq');
        $xmlWriter->text($changeFrequency);
        $xmlWriter->endElement();
    }

    private function writePriority(\XMLWriter $xmlWriter, $priority = null)
    {
        if ($priority === null) {
            return;
        }

        $xmlWriter->startElement('priority');
        $xmlWriter->text(\number_format($priority, 1));
        $xmlWriter->endElement();
    }

    /**
     * @param \XMLWriter       $xmlWriter
     * @param ImageInterface[] $images
     */
    private function writeImages(\XMLWriter $xmlWriter, array $images = [])
    {
        foreach ($images as $image) {
            $this->imageWriter->write($image, $xmlWriter);
        }
    }

    /**
     * @param \XMLWriter      $xmlWriter
     * @param NewsInterface[] $news
     */
    private function writeNews(\XMLWriter $xmlWriter, array $news = [])
    {
        foreach ($news as $pieceOfNews) {
            $this->newsWriter->write($pieceOfNews, $xmlWriter);
        }
    }

    /**
     * @param \XMLWriter       $xmlWriter
     * @param VideoInterface[] $videos
     */
    private function writeVideos(\XMLWriter $xmlWriter, array $videos = [])
    {
        foreach ($videos as $video) {
            $this->videoWriter->write($video, $xmlWriter);
        }
    }
    
    /**
     * @param \XMLWriter       $xmlWriter
     * @param AltInterface[] $alts
     */
    private function writeAlternatives(\XMLWriter $xmlWriter, array $alts = [])
    {
        foreach ($alts as $alt) {
            $this->altWriter->write($alt, $xmlWriter);
        }
    }
}
