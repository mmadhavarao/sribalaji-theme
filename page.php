<?php
/**
 * The template for displaying all pages (including WooCommerce My Account, Cart, Checkout)
 *
 * @package SriBalajiTheme
 */

get_header(); ?>

<main class="site-main page-container">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'sribalaji-theme' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</main>

<?php get_footer(); ?>
