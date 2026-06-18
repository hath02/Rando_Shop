<?php include 'views/admin/layout/header.php'; ?>

<div class="container admin-page">
    <div class="admin-header">
        <h2>Add Account</h2>
    </div>

    <div class="admin-form-box">
        <form method="POST" action="/shop_db/index.php?action=admin_add_account">

            <label>Username:</label><br>
            <input type="text" name="username" placeholder="Username"><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" placeholder="Email"><br><br>

            <label>Password:</label><br>
            <input type="password" name="password" placeholder="Password"><br><br>

            <label>Address:</label><br>
            <input type="text" name="address" placeholder="Address"><br><br>

            <label for="role">Role:</label>
            <select name="role" id="role">
                <option value="admin">Admin</option>
                <option value="client">Client</option>
            </select><br><br>

            <button type="submit" class="admin-btn">Add Account</button>

        </form>
    </div>
</div>

<?php include 'views/admin/layout/footer.php'; ?>