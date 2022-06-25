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
    public function getAllData($page = 1, $limit = 8)
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
            $stmt = $this->dbh->prepare("SELECT COUNT(*) as totalcnt FROM dailycalorie");
            $stmt->execute();
            $totalcnt= $stmt->fetch(PDO::FETCH_COLUMN);

            //現在登録している全ての個人データを取得する
            $stmt = $this->dbh->prepare("SELECT  * FROM dailycalorie LIMIT :start, :limit");
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $data = $this->setAllData($stmt->fetchAll(PDO::FETCH_ASSOC));

            //一般用トップ画面に渡すためのデータを格納する
            $pager['totalcnt'] = $totalcnt;
            $pager['data'] = $data;
    
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
            $stmt = $this->dbh->prepare("SELECT  * FROM personaldata WHERE id=:id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $datum = $this->setDatum($stmt->fetchAll(PDO::FETCH_ASSOC));

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
            $qd->setItem($result["item"]);
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
        $pd = new PersonalData();
        $pd->setId($result[0]["id"]);
        $pd->setName($result[0]["womanname"]);
        $pd->setAge($result[0]["age"]);
        $pd->setCategory($result[0]["category"]);
        $pd->setBirthday($result[0]["birthday"]);
        $pd->setBirthplace($result[0]["birthplace"]);
        $pd->setBloodtype($result[0]["bloodtype"]);
        $pd->setHeight($result[0]["height"]);
        $pd->setNotices($result[0]["notices"]);
        // $pd->setPicdata0($result[0]["picdata0"]);
        // $pd->setPicdata1($result[0]["picdata1"]);
        // $pd->setPicdata2($result[0]["picdata2"]);

        return $pd;
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