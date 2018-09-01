<?php
# ======================================================================== #
#
#  Title      [PHP] EmailAddressScraper Demo
#  Author:    Chinemerem H. Nworisa
#  Website:   https://www.gigabyte.com.ng/your-projects-f13/php-email-address-scraper-t15.html
#  Version:   1.0
#  License:   https://github.com/remeni/email-address-scrapper/blob/master/LICENSE
#  Date:      1-Sept-2018
#  Purpose:   Simple PHP class for scraping email addresses from webpages demo
#
# ======================================================================== #


include('EmailAddressScraper.php');
?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Email Address Scraper Demo</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<h1>Email Address Scraper Demo</h1>
			<p>Simple PHP class for scraping email addresses from webpages - <a href="https://www.gigabyte.com.ng/your-projects-f13/php-email-address-scraper-t15.html">https://www.gigabyte.com.ng/your-projects-f13/....html</a>
			</p>
			<form action="" method="get">
				<div class="form-group">
					<label class="control-label">URL</label>
					<input type="url" name="url" placeholder="Enter URL to scrape" class="form-control"/>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary"/>
				</div>
			</form>
			<?php if(isset($_GET['url'])){ ?>
			<div style="background-color: #000;color: #fff;font-family: Terminal;padding:10px;">
					<?php
						$url = urldecode($_GET['url']);
						
						// Configurable options
						$opts = array(
							 // Required
							'url' => $url,
							
							// Optional. Default: root of URL provided
							 'referer' => "",
							 
							// Optional. Default: "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36"
							'useragent' => "",
							
							// Optional. Defualt: ";"
							'delimiter' => ",");

						// Initialize scraper
						$init= new EmailAddressScraper($opts);

						// Scrape email addresses
						$addresses =  $init->scrape();
						$addresses = explode(',', $addresses);
						foreach($addresses as $curEmail)
						{
							echo $curEmail.'<br/>';
						}
					?>
			</div>
			<?php } ?>
			
			<h3>Source code:</h3>
			<pre>
			<code>
				&lt;?php
				# ======================================================================== #
				#
				#  Title      [PHP] EmailAddressScraper Demo
				#  Author:    Chinemerem H. Nworisa
				#  Website:   https://www.gigabyte.com.ng/your-projects-f13/php-email-address-scraper-t15.html
				#  Version:   1.0
				#  License:   https://github.com/remeni/email-address-scrapper/blob/master/LICENSE
				#  Date:      1-Sept-2018
				#  Purpose:   Demo for a simple PHP class for scraping email addresses from webpages
				#
				# ======================================================================== #


				include('EmailAddressScraper.php');
				?&gt;
				&lt;html&gt;
					&lt;head&gt;
						&lt;meta charset="utf-8" /&gt;
						&lt;meta http-equiv="X-UA-Compatible" content="IE=edge"&gt;
						&lt;meta name="viewport" content="width=device-width, initial-scale=1" /&gt;
						&lt;title&gt;Email Address Scrapper Demo&lt;/title&gt;
						&lt;style type="text/css"&gt;
							* {
								box-sizing: border-box;
							}
							.container {
								width: 980px;
								margin-right: auto;
								margin-left: auto;
							}
							label {
								font-weight: bold;
								width: 100%;
								display: block;
							}
							input {
								display: block;
								width: 100%;
								height: 40px;
								font-size: 20px;
								border: 1px solid #0E8341;
								border-radius: 6px;
							}
							input[type=submit] {
								background-color: #0E8341;
								color: #fff;
								font-weight: bold;
							}
							input[type=submit]:hover {
								background-color: #000000;
								border-color: #000;
								color: #fff;
								font-weight: bold;
								cursor: pointer;
							}
						&lt;/style&gt;
					&lt;/head&gt;
					&lt;body&gt;
						&lt;div class="container"&gt;
							&lt;h1&gt;Email Address Scraper Demo&lt;/h1&gt;
							&lt;p&gt;Project Link: &lt;a href="https://www.gigabyte.com.ng/your-projects-f13/php-email-address-scraper-t15.html"&gt;https://www.gigabyte.com.ng/your-projects-f13/....html&lt;/a&gt;&lt;/p&gt;
							&lt;form action="" method="get"&gt;
								&lt;label&gt;Url:&lt;/label&gt;
								&lt;input type="text" name="url"/&gt;&lt;br/&gt;
								&lt;input type="submit"/&gt;
							&lt;/form&gt;
							&lt;?php if(isset($_GET['url'])){ ?&gt;
							&lt;div style="background-color: #000;color: #fff;font-family: Terminal;padding:10px;"&gt;
									&lt;?php
										$url = urldecode($_GET['url']);
										
										// Configurable options
										$opts = array(
											 // Required
											'url' =&gt; $url,
											
											// Optional. Default: root of URL provided
											 'referer' =&gt; "",
											 
											// Optional. Default: "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36"
											'useragent' =&gt; "",
											
											// Optional. Defualt: ";"
											'delimiter' =&gt; ",");

										// Initialize scraper
										$init= new EmailAddressScraper($opts);

										// Scrape email addresses
										$addresses =  $init-&gt;scrape();
										$addresses = explode(',', $addresses);
										foreach($addresses as $curEmail)
										{
											echo $curEmail.'&lt;br/&gt;';
										}
									?&gt;
							&lt;/div&gt;
							&lt;?php } ?&gt;
						&lt;/div&gt;
					&lt;/body&gt;
				&lt;/html&gt;
			</code>
			</pre>
		</div>
	</body>
</html>
