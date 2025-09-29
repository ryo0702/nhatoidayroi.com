<?php
$news_query = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
));

if ($news_query->have_posts()) :
?>
    <section class="news-section" style="padding: 60px 0; background-color: #f8f9fa;">
        <div class="container">
            <h2 class="section-title"><?php 'Tin tức'; ?></h2>
            <div class="news-list" style="max-width: 800px; margin: 0 auto;">
                <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                    <div class="news-item" style="background: white; padding: 20px; margin-bottom: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <span style="color: #dc2626; font-weight: bold; white-space: nowrap;"><?php echo get_the_date('Y.m.d'); ?></span>
                            <a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none; flex: 1;">
                                <?php the_title(); ?>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div style="text-align: center; margin-top: 30px;">
                <a href="<?php echo esc_url(home_url('/news/')); ?>" style="color: #dc2626; text-decoration: none; font-weight: bold;"><?php 'Xem tất cả tin tức'; ?></a>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php wp_reset_postdata(); ?>