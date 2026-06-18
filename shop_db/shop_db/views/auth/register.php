<link rel="stylesheet" href="/shop_db/public/css/style.css">

<div class="auth-page">
    <form class="auth-form" method="POST" action="index.php?action=registerPost">

        <h2>Register</h2>

        <label>Username</label>
        <input type="text" name="username" placeholder="Enter your username" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Create a password" required>

        <label>Address</label>
        <input type="text" name="address" placeholder="Enter your address" required>

        <button type="submit" class="btn">Register</button>

        <p class="link">
            Already have an account? 
            <a href="index.php?action=login">Login here</a>
        </p>

    </form>
</div>

<?php include "views/client/layout/footer.php"; ?>