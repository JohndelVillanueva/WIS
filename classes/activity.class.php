<?php

 class Activity {

    private $db_host = 'localhost';
    private $db_name = 'u652554119_admissions';
    private $db_user = 'u652554119_admissions';
    private $db_pass = 'qQ5xkDk!yLzMui.f';
    private $conn;
    public $error;
    public $actid;
    public $subjcode;
    public $actlvl;
    public $actsection;
    public $actdate;
    public $actcreate;
    public $actdesc;
    public $acttype;
    public $actqtr;
    public $maxscore;
    public $flag;




    public function __construct(){
        try {
            $this->conn = new PDO("mysql:host={$this->db_host};dbname={$this->db_name}", $this->db_user, $this->db_pass );
        } catch (PDOException $e) {
            echo $this->error = $e->getMessage();
        }
    }

    // public function selectSubjectbyCode($code){
    //     $selectSubByCode = $this->conn->prepare("SELECT * FROM s_subjects WHERE code = :code");
    //     $selectSubByCode->execute([':code' => $code]);
    //     $subCodeResults = $selectSubByCode->fetchall(PDO::FETCH_OBJ);

    //     return $subCodeResults;
    // }

    public function getAllWrittenWork($code, $qtr, $section){

        $getWrittenWork = $this->conn->prepare("SELECT * FROM s_activities where subjcode = :code AND actqtr = :actqtr AND actsection = :actsection ");
        $getWrittenWork->execute([
            ":code" => $code,
            ":actqtr" => $qtr,
            ":actsection" => $section
        ]);
        $getWrittenWorkResult = $getWrittenWork->fetchAll(PDO::FETCH_ASSOC);

        return $getWrittenWorkResult;

    }

    
 }