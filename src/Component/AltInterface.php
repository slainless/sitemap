<?php

/*
 * Copyright (c) 2023 slainless@github.com.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Slainless\Sitemap\Component;

/**
 * @link https://support.google.com/webmasters/answer/178636?hl=en
 */
interface AltInterface
{
    /**
     * Constants for XML namespace attribute and URI.
     */
    const XML_NAMESPACE_ATTRIBUTE = 'xmlns:xhtml';
    const XML_NAMESPACE_URI = 'http://www.w3.org/1999/xhtml';

    /**
     * @return string
     */
    public function location();

    /**
     * @return string|null
     */
    public function language();
}
