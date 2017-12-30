<?php

  /*
  * A PHP Function which checks if the IP Address specified is a Proxy Server utilising the API provided by https://proxycheck.io
  * This function is covered under an MIT License.
  */

  function proxycheck_function($Visitor_IP) {

    // ------------------------------
    // SETTINGS
    // ------------------------------

    $API_Key = ""; // Supply your API key between the quotes if you have one
    $VPN = "0"; // Change this to 1 if you wish to perform VPN Checks on your visitors
    $TLS = "0"; // Change this to 1 to enable transport security, TLS is much slower though!
    $TAG = "1"; // Change this to 1 to enable tagging of your queries (will show within your dashboard)
    
    // If you would like to tag this traffic with a specific description place it between the quotes.
    // Without a custom tag entered below the domain and page url will be automatically used instead.
    $Custom_Tag = ""; // Example: $Custom_Tag = "My Forum Signup Page";

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
    // However you can supply your own descriptive tag or disable tagging altogether above.
    if ( $TAG == 1 && $Custom_Tag == "" ) {
      $Post_Field = "tag=" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    } else if ( $TAG == 1 && $Custom_Tag != "" ) {
      $Post_Field = "tag=" . $Custom_Tag;
    } else {
      $Post_Field = "";
    }
    
    // Performing the API query to proxycheck.io/v2/ using cURL
    $ch = curl_init($Transport_Type_String . 'proxycheck.io/v2/' . $Visitor_IP . '?key=' . $API_Key . '&vpn=' . $VPN);
    
    $curl_options = array(
      CURLOPT_CONNECTTIMEOUT => 30,
      CURLOPT_POST => 1,
      CURLOPT_POSTFIELDS => $Post_Field,
      CURLOPT_RETURNTRANSFER => true
    );
    
    curl_setopt_array($ch, $curl_options);
    $API_JSON_Result = curl_exec($ch);
    curl_close($ch);
    
    // Decode the JSON from our API
    $Decoded_JSON = json_decode($API_JSON_Result);

    // Check if the IP we're testing is a proxy server
    if ( $Decoded_JSON->$Visitor_IP->proxy == "yes" ) {

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

?>
