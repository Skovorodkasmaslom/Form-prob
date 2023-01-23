<?php

declare(strict_types=1); //включение строгой типизации

$lastname = $firstname = $patronymic = $email = $pass = $confpass = "";

$errors = [];

$success = "";

$denied = "";

//проверка отправки на сервер данных методом ПОСТ
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //проверка фамилии
    if (empty($_POST['lastname'])){
        $errors['lastname'] = "Введите фамилию";
    }elseif(!validateUsersNames($_POST['lastname'])){
        $errors['lastname'] = "Введите корректные данные";
    }else{
        $lastname = $_POST['lastname'];
    }
    //проверка имени
    if (empty($_POST['firstname'])){
        $errors['firstname'] = "Введите имя";
    }elseif(!validateUsersNames($_POST['firstname'])){
        $errors['firstname'] = "Введите корректные данные";
    }else{
        $firstname = $_POST['firstname'];
    }
    //проверка отчества
    if (empty($_POST['patronymic'])){
        $errors['patronymic'] = "Введите отчество";
    }elseif(!validateUsersNames($_POST['patronymic'])){
        $errors['patronymic'] = "Введите корректные данные";
    }else{
        $patronymic = $_POST['patronymic'];
    }
    //проверка емайла
    if (empty($_POST['email'])){
        $errors['email'] = "Введите E-mail";
    }elseif(!validateEmail($_POST["email"])){
        $errors['email'] = "Введите корректный E-mail";
    }else{    
        $email = $_POST['email'];
    } 
    //проверка пароля
    if (empty($_POST['pass'])){
        $errors['pass'] = "Введите пароль";
    }elseif(!validatePass($_POST['pass'])){
        $errors['pass'] = "Пароль должен быть не менее 8 символов и включать в себя только латинские буквы и цифры";
    }else{    
        $pass = $_POST['pass'];    
    }
    //проверка совпадения пароля
    if (empty($_POST['confpass'])){
        $errors['confpass'] = "Подтвердите пароль";
    }elseif($_POST["confpass"] !== $_POST["pass"]){
        $errors['confpass'] = "Пароли не совпадают";
    }else{
        $confpass = $_POST['confpass'];
    }
}

//запись данных в файл и информирование об успехе
if(isset($_POST['done']) && empty($errors)){
    $formdata = print_r($_POST, true);
    file_put_contents("Formdata.txt", "$formdata \r\n", FILE_APPEND);
    $success = "Регистрация прошла успешно!";
}else{
    $denied = "*Заполните все обязательные поля!";
}
//валидация имён
function validateUsersNames($name){
    if(preg_match('/^([а-яА-ЯЁёa-zA-Z]+)$/u', $name) && mb_strlen($name) > 1 && mb_strlen($name) < 40){
        return htmlspecialchars(strip_tags(stripslashes(trim($name))));
    }
}
//валидация емайл
function validateEmail($email){
    return $email = filter_var($email, FILTER_VALIDATE_EMAIL);
}
//валидация пароля
function validatePass($pass){
    if(preg_match('/^([a-zA-Z0-9]+)$/u', $pass) && mb_strlen($pass) > 7 && mb_strlen($pass) < 33){
        return $pass;
    }
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
        <div>
            <? if(isset($success)) { ?>
                <font color="green"><?=$success?></font><? }else{ ?><font color="red"><?=$denied?></font><br/><br/>
            <? } ?>
        </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

        <label>Фамилия:</label><br/>
        <input type="text" name="lastname" placeholder="Lastname" value="<?php echo $lastname;?>">
        <span class="error">* <?php echo isset($errors['lastname'])?$errors['lastname']:"";?></span><br/>

        <label>Имя:</label><br/>
        <input type="text" name="firstname" placeholder="Firstname" value="<?php echo $firstname;?>">
        <span class="error">* <?php echo isset($errors['firstname'])?$errors['firstname']:"";?></span><br/>

        <label>Отчество:</label><br/>
        <input type="text" name="patronymic" placeholder="Patronymic" value="<?php echo $patronymic;?>">
        <span class="error">* <?php echo isset($errors['patronymic'])?$errors['patronymic']:"";?></span><br/>

        <label>E-mail:</label><br/>
        <input type="email" name="email" placeholder="Email" value="<?php echo $email;?>">
        <span class="error">* <?php echo isset($errors['email'])?$errors['email']:"";?></span><br/>

        <label>Пароль:</label><br/>
        <input type="password" name="pass" placeholder="Password" value="<?php echo $pass;?>">
        <span class="error">* <?php echo isset($errors['pass'])?$errors['pass']:"";?></span><br/>

        <label>Подтверждение пароля:</label><br/>
        <input type="password" name="confpass" placeholder="Confirm Password"  value="<?php echo $confpass;?>">
        <span class="error">* <?php echo isset($errors['confpass'])?$errors['confpass']:"";?></span><br/>

        <br/>
        <input type="submit" name="done" value="Отправить"/><br/>
    </form>

    </body>
</html>
