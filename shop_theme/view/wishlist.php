<!DOCTYPE html>
<html lang="en-US" itemscope="itemscope" itemtype="http://schema.org/WebPage">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <title>SHOP - Wishlist</title>
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
    <body class="page-template-default page woocommerce-wishlist can-uppercase">
        <div id="page" class="hfeed site">
            <?php include_once('header.php')?>
            <!-- .header-v1 -->
            <!-- ============================================================= Header End ============================================================= -->
            <div id="content" class="site-content">
                <div class="col-full">
                    <div class="row">
                        <nav class="woocommerce-breadcrumb">
                            <a href="index.php">Home</a>
                            <span class="delimiter">
                                <i class="tm tm-breadcrumbs-arrow-right"></i>
                            </span>
                            Wishlist
                        </nav>
                        <!-- .woocommerce-breadcrumb -->
                        <div id="primary" class="content-area">
                            <main id="main" class="site-main">
                                <div class="type-page hentry">
                                    <header class="entry-header">
                                        <div class="page-header-caption">
                                            <h1 class="entry-title">Wishlist</h1>
                                        </div>
                                    </header>
                                    <!-- .entry-header -->
                                    <div class="entry-content">
                                        <form class="woocommerce" method="post" action="#">
                                            <table class="shop_table cart wishlist_table">
                                                <thead>
                                                    <tr>
                                                        <th class="product-remove"></th>
                                                        <th class="product-thumbnail"></th>
                                                        <th class="product-name">
                                                            <span class="nobr">Product Name</span>
                                                        </th>
                                                        <th class="product-price">
                                                            <span class="nobr">
                                                                Unit Price
                                                            </span>
                                                        </th>
                                                        <th class="product-stock-status">
                                                            <span class="nobr">
                                                                Stock Status
                                                            </span>
                                                        </th>
                                                        <th class="product-add-to-cart"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="product-remove">
                                                            <div>
                                                                <a title="Remove this product" class="remove remove_from_wishlist" href="#">×</a>
                                                            </div>
                                                        </td>
                                                        <td class="product-thumbnail">
                                                            <a href="single_product_fullwidth.php">
                                                                <img width="180" height="180" alt="" class="wp-post-image" src="assets/images/products/cart-1.jpg">
                                                            </a>
                                                        </td>
                                                        <td class="product-name">
                                                            <a href="single_product_fullwidth.php">4K Action Cam with  Wi-Fi &amp; GPS</a>
                                                        </td>
                                                        <td class="product-price">
                                                            <ins>
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <span class="woocommerce-Price-currencySymbol">£</span>199.95</span>
                                                            </ins>
                                                            <del>
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <span class="woocommerce-Price-currencySymbol">£</span>229.99</span>
                                                            </del>
                                                        </td>
                                                        <td class="product-stock-status">
                                                            <span class="wishlist-in-stock">In Stock</span>
                                                        </td>
                                                        <td class="product-add-to-cart">
                                                            <a class="button add_to_cart_button button alt" href="cart.php"> Add to Cart</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="product-remove">
                                                            <div>
                                                                <a title="Remove this product" class="remove remove_from_wishlist" href="#">×</a>
                                                            </div>
                                                        </td>
                                                        <td class="product-thumbnail">
                                                            <a href="single_product_fullwidth.php">
                                                                <img width="180" height="180" alt="" class="wp-post-image" src="assets/images/products/cart-2.jpg">
                                                            </a>
                                                        </td>
                                                        <td class="product-name">
                                                            <a href="single_product_fullwidth.php">55EG9600 - 55-Inch 2160p Smart Curved Ultra HD 3D</a>
                                                        </td>
                                                        <td class="product-price">
                                                            <ins>
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <span class="woocommerce-Price-currencySymbol">£</span>199.95</span>
                                                            </ins>
                                                            <del>
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <span class="woocommerce-Price-currencySymbol">£</span>229.99</span>
                                                            </del>
                                                        </td>
                                                        <td class="product-stock-status">
                                                            <span class="wishlist-in-stock">In Stock</span>
                                                        </td>
                                                        <td class="product-add-to-cart">
                                                            <a class="button add_to_cart_button button alt" href="cart.php"> Add to Cart</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="product-remove">
                                                            <div>
                                                                <a title="Remove this product" class="remove remove_from_wishlist" href="#">×</a>
                                                            </div>
                                                        </td>
                                                        <td class="product-thumbnail">
                                                            <a href="single_product_fullwidth.php">
                                                                <img width="180" height="180" alt="" class="wp-post-image" src="assets/images/products/cart-3.jpg">
                                                            </a>
                                                        </td>
                                                        <td class="product-name">
                                                            <a href="single_product_fullwidth.php">360° Viewing Immersive VR Headset</a>
                                                        </td>
                                                        <td class="product-price">
                                                            <ins>
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <span class="woocommerce-Price-currencySymbol">£</span>199.95</span>
                                                            </ins>
                                                            <del>
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <span class="woocommerce-Price-currencySymbol">£</span>229.99</span>
                                                            </del>
                                                        </td>
                                                        <td class="product-stock-status">
                                                            <span class="wishlist-in-stock">In Stock</span>
                                                        </td>
                                                        <td class="product-add-to-cart">
                                                            <a class="button add_to_cart_button button alt" href="cart.php"> Add to Cart</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="6">
                                                            <div class="yith-wcwl-share">
                                                                <h4 class="yith-wcwl-share-title">Share on:</h4>
                                                                <ul>
                                                                    <li style="list-style-type: none; display: inline-block;">
                                                                        <a title="Facebook" href="https://www.facebook.com/sharer.php?s=100&amp;p%5Btitle%5D=My+wishlist+on+Tech+Market&amp;p%5Burl%5D=http%3A%2F%2Flocalhost%2F%7Efarook%2Ftechmarket%2Fhome-v1.html%2Fwishlist%2Fview%2FD5ON1PW1PYO1%2F" class="facebook" target="_blank"></a>
                                                                    </li>
                                                                    <li style="list-style-type: none; display: inline-block;">
                                                                        <a title="Twitter" href="https://twitter.com/share?url=http%3A%2F%2Flocalhost%2F%7Efarook%2Ftechmarket%2Fhome-v1.html%2Fwishlist%2Fview%2FD5ON1PW1PYO1%2F&amp;text=" class="twitter" target="_blank"></a>
                                                                    </li>
                                                                    <li style="list-style-type: none; display: inline-block;">
                                                                        <a onclick="window.open(this.href); return false;" title="Pinterest" href="http://pinterest.com/pin/create/button/?url=http%3A%2F%2Flocalhost%2F%7Efarook%2Ftechmarket%2Fhome-v1.html%2Fwishlist%2Fview%2FD5ON1PW1PYO1%2F&amp;description=&amp;media=" class="pinterest" target="_blank"></a>
                                                                    </li>
                                                                    <li style="list-style-type: none; display: inline-block;">
                                                                        <a onclick="javascript:window.open(this.href, &quot;&quot;, &quot;menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600&quot;);return false;" title="Google+" href="https://plus.google.com/share?url=http%3A%2F%2Flocalhost%2F%7Efarook%2Ftechmarket%2Fhome-v1.html%2Fwishlist%2Fview%2FD5ON1PW1PYO1%2F&amp;title=My+wishlist+on+Tech+Market" class="googleplus" target="_blank"></a>
                                                                    </li>
                                                                    <li style="list-style-type: none; display: inline-block;">
                                                                        <a title="Email" href="mailto:?subject=I+wanted+you+to+see+this+site&amp;body=http%3A%2F%2Flocalhost%2F%7Efarook%2Ftechmarket%2Fhome-v1.html%2Fwishlist%2Fview%2FD5ON1PW1PYO1%2F&amp;title=My+wishlist+on+Tech+Market" class="email"></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <!-- .wishlist_table -->
                                        </form>
                                        <!-- .woocommerce -->
                                    </div>
                                    <!-- .entry-content -->
                                </div>
                                <!-- .hentry -->
                            </main>
                            <!-- #main -->
                        </div>
                        <!-- #primary -->
                    </div>
                    <!-- .row -->
                </div>
                <!-- .col-full -->
            </div>
            <!-- #content -->
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