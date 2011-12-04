<?php

/**
 * @Entity
 * @Table(name="companies", indexes={@index(name="id_idx", columns={"id"})})
 */
class Companies
{
     /**
     * @Id @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(name="phone_number",nullable="true")
     */
    private $phone_number;

    /**
     * @Column(name="company_name", length=50, nullable="true")
     */
    private $company_name;

    /**
     * @Column(name="industry", length=50, nullable="true")
     */
    private $industry;

    /**
     * @Column(name="number_of_complaint", length=50, nullable="true")
     */
    private $number_of_complaint;


    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
    }

    public function getCompanyName()
    {
        return $this->company_name;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setIndustry($industry)
    {
        $this->industry = $industry;
    }

    public function getIndustry()
    {
        return $this->industry;
    }

    public function setNumberOfComplaint($number_of_complaint)
    {
        $this->number_of_complaint = $number_of_complaint;
    }

    public function getNumberOfComplaint()
    {
        return $this->number_of_complaint;
    }

    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }
}
