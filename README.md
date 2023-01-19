# CurrEx PHP library for Laravel

CurrEx library for get USD exchange rates for next currencies from the FLOATRATES.COM:
  - EUR, GBP, JPY, AUD, CHF, CAD, ARS, STN, BIF, MMK, MUR, VES, BDT, RON, DZD, CRC, BZD, GNF, SZL, SOS, AED, IDR, MXN, UAH, AZN, PYG, GYD, RWF, ERN, WST, BRL, INR, NPR, XAF, IQD, AFN, NAD, SYP, MOP, BAM, DKK, LKR, TND, VND, TMT, SVC, XCD, LAK, GTQ, PKR, BGN, RUB, GEL, MKD, AWG, AOA, MVR, SAR, PLN, GIP, COP, BBD, DJF, HNL, KES, BHD, EGP, KRW, MRO, PAB, FJD, CDF, MZN, UGX, HKD, MAD, ZAR, MDL, IRR, BOB, LRD, SDG, TOP, VUV, KWD, THB, TWD, UZS, ETB, TTD, PGK, BWP, OMR, ILS, PEN, TJS, GMD, CVE, ZMW, KHR, SEK, SGD, HUF, BYN, CLP, BSD, XPF, ALL, SCR, DOP, CNY, ISK, LYD, HTG, BND, KMF, LSL, TZS, ANG, LBP, MYR, KZT, AMD, UYU, JMD, SSP, MRU, MNT, JOD, PHP, XOF, KGS, MGA, SRD, GHS, CUP, NZD, TRY, NGN, RSD, NIO, SBD, MWK, YER, NOK, QAR, CZK, HRK

## Requirements

- Laravel version current support: 5.0 - 5.7
- Guzzle HTTP Client: >=5.0
- PHP ver: >=7.0
- PHP extensions: XML; mbstring;

## Features

- Auto download and caching of XML feed file
- Silent mode on PHP exceptions
- XML feed cache auto update
- Intervals and timeouts configurations
- Round floats 2 numbers after point

## Install

    composer require older777/currex

## Configuration and usage example

Add in to your ENV-file config lines:

    CURREX_INTERVAL=60 
    CURREX_TIMEOUT=5

CURREX_INTERVAL - time interval is for XML feed auto update, in minutes. 60 minutes default value.
CURREX_TIMEOUT - timeout interval for the HTTP query, in seconds. 5 second default value.

PHP-example of some page controller

```php
    public function page()
    {
        $currex = CurrExClass::instance();
        echo <<<TXT
            1 USD = {$currex::getExRate('EUR', false, false)} EUR<br />
            1 USD = {$currex::getExRate('CNY')} CNY<br />
            1 USD = {$currex::getExRate('JPY')} JPY<br />
            1 USD = {$currex::getExRate('RUB')} RUB<br />
            1 USD = {$currex::getExRate('GBP')} GBP<br />
            1 USD = {$currex::getExRate('CNY')} BRL<br />
        TXT;
    }
```

Currency exchange rate function entry variables **getExRate**

    CurrEx::getExRate('EUR', false, false)
    
    1st variable is currency code, string
    2nd is inverse exchage rate couple USD = EUR, EUR = USD, FALSE default value
    3rd variable to round 2 numbers after point, TRUE default value

**Author:** Arthur Minkhaerov
