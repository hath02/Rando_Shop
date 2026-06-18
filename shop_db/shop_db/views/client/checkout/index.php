<?php include __DIR__ . "/../layout/header.php"; ?>
<div class="container">
    <h2>Checkout</h2>

    <?php if (!empty($cartItems)): ?>
        <div class="checkout-wrapper">

            <!-- LEFT -->
            <div class="checkout-form">
                <h3>Customer Info</h3>

                <form method="POST" action="index.php?action=place_order">

                    <label>Full Name</label>
                    <input type="text" name="name" required>

                    <label>Email</label>
                    <input type="email" name="email" required>

                    <label>Phone</label>
                    <input type="text" name="phone" required>

                    <label>Address</label>
                    <textarea name="address" required></textarea>

                    <button class="btn btn-success checkout-btn">
                        Place Order
                    </button>
                </form>
            </div>

            <!-- RIGHT -->
            <div class="checkout-summary">
                <h3>Order Summary</h3>

                <?php foreach ($cartItems as $item): ?>
                    <div class="checkout-item">
                        <span><?= $item['name'] ?> x <?= $item['quantity'] ?></span>
                        <span>$<?= $item['price'] * $item['quantity'] ?></span>
                    </div>
                <?php endforeach; ?>

                <div class="checkout-total">
                    Total: $<?= $total ?>
                </div>
            </div>

        </div>

    <?php else: ?>
        <div class="checkout-empty">
            <h3>Your cart is empty</h3>
            <a href="index.php" class="btn">Go Shopping</a>
        </div>
    <?php endif; ?>
</div>