<?php
// change to new stdClass()
class SessionService {
    private $session_id='';
    private $em = null;
    private $variables = null;
    
    public function __construct($session_id) {
        $exe = Zend_Registry::get("exe");
        $this->em = $exe->getMetaDataEntityManager();
        
        $variables_string = $this->query($session_id);
        if($variables_string) {
            $this->session_id = $session_id;
            $this->variables = json_decode($variables_string);
            if(!$this->variables) {
                $this->variables = new stdClass();
            }
        } else {
            $this->session_id = null;
        }
    }
    
    public static function create() {
        $session_id = uniqid();
        $variables = json_encode(new stdClass());
        $sql = "insert into sessions(session_id, variables) values('$session_id', '$variables')";
        $stmt = Zend_Registry::get("exe")->getMetaDataEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
        return new SessionService($session_id);
    }
    
    public function getId() {
        return $this->session_id;
    }
    
    public function get($key) {
        if(property_exists($this->variables, $key)) {
            return $this->variables->$key;
        } else {
            return null;
        }
    }
    
    public function set($key, $value) {
        if($this->variables->$key) {
            $this->variables->$key = $value;
        } else {
            $this->variables->$key = $value;
        }
        $this->save();
    }
    
    public function purge() {
        $this->variables = new stdClass();
        $this->save();
    }
    
    private function save() {
        $session_id = $this->session_id;
        $variables_string = json_encode($this->variables);
        $sql = "update sessions set variables='$variables_string' where session_id='$session_id'";
        $stmt = Zend_Registry::get("exe")->getMetaDataEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
        
    }
    
    private function query($session_id) {
        $sql = "select variables
                from 
                sessions
                where 
                session_id = '$session_id'";
        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $variables_res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($variables_res) {
            return $variables_res[0]['variables'];
        } else {
            return null;
        }
    }
    
}

