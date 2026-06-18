<?php include "views/admin/layout/header.php"; ?>

<div class="container admin-page">
    <div class="admin-header">
        <h2>Admin - Products</h2>
        <a href="index.php?action=admin_create_product" class="admin-btn">+ Add Product</a>
    </div>

    <form method="GET" action="index.php" class="search-form">
        <input type="hidden" name="action" value="admin_search_product">
        <input type="text" name="keyword" placeholder="Search product...">
        <button>Search</button>
    </form>

    <div class="admin-table-wrapper">
        <table>
            <thread>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>In Stock</th>
                    <th>On Sale</th>
                    <th>Sale Price</th>
                    <th>Action</th>
                </tr>
            </thread>

            <tbody>

                <?php while($row = mysqli_fetch_assoc($products)){ ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>

                    <td><?php echo $row['name']; ?></td>

                    <td>
                        <?php if($row['image']){ ?>
                            <img src="public/uploads/<?php echo $row['image']; ?>" class="admin-product-image">
                        <?php } else { ?>
                        <span class="admin-no-image"> No image </span>
                        <?php } ?>
                    </td>

                    <td>$<?php echo $row['price']; ?></td>

                    <td><?php echo $row['category_name']; ?></td>

                    <td><?php echo $row['stock']; ?></td>

                    <td><?php echo $row['on_sale'] ? 'Yes' : 'No'; ?></td>

                    <td>
                        <?php echo $row['on_sale'] ? '$' . $row['sale_price'] : '-'; ?>
                    </td>


                    <td>
                        <div class="admin-action">
                            <a href="index.php?action=admin_edit_product&id=<?php echo $row['id']; ?>" class="admin-btn">
                                Edit
                            </a> 

                            <a href="index.php?action=admin_product_detail&id=<?php echo $row['id']; ?>" class="admin-btn">
                                View
                            </a>

                            <a href="index.php?action=admin_delete_product&id=<?php echo $row['id']; ?>" class="btn btn-danger">
                                Delete
                            </a>
                    </td>
                </tr>
                <?php } ?>

        </table>
    </div>

</div>

<?php include "views/admin/layout/footer.php"; ?>