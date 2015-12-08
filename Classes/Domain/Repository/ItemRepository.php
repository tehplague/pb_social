<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Mikolaj Jedrzejewski <mj@plusb.de>, plusB
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

//require_once( "typo3conf/ext/pb_besocial/Resources/Libs/Sdk/facebook/src/facebook.php" );
//require_once( "typo3conf/ext/pb_besocial/Resources/Libs/Sdk/instagram/src/Instagram.php" );
//require_once( "typo3conf/ext/pb_besocial/Resources/Libs/Sdk/twitter/TwitterAPIExchange.php" );
//use MetzWeb\Instagram\Instagram;


/**
 *
 *
 * @package pb_besocial
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PbBesocial_Domain_Repository_ItemRepository extends Tx_Extbase_Persistence_Repository {

    /**
     * @param string $type
     * @return Tx_PbBesocial_Domain_Model_Item
     */
    function findFeedsByType($type){
        $refreshTimeInMin = 10;
        $feedRequestLimit = 20;

        switch ($type){

            //
            // FACEBOOK
            //
            case "facebook":
                $feeds = $this->findByType($type);

                if($feeds && $feeds->count() > 0){
                    $feed = $feeds->getFirst();
                    if(($feed->getDate() + $refreshTimeInMin*60) < time()){
                        try{
                            $feed->setDate(time());
                            $facebook = new Facebook(array(
                                'appId'  => '1479262395685504',
                                'secret' => '8adfcecf7b74bb5756d4b7389c49e486',
                            ));
                            $feed->setResult(json_encode($facebook->api($feed->getUrl())));
                        }
                        catch (FacebookApiException $e){
                            //TODO WRITE LOG
                        }
                    }
                    return $feed;
                }
                else{
                    try {
                        $facebook = new Facebook(array(
                            'appId'  => '1479262395685504',
                            'secret' => '8adfcecf7b74bb5756d4b7389c49e486',
                        ));

                        $feed = new Tx_PbBesocial_Domain_Model_Item();
                        $feed->setType($type);
                        $feed->setDate(time());
                        $feed->setUrl('/226066384147152/feed?limit='.$feedRequestLimit);
                        $result = json_encode($facebook->api($feed->getUrl()));
                        $feed->setResult($result);

                        // save to DB
                        $this->add($feed);
                        $persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
                        $persistenceManager->persistAll();

                        return $feed;

                    } catch (FacebookApiException $e) {
                        //TODO WRITE LOG
                        return null;
                    }
                }
                break;

            //
            // GOOGLE
            //
            case "googleplus":
                $feeds = $this->findByType($type);
                $google_plus_id = '115301618461279886910';
                $appKey = 'AIzaSyDbHoXWr_g9npNAhgRdTnoAG8llxLMMFbA';

                $headers = array( 'Content-Type: application/json', );
                $fields = array( 'key' => $appKey, 'format' => 'json', 'ip' => $_SERVER['REMOTE_ADDR'] );
                $url = 'https://www.googleapis.com/plus/v1/people/'.$google_plus_id.'/activities/public?' . http_build_query($fields);

                if($feeds && $feeds->count() > 0){
                    $feed = $feeds->getFirst();
                    if(($feed->getDate() + $refreshTimeInMin*60) < time()){
                        try{
                            $feed->setDate(time());

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, false);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                            $feed->setResult(curl_exec($ch));
                            curl_close($ch);
                        }
                        catch (Exception $e){
                            //TODO WRITE LOG
                        }
                    }
                    return $feed;
                }
                else{
                    try {
                        $feed = new Tx_PbBesocial_Domain_Model_Item();
                        $feed->setType($type);
                        $feed->setDate(time());
                        $feed->setUrl($url);

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, false);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                        $feed->setResult(curl_exec($ch));
                        curl_close($ch);

                        // save to DB
                        $this->add($feed);
                        $persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
                        $persistenceManager->persistAll();
                        return $feed;

                    } catch (Exception $e) {
                        //TODO WRITE LOG
                        return null;
                    }
                }
                break;

            //
            // INSTAGRAM
            //
            case "instagram":
                $client_id = "8fb9c20e37044f1da7f27bc69cc43bfe";
                $search_id = "1443467082";
                $limit = 20;

                $feeds = $this->findByType($type);

                if($feeds && $feeds->count() > 0){
                    $feed = $feeds->getFirst();
                    if(($feed->getDate() + $refreshTimeInMin*60) < time()){
                        try{
                            $feed->setDate(time());
                            $instagram = new Instagram($client_id);
                            $feed->setResult(json_encode($instagram->getUserMedia($search_id, $limit)));
                        }
                        catch (Exception $e){
                            //TODO WRITE LOG
                        }
                    }
                    return $feed;
                }
                else{
                    try {
                        $feed = new Tx_PbBesocial_Domain_Model_Item();
                        $feed->setType($type);
                        $feed->setDate(time());
                        $feed->setUrl("getUserMedia(".$search_id.")");

                        $instagram = new Instagram($client_id);
                        $feed->setResult(json_encode($instagram->getUserMedia($search_id, $limit)));

                        // save to DB
                        $this->add($feed);
                        $persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
                        $persistenceManager->persistAll();
                        return $feed;

                    } catch (Exception $e) {
                        //TODO WRITE LOG
                        return null;
                    }
                }
                break;

            //
            // TWITTER
            //
            case "twitter":
                // Set access tokens here - see: https://dev.twitter.com/apps/
                $settings = array(
                    'oauth_access_token' => "2427039594-xAw65aG1nyTqTqBPnyBx6Qw8jaAMX9r08IPz0rD",
                    'oauth_access_token_secret' => "eQWtN82drxXcbARtvK3kkvbLR8EZhtCPEjVhpQwUaGVPd",
                    'consumer_key' => "xejdUj6VZpzxfjhlIko57tgCP",
                    'consumer_secret' => "KUHfjYazqlFbd0sKdZNohuiIfC6wup7Ypa2D8fJzNmkAPs90vl"
                );

                // Perform a GET request and echo the response
                // Note: Set the GET field BEFORE calling buildOauth();
                $url = 'https://api.twitter.com/1.1/search/tweets.json';
                $getfield = '?q=#talentberlin';
                $requestMethod = 'GET';


                $feeds = $this->findByType($type);

                if($feeds && $feeds->count() > 0){
                    $feed = $feeds->getFirst();
                    if(($feed->getDate() + $refreshTimeInMin*60) < time()){
                        try{
                            $feed->setDate(time());
                            $twitter = new TwitterAPIExchange($settings);
                            $feed->setResult($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest());
                        }
                        catch (Exception $e){
                            //TODO => log
                        }
                    }
                    return $feed;
                }
                else{
                    try {
                        $feed = new Tx_PbBesocial_Domain_Model_Item();
                        $feed->setType($type);
                        $feed->setDate(time());
                        $feed->setUrl("TODO");

                        $twitter = new TwitterAPIExchange($settings);
                        $feed->setResult($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest());

                        // save to DB
                        $this->add($feed);
                        $persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
                        $persistenceManager->persistAll();
                        return $feed;

                    } catch (FacebookApiException $e) {
                        //TODO => log
                        return null;
                    }
                }
                break;
        }
    }

    /**
     * @param string $url
     * @return string
     */
    function findContentByUrl($url = ""){
        $facebook = new Facebook(array(
            'appId'  => '1479262395685504',
            'secret' => '8adfcecf7b74bb5756d4b7389c49e486',
        ));

        if($url == ""){ return "";}

        try{
            return json_encode($facebook->api($url));
        }
        catch(Exception $e){
            return "";
        }
    }

    const ERROR = 'ERROR';
    const WARNING = 'WARNING';
    const NOTICE = 'NOTICE';

    public function writeLog($logType, $message, $data){

//        $filepath = PATH_site . 'typo3conf/social-debug.log';

//        $time = new DateTime('now');
//
//        $content = sprintf('[%s] - %s: %s', $time->format('d-m-Y H:i:s'), $logType, $message);
//        $content .= "\r\n";
//        $content .= sprintf('DATA: %s', $data);
//        $content .= "\r\n";
//        $content .= "\r\n";
//
//        echo '<!-- <div style="display: none">' . $content . '</div>-->';

        //file_put_contents($filepath, $content, FILE_APPEND);
    }
}
?>