<?php include __DIR__ . "/../layout/header.php"; ?>

<div class="product-details">
    <div class="product-image">

        <?php if(!empty($product['image'])){ ?>
            <img src="/shop_db/public/uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
        <?php } ?>
    </div>
    <div class="product-details-info">
        <h2 class="product-details-name"><?= htmlspecialchars($product['name']); ?></h2>

        <div class="product-price">
            <?php if(!empty($product['on_sale']) && !empty($product['sale_price'])){ ?>
                <span class="product-old-price">
                    $<?= number_format($product['price'], 2); ?>
                </span>
                <span>
                    $<?= number_format($product['sale_price'], 2); ?>
                </span>
            <?php } else { ?>
                $<?= number_format($product['price'], 2); ?>
            <?php } ?>
        </div>

        <button class="btn add-to-cart" data-id="<?= $product['id'] ?>">
            Add to cart
        </button>
    </div>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>