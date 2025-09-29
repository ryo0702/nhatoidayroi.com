<a href="<?php the_permalink(); ?>" class="mansion-card-link">
    <div class="mansion-card">
        <div class="mansion-image" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'mansion-thumbnail') ?: get_template_directory_uri() . '/images/nophoto.png'; ?>')">
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