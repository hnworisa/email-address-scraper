<?php
# ======================================================================== #
#
#  Title      [PHP] EmailAddressScraper
#  Author:    Chinemerem H. Nworisa
#  Website:   https://www.gigabyte.com.ng/your-projects-f13/php-email-address-scraper-t15.html
#  Version:   1.0
#  License:   https://github.com/remeni/email-address-scrapper/blob/master/LICENSE
#  Date:      1-Sept-2018
#  Purpose:   Simple PHP class for scraping email addresses from webpages
#
# ======================================================================== #

class EmailAddressScraper
{
	// Which URL to scrap
	var $url;
	
	// Which URL to use as HTTP Referrer
	var $referer;
	
	// Which useragent string to use
	var $useragent;
	
	// Delimiter to separate email addresses
	var $delimiter = ";";
	
	function __construct($options = NULL) {
		if($options != NULL && is_array($options))
		{
			if(isset($options['url']))
				$this->setURL($options['url']);
			
			if(isset($options['referer']))
				$this->setReferer($options['referer']);
			
			if(isset($options['useragent']))
				$this->setUseragent($options['useragent']);
			
			if(isset($options['delimiter']))
				$this->setDelimiter($options['delimiter']);
		}
	}
	
	// Add the URL
	function setURL($theURL){
		$this->url = $theURL;
	}
	
	// Set the referer URL
	function setReferer($theReferer){
		$this->referer = $theReferer;
	}
	
	// Set the useragent string
	function setUseragent($theUseragent){
		$this->useragent = $theUseragent;
	}
	
	// Set the export format
	function setDelimiter($theDelimiter){
		$this->delimiter = $theDelimiter;
	}
	
	// Get the referer URL
	private function getReferer(){
		if($this->referer == '')
		{
			$parseURL = parse_url(trim($this->url));
			$this->referer = $parseURL['scheme'].'://'.$parseURL['host'];
		}
		
		return $this->referer;
	}
	
	// Get the useragent string
	private function getUseragent(){
		if($this->useragent == '')
			$this->useragent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36';
		
		return $this->useragent;
	}
	
	// Function to get URL contents
	private function fetch($url)
	{
		// Use cURL if available
		if(function_exists('curl_exec'))
		{
			$ch = curl_init($url); // intialize cURL handle
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			curl_setopt($ch, CURLOPT_USERAGENT, $this->getUseragent());
			curl_setopt($ch, CURLOPT_AUTOREFERER, false);
			curl_setopt($ch, CURLOPT_REFERER, $this->getReferer());
			curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return into a variable
			curl_setopt($ch, CURLOPT_TIMEOUT, 50); // times out after 50s
			curl_setopt($ch, CURLOPT_POST, 0); //set POST method
			$response = curl_exec($ch); // run the whole process
			curl_close($ch);
		}
		
		// use socket if cURL fails
		if (empty($response))
		{
			$url_parsed = @parse_url($url);
		
			if ($url_parsed === false || !isset($url_parsed["host"]))
				return false;
			
			switch ($url_parsed['scheme']) {
				case 'https':
					$scheme = 'ssl://';
					$port = 443;
					break;
				case 'http':
				default:
					$scheme = '';
					$port = 80;
				break;
			}
		
			$host = $url_parsed["host"];
			$path = isset($url_parsed["path"])  && !empty($url_parsed["path"])  ? $url_parsed["path"] : "/";
			$port = isset($url_parsed["port"])  && !empty($url_parsed["port"])  ? $url_parsed["port"] : $port;
			$path = isset($url_parsed["query"]) && !empty($url_parsed["query"]) ? $path . "?" . $url_parsed["query"] : $path;
		
			$out = "GET " . $path . " HTTP/1.0\r\nHost: " . $host . "\r\nUser-Agent: ". $this->getUseragent() ."\r\nReferer: ".$this->getReferer() . "\r\nConnection: Close\r\n\r\n";
			$fp = @fsockopen($scheme . $host, $port, $errno, $errstr, 15);
			if (!$fp)
				$response = false;
			else {
				@fwrite($fp, $out);
				$body = false;
				$response = "";
				while (!feof($fp)) {
					$str = fgets($fp, 1024);
					if($body) 
						$response .= $str;
					if($str == "\r\n") 
						$body = true;
				}
				@fclose($fp);
			}
		}
		
		// Use file_get_contents if other options fail
		if(empty($response) && @file_get_contents(__FILE__) && ini_get('allow_url_fopen'))
		{
			// Build request header
			$opts = array(
			  'http'=>array(
			    'method'=>"GET",
				'header'=>"Accept-language: en\r\n" .
						  "Cookie: \r\n" .
						  "Referer: ".$this->getReferer()."\r\n" .
						  "User-Agent: ".$this->getUseragent()."\r\n"
				)
			);
			$context = @stream_context_create($opts);
			$response = @file_get_contents($url, false, $context);
		}
		
		return $response;
	}
	
	// Actual scrapping function
	function scrape()
	{
		// Create empty variable to store emails
		$emails_found = '';
		
		//if(is_array($this->url)){ foreach($urls as url){ $new = scrape() $new->setURL = $url; $emails_found = $emails_found.$new->scrape(); }else{ ...
		
		//if($this->follow_urls){ $new = scrape() $new->setURL = search_urls($url); $emails_found = $emails_found.$new->scrape();}
		
		// Fetch contents of url
		$content = $this->fetch($this->url);
		
		// Use preg_match_all to search for emails
		@preg_match_all('/([\w+\.]*\w+@[\w+\.]*\w+[\w+\-\w+]*\.\w+)/is', $content, $results);
		
		// Loop through results using foreach
		foreach($results[1] as $curEmail)
		{
			// Trim current email and append in emails_found string
			$emails_found = $emails_found.trim($curEmail).$this->delimiter;
		}
		
		// Return emails_found found string 
		return $emails_found;
	}
}
?>