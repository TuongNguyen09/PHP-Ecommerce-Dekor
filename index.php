<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Khởi động session nếu chưa được khởi động
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="./assets/bootstrap-5.2.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./assets/fontawesome-free-6.2.0-web/css/all.css">
    <link rel="stylesheet" href="./assets/themify-icons/themify-icons.css">
    <script src="./style.js"></script>
    <link rel="stylesheet" href="./assets/css/cart.css">
    <link rel="stylesheet" href="./assets/css/product.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <title>deKor</title>
</head>

<body>
    <?php
    include './views/templates/Header.php';
    ?>

    <div id="demo" class="carousel slide" data-bs-ride="carousel">

        <!-- Indicators/dots -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
        </div>

        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./assets/imgs/asd.png" alt="" class="d-block" style="width:100%">
            </div>
            <div class="carousel-item">
                <img src="./assets/imgs/img3.jpg " alt="" class="d-block" style="width:100%">
            </div>
            <div class="carousel-item">
                <img src="./assets/imgs/_4.jpg" alt="" class="d-block" style="width:100%">
            </div>
        </div>

        <!-- Left and right controls/icons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>


    <div class="container">
        <div class="slider row">
            <div class="col-lg-6">
                <img src="./assets/imgs/img5.jpg" alt="" class="d-block" style="width:90%;height:90%">
            </div>
            <div class="para col-lg-6">
                <br>
                <h2 class="para1">Xin chào! Chúng tôi là Dekor</h2>
                <h2>----</h2>
                <p class="para2"> Đầu tiên Dekor xin gửi lời chào, kính chúc sức khỏe, thành công và lời cảm ơn đến Quý
                    khách hàng đã ủng hộ những sản phẩm của chúng tôi. Với hơn 10 năm kinh nghiệm về sản xuất, kinh
                    doanh, thiết kế và thi công sản phẩm nội thất phục vụ
                    cho không gian: phòng khách gia đình, nhà hàng, café, khách sạn . Dekor thấu hiểu được nhu cầu và
                    thị hiếu của người tiêu dùng, tập thể chúng tôi luôn chú trọng đầu tư, thiết kế những sản phẩm chất
                    lượng nhằm mang đến một không gian
                    sống thật thoải mái, ấm cúng và tiện nghi cho người sử dụng.</p>
                <a href="./header/GioiThieu.html"><button type="button" class="box1 btn btn-default">Xem Chi
                        Tiết</button></a>
            </div>
        </div>
    </div>

    <div class="content1">
        <div class="container">
            <div class="mt1 row">
                <div class="mt2 col-sm-4">
                    <div class="symbol1"><i class="ti-back-left"></i></div>
                    <h3 class="text1">CHÍNH SÁCH ĐỔI TRẢ</h3>
                    <p class="text2">Sẵn sàng đổi trả trong vòng 24h nếu quý khách không ưng ý mà không mất thêm bất cứ
                        khoản chi phí nào</p>
                </div>
                <div class="mt2 col-sm-4">
                    <div class="symbol2"><i class="ti-thumb-up"></i></div>
                    <h3 class="text1">ĐỘI NGŨ CHUYÊN NGHIỆP</h3>
                    <p class="text2">Với đội ngũ nhân viên có kinh nghiệm, nhiệt tình sẽ mang đến cho bạn dịch vụ hoàn
                        hảo nhất.</p>
                </div>
                <div class="mt2 col-sm-4">
                    <div class="symbol3"><i class="ti-location-pin"></i></div>
                    <h3 class="text1">CHÍNH SÁCH VẬN CHUYỂN</h3>
                    <p class="text2">Miễn phí vận chuyển cho các đơn hàng trên toàn quốc, hỗ trợ chi phí cho các bạn
                        hàng nước ngoài.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="shopping">
        <div class="reason">
            <h2>Lý do bạn nên chọn chúng tôi</h2>
            <p><i class="ti-minus"></i></p>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="symbol4"><i class=" ti-arrow-down"></i></div>
                    <h3 class="paragraph1">Giá cả tối ưu</h3>
                    <p class="paragraph2">DEKOR mang đến cho bạn những sản phẩm tốt nhất với thiết kế tinh tế và giá cả
                        phù hợp với từng đối tượng khách hàng.</p>
                </div>
                <div class="col-sm-4">
                    <div class="symbol5"> <i class="ti-arrows-horizontal"></i></div>
                    <h3 class="paragraph1">Lắp đặt nhanh chóng</h3>
                    <p class="paragraph2">DEKOR sẽ tới tận nơi lắp đặt nhanh chóng cho bạn trong vòng 24h kể từ lúc mua
                        hàng. Tư vấn miễn phí về vị trí lắp đặt.</p>
                </div>
                <div class="col-sm-4">
                    <div class="symbol6"> <i class="ti-settings"></i></div>
                    <h3 class="paragraph1">Dịch vụ hậu mãi tốt nhất</h3>
                    <p class="paragraph2">DEKOR đảm bảo mang đến cho bạn dịch vụ chăm sóc khách hàng tốt nhất, bảo hành
                        trong vòng 1 năm cho tất cả sản phẩm.</p>
                </div>
            </div>
        </div>
        <br> <br> <br>

        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="symbol6"><i class=" ti-reload"></i></div>
                    <h3 class="paragraph1">Giá cả tối ưu</h3>
                    <p class="paragraph2">DEKOR mang đến cho bạn những sản phẩm tốt nhất với thiết kế tinh tế và giá cả
                        phù hợp với từng đối tượng khách hàng.</p>
                </div>
                <div class="col-sm-4">
                    <div class="symbol4"> <i class="ti-light-bulb"></i></div>
                    <h3 class="paragraph1">Lắp đặt nhanh chóng</h3>
                    <p class="paragraph2">DEKOR sẽ tới tận nơi lắp đặt nhanh chóng cho bạn trong vòng 24h kể từ lúc mua
                        hàng. Tư vấn miễn phí về vị trí lắp đặt.</p>
                </div>
                <div class="col-sm-4">
                    <div class="symbol5"> <i class="ti-world"></i></div>
                    <h3 class="paragraph1">Dịch vụ hậu mãi tốt nhất</h3>
                    <p class="paragraph2">DEKOR đảm bảo mang đến cho bạn dịch vụ chăm sóc khách hàng tốt nhất, bảo hành
                        trong vòng 1 năm cho tất cả sản phẩm.</p>
                </div>
            </div>
        </div>
    </div>
    <br> <br> <br> <br>

    <div class="background" style="background-color:rgba(192,192,192,0.4)">
        <div class="container" style="padding-top:40px;padding-bottom: 56px;">
            <div class="reason">
                <h2>Được ưa thích nhất</h2>
                <p><i class="ti-minus"></i></p>
            </div>
            <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false"
                data-bs-interval="false">

            </div>
        </div>
    </div>

    <div class="bg">
        <div class="container">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="checkbox">
                            <h3 class="letter1"> - Bộ sưu tập DEKOR'S new empire - </h3>
                            <p class="letter2"> Cùng đón chờ sự ra mắt của BST mới nhất từ Dekor vào ngày 18/12/2022</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="checkbox">
                            <h3 class="letter1"> - Bộ sưu tập nội thất Overrallt - </h3>
                            <p class="letter2"> Một sự kết hợp đặc biệt giữa IKEA và những nhà thiết kế hàng đầu Châu
                                Phi</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="reason">
            <h2>Bài viết mới nhất </h2>
            <p><i class="ti-minus"></i></p>
            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="drop1">
                                    <a href="./header/TinTuc1.html"><img src="./assets/imgs/1.webp" alt=""></a>
                                </div>
                                <p class="drop2"> Bí quyết bảo quản nội thất gỗ</p>
                            </div>
                            <div class="col-md-6">
                                <div class="drop1">
                                    <a href="./header/Tintuc2.html"><img src="./assets/imgs/2.webp" alt=""></a>
                                </div>
                                <p class="drop2"> Kinh nghiệm mua,bảo quản nội thất</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="drop1">
                                    <a href="./header/Tintuc3.html"><img src="./assets/imgs/3.webp" alt=""></a>
                                </div>
                                <p class="drop2"> Bố trí nội thất, cần tránh những gì? </p>
                            </div>
                            <div class="col-md-6">
                                <div class="drop1">
                                    <a href="./header/Tintuc4.html"><img src="./assets/imgs/4.webp" alt=""></a>
                                </div>
                                <p class="drop2"> Yêu cầu cơ bản trong thiết kế nội thất? </p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="drop1">s
                                    <a href="./header/Tintuc5.html"><img src="./assets/imgs/5.webp" alt=""></a>
                                </div>
                                <p class="drop2"> Khi đặt cửa cần quan tâm những gì?</p>
                            </div>
                            <div class="col-md-6">
                                <div class="drop1">
                                    <a href="./header/Tintuc6.html"><img src="./assets/imgs/6.webp" alt=""></a>
                                </div>
                                <p class="drop2"> Vật liệu nhẹ - Giải pháp tối ưu</p>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>


    <div class="classical">
        <div class="container-fluid">
            <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="10000">
                        <div class="block1 row">
                            <div class="block2 col-md-2">
                                <img src="./assets/imgs/hieu_1.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="block2 col-md-2">
                                <img src="./assets/imgs/hieu_2.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="block2 col-md-2">
                                <img src="./assets/imgs/hieu_1.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="block2 col-md-2">
                                <img src="./assets/imgs/hieu_2.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="block2 col-md-2">
                                <img src="./assets/imgs/hieu_1.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="block2 col-md-2">
                                <img src="./assets/imgs/hieu_2.webp" class="d-block w-100" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                        <div class="block1 row">
                            <div class="block2 col-md-2">
                                <img src="./assets/imgs/hieu_1.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="block2 col-md-2">
                                <img src="./assets/imgs/hieu_2.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="block2 col-md-2">
                                <img src="./assets/imgs/hieu_1.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="block2 col-md-2">
                                <img src="./assets/imgs/hieu_2.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="block2 col-md-2">
                                <img src="./assets/imgs/hieu_1.webp" class="d-block w-100" alt="...">
                            </div>
                            <div class="block2 col-md-2">
                                <img src="./assets/imgs/hieu_2.webp" class="d-block w-100" alt="...">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <?php
    include './views/templates/Footer.php';
    ?>
    <script src="./SanPham/js/data.js"></script>
    <script src="./SanPham/js/product.js"></script>
    <script src="./SanPham/js/icon_cart.js"></script>
    <script src="./SanPham/js/account.js"></script>
    <script>
        function updateUrl(categories, brands) {
            // Mã hóa categories và brands thành chuỗi JSON và sau đó mã hóa URL
            const encodedCategories = (JSON.stringify(categories));
            const encodedBrands = (JSON.stringify(brands));

            // Cập nhật URL với các tham số mới
            const url = new URL(getBasePath() + '/SanPham/html/category/product.html'); // Chuyển hướng đến trang sản phẩm
            url.searchParams.set('categories', encodedCategories);
            url.searchParams.set('brands', encodedBrands);

            // Chuyển hướng đến URL mới
            window.location.href = url.toString();
        }

        function renderTopProductsCarousel(containerId, orders) {
            const productsCount = {};

            // Duyệt qua từng đơn hàng để đếm số lượng sản phẩm được mua
            orders.forEach(order => {
                order.products.forEach(product => {
                    if (productsCount[product.id]) {
                        productsCount[product.id].quantity += product.quantity;
                    } else {
                        productsCount[product.id] = {
                            ...product,
                            quantity: product.quantity
                        };
                    }
                });
            });

            // Sắp xếp sản phẩm theo số lượng mua giảm dần
            const topProducts = Object.values(productsCount)
                .sort((a, b) => b.quantity - a.quantity)
                .slice(0, 6); // Lấy 6 sản phẩm

            // Hàm tạo HTML cho một sản phẩm
            function createProductHTML(product) {
                return `
            <div class="col-md-4">
                <div class="thumb-wrapper">
                    <div class="img-box">
                        <img src="${getBasePath()+product.image}" class="img-fluid" alt="${product.title}">
                    </div>
                    <div class="thumb-content">
                        <h5 style="
                            white-space: nowrap; 
                            overflow: hidden; 
                            text-overflow: ellipsis; 
                            width: 100%; 
                            display: block;">${product.title}</h5>
                        <p class="item-price">
                            <span>${product.price.toLocaleString("vi-VN")} đ</span>
                        </p>
                        <a href="${getBasePath()}/SanPham/html/category/detail_item/product_detail.html?id=${product.id}" class="textbox btn btn-default">Xem Thêm</a>
                    </div>
                </div>
            </div>
        `;
            }

            // Render sản phẩm vào carousel
            const carouselContainer = document.getElementById(containerId);
            const carouselInner = document.createElement('div');
            carouselInner.className = 'carousel-inner';

            // Chia sản phẩm thành các nhóm 3 sản phẩm cho từng slide
            for (let i = 0; i < topProducts.length; i += 3) {
                const slideProducts = topProducts.slice(i, i + 3);
                const isActive = i === 0 ? 'active' : '';

                const slideHTML = `
            <div class="carousel-item ${isActive}">
                <div class="row">
                    ${slideProducts.map(createProductHTML).join('')}
                </div>
            </div>
        `;

                carouselInner.innerHTML += slideHTML;
            }

            // Gắn carouselInner vào container
            carouselContainer.innerHTML = '';
            carouselContainer.appendChild(carouselInner);

            // Thêm các nút điều khiển
            carouselContainer.innerHTML += `
        <button class="carousel-control-prev" type="button" data-bs-target="#${containerId}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#${containerId}" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    `;

            console.log('Carousel updated with top products!');
        }

        renderTopProductsCarousel('carouselExampleControlsNoTouching', orders);
    </script>
</body>

</html>