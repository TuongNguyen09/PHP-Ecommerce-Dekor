<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Khởi động session nếu chưa được khởi động
}
// require_once '../controllers/ProductController.php';

// $controller = new ProductController();
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
    <script src="../assets/js/jquery.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/style.js"></script>
    <link rel="stylesheet" href="../assets/css/cart.css">
    <link rel="stylesheet" href="../assets/">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Sản phẩm</title>
</head>

<body>
    <?php
    include './templates/Header.php';
    ?>

    <section class="category">
        <div class="top_nav">
            <ul class="line_up">
                <li><a href="/Index.html">Trang chủ</a></li>
                <li><i class="fas fa-chevron-right"></i></li>
                <li id="name-category"></li>
            </ul>
            <hr>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 category_left">
                    <div class="row">
                        <div class="col-lg-12 category_top">
                            <div class="title_module_main">
                                <h2>DANH MỤC SẢN PHẨM</h2>
                            </div>
                        </div>

                        <div class="category_left_content">
                            <ul>
                                <li class="category_left_menu"><i class="fas fa-chevron-right"></i><a
                                        style="cursor: pointer;">LOẠI SẢN PHẨM</a>
                                    <ul>
                                        <li><input name="category" type="checkbox" value="Bàn gỗ"> Bàn gỗ</li>
                                        <li><input name="category" type="checkbox" value="Kệ sách"> Kệ sách</li>
                                        <li><input name="category" type="checkbox" value="Rèm cửa"> Rèm cửa</li>
                                        <li><input name="category" type="checkbox" value="Ghế sofa"> Ghế sofa</li>
                                        <li><input name="category" type="checkbox" value="Phòng tắm"> Phòng tắm</li>
                                        <li><input name="category" type="checkbox" value="Tủ quần áo"> Tủ quần áo</li>
                                        <li><input name="category" type="checkbox" value="Giường ngủ"> Giường ngủ</li>
                                        <li><input name="category" type="checkbox" value="Đèn trang trí"> Đèn trang trí</li>
                                    </ul>
                                </li>
                            </ul>
                            <ul>
                                <li class="category_left_menu">
                                    <i class="fas fa-chevron-right"></i>
                                    <a style="cursor: pointer;">THƯƠNG HIỆU</a>
                                    <ul>
                                        <li><input name="brand" type="checkbox" id="kenny" value="Kenny Furniture"> Kenny Furniture</li>
                                        <li><input name="brand" type="checkbox" id="first_impression"
                                                value="First Impression" onclick="filterProducts()"> First Impression
                                        </li>
                                        <li><input name="brand" type="checkbox" id="big_one" value="Big One"> Big One</li>
                                        <li><input name="brand" type="checkbox" id="furniland" value="Furniland"> Furniland</li>
                                        <li><input name="brand" type="checkbox" id="my_home" value="My home"> My home</li>
                                    </ul>
                                </li>

                            </ul>
                            <ul>
                                <li class="category_left_menu">
                                    <i class="fas fa-chevron-right"></i>
                                    <a style="cursor: pointer;">GIÁ</a>
                                    <ul>
                                        <li><input name="price" type="checkbox" value="0-500000"> Dưới 500,000 VNĐ</li>
                                        <li><input name="price" type="checkbox" value="500000-1000000"> 500,000 - 1,000,000 VNĐ</li>
                                        <li><input name="price" type="checkbox" value="1000000-3000000"> 1,000,000 - 3,000,000 VNĐ</li>
                                        <li><input name="price" type="checkbox" value="3000000-5000000"> 3,000,000 - 5,000,000 VNĐ</li>
                                        <li><input name="price" type="checkbox" value="5000000-"> Trên 5,000,000 VNĐ</li>
                                    </ul>
                                </li>
                            </ul>
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

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 category_right">
                    <div class="row category_top">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <div class="category_title col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="title_module_main">
                                    <h2>DANH SÁCH SẢN PHẨM</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-8 col-md-8 col-lg-8">
                            <div class="row">
                                <div class="dropdown category_right_top col-xs-12 col-sm-12 col-md-6 col-lg-6">

                                </div>
                                <div class="category_right_top col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <select id="arrange" onchange="arrangeAndFilterProducts()">
                                        <option value="default">Sắp xếp</option>
                                        <option value="az">A -> Z</option>
                                        <option value="za">Z -> A</option>
                                        <option value="priceDesc">Giá giảm dần</option>
                                        <option value="priceAsc">Giá tăng dần</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="category_right_content row" id="product">


                    </div>

                    <div class="category_paging">
                        <ul class="pagination" id="pagination_number">
                            <!-- <li class="page-item page_btn_prev"><a class="page-link"><i
                                        class="fas fa-chevron-left"></i></a></li>
                            <div class="pagination number_page" id="number_page">

                            </div>
                            <li class="page-item page_btn_next"><a class="page-link"><i
                                        class="fas fa-chevron-right"></i></a></li> -->
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <?php
    include './templates/Footer.php';
    ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const categoryMenus = document.querySelectorAll(".category_left_menu");

            categoryMenus.forEach(menu => {
                const toggleTarget = menu.querySelector("a"); // chỉ bắt sự kiện ở <a>

                if (toggleTarget) {
                    toggleTarget.addEventListener("click", function(event) {
                        event.preventDefault(); // ngăn mặc định nếu là <a href="#">
                        menu.classList.toggle("open");

                        const subMenu = menu.querySelector("ul");
                        if (menu.classList.contains("open")) {
                            subMenu.style.maxHeight = subMenu.scrollHeight + "px";
                        } else {
                            subMenu.style.maxHeight = null;
                        }
                    });
                }
            });
        });



        // function updateUrl(categories, brands) {
        //     // Mã hóa categories và brands thành chuỗi JSON và sau đó mã hóa URL
        //     const encodedCategories = (JSON.stringify(categories));
        //     const encodedBrands = (JSON.stringify(brands));

        //     // Cập nhật URL với các tham số mới
        //     const url = new URL(getBasePath() + '/SanPham/html/category/product.html'); // Chuyển hướng đến trang sản phẩm
        //     url.searchParams.set('categories', encodedCategories);
        //     url.searchParams.set('brands', encodedBrands);

        //     // Chuyển hướng đến URL mới
        //     window.location.href = url.toString();
        // }

        // Hàm để lấy danh sách sản phẩm bán chạy
        function renderTopSellingProducts() {
            // Lấy danh sách orders từ localStorage
            const orders = JSON.parse(localStorage.getItem('orders')) || [];

            // Tạo đối tượng đếm số lượng bán ra của từng sản phẩm
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

            // Chuyển đổi đối tượng thành mảng và sắp xếp giảm dần theo số lượng
            const sortedProducts = Object.values(productCounts).sort((a, b) => b.count - a.count);

            // Lấy 5 sản phẩm bán chạy nhất
            const topProducts = sortedProducts.slice(0, 5);

            // Render ra HTML
            const hotProductContainer = document.getElementById('hot-product');
            hotProductContainer.innerHTML = '';

            topProducts.forEach(product => {
                const productHTML = `
            <div class="hot_item row">
                <div class="col-4">
                    <img src="${getBasePath() + product.image}" alt="${product.title}">
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

        // Gọi hàm khi trang được load
        document.addEventListener('DOMContentLoaded', renderTopSellingProducts);

        function getSelectedValues(name) {
            let selectedValues = [];
            let checkboxes = document.querySelectorAll(`input[name="${name}"]:checked`);
            checkboxes.forEach(function(checkbox) {
                selectedValues.push(checkbox.value);
            });
            return selectedValues;
        }

        function updateUrl(page = 1) {
            let selectedCategories = getSelectedValues('category');
            let selectedBrands = getSelectedValues('brand');
            let selectedPrices = getSelectedValues('price');

            let params = new URLSearchParams();

            if (selectedCategories.length > 0) {
                params.set('category', selectedCategories.join(','));
            }
            if (selectedBrands.length > 0) {
                params.set('brand', selectedBrands.join(','));
            }
            if (selectedPrices.length > 0) {
                params.set('price', selectedPrices.join(','));
            }

            params.set('page', page);

            history.pushState(null, '', '?' + params.toString());

            fetchProductsFromServer(params);
        }

        // Định nghĩa hàm renderProducts bên ngoài DOMContentLoaded
        function renderProducts(products) {
            const container = document.getElementById('product');
            container.innerHTML = '';
            if (products.length === 0) {
                container.innerHTML = '<p>Không có sản phẩm phù hợp.</p>';
                return;
            }
            products.forEach(product => {
                const html = `
        <div class="lazyload col-xs-12 col-sm-6 col-md-4 col-lg-4">
            <div class="lazyload_item popup category_right_content_item">
                <img src="../uploads/${product.image}" alt="${product.name}">
                <h5><a href="">${product.name}</a></h5>
                <p>${Number(product.price).toLocaleString()} <u>Đ</u></p>
                <ul class="popup_item">
                    <a title="Mua hàng" class="add-cart" id="add-cart-${product.id}">
                        <li class="fas fa-cart-shopping"></li>
                    </a>
                    <a title="Chi tiết" id="${product.id}" href="./ProductDetailPage.php?id=${product.id}">
                        <li class="fas fa-eye"></li>
                    </a>
                </ul>
            </div>
        </div>`;
                container.innerHTML += html;

                // Gắn sự kiện click vào nút "Mua hàng"
                document.getElementById(`add-cart-${product.id}`).addEventListener('click', function(e) {
                    e.preventDefault();
                    addToCart(product.id, 1); // Số lượng mặc định là 1
                });
            });
        }

        // Hàm fetchProductsFromServer không cần thay đổi
        function fetchProductsFromServer(params) {
            fetch('../controllers/ProductController.php?action=listProducts&' + params.toString())
                .then(response => response.json())
                .then(data => {
                    renderProducts(data.products);
                    renderPagination(data.totalPages, data.currentPage);
                })
                .catch(error => console.error('Fetch error:', error));
        }

        // ✅ Cập nhật: Hỗ trợ lấy filter từ URL dạng category=1,2
        function setCheckboxStateFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);

            ['category', 'brand', 'price'].forEach(name => {
                if (urlParams.has(name)) {
                    let values = urlParams.get(name).split(',');
                    values.forEach(val => {
                        let checkbox = document.querySelector(`input[name="${name}"][value="${val}"]`);
                        if (checkbox) checkbox.checked = true;
                    });
                }
            });
        }

        // Gắn sự kiện checkbox
        document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateUrl(); // mỗi lần đổi filter
            });
        });

        window.onload = function() {
            setCheckboxStateFromUrl();

            // ✅ Gọi fetch khi load lần đầu dựa vào URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('category') || urlParams.has('brand') || urlParams.has('price') || urlParams.has('page')) {
                fetchProductsFromServer(urlParams);
            }

            // Tô sáng nút phân trang hiện tại
            let currentPage = urlParams.get('page') || '1';
            document.querySelectorAll('.pagination a').forEach(function(link) {
                let pageParam = new URL(link.href).searchParams.get('page');
                if (pageParam === currentPage) {
                    link.classList.add('active');
                }
            });
        };

        // Định nghĩa hàm addToCart bên ngoài DOMContentLoaded
        function addToCart(productId, quantity) {
            $.ajax({
                url: '../controllers/CartController.php',
                method: 'POST',
                data: {
                    action: 'addItem',
                    productId: productId,
                    quantity: quantity
                },
                success: function(response) {
                    console.log('Phản hồi từ server:', response);

                    // Bỏ qua JSON.parse, vì response đã là đối tượng
                    try {
                        console.log('Status:', response.status);
                        if (response.status === 'success') {
                                
                            // Cập nhật số lượng giỏ hàng trên header
                            const cartSpan = document.querySelector('.cart span');
                            if (cartSpan) {
                                cartSpan.innerHTML = response.totalQuantity;
                                console.log('totalQuantity:', response.totalQuantity);
                            } else {
                                console.error('Không tìm thấy phần tử giỏ hàng');
                            }
                        } else {
                            alert(response.message || 'Có lỗi xảy ra, vui lòng thử lại!');
                        }
                    } catch (e) {
                        console.error('Lỗi xử lý phản hồi:', e);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Không thể kết nối máy chủ. Vui lòng thử lại!');
                }
            });

        }



        function renderPagination(totalPages, currentPage) {
            const paginationContainer = document.getElementById('pagination_number');
            paginationContainer.innerHTML = '';

            let html = '<ul class="pagination">';

            // Nút Prev
            html += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a href="?page=${currentPage - 1}" class="page-link">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>
    `;

            // Các số trang
            for (let i = 1; i <= totalPages; i++) {
                html += `
            <li class="page-item ${i == currentPage ? 'active' : ''}">
                <a href="?page=${i}" class="page-link">${i}</a>
            </li>
        `;
            }

            // Nút Next
            html += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a href="?page=${currentPage + 1}" class="page-link">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
    `;

            html += '</ul>';
            paginationContainer.innerHTML = html;

            // Gắn lại sự kiện click sau khi tạo HTML
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = new URL(link.href).searchParams.get('page') || 1;
                    updateUrl(page);
                });
            });
        }


    </script>
</body>

</html>