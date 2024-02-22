<?

 class User {

    private $conn;
    public $rfid;
    public $id;

    public function __construct(){
        try {
            $this->conn = new PDO('mysql:host=localhost;dbname=u652554119_admissions');
        } catch (PDOException $e) {
            // attempt to retry the connection after some timeout for example
        }
    }

    public function updateUserRfid(){
        $userUpdate = $this->conn->prepare("UPDATE user
        SET `rfid` = ?
        where id = ?");
        $userUpdate->execute([
            $this->rfid,
            $this->id
        ]);
    }

    
 }