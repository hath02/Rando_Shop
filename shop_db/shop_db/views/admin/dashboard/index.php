<link rel="stylesheet" href="public/css/style.css">

<div class="container admin-page">
    <h1>Admin Dashboard</h1>

    <div class="admin-dashboard-grid">

            <a href="index.php?action=admin_accounts" class="admin-dashboard-card">
                <span class="admin-dashboard-title">Manage Accounts</span>
                <span class="admin-dashboard-text">View, edit and remove user accounts.</span>
            </a>

            <a href="index.php?action=admin_products" class="admin-dashboard-card">
                <span class="admin-dashboard-title">Manage Products</span>
                <span class="admin-dashboard-text">Add, edit and delete products.</span>
            </a> 

            <a href="index.php?action=admin_categories" class="admin-dashboard-card">
                <span class="admin-dashboard-title">Manage Categories</span>
                <span class="admin-dashboard-text">Organize your product categories.</span>
            </a>

            <a href="index.php?action=admin_orders" class="admin-dashboard-card">
                <span class="admin-dashboard-title">Manage Orders</span>
                <span class="admin-dashboard-text">View and update customer orders.</span>
            </a>

            <a href="index.php?action=logout" class="admin-dashboard-card admin-dashboard-card-danger">
                <span class="admin-dashboard-title">Logout</span>
                <span class="admin-dashboard-text">Sign out of the admin panel.</span>
            </a>

    </div>
</div>