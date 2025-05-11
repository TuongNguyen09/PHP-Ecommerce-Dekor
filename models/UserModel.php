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

    public function getTopSpendingUsers($limit = 10, $fromDate = null, $toDate = null)
    {
        $query = "SELECT u.id, u.fullname, u.email, u.phone,
                     SUM(p.price * oi.quantity) AS total_revenue
              FROM user u
              JOIN orders o ON u.id = o.user_id
              JOIN order_item oi ON o.id = oi.order_id
              JOIN product p ON oi.product_id = p.id
              WHERE o.status = 'Đã giao thành công'";

        if (!empty($fromDate)) {
            $query .= " AND o.order_date >= :fromDate";
        }

        if (!empty($toDate)) {
            $query .= " AND o.order_date <= :toDate";
        }

        $query .= " GROUP BY u.id
                ORDER BY total_revenue DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($query);

        if (!empty($fromDate)) {
            $stmt->bindParam(':fromDate', $fromDate);
        }

        if (!empty($toDate)) {
            $stmt->bindParam(':toDate', $toDate);
        }

        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

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
        $query = "SELECT id, role, username, email, password, is_banned FROM " . $this->table . " WHERE username = :username";
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

        // Kiểm tra xem có 'role' trong $data hay không, nếu không có thì gán là 'user'
        $role = isset($data['role']) ? $data['role'] : 'user'; // Nếu có thì lấy giá trị từ $data['role'], nếu không có thì gán 'user'

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
        $setClauses = [];
        $params = [
            ':id' => $id
        ];

        // Kiểm tra và thêm các trường vào câu lệnh SQL nếu chúng tồn tại trong dữ liệu
        if (!empty($data['username'])) {
            $setClauses[] = "username = :username";
            $params[':username'] = htmlspecialchars(strip_tags($data['username']));
        }
        if (!empty($data['email'])) {
            $setClauses[] = "email = :email";
            $params[':email'] = htmlspecialchars(strip_tags($data['email']));
        }
        if (!empty($data['phone'])) {
            $setClauses[] = "phone = :phone";
            $params[':phone'] = htmlspecialchars(strip_tags($data['phone']));
        }
        if (!empty($data['fullname'])) {
            $setClauses[] = "fullname = :fullname";
            $params[':fullname'] = htmlspecialchars(strip_tags($data['fullname']));
        }
        if (!empty($data['birthday'])) {
            $setClauses[] = "date_of_birth = :birthday";
            $params[':birthday'] = htmlspecialchars(strip_tags($data['birthday']));
        }
        if (!empty($data['gender'])) {
            $setClauses[] = "gender = :gender";
            $params[':gender'] = htmlspecialchars(strip_tags($data['gender']));
        }

        // Nếu không có trường nào cần cập nhật, return false
        if (empty($setClauses)) {
            return false;
        }

        // Tạo câu lệnh SQL động với các trường cần cập nhật
        $query = "UPDATE " . $this->table . " 
                  SET " . implode(', ', $setClauses) . " 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Gắn các tham số vào câu lệnh SQL
        foreach ($params as $param => $value) {
            $stmt->bindParam($param, $value);
        }

        return $stmt->execute();
    }


    public function banUserById($id)
    {
        $query = "UPDATE {$this->table} SET is_banned = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function unbanUserById($id)
    {
        $query = "UPDATE {$this->table} SET is_banned = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
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
