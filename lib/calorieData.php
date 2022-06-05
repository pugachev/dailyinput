<?php
class CalorieData
{
    private $id=null;
    private $category = null;
    private $item = null;
    private $calorie = null;
    private $quantity = null;
    private $momentum = null;
    private $picdata = null;
    private $delflag = null;


    public function save()
    {
        $queryPersonalData = new QueryCalorieData();
        $queryPersonalData->setCalorieData($this);
        $queryPersonalData->save();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function getCalorie()
    {
        return $this->calorie;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getMomentum()
    {
        return $this->momentum;
    }

    public function getPicdata()
    {
        return $this->picdata;
    }

    public function getDelFlag()
    {
        return $this->delflag;
    }


    public function setId($id)
    {
        $this->id=$id;
    }

    public function setCategory($category)
    {
        $this->category=$category;
    }

    public function setItem($item)
    {
        $this->item = $item;
    }

    public function setCalorie($calorie)
    {
        $this->calorie=$calorie;
    }

    public function setQuantity($quantity)
    {
        $this->quantity=$quantity;
    }

    public function setMomen($momentum)
    {
        $this->momentum=$momentum;
    }

    public function setPicdata($picdata)
    {
        $this->picdata=$picdata;
    }

    public function setDelFlag($delflag)
    {
        $this->delflag=$delflag;
    }
    
}