<!DOCTYPE html>
<html>
    <head>
        <title>write</title>
    </head>
    <body>
        <?php
            session_start();
            require 'database.php';
            if ($_SESSION['loginstatus']!=1){
                header("Location: simple news site.html");
                exit;
            }
            
            //code below prevents CSRF attack
            if($_SESSION['token'] !== $_POST['token']){
                die("Request forgery detected");
            }
            
            //the code below sanitizes the user input for the cotent of story
            $username=$_SESSION['username'];
            $url=$_POST['url'];
            $content=filter_var($_POST['content'], FILTER_SANITIZE_STRING);
            
            //the preg_match statement is obtained from w3schools. it sanitizes the user input for url.
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)){
                 echo htmlentities("Invalid URL."); 
            }
            
            //the code below stores the story into the database table stories
            $stmt = $mysqli->prepare("insert into stories (username, content, url) values (?,?,?)");
            if (!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('sss',$username,$content,$url);
            $stmt->execute();
            $stmt->close();
            header("Location: stories.php");// redirect to the main stories page
        ?>
    </body>
</html>
