<?php
function path()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];

    $url = $protocol . $host . $uri;

    $urlParts = explode('/', $url);

    $pageIndex = array_search('page', $urlParts);

    if ($pageIndex !== false) {
        // Tạo URL mới bằng cách nối các phần từ đầu đến "page"
        $newUrl = implode('/', array_slice($urlParts, 0, $pageIndex));
        return $newUrl;
    } else {
        // Không tìm thấy "page" trong URL
        echo "Không tìm thấy 'page' trong URL.";
        return ;
    }
}
?>