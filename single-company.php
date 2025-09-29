<?php
include get_template_directory() . '/parts/header.php';
?>

<main id="main" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        <section class="company-header" style="padding: 100px 0 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            <div class="container">
                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 40px; align-items: center;">
                    <div class="company-logo" style="text-align: center;">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title(); ?>" style="max-width: 200px; max-height: 200px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <?php else : ?>
                            <div style="width: 200px; height: 200px; background: #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <span style="color: #999; font-size: 18px;">Logo công ty</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="company-info">
                        <h1 style="font-size: 36px; color: #333; margin-bottom: 20px;"><?php the_title(); ?></h1>
                        
                        <div class="company-meta" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                            <?php
                            // エリア表示
                            $areas = get_the_terms(get_the_ID(), 'area');
                            if ($areas && !is_wp_error($areas)) {
                                echo '<div class="meta-item">';
                                echo '<strong>Khu vực:</strong><br>';
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
                                echo '<div class="meta-item">';
                                echo '<strong>Lĩnh vực kinh doanh:</strong><br>';
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
                                echo '<div class="meta-item">';
                                echo '<strong>Quy mô công ty:</strong><br>' . $sizes[0]->name;
                                echo '</div>';
                            }
                            
                            // 設立年表示
                            $established_year = get_post_meta(get_the_ID(), '_company_established_year', true);
                            if ($established_year) {
                                echo '<div class="meta-item">';
                                echo '<strong>Năm thành lập:</strong><br>' . $established_year;
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="company-content" style="padding: 60px 0;">
            <div class="container">
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
                    
                    <!-- メインコンテンツ -->
                    <div class="main-content">
                        <!-- 会社概要 -->
                        <div class="company-description" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                            <h2 style="font-size: 24px; color: #333; margin-bottom: 25px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Giới thiệu công ty</h2>
                            <div class="content" style="line-height: 1.8; color: #555;">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <!-- 会社詳細情報 -->
                        <div class="company-details" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                            <h2 style="font-size: 24px; color: #333; margin-bottom: 25px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Thông tin chi tiết</h2>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                                <?php
                                $employees = get_post_meta(get_the_ID(), '_company_employees', true);
                                $capital = get_post_meta(get_the_ID(), '_company_capital', true);
                                $website = get_post_meta(get_the_ID(), '_company_website', true);
                                
                                if ($employees) {
                                    echo '<div class="detail-item">';
                                    echo '<label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">Số nhân viên</label>';
                                    echo '<span>' . number_format($employees) . ' người</span>';
                                    echo '</div>';
                                }
                                
                                if ($capital) {
                                    echo '<div class="detail-item">';
                                    echo '<label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">Vốn điều lệ</label>';
                                    echo '<span>' . number_format($capital, 0, ',', '.') . ' VND</span>';
                                    echo '</div>';
                                }
                                
                                if ($website) {
                                    echo '<div class="detail-item">';
                                    echo '<label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">Website</label>';
                                    echo '<a href="' . esc_url($website) . '" target="_blank" style="color: #dc2626; text-decoration: none;">' . esc_html($website) . '</a>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- サイドバー -->
                    <div class="sidebar">
                        <!-- 連絡先情報 -->
                        <div class="contact-info" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 30px;">
                            <h3 style="font-size: 20px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Thông tin liên hệ</h3>
                            
                            <?php
                            $phone = get_post_meta(get_the_ID(), '_company_phone', true);
                            $email = get_post_meta(get_the_ID(), '_company_email', true);
                            $address = get_post_meta(get_the_ID(), '_company_address', true);
                            $contact_person = get_post_meta(get_the_ID(), '_company_contact_person', true);
                            
                            if ($phone) {
                                echo '<div style="margin-bottom: 15px;">';
                                echo '<strong>Điện thoại:</strong><br>';
                                echo '<a href="tel:' . esc_attr($phone) . '" style="color: #dc2626; text-decoration: none;">' . esc_html($phone) . '</a>';
                                echo '</div>';
                            }
                            
                            if ($email) {
                                echo '<div style="margin-bottom: 15px;">';
                                echo '<strong>Email:</strong><br>';
                                echo '<a href="mailto:' . esc_attr($email) . '" style="color: #dc2626; text-decoration: none;">' . esc_html($email) . '</a>';
                                echo '</div>';
                            }
                            
                            if ($address) {
                                echo '<div style="margin-bottom: 15px;">';
                                echo '<strong>Địa chỉ:</strong><br>';
                                echo '<span style="color: #555;">' . esc_html($address) . '</span>';
                                echo '</div>';
                            }
                            
                            if ($contact_person) {
                                echo '<div style="margin-bottom: 15px;">';
                                echo '<strong>Người liên hệ:</strong><br>';
                                echo '<span style="color: #555;">' . esc_html($contact_person) . '</span>';
                                echo '</div>';
                            }
                            ?>
                            
                            <div style="margin-top: 20px;">
                                <a href="#contact-form" class="contact-btn" style="background: #dc2626; color: white; padding: 12px 24px; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; transition: background 0.3s ease; width: 100%; display: inline-block; text-align: center; text-decoration: none;">
                                    Liên hệ ngay
                                </a>
                            </div>
                        </div>

                        <!-- 関連プロジェクト -->
                        <div class="related-projects" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                            <h3 style="font-size: 20px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">Dự án liên quan</h3>
                            
                            <?php
                            // 同じエリアのプロジェクトを取得
                            $company_areas = get_the_terms(get_the_ID(), 'area');
                            if ($company_areas && !is_wp_error($company_areas)) {
                                $area_ids = wp_list_pluck($company_areas, 'term_id');
                                
                                $related_projects = get_posts(array(
                                    'post_type' => 'project',
                                    'posts_per_page' => 3,
                                    'post_status' => 'publish',
                                    'post__not_in' => array(get_the_ID()),
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'area',
                                            'field'    => 'term_id',
                                            'terms'    => $area_ids,
                                        ),
                                    ),
                                ));
                                
                                if ($related_projects) {
                                    foreach ($related_projects as $project) {
                                        echo '<div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #eee;">';
                                        echo '<h4 style="margin: 0 0 8px 0; font-size: 16px;">';
                                        echo '<a href="' . get_permalink($project->ID) . '" style="color: #333; text-decoration: none;">' . get_the_title($project->ID) . '</a>';
                                        echo '</h4>';
                                        echo '<p style="margin: 0; color: #666; font-size: 14px; line-height: 1.4;">' . wp_trim_words(get_the_excerpt($project->ID), 15, '...') . '</p>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p style="color: #999; font-style: italic;">Chưa có dự án liên quan.</p>';
                                }
                            } else {
                                echo '<p style="color: #999; font-style: italic;">Chưa có dự án liên quan.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- お問い合わせフォーム -->
        <section id="contact-form" class="contact-form-section" style="padding: 60px 0; background: #f8f9fa;">
            <div class="container">
                <div style="max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <h2 style="font-size: 28px; color: #333; margin-bottom: 30px; text-align: center;">Liên hệ với chúng tôi</h2>
                    
                    <form class="contact-form" method="post" action="">
                        <?php wp_nonce_field('company_contact', 'company_contact_nonce'); ?>
                        <input type="hidden" name="company_id" value="<?php echo get_the_ID(); ?>">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label for="contact_name">Họ và tên *</label>
                                <input type="text" id="contact_name" name="contact_name" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_email">Email *</label>
                                <input type="email" id="contact_email" name="contact_email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                            </div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label for="contact_phone">Số điện thoại</label>
                                <input type="tel" id="contact_phone" name="contact_phone" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                            </div>
                            
                            <div class="form-group">
                                <label for="contact_subject">Chủ đề</label>
                                <select id="contact_subject" name="contact_subject" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                                    <option value="">Chọn chủ đề</option>
                                    <option value="inquiry">Tư vấn dự án</option>
                                    <option value="partnership">Hợp tác</option>
                                    <option value="investment">Đầu tư</option>
                                    <option value="other">Khác</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="contact_message">Nội dung *</label>
                            <textarea id="contact_message" name="contact_message" rows="5" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; resize: vertical;"></textarea>
                        </div>
                        
                        <div class="form-group" style="text-align: center;">
                            <button type="submit" name="submit_contact" class="submit-btn" style="background: #dc2626; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background 0.3s ease;">
                                Gửi tin nhắn
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    <?php endwhile; ?>
</main>

<?php
include get_template_directory() . '/parts/footer.php';
?>
