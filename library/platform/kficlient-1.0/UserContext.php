<?php
// NAID Client Version 1.1 2011-05-24

require_once "UserContextConfig.php";
require_once "NAIDRestClient.php";
require_once "DerivedLogger.php";

class UserContext
{

  /**
   * Kabam User ID
   */
  public $kabamUID;

  /**
   * Facebook User ID
   */
  public $fbUID;

  /**
   * Kabam Application ID.
   */
  public $kabamAppID;

  /**
   * Facebook Application ID.
   */
  public $fbAppID;

  /**
   * Kabam Application Third Party ID.
   */
  public $kabamAppTPUID;

  /**
   * Kabam Application Third Party ID Version
   */
  public $kabamAppTPUIDVersion;
}


class UserContextService
{
    //TODO: Read these constants from a config file
    const FB_THIRD_PARTY_URL = "https://api.facebook.com/method/fql.query?query=select%20third_party_id,%20uid%20from%20user%20where%20uid%20=%20REPLACE_UID&access_token=REPLACE_ACCESS&format=json";
    const FB_THIRD_PARTY_URL_MULTI = 'https://api.facebook.com/method/fql.query?query=select%20third_party_id,%20uid%20from%20user%20where%20uid%20in%20(REPLACE_UID)&access_token=REPLACE_ACCESS&format=json';
    private static $kfiRestClient = null;

    protected static function getNAIDClient(){
        if(UserContextService::$kfiRestClient === null) {
	  if (UserContextConfig::getNAIDServerURL() === null ||
	      UserContextConfig::getKabamAppID() === null ||
	      UserContextConfig::getKabamAppSecret() === null) {
	      DerivedLogger::error("Please configure ServerURL, KabamAppID, and  KabamAppSecret in UserContextConfig.php!");
	      return null;
	    }

	  UserContextService::$kfiRestClient = new NAIDRestClient(UserContextConfig::getNAIDServerURL(),
								 UserContextConfig::getKabamAppID(),
								 UserContextConfig::getKabamAppSecret(),
								 UserContextConfig::getKabamApiKey());
        }
        return UserContextService::$kfiRestClient;
    }


    /**
     * Get Third party IDS from Facebook
     * $fbUIDs : array of facebook user ids
     * $fbAppId : facebook application id of the users
     * $access_toke : access token of the session
     * Returns:
     * Array of UserContext object
     */
    public static function getTPIDFromFacebookMulti($fbUIDs, $fbAppID, $access_token) {
      $resultArray = array();

      if (is_array($fbUIDs)) {
	$idStr = implode(",", $fbUIDs);
      } else {
	$idStr = $fbUIDs;
      }

      $url = str_replace(array('REPLACE_UID', 'REPLACE_ACCESS'), array($idStr, $access_token), self::FB_THIRD_PARTY_URL_MULTI);

      try {
	$response = json_decode(file_get_contents($url), true);

	if (is_array($response)) {
	  foreach ($response as $userData) {
	    $userContext = new UserContext();
	    $userContext->fbUID = $userData->uid;
	    $userContext->fbAppID = $fbAppID;
	    $userContext->kabamAppTPUID = $userData->third_party_id;

	    $resultArray[] = $userContext;
	  }
	} else {
	  return false;
	}
      } catch (Exception $e) {
	echo 'Exception: ',  $e->getMessage(), "\n";
	return false;
      }

      return $resultArray;
    }


    /**
     * Returns the Third party Id for a given facebook user and app
     * $fbUID : facebook user id of the user
     * $fbAppId : facebook appliation id of the user
     * $access_toke : access token of the session
     * Returns:
     * UserContext object
     */
    public static function getByfbUIdAndfbAppId($fbUID, $fbAppID, $access_token) {
        return UserContextService::getTPIDFromFacebook($fbUID, $fbAppID,$access_token);
        //return UserContextService::getTPIDFromNAID($fbUID, $fbAppID,$access_token);
    }

    /**
     * Get Third party ID from Facebook
     * $fbUID : facebook user id of the user
     * $fbAppId : facebook appliation id of the user
     * $access_toke : access token of the session
     * Returns:
     * UserContext object
     */
    public static function getTPIDFromFacebook($fbUID, $fbAppID, $access_token) {
        $userContext = new UserContext();
        $userContext->fbUID = $fbUID;
        $userContext->fbAppID = $fbAppID;

        if ($access_token === null || $access_token === "APP_ID_REQUIRED") {
            DerivedLogger::error("Calling getTPIDFromFacebook with $access_token=APP_ID_REQUIRED");
            return $userContext;
        }

        $url = str_replace(array('REPLACE_UID', 'REPLACE_ACCESS'), array($fbUID, $access_token), self::FB_THIRD_PARTY_URL);
        $response = json_decode(file_get_contents($url));

        if (is_array($response) && isset($response[0])) {
	  $userContext->kabamAppTPUID = $response[0]->third_party_id;
	  if(UserContextConfig::getNAIDCallback()){
            try {
	      $result = UserContextService::setNAIDAppTPID($fbUID, $fbAppID, $userContext->kabamAppTPUID);
	      $userContext->kabamUID = $result->UID;
            } catch (Exception $e) {
	      DerivedLogger::error('Caught Error: '. $e->getMessage(). "\n");
	      return $userContext;
            }
	  }
	}
	else {
	  DerivedLogger::error("Invalid response from FB_THIRD_PARTY_URL ". $url. "\n");
	  return $userContext;
	}
        return $userContext;
    }


    /**
     * Get Third party ID from Kabam Federated Server
     * $fbUID : facebook user id of the user
     * $fbAppId : facebook appliation id of the user
     * Returns:
     * UserContext object
     */
    public static function getTPIDFromNAID($fbUID, $fbAppID) 
    {
        $userContext = new UserContext();
        $userContext->fbUID = $fbUID;
        $userContext->fbAppID = $fbAppID;
        $client = UserContextService::getNAIDClient();
        
        $result = $client->callNAID("tpuid", "GET", array("FBUID" => $fbUID, "apikey" => UserContextConfig::getKabamApiKey()));
        if(property_exists($result, "appTPUID"))
            $userContext->kabamAppTPUID = $result->appTPUID;
        if(property_exists($result, "appTPUIDVersion"))
            $userContext->kabamAppTPUIDVersion = $result->appTPUIDVersion;
        if(property_exists($result, "UID"))
            $userContext->kabamUID = $result->UID;

        $userContext->kabamAppID = UserContextConfig::getKabamAppID();
        return $userContext;
    }

    /**
     * Get the KabamUID given the network, gnuid, and appikey with an optional appTPUID from Kabam Federated Server
     * This call is designed to be used without the UserContextConfig for those clients that may need
     * different apikey's, for example, the payment server uses this call.
     * $kfiServerURL : the kfiserver's url 
     * $network : facebook, google, kabam, etc
     * $gnuid : global network id i.e. FBUID or GOOGLEID
     * $api_key : api key of the application
     * $sharedSecret : shared secret of the application
     * Returns:
     * UserContext object
     *
     */
    public static function setKabamIDFromGNUID($kfiServerURL, $network, $gnuid, $appid, $apikey, $sharedSecret, $appTPUID=null)
    {
        $userContext = new UserContext();
        $client = new NAIDRestClient($kfiServerURL, $appid, $sharedSecret, $apikey);

        if($appTPUID != null) {
          $result = $client->callNAID("tpuid", "POST", array("network" => $network, "apikey" => $apikey), array("gnuid"=>$gnuid, "appTPUID"=>$appTPUID));
        }
        else {
          $result = $client->callNAID("tpuid", "POST", array("network" => $network, "apikey" => $apikey), array("gnuid"=>$gnuid));
        }
        if (property_exists($result, 'naid')) {
            $userContext->kabamUID = $result->naid;
        }
        if (property_exists($result, 'appId')) {
            $userContext->kabamAppID = $result->appId;
        }

        return $userContext;
    }

    /**
     * Get the KabamUID given the fbUID, fbAppID and appikey from Kabam Federated Server
     * This call is designed to be used without the UserContextConfig for those clients that may need
     * different apikey's, for example, the payment server uses this call.
     * $kfiServerURL : the kfiserver's url 
     * $fbUID : facebook user id of the user
     * $fbAppId : facebook appliation id of the user
     * Returns:
     * UserContext object
     *
     * Note: Modified for backwards compatibility
     */
    public static function getKabamIDFromNAID($kfiServerURL, $fbUID, $apikey, $sharedSecret) 
    {
      $userContext->fbUID = $fbUID;
      return UserContextService::setKabamIDFromGNUID($kfiServerURL, "facebook", $fbUID, null, $apikey, $sharedSecret);
    }


    /**
     * Sets the App specific Third Party ID for the Kabam Federated Server
     * $fbUID : facebook user id of the user
     * $fbAppId : facebook application id of the user
     * $appTPUID : the Third Party ID for this user / app combination.
     * Returns:
     * true if successful.
     *
     * Note: Modified for backwards compatibility
     */
    public static function setNAIDAppTPID($fbUID, $fbAppID, $appTPUID){
      $context = UserContextService::setKabamIDFromGNUID(UserContextConfig::getNAIDServerURL(), "facebook", $fbUID, UserContextConfig::getKabamAppID(), UserContextConfig::getKabamApiKey(), UserContextConfig::getKabamAppSecret(), $appTPUID);
      $result = array();
      $result['appId'] = $context->kabamAppID;
      $result['UID'] = $context->kabamUID;
      return json_decode(json_encode($result));
    }

    /**
     *  Given a Google+ UserID, return
     *    kabamUID               - the kfid
     *    kabamAppID             - kabam's app id (e.g. 1 - koc, 6 gor, etc)
     *    kabamAppTPUIDVersion   - the version  (e.g. 0)
     *    kabamAppTPUID          - null
     */
    public static function getTPIDFromNAIDGivenGoogleID($guid) 
    {
      return UserContextService::setKabamIDFromGNUID(UserContextConfig::getNAIDServerURL(), "google", $guid, UserContextConfig::getKabamAppID(), UserContextConfig::getKabamApiKey(), UserContextConfig::getKabamAppSecret());
    }

    /**
     * Even though the tpuid is no different for google, this routine makes an entry in the reverseappuser lookup table.
     * This is important since it provides one place to know which games a user is playing.
     *
     * Note: Modified for backwards compatibility
     */
    public static function setNAIDAppTPIDFromGoogleID($guid)
    {
      $context = UserContextService::getTPIDFromNAIDGivenGoogleID($guid);
      $result = array();
      $result['appId'] = $context->kabamAppID;
      $result['UID'] = $context->kabamUID;
      return json_decode(json_encode($result));
    }

    public static function resetNAIDAppTPID($fbUID, $fbAppID)
    {
        $client = UserContextService::getNAIDClient();
        $result = $client->callNAID("tpuid", "DELETE", array("FBUID" => $fbUID, "apikey" => UserContextConfig::getKabamApiKey()));
        return $result;
    }

    /**
     * *** For Payment Server ***
     * Gets FBUID from the Kabam Federated Server
     * $kabamAppID : Kabam App ID
     * $kabamAppTPUID : the Third Party ID for this user / app combination.
     * Returns:
     * FBUID
     */

    public static function getFBUIDByAppIdAndAppTPUID($kabamAppID, $kabamAppTPUID){
        $client = UserContextService::getNAIDClient();
        $data = array("appID" => $kabamAppID, "appTPUID" => $kabamAppTPUID);
	$result = $client->callNAID("reverse", "GET", array("apikey" => UserContextConfig::getKabamApiKey(), "TPUID" => $kabamAppTPUID));
        return $result->fbUID;
    }

    /**
     *  Given a Mobile UDID and mobile device type, get an naid for this device
     *    udid                   - device id
     *    type                   - "iphone" or "android" are accepted
     *    access_token           - oauth access token used to access the account after initial request
     *    naid                   - network abstraction id
     *  Service:  POST	/mobile/account/register/guest/client_id/<client_id>
     *         	  { udid, type, sig }
     *            => { access_token, naid }	
     */
    private static function mobileRegisterGuest($udid, $type) {
      if ($type != "iphone" && $type != "android") {
	return;
      }
      $client = UserContextService::getNAIDClient();
      $result = $client->callNAID("mobile/account/register/guest", "POST", array("client_id" => UserContextConfig::getKabamAppId()), array("udid"=>$udid, "type"=>$type));
      return $result;
    }

    public static function mobileRegisterIphoneGuest($udid) {
      return UserContextService::mobileRegisterGuest($udid, "iphone");
    }

    public static function mobileRegisterAndroidGuest($udid) {
      return UserContextService::mobileRegisterGuest($udid, "android");
    }

    /**
     *  Given an naid and Login account credentials, device should call this service
     *  directly against the platform service, rather than through game server
     *    $naid : network abstraction id
     *    $email : email address of registering user
     *    $password : password of registering user
     *    $redirect_url : url of game server to direct to
     *    POST /mobile/account/login/upgrade/client_id/<client_id>
     *    { naid, email, password, redirect_url, sig }
     *    => { code, naid, kabam_id }
     */
    public static function mobileLoginUpgrade($naid, $email, $password) {
      $client = new NAIDRestClient(UserContextConfig::getNAIDServerURL(),
				  UserContextConfig::getKabamAppID(),
				  UserContextConfig::getKabamAppSecret(),
				  UserContextConfig::getKabamApiKey());
      $result = $client->callNAID("mobile/account/login/upgrade", "POST", array("client_id" => UserContextConfig::getKabamAppID()), array("naid"=>$naid, "email"=>$email, "password"=>$password, "redirect_url"=>"null"));
      return $result;
    }

    /**
     *  Given an naid and Login account credentials, device should call this service
     *  directly against the platform service, rather than through game server
     *    $naid : network abstraction id
     *    $email : email address of registering user
     *    $password : password of registering user
     *    $redirect_url : url of game server to direct to
     *    POST /mobile/account/login/client_id/<client_id>
     *    { naid, email, password, redirect_url, sig }
     *    => { code, naid, kabam_id }
     */
    public static function mobileLogin($email, $password) {
      $client = new NAIDRestClient(UserContextConfig::getNAIDServerURL(),
				  UserContextConfig::getKabamAppID(),
				  UserContextConfig::getKabamAppSecret(),
				  UserContextConfig::getKabamApiKey());
      $result = $client->callNAID("mobile/account/login", "POST", array("client_id" => UserContextConfig::getKabamAppID()), array("email"=>$email, "password"=>$password, "redirect_url"=>"null"));
      return $result;
    }

    /**
     *  Given a Mobile UDID and mobile device type, get an list of naids that have already been requested
     *    udid                   - device id
     *    type                   - "iphone" or "android" are accepted
     *    access_token           - oauth access token used to access the account after initial request
     *    naid                   - network abstraction id
     *    kabam_id               - this field represents identification of Kabam email/password accounts
     *    gnuid                  - global network id
     *    network                - network id mapping to kabam networks i.e. facebook, kabam, iphone, android
     *  Service:  POST /tpuid/network/{network}/query/client_id/{client_id}
     *      { gnuid, sig }
     *      => [naid, kabam_id, gnuid, network]
     */
    public static function mobileQueryUDID($udid, $type) {
      $client = UserContextService::getNAIDClient();
      $result = $client->callNAID("tpuid/query", "POST", array("network" => $type, "client_id" => UserContextConfig::getKabamAppID()), array("gnuid"=>$udid));
      return $result;
    }

    /**
     *  Given an access_token, call the oauth server to make sure it's still valid
     *    access_token           - oauth access token used to access the account after initial request
     *    naid                   - network abstraction id
     *    POST /oauth/me?client_id=<client_id>&acessToken=<access_token>&client_secret=<secret>
     *    => {user_info}
     */
    public static function oauthValidateAccessToken($naid, $access_token) {
      $client = UserContextService::getNAIDClient();
      $result = $client->callNAID("oauth/me", "GET", array(), array("client_id"=>UserContextConfig::getKabamAppID(), "accessToken"=>$access_token, "client_secret"=>UserContextConfig::getKabamAppSecret()));
      return $result;
    }
    
    /**
     *  Given an naid and upgrade account credentials, device should call this service
     *  directly against the platform service, rather than through game server
     *    $naid : network abstraction id
     *    $email : email address of registering user
     *    $password : password of registering user
     *    $redirect_url : url of game server to direct to
     *    POST /mobile/register/upgrade/client_id/<client_id>
     *    { naid, email, password, redirect_url, sig }
     *    => { code, naid, kabam_id }
     */
    public static function mobileUpgradeGuest($naid, $email, $password) {
      $client = new NAIDRestClient(UserContextConfig::getNAIDServerURL(),
				  UserContextConfig::getKabamAppID(),
				  UserContextConfig::getKabamAppSecret(),
				  UserContextConfig::getKabamApiKey());
      $result = $client->callNAID("mobile/account/register/upgrade", "POST", array("client_id" => UserContextConfig::getKabamAppID()), array("naid"=>$naid, "email"=>$email, "password"=>$password, "redirect_url"=>"null"));
      return $result;
    }

    /**
     *  Given an access_token, call the oauth server to make sure it's still valid
     *    $naid : network abstraction id
     *    $code : oauth code originally retrieved in the initial upgrade request
     *    ($client_secret : shared secret used to verify identity the request came from a trusted game)
     *    $access_token : Used to access the account for future verification purposes
     *    POST /account/register/upgrade/verify/client_id/<client_id>
     *    { naid, code, client_secret }
     *    => {access_token}
     */
    public static function mobileVerifyLogin($naid, $code) {
      $client = new NAIDRestClient(UserContextConfig::getNAIDServerURL(),
				  UserContextConfig::getKabamAppID(),
				  UserContextConfig::getKabamAppSecret(),
				  UserContextConfig::getKabamApiKey());
      $result = $client->callNAID("mobile/account/login/verify", "POST", array("client_id" => UserContextConfig::getKabamAppID()), array("naid"=>$naid, "code"=>$code, "client_secret"=>UserContextConfig::getKabamAppSecret()));
      return $result;
    }
}
?>
