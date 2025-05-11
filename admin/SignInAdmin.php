<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <link rel="stylesheet" href="../assets/css/admin.css" />
  <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css" />
  <link rel="stylesheet" href="../assets/bootstrap-5.2.2-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/font_Roboto/Roboto-Bold.ttf" />
  <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css" />
  <link rel="stylesheet" href="../assets/css/product.css" />
  <script src="../assets/js/jquery.min.js"></script>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <script src=".../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="../assets/css/cart.css" />
  <title>Admin</title>
  <style>
    body {
      background-color: #f0f0f0;
      font-family: Arial, sans-serif;
      height: 100vh;
    }

    .login-container {
      margin: auto;
      display: flex;
      vertical-align: middle;
      background: #ffffff;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.4);
      /* Tăng độ mờ và giảm độ trong suốt */
      border-radius: 8px;
      overflow: hidden;
      width: 60%;
      margin-top: 120px;
      height: 400px;
    }

    form {
      padding: 0 30px 0 30px !important;
    }

    .login-image {
      width: 50%;
      background: url("https://noithatchauanh.com/uploaded/Thiet-ke-noi-that-biet-thu-go-oc-cho-1-1_1.jpg") no-repeat center center/cover;
    }

    .login-form {
      position: relative;
      width: 50%;
      padding: 20px;
      overflow-x: auto;
      overflow-y: auto;
      max-height: 100vh;
      box-sizing: border-box;
      transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    }

    .form-container {
      display: none;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    }

    .form-container.active {
      display: block;
      opacity: 1;
      visibility: visible;
    }

    #toggleFormText {
      font-weight: bold;
      color: #007bff;
    }

    #formTitle {
      text-align: center;
      margin-bottom: 20px;
    }

    .login-form h4 {
      margin-bottom: 30px;
      color: #bb0000;
      font-weight: 600;
      text-align: center;
    }

    .form-group {
      margin-bottom: 15px;
      margin-top: 30px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      color: #555;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    .form-group button {
      width: 100%;
      padding: 10px;
      background-color: #001c40;
      color: white;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .form-group button:hover {
      background-color: #0056b3;
    }

    .message-error {
      color: red;
      font-size: 12px;
      margin-top: 5px;
      display: block;
      height: 3px;
    }
  </style>
</head>

<body>
  <header>
    <div class="top">
      <div class="tab_menu">
        <img style="margin: 10px 0 0 20px" src="../../../img/logo.webp" alt="" />
      </div>
    </div>
  </header>

  <div class="login-container">
    <div class="login-image"></div>
    <div class="login-form">
      <h4 id="formTitle">ĐĂNG NHẬP</h4>

      <!-- Form đăng nhập -->
      <form id="loginForm" class="form-container">
        <div class="form-group">
          <label for="username">Tên đăng nhập</label>
          <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập" required />
          <span class="message-error" id="usernameError"></span>
        </div>
        <div class="form-group">
          <label for="password">Mật khẩu</label>
          <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required />
          <span class="message-error" id="passwordError"></span>
        </div>
        <div class="form-group">
          <button type="button" onclick="validateLogin()">Đăng nhập</button>
        </div>
      </form>

      <div style="text-align: center">
        <span id="toggleFormText" style="cursor: pointer"></span>
      </div>
    </div>
  </div>

  <!-- ----------------------- Script ----------------------- -->
  <script src="../../bootstrap-5.2.2-dist/js/bootstrap.bundle.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
  <script>
    function validateLogin() {
      const username = document.getElementById("username").value.trim();
      const password = document.getElementById("password").value.trim();
      const errorSpan = document.getElementById("passwordError");
      errorSpan.textContent = "";

      fetch("../controllers/UserController.php?action=loginAdmin", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
        })
        .then(response => response.text()) // Chúng ta đọc văn bản thay vì JSON
        .then(data => {
          if (data === 'Đăng nhập admin thành công') { // Kiểm tra thông báo thành công
            window.location.href = "index.php";
          } else {
            errorSpan.textContent = data; // Hiển thị thông báo lỗi trả về từ PHP
          }
        })
        .catch(error => {
          console.error("Lỗi trong quá trình gửi yêu cầu:", error); // In lỗi vào console
          errorSpan.textContent = "Đã xảy ra lỗi khi gửi yêu cầu.";
        });
    }

    // Hiển thị form đăng nhập mặc định
    document.getElementById("loginForm").classList.add("active");
  </script>
</body>

</html>