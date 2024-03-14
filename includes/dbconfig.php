<?php

class DB
{
    private $db_host = 'localhost';
    private $db_name = 'u652554119_admissions';
    private $db_user = 'u652554119_admissions';
    private $db_pass = 'Dg6iW4uYOCyzBFfG';

    private $dbh;
    private $error;
    private $stmt;
    public $score;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;
        $db_options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->dbh = new PDO($dsn, $this->db_user, $this->db_pass, $db_options);
        } catch (PDOException $e) {
            echo $this->error = $e->getMessage();
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value);
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value);
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value);
                    $type = PDO::PARAM_NULL;
                    break;
                default;
                    $type = PDO::PARAM_STR;

            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute($array = null)
    {
        return $this->stmt->execute($array);
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function result($array = null)
    {
        $this->execute($array);
        return $this->stmt->fetch();
    }

    public function resultSet($array = null)
    {
        $this->execute($array);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActivity($code, $qtr, $section, $id){
        $this->query("SELECT * FROM s_activities WHERE subjcode = :code AND actqtr = :actqtr AND actsection = :actsection AND actid LIKE ':actid' ");
        $this->bind(":code",$code);
        $this->bind(":actqtr",$qtr);
        $this->bind(":actsection",$section);
        $this->bind(":actid",$id);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function close()
    {
        return $this->dbh = null;
    }

    public function getScores($code, $qtr, $sid){
        $getScoreOfAstudent = $this->dbh->prepare("SELECT SUM(`score`) as totalScore, `maxscore` FROM s_scores WHERE 
        subjcode = :subjcode AND qtr = :qtr AND sid = :sid");
        $getScoreOfAstudent->execute([":subjcode" => $code, ":qtr" => $qtr,":sid" => $sid]);
        $getScores = $getScoreOfAstudent->fetchAll(PDO::FETCH_OBJ);

        $getWrittenWorkQuery = $this->dbh->prepare("SELECT ss.percentww FROM s_scores 
        LEFT JOIN s_subjects ss ON s_scores.subjcode = ss.code
        WHERE  acttype = 1");
        $getWrittenWorkQuery->execute();
        $writteGrade = $getWrittenWorkQuery->fetchAll();

        $getPerformanceTaskQuery = $this->dbh->prepare("SELECT sub.percentpt FROM s_scores 
            LEFT JOIN s_subjects sub ON s_scores.subjcode = sub.code
            WHERE acttype = 2");
        $getPerformanceTaskQuery->execute();
        $performanceGrade = $getPerformanceTaskQuery->fetchAll();

        return $getScores;


    }

    public function getFinalGrade($qtr){

        $userLogin = $_SESSION['username'];
        $getWrittenWorkQuery = $this->dbh->prepare("SELECT ss.percentww FROM s_scores 
            LEFT JOIN s_subjects ss ON s_scores.subjcode = ss.code
            WHERE  acttype = 1");
        $getWrittenWorkQuery->execute(array(":sid" =>  $userLogin, ":qtr" => $qtr));
        $writteGrade = $getWrittenWorkQuery->fetch();

        $getPerformanceTaskQuery = $this->dbh->prepare("SELECT sub.percentpt FROM s_scores 
            LEFT JOIN s_subjects sub ON s_scores.subjcode = sub.code
            WHERE acttype = 2");
        $getPerformanceTaskQuery->execute();
        $performanceGrade = $getPerformanceTaskQuery->fetch();

        $getQuarterlyQuery = $this->dbh->prepare("SELECT subs.percentqt FROM s_scores 
            LEFT JOIN s_subjects subs ON s_scores.subjcode = subs.code
            WHERE acttype = 3 ");
        $getQuarterlyQuery->execute();
        $quarterlyGrade = $getQuarterlyQuery->fetch();

        $initgrade = round(round($writteGrade, 2) * $writteGrade["percentww"] + round($performanceGrade, 2) * $performanceGrade["percentpt"] + round($quarterlyGrade, 2) * $quarterlyGrade["percentqt"], 2);

        $resultGrade = $this->dbh->prepare("SELECT * FROM s_transmute WHERE :initgrade BETWEEN lowerl AND upperl");
        $resultGrade->execute(array(":initgrade" =>  round($initgrade, 1)));
        $transmutedGrade = $resultGrade->fetchAll();

        return $transmutedGrade;



    }

}