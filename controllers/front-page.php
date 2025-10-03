<?php
include get_template_directory() . '/parts/header.php';
?>
<main id="main" class="site-main">
    <?php if (isset($_GET['loggedout']) && $_GET['loggedout'] === 'true') : ?>
        <div style="background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; margin: 20px auto; max-width: 1200px; border-radius: 8px; text-align: center;">
            <strong>👋 Đã đăng xuất thành công!</strong><br>
            Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['register']) && $_GET['register'] === 'success') : ?>
        <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin: 20px auto; max-width: 1200px; border-radius: 8px; text-align: center;">
            <strong>✅ Đăng ký thành công!</strong><br>
            Chào mừng bạn đến với dịch vụ của chúng tôi.
        </div>
    <?php endif; ?>
    <?php
    include get_template_directory() . '/parts/hero-slider.php';
    include get_template_directory() . '/parts/serach-form.php';
    include get_template_directory() . '/parts/cta-email.php';
    include get_template_directory() . '/parts/archive-top-project.php';
    include get_template_directory() . '/parts/cta-email.php';
    include get_template_directory() . '/parts/archive-top-new-mansions.php';
    include get_template_directory() . '/parts/archive-top-used-mansions.php';
    include get_template_directory() . '/parts/cta-email.php';
    include get_template_directory() . '/parts/archive-top-news.php';
    ?>
</main>
<?php
include get_template_directory() . '/parts/footer.php';
?>