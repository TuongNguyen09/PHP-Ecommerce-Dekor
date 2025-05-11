<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['adminId'])) {
    echo "<script>
        alert('Vui lòng đăng nhập với quyền admin');
        window.location.href = 'signinadmin.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.2.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font_Roboto/Roboto-Bold.ttf">
    <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <script src="../../js/jquery.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/style.js"></script>
    <link rel="stylesheet" href="../assets/css/cart.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <title>Admin</title>
</head>
<style>
    /* Cả 2 nút khi chưa click */
    .btn-toggle {
        background: none;
        border: none;
        color: #000;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        position: relative;
        transition: color 0.3s ease;
    }

    /* Đường line dưới nút */
    .btn-toggle::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: transparent;
        transition: background-color 0.3s ease;
    }

    /* Khi nút được click và có màu đỏ */
    .btn-toggle.active {
        color: red;
    }

    .btn-toggle.active::after {
        background-color: red;
    }
</style>

<body>
    <?php
    include './Header.php';
    ?>

    <div class="content">
        <div class="row">
            <div class="title col-12 box_shadow">
                <ul class="line_up">
                    <li>Tài khoản quản trị viên</li>
                </ul>
            </div>
        </div>
        <div class="row main_frame box_card box_shadow">
            <div style="padding: 0;">
                <div>
                    <button id="updateAdminBtn" class="btn btn-toggle" onclick="switchToUpdateForm()">Cập nhật Admin</button>
                    <button id="addAdminBtn" class="btn btn-toggle" onclick="switchToAddForm()">Thêm Admin</button>
                </div>
            </div>
            <div class="form_add">
                <!-- Form Add Admin -->
                <div id="addAdminForm" style="display: none;">
                    <div class="form_group col-12 col-sm-6 col-lg-6" style="display: flex; flex-direction: column;">
                        <label for="usernameAdmin" style="width: 30%;">Tên đăng nhập</label>
                        <input style="width: 50%;" type="text" class="form-control" id="usernameAdmin" />
                        <small class="error-message" style="height:20px; color: red; display: block;"></small>
                    </div>

                    <div class="form_group col-12 col-sm-6 col-lg-6" style="display: flex; flex-direction: column;">
                        <label for="nameAdmin" style="width: 30%;">Họ tên</label>
                        <input style="width: 50%;" type="text" class="form-control" id="nameAdmin" />
                        <small class="error-message" style="height:20px; color: red; display: block;"></small>
                    </div>

                    <div class="form_group col-12 col-sm-6 col-lg-6" style="display: flex; flex-direction: column;">
                        <label for="emailAdmin" style="width: 30%;">Email</label>
                        <input style="width: 50%;" type="email" class="form-control" id="emailAdmin" />
                        <small class="error-message" style="height:20px; color: red; display: block;"></small>
                    </div>

                    <div class="form_group col-12 col-sm-6 col-lg-6" style="display: flex; flex-direction: column;">
                        <label for="phoneAdmin" style="width: 30%;">Số điện thoại</label>
                        <input style="width: 50%;" type="text" class="form-control" id="phoneAdmin" />
                        <small class="error-message" style="height:20px; color: red; display: block;"></small>
                    </div>

                    <div class="form_group col-12 col-sm-6 col-lg-6" style="display: flex; flex-direction: column;">
                        <label for="passwordAdmin" style="width: 30%;">Mật khẩu</label>
                        <input style="width: 50%;" type="password" class="form-control" id="passwordAdmin" />
                        <small class="error-message" style="height:20px; color: red; display: block;"></small>
                    </div>

                    <div class="element_btn">
                        <div class="add_product">
                            <a delay="10000" type="button" class="addnew_btn" onclick="addAdmin()">Lưu</a>
                        </div>
                    </div>
                </div>

                <!-- Form Update Admin -->
                <div id="updateAdminForm" style="display: block;">
                    <div class="form_group col-12 col-sm-6 col-lg-6" style="display: flex; flex-direction: column;">
                        <label for="usernameAdmin" style="width: 30%;">Tên đăng nhập</label>
                        <input style="width: 50%;" type="text" class="form-control" id="usernameAdminUpdate" />
                        <small class="error-message" style="height:20px; color: red; display: block;"></small>
                    </div>

                    <div class="form_group col-12 col-sm-6 col-lg-6" style="display: flex; flex-direction: column;">
                        <label for="nameAdmin" style="width: 30%;">Họ tên</label>
                        <input style="width: 50%;" type="text" class="form-control" id="nameAdminUpdate" />
                        <small class="error-message" style="height:20px; color: red; display: block;"></small>
                    </div>

                    <div class="form_group col-12 col-sm-6 col-lg-6" style="display: flex; flex-direction: column;">
                        <label for="emailAdmin" style="width: 30%;">Email</label>
                        <input style="width: 50%;" type="email" class="form-control" id="emailAdminUpdate" />
                        <small class="error-message" style="height:20px; color: red; display: block;"></small>
                    </div>

                    <div class="form_group col-12 col-sm-6 col-lg-6" style="display: flex; flex-direction: column;">
                        <label for="phoneAdmin" style="width: 30%;">Số điện thoại</label>
                        <input style="width: 50%;" type="text" class="form-control" id="phoneAdminUpdate" />
                        <small class="error-message" style="height:20px; color: red; display: block;"></small>
                    </div>

                    <div class="form_group col-12 col-sm-6 col-lg-6" style="display: none; flex-direction: column;">
                        <label for="passwordAdmin" style="width: 30%;">Mật khẩu</label>
                        <input style="width: 50%;" type="password" class="form-control" id="passwordAdminUpdate" />
                        <small class="error-message" style="height:20px; color: red; display: block;"></small>
                    </div>

                    <div class="element_btn">
                        <div class="add_product">
                            <a delay="10000" type="button" class="addnew_btn" onclick="updateAdmin()">Cập nhật</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <script>
        function checkValidateAdminForm(isUpdate = false) {
            const prefix = isUpdate ? 'Update' : '';
            let isValid = true;

            const username = document.getElementById(`usernameAdmin${prefix}`);
            const name = document.getElementById(`nameAdmin${prefix}`);
            const email = document.getElementById(`emailAdmin${prefix}`);
            const phone = document.getElementById(`phoneAdmin${prefix}`);
            const password = document.getElementById(`passwordAdmin${prefix}`);

            const fields = [username, name, email, phone, password];
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phoneRegex = /^0\d{9}$/;

            fields.forEach(field => {
                const error = field.nextElementSibling;
                error.textContent = '';

                if (field.value.trim() === '') {
                    error.textContent = 'Trường này không được để trống';
                    isValid = false;
                }
            });

            if (email.value && !emailRegex.test(email.value)) {
                email.nextElementSibling.textContent = 'Email không hợp lệ';
                isValid = false;
            }

            if (phone.value && !phoneRegex.test(phone.value)) {
                phone.nextElementSibling.textContent = 'Số điện thoại không hợp lệ (bắt đầu bằng 0, 10 chữ số)';
                isValid = false;
            }

            if (!isUpdate && password.value.length < 6) {
                password.nextElementSibling.textContent = 'Mật khẩu phải có ít nhất 6 ký tự';
                isValid = false;
            }

            return isValid;
        }

        function switchToAddForm() {
            // Kiểm tra trạng thái form Add
            document.getElementById('addAdminForm').style.display = 'block';
            document.getElementById('updateAdminForm').style.display = 'none';

            // Tô màu cho nút Add và trở về trạng thái bình thường cho nút Update
            document.getElementById('addAdminBtn').classList.add('active');
            document.getElementById('updateAdminBtn').classList.remove('active');
        }

        function switchToUpdateForm() {
            // Kiểm tra trạng thái form Update
            document.getElementById('addAdminForm').style.display = 'none';
            document.getElementById('updateAdminForm').style.display = 'block';

            // Tô màu cho nút Update và trở về trạng thái bình thường cho nút Add
            document.getElementById('updateAdminBtn').classList.add('active');
            document.getElementById('addAdminBtn').classList.remove('active');
        }

        // Hàm gọi khi trang được tải
        window.onload = function() {
            // Kiểm tra xem form Update hay Add đang hiển thị khi trang tải
            if (document.getElementById('updateAdminForm').style.display === 'block') {
                // Tô màu nút Update nếu form Update đang hiển thị
                document.getElementById('updateAdminBtn').classList.add('active');
                document.getElementById('addAdminBtn').classList.remove('active');
            } else {
                // Tô màu nút Add nếu form Add đang hiển thị
                document.getElementById('addAdminBtn').classList.add('active');
                document.getElementById('updateAdminBtn').classList.remove('active');
            }
        };



        function switchToUpdateForm() {
            // Kiểm tra trạng thái của form Update
            if (document.getElementById('updateAdminForm').style.display === 'none') {
                document.getElementById('addAdminForm').style.display = 'none';
                document.getElementById('updateAdminForm').style.display = 'block';

                // Tô màu cho nút Update và trở về trạng thái bình thường cho nút Add
                document.getElementById('updateAdminBtn').classList.add('active');
                document.getElementById('addAdminBtn').classList.remove('active');
            }
        }

        function addAdmin() {
            if (!checkValidateAdminForm(false)) return;

            const data = {
                username: document.getElementById('usernameAdmin').value.trim(),
                name: document.getElementById('nameAdmin').value.trim(),
                email: document.getElementById('emailAdmin').value.trim(),
                phone: document.getElementById('phoneAdmin').value.trim(),
                password: document.getElementById('passwordAdmin').value.trim(),
                // Thêm các trường còn thiếu nếu cần thiết
            };

            fetch('../controllers/UserController.php?action=addAdmin', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data) // Gửi dữ liệu JSON
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        alert('Thêm admin thành công');
                        // reset form hoặc reload bảng
                    } else {
                        alert(res.message || 'Thêm admin thất bại');
                    }
                })
                .catch(err => console.error('Lỗi:', err));
        }


        function updateAdmin() {
            if (!checkValidateAdminForm(true)) return;

            const data = {
                username: document.getElementById('usernameAdminUpdate').value.trim(),
                name: document.getElementById('nameAdminUpdate').value.trim(),
                email: document.getElementById('emailAdminUpdate').value.trim(),
                phone: document.getElementById('phoneAdminUpdate').value.trim(),
                // password: document.getElementById('passwordAdminUpdate').value.trim(),
            };

            fetch('../controllers/UserController.php?action=updateAdmin', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        alert('Cập nhật admin thành công');
                        // reset form hoặc reload bảng
                    } else {
                        alert(res.message || 'Cập nhật admin thất bại');
                    }
                })
                .catch(err => console.error('Lỗi:', err));
        }


        function loadAdminInfo() {
            fetch(`../controllers/UserController.php?action=getAdminInfo`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const admin = data.data;
                        document.getElementById('usernameAdminUpdate').value = admin.username || '';
                        document.getElementById('nameAdminUpdate').value = admin.fullname || '';
                        document.getElementById('emailAdminUpdate').value = admin.email || '';
                        document.getElementById('phoneAdminUpdate').value = admin.phone || '';
                        document.getElementById('passwordAdminUpdate').value = ''; // không tự động hiển thị password

                        // document.getElementById('updateAdminForm').style.display = 'block';
                    } else {
                        alert(data.message || 'Lỗi khi lấy thông tin admin');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Không thể kết nối đến server');
                });
        }
        loadAdminInfo();
    </script>
    <!-- ----------------------- Script ----------------------- -->
    <script src="../../bootstrap-5.2.2-dist/js/bootstrap.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>

</body>

</html>