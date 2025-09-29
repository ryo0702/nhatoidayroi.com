<?php
include get_template_directory() . '/parts/header.php';
?>

<main id="main" class="site-main">
    <section class="page-header" style="padding: 100px 0 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <h1 style="font-size: 36px; text-align: center; color: #333; margin-bottom: 20px;">Danh sách công ty phát triển</h1>
            <p style="text-align: center; color: #666; font-size: 16px;">Tìm hiểu về các công ty phát triển bất động sản hàng đầu</p>
        </div>
    </section>

    <section class="companies-section" style="padding: 60px 0;">
        <div class="container">
            <!-- フィルター -->
            <div class="filter-section" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                <form method="get" class="filter-form">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px;">
                        
                        <div class="form-group">
                            <label for="filter_area">Khu vực</label>
                            <select id="filter_area" name="area">
                                <option value="">Tất cả khu vực</option>
                                <?php
                                $areas = get_terms(array(
                                    'taxonomy' => 'area',
                                    'hide_empty' => false,
                                ));
                                foreach ($areas as $area) {
                                    $selected = (isset($_GET['area']) && $_GET['area'] == $area->slug) ? 'selected' : '';
                                    echo '<option value="' . esc_attr($area->slug) . '" ' . $selected . '>' . esc_html($area->name) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="filter_sector">Lĩnh vực kinh doanh</label>
                            <select id="filter_sector" name="sector">
                                <option value="">Tất cả lĩnh vực</option>
                                <?php
                                $sectors = get_terms(array(
                                    'taxonomy' => 'company_sector',
                                    'hide_empty' => false,
                                ));
                                foreach ($sectors as $sector) {
                                    $selected = (isset($_GET['sector']) && $_GET['sector'] == $sector->slug) ? 'selected' : '';
                                    echo '<option value="' . esc_attr($sector->slug) . '" ' . $selected . '>' . esc_html($sector->name) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="filter_size">Quy mô công ty</label>
                            <select id="filter_size" name="size">
                                <option value="">Tất cả quy mô</option>
                                <?php
                                $sizes = get_terms(array(
                                    'taxonomy' => 'company_size',
                                    'hide_empty' => false,
                                ));
                                foreach ($sizes as $size) {
                                    $selected = (isset($_GET['size']) && $_GET['size'] == $size->slug) ? 'selected' : '';
                                    echo '<option value="' . esc_attr($size->slug) . '" ' . $selected . '>' . esc_html($size->name) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="search-btn">Lọc</button>
                            <a href="<?php echo esc_url(get_post_type_archive_link('company')); ?>" class="search-btn" style="background: #6c757d; margin-left: 10px; text-decoration: none; display: inline-block;">Đặt lại</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- 表示切り替えボタン -->
            <div class="view-toggle" style="text-align: right; margin-bottom: 30px;">
                <button class="view-btn active" data-view="grid" style="background: #dc2626; color: white; border: none; padding: 8px 15px; margin-right: 5px; border-radius: 3px; cursor: pointer;">Xem lưới</button>
                <button class="view-btn" data-view="list" style="background: #e5e5e5; color: #333; border: none; padding: 8px 15px; border-radius: 3px; cursor: pointer;">Xem danh sách</button>
            </div>

            <?php
            // クエリの設定
            $args = array(
                'post_type' => 'company',
                'posts_per_page' => 12,
                'post_status' => 'publish',
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
            );

            // タクソノミーフィルター
            $tax_query = array();
            
            if (!empty($_GET['area'])) {
                $tax_query[] = array(
                    'taxonomy' => 'area',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($_GET['area']),
                );
            }
            
            if (!empty($_GET['sector'])) {
                $tax_query[] = array(
                    'taxonomy' => 'company_sector',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($_GET['sector']),
                );
            }
            
            if (!empty($_GET['size'])) {
                $tax_query[] = array(
                    'taxonomy' => 'company_size',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($_GET['size']),
                );
            }
            
            if (!empty($tax_query)) {
                $args['tax_query'] = $tax_query;
            }

            $companies_query = new WP_Query($args);

            if ($companies_query->have_posts()) : ?>
                <div class="companies-grid" id="companies-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
                    <?php while ($companies_query->have_posts()) : $companies_query->the_post(); ?>
                        <div class="company-card" style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden; transition: transform 0.3s ease;">
                            <div class="company-image" style="width: 100%; height: 200px; background-size: cover; background-position: center; position: relative; background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'mansion-thumbnail') ?: get_template_directory_uri() . '/images/default-company.jpg'; ?>')">
                            </div>
                            
                            <div class="company-content" style="padding: 25px;">
                                <h3 style="font-size: 20px; color: #333; margin-bottom: 15px; line-height: 1.4;">
                                    <a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none;"><?php the_title(); ?></a>
                                </h3>
                                
                                <div class="company-excerpt" style="color: #666; margin-bottom: 20px; line-height: 1.6;">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </div>
                                
                                <div class="company-meta" style="margin-bottom: 20px;">
                                    <?php
                                    // エリア表示
                                    $areas = get_the_terms(get_the_ID(), 'area');
                                    if ($areas && !is_wp_error($areas)) {
                                        echo '<div style="margin-bottom: 8px;"><strong>Khu vực:</strong> ';
                                        $area_names = array();
                                        foreach ($areas as $area) {
                                            $area_names[] = $area->name;
                                        }
                                        echo implode(', ', $area_names);
                                        echo '</div>';
                                    }
                                    
                                    // 事業分野表示
                                    $sectors = get_the_terms(get_the_ID(), 'company_sector');
                                    if ($sectors && !is_wp_error($sectors)) {
                                        echo '<div style="margin-bottom: 8px;"><strong>Lĩnh vực:</strong> ';
                                        $sector_names = array();
                                        foreach ($sectors as $sector) {
                                            $sector_names[] = $sector->name;
                                        }
                                        echo implode(', ', $sector_names);
                                        echo '</div>';
                                    }
                                    
                                    // 会社規模表示
                                    $sizes = get_the_terms(get_the_ID(), 'company_size');
                                    if ($sizes && !is_wp_error($sizes)) {
                                        echo '<div style="margin-bottom: 8px;"><strong>Quy mô:</strong> ' . $sizes[0]->name . '</div>';
                                    }
                                    
                                    // 設立年表示
                                    $established_year = get_post_meta(get_the_ID(), '_company_established_year', true);
                                    if ($established_year) {
                                        echo '<div style="margin-bottom: 8px;"><strong>Thành lập:</strong> ' . $established_year . '</div>';
                                    }
                                    ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="company-btn" style="background: #dc2626; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; transition: background 0.3s ease; width: 100%; display: inline-block; text-align: center; text-decoration: none;">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- ページネーション -->
                <div class="pagination" style="text-align: center; margin-top: 40px;">
                    <?php
                    echo paginate_links(array(
                        'total' => $companies_query->max_num_pages,
                        'current' => max(1, get_query_var('paged')),
                        'format' => '?paged=%#%',
                        'show_all' => false,
                        'type' => 'list',
                        'end_size' => 2,
                        'mid_size' => 1,
                        'prev_next' => true,
                        'prev_text' => '← Trước',
                        'next_text' => 'Tiếp →',
                    ));
                    ?>
                </div>

            <?php else : ?>
                <!-- 検索結果なし -->
                <div class="no-results" style="text-align: center; padding: 60px 20px;">
                    <h3 style="color: #666; margin-bottom: 20px;">Không tìm thấy công ty phát triển nào</h3>
                    <p style="color: #999; margin-bottom: 30px;">Vui lòng thử thay đổi tiêu chí tìm kiếm.</p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('company')); ?>" class="search-btn" style="text-decoration: none; display: inline-block;">Xem tất cả công ty</a>
                </div>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    const container = document.getElementById('companies-container');
    
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
            const view = this.getAttribute('data-view');
            if (view === 'grid') {
                container.style.gridTemplateColumns = 'repeat(auto-fill, minmax(350px, 1fr))';
                container.style.gap = '30px';
            } else {
                container.style.gridTemplateColumns = '1fr';
                container.style.gap = '20px';
            }
        });
    });
});
</script>

<?php
include get_template_directory() . '/parts/footer.php';
?>
