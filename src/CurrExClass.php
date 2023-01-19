<?php
namespace Older777\CurrEx;

use Exception;
use Throwable;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use Older777\CurrEx\XMLFeedParseClass;

/**
 *
 * Wrapper for online USD currency exchange rates of FLOATRATES.COM
 *
 * @author older777
 *        
 */
class CurrExClass
{

    const XMLFEEDURL = 'https://www.floatrates.com/daily/usd.xml';

    const XMLFEEDCACHE = 'currex.cache.xml';

    const EXTENSIONS = [
        'xml',
        'mbstring'
    ];

    const ENVINTERVAL = 'CURREX_INTERVAL';

    const ENVTIMEOUT = 'CURREX_TIMEOUT';

    protected static $xmlfeed;

    protected static $instance;

    /**
     * init of environments
     *
     * @return NULL;
     */
    public function __construct()
    {
        // check for extensions
        foreach (self::EXTENSIONS as $row) {
            if (! extension_loaded($row)) {
                throw new Exception("CurrEx load error! Not found PHP extension: {$row}");
                exit();
            }
        }

        // get/set default interval, 0 interval - no cache
        $interval = env(self::ENVINTERVAL, 60) * 60;
        // get XML feed from cache
        if (Cache::offsetExists(self::XMLFEEDCACHE) && $interval) {
            self::$xmlfeed = cache::get(self::XMLFEEDCACHE);
        } else {
            self::downloadXMLFeed();
            if ($interval) {
                Cache::put(self::XMLFEEDCACHE, (string) self::$xmlfeed, $interval);
            }
        }
    }

    /**
     * static instance of class
     *
     * @return \Older777\CurrEx\CurrExClass
     */
    public static function instance()
    {
        if (self::$instance) {
            return self::$instance;
        } else {
            return self::$instance = new self();
        }
    }

    /**
     * Download XML file from the website
     * Silent on HTTP errors
     *
     * @return NULL
     */
    public static function downloadXMLFeed()
    {
        $timeout = env(self::ENVTIMEOUT, 5);
        try {
            $req = new Client([
                'timeout' => $timeout
            ]);
            self::$xmlfeed = $req->get(self::XMLFEEDURL)->getBody();
        } catch (Throwable $e) {
            return null;
        }
    }

    /**
     * Return XML feed
     *
     * @return \Psr\Http\Message\StreamInterface|mixed|Closure|array|number
     */
    public static function getXMLFeed()
    {
        return self::$xmlfeed;
    }

    /**
     * Get exchange rate of USD.
     * Input string EUR, JPY, CNY, etc
     *
     * @param string $currency
     * @return NULL|float
     */
    public static function getExRate(string $currency, bool $inverse = false, bool $roundpoint = true)
    {
        if (empty(self::$xmlfeed) || empty($currency)) {
            return null;
        }
        try {
            $parser = new XMLFeedParseClass(self::$xmlfeed);
            return $parser->parseCurrency($currency, $inverse, $roundpoint);
        } catch (\Throwable $e) {
            return null;
        }
    }
}

