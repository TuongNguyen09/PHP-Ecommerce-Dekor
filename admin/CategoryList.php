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
    <link rel="stylesheet" href="../assets/css/themify-icons/themify-icons.css">
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <title>Quản lý danh mục</title>
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
                    <a class="addnew_button" onclick="openEditCategoryModal()"><i class="fas fa-plus"></i>Thêm mới danh mục sản phẩm</a>
                </div>
            </div>
            <div class="table-responsive-lg">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">ID</th>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTable">

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
            <span class="close" onclick="closeEditCategoryModal()">&times;</span>
            <h4 style="color: #DD0000;font-weight: 600;">THÔNG TIN DANH MỤC</h4>
            <form id="editUserForm">
                <input type="hidden" id="editUserId">

                <div class="form-row">
                    <label for="editUsername">Tên danh mục:</label>
                    <div class="input-container">
                        <input type="text" id="editName">
                        <small class="error-message" id="editUsernameError"></small>
                    </div>
                </div>

                <div style="margin-top:20px;padding:4px" class="form-row">
                    <label for="editFullName">Mô tả:</label>
                    <div class="input-container">
                        <textarea id="editDescription" rows="3" cols="29"></textarea>
                        <small class="error-message" id="editFullNameError"></small>
                    </div>
                </div>

                <button style="margin-top:20px" type="button" id="saveChangesBtn">Lưu</button>
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
        // Mở modal để sửa hoặc thêm mới
        function openEditCategoryModal(id = null) {
            // Reset lỗi
            document.getElementById('editUsernameError').innerText = '';
            document.getElementById('editFullNameError').innerText = '';

            if (id) {
                // Gọi API để lấy thông tin danh mục và điền vào form
                fetch(`../controllers/CategoryController.php?action=get&id=${id}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('editUserId').value = data.id;
                        document.getElementById('editName').value = data.name;
                        document.getElementById('editDescription').value = data.description ?? '';
                        document.getElementById('editUserModal').style.display = 'block';
                    });
            } else {
                // Thêm mới: reset form
                document.getElementById('editUserId').value = '';
                document.getElementById('editName').value = '';
                document.getElementById('editDescription').value = '';
                document.getElementById('editUserModal').style.display = 'block';
            }
        }

        function saveCategoryChanges(categoryId) {
            const name = document.getElementById("editName").value.trim();
            const description = document.getElementById("editDescription").value.trim();

            if (name === "") {
                document.getElementById("editUsernameError").innerText = "Vui lòng nhập tên danh mục.";
                return;
            } else {
                document.getElementById("editUsernameError").innerText = "";
            }

            const formData = new FormData();
            formData.append("name", name);
            formData.append("description", description);

            const isEdit = categoryId !== null && categoryId !== "";
            const url = isEdit ?
                `../controllers/CategoryController.php?action=update&id=${categoryId}` :
                `../controllers/CategoryController.php?action=create`;

            fetch(url, {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        alert(isEdit ? "Cập nhật danh mục thành công!" : "Thêm danh mục thành công!");
                        closeEditCategoryModal();
                        const currentParams = new URLSearchParams(window.location.search);
                        fetchCategoriesFromServer(currentParams); // <-- sửa tại đây
                    } else {
                        alert("Có lỗi xảy ra: " + (data.message || "Không rõ nguyên nhân."));
                    }
                })
                .catch(error => {
                    console.error("Lỗi khi gửi dữ liệu:", error);
                    alert("Đã xảy ra lỗi khi gửi yêu cầu.");
                });
        }




        // Đóng modal
        function closeEditCategoryModal() {
            document.getElementById('editUserModal').style.display = 'none';
        }
        // Gửi dữ liệu khi nhấn nút "Lưu"
        document.getElementById('saveChangesBtn').addEventListener('click', () => {
            const id = document.getElementById('editUserId').value;
            const name = document.getElementById('editName').value.trim();
            const description = document.getElementById('editDescription').value.trim();

            if (!name) {
                document.getElementById('editUsernameError').innerText = 'Tên danh mục không được để trống';
                return;
            }

            const formData = new FormData();
            formData.append('name', name);
            formData.append('description', description);

            const action = id ? `update&id=${id}` : 'create';

            fetch(`../controllers/CategoryController.php?action=${action}`, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(result => {
                    if (result.status === 'success') {
                        alert('Lưu thành công!');
                        closeEditCategoryModal();
                        loadCategories(); // Bạn cần viết hàm này để reload danh sách
                    } else {
                        alert('Thất bại: ' + (result.message || 'Có lỗi xảy ra'));
                    }
                });
        });

        // Gọi API lấy danh sách category từ server
        function fetchCategoriesFromServer(params) {
            fetch('../controllers/CategoryController.php?action=listCategories&' + params.toString())
                .then(res => res.json())
                .then(data => {
                    renderCategories(data.categories);
                    renderPagination(data.totalPages, data.currentPage);
                })
                .catch(error => console.error('Fetch error:', error));
        }

        function loadCategories() {
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get('page') || 1;

            fetch(`../controllers/CategoryController.php?action=listCategories&page=${page}`)
                .then(res => res.json())
                .then(data => {
                    renderCategories(data.categories);
                    renderPagination(data.totalPages, data.currentPage); // nếu cần update pagination sau khi thay đổi
                });
        }



        function deleteCategory(id) {
            if (!confirm("Bạn có chắc chắn muốn xóa danh mục này?")) return;

            fetch(`../controllers/CategoryController.php?action=delete&id=${id}`, {
                    method: 'POST',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        loadCategories(); // Gọi lại hàm render bảng danh mục sau khi xóa
                    } else {
                        alert(data.message || 'Xóa thất bại');
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi gửi yêu cầu xóa:', error);
                    alert('Đã xảy ra lỗi khi xóa danh mục.');
                });
        }

        // Hiển thị dữ liệu categories ra bảng
        function renderCategories(categories) {
            const tbody = document.querySelector('#categoryTable');
            tbody.innerHTML = '';

            categories.forEach(category => {
                const row = document.createElement('tr');
                row.id = `category-${category.id}`;
                row.innerHTML = `
            <td>${category.id}</td>
            <td>${category.name}</td>
            <td>${category.description || ''}</td>
            <td>
                <button class="btn btn-primary btn-sm edit" onclick="openEditCategoryModal(${category.id})"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger btn-sm delete" onclick="deleteCategory(${category.id})"><i class="fas fa-trash"></i></button>
            </td>
        `;
                tbody.appendChild(row);
            });
        }

        // Gọi khi người dùng chuyển trang
        function updateUrl(page = 1) {
            let params = new URLSearchParams();
            params.set('page', page);
            history.pushState(null, '', '?' + params.toString());
            fetchCategoriesFromServer(params);
        }

        // Render phân trang
        function renderPagination(totalPages, currentPage) {
            const paginationContainer = document.getElementById('pagination_number');
            paginationContainer.innerHTML = '';

            let html = '<ul class="pagination">';

            // Prev
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

            if (startPage > 1) {
                html += `<li><a href="?page=1" class="page-link">1</a></li>`;
                if (startPage > 2) {
                    html += `<li class="disabled"><a href="#" class="page-link">...</a></li>`;
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                html += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a href="?page=${i}" class="page-link">${i}</a>
            </li>
        `;
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    html += `<li class="disabled"><a href="#" class="page-link">...</a></li>`;
                }
                html += `<li><a href="?page=${totalPages}" class="page-link">${totalPages}</a></li>`;
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

            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = new URL(link.href).searchParams.get('page') || 1;
                    updateUrl(page);
                });
            });
        }

        // Gọi ban đầu khi load trang
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);

            // Nếu chưa có page thì gán page=1
            if (!urlParams.has('page')) {
                urlParams.set('page', '1');
                history.replaceState(null, '', '?' + urlParams.toString());
            }

            // Gọi API lấy danh mục
            fetchCategoriesFromServer(urlParams);
        };
    </script>

</body>

</html>