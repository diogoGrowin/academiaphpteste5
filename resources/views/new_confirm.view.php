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

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirm User</title>
</head>
<body>
<a href="/new">&laquo; back</a>

<form action="/confirm_new" method="POST">

<dl>
  <dt>Key</dt>
  <dd><input type="text" name="key" value="" size='40'/></dd>
</dl>

<input type="submit" value="Confirm" name='confirm_new' />

</form>

    
</body>
</html>