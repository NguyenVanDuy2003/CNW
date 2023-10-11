<!DOCTYPE html>
<html>

<head>
    <title>Form Thêm Giảng Viên và Học Sinh</title>
    <link rel="stylesheet" href="./index.css">
</head>

<body>
    <div class="container">
        <?php
        include "../../../config/connectSQL/index.php";
        $sql = "SELECT * FROM users WHERE role = 'teacher'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $dataTeacher = [];
        while ($item = $result->fetch_assoc()) {
            $dataTeacher[] = $item;
        }
        ?>

        <?php
        // Khởi tạo mảng danh sách người dùng đã chọn (ban đầu rỗng)
        $selectedUsers = [];

        // Kiểm tra nếu đã nhấn nút "Thêm" và có người dùng được chọn
        if (isset($_POST['add']) && isset($_POST['maGV'])) {
            // Lấy danh sách người dùng đã chọn từ form
            $selectedUserIds = $_POST['maGV'];

            // Lấy thông tin người dùng từ danh sách gốc (dựa vào $dataTeacher)
            foreach ($selectedUserIds as $selectedUserId) {
                $selectedUser = null;
                foreach ($dataTeacher as $key => $item) {
                    if ($item['id'] == $selectedUserId) {
                        $selectedUser = $item;
                        break;
                    }
                }

                // Kiểm tra xem người dùng đã được chọn trước đó hay chưa
                if ($selectedUser && !in_array($selectedUserId, $selectedUsers)) {
                    // Thêm người dùng vào danh sách đã chọn
                    $selectedUsers[] = $selectedUserId;

                    // Loại bỏ người dùng đã chọn khỏi danh sách gốc (nếu có)
                    unset($dataTeacher[$key]);
                }
            }
        }
        ?>

        <h2>Thêm Giảng Viên và Học Sinh</h2>
        <form action="#" method="post">
            <label for="name">Title:</label>
            <input type="text" id="name" name="name" required>

            <label for="optionsDropdown">Giảng Viên:</label>
            <select id="optionsDropdown" name="maGV">
                <?php
                foreach ($dataTeacher as $item) {
                    $name = $item['name'];
                    $id = $item['id'];
                ?>
                    <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                <?php }
                ?>
            </select>

            <input type="button" name="add" value="Add" onclick="addSelectedUsers()">
            <input type="button" name="remove" value="Remove" onclick="removeSelectedUsers()">

            <select id="selectedUsers" name="selectedUsers[]" multiple>
                <?php
                foreach ($selectedUsers as $userId) {
                    foreach ($dataTeacher as $item) {
                        if ($item['id'] == $userId) {
                            echo '<option value="' . $userId . '" selected>' . $item['name'] . '</option>';
                            break;
                        }
                    }
                }
                ?>
            </select>

            <input type="submit" name="submit" value="Thêm">
        </form>
        <?php
        if (isset($_POST['submit'])) {
            // Lấy giá trị từ phần tử select có tên "selectedUsers"
            // $selectedUserIds = $_POST["selectedUsers"];

            // Hiển thị tất cả giá trị đã chọn
            // foreach ($selectedUserIds as $userId) {
            //     echo "Giá trị đã chọn: " . $userId . "<br>";
            // }

            // header("Location: success.php");
            // exit;
        }
        ?>

        <script>
            function addSelectedUsers() {
                let optionsDropdown = document.getElementById("optionsDropdown");
                let selectedUsers = document.getElementById("selectedUsers");

                // Danh sách tạm thời để lưu các tùy chọn cần xóa
                let optionsToRemove = [];

                // Lặp qua tất cả các options và kiểm tra xem nó có được chọn không
                for (let i = 0; i < optionsDropdown.options.length; i++) {
                    let option = optionsDropdown.options[i];
                    if (option.selected) {
                        // Thêm option đã chọn vào danh sách đã chọn
                        selectedUsers.appendChild(option.cloneNode(true));

                        // Thêm option cần xóa vào danh sách tạm thời
                        optionsToRemove.push(option);
                    }
                }

                // Sau khi thêm, xóa các option đã chọn từ danh sách chọn
                for (let i = 0; i < optionsToRemove.length; i++) {
                    optionsDropdown.removeChild(optionsToRemove[i]);
                }
            }

            function removeSelectedUsers() {
                let optionsDropdown = document.getElementById("optionsDropdown");
                let selectedUsers = document.getElementById("selectedUsers");

                // Danh sách tạm thời để lưu các tùy chọn cần xóa
                let optionsToRemove = [];

                // Lặp qua tất cả các options trong danh sách đã chọn và kiểm tra xem nó có được chọn không
                for (let i = 0; i < selectedUsers.options.length; i++) {
                    let option = selectedUsers.options[i];
                    if (option.selected) {
                        // Thêm option đã chọn lại vào danh sách chọn
                        optionsDropdown.appendChild(option.cloneNode(true));

                        // Thêm option cần xóa vào danh sách tạm thời
                        optionsToRemove.push(option);
                    }
                }

                // Sau khi thêm lại, xóa các option đã chọn từ danh sách đã chọn
                for (let i = 0; i < optionsToRemove.length; i++) {
                    selectedUsers.removeChild(optionsToRemove[i]);
                }
            }
        </script>
    </div>
</body>

</html