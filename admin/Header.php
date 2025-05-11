<?php
$currentPage = basename($_SERVER['PHP_SELF']); // lấy tên file hiện tại, ví dụ: data_product.php
?>
<header>
    <div class="top">
        <div class="tab_menu">
            <i class="fas fa-bars" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                aria-controls="offcanvasExample"></i>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                aria-labelledby="offcanvasExampleLabel" style="width: 250px;">
                <div class="sidebar">
                    <div class="close_tab">
                        <i class="fas fa-xmark" data-bs-dismiss="offcanvas"></i>
                    </div>
                    <div class="user">
                        <div class="user_avatar">
                            <i class="fa-solid fa-user fa-2x"></i>
                        </div>
                        <div>
                            <div class="user_name">
                                <a href="./infoAdmin.html" style="color:aliceblue;"></a>
                            </div>
                            <div class="user_designation">
                                <p>Chào mừng bạn trở lại</p>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <?php
                    $currentPage = basename($_SERVER['PHP_SELF']); // lấy tên file hiện tại, ví dụ: data_product.php
                    ?>

                    <header>
                        <!-- các phần khác giữ nguyên -->
                        <div class="menu">
                            <a href="admin.php">
                                <li class="menu_item <?php if ($currentPage == 'admin.php') echo 'active'; ?>">
                                    <i class="fas fa-house"></i>Trang chủ
                                </li>
                            </a>
                            <a href="ProductList.php">
                                <li class="menu_item <?php if ($currentPage == 'ProductList.php') echo 'active'; ?>">
                                    <i class="fas fa-tag"></i>Quản lý sản phẩm
                                </li>
                            </a>
                            <a href="OrderList.php">
                                <li class="menu_item <?php if ($currentPage == 'OrderList.php') echo 'active'; ?>">
                                    <i class="fas fa-bag-shopping"></i>Quản lý đơn hàng
                                </li>
                            </a>
                            <a href="UserList.php">
                                <li class="menu_item <?php if ($currentPage == 'UserList.php') echo 'active'; ?>">
                                    <i class="fas fa-address-card"></i>Quản lý người dùng
                                </li>
                            </a>
                            <a href="CategoryList.php">
                                <li class="menu_item <?php if ($currentPage == 'CategoryList.php') echo 'active'; ?>">
                                    <i class="fas fa-address-card"></i>Quản lý danh mục
                                </li>
                            </a>
                            <a href="BrandList.php">
                                <li class="menu_item <?php if ($currentPage == 'BrandList.php') echo 'active'; ?>">
                                    <i class="fas fa-address-card"></i>Quản lý thương hiệu
                                </li>
                            </a>
                        </div>
                    </header>

                </div>
            </div>
        </div>
        <div class="sign_out">
            <a href="javascript:void(0);" onclick="logoutAdmin()"><i class="fas fa-right-from-bracket"></i></a>
        </div>

    </div>
    <div class="sidebar">
        <div class="user">
            <div class="user_avatar">
                <i class="fa-solid fa-user fa-2x"></i>
            </div>
            <div>
                <div class="user_name">
                    <a href="./infoAdmin.html" style="color:aliceblue;"></a>
                </div>
                <div class="user_designation">
                    <p>Chào mừng bạn trở lại</p>
                </div>
            </div>
            <hr>
        </div>
        <!-- các phần khác giữ nguyên -->
        <div class="menu">
            <a href="Index.php">
                <li class="menu_item <?php if ($currentPage == 'Index.php') echo 'active'; ?>">
                    <i class="fas fa-house"></i>Trang chủ
                </li>
            </a>
            <a href="ProductList.php">
                <li class="menu_item <?php if ($currentPage == 'ProductList.php') echo 'active'; ?>">
                    <i class="fas fa-tag"></i>Quản lý sản phẩm
                </li>
            </a>
            <a href="OrderList.php">
                <li class="menu_item <?php if ($currentPage == 'OrderList.php') echo 'active'; ?>">
                    <i class="fas fa-bag-shopping"></i>Quản lý đơn hàng
                </li>
            </a>
            <a href="UserList.php">
                <li class="menu_item <?php if ($currentPage == 'UserList.php') echo 'active'; ?>">
                    <i class="fas fa-address-card"></i>Quản lý người dùng
                </li>
            </a>
            <a href="CategoryList.php">
                <li class="menu_item <?php if ($currentPage == 'CategoryList.php') echo 'active'; ?>">
                    <i class="fa-solid fa-layer-group"></i>Quản lý danh mục
                </li>
            </a>
            <a href="BrandList.php">
                <li class="menu_item <?php if ($currentPage == 'BrandList.php') echo 'active'; ?>">
                    <i class="fa-brands fa-font-awesome"></i>Quản lý thương hiệu
                </li>
            </a>
        </div>
    </div>
</header>
<script>
    function logoutAdmin() {
        fetch("../controllers/UserController.php?action=logoutAdmin", {
                method: "GET"
            })
            .then(response => {
                if (response.ok) {
                    // Chuyển hướng đến trang đăng nhập sau khi logout thành công
                    window.location.href = "SignInAdmin.php";
                } else {
                    console.error("Lỗi khi đăng xuất.");
                }
            })
            .catch(error => {
                console.error("Đã xảy ra lỗi khi gửi yêu cầu đăng xuất:", error);
            });
    }
</script>