<?php
if ($_POST) {
    include_once 'db.php';
    include_once 'Account.php';

    $database = new Database();
    $db = $database->getConnection();

    $account = new Account($db);

    // Получение данных из формы
    $account->first_name = $_POST['first_name'];
    $account->last_name = $_POST['last_name'];
    $account->email = $_POST['email'];
    $account->company_name = $_POST['company_name'];
    $account->position = $_POST['position'];
    $account->phone1 = $_POST['phone1'];
    $account->phone2 = $_POST['phone2'];
    $account->phone3 = $_POST['phone3'];

    // Проверка, существует ли email
    if ($account->emailExists()) {
        $message = "<div class='error'>Пользователь с такой почтой уже существует, введите другую почту.</div>";
    } else {
        // Создание новой записи
        if ($account->create()) {
            $message = "<div class='success'>Запись успешно создана.</div>";
        } else {
            $message = "<div class='error'>Не удалось создать запись.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Management</title>
    <style>
        body {
            padding-left: 20px;
        }
        form {
            margin-bottom: 50px;
        }
        a, .create {
            background: black;
            padding: 10px;
            border-radius: 15px;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <?php if (isset($message)) echo $message; ?>
    <form action="create.php" method="post">
        <label for="first_name">Имя:</label><br>
        <input type="text" name="first_name" required><br>
        <label for="last_name">Фамилия:</label><br>
        <input type="text" name="last_name" required><br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br>
        <label for="company_name">Компания:</label><br>
        <input type="text" name="company_name"><br>
        <label for="position">Должность:</label><br>
        <input type="text" name="position"><br>
        <label for="phone1">Телефон 1:</label><br>
        <input type="text" name="phone1"><br>
        <label for="phone2">Телефон 2:</label><br>
        <input type="text" name="phone2"><br>
        <label for="phone3">Телефон 3:</label><br>
        <input type="text" name="phone3"><br><br>
        <input class="create" type="submit" value="Создать">
    </form>
    <a href="index.php">Вернуться на главную страницу</a>
</body>
</html>
