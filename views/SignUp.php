<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Khởi động session nếu chưa được khởi động
}

?>
<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Trang SignUp</title>
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.2.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font_Roboto/Roboto-Bold.ttf">
    <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <script src="../assets/js/jquery.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/cart.css">
    <style>
        .input-form .input-wrapper .dropdown {
            display: none;
            position: absolute;
            border: 1px solid #ddd;
            background-color: white;
            width: 200px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 10;
        }

        .input-form .input-wrapper .dropdown .dropdown-item {
            padding: 10px;
            cursor: pointer;
        }

        .input-form .input-wrapper .dropdown .dropdown-item:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <?php
    include './templates/Header.php';
    ?>


    <main role="main">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mx-4">
                        <div class="card-body p-4">
                            <div class="noi-dung">
                                <div class="form">
                                    <h2>Đăng Ký</h2>
                                    <form action="" id="register" method="POST">
                                        <!-- Giữ nguyên các input như bạn cung cấp -->
                                        <div class="input-form">
                                            <span><label for="username">Tên tài khoản:</label></span>
                                            <input id="username" type="text" name="username"
                                                placeholder="VD:username123">
                                            <i class="form-message"></i>
                                        </div>
                                        <div class="input-form">
                                            <span><label for="email">Email:</label></span>
                                            <input id="email" type="text" name="email"
                                                placeholder="VD:email1234@gmail.com">
                                            <i class="form-message"></i>
                                        </div>
                                        <div class="input-form">
                                            <span><label for="SDT">SĐT:</label></span>
                                            <input id="SDT" type="text" name="SDT" placeholder="VD:0984253741">
                                            <i class="form-message"></i>
                                        </div>
                                        <div class="input-form">
                                            <span><label for="name">Họ tên:</label></span>
                                            <input id="name" type="text" name="name" placeholder="VD:Mai Đức Kiên">
                                            <i class="form-message"></i>
                                        </div>
                                        <div class="input-form">
                                            <span><label for="password">Mật Khẩu:</label></span>
                                            <input id="password" type="password" name="password" placeholder="Mật Khẩu">
                                            <i class="form-message"></i>
                                        </div>
                                        <div class="input-form">
                                            <span><label for="confirmpassword">Xác Nhận Mật Khẩu:</label></span>
                                            <input id="confirmpassword" type="password" name="cpassword"
                                                placeholder="Xác Nhận Mật Khẩu">
                                            <i class="form-message"></i>
                                        </div>
                                        <div class="input-form">
                                            <input type="submit" value="Tạo Tài Khoản">
                                            <span class="form-message"></span>
                                        </div>
                                        <div class="xac-nhan">
                                            <p>Bạn Đã Có Tài Khoản?
                                                <a href="./SignIn.php">Đăng Nhập</a>
                                            </p>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End block content -->
    </main>
    <?php
    include './templates/Footer.php';
    ?>
    <!--Kết Thúc Phần Nội Dung-->
    <script src="../../SanPham/js/account.js"></script>
    <script src="../../SanPham/js/product.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('register');

            // Hàm hiển thị lỗi
            function showError(input, message) {
                const formControl = input.parentElement;
                const msgElement = formControl.querySelector('.form-message');
                msgElement.innerText = message;
                msgElement.style.color = 'red';
                input.classList.add('error');
            }

            // Hàm xóa lỗi
            function clearError(input) {
                const formControl = input.parentElement;
                const msgElement = formControl.querySelector('.form-message');
                msgElement.innerText = '';
                input.classList.remove('error');
            }

            // Hàm kiểm tra email
            function isValidEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            // Hàm kiểm tra số điện thoại (10 số)
            function isValidPhone(phone) {
                const re = /^[0-9]{10}$/;
                return re.test(phone);
            }

            // Hàm validate từng trường
            function validateInput(input) {
                const value = input.value.trim();
                const id = input.id;
                let isValid = true;

                clearError(input);

                if (value === '') {
                    showError(input, 'Trường này không được để trống');
                    return false;
                }

                switch (id) {
                    case 'username':
                        if (value.length < 3 || value.length > 20) {
                            showError(input, 'Tên tài khoản phải từ 3 đến 20 ký tự');
                            isValid = false;
                        }
                        break;
                    case 'email':
                        if (!isValidEmail(value)) {
                            showError(input, 'Email không hợp lệ');
                            isValid = false;
                        }
                        break;
                    case 'SDT':
                        if (!isValidPhone(value)) {
                            showError(input, 'Số điện thoại phải là 10 số');
                            isValid = false;
                        }
                        break;
                    case 'name':
                        if (value.length < 2 || value.length > 50) {
                            showError(input, 'Họ tên phải từ 2 đến 50 ký tự');
                            isValid = false;
                        }
                        break;
                    case 'password':
                        if (value.length < 6) {
                            showError(input, 'Mật khẩu phải ít nhất 6 ký tự');
                            isValid = false;
                        }
                        break;
                    case 'confirmpassword':
                        const password = document.getElementById('password').value;
                        if (value !== password) {
                            showError(input, 'Mật khẩu xác nhận không khớp');
                            isValid = false;
                        }
                        break;
                }

                return isValid;
            }

            // Validate khi submit form
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let isFormValid = true;

                const inputs = form.querySelectorAll('input:not([type="submit"])');
                inputs.forEach(input => {
                    if (!validateInput(input)) {
                        isFormValid = false;
                    }
                });

                if (isFormValid) {
                    const formData = new FormData(form);

                    fetch('../controllers/UserController.php?action=register', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text()) // Đọc phản hồi như văn bản
                        .then(data => {
                            console.log('Phản hồi từ PHP (dưới dạng văn bản):', data); // Kiểm tra phản hồi thô

                            try {
                                const jsonData = JSON.parse(data); // Chuyển đổi văn bản thành JSON
                                console.log('Phản hồi sau khi phân tích JSON:', jsonData); // Kiểm tra kết quả sau khi phân tích JSON
                                if (jsonData.status === 'success') {
                                    window.location.href = './SignIn.php';
                                } else {
                                    alert(jsonData.message);
                                }
                            } catch (e) {
                                console.error('Lỗi khi phân tích JSON:', e);
                                alert('Dữ liệu trả về không hợp lệ');
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                        });
                }

            });

            // Validate real-time khi nhập
            form.querySelectorAll('input:not([type="submit"])').forEach(input => {
                input.addEventListener('input', function() {
                    validateInput(input);
                });
            });
        });
    </script>

</body>

</html>