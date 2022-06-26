<?php
include __DIR__.'/settingData.php';

class QuerySettingData extends connect
{
    private $settingdata;

    public function __construct()
    {
        parent::__construct();
    }

    public function setSettingData(SettingData $settingdata)
    {
        $this->settingdata = $settingdata;
    }

    /**
     * 新規作成 or 画像修正
     */
    public function save()
    {
        $rcvId = $this->settingdata->getId();
        $rcvTgtdate = $this->settingdata->getTgtDate();
        $rcvMaxCalorie = $this->settingdata->getMaxCalorie();
        $rcvMaxSpending = $this->settingdata->getMaxSpending();

        try
        {
            //入力された日付の存在チェック
            $stmt = $this->dbh->prepare("SELECT tgtdate FROM settings where tgtdate=:tgtdate");
            $stmt->bindParam(':tgtdate', $rcvTgtdate, PDO::PARAM_STR);
            $stmt->execute();
            $tgtdate= $stmt->fetch(PDO::FETCH_COLUMN);

            if (!empty($tgtdate))
            {
                // 日付があるときは上書き
                $stmt = $this->dbh->prepare("UPDATE settings
                SET maxcalorie=:maxcalorie,maxspending=:maxspending,updated_at=NOW() WHERE tgtdate=:tgtdate");
            }
            else 
            {
                // IDがなければ新規作成
                $stmt = $this->dbh->prepare("INSERT INTO settings (tgtdate,maxcalorie, maxspending,created_at, updated_at) 
                VALUES (:tgtdate,:maxcalorie, :maxspending, NOW(), NOW())");                 
            }
            $stmt->bindParam(':tgtdate', $rcvTgtdate, PDO::PARAM_STR);
            $stmt->bindParam(':maxcalorie', $rcvMaxCalorie, PDO::PARAM_INT);
            $stmt->bindParam(':maxspending', $rcvMaxSpending, PDO::PARAM_INT);     
            $stmt->execute();


            //stockテーブルの対象itemの値を増やす
            // $stock = new QueryStockData();
            // $stock->increase($rcvCategory,$rcvItem,$rcvQuantity);

        }
        catch( Exception $ex )
        {
            return "DB:Error";
        }
    }

    public function getSettingSpendingData()
    {
        $stmt = $this->dbh->prepare("SELECT  * FROM settings");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $maxspending = $data[0]['maxspending'];

        return $maxspending;
    }

    public function getSettingCalorieData()
    {
        $stmt = $this->dbh->prepare("SELECT  * FROM settings");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $maxspending = $data[0]['maxcalorie'];

        return $maxspending;
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
            $stmt = $this->dbh->prepare("SELECT COUNT(*) as totalcnt FROM dailyspending");
            $stmt->execute();
            $totalcnt= $stmt->fetch(PDO::FETCH_COLUMN);

            //現在登録している全ての個人データを取得する
            $stmt = $this->dbh->prepare("SELECT  * FROM dailyspending LIMIT :start, :limit");
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
            // $pd->setPicdata0($result["picdata0"]);
            // $pd->setPicdata1($result["picdata1"]);
            // $pd->setPicdata2($result["picdata2"]);

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