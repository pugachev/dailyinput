<?php
include __DIR__.'/spendingData.php';
include __DIR__.'/queryStockData.php';

class QuerySpendingData extends connect
{
    private $spendingdata;

    public function __construct()
    {
        parent::__construct();
    }

    public function setSpendingData(SpendingData $spendingdata)
    {
        $this->spendingdata = $spendingdata;
    }

    /**
     * 新規作成 or 画像修正
     */
    public function save()
    {
        $rcvId = $this->spendingdata->getId();
        $rcvTxtdate = $this->spendingdata->getTgtDate();
        $rcvCategory = $this->spendingdata->getCategory();
        $rcvItem = $this->spendingdata->getItem();
        $rcvQuantity = $this->spendingdata->getQuantity();
        $rcvPrice = $this->spendingdata->getPrice();
        $rcvDelFlag = 0;

        try
        {
            if (!empty($rcvId))
            {
                // IDがあるときは上書き
                $stmt = $this->dbh->prepare("UPDATE dailyspending
                SET tgtdate=:tgtdate,category=:category, item=:item, quantity=:quantity,price=:price, delflag=:delflag,updated_at=NOW() WHERE id=:id");
                $stmt->bindParam(':id', $rcvId, PDO::PARAM_INT);
            }
            else 
            {
                // IDがなければ新規作成
                $stmt = $this->dbh->prepare("INSERT INTO dailyspending (tgtdate,category, item, quantity,price, delflag,created_at, updated_at) 
                VALUES (:tgtdate,:category, :item, :quantity,:price, :delflag,NOW(), NOW())");                                                                     
            }
            $stmt->bindParam(':tgtdate', $rcvTxtdate, PDO::PARAM_STR);
            $stmt->bindParam(':category', $rcvCategory, PDO::PARAM_STR);
            $stmt->bindParam(':item', $rcvItem, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $rcvQuantity, PDO::PARAM_INT);
            $stmt->bindParam(':price', $rcvPrice, PDO::PARAM_INT);
            $stmt->bindParam(':delflag', $rcvDelFlag, PDO::PARAM_INT);
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
    public function getAllData($tgtdate,$page = 1, $limit = 8)
    {
        //画面に渡すデータ連携
        $pager = array('totalcnt' => null, 'datas' => null);
        //ページ番号
        $start = ($page - 1) * $limit; 
        //総記事数
        $totalcnt = "";
        //一度に取得するデータ数
        $limit=8;
        try
        {
            //対象日付の総データ数を取得する
            $stmt = $this->dbh->prepare("SELECT COUNT(*) as totalcnt FROM dailyspending where tgtdate=:tgtdate");
            $stmt->bindParam(':tgtdate', $tgtdate, PDO::PARAM_STR);
            $stmt->execute();
            $totalcnt= $stmt->fetch(PDO::FETCH_COLUMN);

            //対象日付の総データを取得する
            $stmt = $this->dbh->prepare("SELECT  ds.id as id ,ds.tgtdate as tgtdate, ds.category as category,im.itemname as itemname, ds.price as price,ds.quantity as quantity FROM dailyspending as ds left join items as im on ds.item = im.item where tgtdate=:tgtdate LIMIT :start, :limit");
            $stmt->bindParam(':tgtdate', $tgtdate, PDO::PARAM_STR);
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $data = $this->setAllData($stmt->fetchAll(PDO::FETCH_ASSOC));

            //対象日付の総出費額を取得する
            $stmt = $this->dbh->prepare("SELECT sum(price) FROM dailyspending  group by tgtdate having tgtdate=:tgtdate");
            $stmt->bindParam(':tgtdate', $tgtdate, PDO::PARAM_STR);
            $stmt->execute();
            $sumprice = $stmt->fetch(PDO::FETCH_COLUMN);

            //一般用トップ画面に渡すためのデータを格納する
            $pager['totalcnt'] = $totalcnt;
            $pager['data'] = $data;
            $pager['sumprice']=$sumprice;
    
        }
        catch(Exception $ex)
        {
            return "DB:Error";
        }

        // print_r($pager);
        // die();

        return $pager;
    }

    /**
     * 指定条件でデータを検索する
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
                $searchcondition.='startdate='.$startdate;
            }
            else if(empty($startdate) && !empty($enddate))
            {
                $where .= " and tgtdate <= '".$enddate."'";
                $searchcondition.='enddate='.$enddate;
            }

            //分類
            if(!empty($category) && $category!='firstchoice')
            {
                $where .= " and category ='".$category."'";
                $searchcondition.=',category='.$category;
            }

            //項目
            if(!empty($item) && ($item!='0000'))
            {
                $where .= " and item ='".$item."'";
                $searchcondition.=',item='.$item;
            }

            //上記で作成したWhere句で総記事数を取得する
            $sqlcnt = "SELECT COUNT(*) as totalcnt FROM dailycalorie ";
            $sqlcnt .= $where;
            $stmt = $this->dbh->query($sqlcnt);
            
            $totalcnt= $stmt->fetch(PDO::FETCH_COLUMN);

            //上記で作成したWhere句でデータを取得する
            $sqldate = "SELECT  dc.id as id ,dc.tgtdate as tgtdate, dc.category as category,im.itemname as itemname, dc.price as price,dc.quantity as quantity FROM dailyspending as dc left join items as im on dc.item = im.item ";
            $sqldate .= $where;
            $sqldate .= " LIMIT ".$start.", 5";
            // print_r($sqldate);
            // die();
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
     * 指定したIDのデータを取得する
     */
    public function getDatum($id)
    {
        try
        {
            $stmt = $this->dbh->prepare("SELECT  * FROM dailyspending WHERE id=:id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            $datum = $this->setDatum($stmt->fetch(PDO::FETCH_ASSOC));

        }
        catch(Exception $ex)
        {
            return 'DB:Error';
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
            $pd = new SpendingData();
            $pd->setId($result["id"]);
            $pd->setTxtDate($result["tgtdate"]);
            $pd->setCategory($result["category"]);
            $pd->setItem($result["itemname"]);
            $pd->setPrice($result["price"]);
            $pd->setQuantity($result["quantity"]);

            $tmp[] = $pd;
        }
        return  $tmp;
    }

    /**
     * 取得した特定データをデータクラス(PersonalData)をセットする
     */
    public function setDatum($result)
    {
        $pd = new SpendingData();
        $pd->setId($result["id"]);
        $pd->setTxtDate($result["tgtdate"]);
        $pd->setCategory($result["category"]);
        $pd->setItem($result["item"]);
        $pd->setPrice($result["price"]);
        $pd->setQuantity($result["quantity"]);

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