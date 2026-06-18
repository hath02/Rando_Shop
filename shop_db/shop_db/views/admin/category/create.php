<?php include "views/admin/layout/header.php"; ?>

<div class="container admin-page">
    <div class="admin-header">
        <h2>Add Category</h2>
    </div>

    <div class="admin-form-box">
        <form method="POST" action="/shop_db/index.php?action=admin_add_category">

            <input type="text" name="name" placeholder="Category name"><br><br>

            <textarea name="description" placeholder="Description"></textarea><br><br>

            <button type="submit" class="admin-btn">Add</button>

        </form>
    </div>
</div>

<?php include "views/admin/layout/footer.php"; ?>