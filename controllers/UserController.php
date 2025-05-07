<?php
require_once '../models/UserModel.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');

            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['SDT'] ?? '',
                'full_name' => $_POST['name'] ?? '',
                'password' => $_POST['password'] ?? ''
            ];

            $errors = [];
            if (empty($data['username']) || strlen($data['username']) < 3 || strlen($data['username']) > 20) {
                $errors[] = 'Tên tài khoản phải từ 3 đến 20 ký tự';
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            }
            if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
                $errors[] = 'Số điện thoại phải là 10 số';
            }
            if (empty($data['fullname']) || strlen($data['fullname']) < 2 || strlen($data['fullname']) > 50) {
                $errors[] = 'Họ tên phải từ 2 đến 50 ký tự';
            }
            if (strlen($data['password']) < 6) {
                $errors[] = 'Mật khẩu phải ít nhất 6 ký tự';
            }

            if (empty($errors)) {
                if ($this->userModel->createUser($data)) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Email đã tồn tại hoặc lỗi hệ thống.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => implode(', ', $errors)]);
            }
            exit();
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username1'] ?? '';
            $password = $_POST['password1'] ?? '';

            if (empty($username) || empty($password)) {
                echo json_encode(['status' => 'error', 'message' => 'Tài khoản hoặc mật khẩu không đúng']);
                exit();
            }

            $user = $this->userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                if (!empty($user['is_banned']) && $user['is_banned'] == 1) {
                    echo json_encode(['status' => 'error', 'message' => 'Tài khoản của bạn đã bị khóa']);
                    exit();
                }

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['userId'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                echo json_encode(['status' => 'success', 'message' => 'Đăng nhập thành công']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Tài khoản hoặc mật khẩu không đúng']);
            }
            exit();
        }
    }

    public function listUsers()
    {
        $users = $this->userModel->getAllUsers(); // hoặc từ DB
        $perPage = 10; // số lượng users mỗi trang
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $totalItems = count($users);
        $totalPages = ceil($totalItems / $perPage);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedUsers = array_slice($users, $offset, $perPage);

        header('Content-Type: application/json');
        echo json_encode([
            'users' => array_values($paginatedUsers),
            'totalPages' => $totalPages,
            'currentPage' => $currentPage
        ]);
    }


    public function logout()
    {
        session_start();
        session_destroy();
        echo json_encode(['status' => 'success', 'message' => 'Đăng xuất thành công']);
        exit();
    }

    public function getMyInfo()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();  // Khởi động session nếu chưa được khởi động
        }
        $userId = $_SESSION['userId'] ?? null;
        if (!$userId) {
            echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
            return;
        }
        $user = $this->userModel->getUserById($userId);
        if ($user) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'user' => $user]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy người dùng']);
        }
    }

    public function createUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');

            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'fullname' => $_POST['fullname'] ?? '',
                'password' => $_POST['password'] ?? '',
                'birthday' => $_POST['birthday'] ?? '', // Ngày sinh
                'gender' => $_POST['gender'] ?? '', // Giới tính
                'role' => 'user', // Mặc định là 'user'
                'is_banned' => 0, // Mặc định là chưa bị cấm
                'is_signIn' => 0 // Mặc định là chưa đăng nhập
            ];

            $errors = [];

            // Validate các trường dữ liệu
            if (empty($data['username']) || strlen($data['username']) < 3 || strlen($data['username']) > 20) {
                $errors[] = 'Tên tài khoản phải từ 3 đến 20 ký tự';
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            }
            if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
                $errors[] = 'Số điện thoại phải là 10 số';
            }
            if (empty($data['fullname']) || strlen($data['fullname']) < 2 || strlen($data['fullname']) > 50) {
                $errors[] = 'Họ tên phải từ 2 đến 50 ký tự';
            }
            if (strlen($data['password']) < 6) {
                $errors[] = 'Mật khẩu phải ít nhất 6 ký tự';
            }

            if (empty($errors)) {
                // Nếu không có lỗi, thực hiện tạo người dùng
                if ($this->userModel->createUser($data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Tạo người dùng thành công']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Email đã tồn tại hoặc lỗi hệ thống.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => implode(', ', $errors)]);
            }
            exit();
        }
    }

    public function getUserById($id)
    {
        $user = $this->userModel->getUserById($id);
        if ($user) {
            header('Content-Type: application/json');
            echo json_encode($user);
        } else {
            echo json_encode(null);
        }
    }


    public function updateUser($id)
    {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $fullname = $_POST['fullname'] ?? '';
        $birthday = $_POST['birthday'] ?? '';
        $gender = $_POST['gender'] ?? '';

        if (empty($username)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Tên tài khoản không được để trống'
            ]);
            return;
        }

        $data = [
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'fullname' => $fullname,
            'birthday' => $birthday,
            'gender' => $gender,
        ];

        $result = $this->userModel->updateUser($id, $data);

        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Cập nhật người dùng thành công' : 'Cập nhật người dùng thất bại. Vui lòng thử lại.'
        ]);
    }



    public function deleteUser($id)
    {
        $result = $this->userModel->deleteUser($id);

        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Xóa người dùng thành công' : 'Xóa người dùng thất bại.'
        ]);
    }
}

$controller = new UserController();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'register':
        $controller->register();
        break;
    case 'login':
        $controller->login();
        break;
    case 'listUsers':
        $controller->listUsers();
        break;
    case 'logout':
        $controller->logout();
        break;
    // case 'get':
    //     $id = $_GET['id'] ?? 0;
    //     $controller->getUser($id);
    //     break;
    case 'getMyInfo':
        $controller->getMyInfo();
        break;
    case 'getUserById':
        $id = $_GET['id'] ?? 0;
        $controller->getUserById($id);
        break;
    case 'update':
        $id = $_GET['id'] ?? 0;
        $controller->updateUser($id);
        break;
    case 'delete':
        $id = $_GET['id'] ?? 0;
        $controller->deleteUser($id);
        break;
    case 'create':
        $controller->createUser(); // Thêm hành động create
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ']);
}
