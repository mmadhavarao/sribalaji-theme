<?php
/**
 * Header Template
 *
 * @package SriBalajiTheme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'wide-lens-mode compact-height-mode watermark-active' ); ?> data-theme="teal-mist">
<?php wp_body_open(); ?>

<?php if ( function_exists( 'sribalaji_is_staging_or_sandbox' ) && sribalaji_is_staging_or_sandbox() ) : ?>
<!-- Dynamic Staging / Testing Environment Alert Marquee Ribbon -->
<div class="staging-alert-marquee-bar" id="stagingAlertBar" role="alert" aria-label="Staging Environment Notice">
    <div class="staging-alert-track">
        <div class="staging-alert-ticker">
            <span class="staging-alert-item">🚧 <strong>STAGING ENVIRONMENT</strong> &bull; FOR INTERNAL TESTING &amp; PREVIEW ONLY &bull; DUMMY TRANSACTIONS &bull; ORDERS WILL NOT BE CHARGED OR FULFILLED &bull; PLEASE REPORT ANY BUGS OR FEEDBACK 🚧</span>
            <span class="staging-alert-item">🚧 <strong>STAGING ENVIRONMENT</strong> &bull; FOR INTERNAL TESTING &amp; PREVIEW ONLY &bull; DUMMY TRANSACTIONS &bull; ORDERS WILL NOT BE CHARGED OR FULFILLED &bull; PLEASE REPORT ANY BUGS OR FEEDBACK 🚧</span>
        </div>
    </div>
    <button type="button" class="staging-alert-close" onclick="document.getElementById('stagingAlertBar').style.display='none';" title="Dismiss Staging Banner" aria-label="Dismiss">&times;</button>
</div>
<?php endif; ?>

<!-- Top Announcement & Free Delivery Bar (Header Feature 1.1) -->
<div class="top-announcement-bar" id="topAnnouncementBar" role="region" aria-label="Store Announcement">
    <div class="top-bar-container">
        
        <!-- Left: Service Area & Phone Support -->
        <div class="top-bar-left">
            <span class="top-bar-location">📍 Visakhapatnam Local Delivery</span>
            <span class="top-bar-divider">|</span>
            <a href="tel:+919985181133" class="top-bar-contact" title="Direct Phone Support">📞 Helpline: +91 99851 81133</a>
        </div>

        <!-- Center: Interactive Announcement Ticker / Switcher with Quick Toggle -->
        <div class="top-bar-center">
            <button type="button" class="announcement-toggle-btn prev" onclick="switchAnnouncement(-1)" aria-label="Previous Announcement">&#10094;</button>
            <div class="announcement-slider-viewport" id="announcementViewport">
                <!-- Slide 1: Primary Value Proposition - Free Delivery & COD -->
                <div class="announcement-slide is-active" data-index="0">
                    <span class="announcement-pill pill-cod">COD ACTIVE</span>
                    <span>🚚 <strong>Free Delivery in Visakhapatnam</strong> on orders over <strong>₹499</strong> <span class="mobile-hide">&bull; Cash on Delivery Available</span></span>
                </div>
                <!-- Slide 2: Express Dispatch for School & Office Essentials -->
                <div class="announcement-slide" data-index="1">
                    <span class="announcement-pill pill-dispatch">EXPRESS DISPATCH</span>
                    <span>⚡ <strong>Same-Day Dispatch</strong> on School Notebooks, Art &amp; Office Supplies!</span>
                </div>
                <!-- Slide 3: School Reopening Kits & Bulk Bundles -->
                <div class="announcement-slide" data-index="2">
                    <span class="announcement-pill pill-offer">BULK BUNDLES</span>
                    <span>🎒 <strong>School Reopening Kits</strong> &amp; Classroom Sets &bull; Special Institutional Discounts</span>
                </div>
            </div>
            <button type="button" class="announcement-toggle-btn next" onclick="switchAnnouncement(1)" aria-label="Next Announcement">&#10095;</button>
        </div>

        <!-- Right: WhatsApp Quick-Order & Dismiss Button -->
        <div class="top-bar-right">
            <a href="https://wa.me/919985181133?text=Hi%20Sri%20Balaji%20Books%2C%20I%20would%20like%20to%20order%20stationery%20and%20books" target="_blank" class="top-bar-wa-btn" rel="noopener noreferrer">
                <span>💬</span> Order on WhatsApp
            </a>
            <button type="button" class="top-bar-dismiss-btn" onclick="dismissAnnouncementBar()" aria-label="Dismiss Announcement Bar" title="Dismiss">&times;</button>
        </div>

    </div>
</div>

<script>
// Top Announcement Bar Slider & Dismissal Engine
(function() {
    var slides = document.querySelectorAll('.announcement-slide');
    if (!slides || !slides.length) return;

    var currentIdx = 0;
    var autoPlayTimer = null;
    var bar = document.getElementById('topAnnouncementBar');

    // Check if dismissed in this browser session
    try {
        if (sessionStorage.getItem('sb_announcement_dismissed') === 'true') {
            if (bar) bar.classList.add('is-dismissed');
            return;
        }
    } catch(e) {}

    function showSlide(index) {
        slides.forEach(function(slide, idx) {
            if (idx === index) {
                slide.classList.add('is-active');
            } else {
                slide.classList.remove('is-active');
            }
        });
        currentIdx = index;
    }

    window.switchAnnouncement = function(dir) {
        var nextIdx = currentIdx + dir;
        if (nextIdx >= slides.length) nextIdx = 0;
        if (nextIdx < 0) nextIdx = slides.length - 1;
        showSlide(nextIdx);
        resetTimer();
    };

    window.dismissAnnouncementBar = function() {
        if (bar) {
            bar.classList.add('is-dismissed');
            try {
                sessionStorage.setItem('sb_announcement_dismissed', 'true');
            } catch(e) {}
        }
    };

    function startTimer() {
        if (autoPlayTimer) clearInterval(autoPlayTimer);
        autoPlayTimer = setInterval(function() {
            var nextIdx = (currentIdx + 1) % slides.length;
            showSlide(nextIdx);
        }, 4500);
    }

    function resetTimer() {
        if (autoPlayTimer) clearInterval(autoPlayTimer);
        startTimer();
    }

    if (bar) {
        bar.addEventListener('mouseenter', function() {
            if (autoPlayTimer) clearInterval(autoPlayTimer);
        });
        bar.addEventListener('mouseleave', function() {
            startTimer();
        });
    }

    startTimer();
})();
</script>

<header class="site-header">
    <div class="header-container">
        <div class="site-branding">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand-title">
                <?php bloginfo( 'name' ); ?>
            </a>
            <div class="brand-tagline">
                <?php bloginfo( 'description' ); ?>
            </div>
        </div>

        <!-- Instant Product Search Bar -->
        <div class="header-search-container">
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <form role="search" method="get" class="header-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search" class="search-field" placeholder="Search notebooks, pens, art supplies..." value="<?php echo get_search_query(); ?>" name="s" required />
                    <input type="hidden" name="post_type" value="product" />
                    <button type="submit" class="search-submit" aria-label="Search">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <nav class="header-nav">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'fallback_cb'    => false,
                ) );
            } else {
                echo '<ul>';
                echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
                if ( class_exists( 'WooCommerce' ) ) {
                    echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">Shop</a></li>';
                    echo '<li><a href="' . esc_url( get_template_directory_uri() . '/faq.html' ) . '">FAQs</a></li>';
                    echo '<li><a href="' . esc_url( get_template_directory_uri() . '/bulk-orders.html' ) . '">Bulk Orders</a></li>';
                    echo '<li><a href="' . esc_url( wc_get_cart_url() ) . '">Cart (' . WC()->cart->get_cart_contents_count() . ')</a></li>';
                    echo '<li><a href="' . esc_url( wc_get_page_permalink( 'myaccount' ) ) . '">My Account</a></li>';
                } else {
                    echo '<li><a href="' . esc_url( get_template_directory_uri() . '/faq.html' ) . '">FAQs</a></li>';
                    echo '<li><a href="' . esc_url( get_template_directory_uri() . '/bulk-orders.html' ) . '">Bulk Orders</a></li>';
                }
                echo '</ul>';
            }
            ?>
        </nav>
    </div>
</header>
