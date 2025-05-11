<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Khởi động session nếu chưa được khởi động
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Trang Login</title>
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.2.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font_Roboto/Roboto-Bold.ttf">
    <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <script src="../assets/js/jquery.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/cart.css">

</head>

<body>
    <?php
    include './templates/Header.php';
    ?>

    <!-- Block content - Đục lỗ trên giao diện bố cục chung, đặt tên là `content` -->
    <main>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mx-4">
                        <div class="card-body p-4">
                            <div class="noi-dung">
                                <div class="form">
                                    <h2>Đăng Nhập</h2>
                                    <form action="../../Index.html" id="signIn">
                                        <div class="input-form">
                                            <span><label for="username1">Tên tài khoản:</label></span>
                                            <input id="username1" type="text" name="username1" placeholder="Tên tài khoản">
                                            <i class="form-message" id="username-message"></i>
                                        </div>
                                        <div class="input-form">
                                            <span><label for="password1">Mật Khẩu:</label></span>
                                            <input id="password1" type="password" name="password1" placeholder="Mật Khẩu">
                                            <i class="form-message" id="password-message"></i>
                                        </div>
                                        <div class="input-form">
                                            <a href="#"><input type="submit" value="Đăng Nhập">
                                            </a>

                                        </div>
                                        <div class="input-form">
                                            <p>Bạn Chưa Có Tài Khoản?
                                                <a href="./SignUp.php">Đăng Ký</a>
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
    </main>
    <!-- End block content -->
    <?php
    include './templates/Footer.php';
    ?>
    <script src="../../SanPham/js/data.js"></script>
    <script src="../../SanPham/js/account.js"></script>
    <script src="../../SanPham/js/product.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('signIn');

            // Hàm hiển thị lỗi chung
            function showError(message) {
                const msgElement = document.getElementById('password-message');
                msgElement.innerText = message;
                msgElement.style.color = 'red';
            }

            // Hàm xóa lỗi
            function clearError() {
                const msgElement = document.getElementById('password-message');
                msgElement.innerText = '';
            }

            // Hàm validate trường đăng nhập
            function validateInput(input) {
                const value = input.value.trim();
                const id = input.id;
                let isValid = true;

                clearError();

                if (value === '') {
                    showError('Trường này không được để trống');
                    return false;
                }

                switch (id) {
                    case 'username1':
                        if (value.length < 3 || value.length > 20) {
                            showError('Tên tài khoản phải từ 3 đến 20 ký tự');
                            isValid = false;
                        }
                        break;
                    case 'password1':
                        if (value.length < 6) {
                            showError('Mật khẩu phải ít nhất 6 ký tự');
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
                    fetch('../controllers/UserController.php?action=login', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Phản hồi từ PHP:', data);
                            if (data.status === 'success') {
                                window.location.href = '../index.php'; // Chuyển đến trang quản trị
                            } else {
                                showError(data.message); // Hiển thị thông báo lỗi chung
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