<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Slainless\Sitemap\Writer;

use Slainless\Sitemap\Component\AltInterface;

/**
 * @link https://support.google.com/webmasters/answer/178636?hl=en
 */
class AltWriter
{
    public function write(AltInterface $alt, \XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('xhtml:link');

        $xmlWriter->writeAttribute("rel", "alternate");
        $xmlWriter->writeAttribute("hreflang", $alt->language());
        $xmlWriter->writeAttribute("href", $alt->location());

        $xmlWriter->endElement();
    }
}
