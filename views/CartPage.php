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
    <title>Tạo Trang cart shopping</title>
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.2.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font_Roboto/Roboto-Bold.ttf">
    <link rel="stylesheet" href="../../css/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/cart.css">

</head>

<body>

    <?php
    include './templates/Header.php';
    ?>
    <!-- Block content - Đục lỗ trên giao diện bố cục chung, đặt tên là `content` -->
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">
                    <h2 class="cart-title">GIỎ HÀNG</h2>
                    <hr>

                    <!-- Shopping cart table -->
                    <div class="product-container">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th class="product-title">Sản Phẩm</th>
                                    <th class="product-price">Giá</th>
                                    <th class="product-quantity">SL</th>
                                    <th class="product-total">Thành tiền</th>
                                    <th class="product-action"></th>
                                </tr>
                            </thead>
                            <tbody class="product-in-cart">

                            </tbody>
                        </table>
                    </div>

                    <!-- End -->
                </div>
                <div class="link-bottom">
                    <div>
                        <a href="../../SanPham/html/category/product.html" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Tiếp tục mua</a>
                    </div>
                    <div class="checkout">
                        <a href="../../SanPham/html/checkout.html" id="checkout-link">Bắt đầu thanh toán<i style="margin-left: 0.5rem !important;" class="fas fa-long-arrow-alt-right me-2"></i></a>
                    </div>
                </div>
            </div>

        </div>


    </main>
    <!-- End block content -->
    <?php
    include './templates/Footer.php';
    ?>
    <script>
        function updateQuantity(productId, change) {
            const input = document.getElementById(`quantity-${productId}`);
            let newQuantity = parseInt(input.value) + change;

            if (newQuantity < 1) return;

            fetch('../controllers/CartController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    credentials: 'include',
                    body: `action=updateItem&productId=${productId}&quantity=${newQuantity}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Cập nhật lại giỏ hàng và tổng số lượng
                        fetchCartItems(); // Lấy lại thông tin giỏ hàng
                        const cartSpan = document.querySelector('.cart span');
                        if (cartSpan) {
                            cartSpan.innerHTML = data.totalQuantity; // Cập nhật lại tổng số lượng
                        }
                    } else {
                        alert(data.message || 'Lỗi khi cập nhật số lượng');
                    }
                })
                .catch(error => console.error('Lỗi:', error));
        }


        document.addEventListener('DOMContentLoaded', () => {
            fetchCartItems();

            document.querySelector('.product-in-cart').addEventListener('click', function(e) {
                if (e.target.matches('.quantity-btn')) {
                    const productId = e.target.getAttribute('data-id');
                    const change = parseInt(e.target.getAttribute('data-change'));
                    updateQuantity(productId, change);
                }
            });
        });


        function fetchCartItems() {
            fetch(`../controllers/CartController.php?action=getCartItems`, {
                    method: 'GET',
                    credentials: 'include' // Để gửi cookie PHPSESSID
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        renderCartItems(data.items);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => console.error('Lỗi:', error));
        }

        function renderCartItems(items) {
            const tbody = document.querySelector('.product-in-cart');
            tbody.innerHTML = '';

            let total = 0;

            items.forEach((item) => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                const row = document.createElement('tr');
                row.innerHTML = `
            <td class="product-title">
                <img src="../uploads/${item.image}" alt="${item.name}">
                <span title="${item.name}" style="display: inline-block; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${item.name}</span>
            </td>
            <td class="product-price">${formatCurrency(item.price)} Đ</td>
            <td class="product-quantity">
                <button class="quantity-btn minus" data-id="${item.product_id}" data-change="-1">-</button><input type="number" class="quantity-input" value="${item.quantity}" min="1" id="quantity-${item.product_id}"><button class="quantity-btn plus" data-id="${item.product_id}" data-change="1">+</button>
            </td>
            <td class="product-total" style="width:220px">${formatCurrency(itemTotal)} Đ</td>
            <td class="product-action">
                <button onclick="deleteItem(${item.product_id})"><i class="fa-solid fa-trash-can"></i></button>
            </td>
        `;
                tbody.appendChild(row);
            });

            const totalRow = document.createElement('tr');
            totalRow.innerHTML = `
        <td colspan="4" style="text-align: right;">Tổng cộng:</td>
        <td class="total" style="font-weight: bold;">${formatCurrency(total)} Đ</td>
    `;
            tbody.appendChild(totalRow);
        }


        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount);
        }

        function deleteItem(productId) {

            fetch('../controllers/CartController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    credentials: 'include',
                    body: `action=removeItem&productId=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        fetchCartItems(); // Lấy lại thông tin giỏ hàng (hoặc bạn có thể xóa dòng đó trong DOM)

                        // Cập nhật tổng số lượng sản phẩm trong giỏ hàng
                        const cartSpan = document.querySelector('.cart span');
                        if (cartSpan) {
                            cartSpan.innerHTML = data.totalQuantity; // Cập nhật tổng số lượng mới
                        }
                    } else {
                        alert(data.message || 'Lỗi khi xóa sản phẩm');
                    }
                })
                .catch(error => console.error('Lỗi:', error));
        }

        // Hàm này sẽ được gọi khi trang tải lại
        window.addEventListener('load', () => {
            // Gửi yêu cầu tới server để lấy thông tin giỏ hàng
            fetch('../controllers/CartController.php?action=getCartTotalQuantity') // Địa chỉ API để lấy tổng số lượng giỏ hàng
                .then(response => response.json())
                .then(data => {
                    // Kiểm tra nếu có dữ liệu từ server
                    if (data.status === 'success') {
                        // Cập nhật số lượng giỏ hàng vào giao diện
                        document.querySelector('.cart span').innerText = data.totalQuantity;
                    }
                })
                .catch(error => console.error('Lỗi:', error));
        });
    </script>
</body>

</html>