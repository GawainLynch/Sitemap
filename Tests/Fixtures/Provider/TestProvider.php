<?php

namespace KPhoen\SitemapBundle\Tests\Fixtures\Provider;

use KPhoen\SitemapBundle\Entity\Image;
use KPhoen\SitemapBundle\Entity\Url;
use KPhoen\SitemapBundle\Entity\Video;
use KPhoen\SitemapBundle\Provider\ProviderInterface;
use KPhoen\SitemapBundle\Sitemap\Sitemap;


class TestProvider implements ProviderInterface
{
    public function populate(Sitemap $sitemap)
    {
        $url = new Url();
        $url->setLoc('http://www.google.fr');
        $url->setChangefreq(Url::CHANGEFREQ_NEVER);
        $url->setLastmod('2012-12-19 02:28');

        $video = new Video();
        $video->setThumbnailLoc('http://www.example.com/thumbs/123.jpg');
        $video->setTitle('Grilling steaks for summer');
        $video->setDescription('Alkis shows you how to get perfectly done steaks every time');
        $url->addVideo($video);

        $sitemap->add($url);

        $url = new Url();
        $url->setLoc('http://github.com');
        $url->setChangefreq(Url::CHANGEFREQ_ALWAYS);
        $url->setPriority(0.2);
        $sitemap->add($url);
    }
}
