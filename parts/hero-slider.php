<section class="main-visual">
    <div class="slider-container">
        <?php
        $slides = get_slider_images();
        $slide_count = 0;
        foreach ($slides as $slide) :
            $slide_count++;
            $image_url = !empty($slide['image']) ? $slide['image'] : get_template_directory_uri() . '/images/nophoto.png';
            $title = !empty($slide['title']) ? $slide['title'] : 'Chung cư cao cấp mới xây';
            $description = !empty($slide['description']) ? $slide['description'] : 'Tìm ngôi nhà lý tưởng của bạn';
        ?>
            <div class="slide <?php echo $slide_count === 1 ? 'active' : ''; ?>" style="background-image: url('<?php echo esc_url($image_url); ?>')">
                <div class="slide-content">
                    <h2><?php echo esc_html($title); ?></h2>
                    <p><?php echo esc_html($description); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- スライダーナビゲーション -->
    <div class="slider-nav">
        <?php for ($i = 1; $i <= count($slides); $i++) : ?>
            <div class="slider-dot <?php echo $i === 1 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
        <?php endfor; ?>
    </div>
</section>