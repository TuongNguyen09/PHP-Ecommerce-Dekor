<?php
require_once '../config/db.php';

class UserModel
{
    private $conn;
    private $table = 'user';

    // Constructor tự khởi tạo kết nối
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả người dùng
    public function getAllUsers()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy người dùng theo ID
    public function getUserById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy người dùng theo tên tài khoản (username)
    public function getUserByUsername($username)
    {
        $query = "SELECT id, username, email, password, is_banned FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Thêm người dùng mới
    public function createUser($data)
    {
        $query = "INSERT INTO " . $this->table . " 
                    (username, email, phone, fullname, password, date_of_birth, gender, role, is_banned, is_signIn, created_at) 
                  VALUES 
                    (:username, :email, :phone, :fullname, :password, :date_of_birth, :gender, :role, :is_banned, :is_signIn, :created_at)";

        $stmt = $this->conn->prepare($query);

        // Cập nhật lại các biến theo đúng dữ liệu từ controller
        $username = htmlspecialchars(strip_tags($data['username']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $phone = htmlspecialchars(strip_tags($data['phone']));
        $fullname = htmlspecialchars(strip_tags($data['fullname']));
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        $date_of_birth = $data['birthday'] ?? null; // Nếu có ngày sinh
        $gender = $data['gender'] ?? 'other'; // Mặc định là 'other'
        $role = 'user'; // Mặc định là 'user'
        $is_banned = 0; // Mặc định là chưa bị cấm
        $is_signIn = 0; // Mặc định là chưa đăng nhập
        $created_at = date('Y-m-d H:i:s');

        // Gắn tham số vào câu lệnh SQL
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':is_banned', $is_banned);
        $stmt->bindParam(':is_signIn', $is_signIn);
        $stmt->bindParam(':created_at', $created_at);

        // Thực hiện câu lệnh SQL
        return $stmt->execute();
    }

    // Lấy fullname theo ID người dùng
    public function getFullNameById($id)
    {
        $query = "SELECT fullname FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['fullname'] : null;
    }


    // Cập nhật người dùng
    public function updateUser($id, $data)
    {
        $query = "UPDATE " . $this->table . " 
                  SET username = :username,
                      email = :email,
                      phone = :phone,
                      fullname = :fullname,
                      date_of_birth = :birthday,
                      gender = :gender
                  WHERE id = :id"; // Đã loại bỏ dấu phẩy thừa ở đây

        $stmt = $this->conn->prepare($query);

        $username = htmlspecialchars(strip_tags($data['username']));
        $email = htmlspecialchars(strip_tags($data['email']));
        $phone = htmlspecialchars(strip_tags($data['phone']));
        $fullname = htmlspecialchars(strip_tags($data['fullname']));
        $birthday = htmlspecialchars(strip_tags($data['birthday']));
        $gender = htmlspecialchars(strip_tags($data['gender']));

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':birthday', $birthday);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }



    // Xóa người dùng
    public function deleteUser($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Đăng nhập
    public function login($email, $password)
    {
        $query = "SELECT id, username, email, password FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
