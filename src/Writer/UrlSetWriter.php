<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Sitemap\Writer;

use Assert\Assertion;
use Refinery29\Sitemap\Component\Image\ImageInterface;
use Refinery29\Sitemap\Component\News\NewsInterface;
use Refinery29\Sitemap\Component\UrlInterface;
use Refinery29\Sitemap\Component\UrlSetInterface;
use Refinery29\Sitemap\Component\Video\VideoInterface;

/**
 * @link https://support.google.com/webmasters/answer/183668?hl=en
 */
class UrlSetWriter
{
    /**
     * @var UrlWriter
     */
    private $urlWriter;

    /**
     * @var \XMLWriter
     */
    private $xmlWriter;

    public function __construct(UrlWriter $urlWriter = null)
    {
        $this->urlWriter = $urlWriter ?: new UrlWriter();
        $this->xmlWriter = null;
    }

    /**
     * @param UrlSetInterface $urlSet
     * @param \XMLWriter      $xmlWriter
     *
     * @return string
     */
    public function write(UrlSetInterface $urlSet, \XMLWriter $xmlWriter = null)
    {
        $xmlWriter = $xmlWriter ?: new \XMLWriter();

        $xmlWriter->openMemory();
        $this->_write($urlSet, $xmlWriter);
        return $xmlWriter->outputMemory();
    }

    private function _write(UrlSetInterface $urlSet, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startDocument('1.0', 'UTF-8');

        $xmlWriter->startElement('urlset');

        $this->writeNamespaceAttributes($xmlWriter);
        $this->writeUrls($xmlWriter, $urlSet->urls());

        $xmlWriter->endElement();

        $xmlWriter->endDocument();
    }

    private function writeNamespaceAttributes(\XMLWriter $xmlWriter)
    {
        $xmlWriter->writeAttribute(UrlSetInterface::XML_NAMESPACE_ATTRIBUTE, UrlSetInterface::XML_NAMESPACE_URI);
        $xmlWriter->writeAttribute(ImageInterface::XML_NAMESPACE_ATTRIBUTE, ImageInterface::XML_NAMESPACE_URI);
        $xmlWriter->writeAttribute(NewsInterface::XML_NAMESPACE_ATTRIBUTE, NewsInterface::XML_NAMESPACE_URI);
        $xmlWriter->writeAttribute(VideoInterface::XML_NAMESPACE_ATTRIBUTE, VideoInterface::XML_NAMESPACE_URI);
    }

    /**
     * @param \XMLWriter     $xmlWriter
     * @param UrlInterface[] $urls
     */
    private function writeUrls(\XMLWriter $xmlWriter, array $urls)
    {
        foreach ($urls as $url) {
            $this->urlWriter->write($url, $xmlWriter);
        }
    }

    public static function create(UrlWriter $urlWriter = null)
    {
        return new UrlSetWriter($urlWriter);
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
     * @param UrlSetInterface $urlSet
     * @param \XMLWriter            $xmlWriter
     *
     * @return string
     */
    public function writeToMemory(UrlSetInterface $urlSet)
    {
        return $this->write($urlSet, $this->xmlWriter);
    }

    /**
     * @param UrlSetInterface $urlSet
     * @param string                $Uri
     * @param \XMLWriter            $xmlWriter
     *
     * @return void
     */
    public function writeToUri(UrlSetInterface $urlSet, string $Uri)
    {
        $xmlWriter = $this->xmlWriter ?: new \XMLWriter();

        Assertion::true($xmlWriter->openUri($Uri), "failed to open uri: {$Uri}");
        $this->_write($urlSet, $xmlWriter);
    }
}
