<?php
include get_template_directory() . '/parts/header.php';
?>

<main id="main" class="site-main">
    
    <!-- ページヘッダー -->
    <section class="page-header" style="padding: 100px 0 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <h1 style="font-size: 36px; text-align: center; color: #333; margin-bottom: 20px;"><?php 'Danh sách dự án'; ?></h1>
            <p style="text-align: center; color: #666; font-size: 16px;"><?php 'Giới thiệu các dự án chúng tôi đã thực hiện'; ?></p>
        </div>
    </section>
    
    <!-- エリアフィルター -->
    <section class="filter-section" style="padding: 40px 0; background-color: white; border-bottom: 1px solid #e5e5e5;">
        <div class="container">
            <form class="filter-form" method="get" action="">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                    
                    <div class="form-group">
                        <label for="filter_area"><?php 'Khu vực'; ?></label>
                        <select id="filter_area" name="area">
                            <option value=""><?php 'Tất cả khu vực'; ?></option>
                            <?php
                            $areas = get_terms(array(
                                'taxonomy' => 'area',
                                'hide_empty' => false,
                            ));
                            
                            if (!empty($areas) && !is_wp_error($areas)) {
                                foreach ($areas as $area) {
                                    $selected = ($_GET['area'] ?? '') === $area->slug ? 'selected' : '';
                                    echo '<option value="' . esc_attr($area->slug) . '" ' . $selected . '>' . esc_html($area->name) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="search-btn"><?php 'Lọc'; ?></button>
                        <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>" class="search-btn" style="background: #6c757d; margin-left: 10px; text-decoration: none; display: inline-block;"><?php 'Đặt lại'; ?></a>
                    </div>
                </div>
            </form>
        </div>
    </section>
    
    <!-- プロジェクト一覧 -->
    <section class="projects-section" style="padding: 60px 0;">
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
                
                <!-- プロジェクトグリッド -->
                <div class="projects-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px;">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="project-card" style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;">
                            <div class="project-image" style="width: 100%; height: 250px; background-size: cover; background-position: center; position: relative; background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large') ?: get_template_directory_uri() . '/images/nophoto.png'; ?>')">
                                <?php if (get_post_meta(get_the_ID(), 'featured', true) === 'yes') : ?>
                                    <div style="position: absolute; top: 15px; right: 15px; background: #dc2626; color: white; padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600;"><?php 'Đề xuất'; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="project-content" style="padding: 25px;">
                                <h3 class="project-title" style="font-size: 20px; font-weight: 600; margin-bottom: 10px; color: #333;">
                                    <a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none;">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                
                                <!-- プロジェクト詳細 -->
                                <div class="project-details" style="margin-bottom: 15px;">
                                    <?php 
                                    $location = get_post_meta(get_the_ID(), 'project_location', true);
                                    $completion_date = get_post_meta(get_the_ID(), 'project_completion_date', true);
                                    $project_type = get_post_meta(get_the_ID(), 'project_type', true);
                                    ?>
                                    
                                    <?php if ($location) : ?>
                                        <div style="margin-bottom: 5px; color: #666; font-size: 14px;">
                                            <strong><?php 'Vị trí'; ?>:</strong> <?php echo esc_html($location); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($project_type) : ?>
                                        <div style="margin-bottom: 5px; color: #666; font-size: 14px;">
                                            <strong><?php 'Loại dự án'; ?>:</strong> <?php echo esc_html($project_type); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($completion_date) : ?>
                                        <div style="margin-bottom: 5px; color: #666; font-size: 14px;">
                                            <strong><?php 'Ngày hoàn thành'; ?>:</strong> <?php echo esc_html($completion_date); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- エリアタグ -->
                                <div class="project-areas" style="margin-bottom: 15px;">
                                    <?php
                                    $project_areas = get_the_terms(get_the_ID(), 'area');
                                    if ($project_areas && !is_wp_error($project_areas)) {
                                        foreach ($project_areas as $area) {
                                            echo '<span style="background: #f8f9fa; color: #333; padding: 3px 8px; border-radius: 3px; font-size: 12px; margin-right: 5px; display: inline-block; margin-bottom: 5px;">' . esc_html($area->name) . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <!-- プロジェクト説明 -->
                                <div class="project-excerpt" style="color: #666; font-size: 14px; line-height: 1.4; margin-bottom: 20px;">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="project-btn" style="background: #dc2626; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 14px; display: inline-block; transition: background 0.3s ease;">
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
                    <h3 style="color: #666; margin-bottom: 20px;"><?php 'Không tìm thấy dự án nào'; ?></h3>
                    <p style="color: #999; margin-bottom: 30px;"><?php 'Vui lòng thử thay đổi tiêu chí tìm kiếm.'; ?></p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>" class="search-btn" style="text-decoration: none; display: inline-block;"><?php 'Xem tất cả dự án'; ?></a>
                </div>
            <?php endif; ?>
            
        </div>
    </section>
    
</main>

<style>
.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.project-btn:hover {
    background: #b91c1c !important;
}

@media (max-width: 768px) {
    .projects-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php
include get_template_directory() . '/parts/footer.php';
?>
