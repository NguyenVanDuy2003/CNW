<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển Thị Điểm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .score-container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        .score {
            font-size: 2em;
            color: #27ae60;
        }
    </style>
</head>
<body>
<div style="margin-top:10px">
            <a href='../../course/index.php?id=<?php echo $_GET['id'];?>' style="padding: 5px 10px;
    background: beige;
    border-radius: 5px;">
                Quay lại
            </a>
        </div>
    <div class="score-container">
        <h1>Điểm Của Bạn</h1>
        <div class="score"><?php echo $_GET['score']*10; ?></div>
        <!-- Thêm thông tin khác nếu cần -->
    </div>
</body>
</html>

