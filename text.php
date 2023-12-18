
<?php
// $s = 'a:1:{s:1:"a";a:2:{i:0;a:3:{s:5:"title";s:30:"Các khái niệm cơ bản";s:12:"detailLesson";a:4:{i:0;a:3:{s:5:"title";s:48:"Silde tuần 1 - Các khái niệm cơ bản";s:4:"href";s:9:"../assign";s:6:"status";b:1;}i:1;a:3:{s:5:"title";s:51:"Bài giảng tuần 1 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:0;}i:2;a:3:{s:5:"title";s:48:"Silde tuần 1 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:1;}i:3;a:3:{s:5:"title";s:51:"Bài giảng tuần 1 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:0;}}s:6:"status";s:4:"show";}i:1;a:3:{s:5:"title";s:48:"Các kĩ thuật phân tích thuật toán";s:12:"detailLesson";a:4:{i:0;a:3:{s:5:"title";s:48:"Silde tuần 2 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:1;}i:1;a:3:{s:5:"title";s:51:"Bài giảng tuần 2 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:0;}i:2;a:3:{s:5:"title";s:48:"Silde tuần 2 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:1;}i:3;a:3:{s:5:"title";s:51:"Bài giảng tuần 2 - Các khái niệm cơ bản";s:4:"href";s:7:"../quiz";s:6:"status";b:0;}}s:6:"status";s:4:"show";}}}';
// print_r(unserialize($s));

$data = [
    'a' => [
        0 => [
            'title' => 'Các khái niệm cơ bản',
            'detailLesson' => [
                0 => ['title' => 'Silde tuần 1 - Các khái niệm cơ bản', 'href' => '../assign', 'status' => true],
                1 => ['title' => 'Bài giảng tuần 1 - Các khái niệm cơ bản', 'href' => '../quiz', 'status' => false],
                2 => ['title' => 'Silde tuần 1 - Các khái niệm cơ bản', 'href' => '../quiz', 'status' => true],
                3 => ['title' => 'Bài giảng tuần 1 - Các khái niệm cơ bản', 'href' => '../quiz', 'status' => false],
            ],
            'status' => 'show',
        ],
        1 => [
            'title' => 'Các kĩ thuật phân tích thuật toán',
            'detailLesson' => [
                0 => ['title' => 'Silde tuần 2 - Các khái niệm cơ bản', 'href' => '../quiz', 'status' => true],
                1 => ['title' => 'Bài giảng tuần 2 - Các khái niệm cơ bản', 'href' => '../quiz', 'status' => false],
                2 => ['title' => 'Silde tuần 2 - Các khái niệm cơ bản', 'href' => '../quiz', 'status' => true],
                3 => ['title' => 'Bài giảng tuần 2 - Các khái niệm cơ bản', 'href' => '../quiz', 'status' => false],
            ],
            'status' => 'show',
        ],
    ],
];

print_r(serialize($data));
?>