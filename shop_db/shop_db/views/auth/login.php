<link rel="stylesheet" href="/shop_db/public/css/style.css">

<div class="auth-page">
    <form class="auth-form" method="POST" action="index.php?action=loginPost">

        <h2>Login</h2>

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>

        <button type="submit" class="btn">Login</button>

        <p class="link">
            Don't have an account? 
            <a href="index.php?action=register">Register here</a>
        </p>

    </form>
</div>

<?php include "views/client/layout/footer.php"; ?>