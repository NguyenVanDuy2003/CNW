<?php
include "../../config/connectSQL/index.php";
include "../../config/checkCookie/index.php";
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
    <link rel="stylesheet" href="../../extension/snack/index.css">
    <link rel="stylesheet" href="../../../style/index.css">
    <title>Assign</title>
</head>

<body>
    <?php
        include '../../components/header/index.php';
    ?>

    <main class="assign column gap-20">
        <h1>COMP 254 - Phân tích thiết kế thuật toán</h1>
        <div class="d-flex jc-spacebetween ai-center">
            <p class="f-sz-23 f-weight-500 mgUD-20">Bài tập tuần 3</p>
            <div class="time-homework d-flex gap-10">
                <p>Mở: Thứ năm, 21 Tháng 9 2023, 12:00 AM</p>
                <p>Đến hạn: Thứ tư, 4 Tháng 10 2023, 11:59 PM</p>
            </div>
        </div>

        <div class="request column gap-5 w-haft">
            <p class="pd-10">Instructor requirements</p>
            <p class="pd-10">
                - Bài tập soạn trên word hoặc chụp ảnh bài làm trên giấy có ghi tên sinh viên<br>
                - Hạn nộp: 24h00 ngày 26/09
            </p>
        </div>

        <div class="topic d-flex ai-center gap-10">
            <img class="w-icon-15 pd-10" src="https://cdn-icons-png.flaticon.com/128/11180/11180756.png" />
            <a class="f-sz-14 pd-10" href="#" target="_blank">Tuần 3 - Phiếu BTVN (Giải CT đệ quy - P1).pdf</a>
        </div>

        <hr class="hr mgUD-20">

        <div class="content-contact column gap-30">
            <p class="f-sz-20">Submission status</p>
            <div class="detail-contact">
                <div class='d-flex w-full'>
                    <p class='w-10'>Submission status</p>
                    <p class='flex-1 txt-warning'>Not approved</p>
                </div>
                <div class='d-flex w-full'>
                    <p class='w-10'>Grading assignments</p>
                    <p class='flex-1 txt-warning'>No points yet</p>
                </div>
                <div class='d-flex w-full'>
                    <p class='w-10'>Time remaining</p>
                    <p class='flex-1'>Deadline for submission is coming</p>
                </div>
                <div class='d-flex w-full'>
                    <p class='w-10'>Last edit</p>
                    <p class='flex-1'>Not history</p>
                </div>
                <div class='d-flex w-full'>
                    <p class='w-10'>Instructor's comments</p>
                    <p class='flex-1'>no comments</p>
                </div>
            </div>
            <div class="w-full d-flex jc-center mgUD-10">
                <button id="submit" class='btn btn-submit pd-15 pointer f-sz-16'>Submit</button>
            </div>
        </div>


    </main>

    <?php
    include "../../components/footer/index.php";
    ?>
</body>

</html>