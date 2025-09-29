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
                'posts_per_page' => 12,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'offset'         => 12, // 新築の後に表示
            ));
        }
        
        if ($used_properties->have_posts()) :
        ?>
            <div class="mansions-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-bottom: 40px;">
                <?php while ($used_properties->have_posts()) : $used_properties->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="mansion-card-link">
                        <div class="mansion-card">
                            <div class="mansion-image" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'mansion-thumbnail') ?: get_template_directory_uri() . '/images/default-mansion.jpg'; ?>')">
                                <div class="mansion-badge" style="position: absolute; top: 10px; right: 10px; background: #28a745; color: white; padding: 5px 10px; border-radius: 3px; font-size: 12px; font-weight: bold;">Đã qua sử dụng</div>
                            </div>
                            <div class="mansion-content">
                                <h3 class="mansion-title"><?php the_title(); ?></h3>
                                <div class="mansion-price">
                                    <?php 
                                    $price = get_post_meta(get_the_ID(), '_property_price', true);
                                    if ($price) {
                                        echo '¥' . number_format($price) . '万円';
                                    } else {
                                        echo 'Giá liên hệ';
                                    }
                                    ?>
                                </div>
                                <div class="mansion-details">
                                    <span><?php echo get_post_meta(get_the_ID(), '_property_rooms', true) ?: 'Mặt bằng chưa xác định'; ?></span>
                                    <span><?php echo get_post_meta(get_the_ID(), '_property_area', true) ?: 'Diện tích chưa xác định'; ?></span>
                                </div>
                                <div class="mansion-location">
                                    <?php
                                    $areas = get_the_terms(get_the_ID(), 'area');
                                    if ($areas && !is_wp_error($areas)) {
                                        echo $areas[0]->name;
                                    } else {
                                        echo 'Vị trí chưa xác định';
                                    }
                                    ?>
                                </div>
                                <div class="mansion-btn">Xem chi tiết</div>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
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