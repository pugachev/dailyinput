<?php
class StockData
{
    private $id=null;
    private $category = null;
    private $item = null;
    private $quantity = null;
    private $delflag = null;


    public function save()
    {
        $queryPersonalData = new QueryStockData();
        $queryPersonalData->setStockData($this);
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

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getDelFlag()
    {
        return $this->picdata0;
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

    public function setQuantity($quantity)
    {
        $this->quantity=$quantity;
    }

    public function setDelFlag($delflag)
    {
        $this->delflag=$delflag;
    }
    
}