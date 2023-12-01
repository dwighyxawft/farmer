<?php
require("../middleware/objects.php");
$objects = new Objects;
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : false;

if(isset($_POST["page"])){
    if($_POST["page"] == "user"){

        if($_POST["action"] == "signup"){
            $name = $_POST["name"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $gender = $_POST["gender"];
            $state = $_POST["state"];
            $govt = $_POST["govt"];
            $type = $_POST["type"];
            $image = $gender == "male" ? "male.jpg" : "female.jpg";
            $pass_1 = $_POST["pass_1"];
            $pass_2 = $_POST["pass_2"];
            $address = $_POST["address"];
            $objects->query = "SELECT * FROM users WHERE email = '$email' AND type = '$type'";
            if($objects->total_rows() < 1){
                if($pass_1 == $pass_2){
                    $password = password_hash($pass_1, PASSWORD_DEFAULT);
                    $objects->query = "INSERT INTO users (username, email, phone, gender, state, local_govt, type, image, address, password, balance) VALUES ('$name', '$email', '$phone', '$gender', '$state', '$govt', '$type', '$image', '$address', '$password', '0.00')";
                    if($objects->execute_query()){
                        $output = ["status"=>true];
                    }else{
                        $output = ["status"=>false, "msg"=>"Error saving user details"];
                    }
                }else{
                    $output = ["status"=>false, "msg"=>"Passwords are not matching"];
                }
            }else{
                $output = ["status"=>false, "msg"=>"User already exists"];
            }
            

            echo json_encode($output);
        }

        if($_POST["action"] == "login"){
            $email = $_POST["email"];
            $password = $_POST["password"];
            $type = $_POST["type"];
            $objects->query = "SELECT * FROM users WHERE email = '$email' AND type = '$type'";
            if($objects->total_rows() > 0){
                $user = $objects->query_result();
                if(password_verify($password, $user["password"])){
                    $_SESSION["user_id"] = $user["id"];
                    $output = ["status"=>true, "name"=>$user["username"], "type"=>$user["type"]];
                }else{
                    $output = ["status"=>false, "msg"=>"Password is incorrect"];
                }
            }else{
                $output = ["status"=>false, "msg"=>"User does not exist"];
            }
            echo json_encode($output);
        }

        if($_POST["action"] == "delete_product"){
            $id = $_POST["id"];
            $objects->query = "DELETE FROM products WHERE farmer_id = '$user_id' AND id = '$id'";
            if($objects->execute_query()){
                $output = ["status"=>true];
            }
            echo json_encode($output);
        }

        if($_POST["action"] == "settings"){
            $name = $_POST["name"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $state = $_POST["state"];
            $govt = $_POST["govt"];
            $address = $_POST["address"];
            $objects->query = "SELECT * FROM users WHERE id = '$user_id'";
            $user = $objects->query_result();

            if($user["email"] == $email){
                $objects->query = "UPDATE users SET username = '$name', email = '$email', phone='$phone', state='$state', address='$address', local_govt='$govt' WHERE id = '$user_id'";
                if($objects->execute_query()){
                    $output = ["status"=>true];
                }else{
                    $output = ["status"=>false, "msg"=>"Error saving user details"];
                }
            }else{
                $objects->query = "SELECT * FROM users WHERE email = '$email'";
                if($objects->total_rows() == 0){
                    $objects->query = "UPDATE users SET username = '$name', email = '$email', phone='$phone', state='$state', address='$address', local_govt='$govt' WHERE id = '$user_id'";
                    if($objects->execute_query()){
                        $output = ["status"=>true];
                    }else{
                        $output = ["status"=>false, "msg"=>"Error saving user details"];
                    }
                }else{
                    $output = ["status"=>false, "msg"=>"A user already exists with this email"];
                }
    
            }

           echo json_encode($output);
        }

        if($_POST["action"] == "password"){
            $objects->query = "SELECT * FROM users WHERE id = '$user_id'";
            if($objects->total_rows() > 0){
                $account = $objects->query_result();
                $old_pass = $_POST["old_pass"];
                $new_pass = $_POST["new_pass"];
                $con_pass = $_POST["con_pass"];
                if(password_verify($old_pass, $account["password"])){
                    if($new_pass == $con_pass){
                        $hash = password_hash($new_pass, PASSWORD_DEFAULT);
                        $objects->query = "UPDATE users SET password = '$hash' WHERE id = '$user_id'";
                        if($objects->execute_query()){
                            $output = ["status"=>true];
                        }
                    }else{
                        $output = ["status"=>false, "msg"=>"Passwords are not matching"];
                    }
                }else{
                    $output = ["status"=>false, "msg"=>"Password is incorrect"];
                }
            }else{
                $output = ["status"=>false, "msg"=>"User does not exist"];
            }
            echo json_encode($output);
        }

        if($_POST["action"] == "message"){
            $content = $_POST["content"];
            $friend = $_POST["friend"];
            $objects->query = "INSERT INTO messages (sender_id, receiver_id, content) VALUES ('$user_id', '$friend', '$content')";
            if($objects->execute_query()){
                $output = ["status"=>true];
            }
            echo json_encode($output);
        }

        if($_POST["action"] == "add_product"){
            $product_id = $_POST["product_id"];
            $product_amount = $_POST["product_amount"];
            $quantity = $_POST["quantity"];
            $farmer = $_POST["farmer"];
            $product_name = $_POST["product_name"];
            $buyer_name = $_POST["buyer_name"];
            $total = $quantity * $product_amount;
            $objects->query = "INSERT INTO orders (farmer_id, buyer_id, quantity, amount, product_name, buyer_name, total, product_id) VALUES ('$farmer', '$user_id', '$quantity', '$product_amount', '$product_name', '$buyer_name','$total', '$product_id' )";
            if($objects->execute_query()){
                $output = ["status"=>true];
            }
            echo json_encode($output);
        }

        if($_POST["action"] == "withdraw"){
            $acc_num = $_POST["accountNumber"];
            $bank = $_POST["accountBank"];
            $acc_name = $_POST["accountName"];
            $amount = $_POST["amount"];
            $report = $_POST["report"];
            $code = $_POST["code"];
            if(empty($acc_name)){
                $url = "https://api.paystack.co/transferrecipient";

                $fields = [
                    "type" => "nuban",
                    "name" => "Xawft Inc",
                    "account_number" => $acc_num,
                    "bank_code" => $bank,
                    "currency" => "NGN"
                ];

                $fields_string = http_build_query($fields);

                //open connection
                $ch = curl_init();
                
                //set the url, number of POST vars, POST data
                curl_setopt($ch,CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Authorization: Bearer sk_live_58af92d67a993c890713ac20e639ec442169b2ec",
                    "Cache-Control: no-cache",
                ));
                
                //So that curl_exec returns the contents of the cURL; rather than echoing it
                curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
                
                //execute post
                $result = curl_exec($ch);
                echo json_encode($result);
            }else{
                $objects->query = "SELECT * FROM users WHERE id = '$user_id'";
                $user = $objects->query_result();
                if($user["balance"] >= $amount){
                    $url = "https://api.paystack.co/transfer";

                    $fields = [
                        "source" => "balance", 
                        "reason" => $report, 
                        "amount" => $amount, 
                        "recipient" => $code
                        ];

                    $fields_string = http_build_query($fields);

                    //open connection
                    $ch = curl_init();
                    
                    //set the url, number of POST vars, POST data
                    curl_setopt($ch,CURLOPT_URL, $url);
                    curl_setopt($ch,CURLOPT_POST, true);
                    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        "Authorization: Bearer sk_live_58af92d67a993c890713ac20e639ec442169b2ec",
                        "Cache-Control: no-cache",
                    ));
                    
                    //So that curl_exec returns the contents of the cURL; rather than echoing it
                    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
                    
                    //execute post
                    $result = curl_exec($ch);
                    echo json_encode($result);
                }else{
                    echo json_encode(["status"=>false, "msg"=>"Balance is smaller than withdrawal amount"]);
                }

            }
        }

    }
}

?>