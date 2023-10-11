<?php
include "../../config/connectSQL/index.php";
include "../../config/checkCookie/index.php";
$course = [
    'nameCourse' => 'COMP 254 - Phân tích thiết kế thuật toán',
    'teacher' => [
        [
            'name' => 'Nguyen Quoc Chung',
            'avt' => 'https://zpsocial-f50-org.zadn.vn/17d9b070ef22017c5833.jpg',
        ],
        [
            'name' => 'Nguyen Quoc Chung',
            'avt' => 'https://zpsocial-f50-org.zadn.vn/17d9b070ef22017c5833.jpg',
        ],
    ],
    'introCourse' => [
        [
            'name' => 'Giới thiệu về môn học',
            'href' => '',
        ],
        [
            'name' => 'Quy tắc lớp học',
            'href' => '',
        ]
    ],
    'contents' => [
        [
            'nameLesson' => 'Tuần 1: Các khái niệm cơ bản',
            'detailContent' => [
                [
                    'titleLesson' => 'Silde tuần 1 - Các khái niệm cơ bản',

                    'status' => 'false',
                ],
                [
                    'titleLesson' => 'Bài giảng tuần 1 - Các khái niệm cơ bản',
                    'status' => 'false',
                ],
                [
                    'titleLesson' => 'Bài tập tuần 1',
                    'status' => 'false',
                ],
                [
                    'titleLesson' => 'Quiz tuần 1',
                    'status' => 'false',
                ],
            ]
        ],
        [
            'nameLesson' => 'Tuần 2: Các kĩ thuật phân tích thuật toán',
            'detailContent' => [
                [
                    'titleLesson' => 'Slide Tuần 2 - Các kỹ thuật phân tích thuật toán',
                    'status' => 'false',
                ],
                [
                    'titleLesson' => 'Bài giảng Tuần 2 - Các kỹ thuật phân tích thuật toán',
                    'status' => 'true',
                ],
                [
                    'titleLesson' => 'Bài tập tuần 2',
                    'status' => 'false',
                ],
                [
                    'titleLesson' => 'Quiz tuần 2',
                    'status' => 'false',
                ],
            ]
        ]
    ]
]
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../components/header/index.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="../../components/footer/index.css">
    <link rel="stylesheet" href="../../extension/pagination/index.css">
    <link rel="stylesheet" href="../../style/index.css">
    <title>
        <?php echo $course['nameCourse']; ?>
    </title>
</head>

<body>
    <?php
    include "../../components/header/index.php";
    ?>

    <main class="column gap-30 course">
        <div class="d-flex jc-spacebetween ai-center">
            <h1>
                <?php echo $course['nameCourse']; ?>
            </h1>
            <form method="get" action="../contribute/index.php">
                <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
                <button class="d-flex ai-center btn-tick pointer gap-10 btn-donation">
                    <img class="icon-donation" src="https://cdn-icons-png.flaticon.com/128/5432/5432915.png" />
                    Contribute questions
                </button>
            </form>
        </div>
        <?php
        foreach ($course['contents'] as $detailCourse) {
            echo '
                <div class="lesson pd-20 column gap-20">
                <h3>' . $detailCourse['nameLesson'] . '</h3>
            ';

            foreach ($detailCourse['detailContent'] as $article) {
                echo '
                    <div class="d-flex gap-10 jc-spacebetween ai-center">
                        <div class="d-flex gap-10 ai-center">
                            <img class="icon-of-lesson" src="https://cdn-icons-png.flaticon.com/512/9800/9800294.png" />
                            <a><p class="title-of-lesson pointer">' . $article['titleLesson'] . '</p></a>
                        </div>
                        <button class="btn-tick pointer ' . ($article["status"] == "true" ? "complete" : "") . '">' . ($article["status"] == "true" ? "Hoàn thành" : "Đánh dấu hoàn thành") . '</button>
                    </div>
                    <hr>
                ';
            }
            echo '  
                </div>
            ';
        }
        ?>

    </main>

    <?php
    include "../../components/footer/index.php";
    ?>
</body>

</html>