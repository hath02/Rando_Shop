<?php
session_start(); 

ini_set('display_errors', 1);
error_reporting(E_ALL);

// database connection
require "config/database.php";

// controllers
require "controllers/authController.php";

// admin controllers
require "controllers/admin/dashboardController.php";
require "controllers/admin/accountController.php";
require "controllers/admin/productController.php";
require "controllers/admin/categoryController.php";
require "controllers/admin/orderController.php";

// client controllers
require "controllers/client/homeController.php";
require "controllers/client/accountController.php";
require "controllers/client/productController.php";
require "controllers/client/cartController.php";
require "controllers/client/checkoutController.php";

$action = $_GET['action'] ?? 'home';

// route requests
switch($action){

    // auth
    case "login":
        $auth = new AuthController();
        $auth->login();
    break;

    case "loginPost":
        $auth = new AuthController();
        $auth->loginPost();
    break;

    case "register":
        $auth = new AuthController();
        $auth->register();
    break;

    case "registerPost":
        $auth = new AuthController();
        $auth->registerPost();
    break;

    case "logout":
        $auth = new AuthController();
        $auth->logout();
    break;

    // client
        
        // home page
        case "home":
            $homeController = new HomeController($conn);
            $homeController->index();
        break;

        //account
        case "my_account":
            $accountController = new AccountController($conn);
            $accountController->index();
        break;

        case "update_account":
            $accountController = new AccountController($conn);
            $accountController->update();
        break;

        // products
        case "product":
            $clientProduct = new ClientProductController();
            $clientProduct->shop();
        break;

        case "sales":
            $clientProduct = new ClientProductController();
            $clientProduct->sales();
        break;

        case "category":
            $clientProduct = new ClientProductController();
            $clientProduct->category();
        break;

        case "product_details":
            $clientProduct = new ClientProductController();
            $clientProduct->detail();
        break;

        case "client_search_product":
            $clientProduct = new ClientProductController();
            $clientProduct->search();
        break;

        // cart
        case "cart":
            $cartController = new CartController($conn);
            $cartController->index();
        break;
        
        case "add_to_cart":
            $cartController = new CartController($conn);
            $cartController->add();
        break;

        case "update_cart":
            $cartController = new CartController($conn);
            $cartController->update();
        break;

        case "delete_from_cart":
            $cartController = new CartController($conn);
            $cartController->delete();
        break;

        case "clear_cart":
            $cartController = new CartController($conn);
            $cartController->clear();
        break;

        // checkout
        case "checkout":
            $checkoutController = new CheckoutController($conn);
            $checkoutController->index();
        break;

        case "place_order":
            $checkoutController = new CheckoutController($conn);
            $checkoutController->placeOrder();
        break;

        case "order_success":
            $checkoutController = new CheckoutController($conn);
            $checkoutController->success();
        break;

        case "order_history":
            $checkoutController = new CheckoutController($conn);
            $checkoutController->history();
        break;

        case "order_detail":
            $checkoutController = new CheckoutController($conn);
            $checkoutController->details($_GET['id'] ?? 0);
        break;

    // admin
    case "admin":
        $adminDashboard = new AdminDashboardController();
        $adminDashboard->index();
    break;

        //accounts
        case "admin_accounts":
        (new AdminAccountController())->index();
        break;

        case "admin_create_account":
            (new AdminAccountController())->create();
        break;

        case "admin_add_account":
            (new AdminAccountController())->store();
        break;

        case "admin_search_account":
            (new AdminAccountController())->search();
        break;

        case "admin_product_detail":
            (new AdminProductController())->view();
        break;

        case "admin_edit_account":
            (new AdminAccountController())->edit();
        break;

        case "admin_update_account":
            (new AdminAccountController())->update();
        break;

        case "admin_delete_account":
            (new AdminAccountController())->delete();
        break;

        //products
        case "admin_products":
            $adminProduct = new AdminProductController();
            $adminProduct->index();
        break;

        case "admin_create_product":
            $adminProduct = new AdminProductController();
            $adminProduct->create();
        break;

        case "admin_add_product":
            $adminProduct = new AdminProductController();
            $adminProduct->store();
        break;

        case "admin_edit_product":
            $adminProduct = new AdminProductController();
            $adminProduct->edit();
        break;

        case "admin_update_product":
            $adminProduct = new AdminProductController();
            $adminProduct->update();
        break;

        case "admin_delete_product":
            $adminProduct = new AdminProductController();
            $adminProduct->delete();
        break;

        case "admin_search_product":
            $adminProduct = new AdminProductController();
            $adminProduct->search();
        break;

        //categories
        case "admin_categories":
            $adminCategory = new AdminCategoryController();
            $adminCategory->index();
        break;

        case "admin_create_category":
            $adminCategory = new AdminCategoryController();
            $adminCategory->create();
        break;

        case "admin_add_category":
            $adminCategory = new AdminCategoryController();
            $adminCategory->store();
        break;

        case "admin_edit_category":
            $adminCategory = new AdminCategoryController();
            $adminCategory->edit();
        break;

        case "admin_update_category":
            $adminCategory = new AdminCategoryController();
            $adminCategory->update();
        break;

        case "admin_delete_category":
            $adminCategory = new AdminCategoryController();
            $adminCategory->delete();
        break;

        // orders
        case "admin_orders":
            $adminOrder = new AdminOrderController();
            $adminOrder->index();
        break;

        case "admin_order_detail":
            $adminOrder = new AdminOrderController();
            $adminOrder->detail();
        break;

        case "admin_search_order":
            $adminOrder = new AdminOrderController();
            $adminOrder->search();
        break;

        case "admin_update_order":
            $adminOrder = new AdminOrderController();
            $adminOrder->update();
        break;

        case "admin_delete_order":
            $adminOrder = new AdminOrderController();
            $adminOrder->delete();
        break;

    default:
        echo "404 Not Found";
    break;

}