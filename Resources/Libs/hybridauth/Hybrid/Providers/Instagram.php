<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | https://github.com/hybridauth/hybridauth
*  (c) 2009-2012 HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

/**
 * Hybrid_Providers_Instagram (By Sebastian Lasse - https://github.com/sebilasse)
 */
class Hybrid_Providers_Instagram extends Hybrid_Provider_Model_OAuth2
{
    // default permissions
    public $scope = "basic";

    /**
     * IDp wrappers initializer
     */
    function initialize()
    {
        parent::initialize();

        // Provider api end-points
        $this->api->api_base_url  = "https://api.instagram.com/v1/";
        $this->api->authorize_url = "https://api.instagram.com/oauth/authorize/";
        $this->api->token_url     = "https://api.instagram.com/oauth/access_token";
    }

    /**
     * load the user profile from the IDp api client
     */
    function getUserProfile(){
        $data = $this->api->api("users/self/" );

        if ( $data->meta->code != 200 ){
            throw new Exception( "User profile request failed! {$this->providerId} returned an invalid response.", 6 );
        }

        $this->user->profile->identifier  = $data->data->id;
        $this->user->profile->displayName = $data->data->full_name ? $data->data->full_name : $data->data->username;
        $this->user->profile->description = $data->data->bio;
        $this->user->profile->photoURL    = $data->data->profile_picture;

        $this->user->profile->webSiteURL  = $data->data->website;

        $this->user->profile->username    = $data->data->username;

        return $this->user->profile;
    }

    // +++ MJ 09.10.14 +++
    /**
     * @param string $type
     */
    function getUserActivity()
    {
        // refresh tokens if needed
        $this->refreshToken();
        $activities = array();

        //1443467082 = swmb.museum
        //$response = $this->api->api("users/self/feed");
        $response = $this->api->api("users/1443467082/media/recent");
        if( !$response ){ return ARRAY(); }

        foreach( $response->data as $item ){
            $ua = new Hybrid_User_Activity();
            $ua->id = $item->id;
            $ua->date = $item->created_time;
            $ua->text = $item->caption->text;
            $ua->raw = $item;
            $activities[] = $ua;
        }

        return $activities;
    }
    // --- MJ ---
}