<?php
// ユーザー登録処理
if (isset($_POST['submit_register']) && wp_verify_nonce($_POST['register_nonce'], 'user_register_action')) {
    $username = sanitize_text_field($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    
    // バリデーション
    $errors = array();
    
    if (empty($username)) {
        $errors[] = 'Tên đăng nhập là bắt buộc.';
    } elseif (username_exists($username)) {
        $errors[] = 'Tên đăng nhập đã tồn tại.';
    }
    
    if (empty($email)) {
        $errors[] = 'Email là bắt buộc.';
    } elseif (!is_email($email)) {
        $errors[] = 'Email không hợp lệ.';
    } elseif (email_exists($email)) {
        $errors[] = 'Email đã được sử dụng.';
    }
    
    if (empty($password)) {
        $errors[] = 'Mật khẩu là bắt buộc.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    }
    
    if ($password !== $confirm_password) {
        $errors[] = 'Mật khẩu xác nhận không khớp.';
    }
    
    if (empty($errors)) {
        // ユーザー作成
        $user_id = wp_create_user($username, $password, $email);
        
        if (!is_wp_error($user_id)) {
            // 追加情報を更新
            wp_update_user(array(
                'ID' => $user_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'display_name' => $first_name . ' ' . $last_name
            ));
            
            // 自動ログイン
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);
            
            // 成功メッセージと共にリダイレクト
            wp_redirect(add_query_arg('register', 'success', home_url('/')));
            exit;
        } else {
            $errors[] = 'Có lỗi xảy ra khi tạo tài khoản. Vui lòng thử lại.';
        }
    }
    
    // エラーがある場合はセッションに保存
    if (!empty($errors)) {
        set_transient('register_errors', $errors, 30);
        wp_redirect(wp_get_referer());
        exit;
    }
}

// 既にログインしている場合はリダイレクト
if (is_user_logged_in()) {
    wp_redirect(home_url('/'));
    exit;
}

include get_template_directory() . '/parts/header.php';
?>
<main id="main" class="site-main">
    <?php
    include get_template_directory() . '/parts/user-register-panel.php';
    ?>
</main>
<?php
include get_template_directory() . '/parts/footer.php';
?>


