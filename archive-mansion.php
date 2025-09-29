<?php
include get_template_directory() . '/parts/header.php';
?>

<main id="main" class="site-main">
    
    <!-- ページヘッダー -->
    <section class="page-header" style="padding: 100px 0 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <h1 style="font-size: 36px; text-align: center; color: #333; margin-bottom: 20px;">マンション一覧</h1>
            <p style="text-align: center; color: #666; font-size: 16px;">理想の住まいを見つけましょう</p>
        </div>
    </section>
    
    <!-- 検索フィルター -->
    <section class="filter-section" style="padding: 40px 0; background-color: white; border-bottom: 1px solid #e5e5e5;">
        <div class="container">
            <form class="filter-form" method="get" action="">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                    
                    <div class="form-group">
                        <label for="filter_location">エリア</label>
                        <input type="text" id="filter_location" name="location" value="<?php echo esc_attr($_GET['location'] ?? ''); ?>" placeholder="例：渋谷区">
                    </div>
                    
                    <div class="form-group">
                        <label for="filter_price_min">価格（下限）</label>
                        <select id="filter_price_min" name="price_min">
                            <option value="">選択してください</option>
                            <option value="3000" <?php selected($_GET['price_min'] ?? '', '3000'); ?>>3,000万円以上</option>
                            <option value="4000" <?php selected($_GET['price_min'] ?? '', '4000'); ?>>4,000万円以上</option>
                            <option value="5000" <?php selected($_GET['price_min'] ?? '', '5000'); ?>>5,000万円以上</option>
                            <option value="6000" <?php selected($_GET['price_min'] ?? '', '6000'); ?>>6,000万円以上</option>
                            <option value="8000" <?php selected($_GET['price_min'] ?? '', '8000'); ?>>8,000万円以上</option>
                            <option value="10000" <?php selected($_GET['price_min'] ?? '', '10000'); ?>>1億円以上</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="filter_price_max">価格（上限）</label>
                        <select id="filter_price_max" name="price_max">
                            <option value="">選択してください</option>
                            <option value="4000" <?php selected($_GET['price_max'] ?? '', '4000'); ?>>4,000万円以下</option>
                            <option value="5000" <?php selected($_GET['price_max'] ?? '', '5000'); ?>>5,000万円以下</option>
                            <option value="6000" <?php selected($_GET['price_max'] ?? '', '6000'); ?>>6,000万円以下</option>
                            <option value="8000" <?php selected($_GET['price_max'] ?? '', '8000'); ?>>8,000万円以下</option>
                            <option value="10000" <?php selected($_GET['price_max'] ?? '', '10000'); ?>>1億円以下</option>
                            <option value="15000" <?php selected($_GET['price_max'] ?? '', '15000'); ?>>1.5億円以下</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="filter_rooms">間取り</label>
                        <select id="filter_rooms" name="rooms">
                            <option value="">選択してください</option>
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
                        <label for="filter_area">エリア分類</label>
                        <select id="filter_area" name="area">
                            <option value="">選択してください</option>
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
                            } else {
                                // デフォルトのエリアオプション
                                $default_areas = array('tokyo' => '東京都', 'osaka' => '大阪府', 'kanagawa' => '神奈川県', 'chiba' => '千葉県', 'saitama' => '埼玉県');
                                foreach ($default_areas as $slug => $name) {
                                    $selected = ($_GET['area'] ?? '') === $slug ? 'selected' : '';
                                    echo '<option value="' . esc_attr($slug) . '" ' . $selected . '>' . esc_html($name) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="search-btn">絞り込み</button>
                        <a href="<?php echo esc_url(get_post_type_archive_link('mansion')); ?>" class="search-btn" style="background: #6c757d; margin-left: 10px; text-decoration: none; display: inline-block;">リセット</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
    
    <!-- マンション一覧 -->
    <section class="mansions-section" style="padding: 60px 0;">
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
                    <button class="view-btn active" data-view="grid" style="background: #dc2626; color: white; border: none; padding: 8px 15px; margin-right: 5px; border-radius: 3px; cursor: pointer;">グリッド表示</button>
                    <button class="view-btn" data-view="list" style="background: #e5e5e5; color: #333; border: none; padding: 8px 15px; border-radius: 3px; cursor: pointer;">リスト表示</button>
                </div>
                
                <!-- マンションカード -->
                <div class="mansions-grid" id="mansions-container">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="mansion-card">
                            <div class="mansion-image" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'mansion-thumbnail') ?: get_template_directory_uri() . '/images/nophoto.png'; ?>')">
                                <?php if (get_post_meta(get_the_ID(), 'featured', true) === 'yes') : ?>
                                    <div class="mansion-badge">おすすめ</div>
                                <?php endif; ?>
                                <?php if (get_post_meta(get_the_ID(), 'new', true) === 'yes') : ?>
                                    <div class="mansion-badge" style="background: #28a745; top: 50px;">NEW</div>
                                <?php endif; ?>
                            </div>
                            <div class="mansion-content">
                                <h3 class="mansion-title">
                                    <a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none;">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <div class="mansion-price">
                                    <?php 
                                    $price = get_post_meta(get_the_ID(), 'mansion_price', true);
                                    if ($price) {
                                        echo '¥' . number_format($price) . '万円';
                                    } else {
                                        echo '価格お問い合わせ';
                                    }
                                    ?>
                                </div>
                                <div class="mansion-details">
                                    <span><?php echo get_post_meta(get_the_ID(), 'mansion_rooms', true) ?: '間取り未定'; ?></span>
                                    <span><?php echo get_post_meta(get_the_ID(), 'mansion_size', true) ?: '面積未定'; ?></span>
                                    <span><?php echo get_post_meta(get_the_ID(), 'mansion_age', true) ?: '築年数未定'; ?></span>
                                </div>
                                <div class="mansion-location">
                                    <?php echo get_post_meta(get_the_ID(), 'mansion_location', true) ?: '所在地未定'; ?>
                                </div>
                                <div class="mansion-excerpt" style="margin: 15px 0; color: #666; font-size: 14px; line-height: 1.4;">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="mansion-btn">詳細を見る</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                
                <!-- ページネーション -->
                <div class="pagination" style="text-align: center; margin-top: 50px;">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '« 前へ',
                        'next_text' => '次へ »',
                        'type'      => 'list',
                        'mid_size'  => 2,
                        'end_size'  => 1,
                    ));
                    ?>
                </div>
                
            <?php else : ?>
                <!-- 検索結果なし -->
                <div class="no-results" style="text-align: center; padding: 60px 20px;">
                    <h3 style="color: #666; margin-bottom: 20px;">検索条件に一致するマンションが見つかりませんでした</h3>
                    <p style="color: #999; margin-bottom: 30px;">検索条件を変更してお探しください。</p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('mansion')); ?>" class="search-btn" style="text-decoration: none; display: inline-block;">すべてのマンションを見る</a>
                </div>
            <?php endif; ?>
            
        </div>
    </section>
    
</main>

<!-- 表示切り替えJavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    const mansionsContainer = document.getElementById('mansions-container');
    
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
                mansionsContainer.style.gridTemplateColumns = '1fr';
                mansionsContainer.classList.add('list-view');
            } else {
                mansionsContainer.style.gridTemplateColumns = 'repeat(auto-fit, minmax(300px, 1fr))';
                mansionsContainer.classList.remove('list-view');
            }
        });
    });
});
</script>

<style>
.list-view .mansion-card {
    display: flex;
    flex-direction: row;
    max-width: none;
}

.list-view .mansion-image {
    width: 300px;
    height: 200px;
    flex-shrink: 0;
}

.list-view .mansion-content {
    flex: 1;
    padding: 30px;
}

@media (max-width: 768px) {
    .list-view .mansion-card {
        flex-direction: column;
    }
    
    .list-view .mansion-image {
        width: 100%;
    }
}
</style>

<?php
include get_template_directory() . '/parts/footer.php';
?>
