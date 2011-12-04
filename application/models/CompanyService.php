<?php

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
