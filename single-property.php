<?php get_header(); ?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        <!-- プロパティヘッダー -->
        <section class="property-header" style="padding: 120px 0 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            <div class="container">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;">
                    <div class="property-info">
                        <h1 style="font-size: 36px; color: #333; margin-bottom: 20px;"><?php the_title(); ?></h1>
                        
                        <div class="property-meta" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                            <?php
                            // 価格表示
                            $price = get_post_meta(get_the_ID(), '_property_price', true);
                            if ($price) {
                                echo '<div class="meta-item">';
                                echo '<strong>Giá:</strong><br>';
                                echo '<span style="color: #dc2626; font-size: 24px; font-weight: bold;">¥' . number_format($price) . '万円</span>';
                                echo '</div>';
                            }
                            
                            // 間取り表示
                            $layout_type = get_the_terms(get_the_ID(), 'layout_type');
                            if ($layout_type && !is_wp_error($layout_type)) {
                                echo '<div class="meta-item">';
                                echo '<strong>Mặt bằng:</strong><br>' . $layout_type[0]->name;
                                echo '</div>';
                            }
                            
                            // 面積表示
                            $area = get_post_meta(get_the_ID(), '_property_area', true);
                            if ($area) {
                                echo '<div class="meta-item">';
                                echo '<strong>Diện tích:</strong><br>' . $area . 'm²';
                                echo '</div>';
                            }
                            
                            // 築年数表示
                            $age = get_post_meta(get_the_ID(), '_property_age', true);
                            if ($age) {
                                echo '<div class="meta-item">';
                                echo '<strong>Tuổi nhà:</strong><br>' . $age . '年';
                                echo '</div>';
                            }
                            ?>
                        </div>
                        
                        <div class="property-location" style="margin-bottom: 30px;">
                            <strong>Vị trí:</strong>
                            <?php
                            $areas = get_the_terms(get_the_ID(), 'area');
                            if ($areas && !is_wp_error($areas)) {
                                $area_names = array();
                                foreach ($areas as $area) {
                                    $area_names[] = $area->name;
                                }
                                echo ' ' . implode(', ', $area_names);
                            }
                            ?>
                        </div>
                    </div>
                    
                    <div class="property-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title(); ?>" style="width: 100%; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <?php else : ?>
                            <div style="width: 100%; height: 300px; background: #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <span style="color: #999; font-size: 18px;">Hình ảnh bất động sản</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- プロパティ詳細 -->
        <section class="property-content" style="padding: 60px 0;">
            <div class="container">
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
                    
                    <!-- メインコンテンツ -->
                    <div class="main-content">
                        <!-- 物件概要 -->
                        <div class="property-description" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                            <h2 style="font-size: 24px; color: #333; margin-bottom: 25px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Giới thiệu bất động sản</h2>
                            <div class="content" style="line-height: 1.8; color: #555;">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <!-- 物件詳細情報 -->
                        <div class="property-details" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                            <h2 style="font-size: 24px; color: #333; margin-bottom: 25px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Thông tin chi tiết</h2>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                                <?php
                                $details = array(
                                    '_property_price' => 'Giá bán',
                                    '_property_area' => 'Diện tích',
                                    '_property_rooms' => 'Số phòng',
                                    '_property_age' => 'Tuổi nhà',
                                    '_property_floor' => 'Tầng',
                                    '_property_direction' => 'Hướng nhà',
                                    '_property_parking' => 'Chỗ đỗ xe',
                                    '_property_balcony' => 'Ban công',
                                    '_property_storage' => 'Kho chứa',
                                    '_property_management_fee' => 'Phí quản lý',
                                    '_property_repair_fee' => 'Phí sửa chữa',
                                    '_property_car_parking_fee' => 'Phí đỗ xe ô tô',
                                    '_property_bike_parking_fee' => 'Phí đỗ xe máy'
                                );
                                
                                foreach ($details as $meta_key => $label) {
                                    $value = get_post_meta(get_the_ID(), $meta_key, true);
                                    if ($value) {
                                        echo '<div class="detail-item">';
                                        echo '<label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">' . $label . '</label>';
                                        echo '<span>' . esc_html($value);
                                        
                                        // 単位を追加
                                        if (strpos($meta_key, 'price') !== false) {
                                            echo '万円';
                                        } elseif (strpos($meta_key, 'area') !== false) {
                                            echo 'm²';
                                        } elseif (strpos($meta_key, 'fee') !== false) {
                                            echo '円/月';
                                        } elseif (strpos($meta_key, 'age') !== false) {
                                            echo '年';
                                        } elseif (strpos($meta_key, 'floor') !== false) {
                                            echo '階';
                                        }
                                        
                                        echo '</span>';
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <!-- ギャラリー -->
                        <div class="property-gallery" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                            <h2 style="font-size: 24px; color: #333; margin-bottom: 25px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Hình ảnh bất động sản</h2>
                            
                            <?php
                            $gallery_images = get_property_gallery(get_the_ID());
                            if (!empty($gallery_images)) :
                            ?>
                                <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                                    <?php foreach ($gallery_images as $image) : ?>
                                        <div class="gallery-item" style="position: relative; border-radius: 8px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['label']); ?>" style="width: 100%; height: 150px; object-fit: cover;">
                                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); color: white; padding: 8px; font-size: 12px; text-align: center;">
                                                <?php echo esc_html($image['label']); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <p style="color: #999; text-align: center; padding: 40px;">Chưa có hình ảnh nào được tải lên.</p>
                            <?php endif; ?>
                        </div>

                        <!-- 関連プロジェクト -->
                        <?php
                        $related_project_id = get_post_meta(get_the_ID(), '_property_project_id', true);
                        if ($related_project_id) :
                            $related_project = get_post($related_project_id);
                            if ($related_project) :
                        ?>
                            <div class="related-project" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                                <h2 style="font-size: 24px; color: #333; margin-bottom: 25px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Dự án liên quan</h2>
                                
                                <div style="display: flex; gap: 20px; align-items: center;">
                                    <?php if (has_post_thumbnail($related_project_id)) : ?>
                                        <img src="<?php echo get_the_post_thumbnail_url($related_project_id, 'medium'); ?>" alt="<?php echo get_the_title($related_project_id); ?>" style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;">
                                    <?php endif; ?>
                                    
                                    <div style="flex: 1;">
                                        <h3 style="margin: 0 0 10px 0; font-size: 20px;">
                                            <a href="<?php echo get_permalink($related_project_id); ?>" style="color: #333; text-decoration: none;"><?php echo get_the_title($related_project_id); ?></a>
                                        </h3>
                                        <p style="color: #666; margin: 0; line-height: 1.6;"><?php echo wp_trim_words(get_the_excerpt($related_project_id), 30, '...'); ?></p>
                                        <a href="<?php echo get_permalink($related_project_id); ?>" style="color: #dc2626; text-decoration: none; font-weight: 600; margin-top: 10px; display: inline-block;">Xem chi tiết dự án →</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; endif; ?>
                    </div>

                    <!-- サイドバー -->
                    <div class="sidebar">
                        <!-- お問い合わせフォーム -->
                        <div class="contact-form" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 30px;">
                            <h3 style="font-size: 20px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Liên hệ tư vấn</h3>
                            
                            <form method="post" action="">
                                <?php wp_nonce_field('property_contact', 'property_contact_nonce'); ?>
                                <input type="hidden" name="property_id" value="<?php echo get_the_ID(); ?>">
                                
                                <div style="margin-bottom: 15px;">
                                    <label for="contact_name" style="display: block; margin-bottom: 5px; font-weight: 600;">Họ và tên *</label>
                                    <input type="text" id="contact_name" name="contact_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                </div>
                                
                                <div style="margin-bottom: 15px;">
                                    <label for="contact_email" style="display: block; margin-bottom: 5px; font-weight: 600;">Email *</label>
                                    <input type="email" id="contact_email" name="contact_email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                </div>
                                
                                <div style="margin-bottom: 15px;">
                                    <label for="contact_phone" style="display: block; margin-bottom: 5px; font-weight: 600;">Số điện thoại</label>
                                    <input type="tel" id="contact_phone" name="contact_phone" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                </div>
                                
                                <div style="margin-bottom: 20px;">
                                    <label for="contact_message" style="display: block; margin-bottom: 5px; font-weight: 600;">Nội dung *</label>
                                    <textarea id="contact_message" name="contact_message" rows="4" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; resize: vertical;"></textarea>
                                </div>
                                
                                <button type="submit" name="submit_contact" style="width: 100%; background: #dc2626; color: white; padding: 12px; border: none; border-radius: 4px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.3s ease;">
                                    Gửi yêu cầu tư vấn
                                </button>
                            </form>
                        </div>

                        <!-- 物件特徴 -->
                        <div class="property-features" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 30px;">
                            <h3 style="font-size: 20px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Đặc điểm</h3>
                            
                            <?php
                            $features = get_the_terms(get_the_ID(), 'property_features');
                            if ($features && !is_wp_error($features)) :
                            ?>
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    <?php foreach ($features as $feature) : ?>
                                        <li style="padding: 8px 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center;">
                                            <span style="color: #dc2626; margin-right: 10px;">✓</span>
                                            <?php echo esc_html($feature->name); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <p style="color: #999; font-style: italic;">Chưa có thông tin đặc điểm.</p>
                            <?php endif; ?>
                        </div>

                        <!-- 物件状態 -->
                        <div class="property-condition" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                            <h3 style="font-size: 20px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Tình trạng</h3>
                            
                            <?php
                            $conditions = get_the_terms(get_the_ID(), 'property_condition');
                            if ($conditions && !is_wp_error($conditions)) :
                            ?>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="color: #dc2626; font-size: 18px;">🏠</span>
                                    <span style="font-weight: 600;"><?php echo esc_html($conditions[0]->name); ?></span>
                                </div>
                            <?php else : ?>
                                <p style="color: #999; font-style: italic;">Chưa có thông tin tình trạng.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>