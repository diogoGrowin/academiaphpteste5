<?php
#require_once('../../private/initialize.php');

#$errors = [];
#$username = '';
#$password = '';
/*
if(is_post_request()) {

  #$username = $_POST['username'] ?? '';
 # $password = $_POST['password'] ?? '';

  // Validations
  if(is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }
  if(is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors)) {
    $admin = Admin::find_by_username($username);    //check if user exist or return false
    
    // test if admin found and password is correct
    if($admin != false && $admin->verify_password($password))  //verify if the password matches to login the user 
    {
      // Mark admin as logged in
      $session->login($admin);      //login the user 

      header('Location: /public/staff/index.php');
    } else {
      // username not found or password does not match
      $errors[] = "Log in was unsuccessful.";
    }

  }

}*/

    




?>

<div id="content" align="center" style="margin-top: 50px;">
<?php
//display errors
    if(isset($object['errors']) && !empty($object['errors']))            
    {
        foreach($object['errors'] as $value)
        {
            echo '<p style="color: red;">'.$value.'</p>';
        } 
    } 
?>
  <h1>Log in</h1>
    <!-- name of the form to be redirected on .htaccess file -->
  <form action="/auth" method="post">
    Username:
    <input type="text" name="username" value="<?php #echo htmlspecialchars($username); ?>" /><br /><br />
    Password:
    <input type="password" name="password" value="" /><br /><br />
    <input type="submit" name="login" value="Login" style="font-size: 20px; border-radius: 8px;"  />
  </form>

    <br/>
  <p>Não têm conta ?</p>

<ul  style="list-style-type: none;margin: 0; padding: 0;">
  <li><a href="<?php echo '/new'; ?>">Registe-se aqui</a></li>
</ul>

</div>

<?php #include(SHARED_PATH . '/staff_footer.php'); ?>
