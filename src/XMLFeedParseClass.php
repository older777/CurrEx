<?php
namespace Older777\CurrEx;

use DOMDocument;
use DOMXPath;
use DOMNodeList;

/**
 * Parse XML document
 *
 * @author older777
 *        
 */
class XMLFeedParseClass
{

    protected $xml;

    protected $xpath;

    /**
     * Init environments
     *
     * @param string $xmlfeed
     */
    public function __construct(string $xmlfeed)
    {
        $this->xml = new DOMDocument('1.0', 'utf-8');
        $this->xml->loadXML($xmlfeed);
        $this->xpath = new DOMXPath($this->xml);
    }

    /**
     * Search exchange rate of currency
     *
     * @param string $currency
     * @param bool $inverse
     * @param bool $roundpoint
     * @return float|NULL
     */
    public function parseCurrency(string $currency, bool $inverse, bool $roundpoint)
    {
        $query = "//channel/item[targetCurrency/text()='{$currency}']/" . ($inverse ? "inverseRate" : "exchangeRate") . "/text()";
        $result = $this->xpath->query($query);
        if ($result instanceof DOMNodeList && $result->count() != 0) {
            $node = $result->item(0)->nodeValue;
            return ($roundpoint ? round($node, 2) : $node);
        }
        return null;
    }
}

