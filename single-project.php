<?php
include get_template_directory() . '/parts/header.php';
?>

<main id="main" class="site-main">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- ページヘッダー -->
        <section class="page-header" style="padding: 100px 0 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            <div class="container">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                    <div>
                        <h1 style="font-size: 36px; color: #333; margin-bottom: 10px;"><?php the_title(); ?></h1>
                        <p style="color: #666; font-size: 16px;">
                            <?php 
                            $location = get_post_meta(get_the_ID(), 'project_location', true);
                            echo $location ? esc_html($location) : 'Vị trí chưa xác định';
                            ?>
                        </p>
                    </div>
                    <div style="text-align: right;">
                        <div style="color: #666; font-size: 14px; margin-bottom: 5px;">
                            <?php 
                            $completion_date = get_post_meta(get_the_ID(), 'project_completion_date', true);
                            if ($completion_date) {
                                echo 'Ngày hoàn thành' . ': ' . esc_html($completion_date);
                            }
                            ?>
                        </div>
                        <div style="color: #666; font-size: 14px;">
                            <?php 
                            $project_type = get_post_meta(get_the_ID(), 'project_type', true);
                            if ($project_type) {
                                echo 'Loại dự án' . ': ' . esc_html($project_type);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- メインコンテンツ -->
        <section class="project-detail" style="padding: 60px 0;">
            <div class="container">
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
                    
                    <!-- 左側：メインコンテンツ -->
                    <div class="main-content">
                        
                        <!-- メイン画像 -->
                        <div class="main-image" style="margin-bottom: 40px;">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: 400px; object-fit: cover; border-radius: 10px;')); ?>
                            <?php else : ?>
                                <div style="width: 100%; height: 400px; background: #f0f0f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #999;">
                                    Đang tải hình ảnh
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- プロジェクト詳細情報 -->
                        <div class="project-info" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                            <h2 style="font-size: 24px; color: #333; margin-bottom: 25px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Chi tiết dự án</h2>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">Vị trí</label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'project_location', true) ?: 'Chưa xác định'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">Loại dự án</label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'project_type', true) ?: 'Chưa xác định'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">Ngày hoàn thành</label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'project_completion_date', true) ?: 'Chưa xác định'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">Diện tích xây dựng</label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'project_area', true) ?: 'Chưa xác định'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">Cấu trúc</label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'project_structure', true) ?: 'Chưa xác định'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">Khu vực</label>
                                    <span>
                                        <?php
                                        $project_areas = get_the_terms(get_the_ID(), 'area');
                                        if ($project_areas && !is_wp_error($project_areas)) {
                                            $area_names = array();
                                            foreach ($project_areas as $area) {
                                                $area_names[] = $area->name;
                                            }
                                            echo implode(', ', $area_names);
                                        } else {
                                            echo 'Chưa xác định';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- プロジェクト説明 -->
                        <div class="project-description" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                            <h2 style="font-size: 24px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Tổng quan dự án</h2>
                            <div style="line-height: 1.8; color: #555;">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                        <!-- プロジェクト特徴 -->
                        <?php 
                        $features = get_post_meta(get_the_ID(), 'project_features', true);
                        if ($features) : 
                        ?>
                            <div class="project-features" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                                <h2 style="font-size: 24px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Đặc điểm dự án</h2>
                                <div style="line-height: 1.8; color: #555;">
                                    <?php echo wpautop($features); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    
                    <!-- 右側：サイドバー -->
                    <div class="sidebar">
                        
                        <!-- お問い合わせボックス -->
                        <div class="contact-box" style="background: #dc2626; color: white; padding: 30px; border-radius: 10px; margin-bottom: 30px; text-align: center;">
                            <h3 style="font-size: 20px; margin-bottom: 15px;">Liên hệ</h3>
                            <p style="margin-bottom: 20px; line-height: 1.5;">Về dự án này<br>Nếu bạn muốn biết thêm chi tiết<br>Vui lòng liên hệ với chúng tôi</p>
                            <div style="margin-bottom: 20px;">
                                <div style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">03-1234-5678</div>
                                <div style="font-size: 14px; opacity: 0.9;">Giờ làm việc: 9:00-18:00 (trừ thứ 7, chủ nhật và ngày lễ)</div>
                            </div>
                            <a href="<?php echo esc_url(home_url('/contact/')); ?>" style="background: white; color: #dc2626; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block; transition: all 0.3s ease;">
                                Biểu mẫu liên hệ
                            </a>
                        </div>
                        
                        <!-- 関連プロジェクト -->
                        <?php
                        $related_projects = new WP_Query(array(
                            'post_type'      => 'project',
                            'posts_per_page' => 3,
                            'post__not_in'   => array(get_the_ID()),
                            'orderby'        => 'rand',
                        ));
                        
                        if ($related_projects->have_posts()) :
                        ?>
                            <div class="related-projects" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                <h3 style="font-size: 18px; color: #333; margin-bottom: 20px;">Dự án liên quan</h3>
                                <?php while ($related_projects->have_posts()) : $related_projects->the_post(); ?>
                                    <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
                                        <div style="display: flex; gap: 15px;">
                                            <div style="width: 80px; height: 60px; background-size: cover; background-position: center; border-radius: 5px; flex-shrink: 0; background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: get_template_directory_uri() . '/images/nophoto.png'; ?>')">
                                            </div>
                                            <div style="flex: 1;">
                                                <h4 style="font-size: 14px; margin-bottom: 5px;">
                                                    <a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none;">
                                                        <?php echo wp_trim_words(get_the_title(), 8); ?>
                                                    </a>
                                                </h4>
                                                <div style="font-size: 12px; color: #666;">
                                                    <?php echo get_post_meta(get_the_ID(), 'project_location', true) ?: 'Vị trí chưa xác định'; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                                <div style="text-align: center;">
                                    <a href="<?php echo esc_url(home_url('/projects/')); ?>" style="color: #dc2626; text-decoration: none; font-size: 14px;">Xem tất cả dự án</a>
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

<?php
include get_template_directory() . '/parts/footer.php';
?>
