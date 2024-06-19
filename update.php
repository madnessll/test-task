<?php
if ($_POST) {
    // Подключение к базе данных и классу Account
    include_once 'db.php';
    include_once 'Account.php';

    $database = new Database();
    $db = $database->getConnection();

    $account = new Account($db);
    $account->id = $_POST['id'];
    $account->first_name = $_POST['first_name'];
    $account->last_name = $_POST['last_name'];
    $account->email = $_POST['email'];
    $account->company_name = $_POST['company_name'];
    $account->position = $_POST['position'];
    $account->phone1 = $_POST['phone1'];
    $account->phone2 = $_POST['phone2'];
    $account->phone3 = $_POST['phone3'];

    if ($account->update()) {
        echo "<div class='new'>Запись успешно обновлена.</div>";
    } else {
        echo "<div class='new'>Не удалось обновить запись.</div>";
    }
} else {
    include_once 'db.php';
    include_once 'Account.php';

    $database = new Database();
    $db = $database->getConnection();

    $account = new Account($db);
    $account->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Запись не найдена.');

    $account->readOne();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Management</title>
    <style>
        body {
            padding-left:20px;
        }
        form {
          margin-bottom: 50px;
        }
        a, .update {
          background: black;
          padding: 10px;
          border-radius: 15px;
          color: white;
          text-decoration: none;
          cursor: pointer;
        }
        .new {
          margin-bottom: 20px;
          margin-top: 20px;
        }
    </style>
</head>
<body>
<form action="update.php" method="post">
    <input type="hidden" name="id" value="<?php echo $account->id; ?>">
    <label for="first_name">Имя:</label><br>
    <input type="text" name="first_name" value="<?php echo $account->first_name; ?>" required><br>
    <label for="last_name">Фамилия:</label><br>
    <input type="text" name="last_name" value="<?php echo $account->last_name; ?>" required><br>
    <label for="email">Email:</label><br>
    <input type="email" name="email" value="<?php echo $account->email; ?>" required><br>
    <label for="company_name">Компания:</label><br>
    <input type="text" name="company_name" value="<?php echo $account->company_name; ?>"><br>
    <label for="position">Должность:</label><br>
    <input type="text" name="position" value="<?php echo $account->position; ?>"><br>
    <label for="phone1">Телефон 1:</label><br>
    <input type="text" name="phone1" value="<?php echo $account->phone1; ?>"><br>
    <label for="phone2">Телефон 2:</label><br>
    <input type="text" name="phone2" value="<?php echo $account->phone2; ?>"><br>
    <label for="phone3">Телефон 3:</label><br>
    <input type="text" name="phone3" value="<?php echo $account->phone3; ?>"><br><br>
    <input class="update" type="submit" value="Обновить">
</form>
<a href="index.php">Вернуться на главную страницу</a>
</body>
</html>