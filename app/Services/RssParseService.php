<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use DOMNode;

class RssParseService
{
    private $doc;

    private function xQuery($query, DOMNode $context = null, $first = false)
    {
        $xpath = new DOMXpath($this->doc);
        $result = $xpath->query($query, $context);

        if ($first) {
            return $result->item(0);
        }

        return $result;
    }

    public function parse($xml)
    {
        $this->doc = new DOMDocument();
        try {
            $this->doc->loadXML($xml);
        } catch (\Exception $e) {
            return false; // Failed to parse XML
        }

        $mainLink = $this->xQuery('/rss/channel/link', null, true)->nodeValue;

        $items = $this->xQuery('/rss/channel/item');

        $links = [];

        foreach ($items as $item) {
            /**
             * @var \DOMElement $item
             */

            $title = $this->xQuery('title', $item, true)->nodeValue;
            $link = $this->xQuery('link', $item, true)->nodeValue;
            $description = $this->xQuery('description', $item, true)->nodeValue;

            $links[] = compact('title', 'link', 'description');
        }

        return compact('mainLink', 'links');
    }
}