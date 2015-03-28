<?php

//If there's no Access Token then use the defaults
$access_token_array = array(
    '300694180076642|-cozSG1L4topnAqQOwaIEpy4Ufk',
    '439271626171835|-V79s0TIUVsjj_5lgc6ydVvaFZ8',
    '188877464498533|gObD45qMCG-uE9WGVt3-djx-6Sw',
    '636437039752698|Tt-zXlDy-Nu4CCkNteGfcUe65ow',
    '1448491852049169|eUTjw_pIVoPzC1R1pxVQhmtFqQ0'
);
$access_token = $access_token_array[rand(0, 4)];

//Include this function as it isn't automatically included if the wp-config.php file can't be found
function cff_fetchUrl($url){
    //Can we use cURL?
    if(is_callable('curl_init')){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate,sdch');
        $feedData = curl_exec($ch);
        curl_close($ch);
    //If not then use file_get_contents
    } elseif ( ini_get('allow_url_fopen') == 1 || ini_get('allow_url_fopen') === TRUE ) {
        $feedData = @file_get_contents($url);
    //Or else use the WP HTTP API
    } else {
        $request = new WP_Http;
        $response = $request->request($urls, array('timeout' => 60, 'sslverify' => false));
        if( is_wp_error( $response ) ) {
            //Don't display an error, just use the Server config Error Reference message
           echo '';
        } else {
            $feedData = wp_remote_retrieve_body($response);
        }
    }
    
    return $feedData;
}

?>