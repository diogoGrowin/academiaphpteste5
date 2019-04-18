<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Test Page</title>
</head>
<body>

    <h2>Teste Page</h2>

    <?php

    #echo 'root file redirect ' .__FILE__;

    if(isset($_GET['id']))
    {
        echo $_GET['id'];
    }else
    {
        echo 'root file redirect ' . __FILE__ ;
    }

    if(isset($object))
    {
        echo 'Sucesso ao logar';
    }

    ?>
</body>
</html>

