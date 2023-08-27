# sitemap

This repository provides components for building and writing XML sitemaps, following Google recommendations.

## What's Different?

This is a fork of [`refinery92/sitemap`](https://github.com/refinery29/sitemap), for my personal usage.

- Added static method `create` to some classes such as `Url`, `News`, `Sitemap`, etc. to allow direct method chaining after object creation
- Added method to `SitemapIndexWriter` and `UrlSetWriter` to write to URI instead of memory (`writeToUri`)
- Added localized version support.

Example of localization support to URL:

```php
use Refinery29\Sitemap\Component\Url;
use Slainless\Sitemap\Component\Alt;

$url = Url::create('http://www.example.org/en/bar.html')
    ->withLastModified(new DateTime())
    ->withChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
    ->withPriority(0.8)
    ->withAlternatives([
        new Alt('http://www.example.org/en/bar.html', 'en'),
        new Alt('http://www.example.org/id/bar.html', 'id'),
        new Alt('http://www.example.org/de/bar.html', 'de'),
        new Alt('http://www.example.org', 'x-default'),
    ])

```

## Installation

Run:

```
$ composer require refinery29/sitemap
```

## Content

### Components

This package provides all of the components we need to build a sitemap or a sitemap index.

The components are immutable objects, that is, their mutators clone the instance, then set the values. This helps preventing issues with unwillingly modifying a graph of components.

There are two different types of graphs we are interested in building:

* `Component\UrlSet` (represents a set of URLs)
* `Component\SiteMapIndex` (represents a set of sitemaps)

### Writers

Once a graph of components has been build, they need to passed to a writer so they can be turned into XML.

There are two different types of writers:

* `Writer\UrlSetWriter` (turns a `Component\UrlSet` into XML)
* `Writer\SitemapIndexWriter` (turns a `Component\SitemapIndex` into XML)

## Creating a sitemap

### `Url`

Before we can create a sitemap, we need `Url`s, so let's create one:

```php
use Refinery29\Sitemap\Component;

$url = new Component\Url('http://www.example.org/foo/bar.html');

$url = $url
    ->withLastModified(new DateTime())
    ->withChangeFrequency(Component\Url::CHANGE_FREQUENCY_MONTHLY)
    ->withPriority(0.8)
;
```

:bulb: Google imposes a limit of 50,000 URLs that can be added to any sitemap.

### `Image`

We may want to add images to a `Url` so let's create one:

```php
use Refinery29\Sitemap\Component;

$image = new Component\Image\Image('http://www.example.org/img/beach.jpg');

$image = $image
    ->withTitle('Our day at the beach')
    ->withCaption('Here we are sitting at the bar, enjoying our drinks')
    ->withGeoLocation('Majorca, Canyamel')
;
```

We can now add the image:

```php
$url = $url->withImages([
    $image,
]);
```

:bulb: We can attach up to 1.000 images to a `Url`.

### `News`

We may want to add news to a `Url`, if the URL identifies a news article, for example, so let's do this, too:

```php
use Refinery29\Sitemap\Component;

$publication = new Component\News\Publication(
    'The Example Times',
    'en'
);

$news = new Component\News\News(
    $publication,
    new DateTime(),
    'Something happened and you should know about it',
);

$url = $url->withNews([
    $news,
]);
```

:bulb: `News` has many more options, have a look at the source!

### `Video`

We may want to add video to a `Url`, if the URL identifies a page where you can watch a video, so let's also do this:

```php
use Refinery29\Sitemap\Component;

$video = new Component\Video\Video(
    'http://www.example.org/img/funny-video-thumbnail.gif',
    'Jerry dropped his lemonade',
    'Here you can see how Jerry dropped his lemonade and everyone laughs, it is really funny!',
    'http://www.example.org/img/funny-video.mov',
);

$url = $url->withVideos([
    $video,
]);
```

:bulb: `Video` has many more options, have a look at the source!

### `UrlSet`

Now, let's create a `UrlSet` using the previously created `Url`:


```php
use Refinery29\Sitemap\Component;

$urlSet = new Component\UrlSet([
    $url,
]);
```

## Writing a Sitemap

When we're finished building a `UrlSet`, we probably want to write it, so let's do it:

```php
use Refinery29\Sitemap\Writer;

$urlSetWriter = new Writer\UrlSetWriter();

$xml = $urlSetWriter->write($urlSet);
```

## Creating a Sitemap Index

If we have many URLs, we may want to spread our sitemaps across multiple files and index them.

### `Sitemap`

Before we can create a `SitemapIndex`, we need a few `Sitemap`s, so let's create them:

```php
use Refinery29\Sitemap\Component;

$lastModified = new DateTime();

$sitemap = new Component\Sitemap('http://www.example.org/funny.xml');

$sitemap = $sitemap->withLastModifed($lastModified);

$anotherSitemap = new Component\Sitemap(
    'http://www.example.org/news.xml',
    $lastModified
);
```

### `SitemapIndex`

Let's create a `SitemapIndex` using the previously created `Sitemap`s:

```php
use Refinery29\Sitemap\Component;

$sitemapIndex = new Component\SitemapIndex([
    $sitemap,
    $anotherSitemap,
]);
```

### Writing a Sitemap Index

When we're finished building a `SitemapIndex`, we probably want to write, so let's do it:

```php
use Refinery29\Sitemap\Writer;

$sitemapIndexWriter = new Writer\SitemapIndexWriter();

$xml = $sitemapIndexWriter->write($sitemapIndex);
```

## Contributing

Please refer to [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## Code of Conduct

Please have a look at [`CONDUCT.md`](.github/CONDUCT.md).

## License

This package is licensed using the MIT License.
