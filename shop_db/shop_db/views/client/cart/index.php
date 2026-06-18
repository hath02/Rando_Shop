<?php include __DIR__ . "/../layout/header.php"; ?>

<div class="container cart-page">

    <h2>Cart</h2>

    <?php if (!empty($cartItems)): ?>

        <?php $total = 0; ?>

        <div class="cart-layout">

            <!-- LEFT: ITEMS -->
            <div class="cart-items">

                <?php foreach ($cartItems as $row): ?>
                    <?php
                        $subtotal = $row['price'] * $row['quantity'];
                        $total += $subtotal;
                    ?>

                    <div class="cart-item-modern">

                        <img src="/shop_db/public/uploads/<?php echo $row['image']; ?>" class="cart-img-modern">

                        <div class="cart-info">
                            <h4><?php echo $row['name']; ?></h4>

                            <div class="cart-price">
                                <span class="new"><?php echo number_format($row['price']); ?> $</span>
                            </div>

                            <div class="cart-actions">

                                <form method="POST" action="/shop_db/index.php?action=update_cart">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                    <div class="qty-box">
                                        <button type="button" onclick="this.parentNode.querySelector('input').stepDown()">-</button>

                                        <input type="number"
                                               name="quantity"
                                               value="<?php echo $row['quantity']; ?>"
                                               min="1">

                                        <button type="button" onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                                    </div>

                                    <button class="btn" type="submit">Update</button>
                                </form>

                                <a href="/shop_db/index.php?action=delete_from_cart&id=<?php echo $row['id']; ?>"
                                   class="remove-btn">
                                    🗑
                                </a>

                            </div>
                        </div>

                        <div class="cart-total">
                            <?php echo number_format($subtotal); ?> $
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

            <!-- RIGHT: SUMMARY -->
            <div class="cart-summary">

                <h3>Cart Totals</h3>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span><?php echo number_format($total); ?> $</span>
                </div>

                <div class="summary-row">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>

                <div class="summary-total">
                    <span>Total</span>
                    <span><?php echo number_format($total); ?> $</span>
                </div>

                <a href="/shop_db/index.php?action=checkout" class="checkout-btn">
                    Proceed to Checkout
                </a>

                <a href="/shop_db/index.php?action=clear_cart" class="btn-danger" style="width:100%; margin-top:10px; text-align:center;">
                    Clear Cart
                </a>

            </div>

        </div>

    <?php else: ?>

        <div class="empty-cart">
            <p>Your cart is empty.</p>
            <a href="/shop_db/index.php" class="btn">Shop Now</a>
        </div>

    <?php endif; ?>

</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>