<?php
include "../../config/connectSQL/index.php";
include "../../config/checkCookie/index.php";
$userId = checkActiveCookie($db);
$courses = [
    [
        'id' => '1',
        'name' => 'Tuần sinh hoạt Công dân-HSSV năm học 2021-2022 cho sinh viên K71',
        'semester' => 'Học kì I',
        'imgCover' => 'https://cst.hnue.edu.vn/theme/space/pix/default_course.jpg',
        'teacher' => [
            [
                'name' => 'Nguyen Quoc Chung',
                'avt' => 'https://zpsocial-f50-org.zadn.vn/17d9b070ef22017c5833.jpg',
            ]
        ],
    ],
    [
        'id' => '2',
        'name' => 'Tuần sinh hoạt Công dân-HSSV năm học 2021-2022 cho sinh viên K71',
        'semester' => 'Học kì I',
        'imgCover' => 'https://cst.hnue.edu.vn/theme/space/pix/default_course.jpg',
          
    ],
    [
        'id' => '3',
        'name' => 'Tuần sinh hoạt Công dân-HSSV năm học 2021-2022 cho sinh viên K71',
        'semester' => 'Học kì I',
        'imgCover' => 'https://cst.hnue.edu.vn/theme/space/pix/default_course.jpg',
        'teacher' => [
            [
                'name' => 'Nguyen Quoc Chung',
                'avt' => 'https://zpsocial-f50-org.zadn.vn/17d9b070ef22017c5833.jpg',
            ],
            [
                'name' => 'Nguyen Quoc Chung',
                'avt' => 'https://zpsocial-f50-org.zadn.vn/17d9b070ef22017c5833.jpg',
            ],
            [
                'name' => 'Nguyen Quoc Chung',
                'avt' => 'https://zpsocial-f50-org.zadn.vn/17d9b070ef22017c5833.jpg',
            ],
        ],
    ],
    [
        'id' => '4',
        'name' => 'Tuần sinh hoạt Công dân-HSSV năm học 2021-2022 cho sinh viên K71',
        'semester' => 'Học kì I',
        'imgCover' => 'https://cst.hnue.edu.vn/theme/space/pix/default_course.jpg',
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
    ],
    [
        'id' => '5',
        'name' => 'Tuần sinh hoạt Công dân-HSSV năm học 2021-2022 cho sinh viên K71',
        'semester' => 'Học kì I',
        'imgCover' => 'https://cst.hnue.edu.vn/theme/space/pix/default_course.jpg',
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
    ],
    [
        'id' => '6',
        'name' => 'Tuần sinh hoạt Công dân-HSSV năm học 2021-2022 cho sinh viên K71',
        'semester' => 'Học kì I',
        'imgCover' => 'https://cst.hnue.edu.vn/theme/space/pix/default_course.jpg',
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
    ],
    [
        'id' => '7',
        'name' => 'Tuần sinh hoạt Công dân-HSSV năm học 2021-2022 cho sinh viên K71',
        'semester' => 'Học kì I',
        'imgCover' => 'https://cst.hnue.edu.vn/theme/space/pix/default_course.jpg',
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
    ],
    [
        'id' => '8',
        'name' => 'Tuần sinh hoạt Công dân-HSSV năm học 2021-2022 cho sinh viên K71',
        'semester' => 'Học kì I',
        'imgCover' => 'https://cst.hnue.edu.vn/theme/space/pix/default_course.jpg',
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
    ],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="../../components/header/index.css">
    <link rel="stylesheet" href="../../components/footer/index.css">
    <link rel="stylesheet" href="../../extension/pagination/index.css">
    <link rel="stylesheet" href="../../style/index.css">
    <title>Online learning management system</title>
</head>

<body>
    <?php
    include "../../components/header/index.php";
    ?>

    <main class="d-flex">
        <div class="d-flex jc-spacebetween">
            <div class="courses-detail">
                <h3 class="title-main">My courses</h3>
                <ul class="list-courses-main d-flex gap-20">
                    <?php
                    foreach ($courses as $index => $course) {
                        if ($index > 10) {
                            echo '<buton class="btn btn-seemore">All Courses</buton>';
                            break;
                        } else {
                            echo '<li>
                            <div class="subtitle-course d-flex jc-spacebetween" style="background-image: url(' . $course['imgCover'] . ');">
                                <div class="d-flex">';
                            foreach ($course['teacher'] as $teacher) {
                                echo '<div>
                                                        <img class="pointer" src="' . $teacher["avt"] . '" alt="' . $teacher["name"] . '"/>
                                                        <p>' . $teacher["name"] . '</p>
                                                    </div>';
                            }
                            echo '</div>
                                <button class="pointer">' . $course['semester'] . '</button>
                            </div>
                            <div class="contact-course column gap-20">
                                <h3>' . $course['name'] . '</h3>
                                <form method="get" action="../course/index.php">
                                    <input type="hidden" name="id" value="'. $course["id"] .'">
                                    <button class="go-to-course d-flex gap-10 jc-center ai-center">
                                        <img src="https://cdn-icons-png.flaticon.com/512/2436/2436805.png" alt="Go to Course" />
                                        <p>Into Course</p>
                                    </button>
                                </form> 
                            </div>
                        </li>';
                        }
                    }
                    ?>
                </ul>
                <?php
                include "../../extension/pagination/index.php";
                ?>
            </div>

            <div class="courses-summed column gap-10">
                <h4 class="txt-center">My courses</h4>
                <ul class="column gap-10 list-courses">
                    <?php
                    foreach ($courses as $index => $course) {
                        if ($index > 10) {
                            echo '<buton class="btn btn-seemore">See More</buton>';
                            break;
                        } else {
                            echo '<li class="d-flex gap-10 ai-start pointer">
                            <img class="icon-class" src="https://cdn-icons-png.flaticon.com/512/9316/9316744.png" alt="class"/>
                            <p>' . $course['name'] . '</p>
                        </li>
                    ';
                            if ($index == count($courses) - 1) {
                                echo '<span>Your entire education</span>';
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </main>

    <?php
    include "../../components/footer/index.php";
    ?>
</body>

</html>