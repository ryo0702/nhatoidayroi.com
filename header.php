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
    <div class="container">
        <div class="header-content">
            <!-- ロゴ -->
            <div class="logo">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo-hanoi.png" alt="<?php bloginfo('name'); ?>" style="height: 50px; width: auto;">
                </a>
            </div>
            
            <!-- メインナビゲーション -->
            <nav class="main-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => 'default_menu',
                ));
                ?>
            </nav>
            
            
            <!-- モバイルメニューボタン -->
            <button class="mobile-menu-toggle" aria-label="メニューを開く">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
    
    <!-- モバイルメニュー -->
    <div class="mobile-menu">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_class'     => 'mobile-nav-menu',
            'container'      => false,
            'fallback_cb'    => 'default_menu',
        ));
        ?>
    </div>
</header>

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
