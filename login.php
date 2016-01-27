<!DOCTYPE html>
       <!--Similar comments are ommitted -->
       
       
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <?php
            session_start();
            require 'database.php';
            
            $username=(string) $_POST ['username'];
            $password=$_POST['password'];
            $_SESSION['token'] = substr(md5(rand()), 0, 10);//a token is created here randomly to prevent CSRF attack
            
            //the code below sanitizes the username input
            if(!preg_match('/^[\w_\-]+$/',$username)){
                echo htmlentities("Invalid username");
                exit;
             }
             
             //code below sanitized the password input
            if(!preg_match('/^[a-zA-Z0-9]+$/',$password)){
                echo htmlentities("Invalid Password");
                exit;
             }
             
            //give back the number of matches with specified username
            $stmt = $mysqli->prepare("select COUNT(*), password from users where username=?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            
            $stmt->bind_result($cnt, $pw);
            $stmt->fetch();
            
            if ($cnt==0) {echo htmlentities("Account does not exist!"); exit;}

            //if there is one match, log the user in accordingly 
            if ($cnt ==1 && crypt($password,$pw)==$pw){
                $_SESSION['loginstatus'] =1;
                $_SESSION['username']=$username;
                if ($username=="admin"){
                    header("Location: admin.php");
                    exit;
                }
                header("Location: stories.php");
               exit;
            }else{
                echo htmlentities("Incorrect password!");
            }
        ?>
    </body>
</html>
