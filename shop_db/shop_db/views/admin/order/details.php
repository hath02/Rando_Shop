<?php include "views/admin/layout/header.php"; ?>

<div class="container order-details-page">

<?php if (!empty($order)): ?>

    <h2>Order #<?= $order['id'] ?></h2>

    <!-- ORDER INFO -->
    <div class="order-info-box">
        <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
        <p><strong>Order Date:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
        <p><strong>Total:</strong> $<?= number_format($order['total_price'], 2) ?></p>
    </div>

    <!-- SHIPPING INFO -->
    <div class="order-info-box">
        <h3>Shipping Information</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($order['name'] ?? 'N/A') ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone'] ?? 'N/A') ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($order['address'] ?? 'N/A') ?></p>
    </div>

    <!-- ORDER ITEMS -->
    <h3>Items</h3>

    <div class="order-items">
        <?php foreach ($orderItems as $item): ?>
            <div class="order-item">
                
                <div class="order-item-img">
                    <img src="public/uploads/<?php echo htmlspecialchars($item['product_image']); ?>" class="order-item-img">
                </div>

                <div class="order-item-info">
                    <h4><?= htmlspecialchars($item['product_name']) ?></h4>
                    <p>Price: $<?= number_format($item['price'], 2) ?></p>
                    <p>Quantity: <?= $item['quantity'] ?></p>
                </div>

                <div class="order-item-total">
                    $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

<?php else: ?>

    <p>Order not found.</p>

<?php endif; ?>

</div>

<?php include "views/admin/layout/footer.php"; ?>