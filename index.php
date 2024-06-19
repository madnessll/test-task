<?php
// Подключение к базе данных и файлу с классом Account
include_once 'db.php';
include_once 'Account.php';

// Создание объекта базы данных и подключение
$database = new Database();
$db = $database->getConnection();

// Создание объекта Account
$account = new Account($db);

// Установка количества записей на страницу
$records_per_page = 10;

// Получение текущей страницы из параметра URL, если он есть, иначе установка 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Вычисление LIMIT для запроса
$from_record_num = ($records_per_page * $page) - $records_per_page;

// Получение всех записей с пагинацией
$stmt = $account->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Management</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
          margin-top: 20px;
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .right {
          background: black;
          padding: 5px;
          border-radius: 15px;
          color: white;
          text-decoration: none;
        }
        .create {
          background: black;
          padding: 15px;
          border-radius: 15px;
          color: white;
          text-decoration: none;
        }
        .create-wrapper {
          display: flex;
          justify-content: center;
        }
        h1 {
          text-align: center;
        }
    </style>
</head>
<body>
    <h1>Управление аккаунтами</h1>
    <div class="create-wrapper">
      <a class="create" href="create.php">Создать новый аккаунт</a>
    </div>

    <?php if ($num > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Company name</th>
                <th>Position</th>
                <th>Phone 1</th>
                <th>Phone 2</th>
                <th>Phone 3</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['position']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone1']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone2']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone3']); ?></td>
                    <td>
                        <a class="right" href="update.php?id=<?php echo $row['id']; ?>">Редактировать</a> |
                        <a class="right" href="delete.php?id=<?php echo $row['id']; ?>">Удалить</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <?php
        // Пагинация
        $total_rows = $account->countAll();
        $page_url = "index.php?";
        include_once 'pagination.php';
        ?>

    <?php else: ?>
        <div>Нет записей.</div>
    <?php endif; ?>
</body>
</html>
