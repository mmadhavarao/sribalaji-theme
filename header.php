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
<!-- Temporary Local Device Preview Switcher (Removable after testing) -->
<div class="local-device-switcher-bar" id="localDeviceSwitcherBar" role="region" aria-label="Device Simulation Bar">
    <div class="device-switcher-inner">
        <span class="switcher-tag">🧪 LOCAL PREVIEW:</span>
        <div class="device-btns-group">
            <button type="button" class="device-btn is-active" data-device="auto" onclick="setDevicePreview('auto')" title="Auto detect (follows window/device)">
                <span class="btn-icon">🔄</span> <span class="btn-text">Auto</span>
            </button>
            <button type="button" class="device-btn" data-device="mobile" onclick="setDevicePreview('mobile')" title="Mobile View (Phone screen ~390px)">
                <span class="btn-icon">📱</span> <span class="btn-text">Mobile</span>
            </button>
            <button type="button" class="device-btn" data-device="tablet" onclick="setDevicePreview('tablet')" title="Tablet View (~768px)">
                <span class="btn-icon">📟</span> <span class="btn-text">Tablet</span>
            </button>
            <button type="button" class="device-btn" data-device="desktop" onclick="setDevicePreview('desktop')" title="Desktop View (Full 50/50 hero)">
                <span class="btn-icon">💻</span> <span class="btn-text">Desktop</span>
            </button>
        </div>
        <button type="button" class="switcher-minimize-btn" onclick="toggleDeviceSwitcher()" title="Minimize preview bar" aria-label="Minimize preview bar">&minus;</button>
    </div>
</div>
<script>
function setDevicePreview(mode) {
    document.body.classList.remove('preview-mode-mobile', 'preview-mode-tablet', 'preview-mode-desktop');
    document.querySelectorAll('.device-btn').forEach(function(b) {
        b.classList.toggle('is-active', b.getAttribute('data-device') === mode);
    });
    if (mode !== 'auto') {
        document.body.classList.add('preview-mode-' + mode);
    }
    try { localStorage.setItem('sb_device_preview', mode); } catch(e) {}
}
function toggleDeviceSwitcher() {
    var bar = document.getElementById('localDeviceSwitcherBar');
    if (bar) bar.classList.toggle('is-minimized');
}
(function() {
    try {
        var saved = localStorage.getItem('sb_device_preview');
        if (saved && ['auto','mobile','tablet','desktop'].indexOf(saved) !== -1) {
            setDevicePreview(saved);
        }
    } catch(e) {}
})();
</script>

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
        <div class="site-branding-row">
            <div class="site-branding">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand-title">
                    <?php bloginfo( 'name' ); ?>
                </a>
                <div class="brand-tagline">
                    <?php bloginfo( 'description' ); ?>
                </div>
            </div>

            <!-- Top-Right Account & Profile Trigger -->
            <div class="header-account-area" id="headerAccountArea">
                <?php if ( is_user_logged_in() ) : 
                    $current_user = wp_get_current_user();
                    $display_name = ! empty( $current_user->first_name ) ? $current_user->first_name : ( ! empty( $current_user->display_name ) ? $current_user->display_name : 'Account' );
                    $orders_url   = function_exists( 'wc_get_endpoint_url' ) ? wc_get_endpoint_url( 'orders', '', wc_get_page_permalink( 'myaccount' ) ) : home_url( '/my-account/' );
                    $address_url  = function_exists( 'wc_get_endpoint_url' ) ? wc_get_endpoint_url( 'edit-address', '', wc_get_page_permalink( 'myaccount' ) ) : home_url( '/my-account/' );
                    $account_url  = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account/' );
                    $logout_url   = wp_logout_url( home_url( '/' ) );
                ?>
                    <div class="profile-dropdown-wrapper">
                        <button type="button" class="profile-trigger-btn" id="profileTriggerBtn" onclick="toggleProfileDropdown(event)" aria-expanded="false" aria-haspopup="true">
                            <span class="profile-avatar-circle">👤</span>
                            <span class="profile-user-name"><?php echo esc_html( $display_name ); ?></span>
                            <svg class="profile-caret" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div class="profile-dropdown-menu" id="profileDropdownMenu" role="menu">
                            <div class="profile-menu-header">
                                <div class="profile-menu-name">👋 Hi, <?php echo esc_html( $display_name ); ?></div>
                                <div class="profile-menu-phone"><?php echo esc_html( $current_user->user_email ); ?></div>
                            </div>
                            <ul class="profile-menu-list">
                                <li>
                                    <a href="<?php echo esc_url( $orders_url ); ?>" class="profile-menu-item">
                                        <span class="p-item-icon">📦</span>
                                        <div class="p-item-text">
                                            <span class="p-item-title">My Orders</span>
                                            <span class="p-item-sub">Track deliveries &amp; invoices</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo esc_url( $address_url ); ?>" class="profile-menu-item">
                                        <span class="p-item-icon">📍</span>
                                        <div class="p-item-text">
                                            <span class="p-item-title">Saved Addresses</span>
                                            <span class="p-item-sub">Home, School &amp; Office locations</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo esc_url( $account_url ); ?>" class="profile-menu-item">
                                        <span class="p-item-icon">⚙️</span>
                                        <div class="p-item-text">
                                            <span class="p-item-title">Account Details</span>
                                            <span class="p-item-sub">Profile, password &amp; preferences</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="profile-menu-divider"></li>
                                <li>
                                    <a href="<?php echo esc_url( $logout_url ); ?>" class="profile-menu-item logout-item">
                                        <span class="p-item-icon">🚪</span>
                                        <div class="p-item-text">
                                            <span class="p-item-title">Log Out</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php else : 
                    $login_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account/' );
                ?>
                    <button type="button" class="header-login-btn" onclick="if(typeof sribalajiOpenOtpModal==='function'){sribalajiOpenOtpModal();}else{window.location.href='<?php echo esc_url( $login_url ); ?>';}">
                        <span class="login-btn-icon">👤</span>
                        <span class="login-btn-text">Sign In</span>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <?php 
        // Suppress search bar and category tabs on My Account, Login, Checkout, and Cart pages
        $sribalaji_hide_search_and_tabs = false;
        if ( function_exists( 'is_account_page' ) && is_account_page() ) {
            $sribalaji_hide_search_and_tabs = true;
        }
        if ( function_exists( 'is_checkout' ) && is_checkout() ) {
            $sribalaji_hide_search_and_tabs = true;
        }
        if ( function_exists( 'is_cart' ) && is_cart() ) {
            $sribalaji_hide_search_and_tabs = true;
        }

        // On WooCommerce shop, category archive, and product pages, category navigation is handled by the dedicated Reversed-U Shop Title Bar
        $sribalaji_hide_category_tabs = $sribalaji_hide_search_and_tabs;
        if ( ( function_exists( 'is_shop' ) && is_shop() ) || ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) || ( function_exists( 'is_product_category' ) && is_product_category() ) || ( function_exists( 'is_product' ) && is_product() ) ) {
            $sribalaji_hide_category_tabs = true;
        }
        ?>

        <?php if ( ! $sribalaji_hide_search_and_tabs ) : ?>
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
        <?php endif; ?>

        <?php if ( ! $sribalaji_hide_category_tabs ) : ?>
        <!-- Sticky Blinkit Horizontal Reversed-U Category Tabs (Shown on Mobile / Tablet) -->
        <nav class="mobile-category-tabs-bar sribalaji-reversed-u-bar" id="mobileCategoryTabsBar" aria-label="Product Categories">
            <div class="reversed-u-scroll-track">
                <button type="button" class="reversed-u-cat-card is-active" data-category="all" onclick="selectCategoryTab('all', this)">
                    <div class="reversed-u-tab-header">
                        <span class="reversed-u-header-badge">EXPLORE ALL</span>
                    </div>
                    <div class="reversed-u-tab-body">
                        <div class="reversed-u-thumb-box">
                            <span class="reversed-u-icon">✨</span>
                        </div>
                        <div class="reversed-u-text-col">
                            <span class="reversed-u-title">All Categories</span>
                        </div>
                    </div>
                </button>
                <button type="button" class="reversed-u-cat-card" data-category="notebooks" onclick="selectCategoryTab('notebooks', this)">
                    <div class="reversed-u-tab-header">
                        <span class="reversed-u-header-badge">UP TO 22% OFF</span>
                    </div>
                    <div class="reversed-u-tab-body">
                        <div class="reversed-u-thumb-box">
                            <span class="reversed-u-icon">📓</span>
                        </div>
                        <div class="reversed-u-text-col">
                            <span class="reversed-u-title">Notebooks &amp; Registers</span>
                        </div>
                    </div>
                </button>
                <button type="button" class="reversed-u-cat-card" data-category="pens" onclick="selectCategoryTab('pens', this)">
                    <div class="reversed-u-tab-header">
                        <span class="reversed-u-header-badge">UP TO 17% OFF</span>
                    </div>
                    <div class="reversed-u-tab-body">
                        <div class="reversed-u-thumb-box">
                            <span class="reversed-u-icon">🖊️</span>
                        </div>
                        <div class="reversed-u-text-col">
                            <span class="reversed-u-title">Pens &amp; Writing</span>
                        </div>
                    </div>
                </button>
                <button type="button" class="reversed-u-cat-card" data-category="art" onclick="selectCategoryTab('art', this)">
                    <div class="reversed-u-tab-header">
                        <span class="reversed-u-header-badge">UP TO 24% OFF</span>
                    </div>
                    <div class="reversed-u-tab-body">
                        <div class="reversed-u-thumb-box">
                            <span class="reversed-u-icon">🎨</span>
                        </div>
                        <div class="reversed-u-text-col">
                            <span class="reversed-u-title">Art &amp; Craft</span>
                        </div>
                    </div>
                </button>
                <button type="button" class="reversed-u-cat-card" data-category="office" onclick="selectCategoryTab('office', this)">
                    <div class="reversed-u-tab-header">
                        <span class="reversed-u-header-badge">SAVE ₹50</span>
                    </div>
                    <div class="reversed-u-tab-body">
                        <div class="reversed-u-thumb-box">
                            <span class="reversed-u-icon">📁</span>
                        </div>
                        <div class="reversed-u-text-col">
                            <span class="reversed-u-title">Office &amp; Files</span>
                        </div>
                    </div>
                </button>
                <button type="button" class="reversed-u-cat-card" data-category="geometry" onclick="selectCategoryTab('geometry', this)">
                    <div class="reversed-u-tab-header">
                        <span class="reversed-u-header-badge">UP TO 24% OFF</span>
                    </div>
                    <div class="reversed-u-tab-body">
                        <div class="reversed-u-thumb-box">
                            <span class="reversed-u-icon">📐</span>
                        </div>
                        <div class="reversed-u-text-col">
                            <span class="reversed-u-title">School Kits</span>
                        </div>
                    </div>
                </button>
            </div>
        </nav>
        <?php endif; ?>

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

<script>
function toggleProfileDropdown(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    var menu = document.getElementById('profileDropdownMenu');
    var btn = document.getElementById('profileTriggerBtn');
    if (!menu) return;
    var isOpen = menu.classList.toggle('is-open');
    if (btn) btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
}

document.addEventListener('click', function(e) {
    var menu = document.getElementById('profileDropdownMenu');
    var btn = document.getElementById('profileTriggerBtn');
    if (menu && menu.classList.contains('is-open')) {
        if (!menu.contains(e.target) && (!btn || !btn.contains(e.target))) {
            menu.classList.remove('is-open');
            if (btn) btn.setAttribute('aria-expanded', 'false');
        }
    }
});

function selectCategoryTab(categoryKey, btn) {
    var tabs = document.querySelectorAll('.category-tab-btn, .reversed-u-cat-card');
    tabs.forEach(function(t) { t.classList.remove('is-active'); });
    if (btn) btn.classList.add('is-active');

    if (btn && btn.scrollIntoView) {
        btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    }

    var sections = document.querySelectorAll('.mobile-category-section');
    if (!sections.length) return;

    if (categoryKey === 'all') {
        sections.forEach(function(sec) {
            sec.style.display = 'block';
            sec.classList.remove('is-filtered-single');
        });
    } else {
        sections.forEach(function(sec) {
            if (sec.getAttribute('data-category') === categoryKey) {
                sec.style.display = 'block';
                sec.classList.add('is-filtered-single');
            } else {
                sec.style.display = 'none';
                sec.classList.remove('is-filtered-single');
            }
        });
    }
}
</script>
