<?php
include __DIR__.'/stockdata.php';

class QueryStockData extends connect
{
    private $stockdata;

    public function __construct()
    {
        parent::__construct();
    }

    public function setSpendingData(StockData $stockdata)
    {
        $this->stockdata = $stockdata;
    }

    /**
     * 新規作成 or 修正
     */
    public function save()
    {
        $rcvId = $this->stockdata->getId();
        $rcvCategory = $this->stockdata->getCategory();
        $rcvItem = $this->stockdata->getItem();
        $rcvQuantity = $this->stockdata->getQuantity();
        $rcvDelFlag = $this->stockdata->getDelFlag();

        try
        {
            if (!empty($this->stockdata->getId()))
            {
                
                // IDがあるときは上書き
                $id = $this->stockdata->getId();
                $stmt = $this->dbh->prepare("UPDATE stock
                SET category=:category, item=:item, quantity=:quantity, delflag=:delflag,updated_at=NOW() WHERE id=:id");
                $stmt->bindParam(':id', $rcvId, PDO::PARAM_INT);
            }
            else 
            {
                // IDがなければ新規作成
                $stmt = $this->dbh->prepare("INSERT INTO dailyspending (category, item, quantity,delflag,created_at, updated_at) VALUES (:category, :item, :quantity,:delflag,NOW(), NOW())");                                                                     
            }
            
            $stmt->bindParam(':category', $rcvCategory, PDO::PARAM_STR);
            $stmt->bindParam(':item', $rcvItem, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $rcvPrice, PDO::PARAM_INT);
            $stmt->bindParam(':delflag', $rcvDelFlag, PDO::PARAM_INT);

            $stmt->execute();
            
        }
        catch( Exception $ex )
        {
            return "DB:Error";
        }
    }

    //指定したitemを指定した数分減らす
    public function reduce($rcvCategory,$rcvItem,$rcvQuantity)
    {
        try
        {
            //対象itemの現在のstock数を取得する
            $stmt = $this->dbh->prepare("SELECT * FROM stock WHERE item=:item");
            $stmt->bindParam(':item', $rcvItem, PDO::PARAM_STR);
            $stmt->execute();
            $tmp= $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($tmp[0]['item'].'   '.$tmp[0]['quantity']);
            // die();
            //データが存在しない場合
            if(empty($tmp[0]['item']))
            {
                return "Data:Error";
            }
            //データが存在する場合
            else
            {
                $presentCnt = intval($tmp[0]['quantity']);
                if($presentCnt >= intval($rcvQuantity))
                {
                    //対象itemの現在のstock数を該当数分減らす
                    $stmt = $this->dbh->prepare("UPDATE stock SET quantity=:quantity,updated_at=NOW() WHERE item=:item");

                    $presentCnt  -=  intval($rcvQuantity);
                    $stmt->bindParam(':item', $rcvItem, PDO::PARAM_STR);
                    $stmt->bindParam(':quantity', $presentCnt, PDO::PARAM_INT);
                    $stmt->execute();
                }

            }



        }
        catch( Exception $ex )
        {
            return "DB:Error";
        } 

    }

    //指定したitemを指定した数分増やす
    public function increase($rcvCategory,$rcvItem,$rcvQuantity)
    {
        try
        {
            //対象itemの現在のstock数を取得する
            $stmt = $this->dbh->prepare("SELECT * FROM stock WHERE item=:item");
            $stmt->bindParam(':item', $rcvItem, PDO::PARAM_STR);
            $stmt->execute();
            $tmp= $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($tmp[0]['item'].'   '.$tmp[0]['quantity']);
            // die();
            //データが存在しない場合
            if(empty($tmp[0]['item']))
            {
                $stmt = $this->dbh->prepare("INSERT INTO stock (category, item, quantity,created_at, updated_at) VALUES (:category, :item, :quantity,NOW(), NOW())"); 
                $stmt->bindParam(':category', $rcvCategory, PDO::PARAM_STR);
            }
            //データが存在する場合
            else
            {
                $rcvQuantity += $tmp[0]['quantity'] ;
                //対象itemの現在のstock数を該当数分減らす
                $stmt = $this->dbh->prepare("UPDATE stock SET quantity=:quantity,updated_at=NOW() WHERE item=:item");
            }

            $stmt->bindParam(':item', $rcvItem, PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $rcvQuantity, PDO::PARAM_INT);
            $stmt->execute();

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
            $stmt = $this->dbh->prepare("SELECT COUNT(*) as totalcnt FROM personaldata");
            $stmt->execute();
            $totalcnt= $stmt->fetch(PDO::FETCH_COLUMN);

            //現在登録している全ての個人データを取得する
            $stmt = $this->dbh->prepare("SELECT  * FROM personaldata LIMIT :start, :limit");
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $data = $this->setAllData($stmt->fetchAll(PDO::FETCH_ASSOC));

            //一般用トップ画面に渡すためのデータを格納する
            $pager['totalcnt'] = $totalcnt;
            $pager['people'] = $data;
    
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
            $pd = new PersonalData();
            $pd->setId($result["id"]);
            $pd->setName($result["womanname"]);
            $pd->setAge($result["age"]);
            $pd->setCategory($result["category"]);
            $pd->setBirthday($result["birthday"]);
            $pd->setBirthplace($result["birthplace"]);
            $pd->setBloodtype($result["bloodtype"]);
            $pd->setHeight($result["height"]);
            $pd->setNotices($result["notices"]);
            $pd->setPicdata0($result["picdata0"]);
            $pd->setPicdata1($result["picdata1"]);
            $pd->setPicdata2($result["picdata2"]);

            $tmp[] = $pd;
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
        $pd->setPicdata0($result[0]["picdata0"]);
        $pd->setPicdata1($result[0]["picdata1"]);
        $pd->setPicdata2($result[0]["picdata2"]);

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