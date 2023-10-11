<!DOCTYPE html>
<html>

<head>
    <title>Form Thêm Giáo Viên và Học Sinh</title>

        <link rel="stylesheet" href="./index.css">

</head>

<body>
    <div class="container">
        <h2>Thêm Giảng Viên và Học Sinh</h2>
        <form action="#" method="post">
            <label for="role">Chọn vai trò:</label>
            <input type="radio" id="teacher" name="role" value="teacher">
            <label for="teacher">Giảng Viên</label>
            <input type="radio" id="student" name="role" value="student">
            <label for="student">Học Sinh</label>

            <label for="name">Tên:</label>
            <input type="text" id="name" name="name" required>

            <input type="submit" value="Thêm">
        </form>
    </div>
</body>

</html>