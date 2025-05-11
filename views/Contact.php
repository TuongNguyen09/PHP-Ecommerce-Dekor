<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css">
    <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css">
    <script src="/style.js"></script>
    <link rel="stylesheet" href="../assets/css/cart.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <title>Liên Hệ</title>
</head>

<body>
    <?php
    include './templates/Header.php';
    ?>


    <section class="category">
        <div class="category_top_nav">
            <ul class="topten line_up">
                <li><a href="../Index.php">Trang chủ</a></li>
                <li><i class="ti-angle-right"></i></li>
                <li class="shock">Liên Hệ</li>
            </ul>
            <hr>
        </div>
    </section>

    <div class="door">
        <div class="choke">
            <h3 class="boong"> Liên hệ </h3>
            <p><i class="ti-minus"></i></p>
        </div>

        <div class="container">
            <div class="section row">
                <div class="col-lg-6">
                    <div id="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31355.76526341499!2d106.68085287637966!3d10.775218717803318!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f38f9ed887b%3A0x14aded5703768989!2sDistrict%201%2C%20Ho%20Chi%20Minh%20City%2C%20Vietnam!5e0!3m2!1sen!2s!4v1668325691729!5m2!1sen!2s"
                            width="100%" height="320" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="section1">
                        <div class="section2">
                            <h4>Thông tin cửa hàng </h4>
                        </div>
                        <div class="section3">
                            <ul class="max1">
                                <li>
                                    <span><i class="ti-location-pin"></i></span>
                                    <p>Đường Số 1, Quận 1, Thành Phố Hồ Chí Minh, Việt Nam</p>
                                </li>
                                <li>
                                    <span><i class="ti-headphone-alt"></i></span>
                                    <p><a href="#">+84 123 456 789</a>
                                        <br />
                                        <a href="#">+84 987 654 321</a>
                                    </p>
                                </li>
                                <li>
                                    <span><i class="ti-email"></i></span>
                                    <p><a href="#">diachiemail@gmail.com</a></p>
                                </li>
                            </ul>
                        </div>
                        <div class="section2">
                            <h4>Theo dõi chúng tôi </h4>
                        </div>
                        <div class="section3">
                            <ul class="section4">
                                <li><a href="#"><i class="ti-facebook"></i></a></li>
                                <li><a href="#"><i class="ti-twitter"></i></a></li>
                                <li><a href="#"><i class="ti-email"></i></a></li>
                                <li><a href="#"><i class="ti-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="long">
                <div class="long1">
                    <h3>Liên hệ với chúng tôi</h3>
                </div>

                <form class="cc1">
                    <div class="cc2 form-group">
                        <label for="exampleFormControlInput1">Họ và tên : </label>
                        <input type="text" class="form-control" id="exampleFormControlInput1"
                            placeholder="Nhập Họ và Tên:*">
                    </div>
                    <div class="cc2 form-group">
                        <label for="exampleFormControlInput1">Email : </label>
                        <input type="email" class="form-control" id="exampleFormControlInput1"
                            placeholder="Nhập Email:*">
                    </div>
                    <div class="cc2 form-group">
                        <label for="exampleFormControlTextarea1">Nội dung : </label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <button type="submit" class="cc3 btn btn-primary">Gửi Liên Hệ</button>

                </form>
            </div>
        </div>


    </div>

    <?php
    include './templates/Footer.php';
    ?>
</body>

</html>