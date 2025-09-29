<!-- Call to Action セクション -->
<section class="cta-section" style="padding: 80px 0; background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; text-align: center;">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            <?php if (isset($_COOKIE['cta_success']) && $_COOKIE['cta_success'] == '1') : ?>
                <div style="background: rgba(255,255,255,0.1); border: 2px solid rgba(255,255,255,0.3); border-radius: 10px; padding: 20px; margin-bottom: 30px;">
                    <h3 style="color: #4ade80; font-size: 24px; margin-bottom: 10px;">✅ Đăng ký thành công!</h3>
                    <p style="font-size: 16px; opacity: 0.9;">Cảm ơn bạn đã đăng ký! Chúng tôi sẽ gửi thông tin bất động sản mới nhất đến email của bạn.</p>
                </div>
                <script>
                    // クッキーを削除
                    document.cookie = "cta_success=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                </script>
            <?php endif; ?>
            
            <h2 style="font-size: 36px; font-weight: 700; margin-bottom: 20px; line-height: 1.2;">
                Nhận thông tin bất động sản mới nhất
            </h2>
            <p style="font-size: 18px; margin-bottom: 40px; opacity: 0.9; line-height: 1.6;">
                Đăng ký email để nhận thông tin về các dự án và căn hộ mới nhất tại Hà Nội. 
                Chúng tôi sẽ gửi cho bạn những cơ hội đầu tư tốt nhất!
            </p>
            
            <form class="cta-form" action="" method="post" style="display: flex; gap: 15px; max-width: 500px; margin: 0 auto; flex-wrap: wrap; justify-content: center;">
                <?php wp_nonce_field('cta_email_signup', 'cta_nonce'); ?>
                <input type="email" name="cta_email" placeholder="Nhập địa chỉ email của bạn" required 
                        style="flex: 1; min-width: 250px; padding: 15px 20px; border: none; border-radius: 8px; font-size: 16px; outline: none;">
                <button type="submit" name="submit_cta" 
                        style="background: white; color: #dc2626; padding: 15px 30px; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; white-space: nowrap;">
                    Đăng ký ngay
                </button>
            </form>
            
            <p style="font-size: 14px; margin-top: 20px; opacity: 0.8;">
                🔒 Thông tin của bạn được bảo mật tuyệt đối. Chúng tôi không chia sẻ email với bên thứ ba.
            </p>
        </div>
    </div>
</section>