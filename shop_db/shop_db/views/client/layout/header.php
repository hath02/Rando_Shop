<!DOCTYPE html>
<html>
<head>
    <title>Shop</title>
    <link rel="stylesheet" href="/shop_db/public/css/style.css">
</head>
<body>
    <div class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <a href="index.php?action=home" class="logo">Rando</a>
            </div>

            <div class="nav-center">
                <a href="index.php?action=home">Home</a>
                <a href="index.php?action=product">Shop</a>
                <a href="index.php?action=sales">Sales</a>

                <div class="dropdown">
                    <a href="#" class="dropdown-btn">Collections ⏷</a>
                    <div class="dropdown-content">
                        <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
                            <a href="index.php?action=category&id=<?php echo $cat['id']; ?>">
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <a href="index.php?action=my_account">My Account</a>
                <a href="index.php?action=cart">Cart</a>
            </div>
            
            <div class="nav-right">
                <a href="index.php?action=logout" class="logout-link">Logout</a>
            </div>
        </div>
    </div>