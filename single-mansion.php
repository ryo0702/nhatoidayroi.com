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
                        <p style="color: #666; font-size: 16px;"><?php echo get_post_meta(get_the_ID(), 'mansion_location', true) ?: '所在地未定'; ?></p>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 28px; font-weight: bold; color: #dc2626; margin-bottom: 5px;">
                            <?php 
                            $price = get_post_meta(get_the_ID(), 'mansion_price', true);
                            if ($price) {
                                echo '¥' . number_format($price) . '万円';
                            } else {
                                echo '価格お問い合わせ';
                            }
                            ?>
                        </div>
                        <div style="color: #666; font-size: 14px;">
                            <?php echo get_post_meta(get_the_ID(), 'mansion_rooms', true) ?: '間取り未定'; ?>
                            <?php if (get_post_meta(get_the_ID(), 'mansion_size', true)) : ?>
                                | <?php echo get_post_meta(get_the_ID(), 'mansion_size', true); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- メインコンテンツ -->
        <section class="mansion-detail" style="padding: 60px 0;">
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
                                    画像準備中
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- 物件詳細情報 -->
                        <div class="mansion-info" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                            <h2 style="font-size: 24px; color: #333; margin-bottom: 25px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">物件詳細</h2>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">所在地</label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'mansion_location', true) ?: '未定'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">価格</label>
                                    <span style="color: #dc2626; font-weight: bold;">
                                        <?php 
                                        $price = get_post_meta(get_the_ID(), 'mansion_price', true);
                                        if ($price) {
                                            echo '¥' . number_format($price) . '万円';
                                        } else {
                                            echo 'お問い合わせ';
                                        }
                                        ?>
                                    </span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">間取り</label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'mansion_rooms', true) ?: '未定'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">専有面積</label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'mansion_size', true) ?: '未定'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">築年数</label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'mansion_age', true) ?: '未定'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">構造</label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'mansion_structure', true) ?: '未定'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">交通</label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'mansion_access', true) ?: '未定'; ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <label style="font-weight: bold; color: #666; display: block; margin-bottom: 5px;">管理費</label>
                                    <span><?php echo get_post_meta(get_the_ID(), 'mansion_management_fee', true) ?: '未定'; ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 物件説明 -->
                        <div class="mansion-description" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                            <h2 style="font-size: 24px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">物件説明</h2>
                            <div style="line-height: 1.8; color: #555;">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                        <!-- 設備・仕様 -->
                        <?php 
                        $facilities = get_post_meta(get_the_ID(), 'mansion_facilities', true);
                        if ($facilities) : 
                        ?>
                            <div class="mansion-facilities" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                                <h2 style="font-size: 24px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">設備・仕様</h2>
                                <div style="line-height: 1.8; color: #555;">
                                    <?php echo wpautop($facilities); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- 周辺環境 -->
                        <?php 
                        $surroundings = get_post_meta(get_the_ID(), 'mansion_surroundings', true);
                        if ($surroundings) : 
                        ?>
                            <div class="mansion-surroundings" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 40px;">
                                <h2 style="font-size: 24px; color: #333; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">周辺環境</h2>
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
                            <h3 style="font-size: 20px; margin-bottom: 15px;">お問い合わせ</h3>
                            <p style="margin-bottom: 20px; line-height: 1.5;">この物件について<br>詳しく知りたい方は<br>お気軽にお問い合わせください</p>
                            <div style="margin-bottom: 20px;">
                                <div style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">03-1234-5678</div>
                                <div style="font-size: 14px; opacity: 0.9;">営業時間: 9:00-18:00（土日祝除く）</div>
                            </div>
                            <a href="<?php echo esc_url(home_url('/contact/')); ?>" style="background: white; color: #dc2626; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block; transition: all 0.3s ease;">
                                お問い合わせフォーム
                            </a>
                        </div>
                        
                        <!-- 資料請求 -->
                        <div class="document-request" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 30px; text-align: center;">
                            <h3 style="font-size: 18px; color: #333; margin-bottom: 15px;">資料請求</h3>
                            <p style="color: #666; font-size: 14px; margin-bottom: 20px; line-height: 1.5;">
                                この物件の詳細資料を<br>無料でお送りいたします
                            </p>
                            <a href="<?php echo esc_url(home_url('/contact/?subject=資料請求&mansion=' . get_the_ID())); ?>" style="background: #333; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 14px; display: inline-block;">
                                資料を請求する
                            </a>
                        </div>
                        
                        <!-- 見学予約 -->
                        <div class="inspection-booking" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 30px; text-align: center;">
                            <h3 style="font-size: 18px; color: #333; margin-bottom: 15px;">見学予約</h3>
                            <p style="color: #666; font-size: 14px; margin-bottom: 20px; line-height: 1.5;">
                                実際に物件を見学して<br>ご検討いただけます
                            </p>
                            <a href="<?php echo esc_url(home_url('/contact/?subject=見学予約&mansion=' . get_the_ID())); ?>" style="background: #28a745; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 14px; display: inline-block;">
                                見学を予約する
                            </a>
                        </div>
                        
                        <!-- 関連物件 -->
                        <?php
                        $related_mansions = new WP_Query(array(
                            'post_type'      => 'mansion',
                            'posts_per_page' => 3,
                            'post__not_in'   => array(get_the_ID()),
                            'orderby'        => 'rand',
                        ));
                        
                        if ($related_mansions->have_posts()) :
                        ?>
                            <div class="related-mansions" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                <h3 style="font-size: 18px; color: #333; margin-bottom: 20px;">関連物件</h3>
                                <?php while ($related_mansions->have_posts()) : $related_mansions->the_post(); ?>
                                    <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
                                        <div style="display: flex; gap: 15px;">
                                            <div style="width: 80px; height: 60px; background-size: cover; background-position: center; border-radius: 5px; flex-shrink: 0;" 
                                                 style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: get_template_directory_uri() . '/images/default-mansion.jpg'; ?>')">
                                            </div>
                                            <div style="flex: 1;">
                                                <h4 style="font-size: 14px; margin-bottom: 5px;">
                                                    <a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none;">
                                                        <?php echo wp_trim_words(get_the_title(), 8); ?>
                                                    </a>
                                                </h4>
                                                <div style="font-size: 12px; color: #dc2626; font-weight: bold;">
                                                    <?php 
                                                    $price = get_post_meta(get_the_ID(), 'mansion_price', true);
                                                    if ($price) {
                                                        echo '¥' . number_format($price) . '万円';
                                                    } else {
                                                        echo '価格お問い合わせ';
                                                    }
                                                    ?>
                                                </div>
                                                <div style="font-size: 12px; color: #666;">
                                                    <?php echo get_post_meta(get_the_ID(), 'mansion_rooms', true) ?: '間取り未定'; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                                <div style="text-align: center;">
                                    <a href="<?php echo esc_url(home_url('/mansions/')); ?>" style="color: #dc2626; text-decoration: none; font-size: 14px;">すべての物件を見る</a>
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
