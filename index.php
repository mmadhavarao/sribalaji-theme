<?php
/**
 * Main Index Template - Sri Balaji Books & Stationery Storefront
 *
 * @package SriBalajiTheme
 */

get_header(); ?>

<main class="site-main">

    <!-- Blinkit / Zepto Quick-Commerce Feed for Mobile & Tablet -->
    <div class="mobile-quick-commerce-feed" id="mobileQuickCommerceFeed">
        <?php
        $img_dir = get_template_directory_uri() . '/images/';

        // Define the 5 approved categories
        $categories_feed = array(
            'notebooks' => array(
                'id'       => 'notebooks',
                'title'    => 'Notebooks & Registers',
                'icon'     => '📓',
                'count'    => '28 items',
                'slugs'    => array( 'notebooks', 'notebooks-registers', 'stationery', 'books-notebooks', 'paper-registers' ),
                'url'      => sribalaji_get_category_url( array( 'notebooks', 'notebooks-registers', 'stationery', 'books-notebooks', 'paper-registers' ), 'Notebooks & Registers' ),
                'products' => array(
                    array(
                        'id'       => 101,
                        'title'    => 'Classmate Pulse Spiral Notebook A5',
                        'pack'     => '300 pgs',
                        'price'    => '₹126',
                        'mrp'      => '₹140',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-1.jpg',
                    ),
                    array(
                        'id'       => 102,
                        'title'    => 'Classmate Long Exercise Notebook',
                        'pack'     => '172 pgs',
                        'price'    => '₹81',
                        'mrp'      => '₹90',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-8.jpg',
                    ),
                    array(
                        'id'       => 103,
                        'title'    => 'Paperkraft Premium Hardbound Journal',
                        'pack'     => '192 pgs',
                        'price'    => '₹225',
                        'mrp'      => '₹250',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-1.jpg',
                    ),
                    array(
                        'id'       => 104,
                        'title'    => 'Classmate Drawing Book Unruled',
                        'pack'     => '40 pgs',
                        'price'    => '₹63',
                        'mrp'      => '₹70',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-8.jpg',
                    ),
                    array(
                        'id'       => 105,
                        'title'    => 'Classmate Interleaf Practical Notebook',
                        'pack'     => '128 pgs',
                        'price'    => '₹95',
                        'mrp'      => '₹105',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-1.jpg',
                    ),
                ),
            ),
            'pens' => array(
                'id'       => 'pens',
                'title'    => 'Pens & Writing Instruments',
                'icon'     => '🖊️',
                'count'    => '35 items',
                'slugs'    => array( 'pens', 'pens-writing', 'writing-instruments', 'writing', 'pens-refills', 'pens-pencils', 'stationery' ),
                'url'      => sribalaji_get_category_url( array( 'pens', 'pens-writing', 'writing-instruments', 'writing', 'pens-refills', 'pens-pencils' ), 'Pens & Writing Instruments' ),
                'products' => array(
                    array(
                        'id'       => 201,
                        'title'    => 'Pilot Hi-Tecpoint V5 Rollerball Pen',
                        'pack'     => 'Single',
                        'price'    => '₹195',
                        'mrp'      => '',
                        'discount' => '',
                        'image'    => $img_dir . 'hero-product-2.jpg',
                    ),
                    array(
                        'id'       => 202,
                        'title'    => 'Reynolds 045 Fine Carbure Ball Pen',
                        'pack'     => 'Pack of 10',
                        'price'    => '₹90',
                        'mrp'      => '₹100',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'SCH-PEN-REY-045BLU.jpg',
                    ),
                    array(
                        'id'       => 203,
                        'title'    => 'Faber-Castell Textliner Highlighters',
                        'pack'     => 'Set of 5',
                        'price'    => '₹135',
                        'mrp'      => '₹150',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-3.jpg',
                    ),
                    array(
                        'id'       => 204,
                        'title'    => 'Pilot V7 Cartridge Rollerball Pen',
                        'pack'     => 'Single',
                        'price'    => '₹180',
                        'mrp'      => '₹200',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-2.jpg',
                    ),
                    array(
                        'id'       => 205,
                        'title'    => 'Reynolds Trimax Liquid Gel Pen Set',
                        'pack'     => 'Pack of 3',
                        'price'    => '₹162',
                        'mrp'      => '₹180',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'SCH-PEN-REY-TRIMBLU.jpg',
                    ),
                ),
            ),
            'art' => array(
                'id'       => 'art',
                'title'    => 'Art & Craft Supplies',
                'icon'     => '🎨',
                'count'    => '42 items',
                'slugs'    => array( 'art', 'art-craft', 'art-supplies', 'art-and-craft', 'arts-supplies', 'creative-art-and-craft', 'craft-supplies' ),
                'url'      => sribalaji_get_category_url( array( 'art', 'art-craft', 'art-supplies', 'art-and-craft', 'arts-supplies', 'creative-art-and-craft' ), 'Art & Craft Supplies' ),
                'products' => array(
                    array(
                        'id'       => 301,
                        'title'    => 'Faber-Castell Triangular Oil Pastels',
                        'pack'     => '24 Shades',
                        'price'    => '₹140',
                        'mrp'      => '₹155',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-3.jpg',
                    ),
                    array(
                        'id'       => 302,
                        'title'    => 'Camel Oil Pastels (10 Shades Set)',
                        'pack'     => '10 Shades',
                        'price'    => '₹65',
                        'mrp'      => '',
                        'discount' => '',
                        'image'    => $img_dir . 'hero-product-5.jpg',
                    ),
                    array(
                        'id'       => 303,
                        'title'    => 'Pidilite Fevicryl Acrylic Colors Kit',
                        'pack'     => '12 Shades',
                        'price'    => '₹225',
                        'mrp'      => '₹250',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-5.jpg',
                    ),
                    array(
                        'id'       => 304,
                        'title'    => 'Fevicol MR Squeezy Bottle Adhesive',
                        'pack'     => '100g',
                        'price'    => '₹45',
                        'mrp'      => '₹50',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-4.jpg',
                    ),
                    array(
                        'id'       => 305,
                        'title'    => 'Camlin Stretched Canvas Board 8x10',
                        'pack'     => '1 Piece',
                        'price'    => '₹99',
                        'mrp'      => '₹110',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-3.jpg',
                    ),
                ),
            ),
            'office' => array(
                'id'       => 'office',
                'title'    => 'Office & Filing Supplies',
                'icon'     => '📁',
                'count'    => '30 items',
                'slugs'    => array( 'office', 'office-supplies', 'office-files', 'filing', 'paper-registers' ),
                'url'      => sribalaji_get_category_url( array( 'office', 'office-supplies', 'office-files', 'filing' ), 'Office & Filing Supplies' ),
                'products' => array(
                    array(
                        'id'       => 401,
                        'title'    => 'Casio fx-82MS Scientific Calculator',
                        'pack'     => '2nd Gen',
                        'price'    => '₹545',
                        'mrp'      => '₹595',
                        'discount' => 'SAVE ₹50',
                        'image'    => $img_dir . 'hero-product-6.jpg',
                    ),
                    array(
                        'id'       => 402,
                        'title'    => 'Solo Executive Display Folder A4',
                        'pack'     => '20 Pockets',
                        'price'    => '₹135',
                        'mrp'      => '₹150',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-7.jpg',
                    ),
                    array(
                        'id'       => 403,
                        'title'    => 'Kangaro Stapler #10 & Pin Box Bundle',
                        'pack'     => 'Combo Pack',
                        'price'    => '₹90',
                        'mrp'      => '₹100',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-4.jpg',
                    ),
                    array(
                        'id'       => 404,
                        'title'    => '3M Scotch Magic Tape with Dispenser',
                        'pack'     => '1 Roll',
                        'price'    => '₹117',
                        'mrp'      => '₹130',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-6.jpg',
                    ),
                    array(
                        'id'       => 405,
                        'title'    => 'Post-it Sticky Notes Cube Yellow 3x3',
                        'pack'     => '100 Sheets',
                        'price'    => '₹90',
                        'mrp'      => '₹100',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-7.jpg',
                    ),
                ),
            ),
            'geometry' => array(
                'id'       => 'geometry',
                'title'    => 'School Kits & Geometry',
                'icon'     => '📐',
                'count'    => '24 items',
                'slugs'    => array( 'school', 'school-essentials', 'geometry', 'school-kits', 'bags-totes' ),
                'url'      => sribalaji_get_category_url( array( 'school', 'school-essentials', 'geometry', 'school-kits', 'bags-totes' ), 'School Kits & Geometry' ),
                'products' => array(
                    array(
                        'id'       => 501,
                        'title'    => 'Apsara Platinum Kit (Pencils & Scale)',
                        'pack'     => 'Complete Kit',
                        'price'    => '₹135',
                        'mrp'      => '₹150',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-4.jpg',
                    ),
                    array(
                        'id'       => 502,
                        'title'    => 'Doms Mathematical Drawing Instruments',
                        'pack'     => 'Tin Box',
                        'price'    => '₹144',
                        'mrp'      => '₹160',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-6.jpg',
                    ),
                    array(
                        'id'       => 503,
                        'title'    => 'Train 2-in-1 Sharpener & Eraser',
                        'pack'     => 'Single',
                        'price'    => '₹110',
                        'mrp'      => '',
                        'discount' => '',
                        'image'    => $img_dir . 'hero-product-4.jpg',
                    ),
                    array(
                        'id'       => 504,
                        'title'    => 'Sri Balaji Canvas School Tote Bag',
                        'pack'     => 'Heavy Duty',
                        'price'    => '₹119',
                        'mrp'      => '',
                        'discount' => '',
                        'image'    => $img_dir . 'hero-product-7.jpg',
                    ),
                    array(
                        'id'       => 505,
                        'title'    => 'Camlin Scholar Geometry Box Set',
                        'pack'     => 'Premium Set',
                        'price'    => '₹135',
                        'mrp'      => '₹150',
                        'discount' => '10% OFF',
                        'image'    => $img_dir . 'hero-product-6.jpg',
                    ),
                ),
            ),
        );

        // If WooCommerce is active, attempt to blend live category products
        if ( class_exists( 'WooCommerce' ) ) {
            foreach ( $categories_feed as $cat_key => &$cat_info ) {
                $tax_query = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => $cat_info['slugs'],
                    ),
                );
                $wc_cat_query = new WP_Query( array(
                    'post_type'      => 'product',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'tax_query'      => $tax_query,
                ) );

                if ( $wc_cat_query->have_posts() ) {
                    $live_prods = array();
                    while ( $wc_cat_query->have_posts() ) {
                        $wc_cat_query->the_post();
                        global $product;
                        $thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
                        if ( ! $thumb ) {
                            $thumb = $cat_info['products'][ count( $live_prods ) % count( $cat_info['products'] ) ]['image'];
                        }
                        $reg_price  = $product ? $product->get_regular_price() : '';
                        $sale_price = $product ? $product->get_sale_price() : '';
                        $curr_price = $product ? $product->get_price() : '99';
                        $discount_badge = '';
                        $mrp_display    = '';
                        if ( $reg_price && $sale_price && (float) $reg_price > (float) $sale_price ) {
                            $pct = round( ( ( (float) $reg_price - (float) $sale_price ) / (float) $reg_price ) * 100 );
                            if ( $pct > 0 ) {
                                $discount_badge = $pct . '% OFF';
                                $mrp_display    = '₹' . $reg_price;
                            }
                        }
                        $live_prods[] = array(
                            'id'       => get_the_ID(),
                            'title'    => get_the_title(),
                            'pack'     => 'Standard',
                            'price'    => '₹' . ( $curr_price ? $curr_price : '99' ),
                            'mrp'      => $mrp_display,
                            'discount' => $discount_badge,
                            'image'    => $thumb,
                            'url'      => get_permalink( get_the_ID() ),
                        );
                    }
                    wp_reset_postdata();
                    if ( ! empty( $live_prods ) ) {
                        $cat_info['products'] = $live_prods;
                    }
                }
            }
            unset( $cat_info );
        }

        // Ensure every product in the feed has a valid url for instant mobile navigation
        foreach ( $categories_feed as &$cf_cat ) {
            foreach ( $cf_cat['products'] as &$cf_prod ) {
                if ( empty( $cf_prod['url'] ) ) {
                    if ( function_exists( 'get_permalink' ) && get_post_status( $cf_prod['id'] ) === 'publish' ) {
                        $cf_prod['url'] = get_permalink( $cf_prod['id'] );
                    } elseif ( ! empty( $cf_cat['url'] ) ) {
                        $cf_prod['url'] = $cf_cat['url'];
                    } else {
                        $cf_prod['url'] = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
                    }
                }
            }
            unset( $cf_prod );
        }
        unset( $cf_cat );

        // Render each category section
        foreach ( $categories_feed as $cat_key => $cat ) :
        ?>
            <section class="mobile-category-section" data-category="<?php echo esc_attr( $cat['id'] ); ?>" id="catSection-<?php echo esc_attr( $cat['id'] ); ?>">
                <div class="mobile-category-header">
                    <h2 class="mobile-category-title">
                        <span class="mobile-category-icon"><?php echo esc_html( $cat['icon'] ); ?></span>
                        <span><?php echo esc_html( $cat['title'] ); ?></span>
                    </h2>
                    <span class="mobile-category-count"><?php echo esc_html( $cat['count'] ); ?></span>
                </div>

                <!-- 1-Row Compact Products Scroller (Blinkit Style) -->
                <div class="mobile-product-scroller">
                    <?php foreach ( $cat['products'] as $p ) : ?>
                        <article class="mobile-product-card" data-product-id="<?php echo esc_attr( $p['id'] ); ?>">
                            <!-- Clickable Card Area: Direct Navigation to Product Details Page -->
                            <a href="<?php echo esc_url( $p['url'] ); ?>" class="mobile-card-link" aria-label="<?php echo esc_attr( $p['title'] ); ?>">
                                <div class="mobile-card-thumb-wrap">
                                    <span class="mobile-card-pack-pill"><?php echo esc_html( $p['pack'] ); ?></span>
                                    <?php if ( ! empty( $p['discount'] ) ) : ?>
                                        <span class="mobile-card-discount-pill"><?php echo esc_html( $p['discount'] ); ?></span>
                                    <?php endif; ?>
                                    <img src="<?php echo esc_url( $p['image'] ); ?>" alt="<?php echo esc_attr( $p['title'] ); ?>" class="mobile-card-img" loading="lazy">
                                </div>

                                <div class="mobile-card-details">
                                    <h3 class="mobile-card-title" title="<?php echo esc_attr( $p['title'] ); ?>">
                                        <?php echo esc_html( $p['title'] ); ?>
                                    </h3>
                                </div>
                            </a>

                            <!-- Product Pricing & Instant Add-to-Cart Action -->
                            <div class="mobile-card-action-bar">
                                <div class="mobile-card-pricing-row">
                                    <span class="mobile-card-price"><?php echo esc_html( $p['price'] ); ?></span>
                                    <?php if ( ! empty( $p['mrp'] ) ) : ?>
                                        <span class="mobile-card-mrp"><?php echo esc_html( $p['mrp'] ); ?></span>
                                    <?php endif; ?>
                                </div>

                                <button type="button" class="mobile-add-btn ajax_add_to_cart" 
                                    data-product_id="<?php echo esc_attr( $p['id'] ); ?>" 
                                    data-product_name="<?php echo esc_attr( $p['title'] ); ?>"
                                    data-quantity="1"
                                    onclick="handleQuickCommerceAdd(this, '<?php echo esc_attr( $p['id'] ); ?>', '<?php echo esc_js( $p['title'] ); ?>')">
                                    + ADD
                                </button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <!-- "See all {Category} products ▸" Button (Option B: Links to category page) -->
                <a href="<?php echo esc_url( $cat['url'] ); ?>" class="mobile-see-all-cat-btn" aria-label="See all <?php echo esc_attr( $cat['title'] ); ?> products">
                    <div class="see-all-preview-thumbs">
                        <img src="<?php echo esc_url( $cat['products'][0]['image'] ); ?>" alt="" class="see-all-thumb thumb-1">
                        <img src="<?php echo esc_url( $cat['products'][1]['image'] ); ?>" alt="" class="see-all-thumb thumb-2">
                        <img src="<?php echo esc_url( $cat['products'][2]['image'] ); ?>" alt="" class="see-all-thumb thumb-3">
                    </div>
                    <span class="see-all-text">See all <?php echo esc_html( $cat['title'] ); ?> products</span>
                    <span class="see-all-arrow">&rarr;</span>
                </a>
            </section>
        <?php endforeach; ?>
    </div>

    <script>
    function handleQuickCommerceAdd(btn, prodId, prodTitle) {
        if (!btn) return;
        var origText = btn.innerHTML;
        btn.innerHTML = '✓ ADDED';
        btn.classList.add('is-added');

        if (window.jQuery && typeof jQuery.fn.trigger === 'function') {
            jQuery(document.body).trigger('added_to_cart', [{}, {}]);
        }

        setTimeout(function() {
            btn.innerHTML = 'ADDED (1)';
        }, 1200);
    }
    </script>

    <!-- Desktop Flagship Storefront View (50/50 Ajio Hero, Ambient Drift, Full Banners) -->
    <div class="desktop-storefront-view" id="desktopStorefrontView">

    <!-- 50/50 Split Storefront Hero Section (Ajio-Inspired) -->
    <section class="hero-split-section">
        <?php
        // Query WooCommerce for top products, or use authentic catalog fallback
        $hero_products = array();
        if ( class_exists( 'WooCommerce' ) ) {
            $wc_query = new WP_Query( array(
                'post_type'      => 'product',
                'posts_per_page' => 8,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ) );

            if ( $wc_query->have_posts() ) {
                $idx = 0;
                $fallback_images = array(
                    'hero-product-1.jpg',
                    'hero-product-2.jpg',
                    'hero-product-3.jpg',
                    'hero-product-4.jpg',
                    'hero-product-5.jpg',
                    'hero-product-6.jpg',
                    'hero-product-7.jpg',
                    'hero-product-8.jpg',
                );
                while ( $wc_query->have_posts() ) {
                    $wc_query->the_post();
                    global $product;
                    $thumb = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                    if ( ! $thumb ) {
                        $thumb = get_template_directory_uri() . '/images/' . $fallback_images[ $idx % 8 ];
                    }
                    $title = get_the_title();
                    $price_html = $product ? $product->get_price_html() : '';
                    
                    // Brand identification
                    $brand = 'Sri Balaji';
                    if ( stripos( $title, 'Classmate' ) !== false ) $brand = 'Classmate';
                    elseif ( stripos( $title, 'Apsara' ) !== false ) $brand = 'Apsara';
                    elseif ( stripos( $title, 'Pilot' ) !== false ) $brand = 'Pilot';
                    elseif ( stripos( $title, 'Faber' ) !== false ) $brand = 'Faber-Castell';
                    elseif ( stripos( $title, 'Casio' ) !== false ) $brand = 'Casio';
                    elseif ( stripos( $title, 'Camel' ) !== false || stripos( $title, 'Camlin' ) !== false ) $brand = 'Camlin';
                    elseif ( stripos( $title, 'Doms' ) !== false ) $brand = 'Doms';
                    elseif ( stripos( $title, 'Pidilite' ) !== false || stripos( $title, 'Fevicol' ) !== false || stripos( $title, 'Fevicryl' ) !== false || stripos( $title, 'Fevicreate' ) !== false ) $brand = 'Pidilite';
                    elseif ( stripos( $title, 'Reynolds' ) !== false ) $brand = 'Reynolds';

                    $badge = 'POPULAR';
                    if ( $product && $product->is_on_sale() ) {
                        $reg_p  = (float) $product->get_regular_price();
                        $sale_p = (float) $product->get_sale_price();
                        if ( $reg_p > 0 && $sale_p > 0 && $reg_p > $sale_p ) {
                            $calc_pct = (int) round( ( ( $reg_p - $sale_p ) / $reg_p ) * 100 );
                            if ( $calc_pct > 0 ) {
                                $badge = $calc_pct . '% OFF';
                            }
                        }
                    } elseif ( $product && $product->is_featured() ) {
                        $badge = 'FEATURED';
                    } elseif ( $idx === 0 ) {
                        $badge = 'BESTSELLER';
                    } elseif ( $idx === 1 ) {
                        $badge = 'TOP PICK';
                    } elseif ( $idx === 2 ) {
                        $badge = 'TRENDING';
                    } else {
                        $curated_badges = array( 'POPULAR', 'ESSENTIAL', 'CAMPUS PICK', 'STAFF PICK', 'TOP VALUE' );
                        $badge = $curated_badges[ $idx % count( $curated_badges ) ];
                    }

                    $hero_products[] = array(
                        'title' => $title,
                        'url'   => get_permalink(),
                        'image' => $thumb,
                        'price' => $price_html ? $price_html : '₹99.00',
                        'brand' => $brand,
                        'badge' => $badge,
                    );
                    $idx++;
                }
                wp_reset_postdata();
            }
        }

        // Fallback to verified catalog products if WooCommerce is empty or inactive
        if ( empty( $hero_products ) ) {
            $img_dir = get_template_directory_uri() . '/images/';
            $shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '#';
            $hero_products = array(
                array(
                    'title' => 'Classmate Pulse Spiral Notebook',
                    'url'   => $shop_url,
                    'image' => $img_dir . 'hero-product-1.jpg',
                    'price' => '<del>₹130</del> ₹117',
                    'brand' => 'Classmate',
                    'badge' => '10% OFF',
                ),
                array(
                    'title' => 'Pilot Hi-Tecpoint V5 Rollerball Pen',
                    'url'   => $shop_url,
                    'image' => $img_dir . 'hero-product-2.jpg',
                    'price' => '₹195',
                    'brand' => 'Pilot',
                    'badge' => 'TOP SELLER',
                ),
                array(
                    'title' => 'Faber-Castell Triangular Oil Pastels',
                    'url'   => $shop_url,
                    'image' => $img_dir . 'hero-product-3.jpg',
                    'price' => '<del>₹155</del> ₹140',
                    'brand' => 'Faber-Castell',
                    'badge' => '10% OFF',
                ),
                array(
                    'title' => 'Casio fx-82MS Scientific Calculator',
                    'url'   => $shop_url,
                    'image' => $img_dir . 'hero-product-6.jpg',
                    'price' => '<del>₹595</del> ₹545',
                    'brand' => 'Casio',
                    'badge' => 'SAVE ₹50',
                ),
                array(
                    'title' => 'Camel Oil Pastels (10 Shades Set)',
                    'url'   => $shop_url,
                    'image' => $img_dir . 'hero-product-5.jpg',
                    'price' => '₹65',
                    'brand' => 'Camlin',
                    'badge' => 'POPULAR',
                ),
                array(
                    'title' => 'Sri Balaji Canvas Tote Shopping Bag',
                    'url'   => $shop_url,
                    'image' => $img_dir . 'hero-product-7.jpg',
                    'price' => '₹119',
                    'brand' => 'Sri Balaji',
                    'badge' => 'ECO TOTE',
                ),
                array(
                    'title' => 'Train Sharpener & Eraser 2-in-1',
                    'url'   => $shop_url,
                    'image' => $img_dir . 'hero-product-4.jpg',
                    'price' => '₹110',
                    'brand' => 'Sri Balaji',
                    'badge' => 'KIDS PICK',
                ),
                array(
                    'title' => 'Classmate Long Exercise Notebook',
                    'url'   => $shop_url,
                    'image' => $img_dir . 'hero-product-8.jpg',
                    'price' => '<del>₹80</del> ₹72',
                    'brand' => 'Classmate',
                    'badge' => '10% OFF',
                ),
            );
        }
        ?>

        <!-- Ambient 10% Dim Watermark Scrolling Background Drift -->
        <div class="hero-ambient-watermark-wrap" id="ambientWatermarkWrap">
            <div class="hero-ambient-watermark-track">
                <?php foreach ( $hero_products as $item ) : ?>
                    <img src="<?php echo esc_url( $item['image'] ); ?>" alt="" class="ambient-watermark-item">
                <?php endforeach; ?>
                <!-- Duplicate for infinite seamless drift -->
                <?php foreach ( $hero_products as $item ) : ?>
                    <img src="<?php echo esc_url( $item['image'] ); ?>" alt="" class="ambient-watermark-item">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Left Half: Brand Narrative & Action CTAs (Zero image clutter behind text) -->
        <div class="hero-split-left">
            <div class="store-badge">
                ✨ Premium Stationery &bull; School Supplies &bull; Office Essentials
            </div>
            <h1>Empowering Young Minds &amp; Modern Workplaces</h1>
            <p class="hero-desc">
                Your trusted neighborhood bookstore and school partner. Discover authentic Classmate notebooks, Pilot pens, Faber-Castell art gear, and custom student kit bundles.
            </p>
            <div class="hero-cta-group">
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn-primary">
                        Shop All Products &rarr;
                    </a>
                <?php endif; ?>
                <a href="#categories" class="btn-secondary">
                    Explore Categories &darr;
                </a>
            </div>
            <div class="hero-features-list">
                <span>🚚 Cash on Delivery (COD) Active</span>
                <span>🏷️ 100% Genuine Brands</span>
                <span>🏫 School &amp; Office Bulk Kits</span>
            </div>
        </div>

        <!-- Right Half: Ajio-Style Large Product Showcase Carousel -->
        <div class="hero-split-right">
            <div class="hero-carousel-header">
                <div class="carousel-title-group">
                    <span class="live-dot"></span>
                    <span class="carousel-title">Trending In Store</span>
                </div>
                <div class="carousel-nav-arrows">
                    <button type="button" class="c-arrow prev" onclick="scrollHeroCarousel(-1)" aria-label="Previous Products">&#10094;</button>
                    <button type="button" class="c-arrow next" onclick="scrollHeroCarousel(1)" aria-label="Next Products">&#10095;</button>
                </div>
            </div>

            <div class="hero-carousel-viewport" id="heroProductViewport">
                <div class="hero-carousel-track">
                    <?php foreach ( $hero_products as $item ) : ?>
                        <a href="<?php echo esc_url( $item['url'] ); ?>" class="ajio-card">
                            <div class="ajio-card-img-wrap">
                                <span class="ajio-badge"><?php echo esc_html( $item['badge'] ); ?></span>
                                <img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy">
                            </div>
                            <div class="ajio-card-info">
                                <div class="ajio-info-main">
                                    <span class="ajio-item-title"><?php echo esc_html( $item['title'] ); ?></span>
                                    <span class="ajio-item-offer"><?php echo wp_kses_post( $item['price'] ); ?></span>
                                </div>
                                <div class="ajio-info-divider"></div>
                                <div class="ajio-info-brand">
                                    <span class="ajio-brand-name"><?php echo esc_html( $item['brand'] ); ?></span>
                                    <span class="ajio-brand-tag">&amp; More</span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <script>
    function scrollHeroCarousel(dir) {
        var el = document.getElementById('heroProductViewport');
        if (el) {
            el.scrollBy({ left: 305 * dir, behavior: 'smooth' });
        }
    }
    (function() {
        var el = document.getElementById('heroProductViewport');
        if (!el) return;
        var hovered = false;
        el.addEventListener('mouseenter', function() { hovered = true; });
        el.addEventListener('mouseleave', function() { hovered = false; });
        setInterval(function() {
            if (!hovered && el) {
                if (el.scrollLeft + el.clientWidth >= el.scrollWidth - 15) {
                    el.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    el.scrollBy({ left: 305, behavior: 'smooth' });
                }
            }
        }, 4000);
    })();
    </script>

    <!-- Customer Trust & Value Pillars (4 Key Customer Benefits) -->
    <section class="trust-grid">
        <div class="trust-card">
            <div class="trust-icon">🚚</div>
            <div class="trust-text">
                <h3>Fast Delivery &amp; COD</h3>
                <p>Doorstep delivery with Cash on Delivery available across all items.</p>
            </div>
        </div>
        <div class="trust-card">
            <div class="trust-icon">🏷️</div>
            <div class="trust-text">
                <h3>100% Authentic Brands</h3>
                <p>Classmate, Doms, Camlin, Faber-Castell, Apsara, and Reynolds.</p>
            </div>
        </div>
        <div class="trust-card">
            <div class="trust-icon">🏫</div>
            <div class="trust-text">
                <h3>School &amp; Institutional Supply</h3>
                <p>Bulk pricing and customized starter kits for schools, colleges, and offices.</p>
            </div>
        </div>
        <div class="trust-card">
            <div class="trust-icon">🛡️</div>
            <div class="trust-text">
                <h3>Customer Satisfaction</h3>
                <p>Hassle-free support, easy exchanges, and friendly neighborhood service.</p>
            </div>
        </div>
    </section>

    <!-- Trusted Brand Partner Logo Strip / Carousel (Feature 2.2) -->
    <section class="brands-section" aria-label="Trusted Brand Partners">
        <div class="brands-container">
            <div class="brands-header">
                <span class="brands-badge">✨ 100% AUTHENTIC PARTNERS</span>
                <h2 class="brands-title">Trusted Stationery Brands You Know &amp; Love</h2>
                <p class="brands-subtitle">Direct from official manufacturers with genuine quality assurance for schools &amp; offices</p>
            </div>

            <div class="brands-carousel-wrapper">
                <button type="button" class="brands-nav-btn prev" onclick="scrollBrandsCarousel(-1)" aria-label="Previous Brands">&#10094;</button>
                <div class="brands-carousel-viewport" id="brandsCarouselViewport">
                    <div class="brands-track">
                        <a href="<?php echo esc_url( home_url( '/?s=Classmate&post_type=product' ) ); ?>" class="brand-card brand-classmate" title="Shop ITC Classmate">
                            <div class="brand-emblem">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/brands/classmate.svg' ); ?>" alt="ITC Classmate" class="brand-logo-img brand-logo-classmate" loading="lazy">
                            </div>
                            <span class="brand-desc">Notebooks &bull; Pens &bull; Geometry</span>
                            <span class="brand-link-pill">Explore Classmate &rarr;</span>
                        </a>

                        <a href="<?php echo esc_url( home_url( '/?s=Apsara&post_type=product' ) ); ?>" class="brand-card brand-apsara" title="Shop Apsara Stationery & Pencils">
                            <div class="brand-emblem">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/brands/apsara.png' ); ?>" alt="Apsara Stationery" class="brand-logo-img brand-logo-apsara" loading="lazy">
                            </div>
                            <span class="brand-desc">Platinum &bull; Matt &bull; Art Supplies</span>
                            <span class="brand-link-pill">Explore Apsara &rarr;</span>
                        </a>

                        <a href="<?php echo esc_url( home_url( '/?s=Doms&post_type=product' ) ); ?>" class="brand-card brand-doms" title="Shop Doms Stationery & Art">
                            <div class="brand-emblem">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/brands/doms.png' ); ?>" alt="DOMS Stationery" class="brand-logo-img brand-logo-doms" loading="lazy">
                            </div>
                            <span class="brand-desc">Pencils &bull; Crayons &bull; Kits</span>
                            <span class="brand-link-pill">Explore Doms &rarr;</span>
                        </a>

                        <a href="<?php echo esc_url( home_url( '/?s=Camlin&post_type=product' ) ); ?>" class="brand-card brand-camlin" title="Shop Kokuyo Camlin">
                            <div class="brand-emblem">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/brands/camlin.svg' ); ?>" alt="Kokuyo Camlin" class="brand-logo-img brand-logo-camlin" loading="lazy">
                            </div>
                            <span class="brand-desc">Camel Colors &bull; Art &bull; Pastels</span>
                            <span class="brand-link-pill">Explore Camlin &rarr;</span>
                        </a>

                        <a href="<?php echo esc_url( home_url( '/?s=Pidilite&post_type=product' ) ); ?>" class="brand-card brand-pidilite" title="Shop Pidilite & Fevicol Crafts">
                            <div class="brand-emblem">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/brands/pidilite.png' ); ?>" alt="Pidilite & Fevicol" class="brand-logo-img brand-logo-pidilite" loading="lazy">
                            </div>
                            <span class="brand-desc">Fevicol &bull; Fevicryl &bull; Craft Kits</span>
                            <span class="brand-link-pill">Explore Pidilite &rarr;</span>
                        </a>

                        <a href="<?php echo esc_url( home_url( '/?s=Faber-Castell&post_type=product' ) ); ?>" class="brand-card brand-faber" title="Shop Faber-Castell">
                            <div class="brand-emblem">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/brands/faber-castell.png' ); ?>" alt="Faber-Castell" class="brand-logo-img brand-logo-faber" loading="lazy">
                            </div>
                            <span class="brand-desc">Fine Art &bull; Highlighters &bull; Pens</span>
                            <span class="brand-link-pill">Explore Faber-Castell &rarr;</span>
                        </a>

                        <a href="<?php echo esc_url( home_url( '/?s=Pilot&post_type=product' ) ); ?>" class="brand-card brand-pilot" title="Shop Pilot Pens">
                            <div class="brand-emblem">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/brands/pilot.svg' ); ?>" alt="Pilot Pens" class="brand-logo-img brand-logo-pilot" loading="lazy">
                            </div>
                            <span class="brand-desc">Hi-Tecpoint V5 &bull; V7 &bull; Gels</span>
                            <span class="brand-link-pill">Explore Pilot &rarr;</span>
                        </a>

                        <a href="<?php echo esc_url( home_url( '/?s=Casio&post_type=product' ) ); ?>" class="brand-card brand-casio" title="Shop Casio Calculators">
                            <div class="brand-emblem">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/brands/casio.svg' ); ?>" alt="Casio Calculators" class="brand-logo-img brand-logo-casio" loading="lazy">
                            </div>
                            <span class="brand-desc">Scientific &bull; Basic Calculators</span>
                            <span class="brand-link-pill">Explore Casio &rarr;</span>
                        </a>

                        <a href="<?php echo esc_url( home_url( '/?s=Paperkraft&post_type=product' ) ); ?>" class="brand-card brand-paperkraft" title="Shop ITC Paperkraft Premium">
                            <div class="brand-emblem">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/brands/paperkraft.svg' ); ?>" alt="ITC Paperkraft" class="brand-logo-img brand-logo-paperkraft" loading="lazy">
                            </div>
                            <span class="brand-desc">Executive Journals &bull; Ceramic Pens</span>
                            <span class="brand-link-pill">Explore Paperkraft &rarr;</span>
                        </a>

                        <a href="<?php echo esc_url( home_url( '/?s=Reynolds&post_type=product' ) ); ?>" class="brand-card brand-reynolds" title="Shop Reynolds Pens">
                            <div class="brand-emblem">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/brands/reynolds.png' ); ?>" alt="Reynolds Pens" class="brand-logo-img brand-logo-reynolds" loading="lazy">
                            </div>
                            <span class="brand-desc">045 Classic &bull; Liquiflo &bull; Gel</span>
                            <span class="brand-link-pill">Explore Reynolds &rarr;</span>
                        </a>
                    </div>
                </div>
                <button type="button" class="brands-nav-btn next" onclick="scrollBrandsCarousel(1)" aria-label="Next Brands">&#10095;</button>
            </div>
        </div>
    </section>

    <script>
    function scrollBrandsCarousel(dir) {
        var el = document.getElementById('brandsCarouselViewport');
        if (el) {
            el.scrollBy({ left: 280 * dir, behavior: 'smooth' });
        }
    }
    </script>

    <!-- Category Highlights Section -->
    <section id="categories" class="category-section">
        <div class="section-header">
            <h2>Shop by Category</h2>
            <p>Browse through our hand-picked collections for students, artists, and professionals.</p>
        </div>
        
        <div class="category-grid">
            <a href="<?php echo esc_url( sribalaji_get_category_url( array( 'notebooks', 'notebooks-exam-pads', 'paper-registers', 'school-essentials', 'books-notebooks' ), 'Notebooks & Exam Pads' ) ); ?>" class="category-card">
                <div class="category-icon">📚</div>
                <h3>Notebooks &amp; Registers</h3>
                <p>Single line, unruled, long books, graph &amp; drawing books</p>
                <span class="category-link">View Collection &rarr;</span>
            </a>
            <a href="<?php echo esc_url( sribalaji_get_category_url( array( 'pens', 'pens-refills', 'school-essentials', 'pens-pencils' ), 'Pens & Refills' ) ); ?>" class="category-card">
                <div class="category-icon">✍️</div>
                <h3>Pens &amp; Writing</h3>
                <p>Gel pens, rollerballs, fine liners, pencils &amp; markers</p>
                <span class="category-link">View Collection &rarr;</span>
            </a>
            <a href="<?php echo esc_url( sribalaji_get_category_url( array( 'art', 'art-craft', 'art-supplies', 'paints-canvases' ), 'Art & Craft' ) ); ?>" class="category-card">
                <div class="category-icon">🎨</div>
                <h3>Art &amp; Craft Materials</h3>
                <p>Acrylics, oil pastels, sketchbooks, canvases &amp; craft clay</p>
                <span class="category-link">View Collection &rarr;</span>
            </a>
            <a href="<?php echo esc_url( sribalaji_get_category_url( array( 'office', 'office-supplies', 'paper-registers' ), 'Office Supplies' ) ); ?>" class="category-card">
                <div class="category-icon">🏢</div>
                <h3>Office Essentials</h3>
                <p>Files, staplers, adhesives, sticky notes &amp; desk organizers</p>
                <span class="category-link">View Collection &rarr;</span>
            </a>
            <a href="<?php echo esc_url( sribalaji_get_category_url( array( 'geometry', 'school-kits', 'bags-totes', 'novelty-gifts', 'jute-bags' ), 'School Kits' ) ); ?>" class="category-card">
                <div class="category-icon">🎒</div>
                <h3>Bags &amp; Novelty Gifts</h3>
                <p>Eco-friendly jute shopping bags, pouches &amp; novelty sharpeners</p>
                <span class="category-link">View Collection &rarr;</span>
            </a>
        </div>
    </section>

    <!-- Live WooCommerce Products Section -->
    <?php if ( class_exists( 'WooCommerce' ) ) : 
        $count_posts = function_exists( 'wp_count_posts' ) ? wp_count_posts( 'product' ) : null;
        $total_pub = ( $count_posts && isset( $count_posts->publish ) ) ? intval( $count_posts->publish ) : 500;
        $count_text = $total_pub > 0 ? $total_pub : '500+';
    ?>
        <section class="products-section">
            <div class="section-header">
                <h2>Featured Products</h2>
                <p>Top picks and daily essentials from our verified catalog.</p>
            </div>
            <?php
            // Displays latest 4 products (1-row compact grid) using WooCommerce native engine
            echo do_shortcode( '[products limit="4" columns="4" orderby="date" order="DESC"]' );
            ?>
            <div class="products-footer-cta">
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn-primary">
                    View All <?php echo esc_html( $count_text ); ?> Products &rarr;
                </a>
            </div>
        </section>

        <?php
        // Feature 3.1: "Frequently Bought Together" & Classroom Bundle Spotlight
        if ( function_exists( 'sribalaji_render_homepage_fbt_spotlight' ) ) {
            sribalaji_render_homepage_fbt_spotlight();
        }
        ?>
    <?php else : ?>
        <section style="text-align: center; padding: 2rem; background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0;">
            <p style="color: #64748b;">
                WooCommerce is not currently active. Activate the WooCommerce plugin to display your store products here.
            </p>
        </section>
    <?php endif; ?>

    <!-- Google Maps Reviews Single-Line Ticker (Feature 2.4 - Pause on Hover) -->
    <section class="reviews-ticker-section" aria-label="Google Maps Verified Reviews">
        <div class="reviews-ticker-container">
            <!-- Permanent Store Anchor -->
            <div class="reviews-ticker-badge">
                <div class="google-icon-box" title="Google Maps Verified Store">
                    <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17z"/><path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.34 24 12 24z"/><path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/><path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.34 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/></svg>
                </div>
                <div class="reviews-ticker-badge-text">
                    <span class="reviews-ticker-badge-title">
                        Sri Balaji Books <span class="stars">★★★★★</span> <strong>5.0</strong>
                    </span>
                    <span class="reviews-ticker-badge-subtitle">Dwaraka Nagar, Visakhapatnam</span>
                </div>
                <a href="https://www.google.com/maps/place/Sri+Balaji+Books+And+Paper+Centre/@17.7269706,83.3081126,17z/data=!3m1!4b1!4m6!3m5!1s0x3a3943077486d6bf:0x722bfc7ce5ab24f0!8m2!3d17.7269655!4d83.3106875!16s%2Fg%2F11gjtz11_n?entry=ttu" target="_blank" rel="noopener noreferrer" class="reviews-ticker-rate-btn">
                    Rate Us 5★ on Maps &rarr;
                </a>
            </div>

            <!-- Scrolling Viewport (Hover to Pause) -->
            <div class="reviews-ticker-viewport" title="Hover over any review to pause and read">
                <div class="reviews-ticker-track">
                    <!-- Pill 1: Prakash Vaishnav -->
                    <div class="ticker-review-pill">
                        <span class="ticker-avatar avatar-blue">PV</span>
                        <div class="ticker-content">
                            <span class="ticker-name">Prakash Vaishnav</span>
                            <span class="ticker-stars">★★★★★</span>
                            <span class="ticker-tag">📷 5 Photos</span>
                            <span class="ticker-time">3 days ago</span>
                            <span class="ticker-verified">✓ Verified</span>
                        </div>
                    </div>

                    <!-- Pill 2: kuppala srinivas -->
                    <div class="ticker-review-pill">
                        <span class="ticker-avatar avatar-teal">KS</span>
                        <div class="ticker-content">
                            <span class="ticker-name">kuppala srinivas</span>
                            <span class="ticker-stars">★★★★★</span>
                            <span class="ticker-tag">📷 1 Photo</span>
                            <span class="ticker-time">8 mos ago</span>
                            <span class="ticker-verified">✓ Verified</span>
                        </div>
                    </div>

                    <!-- Pill 3: Satish Kumar -->
                    <div class="ticker-review-pill">
                        <span class="ticker-avatar avatar-purple">SK</span>
                        <div class="ticker-content">
                            <span class="ticker-name">Satish Kumar</span>
                            <span class="ticker-stars">★★★★★</span>
                            <span class="ticker-tag">⭐ Local Guide &bull; 10 Photos</span>
                            <span class="ticker-time">8 yrs ago</span>
                            <span class="ticker-verified">✓ Verified</span>
                        </div>
                    </div>

                    <!-- Pill 4: Joshu Bujji -->
                    <div class="ticker-review-pill">
                        <span class="ticker-avatar avatar-indigo">JB</span>
                        <div class="ticker-content">
                            <span class="ticker-name">Joshu Bujji</span>
                            <span class="ticker-stars">★★★★★</span>
                            <span class="ticker-tag">📍 Vizag Patron</span>
                            <span class="ticker-time">8 yrs ago</span>
                            <span class="ticker-verified">✓ Verified</span>
                        </div>
                    </div>

                    <!-- Duplicated set for seamless continuous marquee loop -->
                    <div class="ticker-review-pill" aria-hidden="true">
                        <span class="ticker-avatar avatar-blue">PV</span>
                        <div class="ticker-content">
                            <span class="ticker-name">Prakash Vaishnav</span>
                            <span class="ticker-stars">★★★★★</span>
                            <span class="ticker-tag">📷 5 Photos</span>
                            <span class="ticker-time">3 days ago</span>
                            <span class="ticker-verified">✓ Verified</span>
                        </div>
                    </div>

                    <div class="ticker-review-pill" aria-hidden="true">
                        <span class="ticker-avatar avatar-teal">KS</span>
                        <div class="ticker-content">
                            <span class="ticker-name">kuppala srinivas</span>
                            <span class="ticker-stars">★★★★★</span>
                            <span class="ticker-tag">📷 1 Photo</span>
                            <span class="ticker-time">8 mos ago</span>
                            <span class="ticker-verified">✓ Verified</span>
                        </div>
                    </div>

                    <div class="ticker-review-pill" aria-hidden="true">
                        <span class="ticker-avatar avatar-purple">SK</span>
                        <div class="ticker-content">
                            <span class="ticker-name">Satish Kumar</span>
                            <span class="ticker-stars">★★★★★</span>
                            <span class="ticker-tag">⭐ Local Guide &bull; 10 Photos</span>
                            <span class="ticker-time">8 yrs ago</span>
                            <span class="ticker-verified">✓ Verified</span>
                        </div>
                    </div>

                    <div class="ticker-review-pill" aria-hidden="true">
                        <span class="ticker-avatar avatar-indigo">JB</span>
                        <div class="ticker-content">
                            <span class="ticker-name">Joshu Bujji</span>
                            <span class="ticker-stars">★★★★★</span>
                            <span class="ticker-tag">📍 Vizag Patron</span>
                            <span class="ticker-time">8 yrs ago</span>
                            <span class="ticker-verified">✓ Verified</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Secondary Information Hub (Compact Cards linking to dedicated FAQ & Bulk Orders Pages) -->
    <section class="home-secondary-links-strip" aria-label="Customer Services and Institutional Orders">
        <div class="hub-strip-grid">
            <!-- Card 1: Frequently Asked Questions Hub -->
            <a href="<?php echo esc_url( get_template_directory_uri() . '/faq.html' ); ?>" class="hub-link-card">
                <div class="hub-card-left">
                    <div class="hub-icon-wrap faq-icon-bg">
                        <span>💬</span>
                    </div>
                    <div class="hub-card-text">
                        <h3>Frequently Asked Questions</h3>
                        <p>Quick answers on Vizag same-day delivery, Cash on Delivery, and brand authenticity guarantee.</p>
                        <span class="hub-card-meta">Read 5 Common Questions &bull; WhatsApp Support &rarr;</span>
                    </div>
                </div>
                <div class="hub-action-arrow">&rarr;</div>
            </a>

            <!-- Card 2: Bulk Stationery & School Book Kits Hub -->
            <a href="<?php echo esc_url( get_template_directory_uri() . '/bulk-orders.html' ); ?>" class="hub-link-card">
                <div class="hub-card-left">
                    <div class="hub-icon-wrap bulk-icon-bg">
                        <span>📦</span>
                    </div>
                    <div class="hub-card-text">
                        <h3>Bulk Stationery &amp; School Book Kits</h3>
                        <p>Tailored student bundles, GST invoices, and volume discounts for schools and corporate offices.</p>
                        <span class="hub-card-meta">Explore Institutional Solutions &bull; Fast Quotes &rarr;</span>
                    </div>
                </div>
                <div class="hub-action-arrow">&rarr;</div>
            </a>
        </div>
    </section>

    </div><!-- /desktop-storefront-view -->

</main>

<?php get_footer(); ?>
