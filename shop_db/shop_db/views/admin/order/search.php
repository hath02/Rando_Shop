<?php include __DIR__ . "/../layout/header.php"; ?>

<div class="container admin-page">

    <div class="admin-header">
        <h2>Search Orders</h2>
        <a href="index.php?action=admin_orders" class="admin-btn">← Back</a>
    </div>

    <!-- SEARCH BAR -->
    <form method="GET" action="index.php" class="search-form">
        <input type="hidden" name="action" value="admin_search_order">
        <input type="text" name="keyword" placeholder="Search by ID, name, phone, status..." 
               value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        <button type="submit">Search</button>
    </form>

    <div class="order-table-wrapper">

        <?php if (!empty($orders) && mysqli_num_rows($orders) > 0): ?>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($orders)): ?>
                        <tr>
                            <td>#<?= $row['id'] ?></td>

                            <td><?= htmlspecialchars($row['name']) ?></td>

                            <td><?= htmlspecialchars($row['phone']) ?></td>

                            <td>$<?= number_format($row['total_price'], 2) ?></td>

                            <td>
                                <span class="order-status status-<?= $row['status'] ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>

                            <td><?= htmlspecialchars($row['created_at']) ?></td>

                            <td class="order-action">
                                <a href="index.php?action=admin_order_detail&id=<?= $row['id'] ?>">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        <?php else: ?>

            <div class="checkout-empty">
                <p>No orders found.</p>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>