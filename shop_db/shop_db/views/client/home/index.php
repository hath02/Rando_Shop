<?php include __DIR__ . '/../layout/header.php'; ?>


<?php // get products and categories from controller
$productList = [];
while ($row = mysqli_fetch_assoc($products)) {
    $productList[] = $row;
}
?>

<section class="hero-section hero-primary">
    <div class="hero-overlay">
        <div class="hero-content-primary">
            <h1>Better Furniture. Better Living.</h1>
            <p>
                Turn your house into a home with furniture that brings warmth,
                comfort, and meaningful moments to every corner.
            </p>
            <a href="index.php?action=product" class="hero-btn-primary">See More</a>
        </div>
    </div>
</section>

<section class="featured-section featured-primary">
        <?php
        $groupedProducts = [];

        foreach ($productList as $row) {
            $category = !empty($row['category_name']) ? $row['category_name'] : 'Other';
            $groupedProducts[$category][] = $row;
        }
        ?>

        <div class="featured-content">
            <?php foreach ($groupedProducts as $category => $items) { ?>
                <div class="category-section">
                    <div class="category-banner">
                        <img src="public/uploads/<?php echo strtolower(str_replace(' ', '-', $category)); ?>.jpg" alt="<?php echo $category; ?>">

                        <div class="category-overlay">
                            <span>Collection</span>
                            <h2><?php echo $category; ?></h2>
                            <a href="index.php?action=shop&category=<?php echo urlencode($category); ?>" class="category-btn">
                                See more
                            </a>
                        </div>
                    </div>

                    <div class="home-products-grid">
                        <?php foreach (array_slice($items, 0, 3) as $product) { ?>
                            <div class="home-product-card">

                                <?php if (!empty($product['on_sale'])) { ?>
                                    <span class="home-sale-badge">Sale!</span>
                                <?php } ?>

                                <div class="home-product-image">

                                    <a href="index.php?action=product_details&id=<?php echo $product['id']; ?>">
                                        <?php if (!empty($product['image'])) { ?>
                                            <img src="public/uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                                        <?php } else { ?>
                                            <img src="https://via.placeholder.com/250x250" alt="No image">
                                        <?php } ?>
                                    </a>
                                </div>

                                <div class="home-product-info">
                                    <p class="home-product-category"><?php echo $category; ?></p>

                                    <h3><?php echo $product['name']; ?></h3>

                                    <div class="home-price-box">
                                        <?php if (!empty($product['on_sale']) && !empty($product['sale_price'])) { ?>
                                            <span class="home-old-price">
                                                $<?php echo number_format($product['price'], 2); ?>
                                            </span>

                                            <span class="home-new-price">
                                                $<?php echo number_format($product['sale_price'], 2); ?>
                                            </span>
                                        <?php } else { ?>
                                            <span class="home-new-price">
                                                $<?php echo number_format($product['price'], 2); ?>
                                            </span>
                                        <?php } ?>
                                    </div>

                                    <button class="btn add-to-cart" data-id="<?= $product['id'] ?>">
                                        Add to cart
                                    </button>
                                </div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
</section>

<section class="hero-section hero-secondary">
    <div class="hero-overlay">
        <div class="hero-content-secondary">
            <h1>Discounted Funitures</h1>

            <a href="index.php?action=sales" class="hero-btn-secondary">Shop now</a>
        </div>
    </div>
</section>

<section class="featured-section featured-secondary">
    <?php 
        $saleProducts = [];

        foreach ($productList as $row) {
            if ($row['on_sale'] == 1 && $row['sale_price'] > 0) {
                    $saleProducts[] = $row;
            }
        }
    ?>

    <div class="featured-content">
        <div class="category-section">
            <div class="category-banner">
                <img src="public/uploads/on-sale.jpg" alt="Sale">

                <div class="category-overlay">
                    <span>Don't miss out on</span>
                    <h2>Our Sale!</h2>
                    <a href="index.php?action=sales" class="category-btn">
                        See more
                    </a>
                </div>
            </div>

            <div class="home-products-grid">
                <?php foreach (array_slice($saleProducts, 0, 3) as $product) { ?>
                    <div class="home-product-card">

                        <?php if (!empty($product['on_sale'])) { ?>
                            <span class="home-sale-badge">Sale!</span>
                        <?php } ?>

                        <div class="home-product-image">

                            <a href="index.php?action=product_details&id=<?php echo $product['id']; ?>">
                                <?php if (!empty($product['image'])) { ?>
                                    <img src="public/uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                                <?php } else { ?>
                                    <img src="https://via.placeholder.com/250x250" alt="No image">
                                <?php } ?>
                            </a>
                        </div>

                        <div class="home-product-info">
                            <p class="home-product-category"><?php echo htmlspecialchars($product['category_name']); ?></p>

                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>

                            <div class="home-price-box">
                                <?php if (!empty($product['on_sale']) && !empty($product['sale_price'])) { ?>
                                    <span class="home-old-price">
                                        $<?php echo number_format($product['price'], 2); ?>
                                    </span>

                                    <span class="home-new-price">
                                        $<?php echo number_format($product['sale_price'], 2); ?>
                                    </span>
                                <?php } else { ?>
                                    <span class="home-new-price">
                                        $<?php echo number_format($product['price'], 2); ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <button class="btn add-to-cart" data-id="<?= $product['id'] ?>">
                                Add to cart
                            </button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../layout/footer.php'; ?>