<?php
//Process a new form submission in HubSpot in order to create a new Contact.

function post_to_hubspot($portalId, $formId, $name, $email, $message, $origin){

    $portalId = "3891312";
    $formId = "834c2929-b462-4b7c-ad49-5b8f62ff7167";

    $hubspotutk      = $_COOKIE['hubspotutk']; //grab the cookie from the visitors browser.
    $ip_addr         = $_SERVER['REMOTE_ADDR']; //IP address too.
    $hs_context      = array(
        'hutk' => $hubspotutk,
        'ipAddress' => $ip_addr,
        'pageUrl' => $_SERVER['HTTP_REFERER'],
        'pageName' => $origin
    );
    $hs_context_json = json_encode($hs_context);

    //Need to populate these variable with values from the form.
    $str_post = "name=" . urlencode($name)
        . "&email=" . urlencode($email)
        . "&hs_context=" . urlencode($hs_context_json); //Leave this one be

    //replace the values in this URL with your portal ID and your form GUID
    $endpoint = "https://forms.hubspot.com/uploads/form/v2/$portalId/$formId";

    var_dump($str_post);
    var_dump($endpoint);

    $ch = @curl_init();
    @curl_setopt($ch, CURLOPT_POST, true);
    @curl_setopt($ch, CURLOPT_POSTFIELDS, $str_post);
    @curl_setopt($ch, CURLOPT_URL, $endpoint);
    @curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/x-www-form-urlencoded'
    ));
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response    = @curl_exec($ch); //Log the response from HubSpot as needed.
    $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE); //Log the response status code
    @curl_close($ch);
    echo $status_code . " " . $response;

}