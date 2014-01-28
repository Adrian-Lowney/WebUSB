<?php 
/**
 * @author Adrian
 */
include 'class/LoginView.class.php';
include 'page/partials/base/header.php';
?>

<div id ="content">
        
    <br>
    <h4>Login</h4><hr>
    <br>     

    <div id ="loginBox">
           
        <form  action="login.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="submit"/> 

                    Username: <input name="username" type="text" value="" size="30"/> 
                    Password: <input name="password" type="password" value="" size="30"/> 
                    

                    <center><br><input type="submit" class="myButton" value="Login"/></center>
            </form>
        
    </div>
    
    <br><br><hr><br>
    <a href="register.php">Create Account</a>
</div>  

<?php
include 'page/partials/base/footer.php';
?>