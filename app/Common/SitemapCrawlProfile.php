<?php

namespace App\Common;

use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlProfiles\CrawlProfile;

class SitemapCrawlProfile extends CrawlProfile
{
  /*
  * Determine if the given url should be crawled.
  */
  public function shouldCrawl(UriInterface $url): bool
  {
    return strpos($url->getPath(), '/shop') ||
      strpos($url->getPath(), '/product') ||
      strpos($url->getPath(), '/category') ||
      strpos($url->getPath(), '/brand');
  }
}
