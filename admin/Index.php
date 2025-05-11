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
    <link rel="stylesheet" href="../assets/css/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <script src="../../js/jquery.min.js"></script>
    <link rel="stylesheet" href="../../../css/style.css">
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/cart.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <title>Admin</title>
</head>

<body>
    <?php
    include './Header.php';
    ?>

    <div class="content">
        <div class="row">
            <div class="title col-12 box_shadow">
                <b>Trang chủ</b>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="statistic-admin" class="row">
                    <div class="col-sm-6">
                        <div class="box_summary box_card box_shadow mb-3">
                            <div class="card-header">TỔNG KHÁCH HÀNG</div>
                            <div class="card-body">
                                <a href="./data_user.html" class="card-title">10 khách hàng</a>
                                <p class="card-text">Tổng số khách hàng được quản lý.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="box_summary box_card box_shadow mb-3">
                            <div class="card-header">TỔNG SẢN PHẨM</div>
                            <div class="card-body">
                                <a href="./data_product.html" class="card-title">32 sản phẩm</a>
                                <p class="card-text">Tổng số sản phẩm được quản lý.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="box_summary box_card box_shadow mb-3">
                            <div class="card-header">TỔNG ĐƠN HÀNG</div>
                            <div class="card-body">
                                <a href="./data_oder.html" class="card-title">15 đơn hàng</a>
                                <p class="card-text">Tổng số hóa đơn bán hàng trong tháng.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="box_summary box_card box_shadow mb-3">
                            <div class="card-header">SẮP HẾT HÀNG</div>
                            <div class="card-body">
                                <a href="#non-amount-product" class="card-title">6 sản phẩm</a>
                                <p class="card-text">Số sản phẩm cảnh báo hết cần nhập thêm.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row main_frame box_card box_shadow">
            <div class="top_title_table">
                <h4>SẢN PHẨM BÁN CHẠY</h4>
                <hr>
            </div>
            <div id="dateFilter" class="filter-container filter-date tab-content active" style="margin: 6px 0 6px 0;">
                <div class="filter-group">
                    <label for="fromDate-Products" class="filter-label">Từ ngày:</label>
                    <input type="date" class="filter-input" id="fromDate-Products">
                </div>
                <div class="filter-group">
                    <label for="toDate-Products" class="filter-label">Đến ngày:</label>
                    <input type="date" class="filter-input" id="toDate-Products">
                </div>
                <button id="filterProductsButton" class="filter-button">Lọc</button>
            </div>
            <div class="table-responsive-lg table-statistic">
                <table class="table table-bordered" id="table-product-revenue">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">Mã sản phẩm</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá tiền</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Số lượng bán ra</th>
                            <th scope="col">Tổng doanh thu</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ban3</td>
                            <td>Bàn tròn kính</td>
                            <td>23.000.000</td>
                            <td>Bàn gỗ</td>
                            <td>6</td>
                            <td>138.000.000 VND</td>
                            <td>
                                <a href="./orderlist.php" class="btn btn-danger btn-sm">Xem đơn hàng</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row main_frame box_card box_shadow">
            <div class="top_title_table">
                <h4>KHÁCH HÀNG</h4>
                <hr>
            </div>
            <div id="dateFilter" class="filter-container filter-date tab-content active" style="margin: 6px 0 6px 0;">
                <div class="filter-group">
                    <label for="fromDate-Users" class="filter-label">Từ ngày:</label>
                    <input type="date" class="filter-input" id="fromDate-Users">
                </div>
                <div class="filter-group">
                    <label for="toDate-Users" class="filter-label">Đến ngày:</label>
                    <input type="date" class="filter-input" id="toDate-Users">
                </div>
                <button id="filterUsersButton" class="filter-button">Lọc</button>
            </div>

            <div class="table-responsive-lg table-statistic">
                <table class="table table-bordered" id="table-users-revenue">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">Họ tên</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Email</th>
                            <th scope="col">Tổng doanh thu</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Đặng Xuân Minh</td>
                            <td>9845631234</td>
                            <td>BookShopOnline@gmail.com</td>
                            <td>87,910,000 VND</td>
                            <td>
                                <a href="./orderlist.php?id=5" class="btn btn-danger btn-sm">Xem đơn hàng</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="content" id="non-amount-product">
        <div class="row main_frame box_card box_shadow">
            <div class="top_title_table">
                <h4>SẢN PHẨM SẮP HẾT</h4>
                <hr>
            </div>
            <div class="table-responsive-lg">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">Mã sản phẩm</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá tiền</th>
                        </tr>
                    </thead>
                    <tbody id="lowStockBody">
                        <tr>
                            <td>giuong3</td>
                            <td>Giường ngủ FURNILAND - Jangin Christine (1m8)</td>
                            <td>Giường ngủ</td>
                            <td>4</td>
                            <td>12.000.000 VND</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- ----------------------- Script ----------------------- -->
    <script src="../../bootstrap-5.2.2-dist/js/bootstrap.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <script src="../../js/jquery.min.js"></script>
    <script>
        function renderLowStockProducts() {
            fetch('../controllers/ProductController.php?action=getLowStockProducts')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('lowStockBody');
                    tbody.innerHTML = '';

                    if (data.length === 0) {
                        const row = document.createElement('tr');
                        const cell = document.createElement('td');
                        cell.setAttribute('colspan', '5');
                        cell.classList.add('text-center');
                        cell.textContent = 'Không có sản phẩm nào sắp hết hàng';
                        row.appendChild(cell);
                        tbody.appendChild(row);
                        return;
                    }

                    data.forEach(product => {
                        const row = document.createElement('tr');

                        row.innerHTML = `
                    <td>${product.id}</td>
                    <td>${product.name}</td>
                    <td>${product.category_name}</td>
                    <td>${product.stock}</td>
                    <td>${parseInt(product.price).toLocaleString('vi-VN')} VND</td>
                `;

                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error loading low stock products:', error);
                });
        }

        // Gọi hàm khi trang tải
        document.addEventListener('DOMContentLoaded', renderLowStockProducts);

        document.getElementById('filterProductsButton').addEventListener('click', function() {
            renderProductsTableFromServer();
        });
        renderProductsTableFromServer();

        function renderProductsTableFromServer() {
            // Lấy giá trị từ các trường input
            const fromDate = document.getElementById('fromDate-Products').value;
            const toDate = document.getElementById('toDate-Products').value;

            // Tạo đối tượng chứa dữ liệu lọc
            const formData = new FormData();
            formData.append('fromDate', fromDate);
            formData.append('toDate', toDate);
            formData.append('action', 'topProducts'); // Thêm action vào formData

            // Gọi API qua Fetch để lấy dữ liệu
            fetch('../controllers/ProductController.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text()) // Đọc phản hồi dưới dạng văn bản
                .then(text => {
                    let data;
                    try {
                        // Thử chuyển đổi phản hồi sang JSON
                        data = JSON.parse(text);
                    } catch (error) {
                        // Nếu không thể parse thành JSON, thông báo lỗi
                        console.error('Error parsing JSON:', error);
                        alert('Lỗi: Không nhận được dữ liệu hợp lệ từ server. Phản hồi: ' + text);
                        return;
                    }

                    // Xử lý kết quả trả về từ controller
                    if (data.status === 'success') {
                        const products = data.data;
                        renderProductsTable(products);
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã có lỗi xảy ra.');
                });
        }

        function renderProductsTable(products) {
            const tableBody = document.getElementById('table-product-revenue').getElementsByTagName('tbody')[0];
            console.log(tableBody);
            // Xóa dữ liệu cũ
            tableBody.innerHTML = '';

            // Lặp qua danh sách sản phẩm và tạo các dòng trong bảng
            products.forEach(product => {
                const row = document.createElement('tr');

                // Tạo các ô dữ liệu
                const cells = [
                    product.id,
                    product.name,
                    product.price,
                    product.category_name,
                    product.total_sold,
                    product.total_revenue.toLocaleString('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    }) // Định dạng total_revenue
                ];

                cells.forEach(cellData => {
                    const cell = document.createElement('td');
                    cell.textContent = cellData;
                    row.appendChild(cell);
                });

                // Thêm cột "Xem đơn hàng"
                const viewOrderCell = document.createElement('td');
                const viewOrderLink = document.createElement('a');
                viewOrderLink.href = `./orderlist.php?product_id=${product.id}`; // Link đến trang xem đơn hàng
                viewOrderLink.classList.add('btn', 'btn-danger', 'btn-sm');
                viewOrderLink.textContent = 'Xem đơn hàng';
                viewOrderCell.appendChild(viewOrderLink);
                row.appendChild(viewOrderCell);

                // Thêm dòng vào bảng
                tableBody.appendChild(row);
            });
        }

        document.getElementById('filterUsersButton').addEventListener('click', function() {
            renderUsersTableFromServer();
        });
        renderUsersTableFromServer();

        function renderUsersTableFromServer() {
            // Lấy giá trị từ các trường input
            const fromDate = document.getElementById('fromDate-Users').value;
            const toDate = document.getElementById('toDate-Users').value;

            // Tạo đối tượng chứa dữ liệu lọc
            const formData = new FormData();
            formData.append('fromDate', fromDate);
            formData.append('toDate', toDate);
            formData.append('action', 'topSpendingUsers'); // Thêm action vào formData

            // Gọi API qua Fetch để lấy dữ liệu
            fetch('../controllers/UserController.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text()) // Đọc phản hồi dưới dạng văn bản
                .then(text => {
                    let data;
                    try {
                        // Thử chuyển đổi phản hồi sang JSON
                        data = JSON.parse(text);
                    } catch (error) {
                        // Nếu không thể parse thành JSON, thông báo lỗi
                        console.error('Error parsing JSON:', error);
                        alert('Lỗi: Không nhận được dữ liệu hợp lệ từ server. Phản hồi: ' + text);
                        return;
                    }

                    // Xử lý kết quả trả về từ controller
                    if (data.status === 'success') {
                        const users = data.data;
                        renderUsersTable(users);
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã có lỗi xảy ra.');
                });
        }

        function renderUsersTable(users) {
            const tableBody = document.getElementById('table-users-revenue').getElementsByTagName('tbody')[0];

            // Xóa dữ liệu cũ
            tableBody.innerHTML = '';

            // Lặp qua danh sách khách hàng và tạo các dòng trong bảng
            users.forEach(user => {
                const row = document.createElement('tr');

                // Tạo các ô dữ liệu
                const cells = [
                    user.fullname,
                    user.phone,
                    user.email,
                    user.total_revenue.toLocaleString('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    })
                ];

                cells.forEach(cellData => {
                    const cell = document.createElement('td');
                    cell.textContent = cellData;
                    row.appendChild(cell);
                });

                // Thêm cột "Xem đơn hàng"
                const viewOrderCell = document.createElement('td');
                const viewOrderLink = document.createElement('a');
                viewOrderLink.href = `./orderlist.php?user_id=${user.id}`; // Link đến trang xem đơn hàng
                viewOrderLink.classList.add('btn', 'btn-danger', 'btn-sm');
                viewOrderLink.textContent = 'Xem đơn hàng';
                viewOrderCell.appendChild(viewOrderLink);
                row.appendChild(viewOrderCell);

                // Thêm dòng vào bảng
                tableBody.appendChild(row);
            });
        }
    </script>
</body>

</html>