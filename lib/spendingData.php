<?php
class SpendingData
{
    private $id=null;
    private $tgtdate = null;
    private $category = null;
    private $item = null;
    private $quantity = null;
    private $price = null;
    private $delflag = null;


    public function save()
    {
        $queryPersonalData = new QuerySpendingData();
        $queryPersonalData->setSpendingData($this);
        $queryPersonalData->save();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getTgtDate()
    {
        return $this->tgtdate;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDelFlag()
    {
        return $this->delflag;
    }


    public function setId($id)
    {
        $this->id=$id;
    }

    public function setTxtDate($tgtdate)
    {
        $this->tgtdate = $tgtdate;
    }

    public function setCategory($category)
    {
        $this->category=$category;
    }

    public function setItem($item)
    {
        $this->item = $item;
    }

    public function setQuantity($quantity)
    {
        $this->quantity=$quantity;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setDelFlag($delflag)
    {
        $this->delflag=$delflag;
    }
    
}