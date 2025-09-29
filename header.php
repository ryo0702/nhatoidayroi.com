<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
    <!-- 上段ナビゲーション -->
    <div class="top-nav">
        <div class="container">
            <div class="top-nav-content">
                <!-- ロゴ -->
                <div class="logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/logo-hanoi.png" alt="<?php bloginfo('name'); ?>" style="height: 40px; width: auto;">
                    </a>
                </div>
                
                <!-- ユーザーアクション -->
                <div class="user-actions">
                    <a href="<?php echo esc_url(home_url('/login/')); ?>" class="login-btn">Đăng nhập</a>
                    <a href="<?php echo esc_url(home_url('/register/')); ?>" class="register-btn">Đăng ký</a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="contact-btn">Liên hệ</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 下段ナビゲーション -->
    <div class="main-nav">
        <div class="container">
            <div class="main-nav-content">
                <!-- エリア別ナビゲーション -->
                <nav class="area-nav">
                    <div class="nav-item">
                        <a href="<?php echo esc_url(home_url('/area/hanoi-city/')); ?>" class="nav-link">
                            <span class="nav-icon">🏙️</span>
                            Hà Nội nội thành
                        </a>
                        <div class="dropdown-menu">
                            <a href="<?php echo esc_url(home_url('/area/ba-dinh/')); ?>">Ba Đình</a>
                            <a href="<?php echo esc_url(home_url('/area/hoan-kiem/')); ?>">Hoàn Kiếm</a>
                            <a href="<?php echo esc_url(home_url('/area/hai-ba-trung/')); ?>">Hai Bà Trưng</a>
                            <a href="<?php echo esc_url(home_url('/area/dong-da/')); ?>">Đống Đa</a>
                            <a href="<?php echo esc_url(home_url('/area/tay-ho/')); ?>">Tây Hồ</a>
                            <a href="<?php echo esc_url(home_url('/area/cau-giay/')); ?>">Cầu Giấy</a>
                            <a href="<?php echo esc_url(home_url('/area/thanh-xuan/')); ?>">Thanh Xuân</a>
                            <a href="<?php echo esc_url(home_url('/area/hoang-mai/')); ?>">Hoàng Mai</a>
                            <a href="<?php echo esc_url(home_url('/area/long-bien/')); ?>">Long Biên</a>
                            <a href="<?php echo esc_url(home_url('/area/nam-tu-liem/')); ?>">Nam Từ Liêm</a>
                            <a href="<?php echo esc_url(home_url('/area/bac-tu-liem/')); ?>">Bắc Từ Liêm</a>
                            <a href="<?php echo esc_url(home_url('/area/ha-dong/')); ?>">Hà Đông</a>
                        </div>
                    </div>
                    
                    <div class="nav-item">
                        <a href="<?php echo esc_url(home_url('/area/hanoi-suburb/')); ?>" class="nav-link">
                            <span class="nav-icon">🌳</span>
                            Hà Nội ngoại thành
                        </a>
                        <div class="dropdown-menu">
                            <a href="<?php echo esc_url(home_url('/area/son-tay/')); ?>">Sơn Tây</a>
                            <a href="<?php echo esc_url(home_url('/area/dong-anh/')); ?>">Đông Anh</a>
                            <a href="<?php echo esc_url(home_url('/area/gia-lam/')); ?>">Gia Lâm</a>
                            <a href="<?php echo esc_url(home_url('/area/soc-son/')); ?>">Sóc Sơn</a>
                            <a href="<?php echo esc_url(home_url('/area/thanh-tri/')); ?>">Thanh Trì</a>
                            <a href="<?php echo esc_url(home_url('/area/me-linh/')); ?>">Mê Linh</a>
                            <a href="<?php echo esc_url(home_url('/area/hoai-duc/')); ?>">Hoài Đức</a>
                            <a href="<?php echo esc_url(home_url('/area/thuong-tin/')); ?>">Thường Tín</a>
                            <a href="<?php echo esc_url(home_url('/area/thanh-oai/')); ?>">Thanh Oai</a>
                            <a href="<?php echo esc_url(home_url('/area/phu-xuyen/')); ?>">Phú Xuyên</a>
                            <a href="<?php echo esc_url(home_url('/area/quoc-oai/')); ?>">Quốc Oai</a>
                            <a href="<?php echo esc_url(home_url('/area/chuong-my/')); ?>">Chương Mỹ</a>
                            <a href="<?php echo esc_url(home_url('/area/thach-that/')); ?>">Thạch Thất</a>
                            <a href="<?php echo esc_url(home_url('/area/dan-phuong/')); ?>">Đan Phượng</a>
                            <a href="<?php echo esc_url(home_url('/area/ung-hoa/')); ?>">Ứng Hòa</a>
                            <a href="<?php echo esc_url(home_url('/area/my-duc/')); ?>">Mỹ Đức</a>
                            <a href="<?php echo esc_url(home_url('/area/ba-vi/')); ?>">Ba Vì</a>
                        </div>
                    </div>
                </nav>
                
                <!-- プロジェクト検索 -->
                <div class="nav-item">
                    <a href="<?php echo esc_url(home_url('/projects/')); ?>" class="nav-link">
                        <span class="nav-icon">🏗️</span>
                        Dự án
                    </a>
                    <div class="dropdown-menu">
                        <a href="<?php echo esc_url(home_url('/projects/')); ?>">Tất cả dự án</a>
                        <a href="<?php echo esc_url(home_url('/project-features/residential/')); ?>">Dự án nhà ở</a>
                        <a href="<?php echo esc_url(home_url('/project-features/commercial/')); ?>">Dự án thương mại</a>
                        <a href="<?php echo esc_url(home_url('/project-features/mixed-use/')); ?>">Dự án hỗn hợp</a>
                        <a href="<?php echo esc_url(home_url('/project-features/infrastructure/')); ?>">Dự án hạ tầng</a>
                        <a href="<?php echo esc_url(home_url('/companies/')); ?>">Công ty phát triển</a>
                    </div>
                </div>
                
                <!-- モバイルメニューボタン -->
                <button class="mobile-menu-toggle" aria-label="メニューを開く">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- モバイルメニュー -->
    <div class="mobile-menu">
        <div class="mobile-menu-content">
            <div class="mobile-user-actions">
                <a href="<?php echo esc_url(home_url('/login/')); ?>" class="mobile-login-btn">Đăng nhập</a>
                <a href="<?php echo esc_url(home_url('/register/')); ?>" class="mobile-register-btn">Đăng ký</a>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mobile-contact-btn">Liên hệ</a>
            </div>
            
            <div class="mobile-area-nav">
                <h3>Khu vực</h3>
                <div class="mobile-area-section">
                    <h4>Hà Nội nội thành</h4>
                    <a href="<?php echo esc_url(home_url('/area/ba-dinh/')); ?>">Ba Đình</a>
                    <a href="<?php echo esc_url(home_url('/area/hoan-kiem/')); ?>">Hoàn Kiếm</a>
                    <a href="<?php echo esc_url(home_url('/area/hai-ba-trung/')); ?>">Hai Bà Trưng</a>
                    <a href="<?php echo esc_url(home_url('/area/dong-da/')); ?>">Đống Đa</a>
                    <a href="<?php echo esc_url(home_url('/area/tay-ho/')); ?>">Tây Hồ</a>
                    <a href="<?php echo esc_url(home_url('/area/cau-giay/')); ?>">Cầu Giấy</a>
                    <a href="<?php echo esc_url(home_url('/area/thanh-xuan/')); ?>">Thanh Xuân</a>
                    <a href="<?php echo esc_url(home_url('/area/hoang-mai/')); ?>">Hoàng Mai</a>
                    <a href="<?php echo esc_url(home_url('/area/long-bien/')); ?>">Long Biên</a>
                    <a href="<?php echo esc_url(home_url('/area/nam-tu-liem/')); ?>">Nam Từ Liêm</a>
                    <a href="<?php echo esc_url(home_url('/area/bac-tu-liem/')); ?>">Bắc Từ Liêm</a>
                    <a href="<?php echo esc_url(home_url('/area/ha-dong/')); ?>">Hà Đông</a>
                </div>
                
                <div class="mobile-area-section">
                    <h4>Hà Nội ngoại thành</h4>
                    <a href="<?php echo esc_url(home_url('/area/son-tay/')); ?>">Sơn Tây</a>
                    <a href="<?php echo esc_url(home_url('/area/dong-anh/')); ?>">Đông Anh</a>
                    <a href="<?php echo esc_url(home_url('/area/gia-lam/')); ?>">Gia Lâm</a>
                    <a href="<?php echo esc_url(home_url('/area/soc-son/')); ?>">Sóc Sơn</a>
                    <a href="<?php echo esc_url(home_url('/area/thanh-tri/')); ?>">Thanh Trì</a>
                    <a href="<?php echo esc_url(home_url('/area/me-linh/')); ?>">Mê Linh</a>
                    <a href="<?php echo esc_url(home_url('/area/hoai-duc/')); ?>">Hoài Đức</a>
                    <a href="<?php echo esc_url(home_url('/area/thuong-tin/')); ?>">Thường Tín</a>
                    <a href="<?php echo esc_url(home_url('/area/thanh-oai/')); ?>">Thanh Oai</a>
                    <a href="<?php echo esc_url(home_url('/area/phu-xuyen/')); ?>">Phú Xuyên</a>
                    <a href="<?php echo esc_url(home_url('/area/quoc-oai/')); ?>">Quốc Oai</a>
                    <a href="<?php echo esc_url(home_url('/area/chuong-my/')); ?>">Chương Mỹ</a>
                    <a href="<?php echo esc_url(home_url('/area/thach-that/')); ?>">Thạch Thất</a>
                    <a href="<?php echo esc_url(home_url('/area/dan-phuong/')); ?>">Đan Phượng</a>
                    <a href="<?php echo esc_url(home_url('/area/ung-hoa/')); ?>">Ứng Hòa</a>
                    <a href="<?php echo esc_url(home_url('/area/my-duc/')); ?>">Mỹ Đức</a>
                    <a href="<?php echo esc_url(home_url('/area/ba-vi/')); ?>">Ba Vì</a>
                </div>
            </div>
            
            <div class="mobile-project-nav">
                <h3>Dự án</h3>
                <div class="mobile-project-section">
                    <a href="<?php echo esc_url(home_url('/projects/')); ?>">Tất cả dự án</a>
                    <a href="<?php echo esc_url(home_url('/project-features/residential/')); ?>">Dự án nhà ở</a>
                    <a href="<?php echo esc_url(home_url('/project-features/commercial/')); ?>">Dự án thương mại</a>
                    <a href="<?php echo esc_url(home_url('/project-features/mixed-use/')); ?>">Dự án hỗn hợp</a>
                    <a href="<?php echo esc_url(home_url('/project-features/infrastructure/')); ?>">Dự án hạ tầng</a>
                    <a href="<?php echo esc_url(home_url('/companies/')); ?>">Công ty phát triển</a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            
            // ハンバーガーメニューのアニメーション
            const spans = mobileMenuToggle.querySelectorAll('span');
            if (mobileMenu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    }
});
</script>

<?php
// デフォルトメニューのフォールバック
function default_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Trang chủ</a></li>';
    echo '<li><a href="' . esc_url(home_url('/properties/')) . '">Danh sách bất động sản</a></li>';
    echo '<li><a href="' . esc_url(home_url('/projects/')) . '">Dự án</a></li>';
    echo '<li><a href="' . esc_url(home_url('/companies/')) . '">Công ty phát triển</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about/')) . '">Giới thiệu công ty</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">Liên hệ</a></li>';
    echo '</ul>';
}
?>
