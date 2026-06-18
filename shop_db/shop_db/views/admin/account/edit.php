<?php include "views/admin/layout/header.php"; ?>

<div class="container">
    <div class="admin-header">
        <h2>Edit Account</h2>
    </div>

    <div class="admin-form-box">
        <form method="POST" action="/shop_db/index.php?action=admin_update_account">

            <input type="hidden" name="id" value="<?= $account['id'] ?>">

            <label>Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($account['username'] ?? '') ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($account['email'] ?? '') ?>" required>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Leave blank to keep current password">

            <label>Address:</label>
            <input type="text" name="address" value="<?= htmlspecialchars($account['address'] ?? '') ?>" placeholder="Leave blank to keep current address">

            <label>Role:</label>
            <select name="role" required>
                <option value="admin"
                    <?= (($account['role'] ?? '') === 'admin') ? 'selected' : '' ?>>
                    Admin
                </option>

                <option value="client"
                    <?= in_array(($account['role'] ?? ''), ['client', 'user']) ? 'selected' : '' ?>>
                    Client
                </option>
            </select>

            <button type="submit" class="admin-btn">Update Account</button>
        </form>
    </div>
</div>

<?php include "views/admin/layout/footer.php"; ?>