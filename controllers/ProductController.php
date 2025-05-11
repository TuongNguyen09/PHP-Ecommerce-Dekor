<?php
require_once '../models/ProductModel.php';
require_once '../models/CategoryModel.php';
require_once '../models/BrandModel.php';
require_once '../views/pagination.php';

class ProductController
{
    private $productModel;
    private $categoryModel;
    private $brandModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->brandModel = new BrandModel();
    }

    // public function listProducts()
    // {
    //     // Danh sách ánh xạ tên category => ID
    //     $categoryMap = [
    //         'Bàn gỗ' => 1,
    //         'Kệ sách' => 2,
    //         'Rèm cửa' => 3,
    //         'Ghế sofa' => 4,
    //         'Phòng tắm' => 5,
    //         'Tủ quần áo' => 6,
    //         'Giường ngủ' => 7,
    //         'Đèn trang trí' => 8
    //     ];

    //     // Danh sách ánh xạ tên brand => ID
    //     $brandMap = [
    //         'Kenny Furniture' => 1,
    //         'First Impression' => 2,
    //         'Big One' => 3,
    //         'Furniland' => 4,
    //         'My home' => 5
    //     ];

    //     // Lấy danh sách sản phẩm từ model
    //     $products = $this->productModel->getAllProducts();
    //     $perPage = 1;
    //     $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    //     // Lọc theo category (chuỗi ngăn bởi dấu phẩy)
    //     if (isset($_GET['category']) && $_GET['category'] !== '') {
    //         $categoryNames = explode(',', $_GET['category']);
    //         $categoryIds = [];
    //         foreach ($categoryNames as $name) {
    //             $name = urldecode(trim($name));
    //             if (isset($categoryMap[$name])) {
    //                 $categoryIds[] = $categoryMap[$name];
    //             }
    //         }
    //         $products = array_filter($products, function ($product) use ($categoryIds) {
    //             return in_array($product['category_id'], $categoryIds);
    //         });
    //     }

    //     // Lọc theo brand (chuỗi ngăn bởi dấu phẩy)
    //     if (isset($_GET['brand']) && $_GET['brand'] !== '') {
    //         $brandNames = explode(',', $_GET['brand']);
    //         $brandIds = [];
    //         foreach ($brandNames as $name) {
    //             $name = urldecode(trim($name));
    //             if (isset($brandMap[$name])) {
    //                 $brandIds[] = $brandMap[$name];
    //             }
    //         }
    //         $products = array_filter($products, function ($product) use ($brandIds) {
    //             return in_array($product['brand_id'], $brandIds);
    //         });
    //     }

    //     // Lọc theo price (chuỗi ngăn bởi dấu phẩy)
    //     if (isset($_GET['price']) && $_GET['price'] !== '') {
    //         $priceRanges = explode(',', $_GET['price']);
    //         $products = array_filter($products, function ($product) use ($priceRanges) {
    //             foreach ($priceRanges as $range) {
    //                 list($min, $max) = explode('-', $range);
    //                 if ($product['price'] >= (int)$min && $product['price'] <= (int)$max) {
    //                     return true;
    //                 }
    //             }
    //             return false;
    //         });
    //     }

    //     // Phân trang
    //     $totalItems = count($products);
    //     $totalPages = ceil($totalItems / $perPage);
    //     $offset = ($currentPage - 1) * $perPage;
    //     $paginatedData = array_slice($products, $offset, $perPage);

    //     // Trả về JSON
    //     header('Content-Type: application/json');
    //     echo json_encode([
    //         'products' => array_values($paginatedData),
    //         'totalPages' => $totalPages,
    //         'currentPage' => $currentPage
    //     ]);
    // }

    public function listProducts()
    {
        // Lấy danh sách sản phẩm từ model
        $products = $this->productModel->getAllProducts();
        $perPage = 9;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Lọc theo key (từ khóa tìm kiếm)
        if (isset($_GET['key']) && $_GET['key'] !== '') {
            $keyword = strtolower(trim($_GET['key']));
            $products = array_filter($products, function ($product) use ($keyword) {
                return stripos($product['name'], $keyword) !== false;
            });
        }

        // Lọc theo category
        if (isset($_GET['category']) && $_GET['category'] !== 'all') {
            $categoryNames = explode(',', $_GET['category']);
            $categoryIds = [];
            foreach ($categoryNames as $name) {
                $name = urldecode(trim($name));
                $categoryId = $this->categoryModel->getCategoryIdByName($name);
                if ($categoryId) {
                    $categoryIds[] = $categoryId;
                }
            }
            $products = array_filter($products, function ($product) use ($categoryIds) {
                return in_array($product['category_id'], $categoryIds);
            });
        }

        // Lọc theo brand
        if (isset($_GET['brand']) && $_GET['brand'] !== '') {
            $brandNames = explode(',', $_GET['brand']);
            $brandIds = [];
            foreach ($brandNames as $name) {
                $name = urldecode(trim($name));
                $brandId = $this->brandModel->getBrandIdByName($name);
                if ($brandId) {
                    $brandIds[] = $brandId;
                }
            }
            $products = array_filter($products, function ($product) use ($brandIds) {
                return in_array($product['brand_id'], $brandIds);
            });
        }

        // Lọc theo price
        if (isset($_GET['price']) && $_GET['price'] !== '') {
            $priceRanges = explode(',', $_GET['price']);
            $products = array_filter($products, function ($product) use ($priceRanges) {
                foreach ($priceRanges as $range) {
                    list($min, $max) = explode('-', $range);
                    if ($product['price'] >= (int)$min && $product['price'] <= (int)$max) {
                        return true;
                    }
                }
                return false;
            });
        }

        // Phân trang
        $totalItems = count($products);
        $totalPages = ceil($totalItems / $perPage);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedData = array_slice($products, $offset, $perPage);

        // Thêm tên category và brand vào mỗi sản phẩm
        foreach ($paginatedData as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
            $product['brand_name'] = $this->brandModel->getBrandNameById($product['brand_id']);
        }

        // Trả về JSON
        header('Content-Type: application/json');
        echo json_encode([
            'products' => array_values($paginatedData),
            'totalPages' => $totalPages,
            'currentPage' => $currentPage
        ]);
    }

    public function showTopSellingProducts()
    {
        try {
            // Lấy dữ liệu từ form lọc ngày (nếu có)
            $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : null;
            $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : null;
            $limit = isset($_POST['limit']) ? $_POST['limit'] : 5;  // Mặc định là 10 sản phẩm top selling

            // Kiểm tra và validate dữ liệu nhập
            if (!is_numeric($limit) || $limit <= 0) {
                throw new Exception("Limit phải là một số dương");
            }

            // Tạo đối tượng model (giả sử bạn đã có mô hình Product)
            $productModel = new ProductModel();

            // Lấy danh sách sản phẩm top selling
            $topSellingProducts = $productModel->getTopSellingProducts($limit, $fromDate, $toDate);

            // Kiểm tra nếu không có sản phẩm nào
            if (empty($topSellingProducts)) {
                throw new Exception("Không có sản phẩm nào được bán");
            }

            // Trả về dữ liệu dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'data' => $topSellingProducts
            ]);
        } catch (Exception $e) {
            // Xử lý lỗi, trả về thông báo lỗi dưới dạng JSON
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getProductById($id)
    {
        // Lấy thông tin sản phẩm từ model theo ID
        try {
            $product = $this->productModel->getProductById($id);

            if ($product) {
                // Thêm tên category và brand vào sản phẩm
                $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
                $product['brand_name'] = $this->brandModel->getBrandNameById($product['brand_id']);

                // Lọc HTML trong description để đảm bảo an toàn
                $product['description'] = $this->sanitizeHTML($product['description']);

                header('Content-Type: application/json');
                echo json_encode($product);
            } else {
                // Nếu sản phẩm không tồn tại, trả về lỗi
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Product not found']);
            }
        } catch (Exception $e) {
            // Nếu có lỗi trong quá trình xử lý, echo ra lỗi chi tiết từ exception
            echo "Exception: " . $e->getMessage();  // Echo thông báo lỗi của exception
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Lỗi hệ thống: ' . $e->getMessage()]);
        }
    }

    // Hàm lọc HTML an toàn, chỉ cho phép các thẻ HTML an toàn
    private function sanitizeHTML($html)
    {
        // Lọc HTML để chỉ cho phép các thẻ an toàn
        $allowedTags = '<div><p><b><i><u><a><img><ul><ol><li><br><strong>'; // Các thẻ được phép
        return strip_tags($html, $allowedTags);
    }


    public function getProductById1($id)
    {
        // Lấy thông tin sản phẩm từ model theo ID
        try {
            $product = $this->productModel->getProductById($id);

            if ($product) {
                // Thêm tên category và brand vào sản phẩm
                $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
                $product['brand_name'] = $this->brandModel->getBrandNameById($product['brand_id']);

                // Trả về sản phẩm thay vì echo trực tiếp
                return $product;
            } else {
                // Nếu sản phẩm không tồn tại, trả về lỗi
                return null;  // Trả về null nếu không tìm thấy sản phẩm
            }
        } catch (Exception $e) {
            // Nếu có lỗi trong quá trình xử lý, trả về lỗi chi tiết
            return ['error' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }



    public function addProduct()
    {
        try {
            if (!isset($_POST['title'], $_POST['price'], $_POST['amount'], $_POST['category'], $_POST['Suppliers'])) {
                throw new Exception("Thiếu thông tin sản phẩm.");
            }

            $name = $_POST['title'];
            $price = $_POST['price'];
            $stock = $_POST['amount'];
            $categoryId = $_POST['category'];
            $brandId = $_POST['Suppliers'];
            $description = $_POST['description'] ?? ''; // Nếu không có mô tả thì để trống

            // Kiểm tra xem category_id và brand_id có hợp lệ không
            if (!is_numeric($categoryId) || !is_numeric($brandId)) {
                throw new Exception('Danh mục hoặc nhà cung cấp không hợp lệ.');
            }

            // Xử lý ảnh
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                // Xử lý việc tải ảnh lên máy chủ
                $image = $this->uploadImage($_FILES['image']);
                if (!$image) {
                    throw new Exception('Không thể tải ảnh lên máy chủ');
                }
            }

            // Chuẩn bị dữ liệu
            $data = [
                'name' => $name,
                'price' => $price,
                'stock' => $stock,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'description' => $description,
                'image' => $image // Thêm ảnh vào dữ liệu
            ];

            // Thêm sản phẩm vào cơ sở dữ liệu
            $result = $this->productModel->createProduct($data);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception('Không thể thêm sản phẩm vào cơ sở dữ liệu');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function updateProduct()
    {
        try {
            if (!isset($_POST['id'], $_POST['title'], $_POST['price'], $_POST['amount'], $_POST['category'], $_POST['Suppliers'])) {
                throw new Exception("Thiếu thông tin sản phẩm.");
            }

            $id = $_POST['id'];
            $name = $_POST['title'];
            $price = $_POST['price'];
            $stock = $_POST['amount'];
            $categoryId = $_POST['category'];
            $brandId = $_POST['Suppliers'];
            $description = $_POST['description'] ?? '';
            $image = null;

            // Kiểm tra xem category_id và brand_id có hợp lệ không
            if (!is_numeric($categoryId) || !is_numeric($brandId)) {
                throw new Exception('Danh mục hoặc nhà cung cấp không hợp lệ.');
            }

            // Xử lý ảnh nếu có file ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
                if (!$image) {
                    throw new Exception('Không thể tải ảnh lên máy chủ');
                }
            }

            // Chuẩn bị dữ liệu cập nhật
            $data = [
                'name' => $name,
                'price' => $price,
                'stock' => $stock,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'description' => $description
            ];

            // Nếu có ảnh mới thì thêm vào mảng dữ liệu
            if ($image) {
                $data['image'] = $image;
            }

            // Gọi model để cập nhật sản phẩm
            $result = $this->productModel->updateProduct($id, $data);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception('Không thể cập nhật sản phẩm trong cơ sở dữ liệu');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }



    private function uploadImage($file)
    {
        // Kiểm tra các lỗi của file (như kích thước, định dạng...)
        $targetDir = "../uploads/products/";
        $targetFile = $targetDir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Kiểm tra xem file có phải là ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return false;
        }

        // Kiểm tra kích thước ảnh (tối đa 5MB)
        if ($file["size"] > 5000000) {
            return false;
        }

        // Chỉ cho phép định dạng ảnh: JPG, JPEG, PNG, GIF
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            return false;
        }

        // Di chuyển ảnh vào thư mục upload
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return basename($file["name"]);
        } else {
            return false;
        }
    }

    public function deleteProduct()
    {
        try {
            if (!isset($_POST['id'])) {
                throw new Exception("Thiếu ID sản phẩm để xóa.");
            }

            $id = $_POST['id'];

            // Nếu sản phẩm nằm trong đơn hàng → chỉ ẩn
            if ($this->productModel->isProductInOrderItem($id)) {
                $this->productModel->hideProduct($id);
                echo json_encode([
                    'success' => false,
                    'error' => 'Sản phẩm đã được bán. Đã chuyển sang trạng thái ẩn.'
                ]);
                return;
            }

            // Nếu không, xóa luôn
            if ($this->productModel->deleteProduct($id)) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("Không thể xóa sản phẩm.");
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function unhideProduct()
    {
        try {
            if (!isset($_POST['id'])) {
                throw new Exception("Thiếu ID sản phẩm.");
            }

            $id = $_POST['id'];
            $result = $this->productModel->setProductHide($id, 0); // đặt is_hide = 0

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("Không thể mở bán sản phẩm.");
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function checkProductSold($productId)
    {
        // Kiểm tra sản phẩm đã được bán chưa (có nằm trong đơn hàng nào chưa)
        $isSold = $this->productModel->isProductSold($productId);

        header('Content-Type: application/json');
        echo json_encode(['sold' => $isSold]);  // Sửa từ 'isSold' thành 'sold'
    }


    public function generateNewId()
    {
        $code = $this->productModel->generateNewId();
        echo json_encode(['code' => $code]);
    }

    public function hideProduct($productId)
    {
        if ($this->productModel->hideProduct($productId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Không thể ẩn sản phẩm']);
        }
    }

    public function getLowStockProducts()
    {
        header('Content-Type: application/json');
        $lowStockProducts = $this->productModel->getLowStockProducts();
        echo json_encode($lowStockProducts);
    }
}

if (isset($_GET['action'])) {
    $controller = new ProductController();

    switch ($_GET['action']) {
        case 'listProducts':
            $controller->listProducts();
            break;
        case 'getProductById':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $controller->getProductById($id);
            break;
        case 'checkProductSold':
            if (isset($_GET['id'])) {
                $controller->checkProductSold((int)$_GET['id']);
            } else {
                echo json_encode(['error' => 'Missing product ID']);
            }
            break;
        case 'generateNewId':
            $controller->generateNewId();
            break;
        case 'getLowStockProducts': // ✅ Thêm mới
            $controller->getLowStockProducts();
            break;
        default:
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
    $controller = new ProductController();

    switch ($action) {
        case 'addProduct':
            $controller->addProduct();
            break;
        case 'updateProduct':
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                $controller->updateProduct($id);
            } else {
                echo json_encode(['error' => 'Missing product ID for update']);
            }
            break;
        case 'deleteProduct':
            if (isset($_POST['id'])) {
                $controller->deleteProduct();
            } else {
                echo json_encode(['error' => 'Missing product ID for delete']);
            }
            break;
        case 'unhideProduct':
            if (isset($_POST['id'])) {
                $controller->unhideProduct();
            } else {
                echo json_encode(['error' => 'Missing product ID for unhide']);
            }
            break;
        case 'hideProduct':
            if (isset($_POST['id'])) {
                $controller->hideProduct($_POST['id']);
            } else {
                echo json_encode(['error' => 'Missing product ID for hide']);
            }
            break;
        case 'topProducts': // Thêm case xử lý top selling cho POST nếu cần
            $controller->showTopSellingProducts();
            break;
        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
}
