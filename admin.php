<?php
// Database connection
$servername = "localhost";
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "daily_target_system"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the Add, Edit, and Delete actions

// Add new record
if (isset($_POST['add'])) {
    $style_name = $_POST['style_name'];
    $target_name = $_POST['target_name'];
    $sql = "INSERT INTO labels (style_name, target_name) VALUES ('$style_name', '$target_name')";
    $conn->query($sql);
}

// Edit record
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $style_name = $_POST['style_name'];
    $target_name = $_POST['target_name'];
    $sql = "UPDATE labels SET style_name='$style_name', target_name='$target_name' WHERE id=$id";
    $conn->query($sql);
}

// Delete record
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM labels WHERE id=$id";
    $conn->query($sql);
}

// Fetch all records to display in the DataGrid
$sql = "SELECT * FROM labels";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Labels</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            margin: 5px 0;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Admin Panel - Manage Labels</h2>

<!-- Add New Label Form -->
<div style="text-align:center;">
    <form action="admin.php" method="POST">
        <h3>Add New Label</h3>
        <input type="text" name="style_name" placeholder="Enter Style Name" required>
        <input type="text" name="target_name" placeholder="Enter Target Name" required>
        <input type="submit" name="add" value="Add Label">
    </form>
</div>

<!-- DataGrid/Table for Viewing, Editing, and Deleting Labels -->
<div style="text-align:center;">
    <h3>Existing Labels</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Style Name</th>
                <th>Target Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['style_name'] . "</td>";
                    echo "<td>" . $row['target_name'] . "</td>";
                    echo "<td>
                            <form action='admin.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <input type='text' name='style_name' value='" . $row['style_name'] . "' required>
                                <input type='text' name='target_name' value='" . $row['target_name'] . "' required>
                                <input type='submit' name='edit' value='Edit'>
                            </form>
                            <form action='admin.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                <input type='submit' name='delete' value='Delete'>
                            </form>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center;'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
