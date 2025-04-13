<?php
    include("header.php");
    include("nav.php");
    if(isset($_POST["change_password"])){
        $oldpass=$_POST["old_password"];
        $res = $con->query("SELECT password FROM `employees` WHERE id='$id'");
        $row = $res->fetch_assoc();
        $hashedPassword = $row['password'];

    if ($hashedPassword!=$oldpass) {
    echo '<div class="alert alert-danger" role="alert">
  Old Password Not matched.
</div>';
    }
    else{
        $newHash=$_POST["new_password"];
        $con->query("UPDATE employees SET password='$newHash' WHERE id='$id'");  
        header("location:password.php");
    } 
        }
?>

<script>
function f1() {
    let p1 = document.getElementById("new_password");
    let p2 = document.getElementById("confirm_password");

    if (p1.value !== p2.value) {
        p2.classList.add("is-invalid");
    } else {
        p2.classList.remove("is-invalid");
    }
}
</script>

<div class="container mt-5">
  <div class="card">
    <div class="card-header">Change Password</div>
    <div class="card-body">
      <form method="post">
        <div class="form-group">
          <label>Old Password</label>
          <input type="password" name="old_password" class="form-control" required>
        </div>
        <div class="form-group">
          <label>New Password</label>
          <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Confirm New Password</label>
          <input type="password" name="confirm_password" id="confirm_password" onblur="f1()" class="form-control" required>
          <div class="invalid-feedback">Passwords do not match.</div>
        </div>
        <button type="submit" name="change_password" class="btn btn-primary mt-3">Update Password</button>
      </form>
    </div>
  </div>
</div>
<?php
include("footer.php");
?>