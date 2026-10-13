<?php
/**
 * Footer Template - Sri Balaji Books
 *
 * @package SriBalajiTheme
 */
?>

<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-grid">
            
            <!-- Column 1: Brand & About -->
            <div class="footer-col brand-col">
                <div class="footer-brand">
                    <span class="footer-logo-icon">📚</span>
                    <span class="footer-brand-name"><?php bloginfo( 'name' ); ?></span>
                </div>
                <p class="footer-desc">
                    Your premier neighborhood bookstore and stationery emporium. Supplying quality school essentials, office supplies, art materials, and novelty goods.
                </p>
                <div class="store-badge-pill">
                    📍 Rama Talkies Road, Dwaraka Nagar, Visakhapatnam &bull; Since 2026
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="footer-col">
                <h4>Quick Navigation</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                        <li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Full Catalog</a></li>
                        <li><a href="<?php echo esc_url( get_template_directory_uri() . '/faq.html' ); ?>">FAQs &amp; Help Desk</a></li>
                        <li><a href="<?php echo esc_url( get_template_directory_uri() . '/bulk-orders.html' ); ?>">Bulk &amp; School Orders</a></li>
                        <li><a href="<?php echo esc_url( wc_get_cart_url() ); ?>">Shopping Cart</a></li>
                        <li><a href="<?php echo esc_url( wc_get_checkout_url() ); ?>">Checkout</a></li>
                        <li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">My Account &amp; Orders</a></li>
                    <?php else : ?>
                        <li><a href="<?php echo esc_url( get_template_directory_uri() . '/faq.html' ); ?>">FAQs &amp; Help Desk</a></li>
                        <li><a href="<?php echo esc_url( get_template_directory_uri() . '/bulk-orders.html' ); ?>">Bulk &amp; School Orders</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Column 3: Popular Categories -->
            <div class="footer-col">
                <h4>Popular Categories</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url( sribalaji_get_category_url( array( 'notebooks-exam-pads', 'paper-registers', 'school-essentials', 'books-notebooks' ), 'Notebooks & Exam Pads' ) ); ?>">Notebooks &amp; Registers</a></li>
                    <li><a href="<?php echo esc_url( sribalaji_get_category_url( array( 'pens-refills', 'school-essentials', 'pens-pencils' ), 'Pens & Refills' ) ); ?>">Pens, Pencils &amp; Writing</a></li>
                    <li><a href="<?php echo esc_url( sribalaji_get_category_url( array( 'art-craft', 'art-supplies', 'paints-canvases' ), 'Art & Craft' ) ); ?>">Art &amp; Craft Supplies</a></li>
                    <li><a href="<?php echo esc_url( sribalaji_get_category_url( array( 'office-supplies', 'paper-registers' ), 'Office Supplies' ) ); ?>">Office Stationery &amp; Files</a></li>
                    <li><a href="<?php echo esc_url( sribalaji_get_category_url( array( 'bags-totes', 'novelty-gifts', 'jute-bags' ), 'Bags & Totes' ) ); ?>">Eco Jute Bags &amp; Gifts</a></li>
                </ul>
            </div>

            <!-- Column 4: Customer Care & Store Info -->
            <div class="footer-col">
                <h4>Customer Care &amp; Hours</h4>
                <ul class="footer-info-list">
                    <li>
                        <strong>🕒 Store Hours:</strong><br>
                        Mon – Sat: 11:00 AM – 8:00 PM<br>
                        Sunday: Closed (Holiday)
                    </li>
                    <li>
                        <strong>📍 Store Location:</strong><br>
                        D.No. 48-14-61/4, Rama Talkies Road, Sri Nagar, Dwaraka Nagar, Visakhapatnam - 530016
                    </li>
                    <li>
                        <strong>💳 Payment &amp; Delivery:</strong><br>
                        Cash on Delivery (COD) &bull; UPI &bull; Local Visakhapatnam Delivery &bull; Store Pickup
                    </li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date( 'Y' ); ?> <strong><?php bloginfo( 'name' ); ?></strong>. All rights reserved.</p>
            <p class="footer-tagline">
                Read &bull; Create &bull; Learn &bull; Excel
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
