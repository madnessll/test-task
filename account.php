<?php
class Account {
    private $conn;
    private $table_name = "accounts";

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $company_name;
    public $position;
    public $phone1;
    public $phone2;
    public $phone3;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Создание нового аккаунта
    public function create() {
        // Проверка, существует ли уже email
        if ($this->emailExists()) {
            return false;
        }

        // SQL запрос для вставки данных
        $query = "INSERT INTO " . $this->table_name . " SET
            first_name=:first_name, last_name=:last_name, email=:email, 
            company_name=:company_name, position=:position,
            phone1=:phone1, phone2=:phone2, phone3=:phone3";

        $stmt = $this->conn->prepare($query);

        // Очистка данных
        $this->sanitize();

        // Привязка данных
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":company_name", $this->company_name);
        $stmt->bindParam(":position", $this->position);
        $stmt->bindParam(":phone1", $this->phone1);
        $stmt->bindParam(":phone2", $this->phone2);
        $stmt->bindParam(":phone3", $this->phone3);

        // Выполнение запроса
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Проверка существования email в базе данных
    public function emailExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);

        // Привязка email
        $stmt->bindParam(1, $this->email);
        $stmt->execute();

        // Проверка, если email существует
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    private function sanitize() {
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->company_name = htmlspecialchars(strip_tags($this->company_name));
        $this->position = htmlspecialchars(strip_tags($this->position));
        $this->phone1 = htmlspecialchars(strip_tags($this->phone1));
        $this->phone2 = htmlspecialchars(strip_tags($this->phone2));
        $this->phone3 = htmlspecialchars(strip_tags($this->phone3));
    }

    // Обновление существующего аккаунта
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET
            first_name = :first_name,
            last_name = :last_name,
            email = :email,
            company_name = :company_name,
            position = :position,
            phone1 = :phone1,
            phone2 = :phone2,
            phone3 = :phone3
            WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->sanitize();

        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":company_name", $this->company_name);
        $stmt->bindParam(":position", $this->position);
        $stmt->bindParam(":phone1", $this->phone1);
        $stmt->bindParam(":phone2", $this->phone2);
        $stmt->bindParam(":phone3", $this->phone3);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Чтение одной записи по ID
    public function readOne() {
        $query = "SELECT id, first_name, last_name, email, company_name, position, phone1, phone2, phone3
                  FROM " . $this->table_name . "
                  WHERE id = ?
                  LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Установка значений свойств объекта
        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->email = $row['email'];
        $this->company_name = $row['company_name'];
        $this->position = $row['position'];
        $this->phone1 = $row['phone1'];
        $this->phone2 = $row['phone2'];
        $this->phone3 = $row['phone3'];
    }

    // Удаление аккаунта по ID
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        // Привязка ID записи
        $stmt->bindParam(1, $this->id);

        // Выполнение запроса
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Чтение всех записей с пагинацией
    public function readAll($from_record_num, $records_per_page) {
        $query = "SELECT id, first_name, last_name, email, company_name, position, phone1, phone2, phone3
                  FROM " . $this->table_name . "
                  ORDER BY last_name ASC
                  LIMIT ?, ?";

        $stmt = $this->conn->prepare($query);

        // Привязка значений для пагинации
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    // Подсчет общего количества записей
    public function countAll() {
        $query = "SELECT id FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
?>
