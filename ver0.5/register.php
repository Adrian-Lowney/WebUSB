<?php 
/**
 * @author Adrian
 */
include 'class/RegisterView.class.php';
include 'page/partials/base/header.php';
?>

    <div id ="content">
         
    <br>
    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please Register Below...</h4><hr>
    <br>     

    <div id ="loginBox">
           
        <form  id ="myform" action="register.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="submit"/> 

                    Username:<br> <input name="username" type="text" value="" size="30"/>
                    <br>First name:<br> <input name="firstName" type="text" title = "No special characters except underscores and spaces "value="" size="30"/> 
                    <br> Last name:<br> <input name="lastName" type="text" value="" size="30"/> 
                    <br> Email Address:<br> <input name="email" type="text" value="" size="30"/> 
                    <br> Password:<br> <input name="password" type="password" value="" size="30"/> 
                    <br> Confirm Password:<br> <input name="confirmPassword" type="password" value="" size="30"/>

                    <center><br><input type="submit" class="myButton" value="Register"/></center>
            </form>
    </div>

    <br><br><hr><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="login.php">Login</a>    
    
</div>  

<?php
include 'page/partials/base/footer.php';
?>