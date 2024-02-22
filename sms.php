<?php 

echo WISMS('192.168.93.214', '9710', 'admin', 'N4suaKDS!', '+639392998228', 'WIS Update: Your child Chester tapped in at 11:49:05 AM today Jan 10, 2024.');
  
function WISMS($host, $port, $userName, $password, $number, $message)
{
  
    /* Create the HTTP API query string */
    $query = 'http://'.$host.':'.$port;
    $query .= '/http/send-message/';
    $query .= '?username='.urlencode($userName);
    $query .= '&password='.urlencode($password);
    $query .= '&to='.urlencode($number);
    $query .= '&message='.urlencode($message);
      
    /* Send the HTTP API request and return the response */
    return file_get_contents($query);  
}
