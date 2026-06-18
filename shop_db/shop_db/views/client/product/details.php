<?php include __DIR__ . "/../layout/header.php"; ?>

<div class="product-details">

    <!-- LEFT: IMAGE GALLERY -->
    <div class="product-gallery">

        <div class="main-image" id="zoom-container">

            <?php if(!empty($product['image'])){ ?>
                <img 
                    id="main-product-img"
                    src="/shop_db/public/uploads/<?= htmlspecialchars($product['image']); ?>" 
                    alt="<?= htmlspecialchars($product['name']); ?>">
            <?php } ?>

            <!-- zoom lens -->
            <div id="zoom-lens"></div>

            <!-- keep your UI -->
            <span class="badge-sale">Sale!</span>
            <span class="zoom-icon">🔍︎</span>

        </div>

        <div class="thumbnail-list">
            <img src="/shop_db/public/uploads/<?= htmlspecialchars($product['image']); ?>">
            <img src="/shop_db/public/uploads/<?= htmlspecialchars($product['image']); ?>">
        </div>

    </div>

    <!-- RIGHT: INFO -->
    <div class="product-details-info">

        <div class="breadcrumb">
            Home / Living Room / <?= htmlspecialchars($product['name']); ?>
        </div>

        <h2 class="product-details-name">
            <?= htmlspecialchars($product['name']); ?>
        </h2>

        <div class="product-price">
            <?php if(!empty($product['on_sale']) && !empty($product['sale_price'])){ ?>
                <span class="product-old-price">
                    $<?= number_format($product['price'], 2, '.', ','); ?>
                </span>
                <span>
                    $<?= number_format($product['price'], 2, '.', ','); ?>
                </span>
            <?php } else { ?>
                $<?= number_format($product['price'], 2, '.', ','); ?>
            <?php } ?>
        </div>

        <input type="number" value="1" min="1" class="qty-input">

        <button class="btn add-to-cart" data-id="<?= $product['id'] ?>">
            Add to cart
        </button>

        <div class="category">
            <p class="home-product-category">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
        </div>

    </div>

</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>