<?php

class ResponseService {
    private static $response_obj = null;
    private $header = null;
    private $data = null;
    private $response= null;

    private function __construct() {
        $this->header = new stdClass();
        $this->data = new stdClass();
        $this->response = new stdClass();
        
    }

    public static function getInstance() {
        if(!self::$response_obj) {
            self::$response_obj = new ResponseService();
        }
        return self::$response_obj;
    }

    public function set_header($key, $value) {
        $this->header->$key = $value;
    }

    public function set_data($key, $value) {
        $this->data->$key = $value;
    }

    public function get_response() {
        $this->response->header = $this->header;
        $this->response->data = $this->data;
        return json_encode($this->response);
    }
}