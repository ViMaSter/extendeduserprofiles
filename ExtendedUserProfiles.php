<?php
	/**
	* Extended Userprofiles
	* MediaWiki-extension extending user-profiles for usage with the OHI-Tool
	* @author Vincent Mahnke
	*/

	//Alert the user that this is not a valid entry point to MediaWiki
	if( !defined( 'MEDIAWIKI' ) ) {
		die( 'Not an entry point.' );
	}

	//Take credit for your work.
	//$wgExtensionCredits['others'][] = array(
	$wgExtensionCredits[defined( 'SEMANTIC_EXTENSION_TYPE' ) ? 'semantic' : 'specialpage'][] = array(
		'path' => __FILE__,
		//The name of the extension, which will appear on Special:Version.
		'name' => 'Extended Userprofiles',
		//The version of the extension, which will appear on Special:Version.
		'version' => '0.1',
		//The name of the author, which will appear on Special:Version
		'author' => [
			'[https://vincent.mahn.ke/ Vincent Mahnke]'
		],
		//The URL to a wiki page/web page with information about the extension, which will appear on Special:Version
		'url' => 'https://github.com/ViMaSter/extendeduserprofiles/',
		//The description, which will appear on Special:Version
		'descriptionmsg' => 'extendeduserprofiles-desc',
		'license-name' => 'GPL-2.0+'
	);


    var_dump("AAAAAAAAA");
