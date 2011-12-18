<?php

require_once APPLICATION_ENTITIES . '/User.php';

class UserService
{

    public static function getLoggedInUser()
    {
        $user_str = Zend_Auth::getInstance()->getStorage()->read();
        if (isset($user_str)) {
            parse_str($user_str, $params);
            $exe = Zend_Registry::get("exe");
            return $exe->getMetaDataObject("User", $params['id']);
        }
        return null;
    }

    public function createUser($arr)
    {
        // action body
        try {
            $exe = Zend_Registry::get("exe");
            $user = new User();
            //$user->setAddress($arr['address']);
            // $user->setCity($arr['city']);
            // $user->setCountry($arr['country']);
            //    $user->setCreatedAt(new DateTime('now'));
            $user->setEmail($arr['email']);
            if (array_key_exists('last_name', $arr)){
                $user->setLastname($arr['last_name']);
            }
            $user->setFirstname($arr['first_name']);
            if (array_key_exists('password', $arr)) {
                $user->setPassword(md5($arr['password']));
            } else {
                $user->setPassword('facebook');
            }
            if (array_key_exists('id', $arr)){
                //fbuid
                $user->setFbUID($arr['id']);
            }
            $exe->persist($user);
            $exe->commit();
        } catch (Exception $ex) {
            error_log("User exception:" . $ex->getMessage());
        }
        return $user;

    }

    public function checklogin($username, $password)
    {

    	$user = $this->getByEmail($username);
    	if (!isset($user) || empty($user)) {

            return null;
        }
        if (md5($password) == $user->getPassword()) {
            return $user;
        }
        return null;
    }

    public function getUser($id)
    {
        $exe = Zend_Registry::get("exe");
        return $exe->getMetaDataObject('User', $id);
    }

    public function getByEmail($email)
    {
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $query = $em->createQuery('select u from user u where u.email = :email')->setParameter('email', $email);
        $itr = $query->iterate();
        foreach ($itr as $user) {
            return $user[0];
        }
        return null;
    }

    public function getByfbuid($fbuid)
    {
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $query = $em->createQuery('select u from user u where u.fbuid = :fbuid')->setParameter('fbuid', $fbuid);
        $itr = $query->iterate();
        foreach ($itr as $user) {
            return $user[0];
        }
        return null;
    }


    public function getByUsername($username)
    {
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $query = $em->createQuery('select u from user u where u.username = :username')->setParameter('username', $username);
        $itr = $query->iterate();
        foreach ($itr as $user) {
            return $user[0];
        }
        return null;
    }
}
