<?php get_header(); ?>

<main id="main" class="site-main">
    
    <!-- ヒーロースライダー -->
    <section class="main-visual">
        <div class="slider-container">
            <?php
            $slides = get_slider_images();
            $slide_count = 0;
            foreach ($slides as $slide) :
                $slide_count++;
                $image_url = !empty($slide['image']) ? $slide['image'] : get_template_directory_uri() . '/images/slide' . $slide_count . '.jpg';
                $title = !empty($slide['title']) ? $slide['title'] : 'Chung cư cao cấp mới xây';
                $description = !empty($slide['description']) ? $slide['description'] : 'Tìm ngôi nhà lý tưởng của bạn';
            ?>
                <div class="slide <?php echo $slide_count === 1 ? 'active' : ''; ?>" style="background-image: url('<?php echo esc_url($image_url); ?>')">
                    <div class="slide-content">
                        <h2><?php echo esc_html($title); ?></h2>
                        <p><?php echo esc_html($description); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- スライダーナビゲーション -->
        <div class="slider-nav">
            <?php for ($i = 1; $i <= count($slides); $i++) : ?>
                <div class="slider-dot <?php echo $i === 1 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
            <?php endfor; ?>
        </div>
    </section>
    
    <!-- 詳細検索セクション -->
    <section class="search-section">
        <div class="container">
            <h2 class="search-title">Tìm kiếm bất động sản lý tưởng</h2>
            <form class="search-form" method="post" action="">
                <?php wp_nonce_field('property_search', 'property_search_nonce'); ?>
                <input type="hidden" name="property_search" value="1">
                
                <div class="form-group">
                    <label for="location"><?php 'Khu vực mong muốn'; ?></label>
                    <input type="text" id="location" name="location" placeholder="<?php 'VD: Shibuya, Shinjuku'; ?>">
                </div>
                
                <div class="form-group">
                    <label for="price_min"><?php 'Giá (Tối thiểu)'; ?></label>
                    <select id="price_min" name="price_min">
                        <option value=""><?php 'Vui lòng chọn'; ?></option>
                        <option value="3000">3,000万円以上</option>
                        <option value="4000">4,000万円以上</option>
                        <option value="5000">5,000万円以上</option>
                        <option value="6000">6,000万円以上</option>
                        <option value="8000">8,000万円以上</option>
                        <option value="10000">1億円以上</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="price_max"><?php 'Giá (Tối đa)'; ?></label>
                    <select id="price_max" name="price_max">
                        <option value=""><?php 'Vui lòng chọn'; ?></option>
                        <option value="4000">4,000万円以下</option>
                        <option value="5000">5,000万円以下</option>
                        <option value="6000">6,000万円以下</option>
                        <option value="8000">8,000万円以下</option>
                        <option value="10000">1億円以下</option>
                        <option value="15000">1.5億円以下</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="rooms"><?php 'Mặt bằng'; ?></label>
                    <select id="rooms" name="rooms">
                        <option value=""><?php 'Vui lòng chọn'; ?></option>
                        <option value="1LDK">1LDK</option>
                        <option value="2LDK">2LDK</option>
                        <option value="2DK">2DK</option>
                        <option value="3LDK">3LDK</option>
                        <option value="3DK">3DK</option>
                        <option value="4LDK">4LDK</option>
                        <option value="4DK">4DK</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="area"><?php 'Khu vực'; ?></label>
                    <select id="area" name="area">
                        <option value=""><?php 'Vui lòng chọn'; ?></option>
                        <?php
                        $areas = get_terms(array(
                            'taxonomy' => 'area',
                            'hide_empty' => false,
                        ));
                        
                        if (!empty($areas) && !is_wp_error($areas)) {
                            foreach ($areas as $area) {
                                echo '<option value="' . esc_attr($area->slug) . '">' . esc_html($area->name) . '</option>';
                            }
                        } else {
                            // デフォルトのエリアオプション
                            echo '<option value="tokyo">東京都</option>';
                            echo '<option value="osaka">大阪府</option>';
                            echo '<option value="kanagawa">神奈川県</option>';
                            echo '<option value="chiba">千葉県</option>';
                            echo '<option value="saitama">埼玉県</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="condition"><?php 'Tình trạng'; ?></label>
                    <select id="condition" name="condition">
                        <option value=""><?php 'Vui lòng chọn'; ?></option>
                        <option value="new"><?php 'Mới'; ?></option>
                        <option value="used"><?php 'Đã qua sử dụng'; ?></option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="property_type"><?php 'Loại bất động sản'; ?></label>
                    <select id="property_type" name="property_type">
                        <option value=""><?php 'Vui lòng chọn'; ?></option>
                        <?php
                        $property_types = get_terms(array(
                            'taxonomy' => 'property_type',
                            'hide_empty' => false,
                        ));
                        
                        if (!empty($property_types) && !is_wp_error($property_types)) {
                            foreach ($property_types as $type) {
                                echo '<option value="' . esc_attr($type->slug) . '">' . esc_html($type->name) . '</option>';
                            }
                        } else {
                            // デフォルトの物件タイプオプション
                            echo '<option value="mansion">マンション</option>';
                            echo '<option value="house">一戸建て</option>';
                            echo '<option value="land">土地</option>';
                            echo '<option value="office">オフィス</option>';
                            echo '<option value="shop">店舗</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="search-btn"><?php 'Tìm kiếm'; ?></button>
                </div>
            </form>
        </div>
    </section>
    
    <!-- おすすめマンションセクション -->
    <section class="mansions-section">
        <div class="container">
            <h2 class="section-title"><?php 'Bất động sản được đề xuất'; ?></h2>
            
            <?php
            // おすすめ不動産のクエリ
            $featured_properties = new WP_Query(array(
                'post_type'      => 'property',
                'posts_per_page' => 6,
                'meta_key'       => 'featured',
                'meta_value'     => 'yes',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ));
            
            if (!$featured_properties->have_posts()) {
                // フィーチャード不動産がない場合は最新の不動産を表示
                $featured_properties = new WP_Query(array(
                    'post_type'      => 'property',
                    'posts_per_page' => 6,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ));
            }
            
            if ($featured_properties->have_posts()) :
            ?>
                <div class="mansions-grid">
                    <?php while ($featured_properties->have_posts()) : $featured_properties->the_post(); ?>
                        <div class="mansion-card">
                            <div class="mansion-image" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'mansion-thumbnail') ?: get_template_directory_uri() . '/images/default-mansion.jpg'; ?>')">
                                <?php if (get_post_meta(get_the_ID(), 'featured', true) === 'yes') : ?>
                                    <div class="mansion-badge"><?php 'Đề xuất'; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mansion-content">
                                <h3 class="mansion-title"><?php the_title(); ?></h3>
                                <div class="mansion-price">
                                    <?php 
                                    $price = get_post_meta(get_the_ID(), 'mansion_price', true);
                                    if ($price) {
                                        echo '¥' . number_format($price) . '万円';
                                    } else {
                                        'Giá liên hệ';
                                    }
                                    ?>
                                </div>
                                <div class="mansion-details">
                                    <span><?php echo get_post_meta(get_the_ID(), 'mansion_rooms', true) ?: 'Mặt bằng chưa xác định'; ?></span>
                                    <span><?php echo get_post_meta(get_the_ID(), 'mansion_size', true) ?: 'Diện tích chưa xác định'; ?></span>
                                </div>
                                <div class="mansion-location">
                                    <?php echo get_post_meta(get_the_ID(), 'mansion_location', true) ?: 'Vị trí chưa xác định'; ?>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="mansion-btn"><?php 'Xem chi tiết'; ?></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <div style="text-align: center; margin-top: 40px;">
                    <a href="<?php echo esc_url(home_url('/properties/')); ?>" class="search-btn" style="display: inline-block; text-decoration: none;"><?php 'Xem tất cả bất động sản'; ?></a>
                </div>
            <?php else : ?>
                <div style="text-align: center; padding: 40px;">
                    <p>現在、表示できる不動産がありません。</p>
                    <p>しばらくお待ちください。</p>
                </div>
            <?php endif; ?>
            
            <?php wp_reset_postdata(); ?>
        </div>
    </section>
    
    <!-- ニュース・お知らせセクション -->
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
    
</main>

<?php get_footer(); ?>
