<?php

class UserService {
    public  function createUser(){
        // action body
        $exe = Zend_Registry::get("exe");
        $user = new User();
        $user->setName('aa');
        $user->setEmail('aa');
        $user->setFbUID('123');
        $user->setPassword('password');
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
        $query = $em->createQuery('select u from User u where u.email = :email')->setParameter('email', $email);
        $itr = $query->iterate();
        foreach ($itr as $user) {
            return $user[0];
        }
        return null;
    }
}
