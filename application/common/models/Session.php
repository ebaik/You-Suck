<?php


class Session {
    
    private $session_id='';
    private $em = null;
    private $variables = array();
    
    public function __construct($session_id) {
        $exe = Zend_Registry::get("exe");
        $this->em = $exe->getMetaDataEntityManager();
        
        $variables_string = $this->query($session_id);
        if($variables_string) {
            $this->session_id = $session_id;
            $this->variables = json_decode($variables_string, true);
            if(!$this->variables) {
                $this->variables = array();
            }
        } else {
            $this->session_id = null;
        }
    }
    
    public static function create() {
        $session_id = uniqid();
        $sql = "insert into sessions(session_id) values('$session_id')";
        $stmt = Zend_Registry::get("exe")->getMetaDataEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
    }
    
    public function get($key) {
        if(isset($this->variables[$key])) {
            return $this->variables[$key];
        } else {
            return null;
        }
    }
    
    public function set($key, $value) {
        if(array_key_exists($key, $this->variables)) {
            $this->variables[$key] = $value;
        } else {
            array_merge($this->variables, array($key=>$value));
        }
        $this->save();
    }
    
    private function save() {
        $session_id = $this->session_id;
        $variables_string = json_encode($this->variables);
        $sql = "insert into sessions(session_id, variables) values('$session_id', '$variables_string')";
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

