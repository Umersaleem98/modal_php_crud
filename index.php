<?php
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <!-- model for inserting data  -->
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="number" name="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" required>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- insertion code in php -->
    <?php
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        $query = "INSERT INTO `person`(`name`, `email`, `phone`, `password`) VALUES ('$name','$email','$phone','$password')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Your data is inserted";
            header('location: index.php');
        } else {
            echo "Error occurred";
        }
    }
    ?>

    <!-- insertion code ended  -->

    <!-- delete functionality in php -->
    <?php
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $delete_query = "DELETE FROM `person` WHERE id='$delete_id'";
        $delete_result = mysqli_query($conn, $delete_query);

        if ($delete_result) {
            echo "User data deleted successfully.";
            header('location: index.php');
        } else {
            echo "Error occurred while deleting user data.";
        }
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <button type="button" class="btn btn-primary my-5" data-toggle="modal" data-target=".modal">
                    Add User
                </button>
                <table class="table table-bordered my-1">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $limit = 5; // Number of records per page
                    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page number
                    $start = ($page - 1) * $limit; // Calculate the starting row number for the query

                    $query = "SELECT * FROM `person` LIMIT $start, $limit";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['phone'] ?></td>
                        <td><?php echo $row['password'] ?></td>
                        <td>
                            <!-- Update button triggers the modal -->
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                data-target="#updateUserModal<?php echo $row['id']; ?>">Update</button>

                            <!-- Delete button -->
                            <a href="index.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>

                    <!-- Update Modal for each user -->
                    <div class="modal" id="updateUserModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update User</h5>
                                </div>
                                <div class="modal-body">
                                    <form action="update.php" method="post">
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="<?php echo $row['name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                value="<?php echo $row['email']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Phone</label>
                                            <input type="number" name="phone" class="form-control"
                                                value="<?php echo $row['phone']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input type="password" name="password" class="form-control"
                                                value="<?php echo $row['password']; ?>" required>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="form-group">
                                            <input type="submit" name="update" class="btn btn-primary" required>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </table>

                <!-- Pagination -->
                <?php
                $pagination_query = "SELECT COUNT(*) as total FROM `person`";
                $pagination_result = mysqli_query($conn, $pagination_query);
                $pagination_data = mysqli_fetch_assoc($pagination_result);
                $total_records = $pagination_data['total'];
                $total_pages = ceil($total_records / $limit);

                echo '<ul class="pagination">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<li class="page-item"><a class="page-link" href="index.php?page=' . $i . '">' . $i . '</a></li>';
                }
                echo '</ul>';
                ?>
            </div>
        </div>
    </div>

    <!-- ... (your existing code) ... -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
