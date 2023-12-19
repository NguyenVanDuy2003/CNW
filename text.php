
<?php
// $s = 'a:2:{i:0;a:3:{s:5:"title";s:30:"Các khái niệm cơ bản";s:12:"detailLesson";a:4:{i:0;a:3:{s:5:"title";s:48:"Silde tuần 1 - Các khái niệm cơ bản";s:4:"href";s:9:"../assign";s:6:"status";b:1;}i:1;a:3:{s:5:"title";s:51:"Bài giảng tuần 1 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:0;}i:2;a:3:{s:5:"title";s:48:"Silde tuần 1 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:1;}i:3;a:3:{s:5:"title";s:51:"Bài giảng tuần 1 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:0;}}s:6:"status";s:4:"show";}i:1;a:3:{s:5:"title";s:48:"Các kĩ thuật phân tích thuật toán";s:12:"detailLesson";a:4:{i:0;a:3:{s:5:"title";s:48:"Silde tuần 2 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:1;}i:1;a:3:{s:5:"title";s:51:"Bài giảng tuần 2 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:0;}i:2;a:3:{s:5:"title";s:48:"Silde tuần 2 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:1;}i:3;a:3:{s:5:"title";s:51:"Bài giảng tuần 2 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:0;}}s:6:"status";s:4:"show";}}';
// print_r(unserialize($s));

$data = [
    [
        'title' => 'Giới thiệu về môn học',
        'detailLesson' => [
            0 => ['title' => 'Silde tuần 1 - Giới thiệu về môn học', 'href' => '../assign', 'status' => true],
            1 => ['title' => 'Bài kiểm tra quiz - Về môn học', 'href' => '../quiz', 'status' => false],
        ],
        'status' => 'show',
    ],
    [
        'title' => 'Kiến thức cơ bản PHP',
        'detailLesson' => [
            0 => ['title' => 'Silde tuần 2', 'href' => '../assign', 'status' => true],
            1 => ['title' => 'Bài kiểm tra quiz tuần 1 - Về môn học', 'href' => '../quiz', 'status' => false],
        ],
        'status' => 'show',
    ],
];

print_r(serialize($data));
?>