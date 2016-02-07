<?php

namespace SitemapGenerator\Entity;

/**
 * Represents a sitemap entry.
 *
 * @see http://www.sitemaps.org/protocol.html
 */
class Url
{
    /**
     * URL of the page.
     * MUST begin with the protocol (as it will be added later) AND MUST
     * end with a trailing slash, if your web server requires it. This value
     * must be less than 2,048 characters.
     */
    protected $loc;

    /**
     * The date of last modification of the file.
     *
     * NOTE This tag is separate from the If-Modified-Since (304) header
     * the server can return, and search engines may use the information from
     * both sources differently.
     *
     * @var \DateTimeInterface
     */
    protected $lastmod;

    /**
     * How frequently the page is likely to change. This value provides general
     * information to search engines and may not correlate exactly to how often
     * they crawl the page.
     *
     * @see ChangeFrequency class
     */
    protected $changefreq;

    /**
     * The priority of this URL relative to other URLs on your site. Valid
     * values range from 0.0 to 1.0. This value does not affect how your pages
     * are compared to pages on other sites—it only lets the search engines
     * know which pages you deem most important for the crawlers.
     *
     * The default priority of a page is 0.5 (if not set in the sitemap).
     */
    protected $priority;

    protected $videos = [];

    protected $images = [];

    public function __construct($loc)
    {
        if (strlen($loc) > 2048) {
            throw new \DomainException('The loc value must be less than 2,048 characters');
        }

        $this->loc = $loc;
    }

    public function getLoc()
    {
        return $this->loc;
    }

    public function setLastmod(\DateTimeInterface $lastmod = null)
    {
        $this->lastmod = $lastmod;
    }

    public function getLastmod()
    {
        if ($this->lastmod === null) {
            return null;
        }

        if ($this->getChangefreq() === null || in_array($this->getChangefreq(), [ChangeFrequency::ALWAYS, ChangeFrequency::HOURLY], true)) {
            return $this->lastmod->format(\DateTime::W3C);
        }

        return $this->lastmod->format('Y-m-d');
    }

    public function setChangefreq($changefreq)
    {
        if ($changefreq !== null && !ChangeFrequency::isValid($changefreq)) {
            throw new \DomainException(sprintf('Invalid changefreq given ("%s"). Valid values are: %s', $changefreq, implode(', ', ChangeFrequency::KNOWN_FREQUENCIES)));
        }

        $this->changefreq = $changefreq;
    }

    public function getChangefreq()
    {
        return $this->changefreq;
    }

    public function setPriority($priority)
    {
        $priority = (float) $priority;

        if ($priority < 0 || $priority > 1) {
            throw new \DomainException('The priority must be between 0 and 1');
        }

        $this->priority = $priority;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function addVideo(Video $video)
    {
        $this->videos[] = $video;
    }

    public function setVideos(array $videos)
    {
        $this->videos = $videos;
    }

    /**
     * @return Video[]
     */
    public function getVideos()
    {
        return $this->videos;
    }

    public function addImage(Image $image)
    {
        $this->images[] = $image;
    }

    public function setImages(array $images)
    {
        $this->images = $images;
    }

    /**
     * @return Image[]
     */
    public function getImages()
    {
        return $this->images;
    }
}
