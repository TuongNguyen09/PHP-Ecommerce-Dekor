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
            <a class="navbar-brand" href="/php-ecommerce-dekor/index.php">
                <img src="/php-ecommerce-dekor/assets/imgs/logo.webp">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0" style="width: 28em">
                    <li class="nav-item">
                        <a class="nav-link " href="/php-ecommerce-dekor/Index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/php-ecommerce-dekor/views/About.php">Giới thiệu</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="/php-ecommerce-dekor/views/productpage.php"
                            id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            Sản Phẩm
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/php-ecommerce-dekor/views/productpage.php?page=1">Tất cả sản phẩm</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/php-ecommerce-dekor/views/productpage.php?category=Bàn+gỗ&page=1">Bàn gỗ</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/php-ecommerce-dekor/views/productpage.php?category=Kệ+sách&page=1">Kệ sách</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/php-ecommerce-dekor/views/productpage.php?category=Rèm+cửa&page=1">Rèm cửa</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/php-ecommerce-dekor/views/productpage.php?category=Ghế+sofa&page=1">Ghế sofa</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/php-ecommerce-dekor/views/productpage.php?category=Tủ+quần+áo&page=1">Tủ quần áo</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/php-ecommerce-dekor/views/productpage.php?category=Giường+ngủ&page=1">Giường ngủ</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/php-ecommerce-dekor/views/productpage.php?category=Phòng+tắm&page=1">Phòng tắm</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/php-ecommerce-dekor/views/productpage.php?category=Đèn+trang+trí&page=1">Đèn trang trí</a></li>
                        </ul>


                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="/php-ecommerce-dekor/views/New.php">Tin tức</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="/php-ecommerce-dekor/views/Contact.php">Liên Hệ</a>
                    </li>
                </ul>
                <form class="d-flex display: block">
                    <input class="form-control search-input" type="text" placeholder="Tìm kiếm" aria-label="Search"
                        id="myInput" onkeyup="myFunction()">

                    <button class="btn btn-primary search-btn" type="button" onclick="redirectToProductPage()"><span
                            class="ti-search"></span></button>
                </form>
                <?php

                // Kiểm tra xem người dùng đã đăng nhập chưa
                if (isset($_SESSION['userId'])) {

                    echo '
    <div class="icon-user" style="margin: 0 10px 0 20px;">
        <li class="nav-item dropdown">
            <a class="fas fa-user nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown"></a>
            <ul class="dropdown-menu">
                <a href="' . '' . '/php-ecommerce-dekor/views/MyInfoPage.php" class="dropdown-item">
                    <li>Tài khoản</li>
                </a>
                <a href="' . '' . '/php-ecommerce-dekor/views/OrderHistoryPage.php" class="dropdown-item">
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
                    <a href="/php-ecommerce-dekor/views/SignIn.php" class="dropdown-item">Đăng Nhập</a>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                    <a href="/php-ecommerce-dekor/views/SignUp.php" class="dropdown-item">Đăng Ký</a>
                </li>
            </ul>
        </li>
    </div>';
                }
                ?>

                <a href="<?php echo isset($_SESSION['userId']) ? '/php-ecommerce-dekor/views/CartPage.php' : 'javascript:void(0);' ?>"
                    title="Mua hàng" class="cart"
                    onclick="<?php if (!isset($_SESSION['userId'])) echo "alert('Vui lòng đăng nhập để mua hàng.');" ?>">
                    <li class="fas fa-cart-shopping"><span>0</span></li>
                </a>
            </div>
        </div>
    </nav>
</header>

<script>
    window.addEventListener('load', () => {
        // Gửi yêu cầu tới server để lấy thông tin giỏ hàng
        fetch('/php-ecommerce-dekor/controllers/CartController.php?action=getCartTotalQuantity') // Địa chỉ API để lấy tổng số lượng giỏ hàng
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

    document.querySelector(".search-btn").addEventListener("click", function() {
        const keyword = document.getElementById("myInput").value.trim();
        if (keyword !== "") {
            // Encode từ khóa rồi chuyển hướng
            const encodedKeyword = encodeURIComponent(keyword);
            window.location.href = "/php-ecommerce-dekor/views/productpage.php?key=" + encodedKeyword + "&page=1";
        }
    });
</script>