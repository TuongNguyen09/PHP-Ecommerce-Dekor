<?php
// function paginate($data, $perPage, $currentPage, $baseUrl, $extraParams = [], $renderFunc) {
//     $totalItems = count($data);
//     $totalPages = ceil($totalItems / $perPage);

//     $start = ($currentPage - 1) * $perPage;
//     $paginatedData = array_slice($data, $start, $perPage);

//     $renderFunc($paginatedData);

//     renderPagination($currentPage, $totalPages, $baseUrl, $extraParams);
// }

// function renderPagination($currentPage, $totalPages, $baseUrl, $extraParams) {
//     $maxVisiblePages = 5;

//     echo "<ul class='pagination'>";

//     // First + Prev
//     if ($currentPage > 1) {
//         echo "<li><a class='page-link' href='" . buildUrl($baseUrl, $extraParams, 1) . "'>First</a></li>";
//         echo "<li><a class='page-link' href='" . buildUrl($baseUrl, $extraParams, $currentPage - 1) . "'>Prev</a></li>";
//     }

//     // Tính startPage và endPage
//     $startPage = max(1, $currentPage - floor($maxVisiblePages / 2));
//     $endPage = $startPage + $maxVisiblePages - 1;

//     if ($endPage > $totalPages) {
//         $endPage = $totalPages;
//         $startPage = max(1, $endPage - $maxVisiblePages + 1);
//     }

//     // Dấu "..." đầu
//     if ($startPage > 1) {
//         echo "<li><a class='page-link' href='" . buildUrl($baseUrl, $extraParams, 1) . "'>1</a></li>";
//         if ($startPage > 2) {
//             echo "<li class='disabled'><a class='page-link'>...</a></li>";
//         }
//     }

//     // Các trang chính
//     for ($i = $startPage; $i <= $endPage; $i++) {
//         $activeClass = ($i === $currentPage) ? "active" : "";
//         echo "<li class='$activeClass'><a class='page-link' href='" . buildUrl($baseUrl, $extraParams, $i) . "'>$i</a></li>";
//     }

//     // Dấu "..." cuối
//     if ($endPage < $totalPages) {
//         if ($endPage < $totalPages - 1) {
//             echo "<li class='disabled'><a class='page-link'>...</a></li>";
//         }
//         echo "<li><a class='page-link' href='" . buildUrl($baseUrl, $extraParams, $totalPages) . "'>$totalPages</a></li>";
//     }

//     // Next + Last
//     if ($currentPage < $totalPages) {
//         echo "<li><a class='page-link' href='" . buildUrl($baseUrl, $extraParams, $currentPage + 1) . "'>Next</a></li>";
//         echo "<li><a class='page-link' href='" . buildUrl($baseUrl, $extraParams, $totalPages) . "'>Last</a></li>";
//     } else {
//         echo "<li class='disabled'><a class='page-link'>Next</a></li>";
//         echo "<li class='disabled'><a class='page-link'>Last</a></li>";
//     }

//     echo "</ul>";
// }


// function buildUrl($baseUrl, $extraParams, $page) {
//     $params = array_merge($extraParams, ['page' => $page]);
//     return $baseUrl . '?' . http_build_query($params);
// }
?>
