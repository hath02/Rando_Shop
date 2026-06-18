<?php include "views/admin/layout/header.php"; ?>

<div class="container admin-page">
    <h2>Search Categories</h2>

    <form method="GET" action="/shop_db/index.php" class="search-form">
        <input type="hidden" name="action" value="admin_search_category">
        <input type="text" name="keyword" placeholder="Search by id or name ">
        <button type="submit">Search</button>
    </form>

    <div class="admin-table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>

            <?php while($row = mysqli_fetch_assoc($categories)){ ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['description'] ?></td>
                <td>
                    <div class="admin-action">
                        <a href="/shop_db/index.php?action=admin_edit_category&id=<?= $row['id']; ?>" class="admin-btn">
                            Edit
                        </a> 

                        <a href="/shop_db/index.php?action=admin_delete_category&id=<?= $row['id']; ?>" class="btn btn-danger">
                            Delete
                        </a>
                    </div>
                </td>

            </tr>
            <?php } ?>
        </table>