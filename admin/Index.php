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
                        <div class="menu">
                            <a href="./admin.html">
                                <li class="menu_item active"><i class="fas fa-house"></i>Trang chủ</li>
                            </a>
                            <a href="./data_product.html">
                                <li class="menu_item"><i class="fas fa-tag"></i>Quản lý sản phẩm</li>
                            </a>
                            <a href="./data_oder.html">
                                <li class="menu_item"><i class="fas fa-bag-shopping"></i>Quản lý đơn hàng</li>
                            </a>
                            <a href="./data_user.html">
                                <li class="menu_item"><i class="fas fa-address-card"></i>Quản lý người dùng</li>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sign_out">
                <a href="#" onclick="logoutAdmin()"><i class="fas fa-right-from-bracket"></i></a>
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
            <div class="menu">
                <a href="./admin.html">
                    <li class="menu_item active"><i class="fas fa-house"></i>Trang chủ</li>
                </a>
                <a href="./data_product.html">
                    <li class="menu_item"><i class="fas fa-tag"></i>Quản lý sản phẩm</li>
                </a>
                <a href="./data_oder.html">
                    <li class="menu_item"><i class="fas fa-bag-shopping"></i>Quản lý đơn hàng</li>
                </a>
                <a href="./data_user.html">
                    <li class="menu_item"><i class="fas fa-address-card"></i>Quản lý người dùng</li>
                </a>
            </div>
        </div>
    </header>

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
                <button onclick="renderProductsTableFromLocalStorage()" class="filter-button">Lọc</button>
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
                        </tr>
                        <tr>
                            <td>den3</td>
                            <td>Đèn tường Composite An Phước B948</td>
                            <td>10.000.000</td>
                            <td>Đèn trang trí</td>
                            <td>7</td>
                            <td>70.000.000 VND</td>
                        </tr>
                        <tr>
                            <td>ban1</td>
                            <td>Bàn cafe tròn gỗ đẹp</td>
                            <td>4.500.000</td>
                            <td>Bàn gỗ</td>
                            <td>8</td>
                            <td>36.000.000 VND</td>
                        </tr>
                        <tr>
                            <td>ban2</td>
                            <td>Bàn GTY 091</td>
                            <td>3.500.000</td>
                            <td>Bàn gỗ</td>
                            <td>8</td>
                            <td>28.000.000 VND</td>
                        </tr>
                        <tr>
                            <td>den2</td>
                            <td>Đèn trang trí vách cao cấp pha lê Netviet NV 9005/2</td>
                            <td>970.000</td>
                            <td>Đèn trang trí</td>
                            <td>10</td>
                            <td>9.700.000 VND</td>
                        </tr>
                        <tr>
                            <td>den1</td>
                            <td>Đèn trang trí vách cao cấp NETVIET NV 8825</td>
                            <td>780.000</td>
                            <td>Đèn trang trí</td>
                            <td>5</td>
                            <td>3.900.000 VND</td>
                        </tr>
                        <tr>
                            <td>ban4</td>
                            <td>Bàn gỗ dài</td>
                            <td>189.000</td>
                            <td>Bàn gỗ</td>
                            <td>9</td>
                            <td>1.701.000 VND</td>
                        </tr>
                        <tr>
                            <td>den4</td>
                            <td>Đèn trang trí vách Netviet NV 8205/1</td>
                            <td>590.000</td>
                            <td>Đèn trang trí</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>giuong1</td>
                            <td>Giường Bellasofa BS701</td>
                            <td>11.000.000</td>
                            <td>Giường ngủ</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>giuong2</td>
                            <td>Giường ngủ FURNILAND - Jangin Haim (1.8m)</td>
                            <td>5.400.000</td>
                            <td>Giường ngủ</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>giuong3</td>
                            <td>Giường ngủ FURNILAND - Jangin Christine (1m8)</td>
                            <td>12.000.000</td>
                            <td>Giường ngủ</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>giuong4</td>
                            <td>Giường Bellasofa B1239</td>
                            <td>9.000.000</td>
                            <td>Giường ngủ</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>ke1</td>
                            <td>Kệ sách gỗ 4 tầng 40</td>
                            <td>510.000</td>
                            <td>Kệ sách</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>ke2</td>
                            <td>Kệ sách BIG ONE VIETNAM SPR-1980DK</td>
                            <td>460.000</td>
                            <td>Kệ sách</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>ke3</td>
                            <td>Kệ trang trí Rubik Modulo Home 1846</td>
                            <td>1.100.000</td>
                            <td>Kệ sách</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>ke4</td>
                            <td>Giá sách treo Hurakids 2130-001</td>
                            <td>598.000</td>
                            <td>Kệ sách</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>phongtam1</td>
                            <td>Thanh treo giấy vệ sinh</td>
                            <td>150.000</td>
                            <td>Phòng tắm</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>phongtam2</td>
                            <td>Thanh sắt treo khăn</td>
                            <td>109.000</td>
                            <td>Phòng tắm</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>phongtam3</td>
                            <td>Kệ chứa xà phòng</td>
                            <td>190.000</td>
                            <td>Phòng tắm</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>phongtam4</td>
                            <td>Bóng đèn DTY</td>
                            <td>80.000</td>
                            <td>Phòng tắm</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>rem1</td>
                            <td>Rèm cửa 01</td>
                            <td>900.000</td>
                            <td>Rèm cửa</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>rem2</td>
                            <td>Rèm cửa 02</td>
                            <td>890.000</td>
                            <td>Rèm cửa</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>rem3</td>
                            <td>Rèm cửa 03</td>
                            <td>750.000</td>
                            <td>Rèm cửa</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>rem4</td>
                            <td>Rèm cửa 04</td>
                            <td>950.000</td>
                            <td>Rèm cửa</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>sofa1</td>
                            <td>Ghế sofa kem</td>
                            <td>2.500.000</td>
                            <td>Ghế sofa</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>sofa2</td>
                            <td>Sofa cafe</td>
                            <td>2.300.000</td>
                            <td>Ghế sofa</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>sofa3</td>
                            <td>Ghế sofa đơn êm ái</td>
                            <td>2.600.000</td>
                            <td>Ghế sofa</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>sofa4</td>
                            <td>Sofa đơn SFD18</td>
                            <td>5.100.000</td>
                            <td>Ghế sofa</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>tu1</td>
                            <td>Tủ quần áo BIG ONE VIETNAM WVR-1855L</td>
                            <td>4.000.000</td>
                            <td>Tủ quần áo</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>tu2</td>
                            <td>Tủ áo B1241K</td>
                            <td>5.400.000</td>
                            <td>Tủ quần áo</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>tu3</td>
                            <td>Tủ Áo Bellasofa B1239</td>
                            <td>3.790.000</td>
                            <td>Tủ quần áo</td>
                            <td>0</td>
                            <td>0 VND</td>
                        </tr>
                        <tr>
                            <td>tu4</td>
                            <td>Tủ áo B1238</td>
                            <td>5.100.000</td>
                            <td>Tủ quần áo</td>
                            <td>0</td>
                            <td>0 VND</td>
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
                <button onclick="render_Revenue_User()" class="filter-button">Lọc</button>
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
                                <a href="./data_oder.html?id=5" class="btn btn-danger btn-sm">Xem đơn hàng</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Triệu Thanh Phú</td>
                            <td>9123369598</td>
                            <td>PetSuppliesCT@gmail.com</td>
                            <td>63,000,000 VND</td>
                            <td>
                                <a href="./data_oder.html?id=1" class="btn btn-danger btn-sm">Xem đơn hàng</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Lê Thị Mai</td>
                            <td>9613456789</td>
                            <td>GreenLivingShop@gmail.com</td>
                            <td>53,000,000 VND</td>
                            <td>
                                <a href="./data_oder.html?id=8" class="btn btn-danger btn-sm">Xem đơn hàng</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Quán Thiếu Anh</td>
                            <td>7174378833</td>
                            <td>FrenzyFlorists@gmail.com</td>
                            <td>31,347,000 VND</td>
                            <td>
                                <a href="./data_oder.html?id=2" class="btn btn-danger btn-sm">Xem đơn hàng</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Phan Thị Hồng</td>
                            <td>9432225589</td>
                            <td>EcoHomeDesign@gmail.com</td>
                            <td>18,560,000 VND</td>
                            <td>
                                <a href="./data_oder.html?id=6" class="btn btn-danger btn-sm">Xem đơn hàng</a>
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
                    <tbody>
                        <tr>
                            <td>giuong3</td>
                            <td>Giường ngủ FURNILAND - Jangin Christine (1m8)</td>
                            <td>Giường ngủ</td>
                            <td>4</td>
                            <td>12.000.000 VND</td>
                        </tr>
                        <tr>
                            <td>sofa3</td>
                            <td>Ghế sofa đơn êm ái</td>
                            <td>Ghế sofa</td>
                            <td>2</td>
                            <td>2.600.000 VND</td>
                        </tr>
                        <tr>
                            <td>tu1</td>
                            <td>Tủ quần áo BIG ONE VIETNAM WVR-1855L</td>
                            <td>Tủ quần áo</td>
                            <td>3</td>
                            <td>4.000.000 VND</td>
                        </tr>
                        <tr>
                            <td>tu4</td>
                            <td>Tủ áo B1238</td>
                            <td>Tủ quần áo</td>
                            <td>1</td>
                            <td>5.100.000 VND</td>
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
    <script src="../../js/data.js"></script>
    <script src="../../js/admin.js"></script>
    <script src="../../js/account.js"></script>
    <script src="../../js/statistic.js"></script>
    <script src="../../js/checkSignInAdmin.js"></script>
</body>

</html>