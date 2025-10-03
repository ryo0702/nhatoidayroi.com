<section class="register-section" style="padding: 120px 0 80px 0; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 80vh; margin-top: 80px;">
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto;">
            
            <!-- 登録成功メッセージ -->
            <?php if (isset($_GET['register']) && $_GET['register'] === 'success') : ?>
                <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 30px; text-align: center;">
                    <strong>✅ Đăng ký thành công!</strong><br>
                    Chào mừng bạn đến với dịch vụ của chúng tôi.
                </div>
            <?php endif; ?>
            
            <!-- エラーメッセージ -->
            <?php 
            $errors = get_transient('register_errors');
            if ($errors && !empty($errors)) :
            ?>
                <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 30px;">
                    <strong>❌ Có lỗi xảy ra:</strong>
                    <ul style="margin: 10px 0 0 20px;">
                        <?php foreach ($errors as $error) : ?>
                            <li><?php echo esc_html($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php delete_transient('register_errors'); ?>
            <?php endif; ?>
            
            <!-- 登録フォーム -->
            <div class="register-form-container" style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="font-size: 28px; color: #333; margin-bottom: 10px;">Đăng ký tài khoản</h1>
                    <p style="color: #666; font-size: 16px;">Tạo tài khoản mới để truy cập các tính năng đặc biệt</p>
                </div>
                
                <form method="post" action="" class="register-form">
                    <?php wp_nonce_field('user_register_action', 'register_nonce'); ?>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                        <div class="form-group">
                            <label for="first_name" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                                Họ <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="text" id="first_name" name="first_name" required 
                                   style="width: 100%; padding: 15px; border: 2px solid #e5e5e5; border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; box-sizing: border-box;"
                                   placeholder="Nhập họ của bạn"
                                   value="<?php echo isset($_POST['first_name']) ? esc_attr($_POST['first_name']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                                Tên <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="text" id="last_name" name="last_name" required 
                                   style="width: 100%; padding: 15px; border: 2px solid #e5e5e5; border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; box-sizing: border-box;"
                                   placeholder="Nhập tên của bạn"
                                   value="<?php echo isset($_POST['last_name']) ? esc_attr($_POST['last_name']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="username" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                            Tên đăng nhập <span style="color: #dc2626;">*</span>
                        </label>
                        <input type="text" id="username" name="username" required 
                               style="width: 100%; padding: 15px; border: 2px solid #e5e5e5; border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; box-sizing: border-box;"
                               placeholder="Chọn tên đăng nhập"
                               value="<?php echo isset($_POST['username']) ? esc_attr($_POST['username']) : ''; ?>">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                            Email <span style="color: #dc2626;">*</span>
                        </label>
                        <input type="email" id="email" name="email" required 
                               style="width: 100%; padding: 15px; border: 2px solid #e5e5e5; border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; box-sizing: border-box;"
                               placeholder="Nhập địa chỉ email của bạn"
                               value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>">
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                        <div class="form-group">
                            <label for="password" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                                Mật khẩu <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="password" id="password" name="password" required 
                                   style="width: 100%; padding: 15px; border: 2px solid #e5e5e5; border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; box-sizing: border-box;"
                                   placeholder="Tối thiểu 6 ký tự">
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                                Xác nhận mật khẩu <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="password" id="confirm_password" name="confirm_password" required 
                                   style="width: 100%; padding: 15px; border: 2px solid #e5e5e5; border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease; box-sizing: border-box;"
                                   placeholder="Nhập lại mật khẩu">
                        </div>
                    </div>
                    
                    <div class="form-options" style="margin-bottom: 30px;">
                        <label style="display: flex; align-items: flex-start; cursor: pointer; line-height: 1.5;">
                            <input type="checkbox" name="terms" value="1" required style="margin-right: 10px; margin-top: 2px;">
                            <span style="color: #666; font-size: 14px;">
                                Tôi đồng ý với <a href="#" style="color: #dc2626; text-decoration: none;">Điều khoản sử dụng</a> 
                                và <a href="#" style="color: #dc2626; text-decoration: none;">Chính sách bảo mật</a> của website.
                            </span>
                        </label>
                    </div>
                    
                    <button type="submit" name="submit_register" 
                            style="width: 100%; background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; padding: 15px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; margin-bottom: 20px;">
                        Tạo tài khoản
                    </button>
                </form>
                
                <!-- ログインリンク -->
                <div class="login-link" style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                    <p style="color: #666; margin-bottom: 15px;">
                        Đã có tài khoản?
                    </p>
                    <a href="<?php echo esc_url(home_url('/?page=user-login')); ?>" 
                       style="display: inline-block; padding: 12px 25px; background: transparent; color: #dc2626; border: 2px solid #dc2626; text-decoration: none; border-radius: 6px; font-weight: 600; transition: all 0.3s ease;">
                        Đăng nhập ngay
                    </a>
                </div>
            </div>
            
            <!-- 追加情報 -->
            <div style="text-align: center; margin-top: 30px; color: #666; font-size: 14px;">
                <p>
                    🔒 Thông tin của bạn được bảo mật tuyệt đối<br>
                    📞 Cần hỗ trợ? Liên hệ: <strong>03-1234-5678</strong>
                </p>
            </div>
        </div>
    </div>
</section>

<style>
/* フォーム要素のホバー効果 */
.register-form input:focus {
    outline: none;
    border-color: #dc2626 !important;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.register-form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 38, 38, 0.3);
}

.login-link a:hover {
    background: #dc2626 !important;
    color: white !important;
    transform: translateY(-2px);
}

/* レスポンシブ対応 */
@media (max-width: 768px) {
    .register-section {
        padding: 100px 0 40px 0 !important;
        margin-top: 60px !important;
    }
    
    .register-form-container {
        padding: 30px 20px !important;
        margin: 0 15px;
    }
    
    .register-form-container > div:first-child {
        grid-template-columns: 1fr !important;
        gap: 15px !important;
    }
    
    .register-form-container > div:nth-child(4) {
        grid-template-columns: 1fr !important;
        gap: 15px !important;
    }
}

@media (max-width: 480px) {
    .register-section {
        padding: 80px 0 30px 0 !important;
        margin-top: 50px !important;
    }
    
    .register-form-container {
        padding: 25px 15px !important;
    }
}
</style>


