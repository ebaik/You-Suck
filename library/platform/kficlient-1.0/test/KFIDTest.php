<?php

include_once(__DIR__ . '/../UserContext.php');
include_once(__DIR__ . '/../UserContextConfig.php');
include_once(__DIR__ . '/../KFIRestClient.php');
//include_once(__DIR__ . '/../fb/FbApiCalls.php');

define ('ENV', 'dev');

class KFIDTest extends PHPUnit_Framework_TestCase
{
    public function testKFID()
    {
        $saved = array();
        $fbAppID = UserContextConfig::getFBAppId();
        for ($i = 0; $i < 10; $i++) {
            $fbUID = rand();
            $fb = UserContextConfig::getFBAppId();

            $json = UserContextService::getTPIDFromKFI($fbUID, $fbAppID);
        
            $this->assertTrue($json !== null, 'kfuid failed');
            $this->assertTrue(isset($json->kabamUID) && $json->kabamUID != null, 'KabamUID is set');
            $this->assertTrue(isset($json->kabamAppID) && $json->kabamAppID != null, 'appID is set');
            $saved[$fbUID] = $json->kabamUID;
            if ($i % 1000 == 0) {
                echo "Created: " . $i . "\n";
            }
        }
        foreach ($saved as $fbuid => $uid) {
            $json = UserContextService::getTPIDFromKFI($fbuid, $fbAppID);
            $this->assertTrue($json->kabamUID == $uid, 'UID equals the last time');
        }
    }

    public function testKFIDGoogle()
    {
        $saved = array();
        for ($i = 0; $i < 10; $i++) {
            $guid = rand();
            $json = UserContextService::getTPIDFromKFIGivenGoogleID($guid);
        
            $this->assertTrue($json !== null, 'kfuid failed');
            $this->assertTrue(isset($json->kabamUID) && $json->kabamUID != null, 'KabamUID is set');
            $this->assertTrue(isset($json->kabamAppID) && $json->kabamAppID != null, 'appID is set');
            $saved[$guid] = $json->kabamUID;
            if ($i % 1000 == 0) {
                echo "Created: " . $i . "\n";
            }
        }
        foreach ($saved as $guid => $uid) {
            $json = UserContextService::getTPIDFromKFIGivenGoogleID($guid);
            $this->assertTrue($json->kabamUID == $uid, 'UID equals the last time');
        }
    }

    public function testSetKFID()
    {
        $saved = array();
        $fbAppID = UserContextConfig::getFBAppId();
        $tpAppID = rand();
        for ($i = 0; $i < 10; $i++) {
            $fbUID = rand();
            $fb = UserContextConfig::getFBAppId();

            $json = UserContextService::setKFIAppTPID($fbUID, $fbAppID, $tpAppID);
            $this->assertTrue($json !== null, 'kfuid failed');
            $this->assertTrue(isset($json->UID) && $json->UID != null, 'KabamUID is set');
            $saved[$fbUID] = $json->UID;
            if ($i % 1000 == 0) {
                echo "Created: " . $i . "\n";
            }
        }
        foreach ($saved as $fbuid => $uid) {
            $json = UserContextService::setKFIAppTPID($fbuid, $fbAppID, $tpAppID);
            $this->assertTrue($json->UID == $uid, 'UID equals the last time');
        }
    }

    public function testSetKFIDGoogle()
    {
        $saved = array();
        for ($i = 0; $i < 10; $i++) {
            $guid = rand();
            $json = UserContextService::setKFIAppTPIDFromGoogleID($guid);
        
            $this->assertTrue($json !== null, 'kfuid failed');
            $this->assertTrue(isset($json->UID) && $json->UID != null, 'KabamUID is set');
            $saved[$guid] = $json->UID;
            if ($i % 1000 == 0) {
                echo "Created: " . $i . "\n";
            }
        }
        foreach ($saved as $guid => $uid) {
            $json = UserContextService::setKFIAppTPIDFromGoogleID($guid);
            $this->assertTrue($json->UID == $uid, 'UID equals the last time');
        }
    }

    public function testServerError()
    {
        $fbUID = rand(); 
        $msg = null;
        try {
            $serverUrl = "http://nonexistent.com/";
            // random/wrong apikey
            $apikey = '89q2383q498747878erwt';
            $json = UserContextService::getKabamIDFromKFI($serverUrl, $fbUID, $apikey, null);
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $this->assertTrue($msg != null, "should get error when tryign to get non existent.com kfid");
    }

    public function testErrorKFID()
    {
        $fbUID = rand(); 
        $msg = null;
        try {
            $serverUrl = UserContextConfig::getKFIServerURL();
            // random/wrong apikey
            $apikey = '89q2383q498747878erwt';
            $json = UserContextService::getKabamIDFromKFI($serverUrl, $fbUID, $apikey, null);
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        $this->assertTrue($msg != null && $msg == "Error: Application error response from KFID request: GET to http://mambo-stg.dev.kabam.com/tpuid/FBUID/$fbUID/apikey/$apikey Signature verfication failed.", "error message mismatch $msg != 'Error: Application error response from KFID request: GET to http://mambo-stg.dev.kabam.com/tpuid/FBUID/$fbUID/apikey/$apikey Signature verfication failed.'");
    }

    public function testBackwardKFID()
    {
      $client = new KFIRestClient(UserContextConfig::getKFIServerURL(),
				  UserContextConfig::getKabamAppID(),
				  UserContextConfig::getKabamAppSecret(),
				  UserContextConfig::getKabamApiKey());

      $fbAppId = UserContextConfig::getFBAppId();
        for ($i = 0; $i < 10; $i++) {
            $fbUID = rand();
            $json = $client->callKFI("tpuid", "GET", array("FBUID" => $fbUID, "FBAppID" => $fbAppId));
            $this->assertTrue($json !== null, 'kfuid failed');
            $this->assertTrue(isset($json->UID) && $json->UID != null, 'KabamUID is set');
            $this->assertTrue(isset($json->appID) && $json->appID != null, 'appID is set');
            $saved[$fbUID] = $json->UID;
            if ($i % 1000 == 0) {
                echo "Backward Compatible: " . $i . "\n";
            }
        }
        foreach ($saved as $fbuid => $uid) {
            $json = $client->callKFI("tpuid", "GET", array("FBUID" => $fbuid, "FBAppID" => $fbAppId));
            $this->assertTrue($json->UID == $uid, 'UID equals the last time');
        }
    }

    public function testReverseKFID()
    {
        // $saved = array();
        // $fbAppID = UserContextConfig::$FBAppId;
        // $tpAppID = rand();
        // $fb = UserContextConfig::$FBAppId;
        // $fbuid = UserContextService::getFBUIDByAppIdAndAppTPUID(1, '1246978807');
        // $this->assertTrue($fbuid !== null, 'fbuid is set');
    }

    public function testBadAppIDTPIDFromFacebook()
    {
      $fbUID = rand();
      $fbAppID = UserContextConfig::getFBAppId();
      $access_token = "APP_ID_REQUIRED";
      try {
          $json = UserContextService::getTPIDFromFacebook($fbUID, $fbAppID, $access_token);
          $this->assertTrue(false, 'no error found');
      } catch (Exception $e) {
          $this->assertTrue(true, 'error found');
      }
    }
}
