<?php get_header(); ?>

<main id="main" class="site-main">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- ページヘッダー -->
        <section class="page-header" style="padding: 100px 0 60px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            <div class="container">
                <h1 style="font-size: 36px; text-align: center; color: #333; margin-bottom: 20px;"><?php the_title(); ?></h1>
                <?php if (get_the_excerpt()) : ?>
                    <p style="text-align: center; color: #666; font-size: 16px;"><?php the_excerpt(); ?></p>
                <?php endif; ?>
            </div>
        </section>
        
        <!-- パンくずリスト -->
        <section class="breadcrumb" style="padding: 20px 0; background-color: white; border-bottom: 1px solid #e5e5e5;">
            <div class="container">
                <nav style="font-size: 14px; color: #666;">
                    <a href="<?php echo esc_url(home_url('/')); ?>" style="color: #dc2626; text-decoration: none;">ホーム</a>
                    <span style="margin: 0 10px;">></span>
                    <span><?php the_title(); ?></span>
                </nav>
            </div>
        </section>
        
        <!-- メインコンテンツ -->
        <section class="page-content" style="padding: 60px 0;">
            <div class="container">
                <div style="max-width: 800px; margin: 0 auto;">
                    <div style="background: white; padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); line-height: 1.8;">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- お問い合わせセクション（特定のページでのみ表示） -->
        <?php if (is_page('contact') || is_page('about')) : ?>
            <section class="contact-section" style="padding: 60px 0; background-color: #f8f9fa;">
                <div class="container">
                    <div style="text-align: center;">
                        <h2 style="font-size: 28px; color: #333; margin-bottom: 20px;">お気軽にお問い合わせください</h2>
                        <p style="color: #666; margin-bottom: 30px;">新築マンションに関するご相談は専門スタッフがお答えいたします。</p>
                        <div style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap;">
                            <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; min-width: 200px;">
                                <h3 style="color: #dc2626; margin-bottom: 15px;">電話でのお問い合わせ</h3>
                                <div style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">03-1234-5678</div>
                                <div style="font-size: 14px; color: #666;">営業時間: 9:00-18:00<br>（土日祝日除く）</div>
                            </div>
                            <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); text-align: center; min-width: 200px;">
                                <h3 style="color: #dc2626; margin-bottom: 15px;">メールでのお問い合わせ</h3>
                                <p style="color: #666; margin-bottom: 20px;">24時間受付可能</p>
                                <a href="<?php echo esc_url(home_url('/contact/')); ?>" style="background: #dc2626; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold;">
                                    お問い合わせフォーム
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        
    <?php endwhile; ?>
    
</main>

<?php get_footer(); ?>
