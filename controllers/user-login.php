<?php
// ログイン処理
if (isset($_POST['submit_login']) && wp_verify_nonce($_POST['login_nonce'], 'user_login_action')) {
    $username = sanitize_text_field($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    // ログイン試行
    $user = wp_authenticate($username, $password);
    
    if (!is_wp_error($user)) {
        // ログイン成功
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, $remember);
        
        // 成功メッセージと共にリダイレクト
        wp_redirect(site_url('/'));
        exit;
    } else {
        // ログイン失敗
        wp_redirect(add_query_arg('login', 'failed', wp_get_referer()));
        exit;
    }
}

// 既にログインしている場合はリダイレクト
if (is_user_logged_in()) {
    wp_redirect(site_url('/'));
    exit;
}

include get_template_directory() . '/parts/header.php';
?>
<main id="main" class="site-main">
    <?php
    include get_template_directory() . '/parts/user-login-panel.php';
    ?>
</main>
<?php
include get_template_directory() . '/parts/footer.php';
?>