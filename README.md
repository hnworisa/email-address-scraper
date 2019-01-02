# email-address-scraper
Simple PHP class for scraping email addresses from webpages
[![Made in Nigeria](https://img.shields.io/badge/made%20in-nigeria-008751.svg?style=flat-square)](https://github.com/acekyd/made-in-nigeria)

## Requirements
PHP 5.2+

## Demo
https://www.gigabyte.com.ng/demos/email_scraper/

## How to use
```php
<?php
// Configurable options
$opts = array(
	 // URL to scrape. Required
	'url' => "http://example.com",
	
	// HTTP Referer. Optional. Default: root of URL provided
	 'referer' => "",
	 
	// User Agent. Optional. Default: "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36"
 	'useragent' => "",
 	
 	// Delimiter. Optional. Default: ";"
 	'delimiter' => "");

// Initialize scraper
$init= new EmailAddressScraper($opts);

// Scrape email address
$init->scrape();
?>
```
