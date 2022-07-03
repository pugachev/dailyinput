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
            // $stock = new QueryStockData();
            // $stock->reduce($rcvCategory,$rcvItem,$rcvQuantity);
        
            
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

        return $pager;
    }

    /**
     * 指定条件でデータを検索する
     * ページ番号あり
     */
    public function searchData($startdate,$enddate,$category,$item,$page = 1, $limit = 5)
    {
        //画面に渡すデータ連携
        $pager = array('totalcnt' => null, 'persons' => null);
        //ページ番号
        $start = ($page - 1) * $limit; 
        //総記事数
        $totalcnt = "";
        //一度に取得するデータ数
        $limit=5;
        //検索条件の元データ
        $where = "where delflag=0";
        //画面に返却する検索データ
        $searchcondition="";
        try
        {

            //画面から取得した検索条件を組み立てる
            //日付条件
            if(!empty($startdate) && !empty($enddate))
            {
                $where .= " and tgtdate between '".$startdate."' and '".$enddate."'";
                $searchcondition.='startdate='.$startdate.',enddate='.$enddate;
            }
            else if(!empty($startdate) && empty($enddate))
            {
                $where .= " and tgtdate >= '".$startdate."'";
                $searchcondition.='startdate='.$startdate.',enddate=';
            }
            else if(empty($startdate) && !empty($enddate))
            {
                $where .= " and tgtdate <= '".$enddate."'";
                $searchcondition.='startdate='.',enddate='.$enddate;
            }
            else
            {
                $searchcondition.='startdate=,enddate=';
            }

            //分類
            if(!empty($category) && $category!='firstchoice')
            {
                $where .= " and category ='".$category."'";
                $searchcondition.=',category='.$category;
            }
            else
            {
                $searchcondition.=',category=';
            }

            //項目
            if(!empty($item) && ($item!='0000'))
            {
                $where .= " and dc.item ='".$item."'";
                $searchcondition.=',item='.$item;
            }
            else
            {
                $searchcondition.=',item=';
            }

            //上記で作成したWhere句で総記事数を取得する
            $sqlcnt = "SELECT COUNT(*) as totalcnt FROM dailycalorie  as dc ";
            $sqlcnt .= $where;
            $stmt = $this->dbh->query($sqlcnt);
            $totalcnt= $stmt->fetch(PDO::FETCH_COLUMN);

            //上記で作成したWhere句でデータを取得する
            $sqldate = "SELECT  dc.id as id ,dc.tgtdate as tgtdate, dc.category as category,im.itemname as itemname, dc.calorie as calorie,dc.quantity as quantity FROM dailycalorie as dc left join items as im on dc.item = im.item ";
            $sqldate .= $where;
            $sqldate .= " LIMIT ".$start.", 5";
            $stmt = $this->dbh->query($sqldate);
            $data = $this->setAllData($stmt->fetchAll(PDO::FETCH_ASSOC));

            //一般用トップ画面に渡すためのデータを格納する
            $pager['totalcnt'] = $totalcnt;
            $pager['data'] = $data;
            $pager['searchcondition'] = $searchcondition;
        }
        catch(Exception $ex)
        {
            return "DB:Error";
        }

        return $pager;
    }

    /**
     * 指定した日付で合計値を取得する
     */
    public function searchDataByDate($tgtdate)
    {
        try
        {
            // $sql ="SELECT dc.tgtdate as tgtdate, dc.item as item, im.itemname as itemname, sum(dc.calorie) as sumcalorie FROM dailycalorie as dc inner join items as im on  dc.item = im.item group by dc.tgtdate, dc.item HAVING dc.tgtdate ='$tgtdate'";
            $sql ="SELECT dc.tgtdate as tgtdate, dc.item as item, im.itemname as itemname, sum(dc.calorie) as sumcalorie FROM dailycalorie as dc inner join items as im on  dc.item = im.item group by dc.tgtdate, dc.item HAVING dc.tgtdate ='$tgtdate'";
            // var_dump($sql);
            $stmt = $this->dbh->query($sql);
            $data = $this->setSumData($stmt->fetchAll(PDO::FETCH_ASSOC));

            // var_dump($data);
            // die();
        }
        catch(Exception $ex)
        {
            return "DB:Error";
        }


        return $data;
    }

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
     * group byの結果を格納する
     */
    public function setSumData($resutls)
    {
        $tmp = array();
        foreach ($resutls as $result) 
        {
            $qd = new CalorieData();
            $qd->setTgtDate($result["tgtdate"]);
            $qd->setItem($result["item"]);
            $qd->setCalorie($result["sumcalorie"]);
            $tmp[] = $qd;
        }
        return  $tmp;
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

}