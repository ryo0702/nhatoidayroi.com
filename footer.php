<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <!-- 会社情報 -->
            <div class="footer-section">
                <h3>会社情報</h3>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/about/')); ?>">会社概要</a></li>
                    <li><a href="<?php echo esc_url(home_url('/company/')); ?>">企業情報</a></li>
                    <li><a href="<?php echo esc_url(home_url('/recruit/')); ?>">採用情報</a></li>
                    <li><a href="<?php echo esc_url(home_url('/news/')); ?>">お知らせ</a></li>
                </ul>
            </div>
            
            <!-- 物件情報 -->
            <div class="footer-section">
                <h3>物件情報</h3>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/mansions/')); ?>">マンション一覧</a></li>
                    <li><a href="<?php echo esc_url(home_url('/mansions/?area=tokyo')); ?>">東京都内</a></li>
                    <li><a href="<?php echo esc_url(home_url('/mansions/?area=osaka')); ?>">大阪府内</a></li>
                    <li><a href="<?php echo esc_url(home_url('/mansions/?area=kanagawa')); ?>">神奈川県内</a></li>
                </ul>
            </div>
            
            <!-- サポート -->
            <div class="footer-section">
                <h3>サポート</h3>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a></li>
                    <li><a href="<?php echo esc_url(home_url('/faq/')); ?>">よくある質問</a></li>
                    <li><a href="<?php echo esc_url(home_url('/support/')); ?>">購入サポート</a></li>
                    <li><a href="<?php echo esc_url(home_url('/privacy/')); ?>">プライバシーポリシー</a></li>
                </ul>
            </div>
            
            <!-- ウィジェットエリア -->
            <div class="footer-section">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <?php dynamic_sidebar('footer-1'); ?>
                <?php else : ?>
                    <h3>お問い合わせ</h3>
                    <p>新築マンションに関するご相談は<br>お気軽にお問い合わせください。</p>
                    <p><strong>TEL: 03-1234-5678</strong></p>
                    <p>営業時間: 9:00-18:00<br>（土日祝日除く）</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<!-- モバイルメニューのJavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            mobileMenuToggle.classList.toggle('active');
        });
    }
});
</script>

</body>
</html>
