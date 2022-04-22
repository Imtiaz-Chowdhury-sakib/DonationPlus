<?php 

    include('dbconnection/dbconn.php');
    
    $name = $email = $address = $password ="";
    $name_err = $email_err = $address_err = $password_err = "";


    if(isset($_POST['submit']))
    {
        //name validation
        if(empty($_POST["name"])){
            $name_err = "Name is required ";

        }else{
            $name = $_POST['name'];

            // check if name only contains latters and whitespace 
            if(!preg_match("/^[a-zA-Z ]*$/",$name)){
                $name_err = "Only alphabet and whitespace are allowned";
            }
        }

        // email validation

        if (empty($_POST["email"])) {  
            $email_err = "Email is required";  

        } else {  
            $email = $_POST["email"];

            // check that the e-mail address is well-formed  
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
                $email_err = "Invalid email format";  
            }  
     }  



     // address validation

     if(empty($_POST['address'])){
        $address_err = "Address is required";

     }else {
        $address =$_POST['address'];

        //check that the address is well-formed  
        if(!preg_match("/[A-Za-z0-9\-\\,.]+/", $address)){
            $address_err = "address must be valid";
        }
     }


     // password validation 
     if(empty($_POST['password'])){
        $password_err = "Password is required";

    }else {
        $password = $_POST['password'];

        // check if the password is valid or not
        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
 
        if(strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
        $password_err = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
        }

        $password = md5($password);

    }


        //check if email already exist
        $sql = "SELECT * FROM user WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0) {
            $email_err = "Email already exist";
        }

       if($name_err == "" && $email_err == "" && $address_err == "" && $password_err == ""){


        //create sql
        $sql = "INSERT INTO user(name,email,address,password) VALUES('$name','$email','$address','$password')";

        if(mysqli_query($conn,$sql)){
            header('Location: index.php');
        } else {
            echo 'query error'. mysqli_error($conn);
        }

       }


}
   


 ?>


 <!DOCTYPE html>
<html>
     
      <?php include('templates/signupheader.php'); ?>


<section class="container grey-text">
     <h4 class="center" style="color: black;"><b>Sign Up</b></h4>
      <form class="white" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
      
            <label>Name</label>
            <input type="text" name="name">
            <span class="error" style="color: red;"><?php echo $name_err; ?></span>
            <br><br>
    
            <label>Email</label>
            <input type="email" name="email">
            <span class="error" style="color: red;"><?php echo $email_err; ?></span>
            <br><br>

            <label>Address</label>
            <input type="text" name="address">
            <span class="error" style="color: red;"><?php echo $address_err; ?></span>
           <br><br>


             <label>password</label>
            <input type="password" name="password">
            <span class="error" style="color: red;"><?php echo $password_err; ?></span>
            <br><br>

            <div class="center">
                <input type="submit" name="submit" value="Register" class="btn brand z-depth-0">
            </div>

</form>
      

 </section>

      <?php include('templates/footer.php'); ?>



</html>
