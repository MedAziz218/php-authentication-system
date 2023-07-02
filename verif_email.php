<!DOCTYPE html>
<html>
    <head>
        <title>Email verification</title>
        <link rel="stylesheet" href="index.css">
        <script src="index.js"></script>
    </head>
</html>
<body>

    <section>
        <div class="form-box">
            <div class="form-value">
                <form onsubmit="return validateForm()">
                    <h2>Email verification</h2>
                    <div class="input-box">
                        <ion-icon name="mail"></ion-icon>
                        <input type="text" required id = "email" readonly value="" >
                        <label for="">Email</label>
                    </div>
                    <div class="input-box">
                        <ion-icon name="mail"></ion-icon>
                        <input type="text" oninput="checkinput(this)" required id = "code" name = "code"  pattern="[A-Za-z0-9]{8}" title="Please enter a valid 8-character string with only alphabetic characters or numbers.">
                        <label for="">Verification Code</label>
                    </div>
                    <div class = "input-box spacing" >
                        <button type = "submit" >Verify</button> 
                    </div>
                </form>
                    <div class = "input-box spacing">                       
                        <button type = "resend"  onclick="resend_verification()">resend</button> 
                    </div>
                    
                    
                    <div class="register">
                        <p>Change Email <a href="signup.php?">Register</a></p>
                    </div>
                
                
            </div>
        </div>
    </section>
</body>
<script>
    function resend_verification(){
        send_verification();
        
    }
    function send_verification(){
        serverFetch({task : "send_verification" },data=>{});  
    }
    
    function verify(){
        code = document.getElementById("code").value;

        req = {task : "verify" , code : code };
        handler = data => {
                if(data.respond == "verified"){
                    window.location = 'login.php';
                }
                else if(data.respond == "not_verified"){
                    alert("unvalid code");
                    document.getElementById("code").value = "";
                }
                
            }
        serverFetch(req,handler);        
    }
        function validateForm() {
        // Get the form element
        var form = document.querySelector('form');

        // Perform validation using checkValidity()
        if (!form.checkValidity()) {
            // Display an error message or perform any other validation logic
            console.log('Please fill in all required fields.');
            alert('Please fill in all required fields.');

            return false; // Prevent form submission
        }

        verify();


        // Prevent form submission
        return false;
    }

</script>


<?php
    session_start();
    if(isset($_SESSION["email"])){
        $email = $_SESSION["email"];
        echo " <script>document.getElementById('email').value = '{$_SESSION['email']}'</script>";
        echo "<script>document.getElementById('email').setAttribute('empty', 'false');</script>";
        

        if(!isset($_SESSION['code']) || ($_SESSION['code'] != 'null')){
            echo "<script> send_verification();</script>";
        }
        else{
            require_once "database.php";
            $sql="SELECT * FROM users ";
            $result=mysqli_query($conn,$sql);
            if (mysqli_num_rows( $result)>=0) {
                $rows =mysqli_fetch_all($result);
                foreach($rows as $i){              
                if ($i[1]==$email ) {
                   $verified = $i[6];
                   if($verified == 1){
                    //  echo "<script>window.location = 'login.php';</script>";
                    header("Location:login.php");
                   }
                    break;
                }}}
           
        }
        
    }
    else{
        // echo "<script>window.location = 'login.php';</script>";
        header("Location:login.php");

        
    }
   
?>