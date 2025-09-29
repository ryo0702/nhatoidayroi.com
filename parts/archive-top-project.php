<section class="projects-section" style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        <h2 class="section-title" style="text-align: center; margin-bottom: 40px; font-size: 32px; color: #333;">Dự án nổi bật</h2>
        
        <?php
        // プロジェクトのクエリ
        $featured_projects = new WP_Query(array(
            'post_type'      => 'project',
            'posts_per_page' => 12,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        
        if ($featured_projects->have_posts()) :
        ?>
            <div class="projects-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; margin-bottom: 40px;">
                <?php while ($featured_projects->have_posts()) : $featured_projects->the_post();
                    include get_template_directory() . '/parts/loop-project.php';
                endwhile; ?>
            </div>
            
            <div style="text-align: center;">
                <a href="<?php echo esc_url(home_url('/projects/')); ?>" class="search-btn" style="display: inline-block; text-decoration: none;">Xem tất cả dự án</a>
            </div>
        <?php else : ?>
            <div style="text-align: center; padding: 40px;">
                <p>現在、表示できるプロジェクトがありません。</p>
            </div>
        <?php endif; ?>
        
        <?php wp_reset_postdata(); ?>
    </div>
</section>