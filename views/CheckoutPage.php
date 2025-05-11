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
    <title>Tạo Trang Thanh Toán</title>
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.2.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/font_Roboto/Roboto-Bold.ttf">
    <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/cart.css">
    <link rel="stylesheet" href="../assets/css/checkout.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .form-group .input-wrapper .dropdown {
        display: none;
        position: absolute;
        border: 1px solid #ddd;
        background-color: white;
        width: 200px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 10;
    }

    .form-group .input-wrapper .dropdown .dropdown-item {
        padding: 10px;
        cursor: pointer;
    }

    .form-group .input-wrapper .dropdown .dropdown-item:hover {
        background-color: #f0f0f0;
    }

    .form-container input {
        padding: 10px;
        width: 300px;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-footer {
        border-top: none;
    }

    .address-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .address-item input[type="radio"] {
        margin-right: 10px;
    }

    .default-label {
        background-color: #f8f9fa;
        color: #dc3545;
        border: 1px solid #dc3545;
        padding: 2px 5px;
        border-radius: 3px;
        font-size: 12px;
        margin-left: 10px;
    }

    .address-type-buttons button {
        margin-right: 10px;
    }
</style>

<body>
    <?php
    include './templates/Header.php';
    ?>
    <main>

        <!-- Block content - Đục lỗ trên giao diện bố cục chung, đặt tên là `content` -->
        <div class="container">

            <div class="py-5 text-center">
                <p class="lead" style="color: red;">Vui lòng kiểm tra thông tin Khách hàng, thông tin Giỏ hàng trước khi
                    Đặt hàng.</p>
            </div>

            <form class="needs-validation" name="frmthanhtoan" action="../../SanPham/html/thanks.html">
                <div class="row">
                    <div class="col-md-4 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <a style="text-decoration:none;"><span style="font-weight: 600;">ĐƠN HÀNG:
                                </span></a>
                            <a style="text-decoration:none;" title="Mua hàng" class="cart1 ">
                                <span>0</span>
                            </a>
                        </h4>
                        <div class="col-25 ">
                            <ul class="list-group mb-3 ">
                                <div class="input-checkout ">
                                    <div style="width: 416px;">
                                        <ul style="list-style: none; padding-left: 0;">
                                            <li
                                                style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                <span>Áo Thun (x2)</span><span>300,000 VND</span>
                                            </li>
                                            <li
                                                style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                <span>Quần Jeans (x1)</span><span>300,000 VND</span>
                                            </li>
                                            <li
                                                style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                                <span>Phí vận chuyển</span><span>30,000 VND</span>
                                            </li>
                                            <li
                                                style="display: flex; justify-content: space-between; font-weight: bold; margin-top: 10px;">
                                                <span>Tổng cộng</span><span>630,000 VND</span>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </ul>
                        </div>

                        <div class="input-group ">
                            <input type="text " class="form-control " placeholder="Mã khuyến mãi ">
                            <div class="input-group-append ">
                                <button type="submit " class="btn btn-secondary ">Xác nhận</button>
                            </div>
                        </div>


                    </div>

                    <div class="col-md-8 order-md-1">
                        <h4 class="mb-3" style="font-weight: 600;">THÔNG TIN KHÁCH HÀNG</h4>
                        <div class="user-infor"
                            style="font-family: Arial, sans-serif; max-width: 900px; margin: 0 auto; display: flex; gap: 30px; padding: 20px;border-radius: 8px;">
                            <!-- Cột trái: Thông tin khách hàng -->
                            <div style="flex: 1;">
                                <input id="fullname" type="text" placeholder="Họ Tên"
                                    style="width: 60%; padding: 8px; margin-bottom: 10px;">
                                <input id="email" type="email" placeholder="Email"
                                    style="width: 60%; padding: 8px; margin-bottom: 10px;">
                                <input id="phone" type="tel" placeholder="Số Điện Thoại"
                                    style="width: 60%; padding: 8px; margin-bottom: 10px;">
                                <input id="address" type="tel" placeholder="Địa chỉ giao hàng"
                                    style="width: 60%; padding: 8px; margin-bottom: 10px;">
                                <a href="#" style="margin-left:8px" data-bs-toggle="modal"
                                    data-bs-target="#addressModal" onclick="showAddressList()">Thay đổi địa chỉ</a>
                                <br>

                                <h4 style="margin-top: 30px;">Hình Thức Thanh Toán</h4>
                                <div class="d-block my-3">
                                    <div class="custom-control custom-radio">
                                        <input id="httt-2" name="httt_ma" type="radio" class="custom-control-input"
                                            required="" value="Thanh toán tiền mặt" onclick="togglePaymentForm()">
                                        <label class="custom-control-label" for="httt-2">Thanh toán tiền mặt</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="httt-3" name="httt_ma" type="radio" class="custom-control-input"
                                            required="" value="Chuyển khoản" onclick="togglePaymentForm()">
                                        <label class="custom-control-label" for="httt-3">Chuyển khoản</label>
                                    </div>

                                    <!-- Form nhập thông tin chuyển khoản ngân hàng -->
                                    <div id="bankTransferForm"
                                        style="width:60%; display: block; overflow: hidden; height: 0; transition: height 0.5s ease-in-out;">
                                        <h5>Thông Tin Chuyển Khoản Ngân Hàng</h5>
                                        <div class="form-group">
                                            <label for="bankName">Tên Ngân Hàng</label>
                                            <select class="form-control" id="bankName" required>
                                                <option value="">Chọn ngân hàng</option>
                                                <option value="Vietcombank">Vietcombank</option>
                                                <option value="BIDV">BIDV</option>
                                                <option value="VietinBank">VietinBank</option>
                                                <option value="Agribank">Agribank</option>
                                                <option value="Techcombank">Techcombank</option>
                                                <option value="Sacombank">Sacombank</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="bankAccount">Số Tài Khoản</label>
                                            <input type="text" class="form-control" id="bankAccount"
                                                placeholder="Nhập số tài khoản ngân hàng" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="bankTransferDate">Ngày Chuyển Khoản</label>
                                            <input type="date" class="form-control" id="bankTransferDate" required>
                                        </div>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input id="httt-4" name="httt_ma" type="radio" class="custom-control-input"
                                            required="" value="Thanh toán qua thẻ" onclick="togglePaymentForm()">
                                        <label class="custom-control-label" for="httt-4">Thanh toán qua thẻ</label>
                                    </div>
                                </div>

                                <!-- Form nhập thông tin thẻ tín dụng -->
                                <div id="creditCardForm"
                                    style="width: 60%; display: block; overflow: hidden; height: 0; transition: height 0.5s ease-in-out;">
                                    <h5>Thông Tin Thẻ Tín Dụng</h5>
                                    <div class="form-group">
                                        <label for="cardNumber">Số Thẻ</label>
                                        <input type="text" class="form-control" id="cardNumber"
                                            placeholder="Nhập số thẻ" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="expiryDate">Ngày Hết Hạn</label>
                                        <input type="text" class="form-control" id="expiryDate" placeholder="MM/YYYY"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">Mã CVV</label>
                                        <input type="text" class="form-control" id="cvv" placeholder="Nhập mã CVV"
                                            required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <button class="btn btn-primary btn-lg btn-block" type="submit" name="btnDatHang"
                            onclick="placeOrder();">Mua hàng</button>
                        <hr>
                    </div>

                    <script>
                        // Hàm để hiển thị/ẩn các form nhập thông tin thanh toán (thẻ tín dụng và chuyển khoản ngân hàng)
                        function togglePaymentForm() {
                            var creditCardForm = document.getElementById("creditCardForm");
                            var bankTransferForm = document.getElementById("bankTransferForm");

                            // Kiểm tra xem phương thức thanh toán là "Thanh toán qua thẻ"
                            if (document.getElementById("httt-4").checked) {
                                creditCardForm.style.display = "block"; // Hiển thị form thẻ tín dụng
                                setTimeout(function() {
                                    creditCardForm.style.height = "auto"; // Mở rộng chiều cao của form
                                }, 50); // Đảm bảo có độ trễ nhỏ để transition có thể xảy ra
                            } else {
                                creditCardForm.style.height = "0"; // Thu gọn chiều cao của form
                                setTimeout(function() {
                                    creditCardForm.style.display = "none"; // Ẩn form thẻ tín dụng sau khi hoàn thành hiệu ứng
                                }, 50); // Thời gian delay để đợi hiệu ứng hoàn thành
                            }

                            // Kiểm tra xem phương thức thanh toán là "Chuyển khoản"
                            if (document.getElementById("httt-3").checked) {
                                bankTransferForm.style.display = "block"; // Hiển thị form chuyển khoản
                                setTimeout(function() {
                                    bankTransferForm.style.height = "auto"; // Mở rộng chiều cao của form
                                }, 50); // Đảm bảo có độ trễ nhỏ để transition có thể xảy ra

                                // Lấy ngày hiện tại và gán vào trường ngày chuyển khoản
                                var today = new Date();
                                var day = ("0" + today.getDate()).slice(-2); // Đảm bảo ngày có 2 chữ số
                                var month = ("0" + (today.getMonth() + 1)).slice(-2); // Tháng từ 0-11, cộng 1 để đúng tháng
                                var year = today.getFullYear();
                                var formattedDate = year + "-" + month + "-" + day; // Định dạng ngày thành YYYY-MM-DD

                                // Gán ngày hiện tại vào trường ngày chuyển khoản
                                document.getElementById("bankTransferDate").value = formattedDate;
                            } else {
                                bankTransferForm.style.height = "0"; // Thu gọn chiều cao của form
                                setTimeout(function() {
                                    bankTransferForm.style.display = "none"; // Ẩn form chuyển khoản sau khi hoàn thành hiệu ứng
                                }, 50); // Thời gian delay để đợi hiệu ứng hoàn thành
                            }
                        }
                    </script>




                </div>
        </div>
        </form>

        </div>


    </main>

    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressModalLabel">Địa Chỉ Của Tôi</h5>
                </div>
                <div class="modal-body">
                    <!-- Danh sách địa chỉ -->
                    <div id="addressList">
                        <button class="btn btn-outline-primary w-100" onclick="showAddForm()">+ Thêm Địa Chỉ Mới</button>
                    </div>

                    <!-- Form thêm mới và cập nhật địa chỉ -->
                    <form style="display:none !important" id="addAddressForm" action="controllers/AddressController.php?action=create" method="post">
                        <h5>Địa chỉ mới</h5>
                        <input type="hidden" name="user_id" value="<?= $_SESSION['userId'] ?? '' ?>">
                        <input type="hidden" name="address_id" id="addressId" value="">

                        <input type="hidden" name="province_name" id="provinceNameAdd">
                        <input type="hidden" name="district_name" id="districtNameAdd">
                        <input type="hidden" name="ward_name" id="wardNameAdd">

                        <div class="row mb-3">
                            <div class="col-4">
                                <select class="form-control" name="city" id="provinceSelectAdd">
                                    <option value="">Tỉnh/Thành phố</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <select class="form-control" name="district" id="districtSelectAdd" disabled>
                                    <option value="">Quận/Huyện</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <select class="form-control" name="ward" id="wardSelectAdd" disabled>
                                    <option value="">Phường/Xã</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <input id="street" type="text" class="form-control" name="street" placeholder="Địa chỉ cụ thể">
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_default" id="defaultAddress" value="1">
                            <label class="form-check-label" for="defaultAddress">Đặt làm địa chỉ mặc định</label>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitButton">Hoàn thành</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" id="backToListButton" style="display:none !important;" onclick="showAddressList()">Quay lại</button>
                    <button type="button" class="btn btn-danger" id="confirmButton" style="display:none;">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>


    <?php
    include './templates/Footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        let cartItemsGlobal = [];
        // Hàm gửi thông tin và đặt hàng
        function placeOrder() {
            var fullname = document.getElementById("fullname").value;
            var email = document.getElementById("email").value;
            var phone = document.getElementById("phone").value;
            var address = document.getElementById("address").value;
            var addressId = document.getElementById("address").getAttribute('data-id'); // Lấy ID của địa chỉ từ data-id

            // Lấy phương thức thanh toán đã chọn
            var paymentMethod = "";
            var paymentMethodElements = document.getElementsByName("httt_ma");
            paymentMethodElements.forEach(function(element) {
                if (element.checked) {
                    paymentMethod = element.value;
                }
            });

            // Nếu phương thức thanh toán là "Chuyển khoản" hoặc "Thanh toán qua thẻ", lấy thêm thông tin
            var bankInfo = null;
            var creditCardInfo = null;

            if (paymentMethod === "Chuyển khoản") {
                bankInfo = {
                    bankName: document.getElementById("bankName").value,
                    bankAccount: document.getElementById("bankAccount").value,
                    bankTransferDate: document.getElementById("bankTransferDate").value
                };
            } else if (paymentMethod === "Thanh toán qua thẻ") {
                creditCardInfo = {
                    cardNumber: document.getElementById("cardNumber").value,
                    expiryDate: document.getElementById("expiryDate").value,
                    cvv: document.getElementById("cvv").value
                };
            }

            // Tạo đối tượng order để gửi
            var order = {
                fullname: fullname,
                email: email,
                phone: phone,
                addressId: addressId, // Gửi id của địa chỉ
                paymentMethod: paymentMethod,
                bankInfo: bankInfo, // Gửi thông tin chuyển khoản (nếu có)
                creditCardInfo: creditCardInfo, // Gửi thông tin thẻ (nếu có)
                cartItems: cartItemsGlobal // Gửi kèm giỏ hàng
            };
            console.log(order);

            // Gửi thông tin order và cartItems qua fetch
            fetch("../controllers/OrderController.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json;charset=UTF-8"
                    },
                    body: JSON.stringify({
                        action: 'placeOrder',
                        order: order
                    })
                })
                .then(async (response) => {
                    const contentType = response.headers.get("Content-Type") || "";
                    const text = await response.text(); // Đọc phản hồi dưới dạng văn bản thô
                    console.log("Response:", text); // In ra phản hồi
                    if (contentType.includes("application/json")) {
                        return JSON.parse(text); // Chỉ parse nếu thực sự là JSON
                    } else {
                        throw new Error("Server trả về không phải JSON:\n" + text);
                    }
                })
                .then(data => {
                    if (data.status === 'success') {
                        console.log("Đặt hàng thành công", data.message);
                    } else {
                        console.log("Đặt hàng thất bại:", data.message);
                        alert("Đặt hàng thất bại: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Lỗi:", error);
                    alert("Đặt hàng thất bại. " + error.message);
                });
        }



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

        // Hàm lấy dữ liệu tỉnh/thành phố
        async function fetchProvinces(selectId) {
            try {
                const response = await fetch('https://provinces.open-api.vn/api/?depth=1');
                if (!response.ok) throw new Error('Failed to fetch provinces');
                const data = await response.json();
                const provinceSelect = document.getElementById(selectId);
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.code;
                    option.textContent = province.name;
                    provinceSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error fetching provinces:', error);
            }
        }

        // Hàm lấy dữ liệu quận/huyện dựa trên tỉnh/thành phố
        async function fetchDistricts(provinceCode, selectId) {
            const districtSelect = document.getElementById(selectId);
            districtSelect.innerHTML = '<option value="">Quận/Huyện</option>';
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

        // Hàm lấy dữ liệu phường/xã dựa trên quận/huyện
        async function fetchWards(districtCode, selectId) {
            const wardSelect = document.getElementById(selectId);
            wardSelect.innerHTML = '<option value="">Phường/Xã</option>';
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

        // Xử lý sự kiện cho form thêm địa chỉ
        async function setupAddFormEvents() {
            const provinceSelect = document.getElementById('provinceSelectAdd');
            const districtSelect = document.getElementById('districtSelectAdd');
            const wardSelect = document.getElementById('wardSelectAdd');

            const provinceName = document.getElementById('provinceNameAdd');
            const districtName = document.getElementById('districtNameAdd');
            const wardName = document.getElementById('wardNameAdd');

            provinceSelect.addEventListener('change', () => {
                const provinceCode = provinceSelect.value;
                if (provinceCode) {
                    // Cập nhật tên tỉnh vào trường ẩn
                    provinceName.value = provinceSelect.options[provinceSelect.selectedIndex].text;
                    fetchDistricts(provinceCode, 'districtSelectAdd');
                    districtSelect.disabled = false;
                } else {
                    districtSelect.innerHTML = '<option value="">Quận/Huyện</option>';
                    districtSelect.disabled = true;
                    wardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                    wardSelect.disabled = true;
                    provinceName.value = ''; // Clear tên tỉnh
                }
            });

            districtSelect.addEventListener('change', () => {
                const districtCode = districtSelect.value;
                if (districtCode) {
                    // Cập nhật tên quận vào trường ẩn
                    districtName.value = districtSelect.options[districtSelect.selectedIndex].text;
                    fetchWards(districtCode, 'wardSelectAdd');
                    wardSelect.disabled = false;
                } else {
                    wardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                    wardSelect.disabled = true;
                    districtName.value = ''; // Clear tên quận
                }
            });

            wardSelect.addEventListener('change', () => {
                const wardCode = wardSelect.value;
                if (wardCode) {
                    // Cập nhật tên phường vào trường ẩn
                    wardName.value = wardSelect.options[wardSelect.selectedIndex].text;
                } else {
                    wardName.value = ''; // Clear tên phường
                }
            });
        }

        // Gọi hàm setup form khi trang tải xong
        document.addEventListener('DOMContentLoaded', setupAddFormEvents);


        // Xử lý sự kiện cho form cập nhật địa chỉ
        function setupUpdateFormEvents() {
            const provinceSelect = document.getElementById('provinceSelectUpdate');
            const districtSelect = document.getElementById('districtSelectUpdate');
            const wardSelect = document.getElementById('wardSelectUpdate');

            provinceSelect.addEventListener('change', () => {
                const provinceCode = provinceSelect.value;
                fetchDistricts(provinceCode, 'districtSelectUpdate');
                wardSelect.innerHTML = '<option value="">Phường/Xã</option>';
                wardSelect.disabled = true;
            });

            districtSelect.addEventListener('change', () => {
                const districtCode = districtSelect.value;
                fetchWards(districtCode, 'wardSelectUpdate');
            });
        }

        function showAddForm() {
            document.getElementById('addressList').style.display = 'none';
            document.getElementById('addAddressForm').style.display = 'block';
            document.getElementById('confirmButton').style.display = "none";

            // Hiển thị nút "Quay lại danh sách địa chỉ"
            document.getElementById('backToListButton').style.display = 'block';

            // Thay đổi tiêu đề modal
            document.getElementById('addressModalLabel').innerText = "Thêm Địa Chỉ Mới";

            // Thay đổi nút "Hoàn thành"
            document.getElementById('submitButton').innerText = "Hoàn thành";

            // Xóa dữ liệu cũ trong form khi thêm mới
            document.getElementById('addressId').value = ''; // Reset ID
            document.getElementById('street').value = ''; // Reset street
            document.getElementById('defaultAddress').checked = false; // Reset checkbox

            if (document.getElementById('provinceSelectAdd').options.length <= 1) {
                fetchProvinces('provinceSelectAdd').then(setupAddFormEvents);
            }
        }

        function showUpdateForm(addressId) {
            fetch(`../controllers/AddressController.php?action=get&id=${addressId}`)
                .then(res => res.json())
                .then(address => {
                    console.log(address);

                    // Hiển thị form cập nhật, ẩn danh sách
                    document.getElementById('addAddressForm').style.display = 'block';
                    document.getElementById('addressList').style.display = 'none';

                    // Hiển thị nút "Quay lại danh sách địa chỉ"
                    document.getElementById('backToListButton').style.display = 'block';

                    // Thay đổi tiêu đề modal
                    document.getElementById('addressModalLabel').innerText = "Cập Nhật Địa Chỉ";

                    // Thay đổi nút "Hoàn thành"
                    document.getElementById('submitButton').innerText = "Cập nhật";

                    // Điền địa chỉ cụ thể
                    document.getElementById('street').value = address.street;

                    // Gọi chuỗi load tỉnh -> quận -> phường theo giá trị có sẵn
                    fetchProvinces('provinceSelectAdd', () => {
                        const provinceSelect = document.getElementById('provinceSelectAdd');
                        const provinceId = getOptionValueByText(provinceSelect, address.city);
                        setSelectedOptionByValue(provinceSelect, provinceId);

                        // Sau khi tỉnh được chọn, tải quận
                        fetchDistricts(provinceId, 'districtSelectAdd', () => {
                            const districtSelect = document.getElementById('districtSelectAdd');
                            const districtId = getOptionValueByText(districtSelect, address.district);
                            setSelectedOptionByValue(districtSelect, districtId);

                            // Sau khi quận được chọn, tải phường
                            fetchWards(districtId, 'wardSelectAdd', () => {
                                const wardSelect = document.getElementById('wardSelectAdd');
                                const wardId = getOptionValueByText(wardSelect, address.ward);
                                setSelectedOptionByValue(wardSelect, wardId);
                            });
                        });
                    });

                    // Gán dữ liệu ẩn nếu cần
                    document.getElementById('addressId').value = address.id;
                    document.getElementById('provinceNameAdd').value = address.city;
                    document.getElementById('districtNameAdd').value = address.district;
                    document.getElementById('wardNameAdd').value = address.ward;

                    // Xử lý checkbox
                    document.getElementById('defaultAddress').checked = !!address.is_default;

                    // Đổi action của form
                    document.getElementById('addAddressForm').action = `../controllers/AddressController.php?action=update&id=${addressId}`;
                })
                .catch(err => {
                    console.error('Lỗi khi lấy thông tin địa chỉ:', err);
                });
        }


        function getOptionValueByText(selectElement, text) {
            for (let option of selectElement.options) {
                if (option.text.trim() === text.trim()) {
                    return option.value;
                }
            }
            return '';
        }

        function setSelectedOptionByValue(selectElement, value) {
            for (let option of selectElement.options) {
                option.selected = option.value === value;
            }
        }

        // Reset to address list when modal is closed
        document.getElementById('addressModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('addressList').style.display = 'block';
            document.getElementById('addAddressForm').style.display = 'none';
            document.getElementById('confirmButton').style.dislay = 'block';
            document.getElementById('confirmButton').innerText = 'Xác nhận';

            // Ẩn nút "Quay lại danh sách địa chỉ"
            document.getElementById('backToListButton').style.display = 'none';

            // Reset lại tiêu đề modal và nút
            document.getElementById('addressModalLabel').innerText = "Địa Chỉ Của Tôi";
            document.getElementById('submitButton').innerText = "Hoàn thành";
        });
        const userId = sessionStorage.getItem("userId");

        function loadAddresses() {
            return fetch('../controllers/AddressController.php?action=list')
                .then(res => res.text())
                .then(text => {
                    let data;
                    try {
                        data = JSON.parse(text);
                        console.log('Danh sách địa chỉ:', data.addresses);
                    } catch (e) {
                        throw new Error('Phản hồi không phải JSON: ' + text);
                    }

                    if (!data.addresses || data.addresses.length === 0) {
                        document.getElementById('addressList').innerHTML = '<p>Chưa có địa chỉ nào.</p>';
                        return []; // Trả về mảng rỗng nếu không có địa chỉ
                    }

                    const container = document.getElementById('addressList');
                    container.innerHTML = '';
                    let checkedAssigned = false;

                    data.addresses.forEach(addr => {
                        const div = document.createElement('div');
                        div.className = 'address-item';
                        const isChecked = addr.is_default == 1 && !checkedAssigned ? 'checked' : '';
                        if (isChecked) checkedAssigned = true;

                        div.innerHTML = `
                    <input type="radio" name="address" id="address_${addr.id}" ${isChecked}>
                    <div>
                        <span>${addr.street}, ${addr.ward}, ${addr.district}, ${addr.city}</span>
                        ${addr.is_default == 1 ? '<span class="default-label">Mặc định</span>' : ''}
                    </div>
                    <a href="#" style="margin-left: auto;" onclick="showUpdateForm(${addr.id})">Cập nhật</a>
                `;
                        container.appendChild(div);
                    });

                    const btn = document.createElement('button');
                    btn.className = 'btn btn-outline-primary w-100';
                    btn.textContent = '+ Thêm Địa Chỉ Mới';
                    btn.onclick = showAddForm;
                    container.appendChild(btn);

                    return data.addresses; // ✅ Trả về danh sách địa chỉ
                })
                .catch(err => {
                    const container = document.getElementById('addressList');
                    container.innerHTML = `<p class="text-danger">Lỗi: ${err.message}</p>`;
                    console.error('Lỗi phản hồi:', err);
                    return []; // Trả về mảng rỗng khi lỗi
                });
        }


        // document.getElementById('addressModal').addEventListener('shown.bs.modal', function() {
        //     loadAddresses();
        // });

        async function submitAddressForm(event) {
            event.preventDefault();

            const form = document.getElementById('addAddressForm');
            const formData = new FormData(form);

            const provinceSelect = document.getElementById('provinceSelectAdd');
            const districtSelect = document.getElementById('districtSelectAdd');
            const wardSelect = document.getElementById('wardSelectAdd');

            const provinceName = provinceSelect.options[provinceSelect.selectedIndex].text;
            const districtName = districtSelect.options[districtSelect.selectedIndex].text;
            const wardName = wardSelect.options[wardSelect.selectedIndex].text;

            if (!provinceSelect.value || !districtSelect.value || !wardSelect.value) {
                alert('Vui lòng chọn đầy đủ thông tin địa chỉ.');
                return;
            }

            // Thêm tên để controller có thể dùng nếu cần
            formData.set('province_name', provinceName);
            formData.set('district_name', districtName);
            formData.set('ward_name', wardName);

            const addressId = formData.get('address_id');
            console.log(addressId);
            const action = addressId ? 'update' : 'create';

            try {
                const response = await fetch(`../controllers/AddressController.php?action=${action}&id=${addressId}`, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    loadAddresses();
                    form.reset();
                    document.getElementById('addAddressForm').style.display = 'none';
                    document.getElementById('addressList').style.display = 'block';
                    document.getElementById('backToListButton').style.display = 'none';

                    // Hiển thị nút xác nhận
                    document.getElementById('confirmButton').style.display = 'block';
                } else {
                    alert(result.message);
                }
            } catch (error) {
                console.error('Lỗi khi gửi địa chỉ:', error);
                alert('Đã có lỗi xảy ra. Vui lòng thử lại!');
            }
        }


        // Gán sự kiện submit cho form
        document.getElementById('addAddressForm').addEventListener('submit', submitAddressForm);

        console.log(userId);
        fetch(`../controllers/UserController.php?action=getMyInfo`)
            .then(async res => {
                const contentType = res.headers.get("content-type");

                if (contentType && contentType.includes("application/json")) {
                    const user = await res.json();
                    console.log("Dữ liệu user nhận được:", user);

                    if (user && user.status === 'success') {
                        const u = user.user; // user.user là object chứa thông tin người dùng
                        document.getElementById('fullname').value = u.fullname || "alo";
                        document.getElementById('email').value = u.email || "";
                        document.getElementById('phone').value = u.phone || "";

                        // Lấy danh sách địa chỉ và cập nhật ô radio
                        loadAddresses().then(addresses => {
                            // Kiểm tra địa chỉ nào được chọn và gán vào form
                            const selectedAddress = addresses.find(addr => addr.is_default == 1);
                            if (selectedAddress) {
                                // Cập nhật giá trị địa chỉ vào ô input và gán data-id
                                const addressInput = document.getElementById('address');
                                addressInput.value = selectedAddress.street + ', ' + selectedAddress.ward + ', ' + selectedAddress.district + ', ' + selectedAddress.city;
                                addressInput.setAttribute('data-id', selectedAddress.id); // Gán data-id cho input address
                            }

                            // Cập nhật các ô radio với danh sách địa chỉ
                            addresses.forEach(addr => {
                                const addressRadio = document.getElementById(`address_${addr.id}`);
                                if (addressRadio) {
                                    addressRadio.checked = addr.is_default == 1; // Đánh dấu địa chỉ mặc định
                                }
                            });

                            // Thêm sự kiện click vào nút "Xác nhận"
                            document.getElementById('confirmButton').addEventListener('click', () => {
                                // Kiểm tra địa chỉ nào được chọn khi click "Xác nhận"
                                const selectedRadio = addresses.find(addr => document.getElementById(`address_${addr.id}`).checked);

                                if (selectedRadio) {
                                    // Cập nhật giá trị address khi chọn địa chỉ mới
                                    const addressInput = document.getElementById('address');
                                    addressInput.value = selectedRadio.street + ', ' + selectedRadio.ward + ', ' + selectedRadio.district + ', ' + selectedRadio.city;
                                    addressInput.setAttribute('data-id', selectedRadio.id); // Gán data-id cho input address khi chọn địa chỉ mới
                                }

                                // Đóng modal và ẩn màn hình tối (overlay)
                                const modal = document.getElementById('addressModal');
                                modal.classList.remove('show');
                                modal.style.display = 'none';

                                // Xóa tất cả các backdrop dư thừa
                                const backdrops = document.querySelectorAll('.modal-backdrop');
                                backdrops.forEach(backdrop => backdrop.remove());
                            });
                        });

                    } else {
                        console.warn("Lỗi: ", user.message);
                    }
                } else {
                    const text = await res.text();
                    console.warn("Phản hồi không phải JSON. Nội dung:", text);
                }
            })
            .catch(err => console.error("Lỗi khi lấy user:", err));


        fetch(`../controllers/CartController.php?action=getCartItems`)
            .then(res => res.json())
            .then(response => {
                if (response.status === "success") {
                    const cartItems = response.items;
                    cartItemsGlobal = cartItems; // gán vào biến toàn cục
                    const cartList = document.querySelector(".input-checkout ul");
                    cartList.innerHTML = "";
                    let total = 0;

                    cartItems.forEach(item => {
                        const li = document.createElement("li");
                        li.setAttribute("style", "display: flex; justify-content: space-between; margin-bottom: 8px;");
                        li.innerHTML = `
        <span style="width:200px">${item.name} (x${item.quantity})</span>
        <span style="width:200px;text-align: right; margin-left: auto;">${(item.price * item.quantity).toLocaleString()} VND</span>
    `;
                        cartList.appendChild(li);
                        total += item.price * item.quantity;
                    });


                    const shipping = 30000;
                    total += shipping;

                    const liShipping = document.createElement("li");
                    liShipping.setAttribute("style", "margin-top:20px;display: flex; justify-content: space-between; margin-bottom: 8px;");
                    liShipping.innerHTML = `
                <span style="width:200px">Phí vận chuyển</span>
                <span>${shipping.toLocaleString()} VND</span>
            `;
                    cartList.appendChild(liShipping);

                    const liTotal = document.createElement("li");
                    liTotal.setAttribute("style", "display: flex; justify-content: space-between; font-weight: bold; margin-top: 10px;");
                    liTotal.innerHTML = `
                <span>Tổng cộng</span>
                <span>${total.toLocaleString()} VND</span>
            `;
                    cartList.appendChild(liTotal);

                    // Cập nhật số lượng sản phẩm trong .cart1 span
                    document.querySelector(".cart1 span").textContent =
                        parseInt(cartItems.reduce((sum, i) => sum + parseInt(i.quantity || 0), 0));

                } else {
                    console.error("Lỗi từ server:", response.message);
                }
            })
            .catch(err => console.error("Lỗi khi lấy giỏ hàng:", err));
        // Hàm để quay lại danh sách địa chỉ
        function showAddressList() {
            // Ẩn form thêm mới
            document.getElementById('addAddressForm').style.display = 'none';

            // Hiển thị danh sách địa chỉ
            document.getElementById('addressList').style.display = 'block';

            // Ẩn nút quay lại
            document.getElementById('backToListButton').style.display = 'none';

            // Hiển thị nút xác nhận
            document.getElementById('confirmButton').style.display = 'block';

            // Thay đổi tiêu đề modal
            document.getElementById('addressModalLabel').innerText = "Địa Chỉ Của Tôi";
        }
    </script>
</body>

</html>