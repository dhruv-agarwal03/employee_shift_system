<?php
    include("header.php");
    include("nav.php");
    $date=date('Y-m-d');
    
    $lastid=0;
    $row=$con->query("SELECT count(*) FROM weeks ");
    if($wid=$row->fetch_array()) {
        $weekid=$wid[0];
    }

    $res=$con->query("SELECT * FROM `schedule` WHERE weekID='$weekid'	AND employeeId='$id'");
    if($row=$res->fetch_array()){

    }
    else{
        header("location:store.php?id=$id&weekId=$weekid&where='Y'");
    }
    
?>
<div class="m-2 p-3">
    
    <table class="table table-bordered table-hover">
    <tr><td>Name</td><td><?= $name?></td></tr>
    <tr><td>E.mail</td><td><?= $email ?></td></tr>
    <tr><td>Contact Number</td><td><?= $phone ?></td></tr>
    <tr><td>City</td><td><?= $city?></td></tr>
    </table>

</div>
<div>
    <a href="store.php?id=<?=$id?>&weekId=<?=$weekid?>&where=N" class="btn btn-primary m-3"> Check Your Shift </a>
</div>
<?php
include("footer.php");
?>