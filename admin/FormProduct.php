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
    <header>
        <div class="top">
            <div class="tab_menu">
                <i class="fas fa-bars" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                    aria-controls="offcanvasExample"></i>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                    aria-labelledby="offcanvasExampleLabel" style="width: 250px">
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
                            <hr />
                        </div>
                        <div class="menu">
                            <a href="../../html/admin/admin.html">
                                <li class="menu_item">
                                    <i class="fas fa-house"></i>Trang chủ
                                </li>
                            </a>
                            <a href="../../html/admin/data_product.html">
                                <li class="menu_item active">
                                    <i class="fas fa-tag"></i>Quản lý sản phẩm
                                </li>
                            </a>
                            <a href="../../html/admin/data_oder.html">
                                <li class="menu_item">
                                    <i class="fas fa-bag-shopping"></i>Quản lý đơn hàng
                                </li>
                            </a>
                            <a href="../../html/admin/data_user.html">
                                <li class="menu_item">
                                    <i class="fas fa-address-card"></i>Quản lý người dùng
                                </li>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sign_out">
                <a href="../../html/Dangnhap.html" onclick="logoutAdmin()"><i class="fas fa-right-from-bracket"></i></a>
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
                <hr />
            </div>
            <div class="menu">
                <a href="../../html/admin/admin.html">
                    <li class="menu_item"><i class="fas fa-house"></i>Trang chủ</li>
                </a>
                <a href="../../html/admin/data_product.html">
                    <li class="menu_item active">
                        <i class="fas fa-tag"></i>Quản lý sản phẩm
                    </li>
                </a>
                <a href="../../html/admin/data_oder.html">
                    <li class="menu_item">
                        <i class="fas fa-bag-shopping"></i>Quản lý đơn hàng
                    </li>
                </a>
                <a href="../../html/admin/data_user.html">
                    <li class="menu_item">
                        <i class="fas fa-address-card"></i>Quản lý người dùng
                    </li>
                </a>
            </div>
        </div>
    </header>

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
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Số lượng</label>
                        <input type="number" class="form-control" id="amount" name="amount" />
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Tình trạng</label>
                        <select class="form-select" id="status" name="status">
                            <option selected>--Tình trạng--</option>
                            <option value="Còn hàng">Còn hàng</option>
                            <option value="Hết hàng">Hết hàng</option>
                        </select>
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Danh mục</label>
                        <select class="form-select" id="category" name="category">
                            <!-- Các options được điền thông qua JavaScript hoặc từ server -->
                        </select>
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Nhà cung cấp</label>
                        <select class="form-select" id="Suppliers" name="Suppliers">
                            <option selected>--Nhà cung cấp--</option>
                            <!-- Các options được điền thông qua JavaScript hoặc từ server -->
                        </select>
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Giá bán</label>
                        <input type="number" class="form-control" id="price" name="price" />
                    </div>
                    <div class="form_group col-12 col-sm-6 col-lg-3">
                        <label>Ảnh sản phẩm</label>
                        <button class="hinh form-control" type="button" id="uploadBtn">Tải ảnh</button>
                        <input style="display: none" type="file" id="files" name="image" />
                        <span id="previewImg"></span>
                    </div>
                    <div class="form_group col-12">
                        <label>Mô tả sản phẩm</label>
                        <div contenteditable="true" id="editableDiv">
                            Bạn có thể nhập văn bản và chèn hình ảnh vào đây.
                        </div>
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
    <script src="../../js/data.js"></script>
    <script src="../../js/editProduct.js"></script>
    <script src="../../js/admin.js"></script>
    <script src="../../js/account.js"></script>
    <script src="../../js/accountAdmin.js"></script>
    <script src="../../js/checkSignInAdmin.js"></script>
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

                const br = document.createElement("br");
                range.insertNode(br);

                range.setStartAfter(br);
                range.setEndAfter(br);
                selection.removeAllRanges();
                selection.addRange(range);

                // Cập nhật vị trí con trỏ mới
                savedRange = selection.getRangeAt(0).cloneRange();
            } else {
                // Nếu không có range hợp lệ, thêm vào cuối editableDiv
                editableDiv.appendChild(imgElement);
                editableDiv.appendChild(document.createElement("br"));
            }
        }

        // Trước khi submit, đưa nội dung vào input ẩn
        form.addEventListener('submit', function() {
            hiddenDescription.value = editableDiv.innerHTML;
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
                            document.getElementById('category').value = data.category_id;
                            document.getElementById('Suppliers').value = data.brand_id;
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

            // Khi nhấn "Lưu", gửi tệp ảnh và dữ liệu form lên server
            saveBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // ✅ Ghi nội dung vào input ẩn trước khi tạo FormData
                document.getElementById('hiddenDescription').value = document.getElementById('editableDiv').innerHTML;
                console.log(document.getElementById('hiddenDescription').value);
                const formData = new FormData(form);

                const file = fileInput.files[0];
                if (file) {
                    formData.append('image', file);
                }

                // (Phần còn lại giữ nguyên)
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
                            alert('Sản phẩm đã được lưu!');
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