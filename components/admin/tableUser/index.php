<?php
include "../../../config/connectSQL/index.php";

$sql = "SELECT * FROM users WHERE 1";
$stmt = $db->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$totalDataPoints = $result->num_rows; // Get the total number of data points from the result
$dataPerPage = 10;
$totalPages = ceil($totalDataPoints / $dataPerPage);
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($currentPage - 1) * $dataPerPage;

$data = [];

// Fetch and store the data for the current page
for ($i = 0; $i < $totalDataPoints; $i++) {
    $row = $result->fetch_assoc();
    if (!$row) {
        break; // Break the loop if there is no more data
    }
    $data[] = $row;
}

$dataForPage = array_slice($data, $offset, $dataPerPage);

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
            <?php foreach ($dataForPage as $item) { ?>
                <tr>

                    <td><?php echo $item["id"]; ?></td>
                    <td><?php echo $item["name"]; ?></td>
                    <td><?php echo $item["username"]; ?></td>
                    <td><?php echo $item["email"]; ?></td>
                    <td><?php echo $item["address"]; ?></td>
                    <td>
                        <select>
                            <option value="active" <?php if ($item["status"] === "active") echo "selected"; ?>>Active</option>
                            <option value="inactive" <?php if ($item["status"] === "inactive") echo "selected"; ?>>Inactive</option>
                        </select>
                    </td>
                    <!-- <td><?php echo $item["author"]; ?></td> -->
                    <td><?php echo $item["createAt"]; ?></td>
                    <td><?php echo $item["updateAt"]; ?></td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($currentPage > 1) { ?>
            <a href='index.php?page=<?php echo $currentPage - 1; ?>' class='number'>Previous</a>
        <?php } ?>
        <?php for ($page = 1; $page <= $totalPages; $page++) { ?>
            <a href='index.php?page=<?php echo $page; ?>' class='number <?php echo ($currentPage == $page) ? 'current' : ''; ?>'><?php echo $page; ?></a>
        <?php } ?>
        <?php if ($currentPage < $totalPages) { ?>
            <a href='index.php?page=<?php echo $currentPage + 1; ?>' class='number'>Next</a>
        <?php } ?>
    </div>
</body>

</html>