<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Khởi động session nếu chưa được khởi động
}
require_once '../controllers/ProductController.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = (int)$_GET['id'];
    echo $productId;
    $controller = new ProductController();
    $product = $controller->getProductById1($productId); // ✅ Sử dụng hàm đã sửa

    if ($product) {
        $productId = $product['id'];
        $productName = $product['name'];
        $productDescription = $product['description'];
        $productPrice = $product['price'];
        $productImage = $product['image'];
        $productBrand = $product['brand_name'];
        // render HTML bên dưới
    } else {
        echo "Sản phẩm không tồn tại";
    }
} else {
    echo "ID sản phẩm không hợp lệ";
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
    <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css">
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/detail_item.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/cart.css">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <title>Bàn Cafe tròn gỗ đẹp</title>
    <style>
        .category_left_menu {
            transition: color 0.3s, background-color 0.3s, transform 0.3s;
        }

        .category_left_menu:hover {
            transform: translateX(5px);
        }

        .category_left_menu a:hover {
            color: #444444;
        }
    </style>
</head>

<body>
    <?php
    include './templates/Header.php';
    ?>

    <section class="category">
        <div class="top_nav">
            <ul class="line_up">
                <li><a href="../../../../Index.html">Trang chủ</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li id="name-category"></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li id="name-product"></li>
            </ul>
            <hr>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 category_left">
                    <div class="row">
                        <div class="col-lg-12 category_top">
                            <div class="title_module_main">
                                <h2>LOẠI SẢN PHẨM</h2>
                            </div>
                        </div>

                        <div class="category_left_content">
                            <ul>
                                <li class="category_left_menu">
                                    <i class="fas fa-chevron-right"></i>
                                    <a href="/php-ecommerce-dekor/views/productpage.php?category=all&page=1">Tất cả sản phẩm</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="category_left_menu">
                                    <i class="fas fa-chevron-right"></i>
                                    <a href="/php-ecommerce-dekor/views/productpage.php?category=Bàn+gỗ&page=1">Bàn Gỗ</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="category_left_menu">
                                    <i class="fas fa-chevron-right"></i>
                                    <a href="/php-ecommerce-dekor/views/productpage.php?category=Kệ+sách&page=1">Kệ Sách</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="category_left_menu">
                                    <i class="fas fa-chevron-right"></i>
                                    <a href="/php-ecommerce-dekor/views/productpage.php?category=Rèm+cửa&page=1">Rèm Cửa</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="category_left_menu">
                                    <i class="fas fa-chevron-right"></i>
                                    <a href="/php-ecommerce-dekor/views/productpage.php?category=Ghế+sofa&page=1">Ghế Sofa</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="category_left_menu">
                                    <i class="fas fa-chevron-right"></i>
                                    <a href="/php-ecommerce-dekor/views/productpage.php?category=Tủ+quần+áo&page=1">Tủ Quần Áo</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="category_left_menu">
                                    <i class="fas fa-chevron-right"></i>
                                    <a href="/php-ecommerce-dekor/views/productpage.php?category=Giường+ngủ&page=1">Giường Ngủ</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="category_left_menu">
                                    <i class="fas fa-chevron-right"></i>
                                    <a href="/php-ecommerce-dekor/views/productpage.php?category=Phòng+tắm&page=1">Phòng Tắm</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="category_left_menu">
                                    <i class="fas fa-chevron-right"></i>
                                    <a href="/php-ecommerce-dekor/views/productpage.php?category=Đèn+trang+trí&page=1">Đèn trang trí</a>
                                </li>
                            </ul>

                            <script>
                                const itemsliderbar = document.querySelectorAll(".category_left_menu")
                                itemsliderbar.forEach(function(menu, index) {
                                    menu.addEventListener("click", function() {
                                        menu.classList.toggle("block")
                                    })
                                })
                            </script>
                        </div>

                        <div class="col-lg-12 category_top">
                            <div class="title_module_main">
                                <h2>SẢN PHẨM BÁN CHẠY</h2>
                            </div>
                            <div class="category_hot_item col-12" id="hot-product">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-9 row category_right">
                    <div class="col-sm-12 col-md-6" id="product-image"><img src="../uploads/products/<?php echo htmlspecialchars($productImage); ?>"></div>
                    <div class="col-sm-12 col-md-6">
                        <div>
                            <div class="details_pro">
                                <h1 class="title_product"><?php echo htmlspecialchars($productName); ?></h1>

                                <div class="price_box">
                                    <span><?php echo number_format($productPrice, 0, ',', '.'); ?>
                                        <u>đ</u></span>
                                </div>
                                <div class="info_product">
                                    <div class="status">
                                        <span class="a_name">Thương hiệu:</span>
                                        <span class="status_name"><?php echo htmlspecialchars($productBrand); ?></span>
                                    </div>
                                    <div class="status">
                                        Tình trạng:
                                        <span class="status_name">Còn hàng</span>
                                    </div>
                                </div>
                            </div>
                            <p>Số lượng:</p>
                            <div class="form_btn_detail">
                                <div class="btn_added">
                                    <input class="minus is-form" type="button" value="-">
                                    <input id="add-to-cart-btn" aria-label="quantity" class="input-qty" max="10" min="1" name="" type="number" value="<?php echo htmlspecialchars($productId); ?>" data-image="<?php echo htmlspecialchars($productImage); ?>">
                                    <input class="plus is-form" type="button" value="+">
                                </div>
                                <script>
                                    $('input.input-qty').each(function() {
                                        var $this = $(this),
                                            qty = $this.parent().find('.is-form'),
                                            min = Number($this.attr('min')),
                                            max = Number($this.attr('max'))
                                        if (min == 0) {
                                            var d = 0
                                        } else d = min
                                        $(qty).on('click', function() {
                                            if ($(this).hasClass('minus')) {
                                                if (d > min) d += -1
                                            } else if ($(this).hasClass('plus')) {
                                                var x = Number($this.val()) + 1
                                                if (x <= max) d += 1
                                            }
                                            $this.attr('value', d).val(d)
                                            localStorage.setItem('newqty', d);
                                        })
                                    })
                                </script>
                                <div class="add_to_cart_btn add-cart" id="1">
                                    <a>THÊM VÀO GIỎ HÀNG</a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="product_tab">
                        <ul class="tabs_title" style="display: flex;">
                            <li class="tab_link active tab1 col-xs-12 col-sm-4">
                                <h3 onclick="showTab1()"><a>Mô tả</a></h3>
                            </li>
                            <li class="tab_link tab2 col-xs-12 col-sm-4">
                                <h3 onclick="showTab2()"><a>Hướng dẫn mua hàng</a></h3>
                            </li>
                        </ul>
                        <div class="tab_float">
                            <div style="text-align:left" class="tab_1">
                                <?php
                                    echo $productDescription;
                                ?>
                                <!-- <p>Chất liêu: Sản xuất từ Gỗ MDF sơn Bệt 2k</p>
                                <p>Kích thước: 800x800x350mm(Quý khách có thể đặt kích thước khác để phù hợp với phòng nhà mình)</p>
                                <p>Màu: nâu</p>
                                <p>Chất lượng: Gỗ công nghiệp MDF nhập khẩu nguyên tấm từ Malaysia, vật liệu chất lượng cao.</p>
                                <p>Với 100% nhựa nguyên chất, đảm bảo không độc hại, không mối mọt, ẩm ướt..v..v</p><img src="http://127.0.0.1:5500/Facility/Sanpham/img/category/Ban/1.png">
                                <p>Ghế cafe TF 018 Với thiết kế đơn giản nhưng sang trọng, được tối ưu các chi tiết góc canh,để tạo cho bạn có cảm giác ngồi thoải mái nhất có thể.</p>
                                <p>Ghế được làm bằng hộp thép tròn phi 19 , 21,.v..v độ dày 1mm, thép mạ kém, hoặc thép sơn tĩnh điện,tùy theo khách hàng lựa chọn,.</p>
                                <p>Sợi dây nhựa giả mây cao cấp nhất Việt Nam.</p>
                                <p>Không gian của bạn cần một loại ghế đơn giản nhưng sang trọng thì đó là ghế TF 018.</p>
                                <p>Thiết kế của ghế TF 018, giúp bạn tiết kiệm không gian, ghế có thể chồng lên nhau từ 4 - 8 ghế khi bạn cần thu dọn, để lấy không gian</p><img src="http://127.0.0.1:5500/Facility/Sanpham/img/category/Ban/2.png"> -->
                            </div>
                            <div class="tab_2">
                                <p>Bước 1: Tìm sản phẩm cần mua Bạn có thể truy cập website để tìm và chọn sản phẩm muốn
                                    mua bằng nhiều cách:</p>
                                <p>+ Sử dụng ô tìm kiếm phía trên, gõ tên sản phẩm muốn mua (có thể tìm đích danh 1 sản
                                    phẩm, tìm theo hãng...). Website sẽ cung cấp cho bạn những gợi ý chính xác để lựa
                                    chọn:</p>
                                <p>Bước 2: Đặt mua sản phẩm Sau khi chọn được sản phẩm ưng ý muốn mua, bạn tiến hành đặt
                                    hàng bằng cách:</p>
                                <p>+ Chọn vào nút MUA NGAY nếu bạn muốn thanh toán luôn toàn bộ giá tiền sản phẩm</p>
                                <p>+ Điền đầy đủ các thông tin mua hàng theo các bước trên website, sau đó chọn hình
                                    thức nhận hàng là giao hàng tận nơi hay đến siêu thị lấy hàng, chọn hình thức thanh
                                    toán là trả khi nhận hàng hay thanh toán online (bằng thẻ ATM, VISA hay MasterCard)
                                    và hoàn tất đặt hàng.</p>
                                <p>+ Lưu ý:</p>
                                <p>1. Chúng tôi chỉ chấp nhận những đơn đặt hàng khi cung cấp đủ thông tin chính xác về
                                    địa chỉ, số điện thoại. Sau khi bạn đặt hàng, chúng tôi sẽ liên lạc lại để kiểm tra
                                    thông tin và thỏa thuận thêm những điều có liên quan.</p>
                                <p>2. Một số trường hợp nhạy cảm: giá trị đơn hàng quá lớn &amp; thời gian giao hàng vào
                                    buổi tối, địa chỉ giao hàng trong ngõ hoặc có thể dẫn đến nguy hiểm. Chúng tôi sẽ
                                    chủ động liên lạc với quý khách để thống nhất lại thời gian giao hàng cụ thể.</p>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php
    include './templates/Footer.php';
    ?>
    <script src="../../../js/data.js"></script>
    <script>
        // $(document).ready(function() {
        //     $('#add-to-cart-btn a').click(function(e) {
        //         e.preventDefault();

        //         // Lấy thông tin sản phẩm và số lượng
        //         var productId = <?php echo $productId; ?>;
        //         var quantity = $('#add-to-cart-btn').val();

        //         // Gửi yêu cầu thêm vào giỏ hàng
        //         $.ajax({
        //             url: '../controllers/CartController.php', // Đường dẫn tới controller PHP xử lý thêm sản phẩm
        //             method: 'POST',
        //             data: {
        //                 productId: productId,
        //                 quantity: quantity
        //             },
        //             success: function(response) {
        //                 alert('Sản phẩm đã được thêm vào giỏ hàng!');
        //             },
        //             error: function() {
        //                 alert('Có lỗi xảy ra, vui lòng thử lại!');
        //             }
        //         });
        //     });
        // });

        $(document).ready(function() {
            $('.add_to_cart_btn').click(function(e) {
                e.preventDefault();

                <?php if (!isset($_SESSION['userId'])): ?>
                    alert('Vui lòng đăng nhập để mua hàng');
                    return;
                <?php endif; ?>

                console.log('Nút "Thêm vào giỏ hàng" đã được nhấn.');

                var productId = <?php echo $productId; ?>;
                var quantity = $('.input-qty').val();

                console.log('Product ID: ' + productId);
                console.log('Quantity: ' + quantity);

                $.ajax({
                    url: '../controllers/CartController.php',
                    method: 'POST',
                    data: {
                        action: 'addItem',
                        productId: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        console.log('Response từ server: ' + response);
                        fetch('../controllers/CartController.php?action=getCartTotalQuantity')
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    document.querySelector('.cart span').innerText = data.totalQuantity;
                                }
                            })
                            .catch(error => console.error('Lỗi khi cập nhật giỏ hàng:', error));
                    },
                    error: function() {
                        console.log('Có lỗi xảy ra trong AJAX.');
                        alert('Có lỗi xảy ra, vui lòng thử lại!');
                    }
                });
            });
        });



        function getBasePath() {
            const pathArray = window.location.pathname.split('/');
            const facilityIndex = pathArray.indexOf('Facility');

            if (facilityIndex !== -1) {
                // Tạo basePath tới 'SanPham/html' từ 'Facility'
                const basePath = pathArray.slice(0, facilityIndex + 1).join('/');
                return window.location.origin + basePath;
            } else {
                // Trường hợp không tìm thấy 'Facility'
                console.warn("Không tìm thấy thư mục 'Facility' trong URL.");
                return window.location.origin;
            }
        }


        function showTab1() {
            document.querySelector(".tab_1").style.display = "inline-block";
            document.querySelector(".tab_2").style.display = "none";
            $('.tab1').addClass('active');
            $('.tab2').removeClass('active');
        }

        function showTab2() {
            document.querySelector(".tab_1").style.display = "none";
            document.querySelector(".tab_2").style.display = "inline-block";
            $('.tab2').addClass('active');
            $('.tab1').removeClass('active');
        }
    </script>
    <script src="../../../js/icon_cart.js"></script>
    <script src="../../../js/account.js"></script>
    <script>
        function updateUrl(categories, brands) {
            const encodedCategories = (JSON.stringify(categories));
            const encodedBrands = (JSON.stringify(brands));

            const url = new URL(getBasePath() + '/SanPham/html/category/product.html');
            url.searchParams.set('categories', encodedCategories);
            url.searchParams.set('brands', encodedBrands);

            window.location.href = url.toString();
        }

        function renderTopSellingProducts() {
            const orders = JSON.parse(localStorage.getItem('orders')) || [];
            const productCounts = {};
            orders.forEach(order => {
                order.products.forEach(product => {
                    if (!productCounts[product.id]) {
                        productCounts[product.id] = {
                            ...product,
                            count: 0
                        };
                    }
                    productCounts[product.id].count += product.quantity;
                });
            });

            const sortedProducts = Object.values(productCounts).sort((a, b) => b.count - a.count);

            const topProducts = sortedProducts.slice(0, 5);

            const hotProductContainer = document.getElementById('hot-product');
            hotProductContainer.innerHTML = '';

            topProducts.forEach(product => {
                const productHTML = `
            <div class="hot_item row">
                <div class="col-4">
                    <img src="${product.image.length > 100 ? product.image : getBasePath() + product.image}" alt="${product.title}">
                </div>
                <div class="col-8">
                    <h5><a href="${getBasePath()}/SanPham/html/category/detail_item/product_detail.html?id=${product.id}">${product.title}</a></h5>
                    <p>${product.price.toLocaleString()}<u>đ</u></p>
                </div>
            </div>
        `;
                hotProductContainer.insertAdjacentHTML('beforeend', productHTML);
            });
        }

        document.addEventListener('DOMContentLoaded', renderTopSellingProducts);

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