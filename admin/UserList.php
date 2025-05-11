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
    <link rel="stylesheet" href="../assets/bootstrap-5.2.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="../assets/font_Roboto/Roboto-Bold.ttf">
    <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css">
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <title>Quản lý người dùng</title>
    <style>
        .overlay-modal {
            position: fixed;
            text-align: center;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* display: none; */
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 500px;
            max-height: 80vh;
            margin: auto;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            margin-top: 100px;
        }


        .close {
            position: absolute;
            top: 10px;
            bottom: 50px;
            right: 20px;
            font-size: 30px;
            cursor: pointer;
        }

        .input-wrapper .dropdown {
            display: none;
            position: absolute;
            border: 1px solid #ddd;
            background-color: white;
            width: 200px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 10;
        }

        .input-wrapper .dropdown .dropdown-item {
            padding: 10px;
            cursor: pointer;
        }

        .input-wrapper .dropdown .dropdown-item:hover {
            background-color: #f0f0f0;
        }

        .input-container {
            text-align: left;
            width: 60%;
        }

        #editUserForm {
            text-align: center;
        }

        #editUserForm .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            height: 62px;
        }

        #editUserForm .form-row label {
            width: 120px;
            text-align: left;
        }

        #editUserForm .form-row .input-container input,
        #editUserForm .form-row button {
            width: 80%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        #editUserForm .form-row .input-container input {
            width: 100%;
            text-align: left;
        }

        #editUserForm .form-row .input-container input[type="radio"] {
            width: 30%;
            text-align: left;
        }

        #editUserForm button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100px;
        }


        #editUserForm button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 12px;
            display: block;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <?php
    include './Header.php';
    ?>

    <div class="content">
        <div class="row">
            <div class="title col-12 box_shadow">
                <b>Quản lý người dùng</b>
            </div>
        </div>
        <div class="row main_frame box_card box_shadow">
            <div class="element_btn">
                <div>
                    <a class="addnew_button" onclick="openEditUserModal()"><i class="fas fa-plus"></i>Thêm mới người
                        dùng</a>
                </div>
            </div>
            <div class="table-responsive-lg">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">ID</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Tên tài khoản</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Email</th>
                            <th scope="col">Giới tính</th>
                            <th scope="col">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody id="userTable">

                    </tbody>
                </table>
            </div>
            <div class="category_paging">
                <ul class="pagination" id="pagination_number">
                    <!-- <li class="page-item page_btn_prev"><a class="page-link"><i class="fas fa-chevron-left"></i></a>
                    </li>
                    <div class="pagination number_page" id="number_page">
                        <li class="active"><a class="page-link">1</a></li>
                        <li><a class="page-link">2</a></li>
                        <li><a class="page-link">3</a></li>
                    </div>
                    <li class="page-item page_btn_next"><a class="page-link"><i class="fas fa-chevron-right"></i></a>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>

    <div id="editUserModal" class="overlay-modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeEditUserModal()">&times;</span>
            <h4 style="color: #DD0000;font-weight: 600;">THÔNG TIN NGƯỜI DÙNG</h4>
            <form id="editUserForm">
                <input type="hidden" id="editUserId">

                <div class="form-row">
                    <label for="editUsername">Tài khoản:</label>
                    <div class="input-container">
                        <input type="text" id="editUsername" required>
                        <small class="error-message" id="editUsernameError"></small>
                    </div>
                </div>

                <div class="form-row">
                    <label for="editFullName">Họ và tên:</label>
                    <div class="input-container">
                        <input type="text" id="editFullName" required>
                        <small class="error-message" id="editFullNameError"></small>
                    </div>
                </div>

                <!-- <div class="form-row">
                    <label for="editAddress">Địa chỉ:</label>
                    <div class="input-container input-wrapper">
                        <input type="text" id="editAddress" required>
                        <div id="addressDropdown" class="dropdown"></div>
                        <div id="districtDropdown" class="dropdown"></div>
                        <div id="wardDropdown" class="dropdown"></div>
                        <small class="error-message" id="editAddressError"></small>
                    </div>
                </div> -->

                <div class="form-row">
                    <label for="editPhone">Số điện thoại:</label>
                    <div class="input-container">
                        <input type="text" id="editPhone" required>
                        <small class="error-message" id="editPhoneError"></small>
                    </div>
                </div>

                <div class="form-row">
                    <label for="editEmail">Email:</label>
                    <div class="input-container">
                        <input type="email" id="editEmail" required>
                        <small class="error-message" id="editEmailError"></small>
                    </div>
                </div>

                <div class="form-row">
                    <label>Giới tính:</label>
                    <div class="input-container">
                        <div style="display: flex;">
                            <label>
                                <input type="radio" name="editGender" value="male"> Nam
                            </label>
                            <label>
                                <input type="radio" name="editGender" value="female"> Nữ
                            </label>
                        </div>
                        <small class="error-message" id="editGenderError"></small>
                    </div>
                </div>

                <div class="form-row">
                    <label for="editBirthday">Ngày sinh:</label>
                    <div class="input-container">
                        <input type="date" id="editBirthday" required>
                        <small class="error-message" id="editBirthdayError"></small>
                    </div>
                </div>

                <div id="labelPassword" class="form-row">
                    <label for="editPassword">Mật khẩu:</label>
                    <div class="input-container">
                        <input type="password" id="editPassword" required>
                        <small class="error-message" id="editPasswordError"></small>
                    </div>
                </div>

                <div id="labelconfirmPassword" class="form-row">
                    <label for="editConfirmPassword">Nhập lại mật khẩu:</label>
                    <div class="input-container">
                        <input type="password" id="editConfirmPassword" required>
                        <small class="error-message" id="editConfirmPasswordError"></small>
                    </div>
                </div>

                <button type="button" id="saveChangesBtn">Lưu</button>
            </form>


        </div>
    </div>

    <!-- ----------------------- Script ----------------------- -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../../bootstrap-5.2.2-dist/js/bootstrap.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <script src="../../js/jquery.min.js"></script>
    <script>
        function checkValidateUserForm() {
            let isValid = true;

            // Lấy giá trị
            const username = document.getElementById('editUsername').value.trim();
            const fullname = document.getElementById('editFullName').value.trim();
            const phone = document.getElementById('editPhone').value.trim();
            const email = document.getElementById('editEmail').value.trim();
            const birthday = document.getElementById('editBirthday').value;
            const gender = document.querySelector('input[name="editGender"]:checked');
            const password = document.getElementById('editPassword').value.trim();
            const confirmPassword = document.getElementById('editConfirmPassword').value.trim();

            // Reset lỗi
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

            // Tài khoản
            if (!username) {
                document.getElementById('editUsernameError').textContent = 'Vui lòng nhập tài khoản';
                isValid = false;
            }

            // Họ tên
            if (!fullname) {
                document.getElementById('editFullNameError').textContent = 'Vui lòng nhập họ tên';
                isValid = false;
            }

            // Số điện thoại
            if (!phone || !/^\d{10,11}$/.test(phone)) {
                document.getElementById('editPhoneError').textContent = 'Số điện thoại không hợp lệ';
                isValid = false;
            }

            // Email
            if (!email || !/^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
                document.getElementById('editEmailError').textContent = 'Email không hợp lệ';
                isValid = false;
            }

            // Giới tính
            if (!gender) {
                document.getElementById('editGenderError').textContent = 'Vui lòng chọn giới tính';
                isValid = false;
            }

            // Ngày sinh
            if (!birthday) {
                document.getElementById('editBirthdayError').textContent = 'Vui lòng chọn ngày sinh';
                isValid = false;
            }

            // Mật khẩu
            if (!password) {
                document.getElementById('editPasswordError').textContent = 'Vui lòng nhập mật khẩu';
                isValid = false;
            } else if (password.length < 6) {
                document.getElementById('editPasswordError').textContent = 'Mật khẩu ít nhất 6 ký tự';
                isValid = false;
            }

            // Nhập lại mật khẩu
            if (!confirmPassword || confirmPassword !== password) {
                document.getElementById('editConfirmPasswordError').textContent = 'Mật khẩu không khớp';
                isValid = false;
            }

            return isValid;
        }


        function closeEditUserModal() {
            document.getElementById('editUserModal').style.display = 'none';
        }

        // Mở modal user để thêm mới hoặc chỉnh sửa
        function openEditUserModal(id = null) {
            // Reset lỗi
            const errorFields = [
                'editUsernameError', 'editFullNameError',
                'editPhoneError', 'editEmailError', 'editGenderError',
                'editBirthdayError', 'editPasswordError', 'editConfirmPasswordError'
            ];
            errorFields.forEach(field => document.getElementById(field).innerText = '');

            // Lấy 2 khối nhập mật khẩu
            const passwordField = document.getElementById('labelPassword');
            const confirmPasswordField = document.getElementById('labelconfirmPassword');

            if (id) {
                // Chế độ cập nhật: ẩn mật khẩu
                passwordField.style.display = 'none';
                confirmPasswordField.style.display = 'none';

                fetch(`../controllers/UserController.php?action=get&id=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const user = data.user;
                            document.getElementById('editUserId').value = user.id;
                            document.getElementById('editUsername').value = user.username;
                            document.getElementById('editFullName').value = user.fullname;
                            // document.getElementById('editAddress').value = user.address;
                            document.getElementById('editPhone').value = user.phone;
                            document.getElementById('editEmail').value = user.email;
                            document.getElementById('editBirthday').value = user.birthday;
                            document.querySelector(`input[name="editGender"][value="${user.gender}"]`).checked = true;

                            document.getElementById('editUserModal').style.display = 'block';
                        } else {
                            alert(data.message || 'Không thể tải thông tin người dùng');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi lấy dữ liệu người dùng:', error);
                        alert('Đã xảy ra lỗi khi lấy thông tin người dùng.');
                    });
            } else {
                // Chế độ thêm mới: hiện mật khẩu
                passwordField.style.display = 'flex';
                confirmPasswordField.style.display = 'flex';

                document.getElementById('editUserId').value = '';
                document.getElementById('editUsername').value = '';
                document.getElementById('editFullName').value = '';
                // document.getElementById('editAddress').value = '';
                document.getElementById('editPhone').value = '';
                document.getElementById('editEmail').value = '';
                document.getElementById('editBirthday').value = '';
                document.querySelectorAll('input[name="editGender"]').forEach(r => r.checked = false);

                document.getElementById('editPassword').value = '';
                document.getElementById('editConfirmPassword').value = '';

                document.getElementById('editUserModal').style.display = 'block';
            }
        }



        document.getElementById('saveChangesBtn').addEventListener('click', () => {
            // Kiểm tra validate trước
            if (!checkValidateUserForm()) {
                return; // Nếu không hợp lệ thì không gửi
            }

            const id = document.getElementById('editUserId').value;
            const username = document.getElementById('editUsername').value.trim();
            const fullname = document.getElementById('editFullName').value.trim();
            const phone = document.getElementById('editPhone').value.trim();
            const email = document.getElementById('editEmail').value.trim();
            const birthday = document.getElementById('editBirthday').value.trim();
            const gender = document.querySelector('input[name="editGender"]:checked')?.value || '';
            const password = document.getElementById('editPassword').value.trim();

            const formData = new FormData();
            formData.append('username', username);
            formData.append('fullname', fullname);
            formData.append('phone', phone);
            formData.append('email', email);
            formData.append('birthday', birthday);
            formData.append('gender', gender);
            formData.append('password', password);

            const action = id ? `update&id=${id}` : 'create';

            fetch(`../controllers/UserController.php?action=${action}`, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(text => {
                    console.log('RAW RESPONSE FROM PHP:', text);
                    try {
                        const result = JSON.parse(text);
                        if (result.status === 'success') {
                            alert('Lưu thành công!');
                            closeEditUserModal();
                            loadUsers();
                        } else {
                            alert('Thất bại: ' + (result.message || 'Có lỗi xảy ra'));
                        }
                    } catch (e) {
                        console.error('Phản hồi không phải JSON:', e, text);
                        alert('Phản hồi lỗi từ máy chủ:\n' + text);
                    }
                })
                .catch(error => {
                    console.error('Lỗi gửi dữ liệu:', error);
                    alert('Gửi yêu cầu thất bại.');
                });
        });


        // Gọi API lấy danh sách user từ server
        function fetchUsersFromServer(params) {
            fetch('../controllers/UserController.php?action=listUsers&' + params.toString())
                .then(res => res.json())
                .then(data => {
                    renderUsers(data.users);
                    renderUserPagination(data.totalPages, data.currentPage);
                })
                .catch(error => console.error('Fetch error:', error));
        }

        // Load lại danh sách users
        function fetchUsersFromServer(params) {
            fetch('../controllers/UserController.php?action=listUsers&' + params.toString())
                .then(res => res.json())
                .then(data => {
                    renderUsers(data.users);
                    renderUserPagination(data.totalPages, data.currentPage);
                })
                .catch(error => console.error('Fetch error:', error));
        }

        // function renderUsers(users) {
        //     const tbody = document.querySelector('#userTable');
        //     tbody.innerHTML = '';

        //     users.forEach(user => {
        //         const row = document.createElement('tr');
        //         row.id = `user-${user.id}`;
        //         row.innerHTML = `
        // <td>${user.id}</td>
        // <td>${user.username}</td>
        // <td>${user.fullname}</td>
        // <td>${user.email}</td>
        // <td>${user.phone}</td>
        // <td>
        //     <button class="btn btn-primary btn-sm edit" onclick="openEditUserModal(${user.id})"><i class="fas fa-edit"></i></button>
        //     <button class="btn btn-danger btn-sm delete" onclick="deleteUser(${user.id})"><i class="fas fa-trash"></i></button>
        // </td>
        // `;
        //         tbody.appendChild(row);
        //     });
        // }

        function loadUsers() {
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get('page') || 1;

            fetch(`../controllers/UserController.php?action=listUsers&page=${page}`)
                .then(res => res.json())
                .then(data => {
                    renderUsers(data.users);
                    renderUserPagination(data.totalPages, data.currentPage);
                });
        }


        // Xóa user
        function deleteUser(id) {
            if (!confirm("Bạn có chắc chắn muốn xóa người dùng này?")) return;

            fetch(`../controllers/UserController.php?action=delete&id=${id}`, {
                    method: 'POST',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        loadUsers();
                    } else {
                        alert(data.message || 'Xóa thất bại');
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi gửi yêu cầu xóa:', error);
                    alert('Đã xảy ra lỗi khi xóa người dùng.');
                });
        }


        function renderUsers(paginatedUsers) {
            const tbody = document.querySelector('#userTable');
            if (!tbody) return;

            tbody.innerHTML = ''; // Xóa nội dung cũ

            paginatedUsers.forEach(user => {
                const row = document.createElement('tr');
                row.id = `user-${user.id}`;
                const isBanned = user.is_banned == 1;

                // Tô màu đỏ toàn bộ dòng nếu user bị khóa
                const styleRed = isBanned ? 'color: red;' : '';

                row.innerHTML = `
            <td style="${user.is_banned == 1? 'color:red !important' : 'color:black!important'}">${user.id}</td>
            <td style="${styleRed}">${user.fullname}</td>
            <td style="${styleRed}">${user.username}</td>
            <td style="${styleRed}">${user.phone}</td>
            <td style="${styleRed}">${user.email}</td>
            <td style="${styleRed}">${user.gender === 'male' ? 'Nam' : 'Nữ'}</td>
            <td>
                <button
                    title="Khóa người dùng"
                    class="btn btn-primary btn-sm ban"
                    type="button"
                    data-user-id="${user.id}"
                    style="${user.is_banned == 1 ? 'display: none;' : 'display: inline-block;'}">
                    <i class="fas fa-ban"></i>
                </button>
                <button
                    title="Mở khóa người dùng"
                    class="btn btn-primary btn-sm unban"
                    type="button"
                    data-user-id="${user.id}"
                    style="${user.is_banned == 0 ? 'display: none;' : 'display: inline-block;'}">
                    <i class="fa-solid fa-unlock"></i>
                </button>
                <button
                    title="Chỉnh sửa thông tin"
                    class="btn btn-primary btn-sm edit"
                    type="button"
                    onclick="openEditUserModal(${user.id})">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        `;
                tbody.appendChild(row);
            });

            // Gắn lại sự kiện
            tbody.querySelectorAll('.ban').forEach(button => {
                button.addEventListener('click', () => toggleBanUnban(button, 'ban'));
            });

            tbody.querySelectorAll('.unban').forEach(button => {
                button.addEventListener('click', () => toggleBanUnban(button, 'unban'));
            });
        }


        function toggleBanUnban(button, action) {
            const userId = button.getAttribute('data-user-id');
            const isBan = action === 'ban';
            const url = `../controllers/UserController.php?action=${isBan ? 'banUser' : 'unbanUser'}&id=${userId}`;

            fetch(url, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const row = document.getElementById(`user-${userId}`);
                        if (row) {
                            const banBtn = row.querySelector('.ban');
                            const unbanBtn = row.querySelector('.unban');
                            const cells = row.querySelectorAll('td');

                            // Cập nhật hiển thị
                            if (isBan) {
                                banBtn.style.display = 'none';
                                unbanBtn.style.display = 'inline-block';
                                cells.forEach(cell => cell.style.color = 'red');
                                alert("Khóa người dùng thành công");
                            } else {
                                unbanBtn.style.display = 'none';
                                banBtn.style.display = 'inline-block';
                                cells.forEach(cell => cell.style.color = '');
                                alert("Mở khóa người dùng thành công");
                            }
                        }
                    } else {
                        alert(data.message || 'Thao tác thất bại!');
                    }
                })
                .catch(error => {
                    console.error("Lỗi khi khóa/mở khóa:", error);
                    alert("Có lỗi xảy ra khi gửi yêu cầu.");
                });
        }




        // Cập nhật URL khi chuyển trang
        function updateUserUrl(page = 1) {
            let params = new URLSearchParams();
            params.set('page', page);
            history.pushState(null, '', '?' + params.toString());
            fetchUsersFromServer(params);
        }

        // Phân trang
        function renderUserPagination(totalPages, currentPage) {
            const paginationContainer = document.getElementById('pagination_number');
            paginationContainer.innerHTML = '';

            let html = '<ul class="pagination">';

            html += `
    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
        <a href="?page=${currentPage - 1}" class="page-link">
            <i class="fas fa-chevron-left"></i>
        </a>
    </li>
    `;

            const maxVisiblePages = 5;
            const half = Math.floor(maxVisiblePages / 2);
            let startPage = Math.max(1, currentPage - half);
            let endPage = Math.min(totalPages, currentPage + half);

            for (let i = startPage; i <= endPage; i++) {
                html += `
        <li class="page-item ${i === currentPage ? 'active' : ''}">
            <a href="?page=${i}" class="page-link">${i}</a>
        </li>
        `;
            }

            html += `
    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
        <a href="?page=${currentPage + 1}" class="page-link">
            <i class="fas fa-chevron-right"></i>
        </a>
    </li>
    `;

            html += '</ul>';
            paginationContainer.innerHTML = html;
        }


        // Gọi ban đầu khi load trang
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.has('page')) {
                urlParams.set('page', '1');
                history.replaceState(null, '', '?' + urlParams.toString());
            }
            fetchUsersFromServer(urlParams);
        };
    </script>

</body>

</html>