<?php include "views/admin/layout/header.php"; ?>

<div class="container admin-page">
    <div class="admin-header">
        <h2>Edit Product</h2>
    </div>

    <div class="admin-form-box">
        <form method="POST" action="index.php?action=admin_update_product" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $product['id'] ?>">

            <label>Name:</label><br>
            <input type="text" name="name" value="<?= $product['name'] ?>"><br><br>

            <label>Description:</label><br>
            <textarea name="description"><?= $product['description'] ?></textarea><br><br>

            <label>Price:</label><br>
            <input type="number" name="price" value="<?= $product['price'] ?>"><br><br>

            <label>Category:</label><br>
            <select name="category_id">
                <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= $cat['id'] ?>"
                        <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                        <?= $cat['name'] ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>

            <label>Stock:</label><br>
            <input type="number" name="stock" value="<?= $product['stock'] ?>"><br><br>

            <label>On Sale:</label><br>
            <select name="on_sale">
                <option value="0" <?= $product['on_sale'] == 0 ? 'selected' : '' ?>>No</option>
                <option value="1" <?= $product['on_sale'] == 1 ? 'selected' : '' ?>>Yes</option>
            </select><br><br>

            <label>Sale Price:</label><br>
            <input type="number" name="sale_price" value="<?= $product['sale_price'] ?>"><br><br>


            <label>Current Image:</label><br>
            <?php if($product['image']): ?>
                <img src="public/uploads/<?= $product['image'] ?>" width="100"><br><br>
            <?php endif; ?>

            <label>New Image:</label><br>
            <input type="file" name="image"><br><br>

            <button type="submit" class="admin-btn">Update</button>

        </form>
    </div>
</div>