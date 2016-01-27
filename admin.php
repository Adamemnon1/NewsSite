<!DOCTYPE html>
<html>
    <head>
        <title>Admin Management Portal</title>
    </head>
    <body>
	<style scoped type = "text/css">
		form {text-align : center;}
		textarea {text-align : center;
			display: block;
			margin-left: auto;
			margin-right:auto;
		}
	</style>
        <?php
            session_start();
            require 'database.php';
            
            //if the user is not logged, the page is redirected to the front page
             if ($_SESSION['loginstatus']!=1){
                header("Location: simple news site.html");
                exit;
            }
            
            $token=$_SESSION['token'];
            
            //the code below obtains the content of the stories from the database along with its ID, usernmae and time created
            $stmt = $mysqli ->prepare("select pk_ID, username, time_created, content from stories order by time_created");    
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli-> error);
                    exit;
                }
            
            $stmt -> execute();
            $stmt ->bind_result($id, $user,$time_created,$content);
            
            while ($stmt->fetch()){
                printf("\t %s %s:<br/> %s\n",
                       htmlentities($user),
                       htmlentities($time_created),
                       htmlentities($content)
                       );
                
                print "<form action='admincontent.php' method='GET'>";
                print "<input type='hidden' name= 'id' value='$id'/>";//$id here is submitted via form to help retrieve the stories and comments assiociated with the story later 
                print "<input type= 'submit' value= 'View Content'/>";
                print "</form>";
				echo "<br> <br>";
            }

            $stmt->close();
        ?>
        <br>
		<br>
        
         <form action="adminsearch.php" method="POST">
            <input type="text" name="query" />
            <select name="type">
                <option value="username">Username</option>
                <option value="story">Story</option>
                <option value="comment">Comment</option>
            </select>
            <input type="submit" value="Search"/>
        </form>
        <br/>
		<br>
        
        <!--textarea creates a tecxt box for the user input of the content-->
        <textarea rows="4" cols="50" name="content" form="write">Write your story here.</textarea>
        <br/>
        <form action="write.php" method="POST" id="write">
            URL: <input type="text" name="url"/>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" /><!--the token that was created before is passed along in the form to prevent CSRF attacks-->
            <input type="submit" value="Submit Story"/>
        </form>
        <br>
        <form action="logout.php" method="GET">
        <input type="submit" value="Logout"/>
        </form>
        
    </body>
</html>
