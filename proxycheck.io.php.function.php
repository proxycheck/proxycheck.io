<?php

  /*
  * A PHP Function which checks if the IP Address specified is a Proxy Server utilising the API provided by https://proxycheck.io
  * This example includes not only the function itself but also some example code that utilises the function at the very bottom.
  * This function is covered under an MIT License.
  */

  function proxycheck_function($Visitor_IP) {

    // ------------------------------
    // SETTINGS
    // ------------------------------

    $API_Key = ""; // Supply your API key between the quotes if you have one
    $VPN = "0"; // Change this to 1 if you wish to perform VPN Checks on your visitors
    $TLS = "0"; // Change this to 1 to enable transport security, TLS is much slower though!
    $TAG = "1"; // This setting tags your queries with a message you can view in your dashboard stats

    // ------------------------------
    // END OF SETTINGS
    // ------------------------------

    // Setup the correct querying string for the transport security selected.
    if ( $TLS == 1 ) {
      $Transport_Type_String = "https://";
    } else {
      $Transport_Type_String = "http://";
    }
    
    // By default the tag used is your querying domain and the webpage being accessed
    // However you can supply your own descriptive tag or disable tagging altogether.
    if ( $TAG == 1 ) {
      $Query_Tag = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    } else {
      $Query_Tag = "";
    }
    
    // Performing the API query to proxycheck.io/v1/ using cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Transport_Type_String . 'proxycheck.io/v1/' . $Visitor_IP . '&key=' . $API_Key . '&vpn=' . $VPN . "&tag=" . urlencode($Query_Tag));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $API_JSON_Result = curl_exec($ch);
    curl_close($ch);

    // Decode the JSON from our API
    $Decoded_JSON = json_decode($API_JSON_Result);

    // Check if the IP we're testing is a proxy server
    if ( $Decoded_JSON->proxy == "yes" && $Decoded_JSON->ip == $Visitor_IP) {

      // A proxy has been detected.
      return true;
      
    } else {
      
      if ( $Decoded_JSON->ip != $Visitor_IP ) {
      
        // If an error occured while querying the API this is where the error will be caught.
        // It is recommended for you to setup some kind of alert or log entry to capture these errors for later analysis.
      
      }
      
      // No proxy has been detected.
      return false;
      
    }
    
  }
  
  // ------------------------------
  // EXAMPLE
  // ------------------------------

  // If you're using CloudFlare change $_SERVER["REMOTE_ADDR"] to $_SERVER["HTTP_CF_CONNECTING_IP"]
  if ( proxycheck_function($_SERVER["REMOTE_ADDR"]) ) {
    
    // Example of a Proxy being detected
    echo "Please turn your Proxy Server off and try our website again.";
    exit;

  } else {
    
    // No proxy detected.
    echo "No proxy detected.";
    
  }

  // ------------------------------
  // END OF EXAMPLE
  // ------------------------------

?>
