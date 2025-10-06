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
                    <?php if (is_user_logged_in()) : ?>
                        <span style="color: #666; font-size: 14px; margin-right: 15px;">
                            Xin chào, <?php echo esc_html(wp_get_current_user()->display_name); ?>!
                        </span>
                        <?php if (current_user_can('manage_options')) : ?>
                            <a href="<?php echo esc_url(admin_url()); ?>" class="admin-btn" style="background: #28a745; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.3s ease; margin-right: 10px;"><i class="fas fa-cog"></i> Quản trị</a>
                        <?php endif; ?>
                        <a href="<?php echo wp_logout_url(home_url('/?page=user-logout')); ?>" class="login-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                    <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/?page=user-login')); ?>" class="login-btn"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                    <a href="<?php echo esc_url(home_url('/?page=user-register')); ?>" class="register-btn"><i class="fas fa-user-plus"></i> Đăng ký</a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="contact-btn"><i class="fas fa-envelope"></i> Liên hệ</a>
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
                            <span class="nav-icon"><i class="fas fa-city"></i></span>
                            Hà Nội nội thành
                        </a>
                        <div class="dropdown-menu">
                            <div class="mega-menu-container">
                                <div class="mega-menu-section">
                                    <h3><i class="fas fa-map-marker-alt"></i> Quận nội thành</h3>
                                    <a href="<?php echo esc_url(home_url('/area/ba-dinh/')); ?>"><i class="fas fa-building"></i> Ba Đình</a>
                                    <a href="<?php echo esc_url(home_url('/area/hoan-kiem/')); ?>"><i class="fas fa-landmark"></i> Hoàn Kiếm</a>
                                    <a href="<?php echo esc_url(home_url('/area/hai-ba-trung/')); ?>"><i class="fas fa-city"></i> Hai Bà Trưng</a>
                                    <a href="<?php echo esc_url(home_url('/area/dong-da/')); ?>"><i class="fas fa-university"></i> Đống Đa</a>
                                    <a href="<?php echo esc_url(home_url('/area/tay-ho/')); ?>"><i class="fas fa-water"></i> Tây Hồ</a>
                                    <a href="<?php echo esc_url(home_url('/area/cau-giay/')); ?>"><i class="fas fa-bridge"></i> Cầu Giấy</a>
                                </div>
                                <div class="mega-menu-section">
                                    <h3><i class="fas fa-map-marked-alt"></i> Quận khác</h3>
                                    <a href="<?php echo esc_url(home_url('/area/thanh-xuan/')); ?>"><i class="fas fa-home"></i> Thanh Xuân</a>
                                    <a href="<?php echo esc_url(home_url('/area/hoang-mai/')); ?>"><i class="fas fa-industry"></i> Hoàng Mai</a>
                                    <a href="<?php echo esc_url(home_url('/area/long-bien/')); ?>"><i class="fas fa-subway"></i> Long Biên</a>
                                    <a href="<?php echo esc_url(home_url('/area/nam-tu-liem/')); ?>"><i class="fas fa-tree"></i> Nam Từ Liêm</a>
                                    <a href="<?php echo esc_url(home_url('/area/bac-tu-liem/')); ?>"><i class="fas fa-leaf"></i> Bắc Từ Liêm</a>
                                    <a href="<?php echo esc_url(home_url('/area/ha-dong/')); ?>"><i class="fas fa-hotel"></i> Hà Đông</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nav-item">
                        <a href="<?php echo esc_url(home_url('/area/hanoi-suburb/')); ?>" class="nav-link">
                            <span class="nav-icon"><i class="fas fa-tree"></i></span>
                            Hà Nội ngoại thành
                        </a>
                        <div class="dropdown-menu">
                            <div class="mega-menu-container">
                                <div class="mega-menu-section">
                                    <h3><i class="fas fa-mountain"></i> Huyện miền núi</h3>
                                    <a href="<?php echo esc_url(home_url('/area/son-tay/')); ?>"><i class="fas fa-mountain"></i> Sơn Tây</a>
                                    <a href="<?php echo esc_url(home_url('/area/ba-vi/')); ?>"><i class="fas fa-tree"></i> Ba Vì</a>
                                    <a href="<?php echo esc_url(home_url('/area/thach-that/')); ?>"><i class="fas fa-hiking"></i> Thạch Thất</a>
                                    <a href="<?php echo esc_url(home_url('/area/quoc-oai/')); ?>"><i class="fas fa-hill"></i> Quốc Oai</a>
                                    <a href="<?php echo esc_url(home_url('/area/hoai-duc/')); ?>"><i class="fas fa-forest"></i> Hoài Đức</a>
                                    <a href="<?php echo esc_url(home_url('/area/chuong-my/')); ?>"><i class="fas fa-leaf"></i> Chương Mỹ</a>
                                </div>
                                <div class="mega-menu-section">
                                    <h3><i class="fas fa-subway"></i> Huyện ven đô</h3>
                                    <a href="<?php echo esc_url(home_url('/area/dong-anh/')); ?>"><i class="fas fa-industry"></i> Đông Anh</a>
                                    <a href="<?php echo esc_url(home_url('/area/gia-lam/')); ?>"><i class="fas fa-bridge"></i> Gia Lâm</a>
                                    <a href="<?php echo esc_url(home_url('/area/soc-son/')); ?>"><i class="fas fa-plane"></i> Sóc Sơn</a>
                                    <a href="<?php echo esc_url(home_url('/area/thanh-tri/')); ?>"><i class="fas fa-city"></i> Thanh Trì</a>
                                    <a href="<?php echo esc_url(home_url('/area/me-linh/')); ?>"><i class="fas fa-home"></i> Mê Linh</a>
                                    <a href="<?php echo esc_url(home_url('/area/dan-phuong/')); ?>"><i class="fas fa-building"></i> Đan Phượng</a>
                                </div>
                                <div class="mega-menu-section">
                                    <h3><i class="fas fa-water"></i> Khu vực khác</h3>
                                    <a href="<?php echo esc_url(home_url('/area/thuong-tin/')); ?>"><i class="fas fa-factory"></i> Thường Tín</a>
                                    <a href="<?php echo esc_url(home_url('/area/thanh-oai/')); ?>"><i class="fas fa-industry"></i> Thanh Oai</a>
                                    <a href="<?php echo esc_url(home_url('/area/phu-xuyen/')); ?>"><i class="fas fa-warehouse"></i> Phú Xuyên</a>
                                    <a href="<?php echo esc_url(home_url('/area/ung-hoa/')); ?>"><i class="fas fa-water"></i> Ứng Hòa</a>
                                    <a href="<?php echo esc_url(home_url('/area/my-duc/')); ?>"><i class="fas fa-leaf"></i> Mỹ Đức</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- プロジェクト検索 -->
                    <div class="nav-item">
                        <a href="<?php echo esc_url(home_url('/projects/')); ?>" class="nav-link">
                            <span class="nav-icon"><i class="fas fa-hammer"></i></span>
                            Dự án
                        </a>
                        <div class="dropdown-menu">
                            <div class="mega-menu-container">
                                <div class="mega-menu-section">
                                    <h3><i class="fas fa-home"></i> Dự án nhà ở</h3>
                                    <a href="<?php echo esc_url(home_url('/projects/')); ?>"><i class="fas fa-list"></i> Tất cả dự án</a>
                                    <a href="<?php echo esc_url(home_url('/project-features/residential/')); ?>"><i class="fas fa-building"></i> Chung cư cao cấp</a>
                                    <a href="<?php echo esc_url(home_url('/project-features/residential/')); ?>"><i class="fas fa-home"></i> Nhà phố</a>
                                    <a href="<?php echo esc_url(home_url('/project-features/residential/')); ?>"><i class="fas fa-tree"></i> Biệt thự</a>
                                    <a href="<?php echo esc_url(home_url('/project-features/residential/')); ?>"><i class="fas fa-city"></i> Khu đô thị mới</a>
                                </div>
                                <div class="mega-menu-section">
                                    <h3><i class="fas fa-store"></i> Dự án thương mại</h3>
                                    <a href="<?php echo esc_url(home_url('/project-features/commercial/')); ?>"><i class="fas fa-shopping-mall"></i> Trung tâm thương mại</a>
                                    <a href="<?php echo esc_url(home_url('/project-features/commercial/')); ?>"><i class="fas fa-office-building"></i> Tòa nhà văn phòng</a>
                                    <a href="<?php echo esc_url(home_url('/project-features/mixed-use/')); ?>"><i class="fas fa-building"></i> Dự án hỗn hợp</a>
                                    <a href="<?php echo esc_url(home_url('/project-features/mixed-use/')); ?>"><i class="fas fa-hotel"></i> Khách sạn & Resort</a>
                                </div>
                                <div class="mega-menu-section">
                                    <h3><i class="fas fa-industry"></i> Hạ tầng & Phát triển</h3>
                                    <a href="<?php echo esc_url(home_url('/project-features/infrastructure/')); ?>"><i class="fas fa-road"></i> Dự án hạ tầng</a>
                                    <a href="<?php echo esc_url(home_url('/companies/')); ?>"><i class="fas fa-handshake"></i> Công ty phát triển</a>
                                    <a href="<?php echo esc_url(home_url('/companies/')); ?>"><i class="fas fa-users"></i> Đối tác</a>
                                    <a href="<?php echo esc_url(home_url('/companies/')); ?>"><i class="fas fa-chart-line"></i> Báo cáo thị trường</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                
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
                <?php if (is_user_logged_in()) : ?>
                    <div style="color: #666; font-size: 14px; margin-bottom: 15px; text-align: center;">
                        Xin chào, <?php echo esc_html(wp_get_current_user()->display_name); ?>!
                    </div>
                    <?php if (current_user_can('manage_options')) : ?>
                        <a href="<?php echo esc_url(admin_url()); ?>" class="mobile-admin-btn" style="background: #28a745; color: white; padding: 10px; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.3s ease; margin-bottom: 10px; display: block; text-align: center;"><i class="fas fa-cog"></i> Quản trị</a>
                    <?php endif; ?>
                    <a href="<?php echo wp_logout_url(home_url('/?page=user-logout')); ?>" class="mobile-login-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/?page=user-login')); ?>" class="mobile-login-btn"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                    <a href="<?php echo esc_url(home_url('/?page=user-register')); ?>" class="mobile-register-btn"><i class="fas fa-user-plus"></i> Đăng ký</a>
                <?php endif; ?>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mobile-contact-btn"><i class="fas fa-envelope"></i> Liên hệ</a>
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
