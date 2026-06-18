<?php include "views/client/layout/header.php"; ?>

<div class="container" style="padding: 30px;">

    <h2>My Orders</h2>

    <div class="admin-table-wrapper">
        <table border="1" width="100%" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($orders && mysqli_num_rows($orders) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($orders)): ?>
                        <tr>
                            <td>#<?= $row['id'] ?></td>
                            <td>$<?= number_format($row['total_price'], 2) ?></td>
                            <td>
                                <span class="order-status status-<?= $row['status'] ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            <td><?= $row['created_at'] ?></td>
                            <td>
                                <div class="admin-action">
                                    <a href="index.php?action=order_detail&id=<?= $row['id'] ?>" class="admin-btn">
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">
                            No orders found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>                
</div>

<?php include "views/client/layout/footer.php"; ?>