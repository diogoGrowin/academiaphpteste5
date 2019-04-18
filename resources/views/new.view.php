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
    <title>New User</title>
</head>
<body>
<a href="/login">&laquo; back</a>

    <h2>New User</h2>

    <form action="/create_new" method="POST">
    <table>
        <tr>
            <td>First name </td>
            <td> 
                <input type="text" name="first_name"
                <?php 
                    if(!empty($object['errors']))
                    {
                        echo "value=\"". htmlspecialchars($object2['first_name']) ."\""; 
                    }
                ?> size="30" />
            </td>
        </tr>

        <tr>
            <td>Last name</td>
            <td><input type="text" name="last_name"
            <?php 
                if(!empty($object['errors']))
                {
                    echo "value=\"" . htmlspecialchars($object2['last_name']) ."\""; 
                }
            ?> size="30"/>
            <td>
        <tr>

        <tr>
            <td>Email</td>
            <td><input type="email" name="email" 
            <?php
                if(!empty($object['errors']))
                {
                    echo "value=\"" . htmlspecialchars($object2['email']) ."\""; 
                }
            ?> size='30'/>
            </td>
        </tr>

        <tr>
            <td>Username</td>
            <td> <input type="text" name="username" 
            <?php
                if(!empty($object['errors']))
                {   
                    echo "value=\"" . htmlspecialchars($object2['username']) ."\""; 
                }
            ?> size='30'/>
            </td>
        </tr>

        <tr>
            <td>Password</td>
            <td><input type="password" name="password" value="" size='30'/></td>
        </tr>

        <tr>
            <td>Confirm Password</td>
            <td><input type="password" name="confirm_password" value="" size='30'/></td>
        </tr>

    </table>
<br/>
<input type="submit" value="Create" name='new_user' style="font-size: 18px; border-radius: 6px;" />

    </form>

    <br/>
  <p>Já têm codigo ?</p>

<ul  style="list-style-type: none;margin: 0; padding: 0;">
    <li><a href="<?php echo '/display_confirm' ?>">Clique aqui para continuar</a></li>
</ul>

</body>
</html>