<!DOCTYPE html>
<html lang="en-US" itemscope="itemscope" itemtype="http://schema.org/WebPage">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <title>SHOP - Products List</title>
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" media="all" />
        <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css" media="all" />
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-grid.min.css" media="all" />
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-reboot.min.css" media="all" />
        <link rel="stylesheet" type="text/css" href="assets/css/font-techmarket.css" media="all" />
        <link rel="stylesheet" type="text/css" href="assets/css/slick.css" media="all" />
        <link rel="stylesheet" type="text/css" href="assets/css/techmarket-font-awesome.css" media="all" />
        <link rel="stylesheet" type="text/css" href="assets/css/slick-style.css" media="all" />
        <link rel="stylesheet" type="text/css" href="assets/css/animate.min.css" media="all" />
        <link rel="stylesheet" type="text/css" href="assets/css/style.css" media="all" />
        <link rel="stylesheet" type="text/css" href="assets/css/colors/blue.css" media="all" />

        <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,900" rel="stylesheet">
        <link rel="shortcut icon" href="assets/images/fav-icon.png">
    </head>
    <body class="woocommerce-active left-sidebar">
        <div id="page" class="hfeed site">
            <?php include_once('header.php')?>
            <!-- ============================================================= Header End ============================================================= -->
            <div id="content" class="site-content" tabindex="-1">
                <div class="col-full">
                    <div class="row">
                        <nav class="woocommerce-breadcrumb">
                            <a href="index.php">Home</a>
                            <span class="delimiter">
                                <i class="tm tm-breadcrumbs-arrow-right"></i>
                            </span>Shop
                        </nav>
                        <!-- .woocommerce-breadcrumb -->
                        <div id="primary" class="content-area">
                            <main id="main" class="site-main">
                                
                                
                                <div class="shop-control-bar">
                                    <div class="handheld-sidebar-toggle">
                                        <button type="button" class="btn sidebar-toggler">
                                            <i class="fa fa-sliders"></i>
                                            <span>Filters</span>
                                        </button>
                                    </div>
                                    <!-- .handheld-sidebar-toggle -->
                                    <h1 class="woocommerce-products-header__title page-title">Shop</h1>
                                    <ul role="tablist" class="shop-view-switcher nav nav-tabs">
                                        <li class="nav-item">
                                            <a href="#grid" title="Grid View" data-toggle="tab" class="nav-link active">
                                                <i class="tm tm-grid-small"></i>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#grid-extended" title="Grid Extended View" data-toggle="tab" class="nav-link ">
                                                <i class="tm tm-grid"></i>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#list-view-large" title="List View Large" data-toggle="tab" class="nav-link ">
                                                <i class="tm tm-listing-large"></i>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#list-view" title="List View" data-toggle="tab" class="nav-link ">
                                                <i class="tm tm-listing"></i>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#list-view-small" title="List View Small" data-toggle="tab" class="nav-link ">
                                                <i class="tm tm-listing-small"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- .shop-view-switcher -->
                                    <form class="form-techmarket-wc-ppp" method="POST">
                                        <select class="techmarket-wc-wppp-select c-select" onchange="this.form.submit()" name="ppp">
                                            <option value="20">Show 20</option>
                                            <option value="40">Show 40</option>
                                            <option value="-1">Show All</option>
                                        </select>
                                        <input type="hidden" value="5" name="shop_columns">
                                        <input type="hidden" value="15" name="shop_per_page">
                                        <input type="hidden" value="right-sidebar" name="shop_layout">
                                    </form>
                                    <!-- .form-techmarket-wc-ppp -->
                                    <form method="get" class="woocommerce-ordering">
                                        <select class="orderby" name="orderby">
                                            <option value="popularity">Sort by popularity</option>
                                            <option value="rating">Sort by average rating</option>
                                            <option selected="selected" value="date">Sort by newness</option>
                                            <option value="price">Sort by price: low to high</option>
                                            <option value="price-desc">Sort by price: high to low</option>
                                        </select>
                                        <input type="hidden" value="5" name="shop_columns">
                                        <input type="hidden" value="15" name="shop_per_page">
                                        <input type="hidden" value="right-sidebar" name="shop_layout">
                                    </form>
                                    <!-- .woocommerce-ordering -->
                                    <nav class="techmarket-advanced-pagination">
                                        <form class="form-adv-pagination" method="post">
                                            <input type="number" value="1" class="form-control" step="1" max="5" min="1" size="2" id="goto-page">
                                        </form> of 5<a href="#" class="next page-numbers">?</a>
                                    </nav>
                                    <!-- .techmarket-advanced-pagination -->
                                </div>
                                <!-- .shop-control-bar -->
                                
                                <div class="tab-content">
                                    <div id="grid" class="tab-pane active" role="tabpanel">
                                        <div class="woocommerce columns-5">
                                            <div class="products">
                                                <div class="product first">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/1.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Bbd 23-Inch Screen LED-Lit Monitorss Buds</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>                                                       
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/2.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Bluetooth on-ear PureBass Headphones</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/3.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Smart Watches 3 SWR50</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/4.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Xtreme ultimate splashproof portable speaker</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product last">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/5.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">On-ear Wireless NXTG</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product first">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/6.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">On-ear Wireless NXTG</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/7.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Xtreme ultimate splashproof portable speaker</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/8.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Gear Virtual Reality 3D with Bluetooth Glasses</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/9.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Watch Stainless with Grey Suture Leather Strap</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product last">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/10.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">ZenBook 3 Ultrabook 8GB 512SSD W10</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product first">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/11.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Watch Stainless with Grey Suture Leather Strap</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/12.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">XONE Wireless Controller</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/13.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">ZenBook 3 Ultrabook 8GB 512SSD W10</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/14.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Bluetooth on-ear PureBass Headphones</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product last">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/15.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Xtreme ultimate splashproof portable speaker</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product first">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/16.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">4K Action Cam with Wi-Fi & GPS</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/17.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Gear Virtual Reality 3D with Bluetooth Glasses</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/5.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Bbd 23-Inch Screen LED-Lit Monitorss Buds</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/12.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">4K Action Cam with Wi-Fi & GPS</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product last">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/1.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">XONE Wireless Controller</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="hover-area">
                                                        <a class="button" href="cart.php">Add to cart</a>
                                                        
                                                    </div>
                                                    <!-- .hover-area -->
                                                </div>
                                                <!-- .product -->
                                            </div>
                                            <!-- .products -->
                                        </div>
                                        <!-- .woocommerce -->
                                    </div>
                                    <!-- .tab-pane -->
                                    <div id="grid-extended" class="tab-pane" role="tabpanel">
                                        <div class="woocommerce columns-5">
                                            <div class="products">
                                                <div class="product first">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/1.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Xtreme ultimate splashproof portable speaker</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/2.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">4K Action Cam with Wi-Fi & GPS</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/3.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">On-ear Wireless NXTG</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/4.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Xtreme ultimate splashproof portable speaker</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product last">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/5.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Smart Watches 3 SWR50</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product first">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/6.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Xtreme ultimate splashproof portable speaker</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/7.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Video & Air Quality Monitor</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/8.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Video & Air Quality Monitor</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/9.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Bbd 23-Inch Screen LED-Lit Monitorss Buds</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product last">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/10.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Gear Virtual Reality 3D with Bluetooth Glasses</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product first">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/11.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Xtreme ultimate splashproof portable speaker</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/12.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Bluetooth on-ear PureBass Headphones</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/13.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">XONE Wireless Controller</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/14.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Gear Virtual Reality 3D with Bluetooth Glasses</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product last">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/15.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Watch Stainless with Grey Suture Leather Strap</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product first">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/16.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Watch Stainless with Grey Suture Leather Strap</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/17.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Bbd 23-Inch Screen LED-Lit Monitorss Buds</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/5.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">On-ear Wireless NXTG</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product ">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/12.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">4K Action Cam with Wi-Fi & GPS</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                                <div class="product last">
                                                    <div class="yith-wcwl-add-to-wishlist">
                                                        <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                    </div>
                                                    <!-- .yith-wcwl-add-to-wishlist -->
                                                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/1.jpg">
                                                        <span class="price">
                                                            <span class="woocommerce-Price-amount amount">
                                                                <span class="woocommerce-Price-currencySymbol">$</span>800.00</span>
                                                        </span>
                                                        <h2 class="woocommerce-loop-product__title">Bluetooth on-ear PureBass Headphones</h2>
                                                    </a>
                                                    <!-- .woocommerce-LoopProduct-link -->
                                                    <div class="techmarket-product-rating">
                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                            <span style="width:100%">
                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                        </div>
                                                        <span class="review-count">(1)</span>
                                                    </div>
                                                    <!-- .techmarket-product-rating -->
                                                    <span class="sku_wrapper">SKU:
                                                        <span class="sku">5487FB8/13</span>
                                                    </span>
                                                    <div class="woocommerce-product-details__short-description">
                                                        <ul>
                                                            <li>Multimedia Speakers</li>
                                                            <li>120 watts peak</li>
                                                            <li>Front-facing subwoofer</li>
                                                            <li>Refresh Rate: 120Hz (Effective)</li>
                                                            <li>Backlight: LED</li>
                                                            <li>Smart Functionality: Yes, webOS 3.0</li>
                                                            <li>Dimensions (W x H x D): TV without stand: 43.5? x 25.4? x 3.0?, TV with stand: 43.5? x 27.6? x 8.5?</li>
                                                            <li>Inputs: 3 HMDI, 2 USB, 1 RF, 1 Component, 1 Composite, 1 Optical, 1 RS232C, 1 Ethernet</li>
                                                        </ul>
                                                    </div>
                                                    <!-- .woocommerce-product-details__short-description -->
                                                    <a class="button product_type_simple add_to_cart_button" href="cart.php">Add to cart</a>
                                                    
                                                </div>
                                                <!-- .product -->
                                            </div>
                                            <!-- .products -->
                                        </div>
                                        <!-- .woocommerce -->
                                    </div>
                                    <!-- .tab-pane -->
                                    <div id="list-view-large" class="tab-pane" role="tabpanel">
                                        <div class="woocommerce columns-1">
                                            <div class="products">
                                                <div class="product list-view-large first ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/1.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="brand">
                                                                    <a href="#">
                                                                        <img alt="galaxy" src="assets/images/brands/5.png">
                                                                    </a>
                                                                </div>
                                                                <!-- .brand -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                                <span class="sku_wrapper">SKU:
                                                                    <span class="sku">5487FB8/13</span>
                                                                </span>
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <div class="availability">
                                                                    Availability:
                                                                    <p class="stock in-stock">1000 in stock</p>
                                                                </div>
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-large ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/2.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="brand">
                                                                    <a href="#">
                                                                        <img alt="galaxy" src="assets/images/brands/5.png">
                                                                    </a>
                                                                </div>
                                                                <!-- .brand -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                                <span class="sku_wrapper">SKU:
                                                                    <span class="sku">5487FB8/13</span>
                                                                </span>
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <div class="availability">
                                                                    Availability:
                                                                    <p class="stock in-stock">1000 in stock</p>
                                                                </div>
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-large ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/3.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="brand">
                                                                    <a href="#">
                                                                        <img alt="galaxy" src="assets/images/brands/5.png">
                                                                    </a>
                                                                </div>
                                                                <!-- .brand -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                                <span class="sku_wrapper">SKU:
                                                                    <span class="sku">5487FB8/13</span>
                                                                </span>
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <div class="availability">
                                                                    Availability:
                                                                    <p class="stock in-stock">1000 in stock</p>
                                                                </div>
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-large ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/4.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="brand">
                                                                    <a href="#">
                                                                        <img alt="galaxy" src="assets/images/brands/5.png">
                                                                    </a>
                                                                </div>
                                                                <!-- .brand -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                                <span class="sku_wrapper">SKU:
                                                                    <span class="sku">5487FB8/13</span>
                                                                </span>
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <div class="availability">
                                                                    Availability:
                                                                    <p class="stock in-stock">1000 in stock</p>
                                                                </div>
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-large last">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/5.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="brand">
                                                                    <a href="#">
                                                                        <img alt="galaxy" src="assets/images/brands/5.png">
                                                                    </a>
                                                                </div>
                                                                <!-- .brand -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                                <span class="sku_wrapper">SKU:
                                                                    <span class="sku">5487FB8/13</span>
                                                                </span>
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <div class="availability">
                                                                    Availability:
                                                                    <p class="stock in-stock">1000 in stock</p>
                                                                </div>
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-large first ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/6.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="brand">
                                                                    <a href="#">
                                                                        <img alt="galaxy" src="assets/images/brands/5.png">
                                                                    </a>
                                                                </div>
                                                                <!-- .brand -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                                <span class="sku_wrapper">SKU:
                                                                    <span class="sku">5487FB8/13</span>
                                                                </span>
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <div class="availability">
                                                                    Availability:
                                                                    <p class="stock in-stock">1000 in stock</p>
                                                                </div>
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                            </div>
                                            <!-- .products -->
                                        </div>
                                        <!-- .woocommerce -->
                                    </div>
                                    <!-- .tab-pane -->
                                    <div id="list-view" class="tab-pane" role="tabpanel">
                                        <div class="woocommerce columns-1">
                                            <div class="products">
                                                <div class="product list-view ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/1.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="brand">
                                                                    <a href="#">
                                                                        <img alt="galaxy" src="assets/images/brands/5.png">
                                                                    </a>
                                                                </div>
                                                                <!-- .brand -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <div class="availability">
                                                                    Availability:
                                                                    <p class="stock in-stock">1000 in stock</p>
                                                                </div>
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/2.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="brand">
                                                                    <a href="#">
                                                                        <img alt="galaxy" src="assets/images/brands/5.png">
                                                                    </a>
                                                                </div>
                                                                <!-- .brand -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <div class="availability">
                                                                    Availability:
                                                                    <p class="stock in-stock">1000 in stock</p>
                                                                </div>
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/3.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="brand">
                                                                    <a href="#">
                                                                        <img alt="galaxy" src="assets/images/brands/5.png">
                                                                    </a>
                                                                </div>
                                                                <!-- .brand -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <div class="availability">
                                                                    Availability:
                                                                    <p class="stock in-stock">1000 in stock</p>
                                                                </div>
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view last">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/4.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="brand">
                                                                    <a href="#">
                                                                        <img alt="galaxy" src="assets/images/brands/5.png">
                                                                    </a>
                                                                </div>
                                                                <!-- .brand -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <div class="availability">
                                                                    Availability:
                                                                    <p class="stock in-stock">1000 in stock</p>
                                                                </div>
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view first ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/5.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="brand">
                                                                    <a href="#">
                                                                        <img alt="galaxy" src="assets/images/brands/5.png">
                                                                    </a>
                                                                </div>
                                                                <!-- .brand -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <div class="availability">
                                                                    Availability:
                                                                    <p class="stock in-stock">1000 in stock</p>
                                                                </div>
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/6.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="brand">
                                                                    <a href="#">
                                                                        <img alt="galaxy" src="assets/images/brands/5.png">
                                                                    </a>
                                                                </div>
                                                                <!-- .brand -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <div class="availability">
                                                                    Availability:
                                                                    <p class="stock in-stock">1000 in stock</p>
                                                                </div>
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                            </div>
                                            <!-- .products -->
                                        </div>
                                        <!-- .woocommerce -->
                                    </div>
                                    <!-- .tab-pane -->
                                    <div id="list-view-small" class="tab-pane" role="tabpanel">
                                        <div class="woocommerce columns-1">
                                            <div class="products">
                                                <div class="product list-view-small ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/1.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-small ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/2.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-small last">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/3.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-small first ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/4.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-small ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/5.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-small ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/6.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-small ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/7.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-small last">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/8.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                                <div class="product list-view-small first ">
                                                    <div class="media">
                                                        <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="assets/images/products/9.jpg">
                                                        <div class="media-body">
                                                            <div class="product-info">
                                                                <div class="yith-wcwl-add-to-wishlist">
                                                                    <a href="wishlist.php" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                                                </div>
                                                                <!-- .yith-wcwl-add-to-wishlist -->
                                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single_product_fullwidth.php">
                                                                    <h2 class="woocommerce-loop-product__title">60UH6150 60-Inch 4K Ultra HD Smart LED TV</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 5.00 out of 5" class="star-rating">
                                                                            <span style="width:100%">
                                                                                <strong class="rating">5.00</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(1)</span>
                                                                    </div>
                                                                </a>
                                                                <!-- .woocommerce-LoopProduct-link -->
                                                                <div class="woocommerce-product-details__short-description">
                                                                    <ul>
                                                                        <li>CUJO smart firewall brings business-level Internet security to protect all of your home devices</li>
                                                                        <li>Internet Security: Guard your network and smart devices against hacks, malware, and cyber threats</li>
                                                                        <li>Mobile App: Monitor your wired and wireless network activity with a sleek iPhone or Android app</li>
                                                                        <li>CUJO connects to your wireless router with an ethernet cable. CUJO is not compatible with Luma and does not support Google Wifi Mesh. CUJO works with Eero in Bridge mode.</li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .woocommerce-product-details__short-description -->
                                                            </div>
                                                            <!-- .product-info -->
                                                            <div class="product-actions">
                                                                <span class="price">
                                                                    <span class="woocommerce-Price-amount amount">
                                                                        <span class="woocommerce-Price-currencySymbol">$</span>730.00</span>
                                                                </span>
                                                                <!-- .price -->
                                                                <a class="button add_to_cart_button" href="cart.php">Add to Cart</a>
                                                                
                                                            </div>
                                                            <!-- .product-actions -->
                                                        </div>
                                                        <!-- .media-body -->
                                                    </div>
                                                    <!-- .media -->
                                                </div>
                                                <!-- .product -->
                                            </div>
                                            <!-- .products -->
                                        </div>
                                        <!-- .woocommerce -->
                                    </div>
                                    <!-- .tab-pane -->
                                </div>
                                <!-- .tab-content -->
                                
                                <div class="shop-control-bar-bottom">
                                    <form class="form-techmarket-wc-ppp" method="POST">
                                        <select class="techmarket-wc-wppp-select c-select" onchange="this.form.submit()" name="ppp">
                                            <option value="20">Show 20</option>
                                            <option value="40">Show 40</option>
                                            <option value="-1">Show All</option>
                                        </select>
                                        <input type="hidden" value="5" name="shop_columns">
                                        <input type="hidden" value="15" name="shop_per_page">
                                        <input type="hidden" value="right-sidebar" name="shop_layout">
                                    </form>
                                    <!-- .form-techmarket-wc-ppp -->
                                    <p class="woocommerce-result-count">
                                        Showing 1&ndash;15 of 73 results
                                    </p>
                                    <!-- .woocommerce-result-count -->
                                    <nav class="woocommerce-pagination">
                                        <ul class="page-numbers">
                                            <li>
                                                <span class="page-numbers current">1</span>
                                            </li>
                                            <li><a href="#" class="page-numbers">2</a></li>
                                            <li><a href="#" class="page-numbers">3</a></li>
                                            <li><a href="#" class="page-numbers">4</a></li>
                                            <li><a href="#" class="page-numbers">5</a></li>
                                            <li><a href="#" class="next page-numbers">?</a></li>
                                        </ul>
                                        <!-- .page-numbers -->
                                    </nav>
                                    <!-- .woocommerce-pagination -->
                                </div>
                                <!-- .shop-control-bar-bottom -->
                                
                                
                            </main>
                            <!-- #main -->
                            <div class="shop-archive-header">
                                    <div class="jumbotron">
                                        <div class="jumbotron-img">
                                            <img width="416" height="283" alt="" src="assets/images/products/jumbo.jpg" class="jumbo-image alignright">
                                        </div>
                                        <div class="jumbotron-caption">
                                            <h3 class="jumbo-title">Virtual Reality Headsets</h3>
                                            <p class="jumbo-subtitle">Nullam dignissim elit ut urna rutrum, a fermentum mi auctor. Mauris efficitur magna orci, et dignissim lacus scelerisque sit amet. Proin malesuada tincidunt nisl ac commodo. Vivamus eleifend porttitor ex sit amet suscipit. Vestibulum at ullamcorper lacus, vel facilisis arcu. Aliquam erat volutpat.
                                                <br>
                                                <br>Maecenas in sodales nisl. Pellentesque ac nibh mi. Ut lobortis odio nulla, congue rhoncus risus facilisis eget. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                                                <a href="#">read more <i class="tm tm-long-arrow-right"></i></a>
                                            </p>
                                        </div>
                                        <!-- .jumbotron-caption -->
                                    </div>
                                    <!-- .jumbotron -->
                                </div>
                                <!-- .shop-archive-header -->
                        </div>
                        <!-- #primary -->
                        <div id="secondary" class="widget-area shop-sidebar" role="complementary">
                            <div class="widget woocommerce widget_product_categories techmarket_widget_product_categories" id="techmarket_product_categories_widget-2">
                                <ul class="product-categories ">
                                    <li class="product_cat">
                                        <span>Browse Categories</span>
                                        <ul>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="no-child"></span>Televisions</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="no-child"></span>Home Theater &amp; Audio</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="child-indicator">
                                                        <i class="fa fa-angle-right"></i>
                                                    </span>Headphones</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="child-indicator">
                                                        <i class="fa fa-angle-right"></i>
                                                    </span>Digital Cameras</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="child-indicator">
                                                        <i class="fa fa-angle-right"></i>
                                                    </span>Cells &amp; Tablets</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="no-child"></span>Smartwatches</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="child-indicator">
                                                        <i class="fa fa-angle-right"></i>
                                                    </span>Games &amp; Consoles</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="no-child"></span>Printer</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="no-child"></span>TV &amp; Video</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="child-indicator">
                                                        <i class="fa fa-angle-right"></i>
                                                    </span>Home Entertainment</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="child-indicator">
                                                        <i class="fa fa-angle-right"></i>
                                                    </span>Computers &amp; Laptops</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="no-child"></span>Notebooks</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="child-indicator">
                                                        <i class="fa fa-angle-right"></i>
                                                    </span>Desktop PCs</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="no-child"></span>Mac Computers</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="child-indicator">
                                                        <i class="fa fa-angle-right"></i>
                                                    </span>All in One PC</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="child-indicator">
                                                        <i class="fa fa-angle-right"></i>
                                                    </span>Audio &amp; Music</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="no-child"></span>PC Components</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="child-indicator">
                                                        <i class="fa fa-angle-right"></i>
                                                    </span>Desktop PCs</a>
                                            </li>
                                            <li class="cat-item">
                                                <a href="product-category.html">
                                                    <span class="no-child"></span>Monitors</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div id="techmarket_products_filter-3" class="widget widget_techmarket_products_filter">
                                <span class="gamma widget-title">Filters</span>
                                <div class="widget woocommerce widget_price_filter" id="woocommerce_price_filter-2">
                                    <p>
                                        <span class="gamma widget-title">Filter by price</span>
                                        <div class="price_slider_amount">
                                            <input id="amount" type="text" placeholder="Min price" data-min="6" value="33" name="min_price" style="display: none;">
                                            <button class="button" type="submit">Filter</button>
                                        </div>
                                        <div id="slider-range" class="price_slider"></div>
                                </div>
                                <div class="widget woocommerce widget_layered_nav maxlist-more" id="woocommerce_layered_nav-2">
                                    <span class="gamma widget-title">Brands</span>
                                    <ul>
                                        <li class="wc-layered-nav-term ">
                                            <a href="#">apple</a>
                                            <span class="count">(2)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">bosch</a>
                                            <span class="count">(1)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">cannon</a>
                                            <span class="count">(1)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">connect</a>
                                            <span class="count">(1)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">galaxy</a>
                                            <span class="count">(3)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">gopro</a>
                                            <span class="count">(1)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">kinova</a>
                                            <span class="count">(1)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">samsung</a>
                                            <span class="count">(1)</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- .woocommerce widget_layered_nav -->
                                <div class="widget woocommerce widget_layered_nav maxlist-more" id="woocommerce_layered_nav-3">
                                    <span class="gamma widget-title">Color</span>
                                    <ul>
                                        <li class="wc-layered-nav-term "><a href="#">Black</a>
                                            <span class="count">(4)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">Blue</a>
                                            <span class="count">(4)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">Green</a>
                                            <span class="count">(5)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">Orange</a>
                                            <span class="count">(5)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">Red</a>
                                            <span class="count">(4)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">Yellow</a>
                                            <span class="count">(5)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">Green</a>
                                            <span class="count">(5)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">Orange</a>
                                            <span class="count">(5)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">Red</a>
                                            <span class="count">(4)</span>
                                        </li>
                                        <li class="wc-layered-nav-term "><a href="#">Yellow</a>
                                            <span class="count">(5)</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- .woocommerce widget_layered_nav -->
                            </div>
                            <div class="widget widget_techmarket_products_carousel_widget">
                                <section id="single-sidebar-carousel" class="section-products-carousel">
                                    <header class="section-header">
                                        <h2 class="section-title">Latest Products</h2>
                                        <nav class="custom-slick-nav"></nav>
                                    </header>
                                    <!-- .section-header -->
                                    <div class="products-carousel" data-ride="tm-slick-carousel" data-wrap=".products" data-slick="{&quot;infinite&quot;:false,&quot;slidesToShow&quot;:1,&quot;slidesToScroll&quot;:1,&quot;rows&quot;:2,&quot;slidesPerRow&quot;:1,&quot;dots&quot;:false,&quot;arrows&quot;:true,&quot;prevArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-left\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;nextArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-right\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;appendArrows&quot;:&quot;#single-sidebar-carousel .custom-slick-nav&quot;}">
                                        <div class="container-fluid">
                                            <div class="woocommerce columns-1">
                                                <div class="products">
                                                    <div class="landscape-product-widget product">
                                                        <a class="woocommerce-LoopProduct-link" href="single_product_fullwidth.php">
                                                            <div class="media">
                                                                <img class="wp-post-image" src="assets/images/products/sm-1.jpg" alt="">
                                                                <div class="media-body">
                                                                    <span class="price">
                                                                        <ins>
                                                                            <span class="amount"> 50.99</span>
                                                                        </ins>
                                                                        <del>
                                                                            <span class="amount">26.99</span>
                                                                        </del>
                                                                    </span>
                                                                    <!-- .price -->
                                                                    <h2 class="woocommerce-loop-product__title">S100 Wireless Bluetooth Speaker – Neon Green</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 0 out of 5" class="star-rating">
                                                                            <span style="width:0%">
                                                                                <strong class="rating">0</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(0)</span>
                                                                    </div>
                                                                    <!-- .techmarket-product-rating -->
                                                                </div>
                                                                <!-- .media-body -->
                                                            </div>
                                                            <!-- .media -->
                                                        </a>
                                                        <!-- .woocommerce-LoopProduct-link -->
                                                    </div>
                                                    <div class="landscape-product-widget product">
                                                        <a class="woocommerce-LoopProduct-link" href="single_product_fullwidth.php">
                                                            <div class="media">
                                                                <img class="wp-post-image" src="assets/images/products/sm-2.jpg" alt="">
                                                                <div class="media-body">
                                                                    <span class="price">
                                                                        <ins>
                                                                            <span class="amount"> 50.99</span>
                                                                        </ins>
                                                                        <del>
                                                                            <span class="amount">26.99</span>
                                                                        </del>
                                                                    </span>
                                                                    <!-- .price -->
                                                                    <h2 class="woocommerce-loop-product__title">S100 Wireless Bluetooth Speaker – Neon Green</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 0 out of 5" class="star-rating">
                                                                            <span style="width:0%">
                                                                                <strong class="rating">0</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(0)</span>
                                                                    </div>
                                                                    <!-- .techmarket-product-rating -->
                                                                </div>
                                                                <!-- .media-body -->
                                                            </div>
                                                            <!-- .media -->
                                                        </a>
                                                        <!-- .woocommerce-LoopProduct-link -->
                                                    </div>
                                                    <div class="landscape-product-widget product">
                                                        <a class="woocommerce-LoopProduct-link" href="single_product_fullwidth.php">
                                                            <div class="media">
                                                                <img class="wp-post-image" src="assets/images/products/sm-3.jpg" alt="">
                                                                <div class="media-body">
                                                                    <span class="price">
                                                                        <ins>
                                                                            <span class="amount"> 50.99</span>
                                                                        </ins>
                                                                        <del>
                                                                            <span class="amount">26.99</span>
                                                                        </del>
                                                                    </span>
                                                                    <!-- .price -->
                                                                    <h2 class="woocommerce-loop-product__title">S100 Wireless Bluetooth Speaker – Neon Green</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 0 out of 5" class="star-rating">
                                                                            <span style="width:0%">
                                                                                <strong class="rating">0</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(0)</span>
                                                                    </div>
                                                                    <!-- .techmarket-product-rating -->
                                                                </div>
                                                                <!-- .media-body -->
                                                            </div>
                                                            <!-- .media -->
                                                        </a>
                                                        <!-- .woocommerce-LoopProduct-link -->
                                                    </div>
                                                    <div class="landscape-product-widget product">
                                                        <a class="woocommerce-LoopProduct-link" href="single_product_fullwidth.php">
                                                            <div class="media">
                                                                <img class="wp-post-image" src="assets/images/products/sm-4.jpg" alt="">
                                                                <div class="media-body">
                                                                    <span class="price">
                                                                        <ins>
                                                                            <span class="amount"> 50.99</span>
                                                                        </ins>
                                                                        <del>
                                                                            <span class="amount">26.99</span>
                                                                        </del>
                                                                    </span>
                                                                    <!-- .price -->
                                                                    <h2 class="woocommerce-loop-product__title">S100 Wireless Bluetooth Speaker – Neon Green</h2>
                                                                    <div class="techmarket-product-rating">
                                                                        <div title="Rated 0 out of 5" class="star-rating">
                                                                            <span style="width:0%">
                                                                                <strong class="rating">0</strong> out of 5</span>
                                                                        </div>
                                                                        <span class="review-count">(0)</span>
                                                                    </div>
                                                                    <!-- .techmarket-product-rating -->
                                                                </div>
                                                                <!-- .media-body -->
                                                            </div>
                                                            <!-- .media -->
                                                        </a>
                                                        <!-- .woocommerce-LoopProduct-link -->
                                                    </div>
                                                </div>
                                                <!-- .products -->
                                            </div>
                                            <!-- .woocommerce -->
                                        </div>
                                        <!-- .container-fluid -->
                                    </div>
                                    <!-- .products-carousel -->
                                </section>
                                <!-- .section-products-carousel -->
                            </div>
                            <!-- .widget_techmarket_products_carousel_widget -->
                        </div>
                        <!-- #secondary -->
                    </div>
                    <!-- .row -->
                </div>
                <!-- .col-full -->
            </div>
            <!-- #content -->
            <?php include_once('brands_carousel.php')?>
            <!-- .col-full -->
            <?php include_once('footer.php')?>
            <!-- .site-footer -->
        </div>

        <script type="text/javascript" src="assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/tether.min.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery-migrate.min.js"></script>
        <script type="text/javascript" src="assets/js/hidemaxlistitem.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="assets/js/hidemaxlistitem.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.easing.min.js"></script>
        <script type="text/javascript" src="assets/js/scrollup.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.waypoints.min.js"></script>
        <script type="text/javascript" src="assets/js/waypoints-sticky.min.js"></script>
        <script type="text/javascript" src="assets/js/pace.min.js"></script>
        <script type="text/javascript" src="assets/js/slick.min.js"></script>
        <script type="text/javascript" src="assets/js/scripts.js"></script>

    </body>
</html>
