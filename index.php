<?php
/**
 * Main Index Template
 *
 * @package SriBalajiTheme
 */

get_header(); ?>

<main class="site-main">

    <!-- Hero Section -->
    <section class="hero-box">
        <div class="git-badge">
            🚀 Git Continuous Deployment Active &bull; Branch: main
        </div>
        <h1>Welcome to <?php bloginfo( 'name' ); ?></h1>
        <p>
            <?php bloginfo( 'description' ); ?> &bull; Premium Office Stationery, School Supplies, Art &amp; Craft, Bags, and Novelty Gifts.
        </p>
        <?php if ( class_exists( 'WooCommerce' ) ) : ?>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn-primary">
                Shop Our Collection &rarr;
            </a>
        <?php endif; ?>
    </section>

    <!-- Architecture Highlights -->
    <section class="features-grid">
        <div class="feature-card">
            <h3>⚡ Zero Bloat Architecture</h3>
            <p>Built from scratch without fragile 3rd-party demo importers. 100% reliable, clean, and instant page loads.</p>
        </div>
        <div class="feature-card">
            <h3>🗄️ Hostinger Database Powered</h3>
            <p>Directly connected to your Hostinger MySQL database. All products, categories, and orders stay permanently safe.</p>
        </div>
        <div class="feature-card">
            <h3>🔄 Git-Driven Workflow</h3>
            <p>Edit code in VS Code on your Mac, run <code>git push</code>, and Hostinger automatically updates your live site.</p>
        </div>
    </section>

    <!-- Live WooCommerce Products Section -->
    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
        <section class="products-section" style="margin-top: 3rem;">
            <h2 style="font-size: 1.75rem; color: var(--primary); margin-bottom: 1.5rem; text-align: center;">
                Featured Products
            </h2>
            <?php
            // Displays latest 8 products using WooCommerce native engine
            echo do_shortcode( '[products limit="8" columns="4" orderby="date" order="DESC"]' );
            ?>
        </section>
    <?php else : ?>
        <section style="text-align: center; padding: 2rem; background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0;">
            <p style="color: #64748b;">
                WooCommerce is not currently active. Activate the WooCommerce plugin to display your store products here.
            </p>
        </section>
    <?php endif; ?>

</main>

<?php get_footer(); ?>
