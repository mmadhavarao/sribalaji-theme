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
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

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
                    echo '<li><a href="' . esc_url( wc_get_cart_url() ) . '">Cart (' . WC()->cart->get_cart_contents_count() . ')</a></li>';
                }
                echo '</ul>';
            }
            ?>
        </nav>
    </div>
</header>
