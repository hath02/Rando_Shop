<?php include "views/admin/layout/header.php"; ?>

<div class="container admin-page">
    <div class="admin-header">
        <h2>Edit Category</h2>
    </div>

    <div class="admin-form-box">
        <form method="POST" action="/shop_db/index.php?action=admin_update_category">

            <input type="hidden" name="id" value="<?= $category['id'] ?>">

            <label>Name:</label><br>
            <input type="text" name="name" value="<?= $category['name'] ?>"><br><br>

            <label>Description:</label><br>
            <textarea name="description"><?= $category['description'] ?></textarea><br><br>

            <button type="submit" class="admin-btn">Update Category</button>
        </form>
    </div>
</div>

<?php include "views/admin/layout/footer.php"; ?>