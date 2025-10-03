<section class="login-section" style="padding: 120px 0 80px 0; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 80vh; margin-top: 80px;">
    <div class="container">
        <div style="max-width: 500px; margin: 0 auto;">
            
            <!-- ログイン成功メッセージ -->
            <?php if (isset($_GET['login']) && $_GET['login'] === 'success') : ?>
                <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
                    <strong>✅ Đăng nhập thành công!</strong><br>
                    Chào mừng bạn quay trở lại.
                </div>
            <?php endif; ?>
            
            <!-- ログインエラーメッセージ -->
            <?php if (isset($_GET['login']) && $_GET['login'] === 'failed') : ?>
                <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
                    <strong>❌ Đăng nhập thất bại!</strong><br>
                    Tên đăng nhập hoặc mật khẩu không chính xác.
                </div>
            <?php endif; ?>
            
            <!-- ログアウトメッセージ -->
            <?php if (isset($_GET['loggedout']) && $_GET['loggedout'] === 'true') : ?>
                <div style="background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
                    <strong>👋 Đã đăng xuất thành công!</strong><br>
                    Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.
                </div>
            <?php endif; ?>
            
            <!-- ログインフォーム -->
            <div class="login-form-container" style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="font-size: 28px; color: #333; margin-bottom: 10px;">Đăng nhập</h1>
                    <p style="color: #666; font-size: 16px;">Đăng nhập vào tài khoản của bạn để truy cập các tính năng đặc biệt</p>
                </div>
                
                <form method="post" action="" class="login-form">
                    <?php wp_nonce_field('user_login_action', 'login_nonce'); ?>
                    
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="username" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                            Tên đăng nhập hoặc Email <span style="color: #dc2626;">*</span>
                        </label>
                        <input type="text" id="username" name="username" required 
                               style="width: 100%; padding: 15px; border: 2px solid #e5e5e5; border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; box-sizing: border-box;"
                               placeholder="Nhập tên đăng nhập hoặc email của bạn"
                               value="<?php echo isset($_POST['username']) ? esc_attr($_POST['username']) : ''; ?>">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="password" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                            Mật khẩu <span style="color: #dc2626;">*</span>
                        </label>
                        <input type="password" id="password" name="password" required 
                               style="width: 100%; padding: 15px; border: 2px solid #e5e5e5; border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; box-sizing: border-box;"
                               placeholder="Nhập mật khẩu của bạn">
                    </div>
                    
                    <div class="form-options" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                        <label style="display: flex; align-items: center; cursor: pointer;">
                            <input type="checkbox" name="remember" value="1" style="margin-right: 8px;">
                            <span style="color: #666; font-size: 14px;">Ghi nhớ đăng nhập</span>
                        </label>
                        <a href="<?php echo wp_lostpassword_url(); ?>" style="color: #dc2626; text-decoration: none; font-size: 14px;">
                            Quên mật khẩu?
                        </a>
                    </div>
                    
                    <button type="submit" name="submit_login" 
                            style="width: 100%; background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; padding: 15px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; margin-bottom: 20px;">
                        Đăng nhập
                    </button>
                </form>
                
                <!-- ソーシャルログイン（オプション） -->
                <div class="social-login" style="text-align: center; margin-top: 30px; padding-top: 30px; border-top: 1px solid #eee;">
                    <p style="color: #666; margin-bottom: 20px; font-size: 14px;">Hoặc đăng nhập bằng</p>
                    <div style="display: flex; gap: 15px; justify-content: center;">
                        <a href="#" style="display: inline-block; padding: 12px 20px; background: #3b5998; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; transition: background 0.3s ease;">
                            📘 Facebook
                        </a>
                        <a href="#" style="display: inline-block; padding: 12px 20px; background: #db4437; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; transition: background 0.3s ease;">
                            📧 Google
                        </a>
                    </div>
                </div>
                
                <!-- 新規登録リンク -->
                <div class="register-link" style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                    <p style="color: #666; margin-bottom: 15px;">
                        Chưa có tài khoản?
                    </p>
                    <a href="<?php echo wp_registration_url(); ?>" 
                       style="display: inline-block; padding: 12px 25px; background: transparent; color: #dc2626; border: 2px solid #dc2626; text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.3s ease;">
                        Tạo tài khoản mới
                    </a>
                </div>
            </div>
            
            <!-- 追加情報 -->
            <div style="text-align: center; margin-top: 30px; color: #666; font-size: 14px;">
                <p>
                    🔒 Thông tin đăng nhập của bạn được bảo mật tuyệt đối<br>
                    📞 Cần hỗ trợ? Liên hệ: <strong>03-1234-5678</strong>
                </p>
            </div>
        </div>
    </div>
</section>

<style>
/* フォーム要素のホバー効果 */
.login-form input:focus {
    outline: none;
    border-color: #dc2626 !important;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.login-form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 38, 38, 0.3);
}

.social-login a:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.register-link a:hover {
    background: #dc2626 !important;
    color: white !important;
    transform: translateY(-2px);
}

/* レスポンシブ対応 */
@media (max-width: 768px) {
    .login-section {
        padding: 100px 0 40px 0 !important;
        margin-top: 60px !important;
    }
    
    .login-form-container {
        padding: 30px 20px !important;
        margin: 0 15px;
    }
    
    .form-options {
        flex-direction: column !important;
        gap: 15px;
        align-items: flex-start !important;
    }
    
    .social-login div {
        flex-direction: column !important;
        gap: 10px;
    }
}

@media (max-width: 480px) {
    .login-section {
        padding: 80px 0 30px 0 !important;
        margin-top: 50px !important;
    }
}
</style>
