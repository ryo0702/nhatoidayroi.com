<section class="used-mansions-section" style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        <h2 class="section-title" style="text-align: center; margin-bottom: 40px; font-size: 32px; color: #333;">Chung cư đã qua sử dụng</h2>
        
        <?php
        // 中古マンションのクエリ
        $used_properties = new WP_Query(array(
            'post_type'      => 'property',
            'posts_per_page' => 12,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'property_condition',
                    'field'    => 'slug',
                    'terms'    => 'used',
                ),
            ),
        ));
        
        if (!$used_properties->have_posts()) {
            // 中古の条件がない場合は最新の不動産を表示
            $used_properties = new WP_Query(array(
                'post_type'      => 'property',
                'posts_per_page' => 24,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'offset'         => 12, // 新築の後に表示
            ));
        }
        
        if ($used_properties->have_posts()) :
        ?>
            <div class="mansions-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-bottom: 40px;">
                <?php while ($used_properties->have_posts()) : $used_properties->the_post();
                include get_template_directory() . '/parts/loop-property.php';
                endwhile; ?>
            </div>
            
            <div style="text-align: center;">
                <a href="<?php echo esc_url(home_url('/properties/?condition=used')); ?>" class="search-btn" style="display: inline-block; text-decoration: none;">Xem tất cả chung cư đã qua sử dụng</a>
            </div>
        <?php else : ?>
            <div style="text-align: center; padding: 40px;">
                <p>現在、表示できる中古マンションがありません。</p>
            </div>
        <?php endif; ?>
        
        <?php wp_reset_postdata(); ?>
    </div>
</section>