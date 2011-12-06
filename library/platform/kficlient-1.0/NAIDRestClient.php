<?php

class NAIDRestClient 
{
    // If appid and secret key are set then sign the request
    protected $serverUrl;
    protected $appId;
    protected $secretKey;
    protected $apiKey;
    private $full_error = true;

    public function __construct($serverUrl, $appid, $secretKey, $apiKey)
    {
        if(substr_compare($serverUrl, "/", -1, 1)) $serverUrl .= "/";
        $this->serverUrl = $serverUrl;

	// Always sign requests
	$this->appId = $appid;
	$this->secretKey = $secretKey;
	$this->apiKey = $apiKey;
    }

    public function callNAID($function, $method, $args, $data=null){
        $method = strtoupper($method);
        $path = $function;
        if ($this->secretKey && isset($data["data"])) {
            $data["data"] = json_encode($data["data"]);
        }
        if ($this->secretKey && isset($this->appId)) {
            $signeddata = array();
            if (isset($this->appId)) {
                $signeddata['appid'] = $this->appId;
            }
            $signeddata = array_merge($signeddata, $args);
            if (isset($data)) {
                $signeddata = array_merge($signeddata, $data);
            } else {
                $data = array();
            }
	    //	    print "Generating with siged data ".json_encode($signeddata). " and secret key ".$this->secretKey."\n";
            $data['sig2'] = $this->_generateSignature($signeddata, $this->secretKey);
	    //	    print "Signature is ".$data['sig2']."\n";
            if (isset($this->appId)) {
                $data['appid'] = $this->appId;
            }
        }
        if ($data) {
	  $data = http_build_query($data, '', '&');
        }
        foreach($args as $key => $value){
            $path .= "/{$key}/{$value}";
        }
        $url = $this->serverUrl . $path;
        if($data && $method != "POST"){
            $url .= "?" . $data;
        }

	// Retry once if we get http error
	try {
	  $rawResult = $this->_make_request($method, $url, $data);
	} catch(Exception $e) {
	  DerivedLogger::info("Got first NAID exception: $e.  Retrying...");
	  try {
	    $rawResult = $this->_make_request($method, $url, $data);
	  }
	  catch(Exception $e) {
	    DerivedLogger::info("Got NAID exception after retry: $e. Failing.");
	    throw $e;
	  }
	}

	// Check for empty response
        $result = json_decode($rawResult);
        if($result === null || $result === false){
	  $msg = "Null/empty response from NAID request: $method to $url.  Response: $result";
	  DerivedLogger::error($msg);
	  throw new Exception($msg);
        }
	// Check for invalid responses
        if(!is_array($result)) {

	  // Check for error response
	  if(property_exists($result, "error")){
	    $msg = "Application error response from NAID request: $method to $url ". $result->error;
	    DerivedLogger::error($msg);
	    if ($full_error) {
	      $result->msg = $msg;
	      throw new Exception($result);
	    }
	    else {
	      throw new Exception($msg);
	    }
	  }
	  
	  if(property_exists($result, "success")){
	    return $result->success;
	  }
	}
	else {
	  if (isset($result['error'])) {
	    $msg = 'Application error response from NAID request: $method to $url Error: ' . $result['error'];
	    DerivedLogger::error($msg);
	    if ($full_error) {
	      $result["msg"] = $msg;
	      throw new Exception($result);
	    }
	    else {
	      throw new Exception($msg);	      
	    }
	  }
	}
        return $result;
    }

    private function _make_request($method, $url, $data) {
        $ch = curl_init($url);
	//	print "curl $method to $url \n";
        try{
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if($data && $method == "POST"){
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $rawResult= curl_exec($ch);
        } catch(Exception $e){
            curl_close($ch);
            throw $e;
        }
	if(curl_errno($ch) != 0) {
	  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
	  $errorNo = curl_errno($ch);
	  $error = curl_error($ch);
	  curl_close($ch);
	  throw new Exception("Server error on NAID request: " . $method .
			      " to $url. Http Code $httpCode. Error Number "
			      . $errorNo . " Error: " . $error);
	}
	
        curl_close($ch);
	return $rawResult;
    }

    private function _generateSignature($payload, $secret) {
        if (strlen($secret) != 32) {
            throw new Exception("key must be of length 32.");
        }
        $baseString = '';
        if (is_array($payload)) {
            ksort($payload);
            $baseString = '';
            $first = true;
            foreach ($payload as $key => $value) {
                if ($first) {
                    $first = false;
                } else {
                    $baseString .= '&';
                }
                $baseString .= $key . '=' .$value;
            }
        } else {
            $baseString = $payload;
        }
        return hash_hmac('sha256', $baseString, $secret);
    }
}

?>
