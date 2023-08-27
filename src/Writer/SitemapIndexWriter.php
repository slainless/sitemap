<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer;

use Assert\Assertion;
use Refinery29\Sitemap\Component\SitemapIndexInterface;

/**
 * @link https://support.google.com/webmasters/answer/75712?rd=1
 */
class SitemapIndexWriter
{
    /**
     * @var SitemapWriter
     */
    private $sitemapWriter;

    /**
     * @var \XMLWriter
     */
    private $xmlWriter;

    public function __construct(SitemapWriter $sitemapWriter = null)
    {
        $this->sitemapWriter = $sitemapWriter ?: new SitemapWriter();
        $this->xmlWriter = null;
    }

    /**
     * @param SitemapIndexInterface $sitemapIndex
     * @param \XMLWriter            $xmlWriter
     *
     * @return string
     */
    public function write(SitemapIndexInterface $sitemapIndex, \XMLWriter $xmlWriter = null)
    {
        $xmlWriter = $xmlWriter ?: new \XMLWriter();

        $xmlWriter->openMemory();
        $this->_write($sitemapIndex, $xmlWriter);
        return $xmlWriter->outputMemory();
    }

    private function _write(SitemapIndexInterface $sitemapIndex, \XMLWriter $xmlWriter) {
        $xmlWriter->startDocument('1.0', 'UTF-8');

        $xmlWriter->startElement('sitemapindex');
        $xmlWriter->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($sitemapIndex->sitemaps() as $sitemap) {
            $this->sitemapWriter->write($sitemap, $xmlWriter);
        }

        $xmlWriter->endElement();

        $xmlWriter->endDocument();
    }

    public static function create(SitemapWriter $sitemapWriter = null)
    {
        return new SitemapIndexWriter($sitemapWriter);
    }

    /**
     * @param \XMLWriter            $writer
     *
     * @throws \InvalidArgumentException
     * 
     * @return string
     */
    public function withXMLWriter(\XMLWriter $writer)
    {
        Assertion::isInstanceOf($writer, \XMLWriter::class);

        $instance = clone $this;

        $instance->xmlWriter = $writer;

        return $instance;
    }

    /**
     * Write XML to memory.
     * Writer must be flushed manually after operation if using pre-existing writer.
     * 
     * @param SitemapIndexInterface $sitemapIndex
     * @param \XMLWriter            $xmlWriter
     *
     * @return string
     */
    public function writeToMemory(SitemapIndexInterface $sitemapIndex)
    {
        return $this->write($sitemapIndex, $this->xmlWriter);
    }

    /**
     * @param SitemapIndexInterface $sitemapIndex
     * @param string                $Uri
     * @param \XMLWriter            $xmlWriter
     *
     * @return void
     */
    public function writeToUri(SitemapIndexInterface $sitemapIndex, string $Uri)
    {
        $xmlWriter = $this->xmlWriter ?: new \XMLWriter();

        Assertion::true($xmlWriter->openUri($Uri), "failed to open uri: {$Uri}");
        $this->_write($sitemapIndex, $xmlWriter);
    }
}
