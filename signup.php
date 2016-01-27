<!DOCTYPE html>
	   <!--Similar comments are ommitted -->
	   
	   
	   
<html>
    <head>
        <title>Sign Up</title>
    </head>
    <body>
        <?php
            session_start();
            require 'database.php';
            
            $username=(string) $_POST['username'];
            $password1=$_POST['password1'];
            $password2=$_POST['password2'];
            
            if(!preg_match('/^[\w_\-]+$/',$username)){
                echo htmlentities("Invalid username");
                exit;
             }
             
            if(!preg_match('/^[a-zA-Z0-9]+$/',$password1)){
                echo htmlentities("Invalid Password");
                exit;
             }
             
            if(!preg_match('/^[a-zA-Z0-9]+$/',$password2)){
                echo htmlentities("Invalid Password");
                exit;
             }
            
			//if the passwords don't match, notift the user
            if ($password1 != $password2){
                echo htmlentities("The passwords you entered did not match.");
                exit;
            }
			
			//tablename = users. username and password are the two columns.
			$stmt = $mysqli->prepare("select COUNT(*) from users where username=?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            
            $stmt->bind_result($cnt);
            $stmt->fetch();
            
			//if the username is alreay uesed, prompt the user to choose a different one
            if ($cnt==1) {echo htmlentities("The username exits. Try a new one"); exit;}
			$stmt->close();
			
			$stmt = $mysqli->prepare("insert into users (username, password) values (?,?)");
            if (!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('ss',$username,crypt ("$password1"));
            $stmt->execute();
            $stmt->close();
        
            $_SESSION['loginstatus']=1;
            $_SESSION['username']=$username;
            $_SESSION['token'] = substr(md5(rand()), 0, 10);
            header("Location: stories.php");
        ?>
    </body>
</html>
