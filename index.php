<?php
/**
 * Main Index Template - Sri Balaji Books & Stationery Storefront
 *
 * @package SriBalajiTheme
 */

get_header(); ?>

<main class="site-main">

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

                    $hero_products[] = array(
                        'title' => $title,
                        'url'   => get_permalink(),
                        'image' => $thumb,
                        'price' => $price_html ? $price_html : '₹99.00',
                        'brand' => $brand,
                        'badge' => ( $idx % 2 === 0 ) ? 'MIN. 20% OFF*' : 'BESTSELLER',
                    );
                    $idx++;
                }
                wp_reset_postdata();
            }
        }

        // Fallback to verified catalog products if WooCommerce is empty or inactive
        if ( empty( $hero_products ) ) {
            $img_dir = get_template_directory_uri() . '/images/';
            $hero_products = array(
                array(
                    'title' => 'Classmate Pulse Spiral Notebook',
                    'url'   => '#',
                    'image' => $img_dir . 'hero-product-1.jpg',
                    'price' => 'MIN. 20% OFF* &bull; ₹110',
                    'brand' => 'Classmate',
                    'badge' => 'MIN. 20% OFF*',
                ),
                array(
                    'title' => 'Pilot Hi-Tecpoint V5 Rollerball Pen',
                    'url'   => '#',
                    'image' => $img_dir . 'hero-product-2.jpg',
                    'price' => 'SPECIAL &bull; ₹195',
                    'brand' => 'Pilot',
                    'badge' => 'TOP SELLER',
                ),
                array(
                    'title' => 'Faber-Castell Triangular Oil Pastels',
                    'url'   => '#',
                    'image' => $img_dir . 'hero-product-3.jpg',
                    'price' => 'MIN. 15% OFF* &bull; ₹140',
                    'brand' => 'Faber-Castell',
                    'badge' => 'ART ESSENTIAL',
                ),
                array(
                    'title' => 'Casio fx-82MS Scientific Calculator',
                    'url'   => '#',
                    'image' => $img_dir . 'hero-product-6.jpg',
                    'price' => 'SAVE ₹50 &bull; ₹545',
                    'brand' => 'Casio',
                    'badge' => 'EXAM SPECIAL',
                ),
                array(
                    'title' => 'Camel Oil Pastels (10 Shades Set)',
                    'url'   => '#',
                    'image' => $img_dir . 'hero-product-5.jpg',
                    'price' => 'MIN. 20% OFF* &bull; ₹65',
                    'brand' => 'Camlin',
                    'badge' => 'POPULAR',
                ),
                array(
                    'title' => 'Sri Balaji Canvas Tote Shopping Bag',
                    'url'   => '#',
                    'image' => $img_dir . 'hero-product-7.jpg',
                    'price' => 'FLAT 20% OFF* &bull; ₹119',
                    'brand' => 'Sri Balaji',
                    'badge' => 'ECO TOTE',
                ),
                array(
                    'title' => 'Train Sharpener & Eraser 2-in-1',
                    'url'   => '#',
                    'image' => $img_dir . 'hero-product-4.jpg',
                    'price' => 'MIN. 25% OFF* &bull; ₹110',
                    'brand' => 'Sri Balaji',
                    'badge' => 'KIDS PICK',
                ),
                array(
                    'title' => 'Classmate Long Exercise Notebook',
                    'url'   => '#',
                    'image' => $img_dir . 'hero-product-8.jpg',
                    'price' => 'MIN. 25% OFF* &bull; ₹70',
                    'brand' => 'Classmate',
                    'badge' => 'CAMPUS PICK',
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
            <a href="<?php echo esc_url( sribalaji_get_category_url( array( 'notebooks-exam-pads', 'paper-registers', 'school-essentials', 'books-notebooks' ), 'Notebooks & Exam Pads' ) ); ?>" class="category-card">
                <div class="category-icon">📚</div>
                <h3>Notebooks &amp; Registers</h3>
                <p>Single line, unruled, long books, graph &amp; drawing books</p>
                <span class="category-link">View Collection &rarr;</span>
            </a>
            <a href="<?php echo esc_url( sribalaji_get_category_url( array( 'pens-refills', 'school-essentials', 'pens-pencils' ), 'Pens & Refills' ) ); ?>" class="category-card">
                <div class="category-icon">✍️</div>
                <h3>Pens &amp; Writing</h3>
                <p>Gel pens, rollerballs, fine liners, pencils &amp; markers</p>
                <span class="category-link">View Collection &rarr;</span>
            </a>
            <a href="<?php echo esc_url( sribalaji_get_category_url( array( 'art-craft', 'art-supplies', 'paints-canvases' ), 'Art & Craft' ) ); ?>" class="category-card">
                <div class="category-icon">🎨</div>
                <h3>Art &amp; Craft Materials</h3>
                <p>Acrylics, oil pastels, sketchbooks, canvases &amp; craft clay</p>
                <span class="category-link">View Collection &rarr;</span>
            </a>
            <a href="<?php echo esc_url( sribalaji_get_category_url( array( 'office-supplies', 'paper-registers' ), 'Office Supplies' ) ); ?>" class="category-card">
                <div class="category-icon">🏢</div>
                <h3>Office Essentials</h3>
                <p>Files, staplers, adhesives, sticky notes &amp; desk organizers</p>
                <span class="category-link">View Collection &rarr;</span>
            </a>
            <a href="<?php echo esc_url( sribalaji_get_category_url( array( 'bags-totes', 'novelty-gifts', 'jute-bags' ), 'Bags & Totes' ) ); ?>" class="category-card">
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

</main>

<?php get_footer(); ?>
