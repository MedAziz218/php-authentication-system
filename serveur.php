<?php
    require_once "database.php";
    use PHPMailer\PHPMailer\PHPMailer;
    require_once("PHPMailer-master/src/PHPMailer.php");
    require_once("PHPMailer-master/src/SMTP.php");
    $mail = new PHPMailer(true);


    // mailer settings
    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;

    $mail->Username = 'tmailtest081@gmail.com';

    $mail->Password = 'iqujrvaptbghmjto';

    $mail->SMTPSecure = 'ssl'; // You can use 'ssl' if required by your server

    $mail->Port = 465; // Use the appropriate port for your server

    /////////////////////////////////////////////////////////


    session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $jsonData = json_decode(file_get_contents('php://input'), true);
        if (isset($jsonData['task'])){
            if($jsonData['task'] == "login"){
                if(isset($jsonData['email']) && isset($jsonData['password'])){
                    $valid = false;
                    
                    $task = $jsonData['task'];
                    $email = $jsonData['email'];
                    $password = $jsonData['password'];
                    $sql="SELECT * FROM users ";
                    $result=mysqli_query($conn,$sql);
                    if (mysqli_num_rows( $result)>0) {
                        $rows =mysqli_fetch_all($result);
                        foreach($rows as $i){
                
                        if ($i[1]==$email && (password_verify($password, $i[4]))) {
                            $_SESSION["id"] = $i[0];
                            $id = $_SESSION["id"];
                            $idVerified = $i[6];
                            $valid = true;
                            break;
                        }}
                        if(!$valid){
                            $data = array(
                                "respond" => "not_found",
                                
                            );
                            header('Content-Type: application/json');
                            echo json_encode($data);
                        }
                        else{
                            $_SESSION['email'] = $email;
                            $data = array(
                                "respond" => "valid",
                                "id" => $id,
                                "idVerified" => $idVerified
                            );
                            header('Content-Type: application/json');
                            echo json_encode($data);
                        }
    
                    }
          
                }
            }
            else if($jsonData['task'] == "signup"){
                if(isset($jsonData['email']) && isset($jsonData['password']) && isset($jsonData['firstName']) && isset($jsonData['familyName'])){
                    $email = $jsonData['email'];
                    $password = $jsonData['password'];
                    $firstName = $jsonData['firstName'];
                    $familyName = $jsonData['familyName'];
                    $exist = false;
                    

                    // check if email exist 
                    $sql="SELECT * FROM users ";
                    $result=mysqli_query($conn,$sql);
                    if (mysqli_num_rows( $result)>=0) {
                        $rows =mysqli_fetch_all($result);
                        foreach($rows as $i){              
                        if ($i[1]==$email ) {
                           $exist = true;
                            break;
                        }}
                        if($exist){
                            $data = array(
                                "respond" => "already_exist",
                                
                            );
                            header('Content-Type: application/json');
                            echo json_encode($data);
                        }
                        else{
                            $query = "INSERT INTO users (email, firstName, familyName, password ) VALUES (:value1, :value2, :value3, :value4)";
                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(':value1', $email);
                            $stmt->bindParam(':value2', $firstName);
                            $stmt->bindParam(':value3', $familyName); 
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            $stmt->bindParam(':value4', $hashedPassword);
                            $stmt->execute();
                            $data = array(
                                "respond" => "inserted_successfully"
                                
                            );
                            header('Content-Type: application/json');
                            echo json_encode($data);
                            $_SESSION['email'] = $email;
                            $_SESSION['firstName'] = $firstName;
                        }
                    }
                }
            }
            else if($jsonData['task'] == "send_verification"){
                $mail->setFrom('tmailtest081@gmail.com', 'PROJECT_design');

                $mail->addAddress($_SESSION['email'], $_SESSION['firstName']);
                $code = generateRandomString(8);
                $_SESSION['code'] = $code;
                $mail->Subject = 'Verification Code';

                $mail->Body = 'This is your verification code : '.$code;
                if ($mail->send()) {

                    $data = array(
                        "respond" => "code_sent",
                        "code " => $code
                    );
                    header('Content-Type: application/json');
                    echo json_encode($data);
        
                } else {
        
                    
                    $data = array(
                        "respond" => "failed_to_send",
                    );
                    header('Content-Type: application/json');
                    echo json_encode($data);
        
                }
               

            }
            else if($jsonData['task'] == "verify"){
                if($jsonData['code'] == $_SESSION['code']){
                    $email = $_SESSION['email'];
                    $sql = "UPDATE `users` SET `verif` = 1 WHERE `email` = '$email'";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $data = array(
                        "respond" => "verified"                     
                    );
                    header('Content-Type: application/json');
                    echo json_encode($data);
                }
                else{
                    $data = array(
                        "respond" => "not_verified"                     
                    );
                    header('Content-Type: application/json');
                    echo json_encode($data);
                }
            }
               
            
        }
    }


    function generateRandomString($length = 8) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charLength - 1)];
        }
        
        return $randomString;
    }
    
    





?>