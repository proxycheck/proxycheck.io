<?php

  // ------------------------------
  // INSTRUCTIONS
  // Place the function proxycheck.io.php.function.php in the same folder as this example file.
  // Run this example by navigating to it in your browser, your IP Address will be checked against the API.
  // To supply your API Key and flags to the API modify the function file noted above.
  // ------------------------------
  
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
  
?>
