<?php

require_once APPLICATION_ENTITIES . '/Companies.php';


class CompanyService {
    
    public  function createCompany($arr){
        $company = new Companies();
        $company->setCompanyName($arr['company_name']);
        $company->setIndustry($arr['industry']);
        $company->setPhoneNumber($arr['phone_number']);
        $company->setNumberOfComplaint(0);
        $exe = Zend_Registry::get("exe");
        $exe->persist($company);
        $exe->commit();
    }

    public static function getAllCompanys(){
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $query = $em->createQuery('select c from companies c');
        $itr = $query->iterate();
        $companys = array();
        foreach ($itr as $user) {
            $companys[] = $user[0];
        }
        return $companys;
    }

    public function getCompany($id){
        $exe = Zend_Registry::get("exe");
        return $exe->getMetaDataObject('Company', $id);
    }

    public function getCompanyByName($name){
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $query = $em->createQuery('select c from companies c where c.company_name = :company_name')->setParameter('company_name', $name);
        $result = $query->getResult();
        if (isset($result[0]) && !empty($result[0])){
            return $result[0];
        }
        return null;
    }

}
