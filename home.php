<?php
    include("header.php");
    include("nav.php");
    $date=date('Y-m-d');
    echo('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">');
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
<a href="https://github.com/dhruv-agarwal03/employee_shift_system" class="btn btn-primary m-3 "> Source Code <i class="fa fa-github"></i></a>
<a href="https://drive.google.com/file/d/1oTquGJB6L6t0xjJ3oOmKlJiyE1rgaAcP/view?usp=sharing" class="btn btn-primary m-3 "><img src="https://img.icons8.com/?size=100&id=44091&format=png&color=000000" width="25px"> Resume </a>
</div>
<?php
include("footer.php");
?>
