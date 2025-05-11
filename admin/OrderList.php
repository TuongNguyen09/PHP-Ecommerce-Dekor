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
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font_Roboto/Roboto-Bold.ttf">
    <link rel="stylesheet" href="../assets/css/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <script src="../assets/js/jquery.min.js"></script>
    <link rel="stylesheet" href="../../../css/style.css">
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/cart.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="../assets/css/orderDetail.css">

    <title>Quản lý đơn hàng</title>
</head>

<body>
    <?php
    include './Header.php';
    ?>

    <div class="content">
        <div class="row">
            <div class="title col-12 box_shadow">
                <b>Quản lý đơn hàng</b>
            </div>
        </div>
        <div class="row main_frame box_card box_shadow">
            <!-- <div class="element_btn">
                <div>
                    <a href="" class="addnew"><i class="fas fa-plus"></i>tạo mới sản phẩm</a>
                </div>
            </div> -->
            <!-- <div class="tab">
                <select class="form-select">
                    <option class="tab_item" id="a" onclick="changeTime('past1M', this)" selected>1 tháng vừa qua</option>
                    <option class="tab_item" id="b" onclick="changeTime('past3M', this)">3 tháng vừa qua</option>
                    <option class="tab_item" id="c" onclick="changeTime('past1Y', this)">1 năm vừa qua</option>
                </select>
            </div> -->
            <!-- <ul class="tab">
                <li class="tab_item active_tab" onclick="changeTime('past1M', this)">1 tháng vừa qua</li>
                <li class="tab_item" onclick="changeTime('past3M', this)">3 tháng vừa qua</li>
                <li class="tab_item" onclick="changeTime('past1Y', this)">1 năm vừa qua</li>
            </ul> -->
            <ul class="tab">
                <li class="tab_item active_tab" onclick="openTab('dateFilter', this)">Lọc theo ngày</li>
                <li class="tab_item" onclick="openTab('statusFilter', this)">Lọc theo tình trạng</li>
                <li class="tab_item" onclick="openTab('addressFilter', this)">Lọc theo địa chỉ</li>
            </ul>
            <div id="dateFilter" class="filter-container filter-date tab-content active">
                <div class="filter-group">
                    <label for="fromDate" class="filter-label">Từ ngày:</label>
                    <input type="date" class="filter-input" id="fromDate">
                </div>
                <div class="filter-group">
                    <label for="toDate" class="filter-label">Đến ngày:</label>
                    <input type="date" class="filter-input" id="toDate">
                </div>
                <button id="filterByTime" class="filter-button">Lọc</button>
            </div>

            <div id="statusFilter" class="filter-status tab-content">
                <label class="filter-label" for="status">Chọn tình trạng:</label>
                <select class="filter-input" id="status" style="background-color:#fff;">
                    <option value="Tất cả">Tất cả</option>
                    <option value="Chưa xử lý">Chưa xử lý</option>
                    <option value="Đã xác nhận">Đã xác nhận</option>
                    <option value="Đã giao thành công">Đã giao thành công</option>
                    <option value="Đã hủy">Đã hủy</option>
                </select>
                <button id="filterByStatus" class="filter-button">Lọc</button>
            </div>

            <div id="addressFilter" class="filter-status tab-content">
                <div class="filter-group" style="width:33%">
                    <label for="city" class="filter-label">Tỉnh/Thành:</label>
                    <select class="filter-input" style="width:90%" id="city">
                        <option value="--Chọn Tỉnh/Thành--">--Chọn Tỉnh/Thành--</option>
                        <!-- Add other options here -->
                    </select>
                </div>
                <div class="filter-group" style="width:33%">
                    <label for="district" class="filter-label">Quận/Huyện:</label>
                    <select class="filter-input" style="width:90%" id="district">
                        <option value="--Chọn Quận/Huyện--">--Chọn Quận/Huyện--</option>
                        <!-- Add other options here -->
                    </select>
                </div>
                <div class="filter-group" style="width:33%">
                    <label for="ward" class="filter-label">Phường/Xã:</label>
                    <select class="filter-input" style="width:90%" id="ward">
                        <option value="--Chọn Phường/Xã--">--Chọn Phường/Xã--</option>
                        <!-- Add other options here -->
                    </select>
                </div>
                <button id="filterByAddress" class="filter-button">Lọc</button>
            </div>



            <div class="table-responsive-lg">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">ID đơn hàng</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Ngày đặt</th>
                            <th scope="col">Ngày giao</th>
                            <th scope="col">Tình trạng</th>
                            <th scope="col">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody id="order_list">
                        <tr>
                            <td>#ĐH1</td>
                            <td>Nguyễn Văn A</td>
                            <td>123 Đường Lê Lợi, Phường Bến Nghé, Quận 1, Thành phố Hồ Chí Minh</td>
                            <td>2023-10-01</td>
                            <td>Chưa giao</td>
                            <td>Chưa xử lý</td>
                            <td><button onclick="showOrderDetails(1)" class="btn btn-primary btn-sm btn-detail"
                                    type="button" data-order-id="1" title="Xem chi tiết">Xem chi tiết</button></td>
                        </tr>
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

    <div class="overlay" id="orderOverlay" style="display: none;">
        <div class="order-detail-form">
            <h3 id="titleDetail">CHI TIẾT ĐƠN HÀNG</h2>

                <!-- Thông tin người dùng -->
                <div class="form-group">
                    <label for="name">Họ Tên:</label>
                    <input type="text" id="name" value="" disabled>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" value="" disabled>
                </div>

                <div class="form-group">
                    <label for="phone">Số Điện Thoại:</label>
                    <input type="tel" id="phone" value="" disabled>
                </div>

                <div class="form-group">
                    <label for="dateOrder">Ngày Đặt:</label>
                    <input disabled type="date" id="dateOrder" value="">
                </div>

                <div class="form-group">
                    <label for="dateDeliver">Ngày Giao:</label>
                    <input type="date" id="dateDeliver" value="">
                </div>

                <div class="form-group">
                    <label for="status">Tình Trạng:</label>
                    <select id="status-select" style="background-color:#fff;">
                        <option value="Chưa xử lý">Chưa xử lý</option>
                        <option value="Đã xác nhận">Đã xác nhận</option>
                        <option value="Đã giao thành công">Đã giao thành công</option>
                        <option value="Đã hủy">Đã hủy</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="payment">Hình Thức Thanh Toán:</label>
                    <input type="text" id="payment" value="" disabled>
                </div>

                <div class="form-group">
                    <label for="address">Địa Chỉ:</label>
                    <input type="text" id="address" value="" disabled>
                </div>


                <!-- Danh sách sản phẩm -->
                <h3>Sản Phẩm Đơn Hàng</h3>
                <table class="order-products-table">
                    <thead>
                        <tr>
                            <th>Hình Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Số Lượng</th>
                            <th>Thành Tiền</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

                <div class="order-summary">
                    <div class="summary-row">
                        <span>Tổng tiền hàng:</span>
                        <span></span>
                    </div>
                    <div class="summary-row">
                        <span>Phí vận chuyển:</span>
                        <span></span>
                    </div>
                    <div class="summary-row">
                        <span><strong>Tổng tiền:</strong></span>
                        <span><strong></strong></span>
                    </div>
                </div>

                <!-- Nút đóng form -->
                <div class="buttonDetail">
                    <button id="saveButton">Cập nhật</button>
                    <button id="closeButton">Đóng</button>
                </div>
        </div>
    </div>



    <!-- ----------------------- Script ----------------------- -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../bootstrap-5.2.2-dist/js/bootstrap.bundle.js"></script>
    <script src="../../js/jquery.min.js"></script>
    <script>
        function openTab(tabId, element) {
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.remove('active'));

            document.getElementById(tabId).classList.add('active');

            const tabs = document.querySelectorAll('.tab_item');
            tabs.forEach(tab => tab.classList.remove('active_tab'));

            element.classList.add('active_tab');
        }

        function closeOrderDetail() {
            document.getElementById("orderOverlay").style.display = "none"; // Ẩn form
        }

        document.getElementById("closeButton").addEventListener("click", closeOrderDetail);
        let currentOrderId = null;

        function showOrderDetails(orderId) {
            currentOrderId = orderId;
            fetch(`../controllers/OrderController.php?action=getOrderDetails&id=${orderId}`)
                .then(res => res.text())
                .then(text => {
                    let data;
                    try {
                        data = JSON.parse(text); // Thử parse JSON
                    } catch (e) {
                        // Nếu không phải JSON => hiển thị lỗi thô
                        alert('Lỗi không phải JSON:\n' + text);
                        console.error('Phản hồi không hợp lệ:', text);
                        return;
                    }

                    if (data.status === 'error') {
                        alert(data.message);
                        return;
                    }

                    const order = data;

                    // Hiển thị thông tin như cũ
                    document.getElementById('name').value = order.fullname;
                    document.getElementById('email').value = order.email;
                    document.getElementById('phone').value = order.phone;
                    document.getElementById('dateOrder').value = order.order_date;
                    document.getElementById('dateDeliver').value = order.delivery_date || '';
                    document.getElementById('status-select').value = order.status;
                    document.getElementById('payment').value = order.payment_method;
                    document.getElementById('address').value = order.address || 'Chưa có địa chỉ';

                    let totalAmount = 0;
                    const productsTableBody = document.querySelector('.order-products-table tbody');
                    productsTableBody.innerHTML = '';
                    order.products.forEach(product => {
                        const row = document.createElement('tr');
                        const productTotal = product.price * product.quantity;
                        totalAmount += productTotal;

                        row.innerHTML = `
                    <td><img src="../uploads/products/${product.image_url}" alt="${product.name}" style="width: 50px; height: 50px;"></td>
                    <td>${product.name}</td>
                    <td>${product.quantity}</td>
                    <td>${productTotal.toLocaleString()} VND</td>
                `;
                        productsTableBody.appendChild(row);
                    });

                    const shippingFee = order.shipping_fee || 0;
                    const finalAmount = totalAmount + shippingFee;
                    const summaryRows = document.querySelectorAll('.order-summary .summary-row span:nth-child(2)');
                    summaryRows[0].textContent = totalAmount.toLocaleString() + ' VND';
                    summaryRows[1].textContent = shippingFee.toLocaleString() + ' VND';
                    summaryRows[2].textContent = finalAmount.toLocaleString() + ' VND';

                    document.getElementById('orderOverlay').style.display = 'flex';
                })
                .catch(error => {
                    alert('Lỗi máy chủ:\n' + error.message);
                    console.error('Lỗi:', error);
                });
        }



        // Đóng form chi tiết đơn hàng
        document.getElementById('closeButton').addEventListener('click', () => {
            document.getElementById('orderOverlay').style.display = 'none';
        });


        document.querySelectorAll('.btn-view-order').forEach(button => {
            button.addEventListener('click', function() {
                currentOrderId = this.getAttribute('data-id');

                // Mở form và load dữ liệu từ server
                document.getElementById('orderOverlay').style.display = 'block';

                // (Gợi ý) Gửi request lấy chi tiết order và điền vào form tại đây...
            });
        });


        // Cập nhật thông tin đơn hàng (Nếu cần)
        document.getElementById('saveButton').addEventListener('click', function() {
            const orderId = currentOrderId;
            const newStatus = document.getElementById('status-select').value;
            console.log(orderId);
            console.log(newStatus);

            fetch('../controllers/OrderController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json', // Sửa lại content-type
                    },
                    body: JSON.stringify({
                        action: 'updateStatus',
                        orderId: orderId,
                        newStatus: newStatus
                    })
                })
                .then(response => response.json()) // Sử dụng response.json() thay vì response.text()
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message); // Hiển thị thông báo từ server
                        document.getElementById('orderOverlay').style.display = 'none';
                        // Có thể reload lại danh sách đơn hàng nếu cần
                    } else {
                        alert(data.message); // Nếu có lỗi, hiển thị thông báo lỗi từ server
                    }
                })
                .catch(error => {
                    console.error('Lỗi cập nhật:', error);
                    alert('Đã xảy ra lỗi');
                });
        });




        function renderOrders(orders) {
            const tbody = document.querySelector('#order_list');
            tbody.innerHTML = ''; // Xóa bảng trước khi render lại

            if (!orders || orders.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td colspan="7" style="text-align: center; color: red;">Không tìm thấy đơn hàng phù hợp</td>
        `;
                tbody.appendChild(row);
                return;
            }

            orders.forEach(order => {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td>#${order.id}</td>
            <td>${order.user.fullname}</td>
            <td style="width:200px">${order.address_detail}</td>
            <td>${order.order_date}</td>
            <td>${order.delivery_date ? order.delivery_date : 'Chưa giao'}</td>
            <td>${order.status}</td>
            <td>
                <button onclick="showOrderDetails(${order.id})" class="btn btn-primary btn-sm btn-detail"
                        type="button" title="Xem chi tiết" >Xem chi tiết</button>
            </td>
        `;
                tbody.appendChild(row);
            });
        }


        // Lọc theo thời gian
        document.getElementById('filterByTime').addEventListener('click', function() {
            const fromDate = document.getElementById('fromDate').value;
            const toDate = document.getElementById('toDate').value;

            const params = new URLSearchParams(window.location.search); // Dùng từ URL hiện tại

            if (fromDate && fromDate !== '') {
                params.set('fromDate', fromDate);
                params.delete('status'); // Xóa tham số status nếu có
                params.delete('city'); // Xóa tham số city nếu có
                params.delete('district'); // Xóa tham số district nếu có
                params.delete('ward'); // Xóa tham số ward nếu có
            } else {
                params.delete('fromDate');
            }

            if (toDate && toDate !== '') {
                params.set('toDate', toDate);
                params.delete('status'); // Xóa tham số status nếu có
                params.delete('city'); // Xóa tham số city nếu có
                params.delete('district'); // Xóa tham số district nếu có
                params.delete('ward'); // Xóa tham số ward nếu có
            } else {
                params.delete('toDate');
            }

            params.set('page', 1); // Reset về trang đầu sau khi lọc

            updateUrl(params);
        });

        // Lọc theo tình trạng
        document.getElementById('filterByStatus').addEventListener('click', function() {
            const status = document.getElementById('status').value;

            const params = new URLSearchParams(window.location.search); // Giữ lại các params khác

            if (status && status !== 'Tất cả') {
                params.set('status', status);
                params.delete('fromDate'); // Xóa tham số fromDate nếu có
                params.delete('toDate'); // Xóa tham số toDate nếu có
                params.delete('city'); // Xóa tham số city nếu có
                params.delete('district'); // Xóa tham số district nếu có
                params.delete('ward'); // Xóa tham số ward nếu có
            } else {
                params.delete('status');
            }

            params.set('page', 1); // Reset về trang đầu

            updateUrl(params);
        });

        // Lọc theo địa chỉ
        document.getElementById('filterByAddress').addEventListener('click', function() {
            const city = document.getElementById('city').selectedOptions[0].textContent;
            const district = document.getElementById('district').selectedOptions[0].textContent;
            const ward = document.getElementById('ward').selectedOptions[0].textContent;

            const params = new URLSearchParams(window.location.search); // Giữ lại các params khác

            if (city && city !== '--Chọn Tỉnh/Thành--') {
                params.set('city', city);
                params.delete('fromDate'); // Xóa tham số fromDate nếu có
                params.delete('toDate'); // Xóa tham số toDate nếu có
                params.delete('status'); // Xóa tham số status nếu có
                params.delete('district'); // Xóa tham số district nếu có
                params.delete('ward'); // Xóa tham số ward nếu có
            } else {
                params.delete('city');
            }

            if (district && district !== '--Chọn Quận/Huyện--') {
                params.set('district', district);
                params.delete('fromDate'); // Xóa tham số fromDate nếu có
                params.delete('toDate'); // Xóa tham số toDate nếu có
                params.delete('status'); // Xóa tham số status nếu có
                params.delete('city'); // Xóa tham số city nếu có
                params.delete('ward'); // Xóa tham số ward nếu có
            } else {
                params.delete('district');
            }

            if (ward && ward !== '--Chọn Phường/Xã--') {
                params.set('ward', ward);
                params.delete('fromDate'); // Xóa tham số fromDate nếu có
                params.delete('toDate'); // Xóa tham số toDate nếu có
                params.delete('status'); // Xóa tham số status nếu có
                params.delete('city'); // Xóa tham số city nếu có
                params.delete('district'); // Xóa tham số district nếu có
            } else {
                params.delete('ward');
            }

            params.set('page', 1); // Reset về trang đầu

            updateUrl(params);
        });

        // Lọc theo địa chỉ
        document.getElementById('filterByAddress').addEventListener('click', function() {
            const city = document.getElementById('city').selectedOptions[0].textContent;
            const district = document.getElementById('district').selectedOptions[0].textContent;
            const ward = document.getElementById('ward').selectedOptions[0].textContent;

            const params = new URLSearchParams(window.location.search); // Giữ lại các params khác

            if (city && city !== '--Chọn Tỉnh/Thành--') {
                params.set('city', city);
            } else {
                params.delete('city');
            }

            if (district && district !== '--Chọn Quận/Huyện--') {
                params.set('district', district);
            } else {
                params.delete('district');
            }

            if (ward && ward !== '--Chọn Phường/Xã--') {
                params.set('ward', ward);
            } else {
                params.delete('ward');
            }

            params.set('page', 1); // Reset về trang đầu

            updateUrl(params);
        });





        function fetchOrdersFromServer(params) {
            // Kiểm tra nếu có product_id trên URL và thêm vào params
            const urlParams = new URLSearchParams(window.location.search); // Lấy các tham số từ URL hiện tại
            if (urlParams.has('product_id')) {
                const productId = urlParams.get('product_id');
                params.set('product_id', productId); // Thêm product_id vào params nếu có
            }

            const queryString = params.toString(); // Tạo query string từ params
            console.log("Fetching orders with params:", queryString);

            fetch(`../controllers/OrderController.php?action=listOrders&${queryString}`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return res.text(); // Nhận dữ liệu dưới dạng văn bản thay vì JSON
                })
                .then(data => {
                    console.log("Fetched data:", data);

                    if (data.startsWith("Error:")) {
                        console.error("Error fetching orders:", data); // Hiển thị thông báo lỗi nếu có
                    } else {
                        try {
                            const jsonData = JSON.parse(data);
                            if (Array.isArray(jsonData.orders)) {
                                renderOrders(jsonData.orders); // Gọi hàm renderOrders nếu data.orders là mảng
                            } else {
                                console.error("Dữ liệu đơn hàng không phải là mảng:", jsonData);
                            }

                            // Kiểm tra và cập nhật trang hiện tại nếu cần
                            if (jsonData.totalPages < params.get('page')) {
                                params.set('page', jsonData.totalPages || 1); // Đặt trang về trang hợp lệ
                                history.replaceState(null, '', '?' + params.toString());
                            }

                            renderPagination(jsonData.totalPages, params.get('page'));
                        } catch (e) {
                            console.error("Error parsing JSON response:", e);
                        }
                    }
                })
                .catch(error => console.error('Fetch error:', error));
        }

        function updateUrl(params) {
            // Cập nhật URL với các tham số mới
            history.pushState(null, '', '?' + params.toString());

            // Gọi lại API với tham số mới
            fetchOrdersFromServer(params);
        }



        // Phân trang
        function renderPagination(totalPages, currentPage) {
            const paginationContainer = document.getElementById('pagination_number');
            paginationContainer.innerHTML = '';

            currentPage = parseInt(currentPage);

            let html = '<ul class="pagination">';

            html += `
        <li style="z-index:0" class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a href="#" data-page="${currentPage - 1}" class="page-link">
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
            <li style="z-index:0" class="page-item ${i === currentPage ? 'active' : ''}">
                <a href="#" data-page="${i}" class="page-link">${i}</a>
            </li>
        `;
            }

            html += `
        <li style="z-index:0" class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a href="#" data-page="${currentPage + 1}" class="page-link">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
    `;

            html += '</ul>';
            paginationContainer.innerHTML = html;

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

        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);

            if (!urlParams.has('page')) {
                urlParams.set('page', '1');
                history.replaceState(null, '', '?' + urlParams.toString());
            }

            fetchOrdersFromServer(urlParams);
        };
        async function fetchProvinces() {
            try {
                const response = await fetch('https://provinces.open-api.vn/api/?depth=1');
                if (!response.ok) throw new Error('Failed to fetch provinces');
                const data = await response.json();
                const citySelect = document.getElementById('city');
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.code;
                    option.textContent = province.name;
                    citySelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error fetching provinces:', error);
            }
        }

        // Fetch districts (Quận/Huyện)
        async function fetchDistricts(provinceCode) {
            const districtSelect = document.getElementById('district');
            districtSelect.innerHTML = '<option value="">--Chọn Quận/Huyện--</option>';
            districtSelect.disabled = true;
            if (provinceCode) {
                try {
                    const response = await fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`);
                    if (!response.ok) throw new Error('Failed to fetch districts');
                    const data = await response.json();
                    districtSelect.disabled = false;
                    data.districts.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.code;
                        option.textContent = district.name;
                        districtSelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error fetching districts:', error);
                }
            }
        }

        // Fetch wards (Phường/Xã)
        async function fetchWards(districtCode) {
            const wardSelect = document.getElementById('ward');
            wardSelect.innerHTML = '<option value="">--Chọn Phường/Xã--</option>';
            wardSelect.disabled = true;
            if (districtCode) {
                try {
                    const response = await fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`);
                    if (!response.ok) throw new Error('Failed to fetch wards');
                    const data = await response.json();
                    wardSelect.disabled = false;
                    data.wards.forEach(ward => {
                        const option = document.createElement('option');
                        option.value = ward.code;
                        option.textContent = ward.name;
                        wardSelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error fetching wards:', error);
                }
            }
        }

        // Setup event listeners for address selection
        function setupAddressSelection() {
            const citySelect = document.getElementById('city');
            const districtSelect = document.getElementById('district');
            const wardSelect = document.getElementById('ward');

            citySelect.addEventListener('change', () => {
                const provinceCode = citySelect.value;
                if (provinceCode) {
                    fetchDistricts(provinceCode);
                    districtSelect.disabled = false;
                } else {
                    districtSelect.innerHTML = '<option value="">--Chọn Quận/Huyện--</option>';
                    districtSelect.disabled = true;
                    wardSelect.innerHTML = '<option value="">--Chọn Phường/Xã--</option>';
                    wardSelect.disabled = true;
                }
            });

            districtSelect.addEventListener('change', () => {
                const districtCode = districtSelect.value;
                if (districtCode) {
                    fetchWards(districtCode);
                    wardSelect.disabled = false;
                } else {
                    wardSelect.innerHTML = '<option value="">--Chọn Phường/Xã--</option>';
                    wardSelect.disabled = true;
                }
            });
        }

        // Initialize form with provinces
        document.addEventListener('DOMContentLoaded', () => {
            fetchProvinces();
            setupAddressSelection();
        });
    </script>

</body>

</html>