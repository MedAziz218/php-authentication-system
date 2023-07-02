<?php 
 // zid if _SESSION["already logged in"] arja3 lel main 
// si non reset the session
// if (isset($_SESSION['is_logged_in]))
// {....}
//else { ..
    session_start();
    $_SESSION = array(); // Clear all session variables
    session_destroy();
// .. }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>login page</title>
        <link rel="stylesheet" href="index.css">
        <script src="index.js"></script>
    </head>
</html>
<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form onsubmit="return validateForm()">
                    <h2>Login</h2>
                    <div class="input-box">
                        <ion-icon name="mail"></ion-icon>
                        <input type="text" required id = "email" oninput="checkinput(this)">
                        <label for="">Email</label>
                    </div>
                    <div class="input-box">
                        <ion-icon name="lock-closed"></ion-icon>
                        <input type="password" required id = "password" oninput="checkinput(this)" pattern="(?=.*[A-Z]).{8,}"
                            title="Please enter at least 8 characters and at least one uppercase letter">
                        <label for="">Password</label>
                    </div>
                    <div class="forget">
                        <label for=""><input type="checkbox">Remember me</label>
                        <a href="">Forget password</a>
                    </div>
                    <button type = "submit">Log in</button> 
                    <div class="register">
                        <p>Don't have a account <a href="signup.php?">Register</a></p>
                    </div>

                
            </div>
        </div>
    </section>
</body>
<script>

    function validateForm() {
        // Get the form element
        var form = document.querySelector('form');

        // Perform validation using checkValidity()
        if (!form.checkValidity()) {
            // Display an error message or perform any other validation logic
            // console.log('Please fill in all required fields.');  //DEBUG (remove this line)
            // alert('Please fill in all required fields.');  //DEBUG (remove this line)

            return false; // Prevent form submission
        }

        login();

        // Prevent form submission
        return false;
    }

</script>
<script>
    function login(){
        //inputs 
        email = document.getElementById("email").value;
        password = document.getElementById("password").value;
        req = {task : "login", email : email , password : password};
        handler = data => {
                if(data.respond == "valid"){
                    id = data.id;
                    idVerified = data.idVerified; 
                    if(data.idVerified == 0){
                        msg = `Account Verification Required: Please verify your email address to access your account.\n\nCheck your inbox for a verification email and follow the instructions provided.\nIf you haven't received the email, please check your spam folder.\nThank you for your cooperation.`
                        alert(msg);
                        window.location = "verif_email.php";
                    }
                    else{alert("valid " + id + " verified");} //DEBUG (remove this line)
                    
                }
                
                else if(data.respond == "not_found"){
                    msg = `Account Not Found: The account you are trying to access does not exist.\n\nPlease make sure you have entered the correct username or email address.\nIf you do not have an account, please sign up to create a new account. For any further assistance, please contact our support team. Thank you.`
                    document.getElementById("password").value = '';
                    alert(msg);
                }
               
                else{//DEBUG (remove this close)
                    msg = `Internal Server Error: Sorry, something went wrong on our end.\n\nWe are working to resolve the issue. Please try again later.\nThank you for your patience.`
                    alert(msg);  
                }  
                

            }
       
        serverFetch(req ,handler);
         
    }


</script>
