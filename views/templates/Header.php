<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?')); // Load lại trang không có ?action=logout
    exit();
}
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../../Index.html">
                <img src="./assets/imgs/logo.webp">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="width: 28em">
                    <li class="nav-item">
                        <a class="nav-link " href="../../Index.html">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../header/GioiThieu.html">Giới thiệu</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="../../SanPham/html/category/product.html"
                            id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            Sản Phẩm
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="javascript:void(0)">Tất cả sản phẩm</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)">Bàn Gỗ</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)">Kệ Sách</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)">Rèm Cửa</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)">Ghế Sofa</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)">Tủ Quần Áo</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)">Giường Ngủ</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)">Phòng Tắm</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)">Đèn trang trí</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="../../header/TinTuc.html">Tin tức</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="../../header/LienHe.html">Liên Hệ</a>
                    </li>
                </ul>
                <form class="d-flex display: block">
                    <input class="form-control search-input" type="text" placeholder="Tìm kiếm" aria-label="Search"
                        id="myInput" onkeyup="myFunction()">
                    <ul id="myUL" class="list-group searchInput mt-1">
                        <li><a href="../../SanPham/html/category/detail_item/Ban/ban2.html"
                                class="list-group-item list-group-item-action">bàn GTY 091</a></li>
                        <li><a href="../../SanPham/html/category/detail_item/tu_quan_ao/tu2.html"
                                class="list-group-item list-group-item-action">Tủ áo B1241K</a></li>

                        <li><a href="../../SanPham/html/category/detail_item/ke_sach/ke1.html"
                                class="list-group-item list-group-item-action">Kệ sách gỗ 4 tầng 40</a></li>
                        <li><a href="../../SanPham/html/category/detail_item/rem_cua/rem1.html"
                                class="list-group-item list-group-item-action">Rèm Cửa 01</a></li>

                        <li><a href="../../SanPham/html/category/detail_item/phong_tam/tam1.html"
                                class="list-group-item list-group-item-action">Thanh treo giấy vệ sinh</a></li>
                        <li><a href="../../SanPham/html/category/detail_item/sofa/sofa2.html"
                                class="list-group-item list-group-item-action">Sofa Cafe</a></li>
                        <li><a href="../../SanPham/html/category/detail_item/giuong_ngu/giuong4.html"
                                class="list-group-item list-group-item-action">Giường Bellasofa B1239</a></li>

                    </ul>

                    <button class="btn btn-primary search-btn" type="button" onclick="redirectToProductPage()"><span
                            class="ti-search"></span></button>
                </form>
                <?php

                // Kiểm tra xem người dùng đã đăng nhập chưa
                if (isset($_SESSION['userId'])) {

                    echo '
    <div class="icon-user">
        <li class="nav-item dropdown">
            <a class="fas fa-user nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown"></a>
            <ul class="dropdown-menu">
                <a href="' . '' . '/SanPham/html/accountInfo.html" class="dropdown-item">
                    <li>Tài khoản</li>
                </a>
                <a href="' . '' . '/SanPham/html/user_order.html" class="dropdown-item">
                    <li>Đơn mua</li>
                </a>
                <a href="?action=logout" class="dropdown-item">
                    <li>Đăng xuất</li>
                </a>
            </ul>
        </li>
    </div>';
                } else {
                    // Nếu chưa đăng nhập, render menu đăng nhập và đăng ký
                    echo '
    <div class="icon-user">
        <li class="nav-item dropdown">
            <a class="fas fa-user nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown"></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="./SanPham/html/Dangnhap.html" class="dropdown-item">Đăng Nhập</a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                    <a href="./SanPham/html/Dangky.html" class="dropdown-item">Đăng Ký</a>
                </li>
            </ul>
        </li>
    </div>';
                }
                ?>

                <a href="./cart.html" title="Mua hàng" class="cart">
                    <li class="fas fa-cart-shopping"><span>0</span></li>
                </a>
            </div>
        </div>
    </nav>
</header>

<script>
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