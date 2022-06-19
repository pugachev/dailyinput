<?php
class SettingData
{
    private $id=null;
    private $tgtdate = null;
    private $maxcalorie = null;
    private $maxspending = null;


    public function save()
    {
        $querySettinglData = new QuerySettingData();
        $querySettinglData->setSettingData($this);
        $querySettinglData->save();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTgtDate()
    {
        return $this->tgtdate;
    }

    public function getMaxCalorie()
    {
        return $this->maxcalorie;
    }

    public function getMaxSpending()
    {
        return $this->maxspending;
    }

    public function setId($id)
    {
        $this->id=$id;
    }

    public function setTxtDate($tgtdate)
    {
        $this->tgtdate = $tgtdate;
    }

    public function setMaxCalorie($maxcalorie)
    {
        $this->maxcalorie=$maxcalorie;
    }

    public function setIMaxSpending($maxspending)
    {
        $this->maxspending = $maxspending;
    }
    
}