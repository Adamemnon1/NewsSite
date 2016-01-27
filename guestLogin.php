<!DOCTYPE html>
<html>
    <head>
        <title>guest login</title>
    </head>
    <body>
        <?php
            session_start();
            $_SESSION['loginstatus']=0;//the session loginstatus of 0 does not grant write, edit, delete and search rights to the guest
            header("Location: storiesforguest.php");
        ?>
    </body>
</html>
