<div>
  <nav class="nav m-2 d-flex w-100">
    <a class="nav-link" href="home.php">Home</a>
    <a class="nav-link" href="shiftChange.php">Shift Change</a>
    <a class="nav-link" href="weekOff.php">Week Off</a>
    <a class="nav-link" href="allRequest.php">My Request</a>
    <a class="nav-link" href="password.php">Password Change</a>
    <a class="nav-link" href="req.php">All Request</a>
    <?php
    $id="";
    $name="";
    $email="";
    $phone="";
    $city="";
    $pass="";
    if(isset($_SESSION["id"])){
        $id = $_SESSION["id"];
        $check=$con->query("SELECT * FROM employees WHERE id='$id'");
        
        if ($row = $check->fetch_assoc()) {
            $name=$row["full_name"];
            $email=$row["email"];
            $phone=$row["mobile"];
            $city=$row["city"];
            $pass=$row["password"];
        } 
    }
    else{
        header("location:index.php");
    }
    $res = $con->query("SELECT MAX(week_id) FROM weeks");
    $weekid=-1;
    if ($row = $res->fetch_array()) {
      $weekid = $row[0];
  }
    ?>
    <title><?= $name?></title>
    <label class="nav-link ms-auto text-success" href="#">Hi! <?= $name?> </label>
    
    <a class="nav-link text-danger  me-3" href="logout.php">LogOut </a>
  </nav>
  <hr/>
</div>
