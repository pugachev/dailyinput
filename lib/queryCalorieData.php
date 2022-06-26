<?php
include __DIR__.'/calorieData.php';
include __DIR__.'/queryStockData.php';

class QueryCalorieData extends connect
{
    private $caloriedata;

    public function __construct()
    {
        parent::__construct();
    }

    public function setCalorieData(CalorieData $caloriedata)
    {
        $this->caloriedata = $caloriedata;
    }

    /**
     * 新規作成 or 画像修正
     */
    public function save()
    {
        $rcvId = $this->caloriedata->getId();
        $rcvTgtDate = $this->caloriedata->getTgtDate();
        $rcvCategory = $this->caloriedata->getCategory();
        $rcvItem = $this->caloriedata->getItem();
        $rcvCalorie = $this->caloriedata->getCalorie();
        $rcvQuantity = $this->caloriedata->getQuantity();
        // $rcvPicdata = $this->caloriedata->getPicdata();
        // $rcvDelFlag = $this->caloriedata->getDelFlag();
        $rcvDelFlag = 0;
        try
        {
            if (!empty($this->caloriedata->getId()))
            {
                
                // IDがあるときは上書き
                $id = $this->caloriedata->getId();
                $stmt = $this->dbh->prepare("UPDATE dailycalorie SET tgtdate=:tgtdate,category=:category, item=:item, quantity=:quantity,calorie=:calorie, delflag=:delflag,updated_at=NOW() WHERE id=:id");
                $stmt->bindParam(':id', $rcvId, PDO::PARAM_INT);
            }
            else 
            {
                // IDがなければ新規作成
                $stmt = $this->dbh->prepare("INSERT INTO dailycalorie (tgtdate,category, item, quantity,calorie, delflag,created_at, updated_at) VALUES (:tgtdate,:category, :item, :quantity,:calorie,:delflag,NOW(), NOW())");                                                                     
            }
            $stmt->bindParam(':tgtdate', $rcvTgtDate, PDO::PARAM_STR);
            $stmt->bindParam(':category', $rcvCategory, PDO::PARAM_STR);
            $stmt->bindParam(':item', $rcvItem, PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $rcvQuantity, PDO::PARAM_INT);
            $stmt->bindParam(':calorie', $rcvCalorie, PDO::PARAM_INT);
            // $stmt->bindParam(':picdata', $rcvPicdata, PDO::PARAM_STR);
            // $stmt->bindParam(':delflag', $rcvDelFlag, PDO::PARAM_INT);
            $stmt->bindParam(':delflag', $rcvDelFlag ,PDO::PARAM_INT);
            // $stmt->debugDumpParams();
            $stmt->execute();


            //stockテーブルの対象itemの値を増やす
            $stock = new QueryStockData();
            $stock->reduce($rcvCategory,$rcvItem,$rcvQuantity);
        
            
        }
        catch( Exception $ex )
        {
            return "DB:Error";
        }
    }

    /**
     * 全データを取得する
     */
    public function getAllData($tgtdate,$page = 1, $limit = 8)
    {
        //画面に渡すデータ連携
        $pager = array('totalcnt' => null, 'persons' => null);
        //ページ番号
        $start = ($page - 1) * $limit; 
        //総記事数
        $totalcnt = "";
        //一度に取得するデータ数
        $limit=8;
        try
        {
            //現在の総記事数を取得する
            $stmt = $this->dbh->prepare("SELECT COUNT(*) as totalcnt FROM dailycalorie where tgtdate=:tgtdate");
            $stmt->bindParam(':tgtdate', $tgtdate, PDO::PARAM_STR);
            $stmt->execute();
            $totalcnt= $stmt->fetch(PDO::FETCH_COLUMN);

            //現在登録している全ての個人データを取得する
            $stmt = $this->dbh->prepare("SELECT  dc.id as id ,dc.tgtdate as tgtdate, dc.category as category,im.itemname as itemname, dc.calorie as calorie,dc.quantity as quantity FROM dailycalorie as dc left join items as im on dc.item = im.item where tgtdate=:tgtdate LIMIT :start, :limit");
            $stmt->bindParam(':tgtdate', $tgtdate, PDO::PARAM_STR);
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $data = $this->setAllData($stmt->fetchAll(PDO::FETCH_ASSOC));

            //対象日付の総出費額を取得する
            $stmt = $this->dbh->prepare("SELECT sum(calorie) FROM dailycalorie  group by tgtdate having tgtdate=:tgtdate");
            $stmt->bindParam(':tgtdate', $tgtdate, PDO::PARAM_STR);
            $stmt->execute();
            $sumcalorie = $stmt->fetch(PDO::FETCH_COLUMN);

            //一般用トップ画面に渡すためのデータを格納する
            $pager['totalcnt'] = $totalcnt;
            $pager['data'] = $data;
            $pager['sumcalorie']=$sumcalorie;
    
        }
        catch(Exception $ex)
        {
            return "DB:Error";
        }

        // print_r($pager);
        // die();

        return $pager;
    }
    // public function getAllData()
    // {

    //     try
    //     {
    //         $stmt = $this->dbh->prepare("SELECT  * FROM personaldata");
    //         $stmt->execute();
    //         $data = $this->setAllData($stmt->fetchAll(PDO::FETCH_ASSOC));
    
    //     }
    //     catch(Exception $ex)
    //     {
    //         return "DB:Error";
    //     }

    //     return $data;
    // }

    /**
     * 指定したIDのデータを取得する
     */
    public function getDatum($id)
    {

        try
        {
            $stmt = $this->dbh->prepare("SELECT  * FROM dailycalorie WHERE id=:id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $datum = $this->setDatum($stmt->fetch(PDO::FETCH_ASSOC));

        }
        catch(Exception $ex)
        {
            return "DB:Error";
        }

        return $datum;
    }

    /**
     * 名前からデータが存在するかを調べる
     */
    public function getDatumByName($tgtname)
    {
        try
        {
            $stmt = $this->dbh->prepare("SELECT  * FROM personaldata WHERE womanname=:womanname");
            $stmt->bindParam(':womanname', $tgtname, PDO::PARAM_STR);
            $stmt->execute();
            $datum = $this->setDatumByName($stmt->fetchAll(PDO::FETCH_ASSOC));

        }
        catch(Exception $ex)
        {
            return "DB:Error";
        }

        return $datum;
    }

    /**
     * 取得した全データをデータクラス(PersonalData)の配列にする
     */
    public function setAllData($resutls)
    {
        $tmp = array();
        foreach ($resutls as $result) 
        {
            $qd = new CalorieData();
            $qd->setId($result["id"]);
            $qd->setTgtDate($result["tgtdate"]);
            $qd->setCategory($result["category"]);
            $qd->setItem($result["itemname"]);
            $qd->setQuantity($result["quantity"]);
            $qd->setCalorie($result["calorie"]);

            $tmp[] = $qd;
        }
        return  $tmp;
    }

    /**
     * 取得した特定データをデータクラス(PersonalData)をセットする
     */
    public function setDatum($result)
    {
        $cd = new CalorieData();
        $cd->setId($result["id"]);
        $cd->setTgtDate($result["tgtdate"]);
        $cd->setCategory($result["category"]);
        $cd->setItem($result["item"]);
        $cd->setQuantity($result["quantity"]);
        $cd->setCalorie($result["calorie"]);

        return $cd;
    }

    /**
     * 引数の名前が存在するかをチェックする
     * 有り:true 無し:false
     */
    public function setDatumByName($result)
    {
        //データが存在しない
        if(empty($result))
        {
            return false;
        }
        //データが存在する
        else
        {
            return true;
        }

    }
}