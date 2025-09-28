<?php get_header(); ?>

<main id="main" class="site-main">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- ページヘッダー -->
        <section class="page-header" style="padding: 100px 0 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                    <div>
                        <h1 style="font-size: 36px; color: #333; margin-bottom: 10px;"><?php the_title(); ?></h1>
                        <p style="color: #666; font-size: 16px;"><?php echo get_post_meta(get_the_ID(), 'property_location', true) ?: 'Vị trí chưa xác định'; ?></p>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 28px; font-weight: bold; color: #dc2626; margin-bottom: 5px;">
                            <?php 
                            $price = get_post_meta(get_the_ID(), 'property_price', true);
                            if ($price) {
                                echo '¥' . number_format($price) . '万円';
                            } else {
                                'Giá liên hệ';
                            }
                            ?>
                        </div>
                        <div style="color: #666; font-size: 14px;">
                            <?php echo get_post_meta(get_the_ID(), 'property_rooms', true) ?: 'Mặt bằng chưa xác định'; ?>
                            <?php if (get_post_meta(get_the_ID(), 'property_size', true)) : ?>
                                | <?php echo get_post_meta(get_the_ID(), 'property_size', true); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- メインコンテンツ -->
        <section class="property-detail" style="padding: 60px 0;">
            <div class="container">
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
                    
                    <!-- 左側：メインコンテンツ -->
                    <div class="main-content">
                        
                        <!-- ギャラリー表示 -->
                        <?php echo display_property_gallery(get_the_ID()); ?>
                        
                        <!-- YouTube動画表示 -->
                        <?php echo display_property_youtube_video(get_the_ID()); ?>
                        
                        <!-- 物件詳細情報 -->
                        <div class="property-info" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                            <h2 style="font-size: 24px; color: #333; margin-bottom: 25px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;"><?php 'Chi tiết bất động sản'; ?></h2>
                            
                            <!-- 状態と物件タイプの表示 -->
                            <div style="display: flex; gap: 20px; margin-bottom: 25px; flex-wrap: wrap;">
                                <div class="property-badges" style="display: flex; gap: 10px;">
                                    <?php
                                    // 物件状態の表示
                                    $condition_terms = get_the_terms(get_the_ID(), 'property_condition');
                                    if ($condition_terms && !is_wp_error($condition_terms)) {
                                        foreach ($condition_terms as $term) {
                                            $badge_color = '';
                                            switch ($term->slug) {
                                                case 'new':
                                                    $badge_color = 'background: #28a745;'; // 緑
                                                    break;
                                                case 'used':
                                                    $badge_color = 'background: #6c757d;'; // グレー
                                                    break;
                                                case 'planned':
                                                    $badge_color = 'background: #17a2b8;'; // 青
                                                    break;
                                                default:
                                                    $badge_color = 'background: #dc2626;';
                                            }
                                            echo '<span style="' . $badge_color . ' color: white; padding: 5px 12px; border-radius: 20px; font-size: 14px; font-weight: 600;">' . esc_html($term->name) . '</span>';
                                        }
                                    }
                                    
                                    // 物件タイプの表示
                                    $property_type_terms = get_the_terms(get_the_ID(), 'property_type');
                                    if ($property_type_terms && !is_wp_error($property_type_terms)) {
                                        foreach ($property_type_terms as $term) {
                                            echo '<span style="background: #dc2626; color: white; padding: 5px 12px; border-radius: 20px; font-size: 14px; font-weight: 600;">' . esc_html($term->name) . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;"><?php 'Khu vực'; ?></label>
                                    <span>
                                        <?php
                                        $area_terms = get_the_terms(get_the_ID(), 'area');
                                        if ($area_terms && !is_wp_error($area_terms)) {
                                            $area_names = array();
                                            foreach ($area_terms as $term) {
                                                $area_names[] = $term->name;
                                            }
                                            echo implode(', ', $area_names);
                                        } else {
                                            'Chưa xác định';
                                        }
                                        ?>
                                    </span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;"><?php 'Vị trí'; ?></label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'property_location', true) ?: 'Chưa xác định'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;"><?php 'Giá'; ?></label>
                                    <span style="color: #dc2626; font-weight: bold;">
                                        <?php 
                                        $price = get_post_meta(get_the_ID(), 'property_price', true);
                                        if ($price) {
                                            echo '¥' . number_format($price) . '万円';
                                        } else {
                                            'Liên hệ';
                                        }
                                        ?>
                                    </span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;"><?php 'Mặt bằng'; ?></label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'property_rooms', true) ?: 'Chưa xác định'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;"><?php _et('専有面積', 'nhatoidayroi'); ?></label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'property_size', true) ?: 'Chưa xác định'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;"><?php _et('築年数', 'nhatoidayroi'); ?></label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'property_age', true) ?: 'Chưa xác định'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;"><?php 'Cấu trúc'; ?></label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'property_structure', true) ?: 'Chưa xác định'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;"><?php _et('交通', 'nhatoidayroi'); ?></label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'property_access', true) ?: 'Chưa xác định'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;"><?php _et('管理費', 'nhatoidayroi'); ?></label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'property_management_fee', true) ?: 'Chưa xác định'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;"><?php 'Phạm vi diện tích'; ?></label>
                                    <span>
                                        <?php
                                        $area_size_terms = get_the_terms(get_the_ID(), 'area_size');
                                        if ($area_size_terms && !is_wp_error($area_size_terms)) {
                                            $area_size_names = array();
                                            foreach ($area_size_terms as $term) {
                                                $area_size_names[] = $term->name;
                                            }
                                            echo implode(', ', $area_size_names);
                                        } else {
                                            'Chưa xác định';
                                        }
                                        ?>
                                    </span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;"><?php _et('価格帯', 'nhatoidayroi'); ?></label>
                                    <span>
                                        <?php
                                        $price_range_terms = get_the_terms(get_the_ID(), 'price_range');
                                        if ($price_range_terms && !is_wp_error($price_range_terms)) {
                                            $price_range_names = array();
                                            foreach ($price_range_terms as $term) {
                                                $price_range_names[] = $term->name;
                                            }
                                            echo implode(', ', $price_range_names);
                                        } else {
                                            'Chưa xác định';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 物件の特徴・設備 -->
                        <div class="property-features" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                            <h2 style="font-size: 24px; color: #333; margin-bottom: 25px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">物件の特徴・設備</h2>
                            
                            <?php
                            $feature_terms = get_the_terms(get_the_ID(), 'property_features');
                            if ($feature_terms && !is_wp_error($feature_terms)) {
                                // 特徴をグループごとに分類
                                $feature_groups = array(
                                    'room' => array(),
                                    'bathroom' => array(),
                                    'property' => array()
                                );
                                
                                foreach ($feature_terms as $term) {
                                    $slug = $term->slug;
                                    if (strpos($slug, 'bathtub') !== false || strpos($slug, 'sauna') !== false || strpos($slug, 'bathroom') !== false) {
                                        $feature_groups['bathroom'][] = $term;
                                    } elseif (strpos($slug, 'high-floor') !== false || strpos($slug, 'penthouse') !== false || strpos($slug, 'concierge') !== false || strpos($slug, 'garbage') !== false || strpos($slug, 'corner') !== false || strpos($slug, 'view') !== false) {
                                        $feature_groups['property'][] = $term;
                                    } else {
                                        $feature_groups['room'][] = $term;
                                    }
                                }
                                
                                $group_labels = array(
                                    'room' => '部屋',
                                    'bathroom' => 'トイレ・シャワールーム',
                                    'property' => '物件'
                                );
                                
                                foreach ($feature_groups as $group_key => $terms) {
                                    if (!empty($terms)) {
                                        echo '<div style="margin-bottom: 25px;">';
                                        echo '<h3 style="font-size: 18px; color: #dc2626; margin-bottom: 15px; padding-left: 10px; border-left: 4px solid #dc2626;">' . $group_labels[$group_key] . '</h3>';
                                        echo '<div style="display: flex; flex-wrap: wrap; gap: 10px;">';
                                        
                                        foreach ($terms as $term) {
                                            echo '<span style="background: #f8f9fa; color: #333; padding: 8px 15px; border-radius: 20px; font-size: 14px; border: 1px solid #dee2e6; display: inline-block;">' . esc_html($term->name) . '</span>';
                                        }
                                        
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }
                            } else {
                                echo '<p style="color: #666; text-align: center; padding: 20px;">特徴・設備の情報は準備中です</p>';
                            }
                            ?>
                        </div>
                        
                        <!-- 物件説明 -->
                        <div class="property-description" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                            <h2 style="font-size: 24px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;"><?php _et('物件説明', 'nhatoidayroi'); ?></h2>
                            <div style="line-height: 1.8; color: #555;">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                        <!-- 設備・仕様 -->
                        <?php 
                        $facilities = get_post_meta(get_the_ID(), 'property_facilities', true);
                        if ($facilities) : 
                        ?>
                            <div class="property-facilities" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                                <h2 style="font-size: 24px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;"><?php _et('設備・仕様', 'nhatoidayroi'); ?></h2>
                                <div style="line-height: 1.8; color: #555;">
                                    <?php echo wpautop($facilities); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- 周辺環境 -->
                        <?php 
                        $surroundings = get_post_meta(get_the_ID(), 'property_surroundings', true);
                        if ($surroundings) : 
                        ?>
                            <div class="property-surroundings" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                                <h2 style="font-size: 24px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;"><?php _et('周辺環境', 'nhatoidayroi'); ?></h2>
                                <div style="line-height: 1.8; color: #555;">
                                    <?php echo wpautop($surroundings); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    
                    <!-- 右側：サイドバー -->
                    <div class="sidebar">
                        
                        <!-- お問い合わせボックス -->
                        <div class="contact-box" style="background: #dc2626; color: white; padding: 30px; border-radius: 10px; margin-bottom: 30px; text-align: center;">
                            <h3 style="font-size: 20px; margin-bottom: 15px;"><?php 'Liên hệ'; ?></h3>
                            <p style="margin-bottom: 20px; line-height: 1.5;"><?php _et('この物件について<br>詳しく知りたい方は<br>お気軽にお問い合わせください', 'nhatoidayroi'); ?></p>
                            <div style="margin-bottom: 20px;">
                                <div style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">03-1234-5678</div>
                                <div style="font-size: 14px; opacity: 0.9;"><?php _et('営業時間: 9:00-18:00（土日祝除く）', 'nhatoidayroi'); ?></div>
                            </div>
                            <a href="<?php echo esc_url(home_url('/contact/')); ?>" style="background: white; color: #dc2626; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block; transition: all 0.3s ease;">
                                <?php _et('お問い合わせフォーム', 'nhatoidayroi'); ?>
                            </a>
                        </div>
                        
                        <!-- 資料請求 -->
                        <div class="document-request" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 30px; text-align: center;">
                            <h3 style="font-size: 18px; color: #333; margin-bottom: 15px;"><?php _et('資料請求', 'nhatoidayroi'); ?></h3>
                            <p style="color: #666; font-size: 14px; margin-bottom: 20px; line-height: 1.5;">
                                <?php _et('この物件の詳細資料を<br>無料でお送りいたします', 'nhatoidayroi'); ?>
                            </p>
                            <a href="<?php echo esc_url(home_url('/contact/?subject=資料請求&property=' . get_the_ID())); ?>" style="background: #333; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 14px; display: inline-block;">
                                <?php _et('資料を請求する', 'nhatoidayroi'); ?>
                            </a>
                        </div>
                        
                        <!-- 見学予約 -->
                        <div class="inspection-booking" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 30px; text-align: center;">
                            <h3 style="font-size: 18px; color: #333; margin-bottom: 15px;"><?php _et('見学予約', 'nhatoidayroi'); ?></h3>
                            <p style="color: #666; font-size: 14px; margin-bottom: 20px; line-height: 1.5;">
                                <?php _et('実際に物件を見学して<br>ご検討いただけます', 'nhatoidayroi'); ?>
                            </p>
                            <a href="<?php echo esc_url(home_url('/contact/?subject=見学予約&property=' . get_the_ID())); ?>" style="background: #28a745; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 14px; display: inline-block;">
                                <?php _et('見学を予約する', 'nhatoidayroi'); ?>
                            </a>
                        </div>
                        
                        <!-- 関連物件 -->
                        <?php
                        $related_properties = new WP_Query(array(
                            'post_type'      => 'property',
                            'posts_per_page' => 3,
                            'post__not_in'   => array(get_the_ID()),
                            'orderby'        => 'rand',
                        ));
                        
                        if ($related_properties->have_posts()) :
                        ?>
                            <div class="related-properties" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                <h3 style="font-size: 18px; color: #333; margin-bottom: 20px;"><?php _et('関連物件', 'nhatoidayroi'); ?></h3>
                                <?php while ($related_properties->have_posts()) : $related_properties->the_post(); ?>
                                    <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
                                        <div style="display: flex; gap: 15px;">
                                            <div style="width: 80px; height: 60px; background-size: cover; background-position: center; border-radius: 5px; flex-shrink: 0;" 
                                                 style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: get_template_directory_uri() . '/images/default-property.jpg'; ?>')">
                                            </div>
                                            <div style="flex: 1;">
                                                <h4 style="font-size: 14px; margin-bottom: 5px;">
                                                    <a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none;">
                                                        <?php echo wp_trim_words(get_the_title(), 8); ?>
                                                    </a>
                                                </h4>
                                                <div style="font-size: 12px; color: #dc2626; font-weight: bold;">
                                                    <?php 
                                                    $price = get_post_meta(get_the_ID(), 'property_price', true);
                                                    if ($price) {
                                                        echo '¥' . number_format($price) . '万円';
                                                    } else {
                                                        'Giá liên hệ';
                                                    }
                                                    ?>
                                                </div>
                                                <div style="font-size: 12px; color: #666;">
                                                    <?php echo get_post_meta(get_the_ID(), 'property_rooms', true) ?: 'Mặt bằng chưa xác định'; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                                <div style="text-align: center;">
                                    <a href="<?php echo esc_url(home_url('/properties/')); ?>" style="color: #dc2626; text-decoration: none; font-size: 14px;"><?php _et('すべての物件を見る', 'nhatoidayroi'); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php wp_reset_postdata(); ?>
                        
                    </div>
                </div>
            </div>
        </section>
        
    <?php endwhile; ?>
    
</main>

<style>
/* レスポンシブ対応 */
@media (max-width: 768px) {
    .property-detail .container > div {
        grid-template-columns: 1fr !important;
    }
    
    .gallery-thumbnails {
        grid-template-columns: repeat(4, 1fr) !important;
    }
    
    .property-video iframe {
        height: 250px !important;
    }
}
</style>

<?php get_footer(); ?>
