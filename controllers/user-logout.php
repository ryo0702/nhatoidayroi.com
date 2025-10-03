<?php
// ログアウト処理
if (is_user_logged_in()) {
    // ログアウト実行
    wp_logout();
    
    // トップページにリダイレクト（ログアウト成功メッセージ付き）
    wp_safe_redirect( site_url('/'));
    exit;
} else {
    // 既にログアウト済みの場合はトップページにリダイレクト
    wp_safe_redirect( site_url('/'));
    exit;
}
