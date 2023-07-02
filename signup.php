
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
    <title>sign up page</title>
    <link rel="stylesheet" href="index.css">
    <script src="index.js"></script>

</head>

<body>
    <section>
        <div class="form-boxx">
            <div class="form-value">
                <form onsubmit="return validateForm()">
                    <h2>Sign up</h2>
                    <div class="input-box">
   
                        <input id="firstName" type="text" oninput="checkinput(this)" placeholder="" required 
                            pattern="[A-Za-z]+" title="Please enter alphabetic characters only">
                        <label for="">Full name</label>
                    </div>
                    <div class="input-box">
                        <input id="familyName" type="text" oninput="checkinput(this)" placeholder="" required pattern="[A-Za-z]+" title="Please enter alphabetic characters only">
                        <label for="">FamilyName</label>
                    </div>
                    <div class="input-box">
                        <ion-icon name="mail"></ion-icon>
                        <input id="Email" type="email" oninput="checkinput(this)" required>
                        <label for="">Email</label>
                    </div>
                    <div class="input-box">
                        <ion-icon name="lock-closed"></ion-icon>
                        <input id="pass" type="password" oninput="checkinput(this)" required pattern="(?=.*[A-Z]).{8,}"
                            title="Please enter at least 8 characters and at least one uppercase letter">
                        <label for="">Password</label>
                    </div>
                    <div class="input-box">
                        <ion-icon name="lock-closed"></ion-icon>
                        <input id="passConfirm" type="password" oninput="checkinput(this);verifyPasswords();" required>
                        <label for="">Confirm Password</label>
                    </div>
                    <div class="forget">
                        <label for=""><input type="checkbox">Remember me</label>
                    </div>
                    <button type="submit">Submit</button>
                    <div class="register">
                        <p>Already have an account? <a href="login.php">Login here</a></p>
                    </div>

                </form>
            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>

<script>
    function verifyPasswords(){
        pass = document.getElementById("pass");
        passConfirm = document.getElementById("passConfirm");

        if (!pass.checkValidity()){
            // passConfirm.setAttribute('correct','false');
            return false;
        }
        if (pass.value == passConfirm.value){
            pass.setAttribute('correct','true');
            passConfirm.setAttribute('correct','true');
            return true;
        }
        else{
            if (passConfirm.value.length>0)  passConfirm.setAttribute('correct','false');
            return false;
        }
    }

    function validateForm() {
        // Get the form element
        var form = document.querySelector('form');

        // Perform validation using checkValidity()
        if (!form.checkValidity()) {
            // Display an error message or perform any other validation logic
            // console.log('Please fill in all required fields.'); //DEBUG (remove this line)
            // alert('Please fill in all required fields.'); //DEBUG (remove this line)

            return false; // Prevent form submission
        }
        if (!verifyPasswords()){
            // console.log('Passwords Do not Match'); //DEBUG (remove this line)
            // alert('Passwords Do not Match'); //DEBUG (remove this line)
            return false;
        }

        // If validation passes, call the desired function
        signUp();


        // Prevent form submission
        return false;
    }
</script>
<script>
    function signUp() {

        firstName = document.getElementById("firstName").value;
        familyName = document.getElementById("familyName").value;
        email = document.getElementById("Email").value;
        password = document.getElementById("pass").value;
        var form = document.querySelector('form');

        req = { task: "signup", email: email, password: password, firstName: firstName, familyName: familyName };
        handler = data => {
                if (data.respond == "already_exist") {
                    alert(" already_exist");
                    document.getElementById("Email").value = "";
                    document.getElementById("Email").setAttribute("correct","false");
                }
                else if (data.respond == "inserted_successfully") {
                    alert("inserted_successfully");
                    window.location = "verif_email.php";
                }
                else {
                    alert("somthing wrong");
                }

            }

        serverFetch(req, handler);       

    }

</script>
