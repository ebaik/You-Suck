<?php

class UserService {
    public  function createUser($arr){
        // action body
        $exe = Zend_Registry::get("exe");
        $user = new User();
        $user->setAddress($arr['address']);
        $user->setCity($arr['city']);
        $user->setCountry($arr['country']);
        $user->setCreatedAt($arr['registration_time']);
        $user->setEmail($arr['email']);
        $user->setUsername($arr['username']);
        $user->setFullname($arr['fullname']);
        $encrypted_password = '';
        md5($arr['password'], $encrypted_password);
        $user->setPassword($encrypted_password);
        $exe->persist($user);
        $exe->commit();

    }

    public function getUser($id){
        $exe = Zend_Registry::get("exe");
        return $exe->getMetaDataObject('User', $id);
    }

    public function getByEmail($email){
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $query = $em->createQuery('select u from user u where u.email = :email')->setParameter('email', $email);
        $itr = $query->iterate();
        foreach ($itr as $user) {
            return $user[0];
        }
        return null;
    }
}
