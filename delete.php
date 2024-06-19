<?php
if (isset($_GET['id'])) {
    include_once 'db.php';
    include_once 'Account.php';

    $database = new Database();
    $db = $database->getConnection();

    $account = new Account($db);
    $account->id = $_GET['id'];

    // Удаление записи
    if ($account->delete()) {
        $message = "<div class='message success'>Запись успешно удалена.</div>";
    } else {
        $message = "<div class='message error'>Не удалось удалить запись.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Account</title>
    <style>
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .back-link {
          margin-left: 10px;
          background: black;
          padding: 10px;
          border-radius: 15px;
          color: white;
          text-decoration: none;
          cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>
    <a href="index.php" class="back-link">Вернуться на главную страницу</a>
</body>
</html>
