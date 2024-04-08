<?php

class crud
{
    private $db;

    function __construct($DB_con)
    {
        $this->db = $DB_con;
    }

    public function create($rfid,$fname,$mname,$lname,$position,$dob,$email,$mobile,$vacchist,$photo,$isactive)
    {
        try
        {
            $stmt = $this->db->prepare("INSERT INTO user(rfid,fname,mname,lname,position,dob,email,mobile,vacchist,photo,isactive) VALUES (:rfid,:fname,:mname,:lname,:position,:dob,:email,:mobile,:vacchist,:photo,:isactive)");
            $stmt->bindparam(":rfid",$rfid);
            $stmt->bindparam(":fname",$fname);
            $stmt->bindparam(":mname",$mname);
            $stmt->bindparam(":lname",$lname);
            $stmt->bindparam(":position",$position);
            $stmt->bindparam(":dob",$dob);
            $stmt->bindparam(":email",$email);
            $stmt->bindparam(":mobile",$mobile);
            $stmt->bindparam(":vacchist",$vacchist);
            $stmt->bindparam(":photo",$photo);
            $stmt->bindparam(":isactive",$isactive);
            $stmt->execute();
            return true;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }

    }

    public function getID($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id=:id");
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

    public function update($rfid,$fname,$mname,$lname,$position,$dob,$email,$mobile,$vacchist,$photo,$isactive)
    {
        try
        {
            $stmt=$this->db->prepare("UPDATE user SET fname=:fname,mname=:mname,lname=:lname,position=:position,dob=:dob,email=:email,mobile=:mobile,vacchist=:vacchist,photo=:photo,isactive=:isactive WHERE id=:id ");
            $stmt->bindparam(":rfid",$rfid);
            $stmt->bindparam(":fname",$fname);
            $stmt->bindparam(":mname",$mname);
            $stmt->bindparam(":lname",$lname);
            $stmt->bindparam(":position",$position);
            $stmt->bindparam(":dob",$dob);
            $stmt->bindparam(":email",$email);
            $stmt->bindparam(":mobile",$mobile);
            $stmt->bindparam(":vacchist",$vacchist);
            $stmt->bindparam(":photo",$photo);
            $stmt->bindparam(":isactive",$isactive);
            $stmt->execute();

            return true;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM user WHERE id=:id");
        $stmt->bindparam(":id",$id);
        $stmt->execute();
        return true;
    }

    /* paging */

    public function dataview($query)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>
                <tr>
                    <td><a href="
                    <?php
                        switch($row['position']) {
                            case 'Student':
                                print("timecard-students.php?user=".$row['id']);
                                break;
                            default:
                                print("timecard.php?user=".$row['id']);
                        }?>" ><?php print($row['lname'].", ".$row['fname']." ".$row['mname']); ?></a></td>
                    <td><?php print($row['position']); ?></td>
                    <td><?php print($row['dob']); ?></td>
                    <td><?php print($row['email']); ?></td>
                    <td><?php print($row['mobile']); ?></td>
                    <td>
                        <?php
                            switch($row['isactive']){
                                case 1:
                                    print ("Yes");
                                    break;
                                default:
                                    print ("No");
                            }
                        ?>
                    </td>
<!--                    <td class="text-center">
                        <a href="edit-data.php?edit_id=<?php /*print($row['id']); */?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                        </a>
                    </td>-->
                    <td class="text-center">
                        <a href="../delete.php?delete_id=<?php print($row['id']); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                <?php
            }
        }
        else
        {
            ?>
            <tr>
                <td>Nothing here...</td>
            </tr>
            <?php
        }

    }

    public function paging($query,$records_per_page)
    {
        $starting_position=0;
        if(isset($_GET["page_no"]))
        {
            $starting_position=($_GET["page_no"]-1)*$records_per_page;
        }
        $query2=$query." limit $starting_position,$records_per_page";
        return $query2;
    }

    public function paginglink($query,$records_per_page)
    {

        $self = $_SERVER['PHP_SELF'];

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $total_no_of_records = $stmt->rowCount();

        if($total_no_of_records > 0)
        {
            ?><ul class="pagination"><?php
            $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
            $current_page=1;
            if(isset($_GET["page_no"]))
            {
                $current_page=$_GET["page_no"];
            }
            if($current_page!=1)
            {
                $previous =$current_page-1;
                echo "<li><a href='".$self."?page_no=1'>First</a>&nbsp;</li>";
                echo "<li>&nbsp;<a href='".$self."?page_no=".$previous."'>Previous</a>&nbsp;</li>";
            }
            for($i=1;$i<=$total_no_of_pages;$i++)
            {
                if($i==$current_page)
                {
                    echo "<li>&nbsp;<a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a>&nbsp;</li>";
                }
                else
                {
                    echo "<li>&nbsp;<a href='".$self."?page_no=".$i."'>".$i."</a>&nbsp;</li>";
                }
            }
            if($current_page!=$total_no_of_pages)
            {
                $next=$current_page+1;
                echo "<li>&nbsp;<a href='".$self."?page_no=".$next."'>Next</a>&nbsp;</li>";
                echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a>&nbsp;</li>";
            }
            ?></ul><?php
        }
    }

    /* paging */

}