<?php include "views/admin/layout/header.php"; ?>

<div class="container admin-page">
    <div class="admin-header">
        <h2>Add Product</h2>
    </div>

    <div class="admin-form-box">
        <form method="POST" action="index.php?action=admin_add_product" enctype="multipart/form-data">

            <label>Product Name:</label><br>
            <input type="text" name="name"><br><br>

            <lable>Description:</label><br>
            <textarea name="description"></textarea><br><br>

            <label>Price:</label><br>
            <input type="number" name="price"><br><br>

            <label>Category:</label><br>
            <select name="category_id">
                <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= $cat['id'] ?>">
                        <?= $cat['name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
            <label>Image:</label><br>
            <input type="file" name="image"><br><br>

            <label>Stock:</label><br>
            <input type="number" name="stock"><br><br>

            <label>On Sale:</label><br>
            <select name="on_sale">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select><br><br>

            <label>Sale Price:</label><br>
            <input type="number" name="sale_price"><br><br>


            <button type="submit" class="admin-btn">Add Product</button>

        </form>
    </div>
</div>

<?php include "views/admin/layout/footer.php"; ?>