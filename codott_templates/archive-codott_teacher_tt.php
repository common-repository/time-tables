<?php get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
    <?php if ( have_posts() ) : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="page-header">
                <h1 class="page-title">Teacher Time Tables</h1>
            </header>
            <table>
                <!-- Display table headers -->
                <tr>
                    <th style="text-align:left;"><strong>Title</strong></th>
                    <th style="text-align:left;"><strong>Teacher</strong></th>
                </tr>
                <!-- Start the Loop -->
                <?php while ( have_posts() ) : the_post(); ?>
                    <!-- Display review title and author -->
                    <tr>
                        <td><a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?></a></td>
                        <td><?php echo esc_html( get_post_meta( get_the_ID(), 'codott_teacher_time_table_teacher', true ) ); ?></td>
                    </tr>
                <?php endwhile; ?>
     
                <!-- Display page navigation -->
     
            </table>
            <?php global $wp_query;
            if ( isset( $wp_query->max_num_pages ) && $wp_query->max_num_pages > 1 ) { ?>
                <nav style="overflow: hidden;">
                    <div class="nav-previous alignleft"><?php next_posts_link( '<span class="meta-nav">&larr;</span> Older', $wp_query->max_num_pages); ?></div>
                    <div class="nav-next alignright"><?php previous_posts_link( 'Newer <span class= "meta-nav">&rarr;</span>' ); ?></div>
                </nav>
            <?php };?>
        </article>
        <?php
    endif; ?>
    </main>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>