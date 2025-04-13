<?php 
    $msg="";
    include("header.php");
    if(isset($_POST["submit"])){
        $id=$_POST["id"];
        $pass=$_POST["password"];
        $check=$con->query("SELECT * FROM employees WHERE id='$id' AND password='$pass'");
        if($row=$check->fetch_assoc()){
            $_SESSION["id"]=$id;
            header("location:home.php");
        }else{
            $msg="invalid ID and Password";

        }
    }
?>
 <style>
    input:hover{
        position:relative;
        bottom:2px;
        transform:scale(1.03);
        box-shadow:.5px 1px #bfd0d6;
    }
 </style>
<div class="row">
    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-2 col-sm-1 col-12"></div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-8 col-sm-10 col-12">
        <div class=" pt-5">
            <div class="card">
                <div class="card-header h3 card-title  text-center">
                    Login
                </div>
                <div class="card-body ">
                   <form method="post">
                        <div>
                            <label class="h6">
                                Employee ID'
                            </label>
                            <input type="text" class="form-control" name="id"/>
                        </div>
                        <div>
                            <label class="h6">
                                password
                            </label>
                            <input type="password" class="form-control" name="password"/>
                        </div>
                        <div>
                            <input type="submit" name="submit" class="Login btn mt-2 btn-success"/>
                            <a href="register.php" class="m-2 mt-2 link-opacity-50  link-opacity-100-hover">New User/Register</a>
                        </div>
                   </form>
                </div>
            </div>            
        </div>
    </div>
    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-2 col-sm-1 col-12"></div>
</div>

<?php
include("footer.php");
?>