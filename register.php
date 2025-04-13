<?php
    $msg="";
    include("header.php");
    $Fname="";
    $Lname="";
    $name="";
    $email="";
    $pass="";
    $city="";
    if(isset($_POST["submit"])){
        $id=$_POST["id"];
        $Fname=$_POST["Fname"];
        $Fname=$_POST["Lname"];
        $name=$_POST["Fname"]." ".$_POST["Lname"];
        $email=$_POST["email"];
        $number=$_POST["number"];
        $city=$_POST["city"];
        $pass=$_POST["pass"];
        $res = $con->query("SELECT COUNT(*) FROM employees WHERE id='$id' OR email='$email'");
        if($res->fetch_array()[0]!=0){
            $msg="This id is Already Alotted to anyone else, please contact to Company.";
        }
        else{
            $res=$con->query("INSERT INTO `employees`(`id`, `full_name`, `email`, `mobile`, `city`, `password`) VALUES ('$id','$name','$email','$number','$city','$pass')");
            if($res){
                $_SESSION["id"]=$id;
                header("location: home.php");
            }
        }
    }
    else{
        $msg="";
    }
?>
 <style>
    input:hover{
        position:relative;
        bottom:2px;
        transform:scale(1.02);
        box-shadow:.5px 1px #bfd0d6;
    }
 </style>
 <script>
            function check1() {
            const pass = document.getElementById("pass");
            const rpass = document.getElementById("rpass");

    if (pass.value === rpass.value && pass.value.trim() !== "") {
        pass.style.border = "";
        rpass.style.border = "";
        return true;
    } else {
        pass.style.borderStyle = "solid";
        rpass.style.borderStyle = "solid";
        pass.style.borderColor = "red";
        rpass.style.borderColor = "red";
        return false; 
    }
}

            curr=1;
            function prog(){
                document.getElementById("progess").style.width=(curr*33)+"%";
            }
            function nextdiv(){
                if(curr==1){
                    if(!check1()) return;
                }
                if(curr>0){
                    curr++;
                    document.getElementById("div"+curr).style.display="block";
                    document.getElementById("prev").disabled=false;
                    document.getElementById("prev").className="btn-danger btn";
                    document.getElementById("next").className="btn btn-success";
                }
                if(curr==3){
                    document.getElementById("next").disabled=true;
                    document.getElementById("next").className="btn";
                }
                prog();
            }
            function prevdiv(){
                if(curr==2){
                    document.getElementById("prev").disabled=true;
                    
                document.getElementById("prev").className=" btn";
                }
                if(curr>1){
                    document.getElementById("div"+curr).style.display="none";       
                    document.getElementById("next").disabled=false;
                    document.getElementById("next").value="Next";
                    curr--;
                }
                prog();
            }
        </script>
<div class="row">
    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-2 col-sm-1 col-12">
        
    <a class="btn" href="index.php"><h3>&larr;<h3></a>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-8 col-12 bg-white p-3 mt-4" style="border-radius: 25px;">
                <form method="post">
                    <div id="div1" class="identify">
                        <div>
                          <label>Unique ID</label>
                          <input placeholder="Enter your Unique Id" class="form-control" type="text" name="id" required />
                        </div>  
                        <div>
                          <label>E.mail</label>
                          <input placeholder="Enter your Email" class="form-control" type="email" name="email" required />
                        </div>  
                        <div class="row">
                            <div class="col-6">
                                <label>password</label>
                                <input type="password" id="pass" placeholder="password" class="form-control" name="pass" required/>
                            </div>
                            <div class="col-6">
                                <label>re password</label>
                                <input type="password" id="rpass" placeholder="re-password" class="form-control" required/>
                            </div>
                            <br/>
                        </div>
                    </div>
                        <div id="div2" style="display: none">
                                <hr/>
                            <div class="row">
                                <div class="col-2">
                                    <label>&nbsp;</label>
                                   <select class="form-control">
                                    <option>Mr.</option>
                                    <option>Ms.</option>
                                    <option>Dr.</option>
                                    <option>Adv.</option>
                                   </select>
                                </div>
                                <div class="col-5">
                                    <label>Name</label>
                                    <input type="text" placeholder="Name" class="form-control" name="Fname" required/>
                                </div>
                                <div class="col-5">
                                    <label>Surname</label>
                                    <input type="text" placeholder="Surname" name="Lname" class="form-control"/>
                                </div><div class="col-6">
                                <label for="phone">Enter a phone number:</label>
                                <input type="text" id="phone"  name="number" placeholder="XXXXXXXXX" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label>City</label>
                                <Select name="city" class="form-control">
                                    <option>Meerut</option>
                                    <option>Delhi</option>
                                    <option>Ghaziabad</option>
                                    <option>Hapur</option>
                                </select>
                            </div>
                                <br/>
                                <br/>
                            </div>
                       
                    </div>  
                    
                    <div id="div3" style="display: none;" class="row">
                        <br><br>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <div class="bg-white">
                    
                    <br>
                    <div class="progress" role="progressbar" aria-label="Example 1px high" aria-valuenow="25"  aria-valuemin="0" aria-valuemax="100" style="height: 1px">
                        <div class="progress-bar" id="progess" style="width:33%"></div>
                      </div>                      
                    <br>
                    <button class="btn pr-3" onclick="prevdiv()" id="prev" disabled> prev</button>
                    <button class="btn btn-success" onclick="nextdiv()" id="next" value="Next">Next </button>
                </div>
                <div class="h5 text-danger mt-2">
                <?php
                    if($msg!=""){
                        echo $msg .'<br/><a href="#">E.mail</a>';
                    }
                ?> 
                </div>
            </div>
    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-2 col-sm-1 col-12"></div>
</div>

<?php
include("footer.php");
?>