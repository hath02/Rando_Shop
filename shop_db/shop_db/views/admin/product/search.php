<?php include __DIR__ . "/../layout/header.php"; ?>

<div class="container admin-page">
    <div class="admin-header">
        <h2>Search Results (Admin)</h2>
    </div>

    <form method="GET" action="index.php" class="search-form">
        <input type="hidden" name="action" value="admin_search_product">
        <input type="text" name="keyword" placeholder="Search product...">
        <button class="admin-btn">Search</button>
    </form>

        <div class="admin-table-wrapper">
            <?php if ($products && mysqli_num_rows($products) > 0): ?>

                <table>
                    <thread>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>In Stock</th>
                            <th>Action</th>
                        </tr>
                    </thread>

                <?php while($row = mysqli_fetch_assoc($products)){ ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>

                    <td><?php echo $row['name']; ?></td>

                    <td>
                        <?php if($row['image']){ ?>
                            <img src="public/uploads/<?php echo $row['image']; ?>" width="80">
                        <?php } else { ?>
                            No image
                        <?php } ?>
                    </td>

                    <td>$<?php echo $row['price']; ?></td>

                    <td><?php echo $row['category_id']; ?></td>

                    <td><?php echo $row['stock']; ?></td>

                    <td>
                        <div class="admin-action">
                            <a href="index.php?action=admin_edit_product&id=<?php echo $row['id']; ?>" class="admin-btn">
                                Edit
                            </a>

                            <a href="index.php?action=admin_product_detail&id=<?php echo $row['id']; ?>" class="admin-btn">
                                View
                            </a>

                            <a href="index.php?action=admin_delete_product&id=<?php echo $row['id']; ?>" class="btn-danger">
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <?php } ?>

                </table>

            <?php else: ?>
            <p>No products found</p>
            <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>