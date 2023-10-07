<?php
function generateFakeData($id)
{
    $names = ["John Doe", "Jane Smith", "Alice Johnson"];
    $usernames = ["johndoe123", "janesmith456", "alicej"];
    $emails = ["johndoe@example.com", "janesmith@example.com", "alice@example.com"];
    $createdAt = date("Y-m-d H:i:s");
    $statuses = ["active", "inactive"];
    $addresses = ["123 Main St, City", "456 Elm St, Town", "789 Oak St, Village"];
    $authors = ["Học sinh", "Giảng viên", "Admin"]; // Các tùy chọn cho trường Author

    $data = [
        "id" => $id,
        "name" => $names[array_rand($names)],
        "username" => $usernames[array_rand($usernames)],
        "email" => $emails[array_rand($emails)],
        "createdAt" => $createdAt,
        "status" => $statuses[array_rand($statuses)],
        "address" => $addresses[array_rand($addresses)],
        "author" => $authors[array_rand($authors)],
    ];

    return $data;
}

$fakeDataArray = [];
for ($i = 1; $i <= 5; $i++) {
    $fakeDataArray[] = generateFakeData($i);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table</title>
    <link rel="stylesheet" href="./index.css">
</head>

<body>
    <h1>Danh sách người dùng</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Address</th>
                <th>Status</th>
                <th>Author</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fakeDataArray as $fakeData) { ?>
                <tr>
                    <td><?php echo $fakeData["id"]; ?></td>
                    <td><?php echo $fakeData["name"]; ?></td>
                    <td><?php echo $fakeData["username"]; ?></td>
                    <td><?php echo $fakeData["email"]; ?></td>
                    <td><?php echo $fakeData["address"]; ?></td>
                    <td>
                        <select>
                            <option value="active" <?php if ($fakeData["status"] === "active") echo "selected"; ?>>Active</option>
                            <option value="inactive" <?php if ($fakeData["status"] === "inactive") echo "selected"; ?>>Inactive</option>
                        </select>
                    </td>
                    <td><?php echo $fakeData["author"]; ?></td> <!-- Hiển thị giá trị Author -->
                    <td><?php echo $fakeData["createdAt"]; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>