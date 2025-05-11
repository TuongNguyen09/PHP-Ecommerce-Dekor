<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản của tôi</title>
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.2.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font_Roboto/Roboto-Bold.ttf">
    <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <script src="../assets/js/jquery.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/cart.css">
    <link rel="stylesheet" href="../assets/css/accountInfo.css">

</head>
</head>
<style>
    .form-group .input-wrapper .dropdown {
        display: none;
        position: absolute;
        border: 1px solid #ddd;
        background-color: white;
        width: 200px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 10;
    }

    .form-group .input-wrapper .dropdown .dropdown-item {
        padding: 10px;
        cursor: pointer;
    }

    .form-group .input-wrapper .dropdown .dropdown-item:hover {
        background-color: #f0f0f0;
    }

    .form-container input {
        padding: 10px;
        width: 300px;
    }

    .container-order {
        display: flex;
        width: 80%;
        margin-top: 80px;
        margin-bottom: 80px;
    }

    .sidebar {
        width: 250px;
        /* background-color: #fff; */
        padding: 20px;
        /* box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); */
        height: 100vh;
    }

    .profile {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 30px;
    }

    .avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    .user-name p {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .user-name a {
        font-size: 14px;
        color: #007bff;
        text-decoration: none;
    }

    .menu-item {
        text-decoration: none;
        color: #333;
        padding: 10px;
        border-radius: 5px;
        display: inline-block;
        margin-bottom: 10px;
        /* Thêm khoảng cách giữa các mục */
        transition: background-color 0.3s, color 0.3s;
    }

    .menu-item:hover {
        background-color: #f0f0f0;
    }

    .menu-item.active {
        color: blue;
    }
</style>

<body>
    <?php
    include './templates/Header.php';
    ?>

    <div class="container-order">
        <!-- Thanh menu bên trái -->
        <div class="sidebar">
            <div class="profile">
                <img src="https://i.natgeofe.com/n/548467d8-c5f1-4551-9f58-6817a8d2c45e/NationalGeographic_2572187_2x3.jpg"
                    alt="Avatar" class="avatar">
                <div class="user-name">
                    <p></p>
                </div>
            </div>
            <div class="menu-items">
                <a href="./accountInfo.html" class="menu-item active"><span class="icon">👤</span> Tài Khoản Của Tôi</a>
                <a href="./user_order.html" class="menu-item"><span class="icon">📋</span> Đơn Mua</a>
            </div>
        </div>
        <!-- Phần lịch sử đơn hàng -->
        <div class="profile-container">
            <h4>Hồ Sơ Của Tôi</h4>
            <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>

            <form id="accountForm">
                <input type="hidden" id="userId" value="">
                <div class="form-group">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" id="username" value="" disabled>
                    <small class="form-message" id="username-error"></small>
                </div>

                <div class="form-group">
                    <label for="name">Tên</label>
                    <input type="text" id="name" value="">
                    <small class="form-message" id="name-error"></small>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="">
                    <small class="form-message" id="email-error"></small>
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" id="phone" value="">
                    <small class="form-message" id="phone-error"></small>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" value="" disabled>
                    <small class="form-message" id="password-error"></small>
                </div>

                <!-- <div class="form-group">
                    <label for="adress">Địa chỉ</label>
                    <div class="input-wrapper" style="width: 40%;">
                        <input style="width: 100%;padding: 10px;" type="text" class="form-control" name="address"
                            id="address" value="">
                        <div id="addressDropdown" class="dropdown"></div>
                        <div id="districtDropdown" class="dropdown"></div>
                        <div id="wardDropdown" class="dropdown"></div>
                    </div>
                    <small class="form-message" id="address-error"></small>
                </div> -->

                <div class="form-group">
                    <label>Giới tính</label>
                    <div class="checkbox-gender">
                        <label class="label-gender"><input type="radio" name="gender" value="male"> Nam</label>
                        <label class="label-gender"><input type="radio" name="gender" value="female"> Nữ</label>
                    </div>
                    <small class="form-message" id="gender-error"></small>
                </div>

                <div class="form-group">
                    <label for="dob">Ngày sinh</label>
                    <input type="date" id="dob" value="">
                    <small class="form-message" id="dob-error"></small>
                </div>

                <button type="button" class="save-button" onclick="saveUserInfo()">Lưu</button>
            </form>


        </div>
    </div>

    <?php
    include './templates/Footer.php';
    ?>
    <!--Kết Thúc Phần Nội Dung-->
    <script src="../../SanPham/js/data.js"></script>
    <script src="../../SanPham/js/account.js"></script>
    <script>
        function validateAccountForm() {
            let isValid = true;

            // Xóa các thông báo lỗi cũ
            const errorMessages = document.querySelectorAll(".form-message");
            errorMessages.forEach(msg => msg.textContent = "");

            // Kiểm tra tên
            const name = document.getElementById("name").value;
            if (name === "") {
                document.getElementById("name-error").textContent = "Tên không được để trống!";
                isValid = false;
            }

            // Kiểm tra email
            const email = document.getElementById("email").value;
            if (email === "") {
                document.getElementById("email-error").textContent = "Email không được để trống!";
                isValid = false;
            } else if (!/^[a-zA-Z0-9]+@gmail\.com$/.test(email)) {
                document.getElementById("email-error").textContent = "Email không hợp lệ!";
                isValid = false;
            } else if (isEmailExist(email)) {
                document.getElementById("email-error").textContent = "Email đã tồn tại!";
                isValid = false;
            }

            // Kiểm tra số điện thoại
            const phone = document.getElementById("phone").value;
            if (phone === "") {
                document.getElementById("phone-error").textContent = "Số điện thoại không được để trống!";
                isValid = false;
            } else if (!/^\d{10}$/.test(phone)) {
                document.getElementById("phone-error").textContent = "Số điện thoại phải có 10 chữ số!";
                isValid = false;
            }

            // Kiểm tra giới tính
            const gender = document.querySelector('input[name="gender"]:checked');
            if (!gender) {
                document.getElementById("gender-error").textContent = "Bạn phải chọn giới tính!";
                isValid = false;
            }

            // Kiểm tra ngày sinh
            const dob = document.getElementById("dob").value;
            if (dob === "") {
                document.getElementById("dob-error").textContent = "Ngày sinh không được để trống!";
                isValid = false;
            }

            return isValid;
        }

        function isEmailExist(email) {
            const users = JSON.parse(localStorage.getItem("users")) || [];

            // Tìm người dùng hiện tại (isSignIn = 1)
            const currentUser = users.find(user => user.isSignIn === 1);

            // Kiểm tra xem email có trùng với email của người dùng hiện tại không, nếu có thì bỏ qua
            return users.some(user => user.account === email && user.account !== currentUser?.account);
        }

        function saveUserInfo() {
            if (!validateAccountForm()) return;

            const userId = document.getElementById("userId").value; // Lấy id từ input ẩn

            const formData = new FormData();
            formData.append("username", document.getElementById("username").value);
            formData.append("fullname", document.getElementById("name").value); // đổi key khớp PHP
            formData.append("email", document.getElementById("email").value);
            formData.append("phone", document.getElementById("phone").value);
            formData.append("gender", document.querySelector('input[name="gender"]:checked')?.value || '');
            formData.append("birthday", document.getElementById("dob").value); // đổi key khớp PHP
            formData.append("password", document.getElementById("password").value);

            fetch(`../controllers/UserController.php?action=update&id=${userId}`, { // Kèm id vào query string
                    method: "POST",
                    body: formData
                })
                .then(res => res.text()) // Đọc dữ liệu trả về dưới dạng văn bản
                .then(responseText => {
                    // Log thẳng phản hồi từ PHP (có thể là JSON hoặc văn bản)
                    console.log('Phản hồi từ PHP:', responseText);
                    alert(responseText); // Hoặc hiển thị luôn bằng alert nếu cần
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    alert("Lỗi: Không thể kết nối đến server.");
                });
        }


        document.addEventListener('DOMContentLoaded', function() {
            fetch('../controllers/UserController.php?action=getMyInfo') // đường dẫn tới file PHP bạn vừa tạo
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        const user = data.user;

                        // In thông tin người dùng ra console
                        console.log('Thông tin người dùng:', user);
                        document.getElementById('userId').value = user.id;
                        document.getElementById('username').value = user.username;
                        document.getElementById('name').value = user.fullname;
                        document.getElementById('email').value = user.email;
                        document.getElementById('phone').value = user.phone;
                        document.getElementById('dob').value = user.birthday;
                        document.getElementById("password").value = user.password;

                        // Xử lý giới tính
                        const genderInputs = document.querySelectorAll('input[name="gender"]');
                        genderInputs.forEach(input => {
                            input.checked = input.value === user.gender;
                        });
                    } else {
                        alert(data.message || 'Không thể lấy thông tin người dùng.');
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                });
        });
    </script>
</body>

</html>