# proxycheck.io
https://proxycheck.io is a service which provides an easy to query, accurate and reliable API for the purposes of proxy blocking.

Our aim on GitHub is to offer example code that utilises our API so that developers can easily integrate what we consider the best proxy detection API into their projects.

## Composer
The function featured here is a basic example. We recommend you use our Composer library featured [here](https://github.com/proxycheck/proxycheck-php) instead which has more features, exposes more information for you to use in your program and supports library side country blocking.

## Installation of the Function ##

Download the [proxycheck.io.php.function.php](https://github.com/proxycheck/proxycheck.io/blob/master/proxycheck.io.php.function.php) and place it in the root folder of your website.

Near the top of the file you will see a settings section where you should populate your API Key and toggle any settings you want to use like below.

```php
// ------------------------------
// SETTINGS
// ------------------------------
    
  $API_Key = "######-######-######-######"; // Supply your API key between the quotes if you have one
  $VPN = "0"; // Change this to 1 if you wish to perform VPN Checks on your visitors
  $TLS = "0"; // Change this to 1 to enable transport security, TLS is much slower though!
  $TAG = "1"; // Change this to 1 to enable tagging of your queries (will show within your dashboard)
    
  // If you would like to tag this traffic with a specific description place it between the quotes.
  // Without a custom tag entered below the domain and page url will be automatically used instead.
  $Custom_Tag = ""; // Example: $Custom_Tag = "My Forum Signup Page";
    
// ------------------------------
// END OF SETTINGS
// ------------------------------
```

## Utilising the function from other pages ##

Once you've saved the function you can add the integration to any other page on your website by including the function and making a call to it as shown below.

```php
// Include the proxycheck.io PHP Function
include_once "proxycheck.io.php.function.php";

// If you're using CloudFlare change $_SERVER["REMOTE_ADDR"] to $_SERVER["HTTP_CF_CONNECTING_IP"]
if ( proxycheck_function($_SERVER["REMOTE_ADDR"]) ) {
    
  // Example of a Proxy being detected
  echo "Please turn your Proxy Server off and try our website again.";
  exit;
    
} else {
    
  // No proxy detected.
  echo "No proxy detected.";
    
}
```
If the page you wish to utilise the function in is inside a folder you can use ```..\\``` to traverse backwards. For example if your folder structure is like this:

```
Root \ WWW \ MyWebsite \ Blog \ Login.php
```
And you have the function in the folder called ```MyWebsite``` you could call it using the following include.

```php
include_once "..\\..\\proxycheck.io.php.function.php";
```

## Service Limits
* Free users without an API Key = 100 Daily Queries
* Free users with an API Key = 1,000 Daily Queries
* Paid users with an API Key = 10,000 to 10.24 Million+ Daily Queries

Get your API Key at [proxycheck.io](http://proxycheck.io/) it's free.

## Features
* IPv4 and IPv6 support for both the querying client and the IP being checked
* Check if an IP is operating as a Proxy Server
* Check if an IP is operating as a VPN Server
* Check up-to 1,000 IP Addresses in a single query (v2 API)
* Check the ASN and Company that the IP belongs to
* Check the Country that the IP belongs to
* View the port number the proxy server is operating on
* View how recently we saw an IP Address operating as a proxy server
* Tag queries with descriptions for later analysis
* Comprehensive statistics and logging with API exporting
* Whitelist and Blacklist support for API Key holders (Free and Paid) with API
* Inference Engine access for real-time and post-query detections
* Very fast proxy checking (average 6ms not including network overhead)
* Multiple geographically seperated servers for load distribution and redundancy

## Usage Scenarios
* Protect Blogs and Forums from spam bots
* Protect Chat systems and Game Servers from Bots/Spammers/Cheaters
* Protect payment systems from fradulent transactions
* Restrict content to a specific country by blocking Proxy/VPN users
* Protect all manner of services from previously banned users
