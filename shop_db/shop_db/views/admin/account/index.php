<?php include "views/admin/layout/header.php"; ?>

<div class="container admin-page">
    <div class="admin-header">
        <h2>Account List</h2>
        <a href="/shop_db/index.php?action=admin_create_account" class="admin-btn">+ Add Account</a>
    </div>

    <form method="GET" action="/shop_db/index.php" class="search-form">
        <input type="hidden" name="action" value="admin_search_account">
        <input type="text" name="keyword" placeholder="Search by email or role">
        <button type="submit">Search</button>
    </form>

    <div class="admin-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Address</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>

            <?php while($row = mysqli_fetch_assoc($accounts)){ ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['address'] ?></td>
                <td><?= $row['role'] ?></td>
                <td>
                    <div class="admin-action">
                        <a href="/shop_db/index.php?action=admin_edit_account&id=<?= $row['id'] ?>" class="admin-btn">Edit</a> 

                        <a href="/shop_db/index.php?action=admin_delete_account&id=<?= $row['id'] ?>" class="btn btn-danger">Delete</a>
                    </div>
                </td>

            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php include "views/admin/layout/footer.php"; ?>