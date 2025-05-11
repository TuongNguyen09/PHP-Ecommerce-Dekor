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
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.2.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font_Roboto/Roboto-Bold.ttf">
    <link rel="stylesheet" href="../assets/css/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <title>Quản lý sản phẩm</title>
</head>
<style>
    .hidden-product {
        opacity: 0.5;
        background-color: #f8d7da;
    }
</style>

<body>
    <?php
    include './Header.php';
    ?>

    <div class="content">
        <div class="row">
            <div class="title col-12 box_shadow">
                <b>Quản lý sản phẩm</b>
            </div>
        </div>
        <div class="row main_frame box_card box_shadow">
            <div class="element_btn">
                <div>
                    <a href="./FormProduct.php" class="addnew_button"><i class="fas fa-plus"></i>Thêm mới sản phẩm</a>
                </div>
            </div>
            <div id="statusFilter" class="filter-status tab-content active">
                <label class="filter-label" for="category">Chọn sản phẩm:</label>
                <select class="filter-input" id="category">
                    <option value="all">Tất cả sản phẩm</option>
                    <option value="Bàn gỗ">Bàn gỗ</option>
                    <option value="Kệ sách">Kệ sách</option>
                    <option value="Rèm cửa">Rèm cửa</option>
                    <option value="Ghế sofa">Ghế sofa</option>
                    <option value="Tủ quần áo">Tủ quần áo</option>
                    <option value="Giường ngủ">Giường ngủ</option>
                    <option value="Phòng tắm">Phòng tắm</option>
                    <option value="Đèn trang trí">Đèn trang trí</option>
                </select>
                <button class="filter-button">Lọc</button>
            </div>
            <div class="table-responsive-lg">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">Mã sản phẩm</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tình trạng</th>
                            <th scope="col">Giá tiền</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody id="product_order">
                        <tr>
                            <td>ban1</td>
                            <td>Bàn cafe tròn gỗ đẹp</td>
                            <td><img src="/img/category/Ban/cafe-tron-go-dep.png"></td>
                            <td>23</td>
                            <td>Còn hàng</td>
                            <td>4.500.000</td>
                            <td>Bàn</td>
                            <td>
                                <button class="btn btn-primary btn-sm trash" type="button" title="Xóa" onclick="myFunction(this)"><i class="fas fa-trash-alt"></i></button>
                                <button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp" data-toggle="modal" data-target="#ModalUP"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="category_paging">
                <ul class="pagination" id="pagination_number">
                    <!-- <li class="page-item page_btn_prev"><a class="page-link"><i class="fas fa-chevron-left"></i></a></li>
                    <div class="pagination number_page" id="number_page">
                        <li class="active"><a class="page-link">1</a></li>
                        <li><a class="page-link">2</a></li>
                        <li><a class="page-link">3</a></li>
                    </div>
                    <li class="page-item page_btn_next"><a class="page-link"><i class="fas fa-chevron-right"></i></a></li> -->
                </ul>
            </div>
        </div>
    </div>




    <!-- ----------------------- Script ----------------------- -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="../../bootstrap-5.2.2-dist/js/bootstrap.bundle.js"></script>
    <script src="../../js/jquery.min.js"></script>
    <script>
        function updateUrl(params) {
            const currentParams = new URLSearchParams(window.location.search);

            // Giữ nguyên các tham số hiện tại trong URL (bao gồm cả page)
            params.forEach((value, key) => {
                currentParams.set(key, value); // Cập nhật hoặc thêm các tham số mới vào URL
            });

            // Cập nhật URL với tất cả các tham số hiện tại
            history.pushState(null, '', '?' + currentParams.toString());

            // Gọi lại API với tham số mới
            fetchProductsFromServer(currentParams);
        }

        document.querySelector('#category').addEventListener('change', function() {
            let params = new URLSearchParams(window.location.search);
            params.set('category', this.value); // Thêm tham số category vào URL
            params.set('page', 1); // Đặt lại trang về 1 khi thay đổi category
            updateUrl(params); // Cập nhật URL và gọi lại API
        });


        function fetchProductsFromServer(params) {
            const queryString = params.toString(); // Tạo query string từ params
            console.log("Fetching with params:", queryString); // Log để kiểm tra các tham số

            fetch(`../controllers/ProductController.php?action=listProducts&${queryString}`)
                .then(res => res.json())
                .then(data => {
                    console.log("Fetched data:", data); // Log để kiểm tra dữ liệu trả về

                    if (Array.isArray(data.products)) {
                        renderProducts(data.products); // Gọi hàm renderProducts nếu data.products là mảng
                    } else {
                        console.error("Dữ liệu sản phẩm không phải là mảng:", data);
                    }

                    // Kiểm tra và cập nhật trang hiện tại nếu cần
                    if (data.totalPages < params.get('page')) {
                        params.set('page', data.totalPages || 1); // Đặt trang về trang hợp lệ (1 nếu không có)
                        history.replaceState(null, '', '?' + params.toString()); // Cập nhật URL mà không thêm lịch sử
                    }

                    renderPagination(data.totalPages, params.get('page'));
                })
                .catch(error => console.error('Fetch error:', error));
        }


        // Hiển thị dữ liệu sản phẩm ra bảng
        function renderProducts(products) {
            const tbody = document.querySelector('#product_order');
            tbody.innerHTML = ''; // Xóa bảng trước khi render lại

            products.forEach(product => {
                const row = document.createElement('tr');
                row.id = `product-${product.id}`;
                row.innerHTML = `
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td><img src="../uploads/products/${product.image}" alt="${product.name}" width="50"></td>
            <td>${product.stock}</td>
            <td>${product.status ? 'Còn hàng' : 'Hết hàng'}</td>
            <td>${parseInt(product.price).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</td>
            <td>${product.category_id}</td>
            <td>
                <button class="btn btn-primary btn-sm edit" onclick="editProduct(${product.id})">
                    <i class="fas fa-edit"></i>
                </button>

                ${product.is_hide == 1
                    ? `<button title="Mở bán" class="btn btn-success btn-sm unhide" onclick="unhideProduct(${product.id})">
                           <i class="fas fa-eye"></i>
                       </button>`
                    : `<button class="btn btn-danger btn-sm delete" onclick="deleteProduct(${product.id})">
                           <i class="fas fa-trash"></i>
                       </button>`
                }
            </td>
        `;
                tbody.appendChild(row);
            });
        }

        function unhideProduct(productId) {
            if (!confirm("Bạn có chắc chắn muốn mở bán lại sản phẩm này không?")) return;

            fetch('../controllers/ProductController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=unhideProduct&id=${productId}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert("Đã mở bán lại sản phẩm.");
                        location.reload(); // Tải lại trang
                    } else {
                        alert("Lỗi: " + data.error);
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                });
        }

        function deleteProduct(productId) {
            // Gửi request kiểm tra sản phẩm đã bán chưa
            fetch(`../controllers/ProductController.php?action=checkProductSold&id=${productId}`)
                .then(res => res.json())
                .then(result => {
                    if (result.sold) {
                        // Nếu đã bán -> chỉ được ẩn
                        if (confirm("Sản phẩm đã từng được bán, chỉ có thể chuyển sang trạng thái ẩn. Bạn có muốn tiếp tục?")) {
                            fetch('../controllers/ProductController.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: `action=hideProduct&id=${productId}`
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        alert("Đã chuyển sản phẩm sang trạng thái ẩn.");
                                        location.reload(); // Tải lại trang
                                    } else {
                                        alert("Lỗi: " + data.error);
                                    }
                                });
                        }
                    } else {
                        // Nếu chưa từng bán -> xóa bình thường
                        if (!confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) return;

                        fetch('../controllers/ProductController.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: `action=deleteProduct&id=${productId}`
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    const row = document.querySelector(`#product-${productId}`);
                                    if (row) row.remove();
                                    alert("Xóa sản phẩm thành công.");
                                } else {
                                    alert("Lỗi: " + data.error);
                                }
                            })
                            .catch(error => {
                                console.error('Lỗi:', error);
                            });
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi kiểm tra trạng thái sản phẩm:', error);
                });
        }

        function editProduct(id) {
            window.location.href = `./FormProduct.php?id=${id}`;
        }


        function renderPagination(totalPages, currentPage) {
            const paginationContainer = document.getElementById('pagination_number');
            paginationContainer.innerHTML = '';

            // Chuyển currentPage sang kiểu số nguyên
            currentPage = parseInt(currentPage);

            let html = '<ul class="pagination">';

            // Prev
            html += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a href="#" data-page="${currentPage - 1}" class="page-link">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>
    `;

            const maxVisiblePages = 5;
            const half = Math.floor(maxVisiblePages / 2);
            let startPage = Math.max(1, currentPage - half);
            let endPage = Math.min(totalPages, currentPage + half);

            if (startPage > 1) {
                html += `<li><a href="#" data-page="1" class="page-link">1</a></li>`;
                if (startPage > 2) {
                    html += `<li class="disabled"><a href="#" class="page-link">...</a></li>`;
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                html += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a href="#" data-page="${i}" class="page-link">${i}</a>
            </li>
        `;
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    html += `<li class="disabled"><a href="#" class="page-link">...</a></li>`;
                }
                html += `<li><a href="#" data-page="${totalPages}" class="page-link">${totalPages}</a></li>`;
            }

            html += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a href="#" data-page="${currentPage + 1}" class="page-link">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
    `;

            html += '</ul>';
            paginationContainer.innerHTML = html;

            // Cập nhật sự kiện cho các liên kết phân trang
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = parseInt(link.getAttribute('data-page'));
                    const params = new URLSearchParams(window.location.search);
                    params.set('page', page); // Cập nhật trang mới vào URL
                    updateUrl(params); // Cập nhật URL và gọi lại API
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

            // Gọi API lấy danh sách sản phẩm
            fetchProductsFromServer(urlParams);
        };
    </script>
</body>

</html>