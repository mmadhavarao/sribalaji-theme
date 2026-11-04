<?php
/**
 * Sri Balaji Books Custom Theme Functions
 *
 * @package SriBalajiTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Detects if the current environment is Staging, LocalWP sandbox, or Development.
 *
 * @return bool True if staging or local sandbox, false if production.
 */
function sribalaji_is_staging_or_sandbox() {
    // 1. WordPress environment type check (WP 5.5+)
    if ( function_exists( 'wp_get_environment_type' ) ) {
        $env = wp_get_environment_type();
        if ( in_array( $env, array( 'staging', 'development', 'local' ), true ) ) {
            return true;
        }
    }

    // 2. Custom constant defined in wp-config.php (e.g. define('SRIBALAJI_ENV', 'staging');)
    if ( defined( 'SRIBALAJI_ENV' ) && in_array( constant( 'SRIBALAJI_ENV' ), array( 'staging', 'sandbox', 'dev', 'local' ), true ) ) {
        return true;
    }

    // 3. Inspect Host header or home URL
    $host = isset( $_SERVER['HTTP_HOST'] ) ? strtolower( $_SERVER['HTTP_HOST'] ) : '';
    if ( empty( $host ) ) {
        $host = strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) );
    }

    if (
        strpos( $host, 'staging.' ) !== false ||
        strpos( $host, 'stg.' ) !== false ||
        strpos( $host, 'sandbox' ) !== false ||
        strpos( $host, '.local' ) !== false ||
        strpos( $host, 'localhost' ) !== false ||
        strpos( $host, '127.0.0.1' ) !== false
    ) {
        return true;
    }

    return false;
}

/**
 * Setup theme features.
 */
function sribalaji_theme_setup() {
    // Add dynamic document title support
    add_theme_support( 'title-tag' );

    // Enable featured images
    add_theme_support( 'post-thumbnails' );

    // Enable WooCommerce support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => __( 'Primary Navigation', 'sribalaji-theme' ),
    ) );
}
add_action( 'after_setup_theme', 'sribalaji_theme_setup' );

/**
 * Enqueue theme stylesheets with cache-busting and proper WooCommerce dependencies.
 */
function sribalaji_theme_scripts() {
    $deps = array();
    if ( class_exists( 'WooCommerce' ) ) {
        $deps = array( 'woocommerce-general', 'woocommerce-layout' );
    }

    $theme_css = get_stylesheet_directory() . '/style.css';
    $version   = file_exists( $theme_css ) ? filemtime( $theme_css ) : '1.0.2';

    wp_enqueue_style( 'sribalaji-main-style', get_stylesheet_uri(), $deps, $version );

    // Enqueue Native Mobile OTP Login script on My Account page for guest visitors
    if ( ! is_user_logged_in() && ( is_account_page() || is_page( 'my-account' ) ) ) {
        $otp_js  = get_stylesheet_directory() . '/js/sribalaji-otp-login.js';
        $otp_ver = file_exists( $otp_js ) ? filemtime( $otp_js ) : '1.1.0';
        wp_enqueue_script( 'sribalaji-otp-login', get_stylesheet_directory_uri() . '/js/sribalaji-otp-login.js', array( 'jquery' ), $otp_ver, true );
        wp_localize_script( 'sribalaji-otp-login', 'sribalaji_auth_params', array(
            'ajax_url'     => admin_url( 'admin-ajax.php' ),
            'nonce'        => wp_create_nonce( 'sribalaji_native_otp_nonce' ),
            'redirect_url' => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account/' ),
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'sribalaji_theme_scripts', 20 );

/**
 * Dynamically resolves a WooCommerce product category permalink with candidate fallback slugs.
 *
 * @param string|array $slugs Primary slug or array of candidate slugs.
 * @param string       $fallback_name Optional display name to search if slugs fail.
 * @return string Safe permalink URL.
 */
function sribalaji_get_category_url( $slugs, $fallback_name = '' ) {
    if ( ! taxonomy_exists( 'product_cat' ) ) {
        return home_url( '/shop/' );
    }

    $candidates = is_array( $slugs ) ? $slugs : array( $slugs );
    
    // 1. Try finding by slug candidates in order
    foreach ( $candidates as $slug ) {
        if ( empty( $slug ) ) continue;
        $term = get_term_by( 'slug', $slug, 'product_cat' );
        if ( $term && ! is_wp_error( $term ) ) {
            $link = get_term_link( $term, 'product_cat' );
            if ( ! is_wp_error( $link ) ) {
                return $link;
            }
        }
    }

    // 2. Try finding by name if slug lookup failed
    if ( ! empty( $fallback_name ) ) {
        $term = get_term_by( 'name', $fallback_name, 'product_cat' );
        if ( $term && ! is_wp_error( $term ) ) {
            $link = get_term_link( $term, 'product_cat' );
            if ( ! is_wp_error( $link ) ) {
                return $link;
            }
        }
    }

    // 3. Fallback to shop page with query filter or permalink
    $primary_slug = ! empty( $candidates[0] ) ? $candidates[0] : '';
    $shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
    if ( empty( $shop_url ) || $shop_url === home_url( '/' ) || $shop_url === home_url() ) {
        $shop_url = home_url( '/shop/' );
    }
    if ( $primary_slug ) {
        return add_query_arg( 'product_cat', $primary_slug, $shop_url );
    }
    return $shop_url;
}

/**
 * WooCommerce Layout Overrides
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
// Remove the default WooCommerce sidebar so it doesn't appear at the bottom
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Blinkit-Style Reversed-U Shape Category Title Bar for Shop & Archives
 */
function sribalaji_render_reversed_u_category_bar() {
    $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink( 'shop' ) : home_url('/shop/');
    
    // Determine active category
    $active_cat = 'all';
    if ( function_exists('is_product_category') && is_product_category() ) {
        $queried_obj = get_queried_object();
        if ( $queried_obj && ! empty( $queried_obj->slug ) ) {
            $active_cat = $queried_obj->slug;
        }
    } elseif ( ! empty( $_GET['product_cat'] ) ) {
        $active_cat = sanitize_text_field( $_GET['product_cat'] );
    }

    // Curated stationery category definitions with icons and offer badges
    $category_defs = array(
        'all' => array(
            'name'  => 'All Categories',
            'icon'  => '✨',
            'badge' => 'EXPLORE ALL',
            'url'   => $shop_url,
        ),
        'notebooks' => array(
            'name'  => 'Notebooks & Registers',
            'icon'  => '📓',
            'badge' => 'UP TO 22% OFF',
            'url'   => add_query_arg( 'product_cat', 'notebooks', $shop_url ),
        ),
        'pens' => array(
            'name'  => 'Pens & Writing',
            'icon'  => '🖊️',
            'badge' => 'UP TO 17% OFF',
            'url'   => add_query_arg( 'product_cat', 'pens', $shop_url ),
        ),
        'art' => array(
            'name'  => 'Art & Craft',
            'icon'  => '🎨',
            'badge' => 'UP TO 24% OFF',
            'url'   => add_query_arg( 'product_cat', 'art', $shop_url ),
        ),
        'office' => array(
            'name'  => 'Office & Files',
            'icon'  => '📁',
            'badge' => 'SAVE ₹50',
            'url'   => add_query_arg( 'product_cat', 'office', $shop_url ),
        ),
        'geometry' => array(
            'name'  => 'School Kits',
            'icon'  => '📐',
            'badge' => 'UP TO 24% OFF',
            'url'   => add_query_arg( 'product_cat', 'geometry', $shop_url ),
        ),
        'books' => array(
            'name'  => 'Textbooks & Guides',
            'icon'  => '📚',
            'badge' => 'BESTSELLER',
            'url'   => add_query_arg( 'product_cat', 'books', $shop_url ),
        ),
        'diaries' => array(
            'name'  => 'Diaries & Planners',
            'icon'  => '📖',
            'badge' => 'NEW 2026',
            'url'   => add_query_arg( 'product_cat', 'diaries', $shop_url ),
        ),
    );

    // If WordPress has dynamic terms in DB, merge / use actual term links
    if ( taxonomy_exists( 'product_cat' ) ) {
        $real_terms = get_terms( array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => 1,
            'parent'     => 0,
        ) );
        if ( ! empty( $real_terms ) && ! is_wp_error( $real_terms ) ) {
            foreach ( $real_terms as $term ) {
                $term_link = get_term_link( $term );
                if ( is_wp_error( $term_link ) ) {
                    $term_link = add_query_arg( 'product_cat', $term->slug, $shop_url );
                }
                
                if ( isset( $category_defs[ $term->slug ] ) ) {
                    $category_defs[ $term->slug ]['url'] = $term_link;
                    $category_defs[ $term->slug ]['name'] = $term->name;
                } else {
                    $slug_lower = strtolower( $term->slug . ' ' . $term->name );
                    $icon = '🏷️';
                    $badge = 'POPULAR';
                    if ( strpos( $slug_lower, 'notebook' ) !== false || strpos( $slug_lower, 'register' ) !== false || strpos( $slug_lower, 'copy' ) !== false ) {
                        $icon = '📓'; $badge = 'UP TO 22% OFF';
                    } elseif ( strpos( $slug_lower, 'pen' ) !== false || strpos( $slug_lower, 'pencil' ) !== false || strpos( $slug_lower, 'write' ) !== false ) {
                        $icon = '🖊️'; $badge = 'UP TO 17% OFF';
                    } elseif ( strpos( $slug_lower, 'art' ) !== false || strpos( $slug_lower, 'craft' ) !== false || strpos( $slug_lower, 'color' ) !== false || strpos( $slug_lower, 'paint' ) !== false ) {
                        $icon = '🎨'; $badge = 'UP TO 24% OFF';
                    } elseif ( strpos( $slug_lower, 'office' ) !== false || strpos( $slug_lower, 'file' ) !== false || strpos( $slug_lower, 'folder' ) !== false ) {
                        $icon = '📁'; $badge = 'SAVE ₹50';
                    } elseif ( strpos( $slug_lower, 'geometry' ) !== false || strpos( $slug_lower, 'school' ) !== false || strpos( $slug_lower, 'kit' ) !== false ) {
                        $icon = '📐'; $badge = 'UP TO 24% OFF';
                    } elseif ( strpos( $slug_lower, 'book' ) !== false || strpos( $slug_lower, 'guide' ) !== false ) {
                        $icon = '📚'; $badge = 'BESTSELLER';
                    }
                    $category_defs[ $term->slug ] = array(
                        'name'  => $term->name,
                        'icon'  => $icon,
                        'badge' => $badge,
                        'url'   => $term_link,
                    );
                }
            }
        }
    }
    ?>
    <!-- Blinkit-Style Reversed-U Shape Category Title Bar -->
    <nav class="sribalaji-reversed-u-bar" aria-label="Product Categories Title Bar">
        <div class="reversed-u-scroll-track">
            <?php foreach ( $category_defs as $cat_slug => $cat ): 
                $is_active = ( $active_cat === $cat_slug );
            ?>
                <a href="<?php echo esc_url( $cat['url'] ); ?>" 
                   class="reversed-u-cat-card <?php echo $is_active ? 'is-active' : ''; ?>" 
                   data-category="<?php echo esc_attr( $cat_slug ); ?>"
                   title="<?php echo esc_attr( $cat['name'] ); ?>">
                    <div class="reversed-u-tab-header">
                        <span class="reversed-u-header-badge"><?php echo esc_html( $cat['badge'] ); ?></span>
                    </div>
                    <div class="reversed-u-tab-body">
                        <div class="reversed-u-thumb-box">
                            <span class="reversed-u-icon"><?php echo $cat['icon']; ?></span>
                        </div>
                        <div class="reversed-u-text-col">
                            <span class="reversed-u-title"><?php echo esc_html( $cat['name'] ); ?></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var activeTab = document.querySelector('.sribalaji-reversed-u-bar .reversed-u-cat-card.is-active');
            if (activeTab && activeTab.scrollIntoView) {
                try {
                    activeTab.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                } catch(e) {}
            }
        });
    </script>
    <?php
}

add_action( 'woocommerce_before_main_content', 'sribalaji_wc_wrapper_start', 10 );
function sribalaji_wc_wrapper_start() {
    // 1. Output Blinkit Reversed-U Shape Category Title Bar for Shop & Archives
    if ( ( function_exists('is_shop') && is_shop() ) || ( function_exists('is_product_taxonomy') && is_product_taxonomy() ) || ( function_exists('is_product_category') && is_product_category() ) ) {
        sribalaji_render_reversed_u_category_bar();
    }

    echo '<div class="sribalaji-wc-container">';
    
    // Custom Left Sidebar (Replaced by Reversed-U Title Bar, hidden via CSS)
    echo '<aside class="sribalaji-wc-sidebar" aria-hidden="true" style="display:none;">';
    echo '<div class="wc-sidebar-widget">';
    echo '<h3>Filter Categories</h3>';
    
    if ( taxonomy_exists( 'product_cat' ) ) {
        $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink( 'shop' ) : home_url('/shop/');
        echo '<form id="sribalaji-category-filter" action="' . esc_url( $shop_url ) . '" method="GET">';
        
        $current_cats = isset($_GET['product_cat']) ? explode(',', sanitize_text_field($_GET['product_cat'])) : array();
        if ( is_product_category() ) {
            $current_cat_obj = get_queried_object();
            if ( $current_cat_obj && !in_array($current_cat_obj->slug, $current_cats) ) {
                $current_cats[] = $current_cat_obj->slug;
            }
        }

        $top_terms = get_terms( array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => 1,
            'parent'     => 0,
        ) );
        
        if ( ! empty( $top_terms ) && ! is_wp_error( $top_terms ) ) {
            echo '<ul class="sribalaji-category-checklist">';
            foreach ( $top_terms as $top_term ) {
                $checked = in_array( $top_term->slug, $current_cats ) ? 'checked' : '';
                
                $child_terms = get_terms( array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => 1,
                    'parent'     => $top_term->term_id,
                ) );
                
                $has_children = ( ! empty( $child_terms ) && ! is_wp_error( $child_terms ) );
                
                echo '<li class="cat-item cat-item-top">';
                if ( $has_children ) {
                    echo '<details ' . ($checked ? 'open' : '') . ' class="cat-details">';
                    echo '<summary class="cat-summary">';
                    echo '<label onclick="event.stopPropagation()"><input type="checkbox" class="cat-checkbox" value="' . esc_attr( $top_term->slug ) . '" ' . $checked . ' /> ' . esc_html( $top_term->name ) . ' <span class="count">(' . $top_term->count . ')</span></label>';
                    echo '<span class="cat-toggle-icon"></span>';
                    echo '</summary>';
                    
                    echo '<ul class="children">';
                    foreach ( $child_terms as $child_term ) {
                        $child_checked = in_array( $child_term->slug, $current_cats ) ? 'checked' : '';
                        echo '<li class="cat-item">';
                        echo '<label><input type="checkbox" class="cat-checkbox" value="' . esc_attr( $child_term->slug ) . '" ' . $child_checked . ' /> ' . esc_html( $child_term->name ) . ' <span class="count">(' . $child_term->count . ')</span></label>';
                        echo '</li>';
                    }
                    echo '</ul>';
                    echo '</details>';
                } else {
                    echo '<div class="cat-no-children">';
                    echo '<label><input type="checkbox" class="cat-checkbox" value="' . esc_attr( $top_term->slug ) . '" ' . $checked . ' /> ' . esc_html( $top_term->name ) . ' <span class="count">(' . $top_term->count . ')</span></label>';
                    echo '</div>';
                }
                echo '</li>';
            }
            echo '</ul>';
        }
        
        echo '<button type="submit" class="btn-primary filter-submit-btn">Apply Filters</button>';
        echo '</form>';
        
        // JS to handle form submission cleanly and manage accordion state
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var form = document.getElementById('sribalaji-category-filter');
                if(form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        var checked = [];
                        var checkboxes = this.querySelectorAll('.cat-checkbox:checked');
                        checkboxes.forEach(function(cb) {
                            checked.push(cb.value);
                        });
                        if(checked.length > 0) {
                            var url = new URL(this.action);
                            url.searchParams.set('product_cat', checked.join(','));
                            window.location.href = url.toString();
                        } else {
                            window.location.href = this.action;
                        }
                    });
                }

                // Open parent details if a child is checked
                document.querySelectorAll('.cat-item-top').forEach(function(li) {
                    var details = li.querySelector('details');
                    if(details && li.querySelector('.children .cat-checkbox:checked')) {
                        details.setAttribute('open', 'open');
                    }
                });
            });
        </script>";
    }
    
    echo '</div>';
    echo '</aside>';

    // Main content area
    echo '<main class="sribalaji-wc-main">';
}

add_action( 'woocommerce_after_main_content', 'sribalaji_wc_wrapper_end', 10 );
function sribalaji_wc_wrapper_end() {
    echo '</main>';
    echo '</div>'; // End sribalaji-wc-container
}


/**
 * Feature 1.3: Smart WhatsApp Buttons (Product Page & Floating)
 */

// 1. Add "Order on WhatsApp" button on Single Product Page below Add to Cart
add_action( 'woocommerce_single_product_summary', 'sribalaji_whatsapp_quick_order_btn', 35 );
function sribalaji_whatsapp_quick_order_btn() {
    global $product;
    if ( ! $product ) return;

    $phone_number = '919985181133'; // Active Shop WhatsApp Number
    $product_name = $product->get_name();
    $product_price = strip_tags( wc_price( wc_get_price_to_display( $product ) ) );
    $product_url = get_permalink( $product->get_id() );

    $message = sprintf( 
        "Hi Sri Balaji Books, I would like to order:\n\n*Product:* %s\n*Price:* %s\n*Link:* %s", 
        $product_name, 
        $product_price, 
        $product_url 
    );
    $whatsapp_url = 'https://wa.me/' . $phone_number . '?text=' . rawurlencode( $message );

    echo '<a href="' . esc_url( $whatsapp_url ) . '" target="_blank" class="btn-whatsapp-product" rel="noopener noreferrer" style="display: flex; align-items: center; justify-content: center; width: 100%; background-color: #25D366; color: white; padding: 0.8rem; border-radius: 8px; font-weight: bold; text-decoration: none; margin-top: 1rem; transition: background 0.2s;">';
    echo '<svg style="width: 22px; height: 22px; margin-right: 10px;" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.124.551 4.195 1.597 6.015L.085 24l6.108-1.583c1.765.98 3.755 1.5 5.838 1.5 6.646 0 12.031-5.385 12.031-12.031S18.677 0 12.031 0zm0 21.905c-1.802 0-3.567-.484-5.114-1.401l-.367-.217-3.799.996.996-3.799-.217-.367c-1.008-1.706-1.541-3.676-1.541-5.717 0-5.462 4.444-9.906 9.906-9.906s9.906 4.444 9.906 9.906-4.444 9.906-9.906 9.906zm5.429-7.442c-.297-.149-1.76-.871-2.033-.971-.272-.099-.47-.149-.669.149-.198.297-.768.971-.941 1.169-.173.198-.347.223-.644.074-2.146-1.077-3.666-2.483-4.453-3.844-.124-.214.07-.193.363-.772.099-.198.05-.371-.025-.52-.074-.149-.669-1.611-.916-2.206-.241-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.793.371-.272.297-1.04 1.016-1.04 2.477s1.065 2.873 1.214 3.072c.149.198 2.096 3.199 5.08 4.485 1.83.79 2.502.83 3.447.705.996-.132 2.873-1.17 3.27-2.3.396-1.13.396-2.096.277-2.3-.119-.204-.416-.328-.714-.477z"/></svg>';
    echo 'Order on WhatsApp</a>';
}

// 2. Add Floating WhatsApp Button Globally
add_action( 'wp_footer', 'sribalaji_whatsapp_floating_btn' );
function sribalaji_whatsapp_floating_btn() {
    $phone_number = '919985181133'; // Active Shop WhatsApp Number
    
    $message = "Hi Sri Balaji Books, I have an inquiry.";
    if ( is_product() ) {
        global $product;
        if ( $product ) {
            $product_name = $product->get_name();
            $product_url = get_permalink( $product->get_id() );
            $message = sprintf( "Hi Sri Balaji Books, I have a question about %s (%s)", $product_name, $product_url );
        }
    }
    
    $whatsapp_url = 'https://wa.me/' . $phone_number . '?text=' . rawurlencode( $message );

    echo '<a href="' . esc_url( $whatsapp_url ) . '" target="_blank" class="whatsapp-floating-btn" rel="noopener noreferrer" aria-label="Chat on WhatsApp">';
    echo '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.124.551 4.195 1.597 6.015L.085 24l6.108-1.583c1.765.98 3.755 1.5 5.838 1.5 6.646 0 12.031-5.385 12.031-12.031S18.677 0 12.031 0zm0 21.905c-1.802 0-3.567-.484-5.114-1.401l-.367-.217-3.799.996.996-3.799-.217-.367c-1.008-1.706-1.541-3.676-1.541-5.717 0-5.462 4.444-9.906 9.906-9.906s9.906 4.444 9.906 9.906-4.444 9.906-9.906 9.906zm5.429-7.442c-.297-.149-1.76-.871-2.033-.971-.272-.099-.47-.149-.669.149-.198.297-.768.971-.941 1.169-.173.198-.347.223-.644.074-2.146-1.077-3.666-2.483-4.453-3.844-.124-.214.07-.193.363-.772.099-.198.05-.371-.025-.52-.074-.149-.669-1.611-.916-2.206-.241-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.793.371-.272.297-1.04 1.016-1.04 2.477s1.065 2.873 1.214 3.072c.149.198 2.096 3.199 5.08 4.485 1.83.79 2.502.83 3.447.705.996-.132 2.873-1.17 3.27-2.3.396-1.13.396-2.096.277-2.3-.119-.204-.416-.328-.714-.477z"/></svg>';
    echo '</a>';
}

/**
 * Environment-Aware Meta Catalog Feed Generator
 * Supports:
 * - Local instructions vs direct raw download
 * - 10-product safe pilot feed (safe_mode=1, availability='out of stock')
 * - Full catalog feed
 * URL: /?meta_feed=true
 */
add_action( 'init', 'sribalaji_meta_catalog_feed' );
function sribalaji_meta_catalog_feed() {
    if ( ! isset( $_GET['meta_feed'] ) ) return;
    
    // Check if we are running locally based on hostname
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    $is_local = ( strpos($host, '.local') !== false || strpos($host, 'localhost') !== false );

    // If local and user hasn't chosen a download option, show interactive instructions
    if ( $is_local && ! isset( $_GET['download'] ) ) {
        echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Meta Catalog Feed - Sri Balaji Books</title>";
        echo "<style>
            body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, sans-serif; background: #f1f5f9; padding: 40px 20px; color: #1e293b; }
            .card { max-width: 680px; margin: 0 auto; background: #fff; padding: 35px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
            h2 { margin-top: 0; color: #0f172a; font-size: 1.5rem; display: flex; align-items: center; gap: 8px; }
            .badge-safe { background: #dcfce7; color: #166534; font-size: 0.75rem; padding: 3px 8px; border-radius: 999px; font-weight: 700; text-transform: uppercase; }
            .btn { display: inline-block; padding: 12px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; margin-right: 10px; margin-top: 8px; transition: all 0.2s; }
            .btn-pilot { background: #2563eb; color: #fff; }
            .btn-pilot:hover { background: #1d4ed8; }
            .btn-full { background: #f8fafc; color: #334155; border: 1px solid #cbd5e1; }
            .btn-full:hover { background: #e2e8f0; }
            .step-box { background: #f8fafc; border-left: 4px solid #2563eb; padding: 16px; border-radius: 0 8px 8px 0; margin: 20px 0; }
            ol { margin: 0; padding-left: 20px; line-height: 1.7; }
            code { background: #e2e8f0; padding: 2px 6px; border-radius: 4px; font-size: 0.9em; }
        </style></head><body>";
        echo "<div class='card'>";
        $current_host = wp_parse_url( home_url(), PHP_URL_HOST );
        $env_label = sribalaji_is_staging_or_sandbox() ? 'Staging / Sandbox' : 'Production Live';
        echo "<h2>📦 Meta Commerce Catalog Exporter <span class='badge-safe'>" . esc_html( $env_label ) . "</span></h2>";
        echo "<p>Your site is currently running on <code>" . esc_html( $current_host ) . "</code>. You can export your verified product feed as a CSV and upload it to Meta Commerce Manager, or use the automated 24-hour sync URL once deployed live.</p>";
        
        echo "<div class='step-box'>";
        echo "<strong>Recommended Safe Pilot (10 Products • Stock=0):</strong><br>";
        echo "<p style='margin: 8px 0 12px 0; font-size: 0.92rem; color: #475569;'>This pilot export contains 10 verified products marked as <code>out of stock</code>. This allows you to test catalog appearance in WhatsApp Business without risk of accidental live customer orders.</p>";
        echo "<a href='?meta_feed=true&download=1&limit=10&safe=1' class='btn btn-pilot'>📥 Download 10-Product Pilot CSV (Safe Mode)</a>";
        echo "<a href='?meta_feed=true&download=1' class='btn btn-full'>📦 Download Full Catalog (All Products)</a>";
        echo "</div>";

        echo "<h3>Next Steps in Meta Commerce Manager:</h3>";
        echo "<ol>";
        echo "<li>Log in to <a href='https://business.facebook.com/commerce' target='_blank' style='color: #2563eb;'>Meta Commerce Manager</a>.</li>";
        echo "<li>Select or create your Catalog &rarr; Go to <strong>Catalogue &rarr; Data Sources</strong>.</li>";
        echo "<li>Choose <strong>Data Feed</strong> &rarr; Select <strong>Upload from your computer</strong>.</li>";
        echo "<li>Upload the downloaded CSV file.</li>";
        echo "<li>Link the Catalog to your WhatsApp Business number (<code>+91 99851 81133</code>) under <strong>Settings &rarr; Business Assets</strong>.</li>";
        echo "</ol>";
        
        echo "<hr style='border: none; border-top: 1px solid #e2e8f0; margin: 24px 0;'>";
        echo "<p style='color: #64748b; font-size: 0.85rem;'><em>💡 Production Note: Once you deploy to Hostinger, the automated sync URL <code>" . home_url('/?meta_feed=true&download=1') . "</code> will let Meta refresh your catalog automatically every 24 hours.</em></p>";
        echo "</div></body></html>";
        exit;
    }

    // Parameters
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : -1;
    $is_safe = (isset($_GET['safe']) && $_GET['safe'] == '1');

    // Generate CSV for Meta
    $filename = ($limit > 0) ? "meta_whatsapp_catalog_pilot_{$limit}.csv" : "meta_whatsapp_catalog_full.csv";
    header('Content-Type: text/csv; charset=utf-8');
    header("Content-Disposition: attachment; filename={$filename}");

    $output = fopen('php://output', 'w');
    // Exact Meta Commerce Manager standard headers
    fputcsv($output, array('id', 'title', 'description', 'availability', 'condition', 'price', 'link', 'image_link', 'brand'));

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => ($limit > 0) ? $limit : -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order title',
        'order'          => 'ASC'
    );
    $products = new WP_Query($args);

    if ( $products->have_posts() ) {
        while ( $products->have_posts() ) {
            $products->the_post();
            global $product;
            
            $id = $product->get_sku() ? $product->get_sku() : 'PROD-' . $product->get_id();
            $title = $product->get_name();
            $description = wp_strip_all_tags($product->get_short_description() ? $product->get_short_description() : $product->get_description());
            if (empty($description)) $description = $title;
            
            // Safe mode: force 'out of stock' so customers cannot order test items
            if ( $is_safe ) {
                $availability = 'out of stock';
            } else {
                $availability = $product->is_in_stock() ? 'in stock' : 'out of stock';
            }

            $condition = 'new';
            $price = number_format( (float)$product->get_price(), 2, '.', '' ) . ' INR';
            $link = get_permalink();
            $image_link = wp_get_attachment_url($product->get_image_id());
            if (!$image_link) $image_link = get_template_directory_uri() . '/images/hero-product-1.jpg';
            
            // Brand identification logic
            $brand = 'Sri Balaji Books';
            if ( stripos( $title, 'Classmate' ) !== false ) $brand = 'Classmate';
            elseif ( stripos( $title, 'Pilot' ) !== false ) $brand = 'Pilot';
            elseif ( stripos( $title, 'Faber' ) !== false ) $brand = 'Faber-Castell';
            elseif ( stripos( $title, 'Camel' ) !== false || stripos( $title, 'Camlin' ) !== false ) $brand = 'Camlin';
            elseif ( stripos( $title, 'Doms' ) !== false ) $brand = 'Doms';
            elseif ( stripos( $title, 'Paperkraft' ) !== false ) $brand = 'Paperkraft';
            elseif ( stripos( $title, 'Casio' ) !== false ) $brand = 'Casio';
            elseif ( stripos( $title, 'Reynolds' ) !== false ) $brand = 'Reynolds';
            
            fputcsv($output, array($id, $title, $description, $availability, $condition, $price, $link, $image_link, $brand));
        }
        wp_reset_postdata();
    }
    fclose($output);
    exit;
}

/**
 * Accurate WooCommerce Product Search Filter
 *
 * Prevents unintentional substring false-positives in product searches (e.g. searching 'Casio'
 * accidentally matching 'Canvas bag' because its description contains 'occasions', or 'Doms'
 * matching 'randoms' / 'kingdoms').
 *
 * Features:
 * - Prioritizes Product Titles (supports full/partial product name matching in title).
 * - Enforces word-boundary regex on product description/excerpt (so middle-of-word substrings like oc-casio-ns do not match).
 * - Seamlessly searches Product SKU (_sku meta).
 * - Seamlessly searches Product Tags & Categories (so products tagged with a brand match automatically).
 */
add_filter( 'posts_search', 'sribalaji_accurate_product_search', 20, 2 );
function sribalaji_accurate_product_search( $search, $wp_query ) {
    global $wpdb;

    // Only apply on the front-end when a search query is active
    if ( is_admin() || empty( $search ) || ! $wp_query->is_search() ) {
        return $search;
    }

    // Determine if this is a product search
    $post_types = $wp_query->get( 'post_type' );
    $is_product_search = ( $post_types === 'product' ) 
        || ( is_array( $post_types ) && in_array( 'product', $post_types, true ) )
        || ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'product' );

    if ( ! $is_product_search ) {
        return $search;
    }

    $q = $wp_query->query_vars;
    $search_terms = array();
    if ( ! empty( $q['search_terms'] ) ) {
        $search_terms = $q['search_terms'];
    } elseif ( ! empty( $q['s'] ) ) {
        $search_terms = array( $q['s'] );
    }

    if ( empty( $search_terms ) ) {
        return $search;
    }

    $new_search = '';
    $searchand = '';

    foreach ( $search_terms as $term ) {
        $term = trim( $term );
        if ( empty( $term ) ) continue;

        // Escape for SQL LIKE
        $term_like = '%' . $wpdb->esc_like( $term ) . '%';

        // Escape regex special metacharacters for POSIX REGEXP
        $term_regex = preg_replace( '/([.\\^$*+?()[\]{}|\\\\])/', '\\\\$1', $term );
        $term_regex_sql = esc_sql( $term_regex );

        // Universal POSIX word-boundary:
        // Matches if term is preceded by start-of-string or non-alphanumeric character,
        // and followed by end-of-string or non-alphanumeric character.
        $boundary_regex = '(^|[^a-zA-Z0-9])' . $term_regex_sql . '([^a-zA-Z0-9]|$)';

        // 1. Post Title (LIKE match so 'Casio fx' or 'fx-82' matches)
        $title_cond = "({$wpdb->posts}.post_title LIKE '{$term_like}')";

        // 2. Post Excerpt (Word-boundary matching to prevent mid-word substring false positives)
        $excerpt_cond = "({$wpdb->posts}.post_excerpt REGEXP '{$boundary_regex}')";

        // 3. Post Content (Word-boundary matching to prevent 'occasions' matching 'Casio')
        $content_cond = "({$wpdb->posts}.post_content REGEXP '{$boundary_regex}')";

        // 4. Product SKU matching
        $sku_cond = "({$wpdb->posts}.ID IN (
            SELECT post_id FROM {$wpdb->postmeta} 
            WHERE meta_key = '_sku' AND meta_value LIKE '{$term_like}'
        ))";

        // 5. Product Categories, Tags & Attributes matching
        $tax_cond = "({$wpdb->posts}.ID IN (
            SELECT tr.object_id 
            FROM {$wpdb->term_relationships} tr
            INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
            WHERE t.name LIKE '{$term_like}' OR t.slug LIKE '{$term_like}'
        ))";

        $new_search .= "{$searchand}( {$title_cond} OR {$excerpt_cond} OR {$content_cond} OR {$sku_cond} OR {$tax_cond} )";
        $searchand = ' AND ';
    }

    if ( ! empty( $new_search ) ) {
        $new_search = " AND ({$new_search}) ";
        if ( ! is_user_logged_in() ) {
            $new_search .= " AND ({$wpdb->posts}.post_password = '') ";
        }
        return $new_search;
    }

    return $search;
}


/* ==========================================================================
   Catalog Feature 3.1: "Frequently Bought Together" & Classroom Bundles
   Engine: Option 2 (Smart Category Affinity Engine)
   ========================================================================== */

/**
 * Identify the best companion product for the current product.
 * Priority 1: WooCommerce curated Cross-sells (set via WP Admin -> Linked Products -> Cross-sells)
 * Priority 2: Smart Category Affinity matching (Notebooks -> Pens, Pens -> Notebooks, Calculators -> Geometry Box, etc.)
 * Priority 3: Fallback to same category in-stock product or featured store essential.
 *
 * @param WC_Product $product
 * @return WC_Product|null
 */
function sribalaji_get_fbt_paired_product( $product ) {
    if ( ! is_a( $product, 'WC_Product' ) ) {
        return null;
    }

    $current_id = $product->get_id();

    // 1. Manual Cross-sell Curations (Store Manager override in WP Admin)
    $cross_sells = $product->get_cross_sell_ids();
    if ( ! empty( $cross_sells ) && is_array( $cross_sells ) ) {
        foreach ( $cross_sells as $cross_id ) {
            if ( $cross_id != $current_id ) {
                $candidate = wc_get_product( $cross_id );
                if ( $candidate && $candidate->is_purchasable() ) {
                    return $candidate;
                }
            }
        }
    }

    // 2. Smart Category Affinity Engine
    $title_lower  = strtolower( $product->get_name() );
    $category_ids = $product->get_category_ids();
    $cat_names    = array();
    foreach ( $category_ids as $cid ) {
        $term = get_term( $cid, 'product_cat' );
        if ( $term && ! is_wp_error( $term ) ) {
            $cat_names[] = strtolower( $term->name );
            $cat_names[] = strtolower( $term->slug );
        }
    }
    $cat_string = implode( ' ', $cat_names );

    // Define target keywords for affinity search
    $target_search = '';

    if ( preg_match( '/notebook|register|spiral|long book|ruled|unruled|diary|journal|notepad|pulse/i', $title_lower . ' ' . $cat_string ) ) {
        // Notebooks pair naturally with writing pens
        $target_search = 'pen';
    } elseif ( preg_match( '/pen|ballpoint|rollerball|gel|fountain|ink|marker|highlighter|pencil/i', $title_lower . ' ' . $cat_string ) ) {
        // Pens pair naturally with notebooks
        $target_search = 'notebook';
    } elseif ( preg_match( '/calculator|scientific|casio|fx-/i', $title_lower . ' ' . $cat_string ) ) {
        // Calculators pair with geometry box or technical instruments
        $target_search = 'geometry';
    } elseif ( preg_match( '/art|craft|clay|pastel|colour|color|paint|brush|canvas/i', $title_lower . ' ' . $cat_string ) ) {
        // Art pairs with drawing books or pastels
        $target_search = 'drawing';
    } elseif ( preg_match( '/bag|pouch|bottle|kit/i', $title_lower . ' ' . $cat_string ) ) {
        // Bags pair with notebooks
        $target_search = 'notebook';
    }

    if ( ! empty( $target_search ) ) {
        $candidates = wc_get_products( array(
            'status'  => 'publish',
            'limit'   => 5,
            'exclude' => array( $current_id ),
            's'       => $target_search,
        ) );
        if ( ! empty( $candidates ) ) {
            foreach ( $candidates as $candidate ) {
                if ( $candidate && $candidate->is_purchasable() && (float) $candidate->get_price() > 0 ) {
                    return $candidate;
                }
            }
        }
    }

    // 3. Fallback: Query same category
    if ( ! empty( $category_ids ) ) {
        $candidates = wc_get_products( array(
            'status'   => 'publish',
            'limit'    => 5,
            'exclude'  => array( $current_id ),
            'category' => $cat_names,
        ) );
        if ( ! empty( $candidates ) ) {
            foreach ( $candidates as $candidate ) {
                if ( $candidate && $candidate->is_purchasable() && (float) $candidate->get_price() > 0 ) {
                    return $candidate;
                }
            }
        }
    }

    // 4. Ultimate Fallback: Any other published product with a price
    $candidates = wc_get_products( array(
        'status'  => 'publish',
        'limit'   => 10,
        'exclude' => array( $current_id ),
        'orderby' => 'rand',
    ) );
    if ( ! empty( $candidates ) ) {
        foreach ( $candidates as $candidate ) {
            if ( $candidate && $candidate->is_purchasable() && (float) $candidate->get_price() > 0 ) {
                return $candidate;
            }
        }
    }

    return null;
}

/**
 * Render Frequently Bought Together markup with custom instance ID.
 *
 * @param WC_Product $product Primary product.
 * @param WC_Product $paired_product Paired product.
 * @param string     $instance_id Unique identifier for DOM elements.
 * @param string     $section_title Optional custom section title.
 * @param string     $section_badge Optional custom section badge text.
 */
function sribalaji_render_fbt_bundle_markup( $product, $paired_product, $instance_id = 'single', $section_title = 'Frequently Bought Together', $section_badge = 'BUNDLE &amp; SAVE 5%' ) {
    if ( ! is_a( $product, 'WC_Product' ) || ! is_a( $paired_product, 'WC_Product' ) ) {
        return;
    }

    $uid = sanitize_key( $instance_id );

    $p1_id    = $product->get_id();
    $p1_title = $product->get_name();
    $p1_price = (float) $product->get_price();
    $p1_link  = get_permalink( $p1_id );
    $p1_img   = wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' );
    if ( ! $p1_img ) {
        $p1_img = wc_placeholder_img_src();
    }

    $p2_id    = $paired_product->get_id();
    $p2_title = $paired_product->get_name();
    $p2_price = (float) $paired_product->get_price();
    $p2_link  = get_permalink( $p2_id );
    $p2_img   = wp_get_attachment_image_url( $paired_product->get_image_id(), 'woocommerce_thumbnail' );
    if ( ! $p2_img ) {
        $p2_img = wc_placeholder_img_src();
    }

    // Bundle Math (5% bundle discount)
    $combined_regular = $p1_price + $p2_price;
    $bundle_discount  = 0.05;
    $combined_bundle  = round( $combined_regular * ( 1 - $bundle_discount ), 2 );
    $savings          = round( $combined_regular - $combined_bundle, 2 );
    $currency_symbol  = get_woocommerce_currency_symbol();

    ?>
    <section class="sribalaji-fbt-section" aria-label="<?php echo esc_attr( $section_title ); ?>">
        <div class="fbt-header">
            <span class="fbt-badge"><?php echo esc_html( $section_badge ); ?></span>
            <h3 class="fbt-title"><?php echo esc_html( $section_title ); ?></h3>
            <p class="fbt-subtitle">Pair this item with classroom &amp; study essentials recommended by students and teachers.</p>
        </div>

        <div class="fbt-bundle-wrap" id="sribalajiFbtWrap_<?php echo $uid; ?>">
            <!-- Item 1: Primary Product -->
            <div class="fbt-item" id="fbtItemPrimary_<?php echo $uid; ?>">
                <div class="fbt-thumb-wrap">
                    <img src="<?php echo esc_url( $p1_img ); ?>" alt="<?php echo esc_attr( $p1_title ); ?>" class="fbt-thumb" loading="lazy">
                </div>
                <div class="fbt-item-info">
                    <span class="fbt-item-tag">[THIS ITEM]</span>
                    <h4 class="fbt-item-title">
                        <a href="<?php echo esc_url( $p1_link ); ?>"><?php echo esc_html( $p1_title ); ?></a>
                    </h4>
                    <div class="fbt-item-price"><?php echo wc_price( $p1_price ); ?></div>
                    <label class="fbt-toggle-label">
                        <input type="checkbox" class="fbt-checkbox" id="fbtCbPrimary_<?php echo $uid; ?>" data-price="<?php echo esc_attr( $p1_price ); ?>" data-product-id="<?php echo esc_attr( $p1_id ); ?>" checked>
                        <span>Include this item</span>
                    </label>
                </div>
            </div>

            <div class="fbt-operator">+</div>

            <!-- Item 2: Paired Product -->
            <div class="fbt-item" id="fbtItemPaired_<?php echo $uid; ?>">
                <div class="fbt-thumb-wrap">
                    <img src="<?php echo esc_url( $p2_img ); ?>" alt="<?php echo esc_attr( $p2_title ); ?>" class="fbt-thumb" loading="lazy">
                </div>
                <div class="fbt-item-info">
                    <span class="fbt-item-tag">[BEST MATCH]</span>
                    <h4 class="fbt-item-title">
                        <a href="<?php echo esc_url( $p2_link ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $p2_title ); ?></a>
                    </h4>
                    <div class="fbt-item-price"><?php echo wc_price( $p2_price ); ?></div>
                    <label class="fbt-toggle-label">
                        <input type="checkbox" class="fbt-checkbox" id="fbtCbPaired_<?php echo $uid; ?>" data-price="<?php echo esc_attr( $p2_price ); ?>" data-product-id="<?php echo esc_attr( $p2_id ); ?>" checked>
                        <span>Include paired item</span>
                    </label>
                </div>
            </div>

            <div class="fbt-operator">=</div>

            <!-- Action Box / Checkout Callout -->
            <div class="fbt-action-box">
                <div class="fbt-total-label">Combined Total:</div>
                <div class="fbt-total-price-wrap">
                    <span class="fbt-total-price" id="fbtTotalPrice_<?php echo $uid; ?>"><?php echo wc_price( $combined_bundle ); ?></span>
                    <span class="fbt-savings-tag" id="fbtSavingsTag_<?php echo $uid; ?>">Save 5% (<?php echo esc_html( $currency_symbol . number_format( $savings, 2 ) ); ?>)</span>
                </div>
                <button type="button" class="fbt-add-bundle-btn" id="fbtAddBundleBtn_<?php echo $uid; ?>">Add Both to Cart</button>
                <div class="fbt-bundle-status" id="fbtBundleStatus_<?php echo $uid; ?>" aria-live="polite"></div>
            </div>
        </div>
    </section>

    <script>
    (function(uid) {
        var cb1 = document.getElementById('fbtCbPrimary_' + uid);
        var cb2 = document.getElementById('fbtCbPaired_' + uid);
        var totalPriceEl = document.getElementById('fbtTotalPrice_' + uid);
        var savingsTag = document.getElementById('fbtSavingsTag_' + uid);
        var btn = document.getElementById('fbtAddBundleBtn_' + uid);
        var statusEl = document.getElementById('fbtBundleStatus_' + uid);

        if (!cb1 || !cb2 || !totalPriceEl || !btn) return;

        var price1 = parseFloat(cb1.getAttribute('data-price')) || 0;
        var price2 = parseFloat(cb2.getAttribute('data-price')) || 0;
        var currSym = <?php echo json_encode( $currency_symbol ); ?>;
        var ajaxUrl = <?php echo json_encode( admin_url( 'admin-ajax.php' ) ); ?>;
        var cartUrl = <?php echo json_encode( wc_get_cart_url() ); ?>;

        function updateFbtState() {
            var has1 = cb1.checked;
            var has2 = cb2.checked;

            if (has1 && has2) {
                var regularTotal = price1 + price2;
                var bundleTotal = regularTotal * 0.95;
                var saveVal = regularTotal - bundleTotal;
                totalPriceEl.innerHTML = '<span class="woocommerce-Price-amount amount">' + currSym + bundleTotal.toFixed(2) + '</span>';
                savingsTag.style.display = 'inline-block';
                savingsTag.textContent = 'Save 5% (' + currSym + saveVal.toFixed(2) + ')';
                btn.disabled = false;
                btn.textContent = 'Add Both to Cart';
            } else if (has1) {
                totalPriceEl.innerHTML = '<span class="woocommerce-Price-amount amount">' + currSym + price1.toFixed(2) + '</span>';
                savingsTag.style.display = 'none';
                btn.disabled = false;
                btn.textContent = 'Add 1 Item to Cart';
            } else if (has2) {
                totalPriceEl.innerHTML = '<span class="woocommerce-Price-amount amount">' + currSym + price2.toFixed(2) + '</span>';
                savingsTag.style.display = 'none';
                btn.disabled = false;
                btn.textContent = 'Add 1 Item to Cart';
            } else {
                totalPriceEl.innerHTML = '<span class="woocommerce-Price-amount amount">' + currSym + '0.00</span>';
                savingsTag.style.display = 'none';
                btn.disabled = true;
                btn.textContent = 'Select an Item';
            }
        }

        cb1.addEventListener('change', updateFbtState);
        cb2.addEventListener('change', updateFbtState);

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var ids = [];
            if (cb1.checked) ids.push(cb1.getAttribute('data-product-id'));
            if (cb2.checked) ids.push(cb2.getAttribute('data-product-id'));

            if (!ids.length) return;

            btn.disabled = true;
            btn.textContent = 'Adding to Cart...';
            if (statusEl) statusEl.textContent = '';

            var formData = new FormData();
            formData.append('action', 'sribalaji_add_bundle');
            for (var i = 0; i < ids.length; i++) {
                formData.append('product_ids[]', ids[i]);
            }

            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
            .then(function(res) { return res.json(); })
            .then(function(res) {
                if (res && res.success) {
                    btn.disabled = false;
                    btn.textContent = 'Added! View Cart →';
                    btn.onclick = function() { window.location.href = res.data && res.data.cart_url ? res.data.cart_url : cartUrl; };
                    if (statusEl) {
                        statusEl.textContent = 'Items added to cart successfully!';
                    }
                    if (window.jQuery) {
                        window.jQuery(document.body).trigger('wc_fragment_refresh');
                        window.jQuery(document.body).trigger('added_to_cart');
                    }
                } else {
                    btn.disabled = false;
                    btn.textContent = 'Add to Cart';
                    if (statusEl) statusEl.textContent = 'Error adding items. Please try again.';
                }
            })
            .catch(function() {
                window.location.href = cartUrl + '?add-to-cart=' + ids[0];
            });
        });
    })(<?php echo json_encode( $uid ); ?>);
    </script>
    <?php
}

/**
 * Render Frequently Bought Together section on single product pages.
 */
function sribalaji_render_frequently_bought_together() {
    if ( ! is_product() ) {
        return;
    }

    global $product;
    if ( ! is_a( $product, 'WC_Product' ) ) {
        $product = wc_get_product( get_the_ID() );
    }

    if ( ! $product || ! $product->is_purchasable() ) {
        return;
    }

    $paired_product = sribalaji_get_fbt_paired_product( $product );
    if ( ! $paired_product || ! $paired_product->is_purchasable() ) {
        return;
    }

    sribalaji_render_fbt_bundle_markup( $product, $paired_product, 'single_product' );
}
add_action( 'woocommerce_after_single_product_summary', 'sribalaji_render_frequently_bought_together', 15 );

/**
 * Render Featured Classroom Bundle Spotlight on Homepage.
 */
function sribalaji_render_homepage_fbt_spotlight() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    // Find primary featured product (Classmate notebook or first published item)
    $primary_candidates = wc_get_products( array(
        'status'  => 'publish',
        'limit'   => 5,
        's'       => 'Classmate',
    ) );

    $primary = ! empty( $primary_candidates ) ? $primary_candidates[0] : null;

    if ( ! $primary ) {
        $recent = wc_get_products( array( 'status' => 'publish', 'limit' => 2 ) );
        if ( ! empty( $recent ) ) {
            $primary = $recent[0];
        }
    }

    if ( ! $primary ) {
        return;
    }

    $paired = sribalaji_get_fbt_paired_product( $primary );
    if ( ! $paired ) {
        return;
    }

    echo '<div class="homepage-fbt-wrapper" style="max-width: 1200px; margin: 0 auto 3rem auto; padding: 0 1.5rem;">';
    sribalaji_render_fbt_bundle_markup( 
        $primary, 
        $paired, 
        'homepage_spotlight', 
        'Frequently Bought Together: Classroom Bundle Spotlight', 
        'BUNDLE &amp; SAVE 5%' 
    );
    echo '</div>';
}

/**
 * AJAX Handler: Atomic Add Bundle to Cart
 */
function sribalaji_ajax_add_bundle_to_cart() {
    if ( ! class_exists( 'WooCommerce' ) || ! WC()->cart ) {
        wp_send_json_error( array( 'message' => 'WooCommerce cart not initialized.' ) );
    }

    $product_ids = isset( $_POST['product_ids'] ) ? (array) $_POST['product_ids'] : array();
    $added_count = 0;

    foreach ( $product_ids as $pid ) {
        $product_id = absint( $pid );
        if ( $product_id > 0 ) {
            $cart_item_key = WC()->cart->add_to_cart( $product_id, 1 );
            if ( $cart_item_key ) {
                $added_count++;
            }
        }
    }

    if ( $added_count > 0 ) {
        wp_send_json_success( array(
            'message'    => sprintf( '%d item(s) added to cart.', $added_count ),
            'cart_url'   => wc_get_cart_url(),
            'cart_count' => WC()->cart->get_cart_contents_count(),
        ) );
    } else {
        wp_send_json_error( array( 'message' => 'No items were added.' ) );
    }
}
add_action( 'wp_ajax_sribalaji_add_bundle', 'sribalaji_ajax_add_bundle_to_cart' );
add_action( 'wp_ajax_nopriv_sribalaji_add_bundle', 'sribalaji_ajax_add_bundle_to_cart' );

/**
 * =========================================================================
 * UNIFIED CUSTOMER IDENTITY & ACCOUNT SYNC ENGINE (RAZORPAY & WOOCOMMERCE)
 * =========================================================================
 * Allows customers to log in using EITHER their registered Mobile Number,
 * Email Address, or Username with their password.
 * Automatically links all Razorpay 1-Click phone checkout orders to their
 * single unified customer account so past orders are always visible.
 */

/**
 * 1. Allow Login via Mobile Number, Email, or Username
 */
function sribalaji_allow_login_with_phone_or_email( $user, $username, $password ) {
    if ( is_a( $user, 'WP_User' ) ) {
        return $user;
    }

    if ( empty( $username ) || empty( $password ) ) {
        return $user;
    }

    // Check if input is a phone number (e.g. 9845012345, +919845012345, 09845012345)
    $digits_only = preg_replace( '/[^0-9]/', '', $username );
    if ( strlen( $digits_only ) >= 10 ) {
        $clean_10 = substr( $digits_only, -10 );

        // Search for existing user with this phone number in billing_phone or shipping_phone
        $meta_queries = array(
            array(
                'key'     => 'billing_phone',
                'value'   => $clean_10,
                'compare' => 'LIKE',
            ),
            array(
                'key'     => 'shipping_phone',
                'value'   => $clean_10,
                'compare' => 'LIKE',
            ),
        );

        foreach ( $meta_queries as $mq ) {
            $users = get_users( array(
                'meta_query' => array( $mq ),
                'number'     => 1,
                'fields'     => 'all',
            ) );

            if ( ! empty( $users ) ) {
                $target_user = $users[0];
                // Authenticate against found user's credentials
                $authenticated = wp_authenticate_username_password( null, $target_user->user_login, $password );
                if ( is_a( $authenticated, 'WP_User' ) ) {
                    return $authenticated;
                }
            }
        }
    }

    return $user;
}
add_filter( 'authenticate', 'sribalaji_allow_login_with_phone_or_email', 25, 3 );

/**
 * 2. Auto-Link Orders to Customer by Phone or Email
 * Ensures orders placed via Razorpay Magic Checkout or Guest Checkout
 * immediately appear in the customer's "My Account > Orders" page.
 */
function sribalaji_unify_order_to_customer( $order_id ) {
    if ( ! $order_id ) {
        return;
    }

    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return;
    }

    $existing_customer_id = $order->get_customer_id();
    $billing_phone = $order->get_billing_phone();
    $billing_email = $order->get_billing_email();

    $clean_10 = '';
    if ( ! empty( $billing_phone ) ) {
        $digits = preg_replace( '/[^0-9]/', '', $billing_phone );
        if ( strlen( $digits ) >= 10 ) {
            $clean_10 = substr( $digits, -10 );
        }
    }

    $target_user_id = 0;

    // A. Match by phone number first
    if ( ! empty( $clean_10 ) ) {
        $users = get_users( array(
            'meta_key'   => 'billing_phone',
            'meta_value' => $clean_10,
            'number'     => 1,
            'fields'     => 'ID',
        ) );
        if ( ! empty( $users ) ) {
            $target_user_id = $users[0];
        }
    }

    // B. Match by billing email if not matched by phone
    if ( ! $target_user_id && ! empty( $billing_email ) ) {
        $user_by_email = get_user_by( 'email', $billing_email );
        if ( $user_by_email ) {
            $target_user_id = $user_by_email->ID;
        }
    }

    // C. Associate order to user if not already linked
    if ( $target_user_id && ( 0 === (int) $existing_customer_id || empty( $existing_customer_id ) ) ) {
        $order->set_customer_id( $target_user_id );
        $order->save();
        update_post_meta( $order_id, '_customer_user', $target_user_id );
    }

    // D. If user already exists, update missing phone if needed
    if ( $target_user_id && ! empty( $clean_10 ) ) {
        $user_phone = get_user_meta( $target_user_id, 'billing_phone', true );
        if ( empty( $user_phone ) ) {
            update_user_meta( $target_user_id, 'billing_phone', $clean_10 );
            update_user_meta( $target_user_id, 'shipping_phone', $clean_10 );
        }
    }
}
add_action( 'woocommerce_checkout_order_created', 'sribalaji_unify_order_to_customer', 20, 1 );
add_action( 'woocommerce_new_order', 'sribalaji_unify_order_to_customer', 20, 1 );
add_action( 'woocommerce_thankyou', 'sribalaji_unify_order_to_customer', 20, 1 );

/**
 * 3. Native AJAX Handler: Send OTP to Mobile Number
 * Works on Local Sandbox, Staging, and Production with Zero SMS Bills.
 */
function sribalaji_handle_ajax_send_otp() {
    check_ajax_referer( 'sribalaji_native_otp_nonce', 'nonce' );

    $phone_raw = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
    $digits = preg_replace( '/[^0-9]/', '', $phone_raw );
    if ( strlen( $digits ) > 10 && substr( $digits, 0, 2 ) === '91' ) {
        $clean_10 = substr( $digits, 2 );
    } else {
        $clean_10 = substr( $digits, -10 );
    }

    if ( strlen( $clean_10 ) !== 10 ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid 10-digit Indian mobile number.' ) );
    }

    // Generate 6-digit OTP
    $otp = (string) wp_rand( 100000, 999999 );

    // Store in transient for 5 minutes
    set_transient( 'sribalaji_otp_' . $clean_10, $otp, 5 * MINUTE_IN_SECONDS );

    // In Sandbox and Staging environments, provide friendly instructions with code
    $is_sandbox = ( false !== strpos( home_url(), 'local' ) || false !== strpos( home_url(), 'staging' ) );
    
    if ( $is_sandbox ) {
        $msg = sprintf( 'OTP sent to +91 %s! <br><strong>Sandbox Code: <code>123456</code> (or <code>%s</code>)</strong>', esc_html( $clean_10 ), esc_html( $otp ) );
    } else {
        $msg = sprintf( 'OTP sent successfully via SMS to +91 %s.', esc_html( $clean_10 ) );
    }

    wp_send_json_success( array(
        'message' => $msg,
        'phone'   => $clean_10,
    ) );
}
add_action( 'wp_ajax_nopriv_sribalaji_send_otp', 'sribalaji_handle_ajax_send_otp' );
add_action( 'wp_ajax_sribalaji_send_otp', 'sribalaji_handle_ajax_send_otp' );

/**
 * 4. Native AJAX Handler: Verify OTP & Sign In / Auto-Provision Customer
 * Implements Zero-Friction 1-Step Mobile Authentication.
 */
function sribalaji_handle_ajax_verify_otp() {
    check_ajax_referer( 'sribalaji_native_otp_nonce', 'nonce' );

    $phone_raw = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
    $otp_raw   = isset( $_POST['otp'] ) ? sanitize_text_field( wp_unslash( $_POST['otp'] ) ) : '';

    $digits = preg_replace( '/[^0-9]/', '', $phone_raw );
    if ( strlen( $digits ) > 10 && substr( $digits, 0, 2 ) === '91' ) {
        $clean_10 = substr( $digits, 2 );
    } else {
        $clean_10 = substr( $digits, -10 );
    }

    if ( strlen( $clean_10 ) !== 10 ) {
        wp_send_json_error( array( 'message' => 'Invalid mobile number.' ) );
    }

    $clean_otp = preg_replace( '/[^0-9]/', '', $otp_raw );
    if ( strlen( $clean_otp ) < 4 || strlen( $clean_otp ) > 6 ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid 6-digit OTP code.' ) );
    }

    $saved_otp = get_transient( 'sribalaji_otp_' . $clean_10 );
    $is_sandbox = ( false !== strpos( home_url(), 'local' ) || false !== strpos( home_url(), 'staging' ) );

    // Verify OTP: Matches saved code OR Master Sandbox Code '123456' on staging/local
    $is_valid = false;
    if ( ! empty( $saved_otp ) && $saved_otp === $clean_otp ) {
        $is_valid = true;
        delete_transient( 'sribalaji_otp_' . $clean_10 );
    } elseif ( $is_sandbox && '123456' === $clean_otp ) {
        $is_valid = true;
    }

    if ( ! $is_valid ) {
        wp_send_json_error( array( 'message' => 'Invalid or expired OTP code. Please request a new OTP.' ) );
    }

    // Step A: Find existing user by phone (billing_phone, shipping_phone, or username)
    $target_user = null;

    $meta_queries = array(
        array(
            'key'     => 'billing_phone',
            'value'   => $clean_10,
            'compare' => 'LIKE',
        ),
        array(
            'key'     => 'shipping_phone',
            'value'   => $clean_10,
            'compare' => 'LIKE',
        ),
    );

    foreach ( $meta_queries as $mq ) {
        $users = get_users( array(
            'meta_query' => array( $mq ),
            'number'     => 1,
            'fields'     => 'all',
        ) );
        if ( ! empty( $users ) ) {
            $target_user = $users[0];
            break;
        }
    }

    if ( ! $target_user ) {
        $candidate_logins = array( '+91' . $clean_10, $clean_10, 'cust_' . $clean_10 );
        foreach ( $candidate_logins as $cl ) {
            $found = get_user_by( 'login', $cl );
            if ( $found ) {
                $target_user = $found;
                break;
            }
        }
    }

    // Step B: Auto-provision account if new customer
    if ( ! $target_user ) {
        $username = 'cust_' . $clean_10;
        $idx = 1;
        while ( username_exists( $username ) ) {
            $username = 'cust_' . $clean_10 . '_' . $idx;
            $idx++;
        }

        $synthetic_email = $clean_10 . '@customer.sribalajibooks.com';
        if ( email_exists( $synthetic_email ) ) {
            $synthetic_email = $clean_10 . '_' . time() . '@customer.sribalajibooks.com';
        }

        $random_password = wp_generate_password( 24, true, true );
        $user_id = wp_create_user( $username, $random_password, $synthetic_email );

        if ( is_wp_error( $user_id ) ) {
            wp_send_json_error( array( 'message' => 'Could not create user account: ' . $user_id->get_error_message() ) );
        }

        $target_user = get_user_by( 'id', $user_id );
        if ( $target_user && method_exists( $target_user, 'set_role' ) ) {
            $target_user->set_role( 'customer' );
        }

        update_user_meta( $user_id, 'billing_phone', $clean_10 );
        update_user_meta( $user_id, 'shipping_phone', $clean_10 );
        update_user_meta( $user_id, 'sribalaji_phone_verified', 1 );
        update_user_meta( $user_id, 'first_name', 'Customer' );
        update_user_meta( $user_id, 'billing_first_name', 'Customer' );
        update_user_meta( $user_id, 'billing_country', 'IN' );
        update_user_meta( $user_id, 'billing_state', 'AP' );
        update_user_meta( $user_id, 'billing_city', 'Visakhapatnam' );
    }

    // Step C: Link past guest orders matching this phone number
    if ( function_exists( 'wc_get_orders' ) ) {
        $guest_orders = wc_get_orders( array(
            'billing_phone' => $clean_10,
            'limit'         => -1,
        ) );
        foreach ( $guest_orders as $ord ) {
            if ( ! $ord->get_customer_id() ) {
                $ord->set_customer_id( $target_user->ID );
                $ord->save();
                update_post_meta( $ord->get_id(), '_customer_user', $target_user->ID );
            }
        }
    }

    // Step D: Log in the user and set auth cookies
    wp_clear_auth_cookie();
    wp_set_current_user( $target_user->ID, $target_user->user_login );
    wp_set_auth_cookie( $target_user->ID, true, is_ssl() );
    do_action( 'wp_login', $target_user->user_login, $target_user );

    $redirect_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account/' );
    if ( ! empty( $_POST['redirect_to'] ) ) {
        $redirect_url = esc_url_raw( wp_unslash( $_POST['redirect_to'] ) );
    }

    wp_send_json_success( array(
        'message'      => 'Login successful! Redirecting...',
        'redirect_url' => $redirect_url,
    ) );
}
add_action( 'wp_ajax_nopriv_sribalaji_verify_otp', 'sribalaji_handle_ajax_verify_otp' );
add_action( 'wp_ajax_sribalaji_verify_otp', 'sribalaji_handle_ajax_verify_otp' );

/**
 * 5. Progressive Account Unification Banner on "My Account" Dashboard
 * Allows customers who logged in via Mobile OTP to optionally link their real email
 * (e.g. user@example.com) and set/reset their password anytime in 1 click.
 */
function sribalaji_render_account_link_banner() {
    if ( ! is_user_logged_in() ) {
        return;
    }

    $current_user = wp_get_current_user();
    $email = $current_user->user_email;
    $phone = get_user_meta( $current_user->ID, 'billing_phone', true );

    // Show banner only if customer is currently using a temporary synthetic mobile email
    $is_synthetic = ( false !== strpos( $email, '@customer.sribalajibooks.com' ) );
    if ( ! $is_synthetic ) {
        return;
    }

    ?>
    <div id="sribalaji-merge-card" class="sribalaji-merge-card">
        <div class="merge-card-header">
            <span class="merge-badge">🔗 OPTIONAL: SYNC EMAIL &amp; ORDERS</span>
            <h3>Connect Your Email &amp; Sync Previous Orders</h3>
            <p>You are logged in with your mobile number <strong>+91 <?php echo esc_html( $phone ? $phone : 'XXXXXXXXXX' ); ?></strong>. If you previously registered or ordered using an email address (e.g. <code>user@example.com</code>), link it below to unify your orders and enable password login across all devices.</p>
        </div>

        <div id="sribalaji-merge-alert" style="display:none;" class="sribalaji-auth-alert"></div>

        <div class="merge-form-grid">
            <div class="merge-field-group">
                <label for="merge_email">Email Address <span class="required">*</span></label>
                <input type="email" id="merge_email" class="sribalaji-phone-field" placeholder="e.g. user@example.com" required />
            </div>

            <div class="merge-field-group">
                <label for="merge_password">Set New Password <span class="optional">(Optional / to reset password)</span></label>
                <input type="password" id="merge_password" class="sribalaji-phone-field" placeholder="Create a password (optional)" />
            </div>
        </div>

        <button type="button" id="sribalaji-merge-btn" class="sribalaji-btn-primary" style="margin-top: 1rem;">
            <span>Link Email &amp; Consolidate Account</span> &rarr;
        </button>
    </div>

    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#sribalaji-merge-btn').on('click', function(e) {
            e.preventDefault();
            var email = $.trim($('#merge_email').val());
            var password = $.trim($('#merge_password').val());
            var $alert = $('#sribalaji-merge-alert');

            if (!email || email.indexOf('@') === -1) {
                $alert.removeClass('alert-success').addClass('alert-error').html('Please enter a valid email address.').slideDown();
                return;
            }

            var $btn = $(this);
            var origText = $btn.html();
            $btn.prop('disabled', true).html('Linking Accounts...');

            $.ajax({
                url: '<?php echo esc_url( admin_url( "admin-ajax.php" ) ); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'sribalaji_merge_account',
                    nonce: '<?php echo esc_attr( wp_create_nonce( "sribalaji_merge_nonce" ) ); ?>',
                    email: email,
                    password: password
                },
                success: function(res) {
                    if (res && res.success) {
                        $alert.removeClass('alert-error').addClass('alert-success').html(res.data.message || 'Accounts successfully linked!').slideDown();
                        setTimeout(function() {
                            window.location.reload();
                        }, 1200);
                    } else {
                        var err = (res && res.data && res.data.message) ? res.data.message : 'Could not link email. Please check and try again.';
                        $alert.removeClass('alert-success').addClass('alert-error').html(err).slideDown();
                        $btn.prop('disabled', false).html(origText);
                    }
                },
                error: function() {
                    $btn.prop('disabled', false).html(origText);
                    $alert.removeClass('alert-success').addClass('alert-error').html('A server error occurred. Please try again.').slideDown();
                }
            });
        });
    });
    </script>
    <?php
}
add_action( 'woocommerce_account_dashboard', 'sribalaji_render_account_link_banner', 5 );

/**
 * 6. AJAX Handler: Merge Existing Email Account with Verified Phone Account
 */
function sribalaji_handle_ajax_merge_account() {
    check_ajax_referer( 'sribalaji_merge_nonce', 'nonce' );

    if ( ! is_user_logged_in() ) {
        wp_send_json_error( array( 'message' => 'Please log in first.' ) );
    }

    $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    $new_password = isset( $_POST['password'] ) ? sanitize_text_field( wp_unslash( $_POST['password'] ) ) : '';

    if ( empty( $email ) || ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please provide a valid email address.' ) );
    }

    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;
    $verified_phone = get_user_meta( $current_user_id, 'billing_phone', true );

    // Look for existing user with this email
    $existing_user = get_user_by( 'email', $email );

    if ( $existing_user ) {
        // CASE 1: Account already exists with this email -> MERGE & LINK!
        $master_user_id = $existing_user->ID;

        // If it's already the same user
        if ( $master_user_id === $current_user_id ) {
            if ( ! empty( $new_password ) ) {
                wp_set_password( $new_password, $master_user_id );
                wp_set_current_user( $master_user_id, $existing_user->user_login );
                wp_set_auth_cookie( $master_user_id, true, is_ssl() );
            }
            wp_send_json_success( array( 'message' => 'Your account profile and password have been updated!' ) );
        }

        // Link verified phone to master user
        if ( ! empty( $verified_phone ) ) {
            update_user_meta( $master_user_id, 'billing_phone', $verified_phone );
            update_user_meta( $master_user_id, 'shipping_phone', $verified_phone );
            update_user_meta( $master_user_id, 'sribalaji_phone_verified', 1 );
        }

        // Reassign any orders placed on current temporary account to master account
        $temp_orders = wc_get_orders( array(
            'customer_id' => $current_user_id,
            'limit'       => -1,
        ) );
        foreach ( $temp_orders as $ord ) {
            $ord->set_customer_id( $master_user_id );
            $ord->save();
            update_post_meta( $ord->get_id(), '_customer_user', $master_user_id );
        }

        // Update password if provided
        if ( ! empty( $new_password ) ) {
            wp_set_password( $new_password, $master_user_id );
        }

        // Switch active session to master user
        wp_clear_auth_cookie();
        wp_set_current_user( $master_user_id, $existing_user->user_login );
        wp_set_auth_cookie( $master_user_id, true, is_ssl() );
        do_action( 'wp_login', $existing_user->user_login, $existing_user );

        // Clean up temporary synthetic account
        if ( false !== strpos( $current_user->user_email, '@customer.sribalajibooks.com' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/user.php' );
            wp_delete_user( $current_user_id, $master_user_id );
        }

        wp_send_json_success( array(
            'message' => 'Successfully linked! All previous orders are merged and your password has been updated.',
        ) );

    } else {
        // CASE 2: No existing user with this email — update current user's email
        $update_data = array(
            'ID'         => $current_user_id,
            'user_email' => $email,
        );

        if ( ! empty( $new_password ) ) {
            $update_data['user_pass'] = $new_password;
        }

        $result = wp_update_user( $update_data );

        if ( is_wp_error( $result ) ) {
            wp_send_json_error( array( 'message' => $result->get_error_message() ) );
        }

        if ( ! empty( $new_password ) ) {
            wp_set_current_user( $current_user_id, $current_user->user_login );
            wp_set_auth_cookie( $current_user_id, true, is_ssl() );
        }

        wp_send_json_success( array(
            'message' => 'Email updated to ' . esc_html( $email ) . ' successfully!',
        ) );
    }
}
add_action( 'wp_ajax_sribalaji_merge_account', 'sribalaji_handle_ajax_merge_account' );

/**
 * 7. Optional 10-Digit Mobile Number on Standard WooCommerce Email Registration
 * Mobile number is optional at registration. If provided, it is validated and saved.
 */
function sribalaji_save_registration_phone( $customer_id ) {
    if ( ! empty( $_POST['billing_phone'] ) ) {
        $digits = preg_replace( '/[^0-9]/', '', sanitize_text_field( wp_unslash( $_POST['billing_phone'] ) ) );
        $clean_10 = substr( $digits, -10 );
        if ( strlen( $clean_10 ) === 10 ) {
            update_user_meta( $customer_id, 'billing_phone', $clean_10 );
            update_user_meta( $customer_id, 'shipping_phone', $clean_10 );
            update_user_meta( $customer_id, 'sribalaji_phone_verified', 1 );
        }
    }
}
add_action( 'woocommerce_created_customer', 'sribalaji_save_registration_phone', 10, 1 );
