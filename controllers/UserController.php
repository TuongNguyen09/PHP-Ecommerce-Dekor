<?php
require_once '../models/UserModel.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function showTopSpendingUsers()
    {
        try {
            // Lấy dữ liệu từ form lọc ngày (nếu có)
            $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : null;
            $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : null;
            $limit = isset($_POST['limit']) ? $_POST['limit'] : 5;  // Mặc định là 5 khách hàng chi tiêu nhiều nhất

            // Kiểm tra và validate dữ liệu nhập
            if (!is_numeric($limit) || $limit <= 0) {
                throw new Exception("Limit phải là một số dương");
            }

            // Tạo đối tượng model (giả sử bạn đã có mô hình User)
            $userModel = new UserModel();

            // Lấy danh sách khách hàng top spending
            $topSpendingUsers = $userModel->getTopSpendingUsers($limit, $fromDate, $toDate);

            // Kiểm tra nếu không có khách hàng nào
            if (empty($topSpendingUsers)) {
                throw new Exception("Không có khách hàng nào trong khoảng thời gian này.");
            }

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'data' => $topSpendingUsers
            ]);
        } catch (Exception $e) {
            // Xử lý lỗi, trả về thông báo lỗi dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');

            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['SDT'] ?? '',
                'fullname' => $_POST['name'] ?? '',
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
                // Kiểm tra xem tài khoản có bị khóa không
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


    public function loginAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                echo 'Tài khoản hoặc mật khẩu không đúng'; // Trả về thông báo lỗi dưới dạng văn bản thuần
                exit();
            }

            $user = $this->userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                if ($user['role'] !== 'admin') {
                    echo 'Bạn không có quyền truy cập';
                    exit();
                }

                if (!empty($user['is_banned']) && $user['is_banned'] == 1) {
                    echo 'Tài khoản đã bị khóa';
                    exit();
                }

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['adminId'] = $user['id'];
                $_SESSION['adminUsername'] = $user['username'];
                $_SESSION['adminRole'] = $user['role'];

                echo 'Đăng nhập admin thành công'; // Trả về thông báo thành công
            } else {
                echo 'Tài khoản hoặc mật khẩu không đúng'; // Trả về thông báo lỗi khi tài khoản hoặc mật khẩu không đúng
            }
            exit();
        }
    }

    public function addAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');

            // Nhận dữ liệu JSON từ body request
            $inputData = json_decode(file_get_contents("php://input"), true);

            // Kiểm tra nếu dữ liệu hợp lệ
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
                exit();
            }

            $data = [
                'username' => $inputData['username'] ?? '',
                'email' => $inputData['email'] ?? '',
                'phone' => $inputData['phone'] ?? '',
                'fullname' => $inputData['name'] ?? '',  // Điều chỉnh tên trường nếu cần
                'password' => $inputData['password'] ?? '',
                'birthday' => $inputData['birthday'] ?? '',
                'gender' => $inputData['gender'] ?? '',
                'role' => 'admin',
                'is_banned' => 0,
                'is_signIn' => 0
            ];

            $errors = [];

            // Kiểm tra dữ liệu
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
                    echo json_encode(['status' => 'success', 'message' => 'Tạo admin thành công']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Email đã tồn tại hoặc lỗi hệ thống.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => implode(', ', $errors)]);
            }
            exit();
        }
    }


    public function updateAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            try {
                if (!isset($_SESSION['adminId'])) {
                    throw new Exception('Chưa đăng nhập');
                }

                $id = $_SESSION['adminId'];
                $input = json_decode(file_get_contents('php://input'), true);

                if (!is_array($input)) {
                    throw new Exception('Dữ liệu JSON không hợp lệ');
                }

                $username = $input['username'] ?? null;
                $email = $input['email'] ?? null;
                $phone = $input['phone'] ?? null;
                $fullname = $input['name'] ?? null;
                $password = $input['password'] ?? null;

                if (!$username) {
                    throw new Exception('Tên tài khoản không được để trống');
                }

                $data = [
                    'username' => $username,
                    'email' => $email,
                    'phone' => $phone,
                    'fullname' => $fullname,
                    'role' => 'admin'
                ];

                if (!empty($password)) {
                    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                $result = $this->userModel->updateUser($id, $data);
                if (!$result) {
                    throw new Exception('Cập nhật thất bại (updateUser trả về false)');
                }

                echo json_encode(['status' => 'success', 'message' => 'Cập nhật admin thành công']);
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                    // 'trace' => $e->getTraceAsString() // chỉ bật khi debug
                ]);
            }

            exit();
        }
    }

    public function logoutAdmin()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();  // Khởi tạo session nếu chưa có
        }

        // Xóa các session liên quan đến admin
        unset($_SESSION['adminId']);
        unset($_SESSION['adminUsername']);
        unset($_SESSION['adminRole']);

        // Hủy session
        session_destroy();

        // Chuyển hướng về trang đăng nhập admin hoặc trang khác
        header("Location: ../admin/SignInAdmin.php");
        exit();
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

    public function getUser($id)
    {
        $user = $this->userModel->getUserById($id);
        header('Content-Type: application/json');

        if ($user) {
            echo json_encode([
                'status' => 'success',
                'user' => $user
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Không tìm thấy người dùng'
            ]);
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

    public function banUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_GET['id'] ?? null;

            if (!$userId) {
                echo json_encode(['status' => 'error', 'message' => 'Thiếu ID người dùng']);
                return;
            }

            $result = $this->userModel->banUserById($userId);

            echo json_encode([
                'status' => $result ? 'success' : 'error',
                'message' => $result ? 'Khóa tài khoản thành công' : 'Không thể khóa tài khoản'
            ]);
        }
    }

    public function unbanUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_GET['id'] ?? null;

            if (!$userId) {
                echo json_encode(['status' => 'error', 'message' => 'Thiếu ID người dùng']);
                return;
            }

            $result = $this->userModel->unbanUserById($userId);

            echo json_encode([
                'status' => $result ? 'success' : 'error',
                'message' => $result ? 'Mở khóa tài khoản thành công' : 'Không thể mở khóa tài khoản'
            ]);
        }
    }

    public function getAdminInfo()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['adminId'])) {
            $adminId = $_SESSION['adminId'];
            $admin = $this->userModel->getUserById($adminId); // Bạn cần có hàm này trong UserModel

            if ($admin) {
                echo json_encode(['status' => 'success', 'data' => $admin]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy admin']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
        }
        exit();
    }
}


if (isset($_GET['action'])) {
    $controller = new UserController();
    $action = $_GET['action'];
    switch ($action) {
        case 'register':
            $controller->register();
            break;
        case 'login':
            $controller->login();
            break;
        case 'loginAdmin':
            $controller->loginAdmin();
            break;
        case 'addAdmin':
            $controller->addAdmin();
            break;
        case 'updateAdmin':
            $controller->updateAdmin();
            break;
        case 'listUsers':
            $controller->listUsers();
            break;
        case 'get':
            $id = $_GET['id'] ?? 0;
            $controller->getUser($id);
            break;
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
            $controller->createUser();
            break;
        case 'logout':
            $controller->logout();
            break;
        case 'logoutAdmin':
            $controller->logoutAdmin();
            break;
        case 'banUser':
            $id = $_GET['id'] ?? 0;
            $controller->banUser($id);
            break;
        case 'unbanUser':
            $id = $_GET['id'] ?? 0;
            $controller->unbanUser($id);
            break;
        case 'getAdminInfo':
            $controller->getAdminInfo();
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ']);
            break;
    }
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
    $controller = new UserController();

    switch ($action) {
        case 'topSpendingUsers':
            $controller->showTopSpendingUsers();
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
}
