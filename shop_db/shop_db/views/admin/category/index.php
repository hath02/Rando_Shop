<?php include "views/admin/layout/header.php"; ?>

<div class="container admin-page">
    <div class="admin-header">
        <h2>Category List</h2>
        <a href="/shop_db/index.php?action=admin_create_category" class="admin-btn">+ Add Category</a>
    </div>

    <form method="GET" action="/shop_db/index.php" class="search-form">
        <input type="hidden" name="action" value="admin_search_category">
        <input type="text" name="keyword" placeholder="Search by name or description">
        <button type="submit">Search</button>
    </form>

    <div class="admin-table-wrapper">
        <table>
            <thread>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thread>

            <?php while($row = mysqli_fetch_assoc($categories)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['description'] ?></td>

                <td>
                    <div class="admin-action">
                        <a href="/shop_db/index.php?action=admin_edit_category&id=<?= $row['id'] ?>" class="admin-btn">Edit</a>
                        <a href="/shop_db/index.php?action=admin_delete_category&id=<?= $row['id'] ?>" class="btn-danger">Delete</a>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<?php include "views/admin/layout/footer.php"; ?>