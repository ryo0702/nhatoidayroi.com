<!-- 詳細検索セクション -->
<section class="search-section">
    <div class="container">
        <h2 class="search-title">Tìm kiếm bất động sản lý tưởng</h2>
        <form class="search-form" method="post" action="">
            <?php wp_nonce_field('property_search', 'property_search_nonce'); ?>
            <input type="hidden" name="property_search" value="1">
            
            <div class="form-group">
                <label for="location"><?php 'Khu vực mong muốn'; ?></label>
                <input type="text" id="location" name="location" placeholder="<?php 'VD: Shibuya, Shinjuku'; ?>">
            </div>
            
            <div class="form-group">
                <label for="price_min"><?php 'Giá (Tối thiểu)'; ?></label>
                <select id="price_min" name="price_min">
                    <option value=""><?php 'Vui lòng chọn'; ?></option>
                    <option value="3000">3,000万円以上</option>
                    <option value="4000">4,000万円以上</option>
                    <option value="5000">5,000万円以上</option>
                    <option value="6000">6,000万円以上</option>
                    <option value="8000">8,000万円以上</option>
                    <option value="10000">1億円以上</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="price_max"><?php 'Giá (Tối đa)'; ?></label>
                <select id="price_max" name="price_max">
                    <option value=""><?php 'Vui lòng chọn'; ?></option>
                    <option value="4000">4,000万円以下</option>
                    <option value="5000">5,000万円以下</option>
                    <option value="6000">6,000万円以下</option>
                    <option value="8000">8,000万円以下</option>
                    <option value="10000">1億円以下</option>
                    <option value="15000">1.5億円以下</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="rooms"><?php 'Mặt bằng'; ?></label>
                <select id="rooms" name="rooms">
                    <option value=""><?php 'Vui lòng chọn'; ?></option>
                    <option value="1LDK">1LDK</option>
                    <option value="2LDK">2LDK</option>
                    <option value="2DK">2DK</option>
                    <option value="3LDK">3LDK</option>
                    <option value="3DK">3DK</option>
                    <option value="4LDK">4LDK</option>
                    <option value="4DK">4DK</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="area"><?php 'Khu vực'; ?></label>
                <select id="area" name="area">
                    <option value=""><?php 'Vui lòng chọn'; ?></option>
                    <?php
                    $areas = get_terms(array(
                        'taxonomy' => 'area',
                        'hide_empty' => false,
                    ));
                    
                    if (!empty($areas) && !is_wp_error($areas)) {
                        foreach ($areas as $area) {
                            echo '<option value="' . esc_attr($area->slug) . '">' . esc_html($area->name) . '</option>';
                        }
                    } else {
                        // デフォルトのエリアオプション
                        echo '<option value="tokyo">東京都</option>';
                        echo '<option value="osaka">大阪府</option>';
                        echo '<option value="kanagawa">神奈川県</option>';
                        echo '<option value="chiba">千葉県</option>';
                        echo '<option value="saitama">埼玉県</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="condition"><?php 'Tình trạng'; ?></label>
                <select id="condition" name="condition">
                    <option value=""><?php 'Vui lòng chọn'; ?></option>
                    <option value="new"><?php 'Mới'; ?></option>
                    <option value="used"><?php 'Đã qua sử dụng'; ?></option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="property_type"><?php 'Loại bất động sản'; ?></label>
                <select id="property_type" name="property_type">
                    <option value=""><?php 'Vui lòng chọn'; ?></option>
                    <?php
                    $property_types = get_terms(array(
                        'taxonomy' => 'property_type',
                        'hide_empty' => false,
                    ));
                    
                    if (!empty($property_types) && !is_wp_error($property_types)) {
                        foreach ($property_types as $type) {
                            echo '<option value="' . esc_attr($type->slug) . '">' . esc_html($type->name) . '</option>';
                        }
                    } else {
                        // デフォルトの物件タイプオプション
                        echo '<option value="mansion">マンション</option>';
                        echo '<option value="house">一戸建て</option>';
                        echo '<option value="land">土地</option>';
                        echo '<option value="office">オフィス</option>';
                        echo '<option value="shop">店舗</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="search-btn"><?php 'Tìm kiếm'; ?></button>
            </div>
        </form>
    </div>
</section>