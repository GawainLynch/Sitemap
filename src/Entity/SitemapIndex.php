<?php

namespace SitemapGenerator\Entity;

/**
 * Represents a sitemap index.
 *
 * @see http://www.sitemaps.org/protocol.html
 */
class SitemapIndex
{
    /**
     * URL of the sitemap index.
     * Should NOT begin with the protocol (as it will be added later) but MUST
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

    public function __construct($loc, \DateTimeInterface $lastmod = null)
    {
        if (strlen($loc) > 2048) {
            throw new \DomainException('The loc value must be less than 2,048 characters');
        }

        $this->loc = $loc;
        $this->lastmod = $lastmod;
    }

    public function getLoc()
    {
        return $this->loc;
    }

    public function getLastmod()
    {
        if ($this->lastmod === null) {
            return null;
        }

        return $this->lastmod->format(\DateTime::W3C);
    }
}
