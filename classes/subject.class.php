<?php

 class Subject {

    private $db_host = 'localhost';
    private $db_name = 'u652554119_admissions';
    private $db_user = 'u652554119_admissions';
    private $db_pass = 'qQ5xkDk!yLzMui.f';
    private $conn;
    public $error;
    public $id;
    public $code;
    public $tid;
    public $subjdesc;
    public $subjlevel;
    public $subjsection;
    public $assignedby;
    public $assigndate;
    public $percentww;
    public $percentpt;
    public $percentqt;


    public function __construct(){
        try {
            $this->conn = new PDO("mysql:host={$this->db_host};dbname={$this->db_name}", $this->db_user, $this->db_pass );
        } catch (PDOException $e) {
            echo $this->error = $e->getMessage();
        }
    }

    // public function updateUserRfid(){
    //     $userUpdate = $this->conn->prepare("UPDATE user
    //     SET `rfid` = ?
    //     where id = ?");
    //     $userUpdate->execute([
    //         $this->rfid,
    //         $this->id
    //     ]);
    // }

    public function selectSubjectbyCode($code){
        $selectSubByCode = $this->conn->prepare("SELECT * FROM s_subjects WHERE code = :code");
        $selectSubByCode->execute([':code' => $code]);
        $subCodeResults = $selectSubByCode->fetchall(PDO::FETCH_OBJ);

        return $subCodeResults;
    }

    
 }