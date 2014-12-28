<?php

//$a = 0;
//$b = "0";
//$c = true;

// Индексньіе массивьі
//$d = [10, 11, 12, 13, 14, 15, 16, 17];
//$e = ['Иван', '123456', '1983'];
//$f = [1, 'werdfgdfg', true];
// echo $d[2];
// echo $e[1];

//$g = [
//    'login' => 'Иван',
//    'password' => '123456',
//    'age' => '1983'
//];
//
//echo $g['login'];


$login = $_GET['login'];
$password = $_GET['password'];

$found = false;

$users = [
    [
        'login' => 'Иваныч',
        'password' => '123456',
        'info' => 'Иваныч В.Г.    87 года рождения. проживает в Киеве'
    ],

    [
        'login' => 'Анна',
        'password' => 'qweqwe',
        'info' => 'Аня - Ня.  84-ого года рождения. проживает в Харькове'
    ],

    [
        'login' => 'Андрей',
        'password' => 'asdasd',
        'info' => 'Андрей. проживает в Харькове'
    ]
];



if ($login == $users[0]['login'] && $password == $users[0]['password']) {
    $found = true;
    echo $users[0]['info'];
}

if ($login == $users[1]['login'] && $password == $users[1]['password']) {
    $found = true;
    echo $users[1]['info'];
}

if ($login == $users[2]['login'] && $password == $users[2]['password']) {
    $found = true;
    echo $users[2]['info'];
}



if ($found == false) {
    echo 'Неправильньій логин или пароль';
}


//$c["Joker"] = 'Джокер Инкогнито.  Родился давно. Проживает везде';
//$d["Mama"] = 'Добрянская Ирина Алексеевна. 60-ого года рождения. Проживает в Мелитополе';
//$e["Roma"] = 'Брателло. 85-ого года рождения. Проживает по ходу в самолете';

?>

<?php if ($found == false) { ?>
<html>
<head>
    <meta charset="utf-8">
    <title>Авторизация</title>
</head>
<body>
<form action = "test.php" method = "get">
    <p><input name = "login" value = "<?php echo $login; ?>"></p>
    <p><input name = "password" value = "<?php echo $password; ?>"></p>
    <p><input type = "submit" value = "войти"></p>
</form>
</body>
</html>
<?php } ?>






























