<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['adminId'])) {
    echo "<script>
        alert('Vui lòng đăng nhập với quyền admin');
        window.location.href = 'signinadmin.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/admin.css" />
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css" />
    <link rel="stylesheet" href="../assets/bootstrap-5.2.2-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/font_Roboto/Roboto-Bold.ttf" />
    <link rel="stylesheet" href="../assets/css/themify-icons/themify-icons.css" />
    <link rel="stylesheet" href="../assets/css/product.css" />
    <script src="../assets/js/jquery.min.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../assets/css/cart.css" />
    <!-- <link rel="stylesheet" href="/package/dist/sweetalert2.min.css"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <title>Quản lý sản phẩm</title>
</head>

<body>
    <?php
    include './Header.php';
    ?>

    <div class="content">
        <div class="row">
            <div class="title col-12 box_shadow">
                <ul class="line_up">
                    <li>
                        <a href="../../html/admin/data_product.html">Quản lý sản phẩm</a>
                    </li>
                    <li><i class="fas fa-chevron-right"></i></li>
                    <li>Tạo mới sản phẩm</li>
                </ul>
            </div>
        </div>
        <div class="row main_frame box_card box_shadow">
            <div class="sub_title">
                <h5><b>Tạo mới sản phẩm</b></h5>
                <div></div>
            </div>
            <form class="form_add" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Mã sản phẩm</label>
                        <input type="text" class="form-control" id="code" disabled readonly />
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Tên sản phẩm</label>
                        <input type="text" class="form-control" id="title" name="title" />
                        <small id="error-title" class="text-danger"></small>
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Số lượng</label>
                        <input type="number" class="form-control" id="amount" name="amount" />
                        <small id="error-amount" class="text-danger"></small>
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Tình trạng</label>
                        <select class="form-select" id="status" name="status">
                            <option selected>--Tình trạng--</option>
                            <option value="Còn hàng">Còn hàng</option>
                            <option value="Hết hàng">Hết hàng</option>
                        </select>
                        <small id="error-status" class="text-danger"></small>
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Danh mục</label>
                        <select class="form-select" id="category" name="category">
                            <option value="" selected>--Danh mục--</option>
                            <!-- Options -->
                        </select>
                        <small id="error-category" class="text-danger"></small>
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Nhà cung cấp</label>
                        <select class="form-select" id="Suppliers" name="Suppliers">
                            <option selected>--Nhà cung cấp--</option>
                            <!-- Options -->
                        </select>
                        <small id="error-suppliers" class="text-danger"></small>
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Giá bán</label>
                        <input type="number" class="form-control" id="price" name="price" />
                        <small id="error-price" class="text-danger"></small>
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Ảnh sản phẩm</label>
                        <button class="hinh form-control" type="button" id="uploadBtn">Tải ảnh</button>
                        <input style="display: none" type="file" id="files" name="image" />
                        <span id="previewImg"></span>
                        <small id="error-image" class="text-danger"></small>
                    </div>
                    <div class="form_group col-12">
                        <label>Mô tả sản phẩm</label>
                        <div contenteditable="true" id="editableDiv">
                            Bạn có thể nhập văn bản và chèn hình ảnh vào đây.
                        </div>
                        <small id="error-description" class="text-danger"></small>
                    </div>
                </div>
                <div class="element_btn">
                    <div class="add_img">
                        <label class="custom-upload-button" for="imageInput">Thêm ảnh</label>
                        <input type="file" id="imageInput" accept="image/*" />
                        <input type="hidden" name="description" id="hiddenDescription">
                    </div>
                    <div class="add_product">
                        <button type="submit" class="addnew_btn">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ----------------------- Script ----------------------- -->
    <!-- <script src="../../package/dist/sweetalert2.all.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="../../bootstrap-5.2.2-dist/js/bootstrap.bundle.js"></script>
    <script src="../../js/jquery.min.js"></script>
    <script>
        let savedRange = null;
        const editableDiv = document.getElementById("editableDiv");
        const imageInput = document.getElementById("imageInput");
        const hiddenDescription = document.getElementById("hiddenDescription");
        const form = document.querySelector(".form_add");

        // Lưu vị trí con trỏ chỉ khi đang trong editableDiv
        editableDiv.addEventListener("mouseup", saveRange);
        editableDiv.addEventListener("keyup", saveRange);
        editableDiv.addEventListener("blur", saveRange);

        function saveRange() {
            const selection = window.getSelection();
            if (selection.rangeCount > 0 && editableDiv.contains(selection.anchorNode)) {
                savedRange = selection.getRangeAt(0).cloneRange();
            }
        }

        // Chọn ảnh
        imageInput.addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (!file || !file.type.startsWith("image/")) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.maxWidth = "100%";
                img.style.display = "block"; // tránh bị inline gây lỗi

                insertImageAtSavedCursor(img);
            };
            reader.readAsDataURL(file);
        });

        function insertImageAtSavedCursor(imgElement) {
            editableDiv.focus();

            const selection = window.getSelection();
            if (savedRange && editableDiv.contains(savedRange.startContainer)) {
                selection.removeAllRanges();
                selection.addRange(savedRange);

                const range = selection.getRangeAt(0);
                range.deleteContents();
                range.insertNode(imgElement);

                // Nếu cần, tạo thẻ br sau ảnh để đảm bảo không bị dính ảnh vào text tiếp theo
                const br = document.createElement("br");
                range.insertNode(br);

                // Cập nhật vị trí con trỏ mới
                range.setStartAfter(br);
                range.setEndAfter(br);
                selection.removeAllRanges();
                selection.addRange(range);

                // Cập nhật lại savedRange
                savedRange = selection.getRangeAt(0).cloneRange();
            } else {
                // Nếu không có range hợp lệ, thêm vào cuối editableDiv
                editableDiv.appendChild(imgElement);
                editableDiv.appendChild(document.createElement("br"));
            }
        }

        // Trước khi submit, đưa nội dung vào input ẩn
        form.addEventListener('submit', function() {
            // Lọc thẻ <br> nếu cần thiết
            let content = editableDiv.innerHTML;
            content = content.replace(/<br\s*\/?>/g, ''); // Lọc tất cả các thẻ <br>

            // Đặt nội dung vào input ẩn
            hiddenDescription.value = content;
        });




        document.addEventListener('DOMContentLoaded', function() {
            // Render brand
            fetch('../controllers/BrandController.php?action=getBrands')
                .then(res => res.json())
                .then(data => {
                    const selectBrand = document.getElementById('Suppliers');
                    data.brands.forEach(brand => {
                        const option = document.createElement('option');
                        option.value = brand.id;
                        option.textContent = brand.name;
                        selectBrand.appendChild(option);
                    });
                });

            // Render category
            fetch('../controllers/CategoryController.php?action=getCategories')
                .then(res => res.json())
                .then(data => {
                    const selectCategory = document.getElementById('category');
                    data.categories.forEach(cat => {
                        const option = document.createElement('option');
                        option.value = cat.id;
                        option.textContent = cat.name;
                        selectCategory.appendChild(option);
                    });
                });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const uploadBtn = document.getElementById('uploadBtn');
            const fileInput = document.getElementById('files');
            const previewImg = document.getElementById('previewImg');

            uploadBtn.addEventListener('click', function() {
                fileInput.click(); // Mở cửa sổ chọn file
            });

            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    console.log('Tên ảnh đã tải lên: ' + file.name); // Log tên ảnh ra console

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.style.maxWidth = '100%';
                        previewImg.innerHTML = ''; // Xóa ảnh cũ
                        previewImg.appendChild(imgElement);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const uploadBtn = document.getElementById('uploadBtn');
            const fileInput = document.getElementById('files');
            const previewImg = document.getElementById('previewImg');
            const saveBtn = document.querySelector('.addnew_btn');
            const form = document.querySelector('.form_add');

            let productId = new URLSearchParams(window.location.search).get('id');

            // Chế độ sửa, lấy dữ liệu sản phẩm
            // Kiểm tra xem có productId không, nếu không có thì gọi generateNewId để lấy ID mới
            if (productId) {
                fetch(`../controllers/ProductController.php?action=getProductById&id=${productId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) {
                            alert("Lỗi khi tải dữ liệu sản phẩm: " + data.error);
                        } else {
                            document.getElementById('code').value = data.id;
                            document.getElementById('title').value = data.name;
                            document.getElementById('amount').value = data.stock;
                            document.getElementById('status').value = data.stock > 0 ? 'Còn hàng' : 'Hết hàng';
                            const categorySelect = document.getElementById('category');
                            const supplierSelect = document.getElementById('Suppliers');

                            // Tìm và chọn option có text trùng với data.category_name
                            Array.from(categorySelect.options).forEach(option => {
                                if (option.text === data.category_name) {
                                    option.selected = true; // Gán thuộc tính selected cho option tương ứng
                                }
                            });

                            // Tìm và chọn option có text trùng với data.brand_name
                            Array.from(supplierSelect.options).forEach(option => {
                                if (option.text === data.brand_name) {
                                    option.selected = true; // Gán thuộc tính selected cho option tương ứng
                                }
                            });

                            document.getElementById('price').value = data.price;
                            document.getElementById('editableDiv').innerHTML = data.description;


                            if (data.image) {
                                // Nếu có ảnh, hiển thị ảnh đã tải lên trước đó
                                const img = document.createElement('img');
                                img.src = "../uploads/products/" + data.image; // Giả sử đường dẫn ảnh đã có trong dữ liệu
                                img.style.maxWidth = '100%';
                                previewImg.innerHTML = ''; // Xóa ảnh cũ
                                previewImg.appendChild(img);
                            }
                        }
                    })
                    .catch(err => alert("Lỗi khi tải dữ liệu sản phẩm: " + err.message));
            } else {
                // Nếu không có productId, gọi hàm generateNewId để lấy ID mới
                fetch('../controllers/ProductController.php?action=generateNewId')
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) {
                            alert("Lỗi khi lấy mã sản phẩm mới: " + data.error);
                        } else {
                            // Gán giá trị ID mới cho mã sản phẩm
                            document.getElementById('code').value = data.code;
                        }
                    })
                    .catch(err => alert("Lỗi khi lấy mã sản phẩm mới: " + err.message));
            }


            // Chức năng tải ảnh
            uploadBtn.addEventListener('click', function() {
                fileInput.click(); // Mở cửa sổ chọn file
            });


            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    // Kiểm tra nếu là file hình ảnh
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imgElement = document.createElement('img');
                            imgElement.src = e.target.result; // Đọc dữ liệu ảnh và hiển thị ngay lập tức
                            imgElement.style.maxWidth = '100%';
                            previewImg.innerHTML = ''; // Xóa ảnh cũ
                            previewImg.appendChild(imgElement);
                        };
                        reader.readAsDataURL(file); // Đọc ảnh như một chuỗi base64
                    } else {
                        alert('Vui lòng chọn một tệp hình ảnh.');
                    }
                }
            });

            function checkValidate() {
                let isValid = true;

                const title = document.getElementById('title');
                const amount = document.getElementById('amount');
                const status = document.getElementById('status');
                const category = document.getElementById('category');
                const suppliers = document.getElementById('Suppliers');
                const price = document.getElementById('price');
                const file = document.getElementById('files');
                const description = document.getElementById('editableDiv');

                // Xóa lỗi cũ
                [
                    'error-title', 'error-amount', 'error-status', 'error-category',
                    'error-suppliers', 'error-price', 'error-image', 'error-description'
                ].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = '';
                });

                // Kiểm tra các trường
                if (!title.value.trim()) {
                    document.getElementById('error-title').innerText = 'Vui lòng nhập tên sản phẩm';
                    isValid = false;
                }

                if (!amount.value || parseInt(amount.value) < 0) {
                    document.getElementById('error-amount').innerText = 'Số lượng phải >= 0';
                    isValid = false;
                }

                if (!status.value || status.value === '--Tình trạng--') {
                    document.getElementById('error-status').innerText = 'Vui lòng chọn tình trạng';
                    isValid = false;
                }

                if (!category.value) {
                    document.getElementById('error-category').innerText = 'Vui lòng chọn danh mục';
                    isValid = false;
                }

                if (!suppliers.value || suppliers.value === '--Nhà cung cấp--') {
                    document.getElementById('error-suppliers').innerText = 'Vui lòng chọn nhà cung cấp';
                    isValid = false;
                }

                if (!price.value || parseInt(price.value) <= 0) {
                    document.getElementById('error-price').innerText = 'Giá bán phải > 0';
                    isValid = false;
                }

                // Kiểm tra nếu người dùng không chọn ảnh mới và có ảnh cũ, thì không cần yêu cầu chọn lại ảnh
                if (!file.files.length && !document.getElementById('previewImg').querySelector('img')) {
                    document.getElementById('error-image').innerText = 'Vui lòng chọn ảnh sản phẩm';
                    isValid = false;
                }


                if (!description.innerText.trim()) {
                    document.getElementById('error-description').innerText = 'Vui lòng nhập mô tả sản phẩm';
                    isValid = false;
                }

                return isValid;
            }



            saveBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Ghi nội dung vào input ẩn
                document.getElementById('hiddenDescription').value = document.getElementById('editableDiv').innerHTML;

                // ✅ Kiểm tra hợp lệ trước khi tiếp tục
                if (!checkValidate()) {
                    return;
                }

                const formData = new FormData(form);
                const file = fileInput.files[0];
                if (file) {
                    formData.append('image', file);
                }

                const action = productId ? 'updateProduct' : 'addProduct';
                formData.append('action', action);
                if (productId) formData.append('id', productId);

                fetch('../controllers/ProductController.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(async res => {
                        const text = await res.text();
                        let data;
                        try {
                            data = JSON.parse(text);
                        } catch (e) {
                            throw new Error("Phản hồi không hợp lệ từ server: " + text);
                        }
                        return data;
                    })
                    .then(data => {
                        if (data && data.success) {
                            // Hiển thị thông báo thành công trước khi tải lại trang
                            alert('Sản phẩm đã được lưu!');
                            // Tải lại trang sau khi thông báo
                            window.location.reload();
                        } else {
                            alert('Có lỗi xảy ra: ' + (data ? data.error : 'Không có thông tin phản hồi'));
                        }
                    })
                    .catch(err => {
                        console.error('Lỗi khi lưu sản phẩm:', err);
                        alert(err.message);
                    });
            });


        });
    </script>
</body>

</html>