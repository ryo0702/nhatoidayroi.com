<section class="projects-section" style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        <h2 class="section-title" style="text-align: center; margin-bottom: 40px; font-size: 32px; color: #333;">Dự án nổi bật</h2>
        
        <?php
        // プロジェクトのクエリ
        $featured_projects = new WP_Query(array(
            'post_type'      => 'project',
            'posts_per_page' => 6,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        
        if ($featured_projects->have_posts()) :
        ?>
            <div class="projects-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; margin-bottom: 40px;">
                <?php while ($featured_projects->have_posts()) : $featured_projects->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="project-card-link">
                        <div class="project-card" style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden; transition: transform 0.3s ease; cursor: pointer;">
                            <div class="project-image" style="width: 100%; height: 200px; background-size: cover; background-position: center; background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'mansion-thumbnail') ?: get_template_directory_uri() . '/images/default-project.jpg'; ?>')">
                            </div>
                            <div class="project-content" style="padding: 25px;">
                                <h3 style="font-size: 20px; color: #333; margin-bottom: 15px; line-height: 1.4;"><?php the_title(); ?></h3>
                                <div class="project-excerpt" style="color: #666; margin-bottom: 20px; line-height: 1.6;">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </div>
                                <div class="project-meta" style="margin-bottom: 20px;">
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
                                    
                                    // 総戸数表示
                                    $total_units = get_post_meta(get_the_ID(), '_project_total_units', true);
                                    if ($total_units) {
                                        echo '<div style="margin-bottom: 8px;"><strong>Tổng số căn hộ:</strong> ' . number_format($total_units) . ' căn</div>';
                                    }
                                    
                                    // 土地面積表示
                                    $land_area = get_post_meta(get_the_ID(), '_project_land_area', true);
                                    if ($land_area) {
                                        echo '<div style="margin-bottom: 8px;"><strong>Diện tích đất:</strong> ' . $land_area . 'm²</div>';
                                    }
                                    ?>
                                </div>
                                <div class="project-btn" style="background: #dc2626; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; transition: background 0.3s ease; width: 100%; display: inline-block; text-align: center; text-decoration: none;">
                                    Xem chi tiết
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
            
            <div style="text-align: center;">
                <a href="<?php echo esc_url(home_url('/projects/')); ?>" class="search-btn" style="display: inline-block; text-decoration: none;">Xem tất cả dự án</a>
            </div>
        <?php else : ?>
            <div style="text-align: center; padding: 40px;">
                <p>現在、表示できるプロジェクトがありません。</p>
            </div>
        <?php endif; ?>
        
        <?php wp_reset_postdata(); ?>
    </div>
</section>