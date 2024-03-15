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
        $getScoreOfAstudent = $this->dbh->prepare("SELECT SUM(`score`) as studentScore, SUM(`maxscore`) as activityScore, `percentww`,`percentpt`,`percentqt` FROM s_scores 
        LEFT JOIN s_subjects ss ON s_scores.subjcode = ss.code
        WHERE subjcode = :subjcode AND qtr = :qtr AND sid = :sid");
        $getScoreOfAstudent->execute([":subjcode" => $code, ":qtr" => $qtr,":sid" => $sid]);
        $getScores = $getScoreOfAstudent->fetchAll(PDO::FETCH_OBJ);

        return $getScores;

    }

    public function getFinalGrade($qtr){

        $getWrittenWorkQuery = $this->dbh->prepare("SELECT SUM(`score`) as totalScore, SUM(`maxscore`) as totalActivity, `percentww` FROM s_scores 
            LEFT JOIN s_subjects ss ON s_scores.subjcode = ss.code
            WHERE  acttype = :acttype");
        $getWrittenWorkQuery->execute([":acttype" => 1 ]);
        $writtenGrades = $getWrittenWorkQuery->fetchAll();
        $wwScore = 0;
        $wwMaxscore = 0;

        foreach($writtenGrades as $writtenGrade){
            $wwScore += $writtenGrade->totalScore;
            $wwMaxscore += $writtenGrade->totalActivity;
        }

        $totalGrade = ($wwScore / $wwMaxscore) * 100;
        round($totalGrade, 2);
        round(round($totalGrade, 2) * $writtenGrade->percentww , 2);


    }

}