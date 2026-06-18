<?php include __DIR__ . "/../layout/header.php"; ?>

<div class="container">
    <h2>My Account</h2>

    <form method="POST" action="/shop_db/index.php?action=update_account" class="account-form">

        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($account['username']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($account['email']) ?>" required>

        <label>New Password (optional)</label>
        <input type="password" name="password" placeholder="Leave blank to keep current password">

        <label>Address</label>
        <input type="text" name="address" value="<?= htmlspecialchars($account['address']) ?>" required>

        <button type="submit" class="btn">Update Account</button>
        <button type="button" class="btn" onclick="window.location.href='/shop_db/index.php?action=order_history'">Order History</button>
    </form>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>