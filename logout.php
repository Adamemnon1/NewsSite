<!DOCTYPE html>
<html>
    <head>
        <title>Logout</title>
    </head>
    <body>
        <?php
            session_start();
            if (session_destroy()){//ends the session, the user need to relogin next time
                //the code below clears all the session variables.
                unset($_SESSION['loginstatus']);
                unset($_SESSION['token']);
                unset($_SESSION['username']);
                unset($_SESSION['id']);
                unset($_SESSION['password']);
                header("Location: simple news site.html");
                exit;
            }
        ?>
    </body>
</html>
