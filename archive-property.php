<?php
include get_template_directory() . '/parts/header.php';
?>

<main id="main" class="site-main">
    
    <!-- ページヘッダー -->
    <section class="page-header" style="padding: 100px 0 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <h1 style="font-size: 36px; text-align: center; color: #333; margin-bottom: 20px;"><?php 'Danh sách bất động sản'; ?></h1>
            <p style="text-align: center; color: #666; font-size: 16px;"><?php _et('理想の住まいを見つけましょう'); ?></p>
        </div>
    </section>
    
    <!-- 検索フィルター -->
    <section class="filter-section" style="padding: 40px 0; background-color: white; border-bottom: 1px solid #e5e5e5;">
        <div class="container">
            <form class="filter-form" method="get" action="">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                    
                    <div class="form-group">
                        <label for="filter_location"><?php 'Khu vực'; ?></label>
                        <input type="text" id="filter_location" name="location" value="<?php echo esc_attr($_GET['location'] ?? ''); ?>" placeholder="<?php _et('例：渋谷区'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="filter_price_min"><?php 'Giá (Tối thiểu)'; ?></label>
                        <select id="filter_price_min" name="price_min">
                            <option value=""><?php 'Vui lòng chọn'; ?></option>
                            <option value="3000" <?php selected($_GET['price_min'] ?? '', '3000'); ?>>3,000万円以上</option>
                            <option value="4000" <?php selected($_GET['price_min'] ?? '', '4000'); ?>>4,000万円以上</option>
                            <option value="5000" <?php selected($_GET['price_min'] ?? '', '5000'); ?>>5,000万円以上</option>
                            <option value="6000" <?php selected($_GET['price_min'] ?? '', '6000'); ?>>6,000万円以上</option>
                            <option value="8000" <?php selected($_GET['price_min'] ?? '', '8000'); ?>>8,000万円以上</option>
                            <option value="10000" <?php selected($_GET['price_min'] ?? '', '10000'); ?>>1億円以上</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="filter_price_max"><?php 'Giá (Tối đa)'; ?></label>
                        <select id="filter_price_max" name="price_max">
                            <option value=""><?php 'Vui lòng chọn'; ?></option>
                            <option value="4000" <?php selected($_GET['price_max'] ?? '', '4000'); ?>>4,000万円以下</option>
                            <option value="5000" <?php selected($_GET['price_max'] ?? '', '5000'); ?>>5,000万円以下</option>
                            <option value="6000" <?php selected($_GET['price_max'] ?? '', '6000'); ?>>6,000万円以下</option>
                            <option value="8000" <?php selected($_GET['price_max'] ?? '', '8000'); ?>>8,000万円以下</option>
                            <option value="10000" <?php selected($_GET['price_max'] ?? '', '10000'); ?>>1億円以下</option>
                            <option value="15000" <?php selected($_GET['price_max'] ?? '', '15000'); ?>>1.5億円以下</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="filter_rooms"><?php 'Mặt bằng'; ?></label>
                        <select id="filter_rooms" name="rooms">
                            <option value=""><?php 'Vui lòng chọn'; ?></option>
                            <option value="1LDK" <?php selected($_GET['rooms'] ?? '', '1LDK'); ?>>1LDK</option>
                            <option value="2LDK" <?php selected($_GET['rooms'] ?? '', '2LDK'); ?>>2LDK</option>
                            <option value="2DK" <?php selected($_GET['rooms'] ?? '', '2DK'); ?>>2DK</option>
                            <option value="3LDK" <?php selected($_GET['rooms'] ?? '', '3LDK'); ?>>3LDK</option>
                            <option value="3DK" <?php selected($_GET['rooms'] ?? '', '3DK'); ?>>3DK</option>
                            <option value="4LDK" <?php selected($_GET['rooms'] ?? '', '4LDK'); ?>>4LDK</option>
                            <option value="4DK" <?php selected($_GET['rooms'] ?? '', '4DK'); ?>>4DK</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="filter_area_size"><?php 'Diện tích'; ?></label>
                        <select id="filter_area_size" name="area_size">
                            <option value=""><?php 'Vui lòng chọn'; ?></option>
                            <?php
                            $area_sizes = get_terms(array(
                                'taxonomy' => 'area_size',
                                'hide_empty' => false,
                            ));
                            
                            if (!empty($area_sizes) && !is_wp_error($area_sizes)) {
                                foreach ($area_sizes as $area_size) {
                                    $selected = ($_GET['area_size'] ?? '') === $area_size->slug ? 'selected' : '';
                                    echo '<option value="' . esc_attr($area_size->slug) . '" ' . $selected . '>' . esc_html($area_size->name) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="search-btn"><?php 'Lọc'; ?></button>
                        <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="search-btn" style="background: #6c757d; margin-left: 10px; text-decoration: none; display: inline-block;"><?php 'Đặt lại'; ?></a>
                    </div>
                </div>
            </form>
        </div>
    </section>
    
    <!-- 不動産一覧 -->
    <section class="properties-section" style="padding: 60px 0;">
        <div class="container">
            
            <?php if (have_posts()) : ?>
                <!-- 検索結果表示 -->
                <div class="search-results" style="margin-bottom: 30px;">
                    <p style="color: #666; font-size: 14px;">
                        <?php
                        global $wp_query;
                        $total = $wp_query->found_posts;
                        $current_page = get_query_var('paged') ?: 1;
                        $per_page = get_option('posts_per_page');
                        $start = ($current_page - 1) * $per_page + 1;
                        $end = min($current_page * $per_page, $total);
                        
                        echo "全 {$total} 件中 {$start}-{$end} 件を表示";
                        ?>
                    </p>
                </div>
                
                <!-- 表示切り替えボタン -->
                <div class="view-toggle" style="text-align: right; margin-bottom: 30px;">
                    <button class="view-btn active" data-view="grid" style="background: #dc2626; color: white; border: none; padding: 8px 15px; margin-right: 5px; border-radius: 3px; cursor: pointer;"><?php 'Xem lưới'; ?></button>
                    <button class="view-btn" data-view="list" style="background: #e5e5e5; color: #333; border: none; padding: 8px 15px; border-radius: 3px; cursor: pointer;"><?php 'Xem danh sách'; ?></button>
                </div>
                
                <!-- 不動産カード -->
                <div class="properties-grid" id="properties-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="property-card" style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                            <div class="property-image" style="width: 100%; height: 200px; background-size: cover; background-position: center; position: relative; background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'mansion-thumbnail') ?: get_template_directory_uri() . '/images/default-property.jpg'; ?>')">
                                <?php if (get_post_meta(get_the_ID(), 'featured', true) === 'yes') : ?>
                                    <div style="position: absolute; top: 15px; right: 15px; background: #dc2626; color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600;"><?php 'Đề xuất'; ?></div>
                                <?php endif; ?>
                                <?php if (get_post_meta(get_the_ID(), 'new', true) === 'yes') : ?>
                                    <div style="position: absolute; top: 50px; right: 15px; background: #28a745; color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600;">NEW</div>
                                <?php endif; ?>
                            </div>
                            <div class="property-content" style="padding: 20px;">
                                <h3 class="property-title" style="font-size: 18px; font-weight: 600; margin-bottom: 10px; color: #333;">
                                    <a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none;">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <div class="property-price" style="font-size: 20px; font-weight: bold; color: #dc2626; margin-bottom: 10px;">
                                    <?php 
                                    $price = get_post_meta(get_the_ID(), 'property_price', true);
                                    if ($price) {
                                        echo '¥' . number_format($price) . '万円';
                                    } else {
                                        'Giá liên hệ';
                                    }
                                    ?>
                                </div>
                                <div class="property-details" style="display: flex; gap: 15px; margin-bottom: 15px; font-size: 14px; color: #666;">
                                    <span><?php echo get_post_meta(get_the_ID(), 'property_rooms', true) ?: 'Mặt bằng chưa xác định'; ?></span>
                                    <span><?php echo get_post_meta(get_the_ID(), 'property_size', true) ?: 'Diện tích chưa xác định'; ?></span>
                                    <span><?php echo get_post_meta(get_the_ID(), 'property_age', true) ?: __('築年数未定', 'nhatoidayroi'); ?></span>
                                </div>
                                
                                <!-- 状態と物件タイプのバッジ表示 -->
                                <div class="property-badges" style="margin-bottom: 15px; display: flex; gap: 8px; flex-wrap: wrap;">
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
                                            echo '<span style="' . $badge_color . ' color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">' . esc_html($term->name) . '</span>';
                                        }
                                    }
                                    
                                    // 物件タイプの表示
                                    $property_type_terms = get_the_terms(get_the_ID(), 'property_type');
                                    if ($property_type_terms && !is_wp_error($property_type_terms)) {
                                        foreach ($property_type_terms as $term) {
                                            echo '<span style="background: #dc2626; color: white; padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">' . esc_html($term->name) . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <!-- 平米数タクソノミー表示 -->
                                <div class="property-area-sizes" style="margin-bottom: 15px;">
                                    <?php
                                    $area_size_terms = get_the_terms(get_the_ID(), 'area_size');
                                    if ($area_size_terms && !is_wp_error($area_size_terms)) {
                                        foreach ($area_size_terms as $term) {
                                            echo '<span style="background: #f8f9fa; color: #333; padding: 3px 8px; border-radius: 3px; font-size: 12px; margin-right: 5px; display: inline-block; margin-bottom: 5px;">' . esc_html($term->name) . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <!-- 価格帯タクソノミー表示 -->
                                <div class="property-price-ranges" style="margin-bottom: 15px;">
                                    <?php
                                    $price_range_terms = get_the_terms(get_the_ID(), 'price_range');
                                    if ($price_range_terms && !is_wp_error($price_range_terms)) {
                                        foreach ($price_range_terms as $term) {
                                            echo '<span style="background: #e3f2fd; color: #1976d2; padding: 3px 8px; border-radius: 3px; font-size: 12px; margin-right: 5px; display: inline-block; margin-bottom: 5px;">' . esc_html($term->name) . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <!-- エリアタクソノミー表示 -->
                                <div class="property-areas" style="margin-bottom: 15px;">
                                    <?php
                                    $area_terms = get_the_terms(get_the_ID(), 'area');
                                    if ($area_terms && !is_wp_error($area_terms)) {
                                        foreach ($area_terms as $term) {
                                            echo '<span style="background: #f3e5f5; color: #7b1fa2; padding: 3px 8px; border-radius: 3px; font-size: 12px; margin-right: 5px; display: inline-block; margin-bottom: 5px;">' . esc_html($term->name) . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <!-- 物件の特徴・設備表示 -->
                                <div class="property-features" style="margin-bottom: 15px;">
                                    <?php
                                    $feature_terms = get_the_terms(get_the_ID(), 'property_features');
                                    if ($feature_terms && !is_wp_error($feature_terms)) {
                                        $display_count = 0;
                                        foreach ($feature_terms as $term) {
                                            if ($display_count < 5) { // 最大5個まで表示
                                                echo '<span style="background: #e8f5e8; color: #2d5a2d; padding: 3px 8px; border-radius: 3px; font-size: 11px; margin-right: 5px; display: inline-block; margin-bottom: 5px;">' . esc_html($term->name) . '</span>';
                                                $display_count++;
                                            }
                                        }
                                        if (count($feature_terms) > 5) {
                                            echo '<span style="background: #e8f5e8; color: #2d5a2d; padding: 3px 8px; border-radius: 3px; font-size: 11px; display: inline-block;">+' . (count($feature_terms) - 5) . '件</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <div class="property-location" style="font-size: 14px; color: #666; margin-bottom: 15px;">
                                    <?php echo get_post_meta(get_the_ID(), 'property_location', true) ?: 'Vị trí chưa xác định'; ?>
                                </div>
                                <div class="property-excerpt" style="margin: 15px 0; color: #666; font-size: 14px; line-height: 1.4;">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="property-btn" style="background: #333; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; transition: background 0.3s ease; width: 100%; display: inline-block; text-align: center; text-decoration: none;">
                                    <?php 'Xem chi tiết'; ?>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <!-- ページネーション -->
                <div class="pagination" style="text-align: center; margin-top: 50px;">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '« ' . 'Trước',
                        'next_text' => 'Tiếp' . ' »',
                        'type'      => 'list',
                        'mid_size'  => 2,
                        'end_size'  => 1,
                    ));
                    ?>
                </div>
                
            <?php else : ?>
                <!-- 検索結果なし -->
                <div class="no-results" style="text-align: center; padding: 60px 20px;">
                    <h3 style="color: #666; margin-bottom: 20px;"><?php 'Không tìm thấy bất động sản nào phù hợp với tiêu chí tìm kiếm'; ?></h3>
                    <p style="color: #999; margin-bottom: 30px;"><?php 'Vui lòng thử thay đổi tiêu chí tìm kiếm.'; ?></p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="search-btn" style="text-decoration: none; display: inline-block;"><?php 'Xem tất cả bất động sản'; ?></a>
                </div>
            <?php endif; ?>
            
        </div>
    </section>
    
</main>

<!-- 表示切り替えJavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    const propertiesContainer = document.getElementById('properties-container');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // アクティブボタンの切り替え
            viewButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.style.background = '#e5e5e5';
                btn.style.color = '#333';
            });
            
            this.classList.add('active');
            this.style.background = '#dc2626';
            this.style.color = 'white';
            
            // 表示スタイルの切り替え
            if (this.dataset.view === 'list') {
                propertiesContainer.style.gridTemplateColumns = '1fr';
                propertiesContainer.classList.add('list-view');
            } else {
                propertiesContainer.style.gridTemplateColumns = 'repeat(auto-fit, minmax(300px, 1fr))';
                propertiesContainer.classList.remove('list-view');
            }
        });
    });
});
</script>

<style>
.property-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.property-btn:hover {
    background: #dc2626 !important;
}

.list-view .property-card {
    display: flex;
    flex-direction: row;
    max-width: none;
}

.list-view .property-image {
    width: 300px;
    height: 200px;
    flex-shrink: 0;
}

.list-view .property-content {
    flex: 1;
    padding: 30px;
}

@media (max-width: 768px) {
    .list-view .property-card {
        flex-direction: column;
    }
    
    .list-view .property-image {
        width: 100%;
    }
    
    .properties-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php
include get_template_directory() . '/parts/footer.php';
?>
