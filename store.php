<?php
    include("header.php");
    if (isset($_GET["weekId"])) {
        $weekid = $_GET["weekId"];
        $id = $_GET["id"];
        $check=$_GET["where"];
    }
    
    
    if(isset($_POST["update"])){
        $shift=$_POST["shift"];
        $holiday=$_POST["week"];
        $weekid=$_POST["weekid"];
        $id=$_POST["id"];
        for($i = 1;$i < 8;$i++){
            $bool=0;
            if($holiday==$i) $bool=1;
            $query=" INSERT INTO `schedule`(`weekID`, `employeeId`, `day`, `shift`, `holiday`) VALUES ('$weekid','$id','$i','$shift','$bool')";
            echo($query);
            $res=$con->query($query);
           
        }
        header("location:home.php");
        
    }
?>
<div class="container" id="check">
    
  <form method="post">
    <div class="text-center h1 text-primary m-3">
                New Week , New You
    </div>    
    <p class="h4 m-3">
      <?php
        if($check=='Y'){
          echo(" Here! is the start of a new week!");
        }
        else{
          echo("Now You can change your data on Sunday <br/>");
          echo("You can send mail at <a href='https://drive.google.com/file/d/1oTquGJB6L6t0xjJ3oOmKlJiyE1rgaAcP/view?usp=sharing'>help</a> ");
        } 
     ?>
       
    </p>
<div class="card">
  <div class="card-header h5">
    Schedule 
  </div>
  <div class="card-body">
  <h5 class="card-title">Select the Shift</h5>
    <p class="card-text">
        <input type="radio" value="A" name="shift" checked/> Shift A:  1:00 - 7:00 <br/>
        <input type="radio" value="B" name="shift"/>  Shift B:  7:00 - 13:00<br/>
        <input type="radio" value="C" name="shift"/>   Shift C:  13:00 - 19:00<br/>
        <input type="radio" value="D" name="shift"/>    Shift D:  19:00 - 1:00<br/>
    </p>
    <h5 class="card-title">Select the Shift</h5>
    <p class="card-text">
        <input type="radio" value="1" name="week" checked/> Monday <br/>
        <input type="radio" value="2" name="week"/>  Tuesday<br/>
        <input type="radio" value="3" name="week"/>   Wednesday<br/>
        <input type="radio" value="4" name="week"/>  Thurday<br/>
        <input type="radio" value="5" name="week"/>  Friday<br/>
        <input type="radio" value="6" name="week"/>  Satday<br/>
        <input type="radio" value="7" name="week"/>  Sunday<br/>
    </p>

  </div>

  <div class="card-footer bg-transparent border-success">
  <h5 class="card-title">Terms & Conditions</h5>
  <ol>
    <li>Once Entered you can't change it untill next week.</li>
    <li>If entered value find to be wronf then company has the rights to take action against you.</li>
    <li>You have to provide any other employee if you are on leave</li>
  </ol>
  </div>
  <div style="">
  <input type="hidden" name="id" value="<?= $id?>">
  <input type="hidden" name="weekid" value="<?= $weekid?>">
  </div>

  <button type="Submit" name="update" class="btn btn-primary " id="btn1">Submit</button>
</div>
</form>
  
<?php

if($check=='N'){
  echo('
        <script>
          let element=document.getElementById("btn1");
          element.disabled=true;
        </script>
      ');
}
include("footer.php");
?>