<?php include "views/client/layout/header.php"; ?>

<div class="container">

    <form method="GET" action="index.php" class="search-form">
        <input type="hidden" name="action" value="client_search_product">
        <input type="text" name="keyword" placeholder="Search product...">
        <button>Search</button>
    </form>

    <div class="products-grid">

        <?php while ($row = mysqli_fetch_assoc($products)) { ?>

            <div class="product-card">

                <?php if (!empty($row['on_sale'])) { ?>
                    <span class="sale-badge">Sale!</span>
                <?php } ?>

                <div class="product-image">
                    <a href="index.php?action=product_details&id=<?php echo $row['id']; ?>">
                        <?php if (!empty($row['image'])) { ?>
                            <img src="public/uploads/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        <?php } else { ?>
                            <img src="https://via.placeholder.com/250x250" alt="No image">
                        <?php } ?>
                    </a>
                </div>

                <div class="product-info">
                    <p class="product-category">
                        <?php echo htmlspecialchars($row['category_name']); ?>
                    </p>

                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>

                    <div class="price-box">
                        <?php if (!empty($row['on_sale']) && !empty($row['sale_price'])) { ?>
                            <span class="old-price">
                                $<?php echo number_format($row['price'], 2); ?>
                            </span>

                            <span class="new-price">
                                $<?php echo number_format($row['sale_price'], 2); ?>
                            </span>
                        <?php } else { ?>
                            <span class="new-price">
                                $<?php echo number_format($row['price'], 2); ?>
                            </span>
                        <?php } ?>
                    </div>

                    <button class="btn add-to-cart" data-id="<?= $row['id'] ?>">
                        Add to cart
                    </button>
                </div>

            </div>
        <?php } ?>
    </div>
</div>

<?php include "views/client/layout/footer.php"; ?>