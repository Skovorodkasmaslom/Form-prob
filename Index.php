<?php

$lastname=$firstname=$patronymic=$email=$pass=$confpass="";
$lastnameErr=$firstnameErr=$patronymicErr=$emailErr=$passErr=$confpassErr="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    if (empty($_POST["lastname"])){
        $lastnameErr="Введите фамилию";
    }else{ 
        $lastname=test_input($_POST["lastname"]);
    }

    if (empty($_POST["firstname"])){
        $firstnameErr="Введите имя";
    }else{
        $firstname=test_input($_POST["firstname"]);
    }

    if (empty($_POST["patronymic"])){
        $patronymicErr="Введите отчество";
    }else{
        $patronymic=test_input($_POST["patronymic"]);
    }

    if (empty($_POST["email"])){
        $emailErr="Введите E-mail";
    }else{
        $email=test_input($_POST["email"]);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailErr="Неверный формат E-mail";
    }else{
        $email=test_input($_POST["email"]);
    }

    if (empty($_POST["pass"])){
        $passErr="Введите пароль";
    }else{    
        $pass=test_input($_POST["pass"]);    
    }

    if (empty($_POST["confpass"])){
        $confpassErr="Подтвердите пароль";
    }else{
        $confpass=test_input($_POST["confpass"]);
    }

    if ( $_POST["confpass"]!==$_POST["pass"]){
        $confpassErr="Пароли не совпадают";
    }else{
        $confpass=test_input($_POST["confpass"]);
    }
}

if(((in_array("", $_POST) == false) and (filter_var($email, FILTER_VALIDATE_EMAIL) )) and ($confpass==$pass)){
    $formdata=print_r($_POST, true);
    file_put_contents("Formdata.txt", "$formdata \r\n", FILE_APPEND );
}

function test_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style>
        .error {color: #FF0000;}
        </style>
    </head>
    <body>

    <h2>Регистрационная форма</h2>
    <p><span class="error">* обязательные поля </span></p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

        <label>Фамилия:</label><br/>
        <input type="text" name="lastname" placeholder="Lastname" value="<?php echo $lastname;?>">
        <span class="error">* <?php echo $lastnameErr;?></span><br/>

        <label>Имя:</label><br/>
        <input type="text" name="firstname" placeholder="Firstname" value="<?php echo $firstname;?>">
        <span class="error">* <?php echo $firstnameErr;?></span><br/>

        <label>Отчество:</label><br/>
        <input type="text" name="patronymic" placeholder="Patronymic" value="<?php echo $patronymic;?>">
        <span class="error">* <?php echo $patronymicErr;?></span><br/>

        <label>E-mail:</label><br/>
        <input type="email" name="email" placeholder="Email" value="<?php echo $email;?>">
        <span class="error">* <?php echo $emailErr;?></span><br/>

        <label>Пароль:</label><br/>
        <input type="password" name="pass" placeholder="Password" value="<?php echo $pass;?>">
        <span class="error">* <?php echo $passErr;?></span><br/>

        <label>Подтверждение пароля:</label><br/>
        <input type="password" name="confpass" placeholder="Confirm Password"  value="<?php echo $confpass;?>">
        <span class="error">* <?php echo $confpassErr;?></span><br/>

        <br/>
        <input type="submit" name="done" value="Отправить"/><br/>
    </form>

    </body>
</html>
