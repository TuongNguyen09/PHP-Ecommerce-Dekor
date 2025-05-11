<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$userId = $_SESSION['userId'] ?? null;
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lịch Sử Đơn Hàng</title>
  <link rel="stylesheet" href="../assets/fontawesome-free-6.2.0-web/css/all.css">
  <link rel="stylesheet" href="../assets/bootstrap-5.2.2-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/font_Roboto/Roboto-Bold.ttf">
  <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/product.css">
  <script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/jquery.min.js"></script>
  <link rel="stylesheet" href="../assets/css/cart.css">
</head>
<style>
  .container-order {
    display: flex;
    width: 100%;
    margin-top: 60px;
  }

  .sidebar {
    width: 250px;
    /* background-color: #fff; */
    padding: 20px;
    height: 100vh;
  }

  .profile {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;
  }

  .avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-bottom: 10px;
  }

  .user-name p {
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
  }

  .user-name a {
    font-size: 14px;
    color: #007bff;
    text-decoration: none;
  }

  .menu-item .icon {
    font-size: 20px;
  }

  .order-history-container {
    flex: 1;
    padding: 20px;
    margin-left: 20px;
  }

  .order-card {
    background-color: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
  }

  .order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .order-dates {
    display: flex;
    gap: 20px;
  }

  .order-status {
    font-size: 16px;
    font-weight: bold;
    display: flex;
    align-items: center;
  }

  .status-icon {
    margin-right: 10px;
  }


  .order-id {
    font-size: 16px;
    margin-bottom: 10px;
    color: #333;
  }

  .order-details {
    margin-bottom: 20px;
  }

  .order-dates-and-address {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
  }

  .order-dates-and-address p {
    margin: 0;
    font-size: 14px;
    color: #555;
  }

  .order-actions {
    text-align: right;
    margin-top: 20px;
  }

  .cancel-button {
    background-color: #ff4d4f;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .cancel-button:hover {
    background-color: #d9363e;
  }

  .order-items {
    margin-top: 20px;
  }

  .product-item {
    display: flex;
    align-items: center;
    padding: 10px;
    background-color: #fafafa;
    border-radius: 8px;
    margin-bottom: 15px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  }

  .product-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    margin-right: 20px;
    border-radius: 8px;
  }

  .product-name {
    font-size: 16px;
    font-weight: bold;
    color: #333;
    flex: 1;
  }

  .product-price {
    font-size: 14px;
    color: #27ae60;
    font-weight: bold;
  }

  .order-total {
    margin-top: 20px;
    text-align: right;
  }

  .order-total p {
    font-size: 18px;
    font-weight: bold;
    color: #333;
  }

  .order-address {
    margin-top: 15px;
    font-size: 14px;
    color: #555;
  }

  button.cancel-button:disabled {
    background-color: #ccc;
    color: #666;
    cursor: not-allowed;
    border: 1px solid #aaa;
  }

  button.cancel-button:disabled:hover {
    background-color: #ccc;
    color: #666;
  }

  .menu-item {
    text-decoration: none;
    color: #333;
    padding: 10px;
    border-radius: 5px;
    display: inline-block;
    margin-bottom: 10px;
    transition: background-color 0.3s, color 0.3s;
  }

  .menu-item:hover {
    background-color: #f0f0f0;
  }

  .menu-item.active {
    color: blue;
  }

  .status-pending {
    color: orange;
  }

  .status-confirmed {
    color: green;
  }

  .status-delivered {
    color: blue;
  }

  .status-canceled {
    color: red;
  }

  .status-icon {
    margin-right: 8px;
  }
</style>

<body>
  <?php
  include './templates/Header.php';
  ?>
  <div class="container-order">
    <!-- Thanh menu bên trái -->
    <div class="sidebar">
      <div class="profile">
        <img src="../../img/avatar-mac-dinh-nam.jpg" alt="Avatar" class="avatar">
        <div class="user-name">
          <p></p>
        </div>
      </div>
      <div class="menu-items">
        <a href="./MyInfoPage.php" class="menu-item"><span class="icon">👤</span> Tài Khoản Của Tôi</a>
        <a href="#" class="menu-item active"><span class="icon">📋</span> Đơn Mua</a>
      </div>
    </div>
    <!-- Phần lịch sử đơn hàng -->
    <div class="order-history-container">

    </div>
  </div>
  <?php
  include './templates/Footer.php';
  ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      fetchOrderHistoryFromServer();
    });
    const userId = <?= json_encode($userId) ?>;
    console.log(userId);

    function fetchOrderHistoryFromServer() {
      fetch(`../controllers/OrderController.php?action=listOrders&user_id=${userId}`)
        .then(response => {
          if (!response.ok) {
            return response.text(); // Trả về văn bản nếu không phải JSON
          }
          return response.json(); // Nếu là JSON thì xử lý bình thường
        })
        .then(data => {
          // Nếu dữ liệu là văn bản lỗi
          if (typeof data === 'string') {
            throw new Error(data); // Ném lỗi nếu là văn bản
          }

          renderOrderHistory(data.orders); // Nếu là JSON, tiếp tục xử lý
        })
        .catch(error => {
          console.error('Fetch order history error:', error);
          alert('Lỗi: ' + error.message); // Hiển thị thông báo lỗi cho người dùng
        });
    }


    function renderOrderHistory(orders) {
      const container = document.querySelector('.order-history-container');
      console.log(container);
      container.innerHTML = ''; // Xóa cũ trước

      if (!orders || orders.length === 0) {
        container.innerHTML = '<p>Không có đơn hàng nào.</p>';
        return;
      }

      orders.forEach(order => {
        let statusClass = '';
        let statusText = '';
        let statusIcon = '';

        if (order.status === 'Đã giao thành công') {
          statusClass = 'status-delivered';
          statusText = 'Đã giao thành công';
          statusIcon = '&#x2705;';
        } else if (order.status === 'Chưa xử lý') {
          statusClass = 'status-pending';
          statusText = 'Chưa xử lý';
          statusIcon = '&#x1F6A8;';
        } else if (order.status === 'Đã hủy') {
          statusClass = 'status-cancelled';
          statusText = 'Đã hủy';
          statusIcon = '&#x274C;';
        }

        // Tính tổng đơn hàng từ các sản phẩm
        let total = order.items.reduce((sum, item) => sum + item.price * item.quantity, 0);

        // Kiểm tra nếu order.items tồn tại và là một mảng
        const orderItemsHTML = (order.items && Array.isArray(order.items)) ?
          order.items.map(item => `
        <li>
            <div class="product-item">
                <img src="../uploads/products/${item.image}" alt="${item.product_name}" class="product-img">
                <p class="product-name">${item.product_name} <span style="font-weight: lighter;" class="product-quantity">x${item.quantity}</span></p>
                <p class="product-price">${Number(item.price).toLocaleString()} VNĐ</p>
            </div>
        </li>`).join('') :
          '<li>Không có sản phẩm trong đơn hàng.</li>'; // Nếu không có sản phẩm

        const orderHTML = `
    <div class="order-card ${statusClass}">
        <div class="order-header">
            <div class="order-id">
                <p><strong>Mã đơn:</strong> #${order.id}</p>
            </div>
            <p class="order-status ${statusClass}"><span class="status-icon">${statusIcon}</span> ${statusText}</p>
        </div>
        <div class="order-details">
            <div class="order-dates-and-address">
                <div>
                    <p><span style="display:inline-block;width:80px;font-weight:600">Ngày đặt: </span>${order.order_date}</p>
                    <p><span style="display:inline-block;width:80px;font-weight:600">Ngày giao: </span>${order.delivery_date ? order.delivery_date : 'Chưa giao'}</p>
                </div>
                <div>
                    <p><strong>Địa chỉ giao hàng:</strong> ${order.address_detail}</p>
                </div>
            </div>
        </div>
        <div class="order-items" style="max-height: 300px; overflow-y: auto;">
            <ul>${orderItemsHTML}</ul>
        </div>
        <div class="order-total">
            <p><strong>Thành tiền:</strong> ${Number(total+30000).toLocaleString()} VNĐ</p>
        </div>
        <div class="order-actions">
            <button class="cancel-button" ${order.status !== 'Chưa xử lý' ? 'disabled' : `onclick="cancelOrder(${order.id})"`}>Hủy đơn</button>
        </div>
    </div>`;

        container.innerHTML += orderHTML;
      });
    }

    function cancelOrder(orderId) {
      if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) return;

      fetch(`../controllers/OrderController.php`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            action: 'cancelOrder',
            orderId: orderId
          })
        })
        .then(response => response.json())
        .then(result => {
          if (result.success) {
            alert('Đơn hàng đã được hủy thành công.');
            fetchOrderHistoryFromServer(); // Cập nhật lại danh sách đơn
          } else {
            alert('Không thể hủy đơn hàng: ' + result.message);
          }
        })
        .catch(error => {
          console.error('Lỗi khi hủy đơn:', error);
          alert('Có lỗi xảy ra khi hủy đơn hàng.');
        });
    }
  </script>

</body>

</html>