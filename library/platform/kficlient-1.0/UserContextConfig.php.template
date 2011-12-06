<?php
// KFID Client Version 1.1 2011-05-24

class UserContextConfig
{
    // 1, Kingdoms of Camelot - prod: 130402594779, staging: 299415635051
    // 2, SweetWorld - legacy
    // 3, Pirate Legacy - legacy
    // 4, Epic Goal - legacy
    // 5, Hero Force - prod: 151729868170673, staging: 
    // 6, Glory of Rome - prod: 140956165916773, staging: 337902643289 
    // 7, Dragons of Atlantis - prod: 111896392174831, staging: 1150141948356247
    // 8, Global Warfare - prod: TBD, staging: 180076125351797 

   public static $KabamAppID = 6;

    public static function getKabamAppID() {
      return UserContextConfig::$KabamAppID;
    }
    
    public static function getFBAppId() {
    	global $appid;
    	switch (ENV) {
    		case 'dev':
    		case 'beta':
    			return "337902643289"; //use the beta app id
    			break;
    		case 'prod':
    			return "$appid";
    			break;
    	}
    }

    public static function getKFIServerURL() {
    	switch (ENV) {
    		case 'dev':
    			return "http://mambo-stg.dev.kabam.com/";
    		case 'beta':
    			return "http://kfi-stage.kabam.com/";
    			break;
    		case 'prod':
    			return "http://kfi.kabam.com/";
			// const KABAM_FEDERATED_ID_URL= 'http://173.45.231.122/tpuid/FBUID/%s/FBAppID/%s/';
    			break;
    	}
    }
    
    public static function getKFICallback() {
    	return true;
    }

    public static function getKabamAppSecret() {
      global $appsecret;
    	switch (ENV) {
    		case 'dev':
    		case 'beta':
		  return "37575edf1e8df811749e469f7b912b51";
		  break;
    		case 'prod':
    			return "$appsecret";
    			break;
    	}
    }

    public static function getKabamApiKey() {
    	switch (ENV) {
    		case 'dev':
    		case 'beta':
    		case 'prod':
    			return "cc1924a45b520685011ade8f5234db6f";
    			break;
    	}
    }

}
?>
