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
                    <td><?php print($row['rfid']); ?></td>
                    <td><?php print($row['lname'].", ".$row['fname']." ".$row['mname']); ?></td>
                    <td><?php print($row['position']); ?></td>
                    <td><a href="reloadprofile.php?rfid=<?php print($row['rfid']); ?>">RELOAD</a></td>
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
public function dataview2($query)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>
                <tr>
                    <td><?php print($row['rfid']); ?></td>
                    <td><?php print($row['lname'].", ".$row['fname']." ".$row['mname']); ?></td>
                    <td><?php print($row['position']); ?></td>
                    <td><a href="viewbalance.php?rfid=<?php print($row['rfid']); ?>">VIEW</a></td>
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