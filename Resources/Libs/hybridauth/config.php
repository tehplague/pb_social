<?php
/**
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2014, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return 
	array(
		"base_url" => "http://museum.pos.ch/typo3conf/ext/pb_besocial/Resources/Libs/hybridauth/",

		"providers" => array ( 
			// openid providers
			"OpenID" => array (
				"enabled" => false
			),

			"Yahoo" => array ( 
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ),
			),

			"AOL"  => array ( 
				"enabled" => false
			),

			"Google" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "405360486431-jvsc3ls3istv1dp3l6jggb9rai8aej18.apps.googleusercontent.com", "secret" => "Y7pOmCd1UX2mEARTU3iiiFLn" ), // application consumer key -
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "1479262395685504", "secret" => "8adfcecf7b74bb5756d4b7389c49e486" ),
				"trustForwarded" => false
			),

			"Twitter" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "ASD", "secret" => "" )
			),

			// windows live
			"Live" => array ( 
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),

			"LinkedIn" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "", "secret" => "" ) 
			),

			"Foursquare" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "", "secret" => "" ) 
			),

            "Instagram" => array (
                "enabled" => true,
                "keys"    => array ( "id" => "9eedf3c7ec3643e2836f3c67cf21476c", "secret" => "9f202185660c4727bedb30f204469131" )
            ),
		),

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,

		"debug_file" => "",
	);