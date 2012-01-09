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
        return $exe->getMetaDataObject('Companies', $id);
    }

    public function getCompanyByName($name){
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $query = $em->createQuery('select c from companies c where c.company_name = :company_name')->setParameter('company_name', $name);
        $result = $query->getResult();
        if (isset($result[0]) && !empty($result[0])){
            return $result[0];
        }
//        
        return null;
    }
    
    public function getCompanyByString($str) {
        
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $query = $em->createQuery("select c.company_name from companies c where c.company_name like '%$str%'");
        $result = $query->getResult();

        if (isset($result) && !empty($result)){
            $company_names = array();
            foreach($result as $rec) 
            {
                $company_names[] = $rec['company_name'];
            }
            return $company_names;
        }
        return null;
        
    }
    
    public function getCompanyAnalytics($company='delta', $scale='day') {
        if(empty($company)) {
            $company = 'delta';
        }
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $stmt = $em->getConnection()->prepare("select monthname(p.post_time) as date, count(p.id) as cnt from posts p join companies c on (p.company_id=c.id) where c.company_name='$company' and date(p.post_time)>date(subdate(now(), interval 2 month)) group by month(p.post_time);");
        //echo "select monthname(p.post_time) as date, count(p.id) as cnt from posts p join companies c on (p.company_id=c.id) where c.company_name='$company' group by month(p.post_time)";
        $stmt->execute();
        $res = $stmt->fetchAll();
        $data = array();
        foreach($res as $i=>$rec) 
        {
            $data[$i][] = $rec['date'];
            $data[$i][] = intval($rec['cnt']);
        }    
        return $data;
    }

}
