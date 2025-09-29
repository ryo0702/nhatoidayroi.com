<?php
/**
 * 新築マンション販売テーマのfunctions.php
 */

// セッション開始
function start_theme_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'start_theme_session', 1);

// テーマサポート機能の追加
function theme_setup() {
    // ベトナム語のロケール設定
    add_filter('locale', function() {
        return 'vi';
    });
    
    // タイトルタグのサポート
    add_theme_support('title-tag');
    
    // アイキャッチ画像のサポート
    add_theme_support('post-thumbnails');
    
    // カスタムロゴのサポート
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // HTML5マークアップのサポート
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // ナビゲーションメニューの登録
    register_nav_menus(array(
        'primary' => 'メインメニュー',
        'footer'  => 'フッターメニュー',
    ));
    
    // 画像サイズの追加
    add_image_size('mansion-thumbnail', 400, 300, true);
    add_image_size('hero-slide', 1200, 500, true);
}
add_action('after_setup_theme', 'theme_setup');

// Google Fontsの読み込み
function enqueue_google_fonts() {
    wp_enqueue_style('google-fonts-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap', false);
}
add_action('wp_enqueue_scripts', 'enqueue_google_fonts');

// CTA フォーム処理
function handle_cta_email_signup() {
    if (isset($_POST['submit_cta']) && wp_verify_nonce($_POST['cta_nonce'], 'cta_email_signup')) {
        $email = sanitize_email($_POST['cta_email']);
        
        if (is_email($email)) {
            // メールアドレスをデータベースに保存（オプション）
            $existing_emails = get_option('cta_subscribers', array());
            if (!in_array($email, $existing_emails)) {
                $existing_emails[] = $email;
                update_option('cta_subscribers', $existing_emails);
            }
            
            // 管理者に通知メールを送信
            $subject = '新しいメール登録 - ' . get_bloginfo('name');
            $message = "新しいメールアドレスが登録されました:\n\n";
            $message .= "Email: " . $email . "\n";
            $message .= "登録日時: " . current_time('Y-m-d H:i:s') . "\n";
            $message .= "IPアドレス: " . $_SERVER['REMOTE_ADDR'] . "\n";
            
            wp_mail(get_option('admin_email'), $subject, $message);
            
            // 成功メッセージをセッションに保存
            setcookie('cta_success', '1', time() + 30, '/');
        }
    }
}
add_action('init', 'handle_cta_email_signup');

// スタイルとスクリプトの読み込み
function theme_scripts() {
    // メインのCSS
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // スライダー用のJavaScript
    wp_enqueue_script('theme-slider', get_template_directory_uri() . '/js/slider.js', array(), '1.0.0', true);
    
    // 検索フォーム用のJavaScript
    wp_enqueue_script('theme-search', get_template_directory_uri() . '/js/search.js', array(), '1.0.0', true);
    
}
add_action('wp_enqueue_scripts', 'theme_scripts');

// ウィジェットエリアの登録
function theme_widgets_init() {
    register_sidebar(array(
        'name'          => 'フッターウィジェット1',
        'id'            => 'footer-1',
        'description'   => 'フッターの最初のウィジェットエリア',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => 'フッターウィジェット2',
        'id'            => 'footer-2',
        'description'   => 'フッターの2番目のウィジェットエリア',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => 'フッターウィジェット3',
        'id'            => 'footer-3',
        'description'   => 'フッターの3番目のウィジェットエリア',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'theme_widgets_init');

// カスタム投稿タイプ「不動産」の登録
function create_property_post_type() {
    register_post_type('property', array(
        'labels' => array(
            'name'               => '不動産',
            'singular_name'      => '不動産',
            'menu_name'          => '不動産',
            'add_new'            => '新規追加',
            'add_new_item'       => '新しい不動産を追加',
            'edit_item'          => '不動産を編集',
            'new_item'           => '新しい不動産',
            'view_item'          => '不動産を表示',
            'search_items'       => '不動産を検索',
            'not_found'          => '不動産が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に不動産はありません',
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-building',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'      => array('slug' => 'properties'),
    ));
}
add_action('init', 'create_property_post_type');

// カスタム投稿タイプ「プロジェクト」の登録
function create_project_post_type() {
    register_post_type('project', array(
        'labels' => array(
            'name'               => 'プロジェクト',
            'singular_name'      => 'プロジェクト',
            'menu_name'          => 'プロジェクト',
            'add_new'            => '新規追加',
            'add_new_item'       => '新しいプロジェクトを追加',
            'edit_item'          => 'プロジェクトを編集',
            'new_item'           => '新しいプロジェクト',
            'view_item'          => 'プロジェクトを表示',
            'search_items'       => 'プロジェクトを検索',
            'not_found'          => 'プロジェクトが見つかりません',
            'not_found_in_trash' => 'ゴミ箱にプロジェクトはありません',
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-portfolio',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'      => array('slug' => 'projects'),
    ));
}
add_action('init', 'create_project_post_type');

// カスタム投稿タイプ「開発会社」の登録
function create_company_post_type() {
    register_post_type('company', array(
        'labels' => array(
            'name'               => '開発会社',
            'singular_name'      => '開発会社',
            'menu_name'          => '開発会社',
            'add_new'            => '新規追加',
            'add_new_item'       => '新しい開発会社を追加',
            'edit_item'          => '開発会社を編集',
            'new_item'           => '新しい開発会社',
            'view_item'          => '開発会社を表示',
            'search_items'       => '開発会社を検索',
            'not_found'          => '開発会社が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に開発会社はありません',
        ),
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-building',
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'      => array('slug' => 'companies'),
    ));
}
add_action('init', 'create_company_post_type');

// カスタムタクソノミーの登録
function create_property_taxonomies() {
    // エリア（不動産、プロジェクト、開発会社の全て）
    register_taxonomy('area', array('property', 'project', 'company'), array(
        'labels' => array(
            'name'              => 'エリア',
            'singular_name'     => 'エリア',
            'search_items'      => 'エリアを検索',
            'all_items'         => 'すべてのエリア',
            'parent_item'       => '親エリア',
            'parent_item_colon' => '親エリア:',
            'edit_item'         => 'エリアを編集',
            'update_item'       => 'エリアを更新',
            'add_new_item'      => '新しいエリアを追加',
            'new_item_name'     => '新しいエリア名',
            'menu_name'         => 'エリア',
        ),
        'hierarchical' => true,
        'public'       => true,
        'rewrite'      => array('slug' => 'area'),
    ));
    
    // 状態（新品・中古）
    register_taxonomy('property_condition', 'property', array(
        'labels' => array(
            'name'              => '状態',
            'singular_name'     => '状態',
            'search_items'      => '状態を検索',
            'all_items'         => 'すべての状態',
            'parent_item'       => '親状態',
            'parent_item_colon' => '親状態:',
            'edit_item'         => '状態を編集',
            'update_item'       => '状態を更新',
            'add_new_item'      => '新しい状態を追加',
            'new_item_name'     => '新しい状態名',
            'menu_name'         => '状態',
        ),
        'hierarchical' => false,
        'public'       => true,
        'rewrite'      => array('slug' => 'condition'),
    ));
    
    
    
    // 物件タイプ
    register_taxonomy('property_type', 'property', array(
        'labels' => array(
            'name'              => '物件タイプ',
            'singular_name'     => '物件タイプ',
            'search_items'      => '物件タイプを検索',
            'all_items'         => 'すべての物件タイプ',
            'parent_item'       => '親物件タイプ',
            'parent_item_colon' => '親物件タイプ:',
            'edit_item'         => '物件タイプを編集',
            'update_item'       => '物件タイプを更新',
            'add_new_item'      => '新しい物件タイプを追加',
            'new_item_name'     => '新しい物件タイプ名',
            'menu_name'         => '物件タイプ',
        ),
        'hierarchical' => false,
        'public'       => true,
        'rewrite'      => array('slug' => 'property-type'),
    ));
    
    // 間取りタイプ
    register_taxonomy('property_tag', 'property', array(
        'labels' => array(
            'name'              => '間取りタイプ',
            'singular_name'     => '間取りタイプ',
            'search_items'      => '間取りタイプを検索',
            'all_items'         => 'すべての間取りタイプ',
            'parent_item'       => '親間取りタイプ',
            'parent_item_colon' => '親間取りタイプ:',
            'edit_item'         => '間取りタイプを編集',
            'update_item'       => '間取りタイプを更新',
            'add_new_item'      => '新しい間取りタイプを追加',
            'new_item_name'     => '新しい間取りタイプ名',
            'menu_name'         => '間取りタイプ',
        ),
        'hierarchical' => false,
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'rewrite'      => array('slug' => 'layout-type'),
    ));
    
    // 雰囲気タグ
    register_taxonomy('atmosphere_tag', 'property', array(
        'labels' => array(
            'name'              => '雰囲気タグ',
            'singular_name'     => '雰囲気タグ',
            'search_items'      => '雰囲気タグを検索',
            'all_items'         => 'すべての雰囲気タグ',
            'parent_item'       => '親雰囲気タグ',
            'parent_item_colon' => '親雰囲気タグ:',
            'edit_item'         => '雰囲気タグを編集',
            'update_item'       => '雰囲気タグを更新',
            'add_new_item'      => '新しい雰囲気タグを追加',
            'new_item_name'     => '新しい雰囲気タグ名',
            'menu_name'         => '雰囲気タグ',
        ),
        'hierarchical' => false,
        'public'       => true,
        'rewrite'      => array('slug' => 'atmosphere-tag'),
    ));
    
    // プロジェクトの特徴・施設
    register_taxonomy('project_features', 'project', array(
        'labels' => array(
            'name'              => 'プロジェクトの特徴・施設',
            'singular_name'     => 'プロジェクトの特徴・施設',
            'search_items'      => 'プロジェクトの特徴・施設を検索',
            'all_items'         => 'すべてのプロジェクトの特徴・施設',
            'parent_item'       => '親プロジェクトの特徴・施設',
            'parent_item_colon' => '親プロジェクトの特徴・施設:',
            'edit_item'         => 'プロジェクトの特徴・施設を編集',
            'update_item'       => 'プロジェクトの特徴・施設を更新',
            'add_new_item'      => '新しいプロジェクトの特徴・施設を追加',
            'new_item_name'     => '新しいプロジェクトの特徴・施設名',
            'menu_name'         => 'プロジェクトの特徴・施設',
        ),
        'hierarchical' => false,
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'rewrite'      => array('slug' => 'project-features'),
    ));
    
    // 物件の特徴・設備
    register_taxonomy('property_features', 'property', array(
        'labels' => array(
            'name'              => '物件の特徴・設備',
            'singular_name'     => '物件の特徴・設備',
            'search_items'      => '特徴・設備を検索',
            'all_items'         => 'すべての特徴・設備',
            'parent_item'       => '親特徴・設備',
            'parent_item_colon' => '親特徴・設備:',
            'edit_item'         => '特徴・設備を編集',
            'update_item'       => '特徴・設備を更新',
            'add_new_item'      => '新しい特徴・設備を追加',
            'new_item_name'     => '新しい特徴・設備名',
            'menu_name'         => '物件の特徴・設備',
        ),
        'hierarchical' => false,
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'rewrite'      => array('slug' => 'property-features'),
    ));
    
    // 開発会社の事業分野
    register_taxonomy('company_sector', 'company', array(
        'labels' => array(
            'name'              => '事業分野',
            'singular_name'     => '事業分野',
            'search_items'      => '事業分野を検索',
            'all_items'         => 'すべての事業分野',
            'parent_item'       => '親事業分野',
            'parent_item_colon' => '親事業分野:',
            'edit_item'         => '事業分野を編集',
            'update_item'       => '事業分野を更新',
            'add_new_item'      => '新しい事業分野を追加',
            'new_item_name'     => '新しい事業分野名',
            'menu_name'         => '事業分野',
        ),
        'hierarchical' => false,
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'rewrite'      => array('slug' => 'company-sector'),
    ));
    
    // 開発会社の規模
    register_taxonomy('company_size', 'company', array(
        'labels' => array(
            'name'              => '会社規模',
            'singular_name'     => '会社規模',
            'search_items'      => '会社規模を検索',
            'all_items'         => 'すべての会社規模',
            'parent_item'       => '親会社規模',
            'parent_item_colon' => '親会社規模:',
            'edit_item'         => '会社規模を編集',
            'update_item'       => '会社規模を更新',
            'add_new_item'      => '新しい会社規模を追加',
            'new_item_name'     => '新しい会社規模名',
            'menu_name'         => '会社規模',
        ),
        'hierarchical' => false,
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'rewrite'      => array('slug' => 'company-size'),
    ));
}
add_action('init', 'create_property_taxonomies');

// エリアタクソノミーのデフォルトターム作成関数
function create_default_area_terms() {
    $area_terms = array(
        // ハノイ市内
        'ba-dinh' => 'Ba Đình',
        'hoan-kiem' => 'Hoàn Kiếm',
        'hai-ba-trung' => 'Hai Bà Trưng',
        'dong-da' => 'Đống Đa',
        'tay-ho' => 'Tây Hồ',
        'cau-giay' => 'Cầu Giấy',
        'thanh-xuan' => 'Thanh Xuân',
        'hoang-mai' => 'Hoàng Mai',
        'long-bien' => 'Long Biên',
        'nam-tu-liem' => 'Nam Từ Liêm',
        'bac-tu-liem' => 'Bắc Từ Liêm',
        'ha-dong' => 'Hà Đông',
        // ハノイ郊外
        'son-tay' => 'Sơn Tây',
        'dong-anh' => 'Đông Anh',
        'gia-lam' => 'Gia Lâm',
        'soc-son' => 'Sóc Sơn',
        'thanh-tri' => 'Thanh Trì',
        'me-linh' => 'Mê Linh',
        'hoai-duc' => 'Hoài Đức',
        'thuong-tin' => 'Thường Tín',
        'thanh-oai' => 'Thanh Oai',
        'phu-xuyen' => 'Phú Xuyên',
        'quoc-oai' => 'Quốc Oai',
        'chuong-my' => 'Chương Mỹ',
        'thach-that' => 'Thạch Thất',
        'dan-phuong' => 'Đan Phượng',
        'ung-hoa' => 'Ứng Hòa',
        'my-duc' => 'Mỹ Đức',
        'ba-vi' => 'Ba Vì'
    );
    
    foreach ($area_terms as $slug => $name) {
        $term = get_term_by('slug', $slug, 'area');
        if (!$term) {
            wp_insert_term($name, 'area', array('slug' => $slug));
        }
    }
}

// 状態タクソノミーのデフォルトターム作成関数
function create_default_condition_terms() {
    $condition_terms = array(
        'new' => '新築',
        'used' => '中古',
        'planned' => '計画中'
    );
    
    foreach ($condition_terms as $slug => $name) {
        $term = get_term_by('slug', $slug, 'property_condition');
        if (!$term) {
            wp_insert_term($name, 'property_condition', array('slug' => $slug));
        }
    }
}

// 物件タイプタクソノミーのデフォルトターム作成関数
function create_default_property_type_terms() {
    $property_type_terms = array(
        'apartment' => 'アパート',
        'service-apartment' => 'サービスアパート',
        'house' => '戸建て住宅',
        'villa' => 'ヴィラ',
        'land' => '土地'
    );
    
    foreach ($property_type_terms as $slug => $name) {
        $term = get_term_by('slug', $slug, 'property_type');
        if (!$term) {
            wp_insert_term($name, 'property_type', array('slug' => $slug));
        }
    }
}


// 間取りタイプタクソノミーのデフォルトターム作成関数
function create_default_layout_type_terms() {
    $layout_type_terms = array(
        'studio' => 'スタジオ',
        '1k' => '1K',
        '1dk' => '1DK',
        '1ldk' => '1LDK',
        '2k' => '2K',
        '2dk' => '2DK',
        '2ldk' => '2LDK',
        '3k' => '3K',
        '3dk' => '3DK',
        '3ldk' => '3LDK',
        '4k' => '4K',
        '4dk' => '4DK',
        '4ldk' => '4LDK',
        '5k' => '5K',
        '5dk' => '5DK',
        '5ldk' => '5LDK',
        '6k' => '6K',
        '6dk' => '6DK',
        '6ldk' => '6LDK',
        'loft' => 'ロフト',
        'duplex' => 'デュプレックス',
        'penthouse' => 'ペントハウス',
        'terrace' => 'テラスハウス'
    );
    
    foreach ($layout_type_terms as $slug => $name) {
        $term = get_term_by('slug', $slug, 'property_tag');
        if (!$term) {
            wp_insert_term($name, 'property_tag', array('slug' => $slug));
        }
    }
}

// 間取りタイプセレクタ用のデフォルトターム作成関数
function create_default_layout_type_select_terms() {
    $layout_type_select_terms = array(
        'studio' => 'Studio',
        '1-room' => '1 Room',
        '2-room' => '2 Room',
        '3-room' => '3 Room',
        '4-room' => '4 Room',
        '5-room-plus' => '5 Room~'
    );
    
    foreach ($layout_type_select_terms as $slug => $name) {
        $term = get_term_by('slug', $slug, 'property_tag');
        if (!$term) {
            wp_insert_term($name, 'property_tag', array('slug' => $slug));
        }
    }
}

// プロジェクトの特徴・施設タクソノミーのデフォルトターム作成関数
function create_default_project_features_terms() {
    $project_feature_terms = array(
        // 施設・設備
        'concierge' => 'コンシェルジュサービス',
        'security' => '24時間セキュリティ',
        'parking' => '駐車場',
        'gym' => 'ジム・フィットネス',
        'pool' => 'プール',
        'sauna' => 'サウナ',
        'spa' => 'スパ・マッサージ',
        'restaurant' => 'レストラン・カフェ',
        'convenience' => 'コンビニエンスストア',
        'supermarket' => 'スーパーマーケット',
        'bank' => '銀行・ATM',
        'pharmacy' => '薬局・クリニック',
        'school' => '学校・保育園',
        'hospital' => '病院・医療施設',
        'playground' => '子供遊び場',
        'garden' => '庭園・緑地',
        'rooftop' => 'ルーフトップ・テラス',
        'lobby' => 'ロビー・ラウンジ',
        'meeting' => '会議室・イベントスペース',
        'library' => '図書館・読書室',
        'business' => 'ビジネスセンター',
        'laundry' => 'ランドリー・クリーニング',
        'storage' => '収納・倉庫',
        'elevator' => 'エレベーター',
        'escalator' => 'エスカレーター',
        'ramp' => 'スロープ・バリアフリー',
        'wifi' => 'Wi-Fi・インターネット',
        'cable' => 'ケーブルテレビ',
        'aircon' => '中央空調',
        'heating' => '暖房設備',
        'water' => '浄水システム',
        'power' => 'バックアップ電源',
        'fire' => '火災報知器・消火設備',
        'cctv' => '防犯カメラ',
        'access' => 'オートロック・入館管理',
        'delivery' => '宅配ボックス',
        'garbage' => 'ゴミ出し・廃棄物管理',
        'maintenance' => 'メンテナンスサービス',
        'cleaning' => 'ハウスキーピング',
        'transport' => '送迎サービス',
        'shuttle' => 'シャトルバス',
        'bike' => '自転車・バイク駐輪場'
    );
    
    foreach ($project_feature_terms as $slug => $name) {
        $term = get_term_by('slug', $slug, 'project_features');
        if (!$term) {
            wp_insert_term($name, 'project_features', array('slug' => $slug));
        }
    }
}

// プロジェクトの特徴・設備セレクタ用のデフォルトターム作成関数
function create_default_project_features_select_terms() {
    // 設備
    $facilities = array(
        'air-conditioning' => '空調システム',
        'fire-safety' => '防火システム',
        'football-field' => 'サッカー場',
        'basketball-court' => 'バスケットボールコート',
        'tennis-court' => 'テニスコート',
        'recreation-room' => 'レクリエーションルーム',
        'concierge' => 'コンシェルジュサービス',
        'security' => '警備員',
        'underground-parking' => '地下自動車駐車場',
        'multi-level-parking' => '立体自動車駐車場',
        'guest-parking' => 'ゲスト駐車場',
        'motorcycle-parking' => 'バイク駐車場',
        'heated-pool' => '温水プール',
        'outdoor-pool' => '屋外プール',
        'gym' => 'ジム',
        'bbq-facilities' => 'BBQ設備'
    );
    
    // 施設
    $amenities = array(
        'shopping-mall' => 'ショッピングモール',
        'supermarket' => 'スーパーマーケット',
        'convenience-store' => 'コンビニ',
        'park' => '公園',
        'restaurant' => 'レストラン',
        'hospital' => '病院',
        'school' => '学校',
        'kindergarten' => '幼稚園・保育園',
        'bus-stop' => 'バス停',
        'station' => '駅'
    );
    
    $all_features = array_merge($facilities, $amenities);
    
    foreach ($all_features as $slug => $name) {
        $term = get_term_by('slug', $slug, 'project_features');
        if (!$term) {
            wp_insert_term($name, 'project_features', array('slug' => $slug));
        }
    }
}

// 物件の特徴・設備タクソノミーのデフォルトターム作成関数
function create_default_property_features_terms() {
    $feature_terms = array(
        // 部屋
        'fingerprint-key' => '指紋キー',
        'electronic-key' => '電子キー',
        'card-key' => 'カードキー',
        'renovated' => 'リノベーション済み',
        'concept-design' => 'コンセプトデザイン',
        'furnished' => '備え付け家具',
        'soundproof' => '防音部屋',
        'flooring' => 'フローリング',
        'carpet-floor' => '絨毯床',
        'floor-heating' => '床暖房',
        'walk-in-closet' => 'ウォークインクローゼット',
        'island-kitchen' => 'アイランドキッチン',
        'ih-kitchen' => 'IHキッチン',
        'water-purifier' => '浄水器',
        'double-window' => '二重窓',
        'security-window' => '防犯窓',
        // トイレ・シャワールーム
        'bathtub' => '浴槽あり',
        'sauna' => 'サウナ',
        'bathroom-dryer' => '浴室乾燥機',
        // 物件
        'high-floor' => '高層階',
        'penthouse' => 'ペントハウス',
        'concierge-service' => 'コンシェルジュサービス',
        '24h-garbage' => '24時間ゴミ出し可能',
        'corner-room' => '角部屋',
        'pool-view' => '池が見える',
        'ocean-view' => '海が見える',
        'night-view' => '夜景が綺麗',
        'park-view' => '公園が見える'
    );
    
    foreach ($feature_terms as $slug => $name) {
        $term = get_term_by('slug', $slug, 'property_features');
        if (!$term) {
            wp_insert_term($name, 'property_features', array('slug' => $slug));
        }
    }
}

// テーマアクティベーション時にタクソノミーのデフォルトタームを作成
function create_default_terms_on_activation() {
    create_default_area_terms();
    create_default_condition_terms();
    create_default_property_type_terms();
    create_default_property_features_terms();
    create_default_layout_type_terms();
    create_default_project_features_terms();
    create_default_company_sector_terms();
    create_default_company_size_terms();
}

// 開発会社の事業分野タクソノミーのデフォルトターム作成関数
function create_default_company_sector_terms() {
    $sector_terms = array(
        'residential' => '住宅開発',
        'commercial' => '商業施設開発',
        'industrial' => '工業団地開発',
        'mixed-use' => '複合用途開発',
        'infrastructure' => 'インフラ開発',
        'urban-planning' => '都市計画',
        'renovation' => 'リノベーション',
        'consulting' => 'コンサルティング'
    );
    
    foreach ($sector_terms as $slug => $name) {
        $term = get_term_by('slug', $slug, 'company_sector');
        if (!$term) {
            wp_insert_term($name, 'company_sector', array('slug' => $slug));
        }
    }
}

// 開発会社の規模タクソノミーのデフォルトターム作成関数
function create_default_company_size_terms() {
    $size_terms = array(
        'small' => '小規模（1-50名）',
        'medium' => '中規模（51-200名）',
        'large' => '大規模（201-500名）',
        'enterprise' => '大企業（500名以上）'
    );
    
    foreach ($size_terms as $slug => $name) {
        $term = get_term_by('slug', $slug, 'company_size');
        if (!$term) {
            wp_insert_term($name, 'company_size', array('slug' => $slug));
        }
    }
}


// 検索フォームの処理
function handle_search_form() {
    if (isset($_POST['property_search'])) {
        $location = sanitize_text_field($_POST['location']);
        $price_min = intval($_POST['price_min']);
        $price_max = intval($_POST['price_max']);
        $rooms = sanitize_text_field($_POST['rooms']);
        $area = sanitize_text_field($_POST['area']);
        $condition = sanitize_text_field($_POST['condition']);
        $property_type = sanitize_text_field($_POST['property_type']);
        
        // 検索結果ページにリダイレクト
        $search_url = add_query_arg(array(
            'post_type' => 'property',
            'location'  => $location,
            'price_min' => $price_min,
            'price_max' => $price_max,
            'rooms'     => $rooms,
            'area'      => $area,
            'condition' => $condition,
            'property_type' => $property_type,
        ), home_url('/properties/'));
        
        wp_redirect($search_url);
        exit;
    }
}
add_action('wp_loaded', 'handle_search_form');

// 検索クエリの修正
function modify_search_query($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_post_type_archive('property') || is_search()) {
            $meta_query = array();
            
            if (!empty($_GET['location'])) {
                $meta_query[] = array(
                    'key'     => 'property_location',
                    'value'   => sanitize_text_field($_GET['location']),
                    'compare' => 'LIKE',
                );
            }
            
            if (!empty($_GET['price_min']) || !empty($_GET['price_max'])) {
                $price_query = array(
                    'key'     => 'property_price',
                    'type'    => 'NUMERIC',
                );
                
                if (!empty($_GET['price_min']) && !empty($_GET['price_max'])) {
                    $price_query['value'] = array(
                        intval($_GET['price_min']),
                        intval($_GET['price_max'])
                    );
                    $price_query['compare'] = 'BETWEEN';
                } elseif (!empty($_GET['price_min'])) {
                    $price_query['value'] = intval($_GET['price_min']);
                    $price_query['compare'] = '>=';
                } else {
                    $price_query['value'] = intval($_GET['price_max']);
                    $price_query['compare'] = '<=';
                }
                
                $meta_query[] = $price_query;
            }
            
            if (!empty($_GET['rooms'])) {
                $meta_query[] = array(
                    'key'     => 'property_rooms',
                    'value'   => sanitize_text_field($_GET['rooms']),
                    'compare' => '=',
                );
            }
            
            if (!empty($meta_query)) {
                $query->set('meta_query', $meta_query);
            }
            
            if (!empty($_GET['area'])) {
                $query->set('tax_query', array(
                    array(
                        'taxonomy' => 'area',
                        'field'    => 'slug',
                        'terms'    => sanitize_text_field($_GET['area']),
                    ),
                ));
            }
        }
    }
}
add_action('pre_get_posts', 'modify_search_query');

// スライダー画像の取得
function get_slider_images() {
    $slides = get_theme_mod('hero_slides', array());
    if (empty($slides)) {
        // デフォルトのスライド画像
        $slides = array(
            array(
                'image' => get_template_directory_uri() . '/images/slide1.jpg',
                'title' => 'Chung cư cao cấp mới xây',
                'description' => 'Tìm ngôi nhà lý tưởng của bạn'
            ),
            array(
                'image' => get_template_directory_uri() . '/images/slide2.jpg',
                'title' => 'Bất động sản vị trí thuận tiện',
                'description' => 'Giới thiệu bất động sản gần ga tiện lợi'
            ),
            array(
                'image' => get_template_directory_uri() . '/images/slide3.jpg',
                'title' => 'Hệ thống hỗ trợ đáng tin cậy',
                'description' => 'Hỗ trợ từ mua đến nhập cư'
            ),
        );
    }
    return $slides;
}

// カスタマイザーの設定
function theme_customize_register($wp_customize) {
    // ヒーロースライダーセクション
    $wp_customize->add_section('hero_slider', array(
        'title'    => 'ヒーロースライダー',
        'priority' => 30,
    ));
    
    $wp_customize->add_setting('hero_slides', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_slides', array(
        'label'   => 'スライド設定',
        'section' => 'hero_slider',
        'type'    => 'textarea',
    ));
}
add_action('customize_register', 'theme_customize_register');


// 管理バーを無効化
add_filter('show_admin_bar', '__return_false');

// Setup機能の追加
function add_setup_admin_menu() {
    add_management_page(
        'Setup - サンプルデータ生成',
        'Setup',
        'manage_options',
        'theme-setup',
        'theme_setup_page'
    );
}
add_action('admin_menu', 'add_setup_admin_menu');

// Setupページの表示
function theme_setup_page() {
    if (isset($_POST['generate_sample_data'])) {
        if (wp_verify_nonce($_POST['setup_nonce'], 'theme_setup_action')) {
            $properties_count = generate_sample_properties();
            $projects_count = generate_sample_projects();
            $companies_count = generate_sample_companies();
            
            echo '<div class="notice notice-success"><p>';
            echo 'サンプルデータを生成しました！<br>';
            echo '不動産: ' . $properties_count . '件<br>';
            echo 'プロジェクト: ' . $projects_count . '件<br>';
            echo '開発会社: ' . $companies_count . '件';
            echo '</p></div>';
        }
    }
    
    if (isset($_POST['clear_sample_data'])) {
        if (wp_verify_nonce($_POST['setup_nonce'], 'theme_setup_action')) {
            $deleted_properties = clear_sample_properties();
            $deleted_projects = clear_sample_projects();
            $deleted_companies = clear_sample_companies();
            
            echo '<div class="notice notice-success"><p>';
            echo 'サンプルデータを削除しました！<br>';
            echo '削除された不動産: ' . $deleted_properties . '件<br>';
            echo '削除されたプロジェクト: ' . $deleted_projects . '件<br>';
            echo '削除された開発会社: ' . $deleted_companies . '件';
            echo '</p></div>';
        }
    }
    ?>
    <div class="wrap">
        <h1>Setup - サンプルデータ生成</h1>
        <p>このページでは、テーマの動作確認用のサンプルデータを生成・削除できます。</p>
        
        <div style="background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 4px; margin: 20px 0;">
            <h2>サンプルデータ生成</h2>
            <p>以下のボタンをクリックすると、サンプルの不動産、プロジェクト、開発会社データが生成されます。</p>
            
            <form method="post" style="margin: 20px 0;">
                <?php wp_nonce_field('theme_setup_action', 'setup_nonce'); ?>
                <input type="submit" name="generate_sample_data" class="button button-primary" value="サンプルデータを生成する（不動産10件・プロジェクト10件・開発会社10件）" onclick="return confirm('サンプルデータを生成しますか？');">
            </form>
        </div>
        
        <div style="background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 4px; margin: 20px 0;">
            <h2>サンプルデータ削除</h2>
            <p style="color: #d63638;">注意: この操作は元に戻せません。サンプルデータのみが削除されます。</p>
            
            <form method="post" style="margin: 20px 0;">
                <?php wp_nonce_field('theme_setup_action', 'setup_nonce'); ?>
                <input type="submit" name="clear_sample_data" class="button button-secondary" value="サンプルデータを削除する" onclick="return confirm('本当にサンプルデータを削除しますか？この操作は元に戻せません。');">
            </form>
        </div>
        
        <div style="background: #f0f6fc; padding: 15px; border-left: 4px solid #0073aa; margin: 20px 0;">
            <h3>現在のデータ状況</h3>
            <p>
                <strong>不動産:</strong> <?php echo wp_count_posts('property')->publish; ?>件<br>
                <strong>プロジェクト:</strong> <?php echo wp_count_posts('project')->publish; ?>件<br>
                <strong>開発会社:</strong> <?php echo wp_count_posts('company')->publish; ?>件
            </p>
        </div>
    </div>
    <?php
}

// 開発会社のエリアコールバック関数
function company_area_callback($post) {
    // エリアタクソノミーのデフォルトタームを作成
    create_default_area_terms();
    
    $selected_terms = wp_get_post_terms($post->ID, 'area', array('fields' => 'ids'));
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label for="company_area">エリア</label></th>';
    echo '<td>';
    
    // エリアの選択肢（ベトナム語表記）
    $area_options = array(
        'city' => array(
            'label' => 'ハノイ市内',
            'areas' => array(
                'ba-dinh' => 'Ba Đình',
                'hoan-kiem' => 'Hoàn Kiếm',
                'hai-ba-trung' => 'Hai Bà Trưng',
                'dong-da' => 'Đống Đa',
                'tay-ho' => 'Tây Hồ',
                'cau-giay' => 'Cầu Giấy',
                'thanh-xuan' => 'Thanh Xuân',
                'hoang-mai' => 'Hoàng Mai',
                'long-bien' => 'Long Biên',
                'nam-tu-liem' => 'Nam Từ Liêm',
                'bac-tu-liem' => 'Bắc Từ Liêm',
                'ha-dong' => 'Hà Đông'
            )
        ),
        'suburb' => array(
            'label' => 'ハノイ郊外',
            'areas' => array(
                'son-tay' => 'Sơn Tây',
                'dong-anh' => 'Đông Anh',
                'gia-lam' => 'Gia Lâm',
                'soc-son' => 'Sóc Sơn',
                'thanh-tri' => 'Thanh Trì',
                'me-linh' => 'Mê Linh',
                'hoai-duc' => 'Hoài Đức',
                'thuong-tin' => 'Thường Tín',
                'thanh-oai' => 'Thanh Oai',
                'phu-xuyen' => 'Phú Xuyên',
                'quoc-oai' => 'Quốc Oai',
                'chuong-my' => 'Chương Mỹ',
                'thach-that' => 'Thạch Thất',
                'dan-phuong' => 'Đan Phượng',
                'ung-hoa' => 'Ứng Hòa',
                'my-duc' => 'Mỹ Đức',
                'ba-vi' => 'Ba Vì'
            )
        )
    );
    
    echo '<select id="company_area" name="company_area[]" multiple style="width: 100%; height: 150px;">';
    echo '<option value="">選択してください</option>';
    
    foreach ($area_options as $group_key => $group_data) {
        echo '<optgroup label="' . esc_html($group_data['label']) . '">';
        
        foreach ($group_data['areas'] as $slug => $label) {
            // タームが存在しない場合は作成
            $term = get_term_by('slug', $slug, 'area');
            if (!$term) {
                $term_result = wp_insert_term($label, 'area', array('slug' => $slug));
                if (!is_wp_error($term_result)) {
                    $term = get_term($term_result['term_id'], 'area');
                }
            }
            
            if ($term) {
                $selected = in_array($term->term_id, $selected_terms) ? 'selected' : '';
                echo '<option value="' . esc_attr($term->term_id) . '" ' . $selected . '>' . esc_html($label) . '</option>';
            }
        }
        
        echo '</optgroup>';
    }
    
    echo '</select>';
    echo '<p class="description">複数選択可能です。Ctrlキー（MacではCommandキー）を押しながらクリックしてください。</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// 開発会社の事業分野コールバック関数
function company_sector_callback($post) {
    // 事業分野タクソノミーのデフォルトタームを作成
    create_default_company_sector_terms();
    
    $selected_terms = wp_get_post_terms($post->ID, 'company_sector', array('fields' => 'ids'));
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label>事業分野</label></th>';
    echo '<td>';
    
    // 事業分野の選択肢
    $sector_options = array(
        'residential' => '住宅開発',
        'commercial' => '商業施設開発',
        'industrial' => '工業団地開発',
        'mixed-use' => '複合用途開発',
        'infrastructure' => 'インフラ開発',
        'urban-planning' => '都市計画',
        'renovation' => 'リノベーション',
        'consulting' => 'コンサルティング'
    );
    
    foreach ($sector_options as $slug => $label) {
        // タームが存在しない場合は作成
        $term = get_term_by('slug', $slug, 'company_sector');
        if (!$term) {
            $term_result = wp_insert_term($label, 'company_sector', array('slug' => $slug));
            if (!is_wp_error($term_result)) {
                $term = get_term($term_result['term_id'], 'company_sector');
            }
        }
        
        if ($term) {
            $checked = in_array($term->term_id, $selected_terms) ? 'checked' : '';
            echo '<label style="display: block; margin-bottom: 10px;">';
            echo '<input type="checkbox" name="company_sector[]" value="' . esc_attr($term->term_id) . '" ' . $checked . ' style="margin-right: 8px;">';
            echo esc_html($label);
            echo '</label>';
        }
    }
    
    echo '<p class="description">該当する事業分野にチェックを入れてください。複数選択可能です。</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// 開発会社の規模コールバック関数
function company_size_callback($post) {
    // 会社規模タクソノミーのデフォルトタームを作成
    create_default_company_size_terms();
    
    $selected_terms = wp_get_post_terms($post->ID, 'company_size', array('fields' => 'ids'));
    $selected_term_id = !empty($selected_terms) ? $selected_terms[0] : '';
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label>会社規模</label></th>';
    echo '<td>';
    
    // 会社規模の選択肢
    $size_options = array(
        'small' => '小規模（1-50名）',
        'medium' => '中規模（51-200名）',
        'large' => '大規模（201-500名）',
        'enterprise' => '大企業（500名以上）'
    );
    
    foreach ($size_options as $slug => $label) {
        // タームが存在しない場合は作成
        $term = get_term_by('slug', $slug, 'company_size');
        if (!$term) {
            $term_result = wp_insert_term($label, 'company_size', array('slug' => $slug));
            if (!is_wp_error($term_result)) {
                $term = get_term($term_result['term_id'], 'company_size');
            }
        }
        
        if ($term) {
            $checked = ($selected_term_id == $term->term_id) ? 'checked' : '';
            echo '<label style="display: block; margin-bottom: 10px;">';
            echo '<input type="radio" name="company_size" value="' . esc_attr($term->term_id) . '" ' . $checked . ' style="margin-right: 8px;">';
            echo esc_html($label);
            echo '</label>';
        }
    }
    
    echo '<p class="description">会社の規模を選択してください。</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// 開発会社詳細情報のコールバック関数
function company_details_callback($post) {
    $established_year = get_post_meta($post->ID, '_company_established_year', true);
    $employees = get_post_meta($post->ID, '_company_employees', true);
    $capital = get_post_meta($post->ID, '_company_capital', true);
    $website = get_post_meta($post->ID, '_company_website', true);
    
    echo '<table class="form-table">';
    
    // 設立年
    echo '<tr>';
    echo '<th scope="row"><label for="company_established_year">設立年</label></th>';
    echo '<td>';
    echo '<input type="number" id="company_established_year" name="company_established_year" value="' . esc_attr($established_year) . '" style="width: 200px;" min="1800" max="' . date('Y') . '" />';
    echo '<p class="description">会社の設立年を入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    // 従業員数
    echo '<tr>';
    echo '<th scope="row"><label for="company_employees">従業員数</label></th>';
    echo '<td>';
    echo '<input type="number" id="company_employees" name="company_employees" value="' . esc_attr($employees) . '" style="width: 200px;" min="1" />';
    echo '<span style="margin-left: 10px;">名</span>';
    echo '<p class="description">現在の従業員数を入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    // 資本金
    echo '<tr>';
    echo '<th scope="row"><label for="company_capital">資本金</label></th>';
    echo '<td>';
    echo '<input type="number" id="company_capital" name="company_capital" value="' . esc_attr($capital) . '" style="width: 200px;" min="0" />';
    echo '<span style="margin-left: 10px;">VND（ベトナムドン）</span>';
    echo '<p class="description">資本金をベトナムドンで入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    // ウェブサイト
    echo '<tr>';
    echo '<th scope="row"><label for="company_website">ウェブサイト</label></th>';
    echo '<td>';
    echo '<input type="url" id="company_website" name="company_website" value="' . esc_attr($website) . '" style="width: 100%;" placeholder="https://example.com" />';
    echo '<p class="description">会社のウェブサイトURLを入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
}

// 不動産のプロジェクト選択コールバック関数
function property_project_callback($post) {
    $selected_project_id = get_post_meta($post->ID, '_property_project_id', true);
    $selected_project_title = '';
    
    if ($selected_project_id) {
        $project = get_post($selected_project_id);
        if ($project) {
            $selected_project_title = $project->post_title;
        }
    }
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label for="property_project_search">関連プロジェクト</label></th>';
    echo '<td>';
    
    echo '<div class="project-search-container" style="position: relative;">';
    echo '<input type="text" id="property_project_search" class="project-search-input" placeholder="プロジェクトを検索..." value="' . esc_attr($selected_project_title) . '" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">';
    echo '<input type="hidden" id="property_project_id" name="property_project_id" value="' . esc_attr($selected_project_id) . '">';
    echo '<div id="project_search_results" class="project-search-results" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-top: none; max-height: 200px; overflow-y: auto; z-index: 1000; display: none;"></div>';
    echo '</div>';
    
    echo '<p class="description">この不動産が所属するプロジェクトを選択してください。検索ボックスにプロジェクト名を入力して選択できます。</p>';
    
    if ($selected_project_id) {
        echo '<div id="selected_project_info" style="margin-top: 10px; padding: 10px; background: #f0f6fc; border: 1px solid #0073aa; border-radius: 4px;">';
        echo '<strong>選択中のプロジェクト:</strong> ' . esc_html($selected_project_title);
        echo ' <button type="button" id="clear_project_selection" style="margin-left: 10px; color: #d63638; background: none; border: none; cursor: pointer; text-decoration: underline;">選択をクリア</button>';
        echo '</div>';
    }
    
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// 不動産の開発会社選択コールバック関数
function property_company_callback($post) {
    $selected_company_id = get_post_meta($post->ID, '_property_company_id', true);
    $selected_company_title = '';
    
    if ($selected_company_id) {
        $company = get_post($selected_company_id);
        if ($company) {
            $selected_company_title = $company->post_title;
        }
    }
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label for="property_company_search">関連開発会社</label></th>';
    echo '<td>';
    
    echo '<div class="company-search-container" style="position: relative;">';
    echo '<input type="text" id="property_company_search" class="company-search-input" placeholder="開発会社を検索..." value="' . esc_attr($selected_company_title) . '" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">';
    echo '<input type="hidden" id="property_company_id" name="property_company_id" value="' . esc_attr($selected_company_id) . '">';
    echo '<div id="company_search_results" class="company-search-results" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-top: none; max-height: 200px; overflow-y: auto; z-index: 1000; display: none;"></div>';
    echo '</div>';
    
    echo '<p class="description">この不動産を開発した会社を選択してください。検索ボックスに会社名を入力して選択できます。</p>';
    
    if ($selected_company_id) {
        echo '<div id="selected_company_info" style="margin-top: 10px; padding: 10px; background: #f0f6fc; border: 1px solid #0073aa; border-radius: 4px;">';
        echo '<strong>選択中の開発会社:</strong> ' . esc_html($selected_company_title);
        echo ' <button type="button" id="clear_company_selection" style="margin-left: 10px; color: #d63638; background: none; border: none; cursor: pointer; text-decoration: underline;">選択をクリア</button>';
        echo '</div>';
    }
    
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// 開発会社連絡先情報のコールバック関数
function company_contact_callback($post) {
    $phone = get_post_meta($post->ID, '_company_phone', true);
    $email = get_post_meta($post->ID, '_company_email', true);
    $address = get_post_meta($post->ID, '_company_address', true);
    $contact_person = get_post_meta($post->ID, '_company_contact_person', true);
    
    echo '<table class="form-table">';
    
    // 電話番号
    echo '<tr>';
    echo '<th scope="row"><label for="company_phone">電話番号</label></th>';
    echo '<td>';
    echo '<input type="tel" id="company_phone" name="company_phone" value="' . esc_attr($phone) . '" style="width: 100%;" placeholder="+84 24 1234 5678" />';
    echo '<p class="description">会社の電話番号を入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    // メールアドレス
    echo '<tr>';
    echo '<th scope="row"><label for="company_email">メールアドレス</label></th>';
    echo '<td>';
    echo '<input type="email" id="company_email" name="company_email" value="' . esc_attr($email) . '" style="width: 100%;" placeholder="info@company.com" />';
    echo '<p class="description">会社のメールアドレスを入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    // 住所
    echo '<tr>';
    echo '<th scope="row"><label for="company_address">住所</label></th>';
    echo '<td>';
    echo '<textarea id="company_address" name="company_address" rows="3" style="width: 100%;">' . esc_textarea($address) . '</textarea>';
    echo '<p class="description">会社の住所を入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    // 担当者名
    echo '<tr>';
    echo '<th scope="row"><label for="company_contact_person">担当者名</label></th>';
    echo '<td>';
    echo '<input type="text" id="company_contact_person" name="company_contact_person" value="' . esc_attr($contact_person) . '" style="width: 100%;" placeholder="Nguyễn Văn A" />';
    echo '<p class="description">担当者の名前を入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
}

// サンプル不動産データの生成
function generate_sample_properties() {
    $sample_properties = array(
        array(
            'title' => 'Chung cư cao cấp tại Ba Đình',
            'content' => 'Chung cư cao cấp với thiết kế hiện đại, nằm tại trung tâm quận Ba Đình. Gần các trường học, bệnh viện và trung tâm thương mại.',
            'price' => 2500000000,
            'area_size' => 85.5,
            'management_fee' => 150000,
            'car_parking_fee' => 2000000,
            'bike_parking_fee' => 500000,
            'areas' => array('ba-dinh'),
            'condition' => 'new',
            'property_type' => 'apartment',
            'layout_types' => array('2ldk'),
            'features' => array('concierge-service', 'security', 'gym', 'pool')
        ),
        array(
            'title' => 'Căn hộ dịch vụ tại Hoàn Kiếm',
            'content' => 'Căn hộ dịch vụ tiện nghi, phù hợp cho người nước ngoài và doanh nhân. Có đầy đủ nội thất và dịch vụ hỗ trợ.',
            'price' => 1800000000,
            'area_size' => 65.0,
            'management_fee' => 120000,
            'car_parking_fee' => 1500000,
            'bike_parking_fee' => 300000,
            'areas' => array('hoan-kiem'),
            'condition' => 'new',
            'property_type' => 'service-apartment',
            'layout_types' => array('1ldk'),
            'features' => array('furnished', 'concierge-service', 'security', 'wifi')
        ),
        array(
            'title' => 'Nhà phố tại Hai Bà Trưng',
            'content' => 'Nhà phố 3 tầng với sân vườn, phù hợp cho gia đình. Khu vực yên tĩnh, gần trường học và chợ.',
            'price' => 4500000000,
            'area_size' => 120.0,
            'management_fee' => 0,
            'car_parking_fee' => 0,
            'bike_parking_fee' => 0,
            'areas' => array('hai-ba-trung'),
            'condition' => 'used',
            'property_type' => 'house',
            'layout_types' => array('3ldk'),
            'features' => array('garden', 'parking', 'security')
        ),
        array(
            'title' => 'Biệt thự tại Tây Hồ',
            'content' => 'Biệt thự sang trọng bên hồ Tây, view đẹp, không gian rộng rãi. Phù hợp cho gia đình có điều kiện.',
            'price' => 8500000000,
            'area_size' => 200.0,
            'management_fee' => 300000,
            'car_parking_fee' => 0,
            'bike_parking_fee' => 0,
            'areas' => array('tay-ho'),
            'condition' => 'new',
            'property_type' => 'villa',
            'layout_types' => array('4ldk'),
            'features' => array('lake-view', 'garden', 'pool', 'security')
        ),
        array(
            'title' => 'Căn hộ 1LDK tại Cầu Giấy',
            'content' => 'Căn hộ 1LDK mới xây, gần các trường đại học và khu công nghệ cao. Phù hợp cho sinh viên và nhân viên văn phòng.',
            'price' => 1200000000,
            'area_size' => 45.0,
            'management_fee' => 80000,
            'car_parking_fee' => 1000000,
            'bike_parking_fee' => 200000,
            'areas' => array('cau-giay'),
            'condition' => 'new',
            'property_type' => 'apartment',
            'layout_types' => array('1ldk'),
            'features' => array('security', 'wifi', 'elevator')
        ),
        array(
            'title' => 'Căn hộ 2LDK tại Thanh Xuân',
            'content' => 'Căn hộ 2LDK với thiết kế tối ưu, gần trung tâm thương mại và bệnh viện. Có ban công rộng và view đẹp.',
            'price' => 2200000000,
            'area_size' => 75.0,
            'management_fee' => 130000,
            'car_parking_fee' => 1800000,
            'bike_parking_fee' => 400000,
            'areas' => array('thanh-xuan'),
            'condition' => 'new',
            'property_type' => 'apartment',
            'layout_types' => array('2ldk'),
            'features' => array('balcony', 'security', 'gym', 'elevator')
        ),
        array(
            'title' => 'Căn hộ 3LDK tại Hoàng Mai',
            'content' => 'Căn hộ 3LDK rộng rãi, phù hợp cho gia đình đông người. Gần công viên và trường học quốc tế.',
            'price' => 3200000000,
            'area_size' => 95.0,
            'management_fee' => 180000,
            'car_parking_fee' => 2200000,
            'bike_parking_fee' => 500000,
            'areas' => array('hoang-mai'),
            'condition' => 'new',
            'property_type' => 'apartment',
            'layout_types' => array('3ldk'),
            'features' => array('park-view', 'security', 'playground', 'gym')
        ),
        array(
            'title' => 'Căn hộ Studio tại Long Biên',
            'content' => 'Căn hộ Studio nhỏ gọn, phù hợp cho người độc thân. Gần cầu Long Biên và khu phố cổ.',
            'price' => 800000000,
            'area_size' => 30.0,
            'management_fee' => 60000,
            'car_parking_fee' => 800000,
            'bike_parking_fee' => 150000,
            'areas' => array('long-bien'),
            'condition' => 'used',
            'property_type' => 'apartment',
            'layout_types' => array('studio'),
            'features' => array('security', 'elevator', 'wifi')
        ),
        array(
            'title' => 'Căn hộ 4LDK tại Nam Từ Liêm',
            'content' => 'Căn hộ 4LDK cao cấp với đầy đủ tiện nghi. Gần các trung tâm thương mại lớn và trường học quốc tế.',
            'price' => 4200000000,
            'area_size' => 110.0,
            'management_fee' => 200000,
            'car_parking_fee' => 2500000,
            'bike_parking_fee' => 600000,
            'areas' => array('nam-tu-liem'),
            'condition' => 'new',
            'property_type' => 'apartment',
            'layout_types' => array('4ldk'),
            'features' => array('concierge-service', 'security', 'gym', 'pool', 'sauna')
        ),
        array(
            'title' => 'Căn hộ 2LDK tại Bắc Từ Liêm',
            'content' => 'Căn hộ 2LDK với giá hợp lý, gần các khu công nghiệp và trung tâm logistics. Phù hợp cho công nhân và nhân viên.',
            'price' => 1500000000,
            'area_size' => 60.0,
            'management_fee' => 90000,
            'car_parking_fee' => 1200000,
            'bike_parking_fee' => 250000,
            'areas' => array('bac-tu-liem'),
            'condition' => 'new',
            'property_type' => 'apartment',
            'layout_types' => array('2ldk'),
            'features' => array('security', 'elevator', 'wifi')
        )
    );
    
    $created_count = 0;
    
    foreach ($sample_properties as $property_data) {
        // 投稿を作成
        $post_id = wp_insert_post(array(
            'post_title' => $property_data['title'],
            'post_content' => $property_data['content'],
            'post_status' => 'publish',
            'post_type' => 'property',
            'meta_input' => array(
                '_property_price' => $property_data['price'],
                '_property_area_size' => $property_data['area_size'],
                '_property_management_fee' => $property_data['management_fee'],
                '_property_car_parking_fee' => $property_data['car_parking_fee'],
                '_property_bike_parking_fee' => $property_data['bike_parking_fee'],
                '_sample_data' => 'yes' // サンプルデータのマーク
            )
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            // エリアタクソノミーを設定
            if (!empty($property_data['areas'])) {
                $area_terms = array();
                foreach ($property_data['areas'] as $area_slug) {
                    $term = get_term_by('slug', $area_slug, 'area');
                    if ($term) {
                        $area_terms[] = $term->term_id;
                    }
                }
                if (!empty($area_terms)) {
                    wp_set_post_terms($post_id, $area_terms, 'area');
                }
            }
            
            // 状態タクソノミーを設定
            if (!empty($property_data['condition'])) {
                $condition_term = get_term_by('slug', $property_data['condition'], 'property_condition');
                if ($condition_term) {
                    wp_set_post_terms($post_id, array($condition_term->term_id), 'property_condition');
                }
            }
            
            // 物件タイプタクソノミーを設定
            if (!empty($property_data['property_type'])) {
                $type_term = get_term_by('slug', $property_data['property_type'], 'property_type');
                if ($type_term) {
                    wp_set_post_terms($post_id, array($type_term->term_id), 'property_type');
                }
            }
            
            // 間取りタイプタクソノミーを設定
            if (!empty($property_data['layout_types'])) {
                $layout_terms = array();
                foreach ($property_data['layout_types'] as $layout_slug) {
                    $term = get_term_by('slug', $layout_slug, 'property_tag');
                    if ($term) {
                        $layout_terms[] = $term->term_id;
                    }
                }
                if (!empty($layout_terms)) {
                    wp_set_post_terms($post_id, $layout_terms, 'property_tag');
                }
            }
            
            // 特徴・設備タクソノミーを設定
            if (!empty($property_data['features'])) {
                $feature_terms = array();
                foreach ($property_data['features'] as $feature_slug) {
                    $term = get_term_by('slug', $feature_slug, 'property_features');
                    if ($term) {
                        $feature_terms[] = $term->term_id;
                    }
                }
                if (!empty($feature_terms)) {
                    wp_set_post_terms($post_id, $feature_terms, 'property_features');
                }
            }
            
            $created_count++;
        }
    }
    
    return $created_count;
}

// サンプルプロジェクトデータの生成
function generate_sample_projects() {
    $sample_projects = array(
        array(
            'title' => 'Dự án chung cư cao cấp The Golden Tower',
            'content' => 'Dự án chung cư cao cấp với thiết kế hiện đại, nằm tại trung tâm quận Ba Đình. Dự án có 2 tòa nhà cao 30 tầng với tổng cộng 600 căn hộ.',
            'total_units' => 600,
            'land_area' => 2500.0,
            'location' => 'Số 123 Đường Kim Mã, Quận Ba Đình, Hà Nội',
            'areas' => array('ba-dinh'),
            'features' => array('concierge', 'security', 'gym', 'pool', 'sauna', 'restaurant', 'supermarket')
        ),
        array(
            'title' => 'Khu đô thị sinh thái Green Valley',
            'content' => 'Khu đô thị sinh thái với không gian xanh, phù hợp cho gia đình. Dự án bao gồm nhà phố, biệt thự và căn hộ cao cấp.',
            'total_units' => 1200,
            'land_area' => 5000.0,
            'location' => 'Xã Đông Anh, Huyện Đông Anh, Hà Nội',
            'areas' => array('dong-anh'),
            'features' => array('park', 'school', 'hospital', 'shopping-mall', 'gym', 'pool', 'security')
        ),
        array(
            'title' => 'Tổ hợp căn hộ dịch vụ Smart Living',
            'content' => 'Tổ hợp căn hộ dịch vụ thông minh với công nghệ hiện đại. Phù hợp cho người nước ngoài và doanh nhân.',
            'total_units' => 400,
            'land_area' => 1800.0,
            'location' => 'Số 456 Đường Láng, Quận Đống Đa, Hà Nội',
            'areas' => array('dong-da'),
            'features' => array('concierge', 'security', 'wifi', 'restaurant', 'gym', 'laundry', 'business')
        ),
        array(
            'title' => 'Dự án biệt thự ven hồ Lake View Villas',
            'content' => 'Dự án biệt thự cao cấp bên hồ Tây với view đẹp. Mỗi biệt thự có sân vườn riêng và bến tàu riêng.',
            'total_units' => 80,
            'land_area' => 3000.0,
            'location' => 'Đường Lạc Long Quân, Quận Tây Hồ, Hà Nội',
            'areas' => array('tay-ho'),
            'features' => array('lake-view', 'garden', 'pool', 'security', 'concierge', 'restaurant', 'spa')
        ),
        array(
            'title' => 'Khu căn hộ sinh viên Student Hub',
            'content' => 'Khu căn hộ dành cho sinh viên với giá cả hợp lý. Gần các trường đại học và khu công nghệ cao.',
            'total_units' => 800,
            'land_area' => 2000.0,
            'location' => 'Đường Cầu Giấy, Quận Cầu Giấy, Hà Nội',
            'areas' => array('cau-giay'),
            'features' => array('wifi', 'security', 'library', 'gym', 'restaurant', 'convenience-store')
        ),
        array(
            'title' => 'Dự án căn hộ gia đình Family Garden',
            'content' => 'Dự án căn hộ dành cho gia đình với không gian rộng rãi. Có khu vui chơi cho trẻ em và khu thể thao.',
            'total_units' => 500,
            'land_area' => 2200.0,
            'location' => 'Đường Nguyễn Trãi, Quận Thanh Xuân, Hà Nội',
            'areas' => array('thanh-xuan'),
            'features' => array('playground', 'gym', 'pool', 'security', 'school', 'kindergarten', 'park')
        ),
        array(
            'title' => 'Tổ hợp thương mại và căn hộ Trade Center',
            'content' => 'Tổ hợp thương mại và căn hộ với trung tâm mua sắm lớn. Kết hợp giữa kinh doanh và sinh hoạt.',
            'total_units' => 300,
            'land_area' => 1500.0,
            'location' => 'Đường Giải Phóng, Quận Hai Bà Trưng, Hà Nội',
            'areas' => array('hai-ba-trung'),
            'features' => array('shopping-mall', 'restaurant', 'gym', 'security', 'parking', 'bank', 'pharmacy')
        ),
        array(
            'title' => 'Dự án căn hộ cao cấp Luxury Residence',
            'content' => 'Dự án căn hộ cao cấp với đầy đủ tiện nghi 5 sao. Dành cho khách hàng có thu nhập cao.',
            'total_units' => 200,
            'land_area' => 1200.0,
            'location' => 'Đường Hoàng Hoa Thám, Quận Hoàng Mai, Hà Nội',
            'areas' => array('hoang-mai'),
            'features' => array('concierge', 'security', 'gym', 'pool', 'sauna', 'spa', 'restaurant', 'supermarket')
        ),
        array(
            'title' => 'Khu đô thị mới New City Development',
            'content' => 'Khu đô thị mới với quy hoạch tổng thể hiện đại. Bao gồm nhà ở, trường học, bệnh viện và trung tâm thương mại.',
            'total_units' => 1500,
            'land_area' => 8000.0,
            'location' => 'Xã Nam Từ Liêm, Quận Nam Từ Liêm, Hà Nội',
            'areas' => array('nam-tu-liem'),
            'features' => array('school', 'hospital', 'shopping-mall', 'park', 'gym', 'pool', 'security', 'bank')
        ),
        array(
            'title' => 'Dự án căn hộ giá rẻ Affordable Housing',
            'content' => 'Dự án căn hộ giá rẻ dành cho người có thu nhập thấp. Đảm bảo chất lượng sống tốt với giá cả hợp lý.',
            'total_units' => 1000,
            'land_area' => 3000.0,
            'location' => 'Đường Bắc Từ Liêm, Quận Bắc Từ Liêm, Hà Nội',
            'areas' => array('bac-tu-liem'),
            'features' => array('security', 'park', 'school', 'hospital', 'convenience-store', 'bus-stop')
        )
    );
    
    $created_count = 0;
    
    foreach ($sample_projects as $project_data) {
        // 投稿を作成
        $post_id = wp_insert_post(array(
            'post_title' => $project_data['title'],
            'post_content' => $project_data['content'],
            'post_status' => 'publish',
            'post_type' => 'project',
            'meta_input' => array(
                '_project_total_units' => $project_data['total_units'],
                '_project_land_area' => $project_data['land_area'],
                '_project_location' => $project_data['location'],
                '_sample_data' => 'yes' // サンプルデータのマーク
            )
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            // エリアタクソノミーを設定
            if (!empty($project_data['areas'])) {
                $area_terms = array();
                foreach ($project_data['areas'] as $area_slug) {
                    $term = get_term_by('slug', $area_slug, 'area');
                    if ($term) {
                        $area_terms[] = $term->term_id;
                    }
                }
                if (!empty($area_terms)) {
                    wp_set_post_terms($post_id, $area_terms, 'area');
                }
            }
            
            // プロジェクトの特徴・施設タクソノミーを設定
            if (!empty($project_data['features'])) {
                $feature_terms = array();
                foreach ($project_data['features'] as $feature_slug) {
                    $term = get_term_by('slug', $feature_slug, 'project_features');
                    if ($term) {
                        $feature_terms[] = $term->term_id;
                    }
                }
                if (!empty($feature_terms)) {
                    wp_set_post_terms($post_id, $feature_terms, 'project_features');
                }
            }
            
            $created_count++;
        }
    }
    
    return $created_count;
}

// サンプルデータの削除機能
function clear_sample_properties() {
    $deleted_count = 0;
    
    $sample_properties = get_posts(array(
        'post_type' => 'property',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_sample_data',
                'value' => 'yes',
                'compare' => '='
            )
        )
    ));
    
    foreach ($sample_properties as $property) {
        if (wp_delete_post($property->ID, true)) {
            $deleted_count++;
        }
    }
    
    return $deleted_count;
}

function clear_sample_projects() {
    $deleted_count = 0;
    
    $sample_projects = get_posts(array(
        'post_type' => 'project',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_sample_data',
                'value' => 'yes',
                'compare' => '='
            )
        )
    ));
    
    foreach ($sample_projects as $project) {
        if (wp_delete_post($project->ID, true)) {
            $deleted_count++;
        }
    }
    
    return $deleted_count;
}

// サンプル開発会社データの生成
function generate_sample_companies() {
    $sample_companies = array(
        array(
            'title' => 'Công ty TNHH Phát triển Bất động sản Vinhomes',
            'content' => 'Vinhomes là một trong những công ty phát triển bất động sản hàng đầu tại Việt Nam, chuyên về phát triển các dự án khu đô thị cao cấp và chung cư hiện đại.',
            'established_year' => 2007,
            'employees' => 5000,
            'capital' => 50000000000000,
            'website' => 'https://vinhomes.vn',
            'phone' => '+84 24 3974 9999',
            'email' => 'info@vinhomes.vn',
            'address' => 'Tòa nhà Vinhomes, 458 Minh Khai, Quận Hai Bà Trưng, Hà Nội',
            'contact_person' => 'Nguyễn Văn A',
            'areas' => array('ba-dinh', 'hoan-kiem', 'hai-ba-trung'),
            'sectors' => array('residential', 'commercial', 'mixed-use'),
            'size' => 'enterprise'
        ),
        array(
            'title' => 'Tập đoàn Bất động sản Novaland',
            'content' => 'Novaland là tập đoàn bất động sản lớn với nhiều dự án đa dạng từ nhà ở đến thương mại, tập trung vào phát triển bền vững và chất lượng cao.',
            'established_year' => 1992,
            'employees' => 3000,
            'capital' => 30000000000000,
            'website' => 'https://novaland.com.vn',
            'phone' => '+84 28 3822 9999',
            'email' => 'contact@novaland.com.vn',
            'address' => 'Tòa nhà Novaland, 65 Nguyễn Du, Quận 1, TP. Hồ Chí Minh',
            'contact_person' => 'Trần Thị B',
            'areas' => array('dong-da', 'tay-ho'),
            'sectors' => array('residential', 'commercial'),
            'size' => 'enterprise'
        ),
        array(
            'title' => 'Công ty CP Đầu tư Xây dựng Hòa Bình',
            'content' => 'Hòa Bình Group chuyên về xây dựng và phát triển các dự án bất động sản với tiêu chuẩn quốc tế, đặc biệt là các dự án cao cấp.',
            'established_year' => 1987,
            'employees' => 2500,
            'capital' => 20000000000000,
            'website' => 'https://hoabinhgroup.com',
            'phone' => '+84 24 3822 8888',
            'email' => 'info@hoabinhgroup.com',
            'address' => 'Tòa nhà Hòa Bình, 123 Láng Hạ, Quận Đống Đa, Hà Nội',
            'contact_person' => 'Lê Văn C',
            'areas' => array('cau-giay', 'thanh-xuan'),
            'sectors' => array('residential', 'infrastructure'),
            'size' => 'large'
        ),
        array(
            'title' => 'Công ty TNHH Phát triển Đô thị Sài Gòn',
            'content' => 'Chuyên phát triển các dự án đô thị thông minh và bền vững, tập trung vào việc tạo ra không gian sống hiện đại cho cộng đồng.',
            'established_year' => 2000,
            'employees' => 800,
            'capital' => 8000000000000,
            'website' => 'https://saigonurban.com',
            'phone' => '+84 28 3822 7777',
            'email' => 'contact@saigonurban.com',
            'address' => 'Tòa nhà Sài Gòn Urban, 456 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh',
            'contact_person' => 'Phạm Thị D',
            'areas' => array('hoang-mai', 'long-bien'),
            'sectors' => array('urban-planning', 'mixed-use'),
            'size' => 'large'
        ),
        array(
            'title' => 'Công ty CP Bất động sản Đông Á',
            'content' => 'Đông Á Real Estate chuyên về phát triển các dự án nhà ở giá rẻ và trung bình, đáp ứng nhu cầu nhà ở của đại đa số người dân.',
            'established_year' => 2005,
            'employees' => 600,
            'capital' => 5000000000000,
            'website' => 'https://dongareal.com',
            'phone' => '+84 24 3822 6666',
            'email' => 'info@dongareal.com',
            'address' => 'Tòa nhà Đông Á, 789 Giải Phóng, Quận Hai Bà Trưng, Hà Nội',
            'contact_person' => 'Vũ Văn E',
            'areas' => array('nam-tu-liem', 'bac-tu-liem'),
            'sectors' => array('residential'),
            'size' => 'medium'
        ),
        array(
            'title' => 'Công ty TNHH Phát triển Bất động sản Thăng Long',
            'content' => 'Thăng Long Development tập trung vào phát triển các dự án thương mại và văn phòng tại các vị trí chiến lược trong thành phố.',
            'established_year' => 2010,
            'employees' => 400,
            'capital' => 3000000000000,
            'website' => 'https://thanglongdev.com',
            'phone' => '+84 24 3822 5555',
            'email' => 'contact@thanglongdev.com',
            'address' => 'Tòa nhà Thăng Long, 321 Trần Duy Hưng, Quận Cầu Giấy, Hà Nội',
            'contact_person' => 'Hoàng Thị F',
            'areas' => array('ba-dinh', 'hoan-kiem'),
            'sectors' => array('commercial', 'infrastructure'),
            'size' => 'medium'
        ),
        array(
            'title' => 'Công ty CP Đầu tư Bất động sản Việt Nam',
            'content' => 'Chuyên về tư vấn và đầu tư bất động sản, cung cấp các dịch vụ toàn diện từ nghiên cứu thị trường đến quản lý dự án.',
            'established_year' => 2015,
            'employees' => 200,
            'capital' => 2000000000000,
            'website' => 'https://vnrealestate.com',
            'phone' => '+84 24 3822 4444',
            'email' => 'info@vnrealestate.com',
            'address' => 'Tòa nhà VN Real Estate, 654 Lê Văn Lương, Quận Thanh Xuân, Hà Nội',
            'contact_person' => 'Đặng Văn G',
            'areas' => array('dong-da', 'tay-ho'),
            'sectors' => array('consulting', 'renovation'),
            'size' => 'medium'
        ),
        array(
            'title' => 'Công ty TNHH Phát triển Khu công nghiệp Hà Nội',
            'content' => 'Chuyên phát triển các khu công nghiệp và khu chế xuất, tạo ra môi trường kinh doanh thuận lợi cho các doanh nghiệp.',
            'established_year' => 2008,
            'employees' => 300,
            'capital' => 4000000000000,
            'website' => 'https://hanoipark.com',
            'phone' => '+84 24 3822 3333',
            'email' => 'contact@hanoipark.com',
            'address' => 'Khu công nghiệp Hà Nội, Xã Đông Anh, Huyện Đông Anh, Hà Nội',
            'contact_person' => 'Bùi Thị H',
            'areas' => array('dong-anh', 'gia-lam'),
            'sectors' => array('industrial', 'infrastructure'),
            'size' => 'medium'
        ),
        array(
            'title' => 'Công ty CP Bất động sản Sài Gòn Land',
            'content' => 'Sài Gòn Land chuyên về phát triển các dự án nhà ở cao cấp và biệt thự, mang đến không gian sống sang trọng cho khách hàng.',
            'established_year' => 2012,
            'employees' => 150,
            'capital' => 1500000000000,
            'website' => 'https://saigonland.com',
            'phone' => '+84 28 3822 2222',
            'email' => 'info@saigonland.com',
            'address' => 'Tòa nhà Sài Gòn Land, 987 Nguyễn Văn Cừ, Quận 5, TP. Hồ Chí Minh',
            'contact_person' => 'Ngô Văn I',
            'areas' => array('hoang-mai', 'long-bien'),
            'sectors' => array('residential'),
            'size' => 'small'
        ),
        array(
            'title' => 'Công ty TNHH Tư vấn Bất động sản Việt Nam',
            'content' => 'Chuyên cung cấp các dịch vụ tư vấn bất động sản chuyên nghiệp, từ đánh giá thị trường đến quản lý đầu tư.',
            'established_year' => 2018,
            'employees' => 80,
            'capital' => 800000000000,
            'website' => 'https://vnconsulting.com',
            'phone' => '+84 24 3822 1111',
            'email' => 'contact@vnconsulting.com',
            'address' => 'Tòa nhà VN Consulting, 147 Kim Mã, Quận Ba Đình, Hà Nội',
            'contact_person' => 'Lý Thị K',
            'areas' => array('ba-dinh', 'hoan-kiem'),
            'sectors' => array('consulting'),
            'size' => 'small'
        )
    );
    
    $created_count = 0;
    
    foreach ($sample_companies as $company_data) {
        // 投稿を作成
        $post_id = wp_insert_post(array(
            'post_title' => $company_data['title'],
            'post_content' => $company_data['content'],
            'post_status' => 'publish',
            'post_type' => 'company',
            'meta_input' => array(
                '_company_established_year' => $company_data['established_year'],
                '_company_employees' => $company_data['employees'],
                '_company_capital' => $company_data['capital'],
                '_company_website' => $company_data['website'],
                '_company_phone' => $company_data['phone'],
                '_company_email' => $company_data['email'],
                '_company_address' => $company_data['address'],
                '_company_contact_person' => $company_data['contact_person'],
                '_sample_data' => 'yes' // サンプルデータのマーク
            )
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            // エリアタクソノミーを設定
            if (!empty($company_data['areas'])) {
                $area_terms = array();
                foreach ($company_data['areas'] as $area_slug) {
                    $term = get_term_by('slug', $area_slug, 'area');
                    if ($term) {
                        $area_terms[] = $term->term_id;
                    }
                }
                if (!empty($area_terms)) {
                    wp_set_post_terms($post_id, $area_terms, 'area');
                }
            }
            
            // 事業分野タクソノミーを設定
            if (!empty($company_data['sectors'])) {
                $sector_terms = array();
                foreach ($company_data['sectors'] as $sector_slug) {
                    $term = get_term_by('slug', $sector_slug, 'company_sector');
                    if ($term) {
                        $sector_terms[] = $term->term_id;
                    }
                }
                if (!empty($sector_terms)) {
                    wp_set_post_terms($post_id, $sector_terms, 'company_sector');
                }
            }
            
            // 会社規模タクソノミーを設定
            if (!empty($company_data['size'])) {
                $size_term = get_term_by('slug', $company_data['size'], 'company_size');
                if ($size_term) {
                    wp_set_post_terms($post_id, array($size_term->term_id), 'company_size');
                }
            }
            
            $created_count++;
        }
    }
    
    return $created_count;
}

function clear_sample_companies() {
    $deleted_count = 0;
    
    $sample_companies = get_posts(array(
        'post_type' => 'company',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_sample_data',
                'value' => 'yes',
                'compare' => '='
            )
        )
    ));
    
    foreach ($sample_companies as $company) {
        if (wp_delete_post($company->ID, true)) {
            $deleted_count++;
        }
    }
    
    return $deleted_count;
}

// 管理画面用のスクリプトとスタイルを追加
function add_admin_scripts($hook) {
    global $post_type;
    
    // 不動産投稿画面でのみスクリプトを読み込み
    if (($hook == 'post.php' || $hook == 'post-new.php') && $post_type == 'property') {
        wp_enqueue_script('jquery');
        
        // インラインJavaScript
        $script = "
        jQuery(document).ready(function($) {
            var searchTimeout;
            var isSearching = false;
            
            // プロジェクト検索機能
            $('#property_project_search').on('input', function() {
                var searchTerm = $(this).val();
                var resultsContainer = $('#project_search_results');
                
                // 既に選択されている場合は検索しない
                if ($('#property_project_id').val()) {
                    return;
                }
                
                clearTimeout(searchTimeout);
                
                if (searchTerm.length < 2) {
                    resultsContainer.hide();
                    return;
                }
                
                searchTimeout = setTimeout(function() {
                    searchProjects(searchTerm);
                }, 300);
            });
            
            // プロジェクト検索関数
            function searchProjects(searchTerm) {
                if (isSearching) return;
                isSearching = true;
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'search_projects',
                        search_term: searchTerm,
                        nonce: '" . wp_create_nonce('search_projects_nonce') . "'
                    },
                    success: function(response) {
                        if (response.success) {
                            displaySearchResults(response.data);
                        } else {
                            $('#project_search_results').html('<div style=\"padding: 10px; color: #666;\">プロジェクトが見つかりませんでした。</div>').show();
                        }
                    },
                    error: function() {
                        $('#project_search_results').html('<div style=\"padding: 10px; color: #d63638;\">検索中にエラーが発生しました。</div>').show();
                    },
                    complete: function() {
                        isSearching = false;
                    }
                });
            }
            
            // 検索結果表示
            function displaySearchResults(projects) {
                var resultsContainer = $('#project_search_results');
                var html = '';
                
                if (projects.length === 0) {
                    html = '<div style=\"padding: 10px; color: #666;\">プロジェクトが見つかりませんでした。</div>';
                } else {
                    projects.forEach(function(project) {
                        html += '<div class=\"project-result-item\" data-id=\"' + project.id + '\" data-title=\"' + project.title + '\" style=\"padding: 10px; cursor: pointer; border-bottom: 1px solid #eee;\" onmouseover=\"this.style.backgroundColor=\\\"#f0f6fc\\\"\" onmouseout=\"this.style.backgroundColor=\\\"white\\\"\">';
                        html += '<strong>' + project.title + '</strong>';
                        if (project.excerpt) {
                            html += '<br><small style=\"color: #666;\">' + project.excerpt + '</small>';
                        }
                        html += '</div>';
                    });
                }
                
                resultsContainer.html(html).show();
            }
            
            // プロジェクト選択
            $(document).on('click', '.project-result-item', function() {
                var projectId = $(this).data('id');
                var projectTitle = $(this).data('title');
                
                $('#property_project_id').val(projectId);
                $('#property_project_search').val(projectTitle);
                $('#project_search_results').hide();
                
                // 選択情報を表示
                var selectedInfo = '<div id=\"selected_project_info\" style=\"margin-top: 10px; padding: 10px; background: #f0f6fc; border: 1px solid #0073aa; border-radius: 4px;\">';
                selectedInfo += '<strong>選択中のプロジェクト:</strong> ' + projectTitle;
                selectedInfo += ' <button type=\"button\" id=\"clear_project_selection\" style=\"margin-left: 10px; color: #d63638; background: none; border: none; cursor: pointer; text-decoration: underline;\">選択をクリア</button>';
                selectedInfo += '</div>';
                
                $('.project-search-container').after(selectedInfo);
            });
            
            // 選択クリア
            $(document).on('click', '#clear_project_selection', function() {
                $('#property_project_id').val('');
                $('#property_project_search').val('');
                $('#selected_project_info').remove();
            });
            
            // 検索ボックス外クリックで結果を非表示
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.project-search-container').length) {
                    $('#project_search_results').hide();
                }
            });
            
            // 検索ボックスフォーカス時の処理
            $('#property_project_search').on('focus', function() {
                if ($(this).val().length >= 2 && !$('#property_project_id').val()) {
                    searchProjects($(this).val());
                }
            });
            
            // 開発会社検索機能
            $('#property_company_search').on('input', function() {
                var searchTerm = $(this).val();
                var resultsContainer = $('#company_search_results');
                
                // 既に選択されている場合は検索しない
                if ($('#property_company_id').val()) {
                    return;
                }
                
                clearTimeout(searchTimeout);
                
                if (searchTerm.length < 2) {
                    resultsContainer.hide();
                    return;
                }
                
                searchTimeout = setTimeout(function() {
                    searchCompanies(searchTerm);
                }, 300);
            });
            
            // 開発会社検索関数
            function searchCompanies(searchTerm) {
                if (isSearching) return;
                isSearching = true;
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'search_companies',
                        search_term: searchTerm,
                        nonce: '" . wp_create_nonce('search_companies_nonce') . "'
                    },
                    success: function(response) {
                        if (response.success) {
                            displayCompanySearchResults(response.data);
                        } else {
                            $('#company_search_results').html('<div style=\"padding: 10px; color: #666;\">開発会社が見つかりませんでした。</div>').show();
                        }
                    },
                    error: function() {
                        $('#company_search_results').html('<div style=\"padding: 10px; color: #d63638;\">検索中にエラーが発生しました。</div>').show();
                    },
                    complete: function() {
                        isSearching = false;
                    }
                });
            }
            
            // 開発会社検索結果表示
            function displayCompanySearchResults(companies) {
                var resultsContainer = $('#company_search_results');
                var html = '';
                
                if (companies.length === 0) {
                    html = '<div style=\"padding: 10px; color: #666;\">開発会社が見つかりませんでした。</div>';
                } else {
                    companies.forEach(function(company) {
                        html += '<div class=\"company-result-item\" data-id=\"' + company.id + '\" data-title=\"' + company.title + '\" style=\"padding: 10px; cursor: pointer; border-bottom: 1px solid #eee;\" onmouseover=\"this.style.backgroundColor=\\\"#f0f6fc\\\"\" onmouseout=\"this.style.backgroundColor=\\\"white\\\"\">';
                        html += '<strong>' + company.title + '</strong>';
                        if (company.excerpt) {
                            html += '<br><small style=\"color: #666;\">' + company.excerpt + '</small>';
                        }
                        html += '</div>';
                    });
                }
                
                resultsContainer.html(html).show();
            }
            
            // 開発会社選択
            $(document).on('click', '.company-result-item', function() {
                var companyId = $(this).data('id');
                var companyTitle = $(this).data('title');
                
                $('#property_company_id').val(companyId);
                $('#property_company_search').val(companyTitle);
                $('#company_search_results').hide();
                
                // 選択情報を表示
                var selectedInfo = '<div id=\"selected_company_info\" style=\"margin-top: 10px; padding: 10px; background: #f0f6fc; border: 1px solid #0073aa; border-radius: 4px;\">';
                selectedInfo += '<strong>選択中の開発会社:</strong> ' + companyTitle;
                selectedInfo += ' <button type=\"button\" id=\"clear_company_selection\" style=\"margin-left: 10px; color: #d63638; background: none; border: none; cursor: pointer; text-decoration: underline;\">選択をクリア</button>';
                selectedInfo += '</div>';
                
                $('.company-search-container').after(selectedInfo);
            });
            
            // 開発会社選択クリア
            $(document).on('click', '#clear_company_selection', function() {
                $('#property_company_id').val('');
                $('#property_company_search').val('');
                $('#selected_company_info').remove();
            });
            
            // 開発会社検索ボックス外クリックで結果を非表示
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.company-search-container').length) {
                    $('#company_search_results').hide();
                }
            });
            
            // 開発会社検索ボックスフォーカス時の処理
            $('#property_company_search').on('focus', function() {
                if ($(this).val().length >= 2 && !$('#property_company_id').val()) {
                    searchCompanies($(this).val());
                }
            });
        });
        ";
        
        wp_add_inline_script('jquery', $script);
    }
}
add_action('admin_enqueue_scripts', 'add_admin_scripts');

// AJAX処理：プロジェクト検索
function handle_project_search() {
    // ノンス検証
    if (!wp_verify_nonce($_POST['nonce'], 'search_projects_nonce')) {
        wp_die('セキュリティエラー');
    }
    
    $search_term = sanitize_text_field($_POST['search_term']);
    
    if (strlen($search_term) < 2) {
        wp_send_json_error('検索語が短すぎます');
        return;
    }
    
    $projects = get_posts(array(
        'post_type' => 'project',
        'posts_per_page' => 10,
        'post_status' => 'publish',
        's' => $search_term,
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    
    $results = array();
    foreach ($projects as $project) {
        $results[] = array(
            'id' => $project->ID,
            'title' => $project->post_title,
            'excerpt' => wp_trim_words($project->post_excerpt, 20, '...')
        );
    }
    
    wp_send_json_success($results);
}
add_action('wp_ajax_search_projects', 'handle_project_search');

// AJAX処理：開発会社検索
function handle_company_search() {
    // ノンス検証
    if (!wp_verify_nonce($_POST['nonce'], 'search_companies_nonce')) {
        wp_die('セキュリティエラー');
    }
    
    $search_term = sanitize_text_field($_POST['search_term']);
    
    if (strlen($search_term) < 2) {
        wp_send_json_error('検索語が短すぎます');
        return;
    }
    
    $companies = get_posts(array(
        'post_type' => 'company',
        'posts_per_page' => 10,
        'post_status' => 'publish',
        's' => $search_term,
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    
    $results = array();
    foreach ($companies as $company) {
        $results[] = array(
            'id' => $company->ID,
            'title' => $company->post_title,
            'excerpt' => wp_trim_words($company->post_excerpt, 20, '...')
        );
    }
    
    wp_send_json_success($results);
}
add_action('wp_ajax_search_companies', 'handle_company_search');

// フロントエンドでの管理バーCSSを無効化
function remove_admin_bar_styles() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_admin_bar_styles');

// 不動産のカスタムフィールド追加
function add_property_meta_boxes() {
    add_meta_box(
        'property_area_select',
        'エリア',
        'property_area_select_callback',
        'property',
        'normal',
        'high'
    );
    
    add_meta_box(
        'property_layout_type',
        '間取りタイプ',
        'property_layout_type_callback',
        'property',
        'normal',
        'high'
    );
    
    add_meta_box(
        'property_features',
        '物件の特徴・設備',
        'property_features_callback',
        'property',
        'normal',
        'high'
    );
    
    add_meta_box(
        'property_condition',
        '物件状態',
        'property_condition_callback',
        'property',
        'normal',
        'high'
    );
    
    add_meta_box(
        'property_type_select',
        '物件タイプ',
        'property_type_select_callback',
        'property',
        'normal',
        'high'
    );
    
    
    add_meta_box(
        'property_gallery',
        'ギャラリー画像',
        'property_gallery_callback',
        'property',
        'normal',
        'high'
    );
    
    add_meta_box(
        'property_video',
        'YouTube動画',
        'property_video_callback',
        'property',
        'normal',
        'high'
    );
    
    add_meta_box(
        'property_pricing',
        '物件価格・費用',
        'property_pricing_callback',
        'property',
        'normal',
        'high'
    );
    
    add_meta_box(
        'property_project',
        '関連プロジェクト',
        'property_project_callback',
        'property',
        'normal',
        'high'
    );
    
    add_meta_box(
        'property_company',
        '関連開発会社',
        'property_company_callback',
        'property',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_property_meta_boxes');

// プロジェクト用のメタボックス追加
function add_project_meta_boxes() {
    add_meta_box(
        'project_area',
        'エリア',
        'project_area_callback',
        'project',
        'normal',
        'high'
    );
    
    add_meta_box(
        'project_features',
        'プロジェクトの特徴・設備',
        'project_features_callback',
        'project',
        'normal',
        'high'
    );
    
    add_meta_box(
        'project_details',
        'プロジェクト詳細情報',
        'project_details_callback',
        'project',
        'normal',
        'high'
    );
    
    add_meta_box(
        'project_images',
        'プロジェクト画像',
        'project_images_callback',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_project_meta_boxes');

// 開発会社用のメタボックス追加
function add_company_meta_boxes() {
    add_meta_box(
        'company_area',
        'エリア',
        'company_area_callback',
        'company',
        'normal',
        'high'
    );
    
    add_meta_box(
        'company_sector',
        '事業分野',
        'company_sector_callback',
        'company',
        'normal',
        'high'
    );
    
    add_meta_box(
        'company_size',
        '会社規模',
        'company_size_callback',
        'company',
        'normal',
        'high'
    );
    
    add_meta_box(
        'company_details',
        '会社詳細情報',
        'company_details_callback',
        'company',
        'normal',
        'high'
    );
    
    add_meta_box(
        'company_contact',
        '連絡先情報',
        'company_contact_callback',
        'company',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_company_meta_boxes');

// 間取りタイプのコールバック関数
function property_layout_type_callback($post) {
    // 間取りタイプタクソノミーのデフォルトタームを作成
    create_default_layout_type_select_terms();
    
    $selected_terms = wp_get_post_terms($post->ID, 'property_tag', array('fields' => 'ids'));
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label for="property_layout_type">間取りタイプ</label></th>';
    echo '<td>';
    
    // 間取りタイプの選択肢（英語表記）
    $layout_type_options = array(
        'studio' => 'Studio',
        '1-room' => '1 Room',
        '2-room' => '2 Room',
        '3-room' => '3 Room',
        '4-room' => '4 Room',
        '5-room-plus' => '5 Room~'
    );
    
    echo '<select id="property_layout_type" name="property_layout_type[]" multiple style="width: 100%; height: 120px;">';
    echo '<option value="">選択してください</option>';
    
    foreach ($layout_type_options as $slug => $label) {
        // タームが存在しない場合は作成
        $term = get_term_by('slug', $slug, 'property_tag');
        if (!$term) {
            $term_result = wp_insert_term($label, 'property_tag', array('slug' => $slug));
            if (!is_wp_error($term_result)) {
                $term = get_term($term_result['term_id'], 'property_tag');
            }
        }
        
        if ($term) {
            $selected = in_array($term->term_id, $selected_terms) ? 'selected' : '';
            echo '<option value="' . esc_attr($term->term_id) . '" ' . $selected . '>' . esc_html($label) . '</option>';
        }
    }
    
    echo '</select>';
    echo '<p class="description">複数選択可能です。Ctrlキー（MacではCommandキー）を押しながらクリックしてください。</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// プロジェクトのエリアコールバック関数
function project_area_callback($post) {
    // エリアタクソノミーのデフォルトタームを作成
    create_default_area_terms();
    
    $selected_terms = wp_get_post_terms($post->ID, 'area', array('fields' => 'ids'));
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label for="project_area">エリア</label></th>';
    echo '<td>';
    
    // ハノイ市内エリア
    $hanoi_city_areas = array(
        'ba-dinh' => 'Ba Đình',
        'hoan-kiem' => 'Hoàn Kiếm',
        'hai-ba-trung' => 'Hai Bà Trưng',
        'dong-da' => 'Đống Đa',
        'tay-ho' => 'Tây Hồ',
        'cau-giay' => 'Cầu Giấy',
        'thanh-xuan' => 'Thanh Xuân',
        'hoang-mai' => 'Hoàng Mai',
        'long-bien' => 'Long Biên',
        'nam-tu-liem' => 'Nam Từ Liêm',
        'bac-tu-liem' => 'Bắc Từ Liêm',
        'ha-dong' => 'Hà Đông'
    );
    
    // ハノイ郊外エリア
    $hanoi_suburbs_areas = array(
        'son-tay' => 'Sơn Tây',
        'dong-anh' => 'Đông Anh',
        'gia-lam' => 'Gia Lâm',
        'soc-son' => 'Sóc Sơn',
        'thanh-tri' => 'Thanh Trì',
        'me-linh' => 'Mê Linh',
        'hoai-duc' => 'Hoài Đức',
        'thuong-tin' => 'Thường Tín',
        'thanh-oai' => 'Thanh Oai',
        'phu-xuyen' => 'Phú Xuyên',
        'quoc-oai' => 'Quốc Oai',
        'chuong-my' => 'Chương Mỹ',
        'thach-that' => 'Thạch Thất',
        'dan-phuong' => 'Đan Phượng',
        'ung-hoa' => 'Ứng Hòa',
        'my-duc' => 'Mỹ Đức',
        'ba-vi' => 'Ba Vì'
    );
    
    echo '<select id="project_area" name="project_area[]" multiple style="width: 100%; height: 150px;">';
    echo '<option value="">選択してください</option>';
    
    // ハノイ市内グループ
    echo '<optgroup label="ハノイ市内">';
    foreach ($hanoi_city_areas as $slug => $label) {
        $term = get_term_by('slug', $slug, 'area');
        if (!$term) {
            $term_result = wp_insert_term($label, 'area', array('slug' => $slug));
            if (!is_wp_error($term_result)) {
                $term = get_term($term_result['term_id'], 'area');
            }
        }
        
        if ($term) {
            $selected = in_array($term->term_id, $selected_terms) ? 'selected' : '';
            echo '<option value="' . esc_attr($term->term_id) . '" ' . $selected . '>' . esc_html($label) . '</option>';
        }
    }
    echo '</optgroup>';
    
    // ハノイ郊外グループ
    echo '<optgroup label="ハノイ郊外">';
    foreach ($hanoi_suburbs_areas as $slug => $label) {
        $term = get_term_by('slug', $slug, 'area');
        if (!$term) {
            $term_result = wp_insert_term($label, 'area', array('slug' => $slug));
            if (!is_wp_error($term_result)) {
                $term = get_term($term_result['term_id'], 'area');
            }
        }
        
        if ($term) {
            $selected = in_array($term->term_id, $selected_terms) ? 'selected' : '';
            echo '<option value="' . esc_attr($term->term_id) . '" ' . $selected . '>' . esc_html($label) . '</option>';
        }
    }
    echo '</optgroup>';
    
    echo '</select>';
    echo '<p class="description">複数選択可能です。Ctrlキー（MacではCommandキー）を押しながらクリックしてください。</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// プロジェクトの特徴・設備のコールバック関数
function project_features_callback($post) {
    // プロジェクトの特徴・設備タクソノミーのデフォルトタームを作成
    create_default_project_features_select_terms();
    
    $selected_terms = wp_get_post_terms($post->ID, 'project_features', array('fields' => 'ids'));
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label>プロジェクトの特徴・設備</label></th>';
    echo '<td>';
    
    // 設備カテゴリー
    $facilities = array(
        'air-conditioning' => '空調システム',
        'fire-safety' => '防火システム',
        'football-field' => 'サッカー場',
        'basketball-court' => 'バスケットボールコート',
        'tennis-court' => 'テニスコート',
        'recreation-room' => 'レクリエーションルーム',
        'concierge' => 'コンシェルジュサービス',
        'security' => '警備員',
        'underground-parking' => '地下自動車駐車場',
        'multi-level-parking' => '立体自動車駐車場',
        'guest-parking' => 'ゲスト駐車場',
        'motorcycle-parking' => 'バイク駐車場',
        'heated-pool' => '温水プール',
        'outdoor-pool' => '屋外プール',
        'gym' => 'ジム',
        'bbq-facilities' => 'BBQ設備'
    );
    
    // 施設カテゴリー
    $amenities = array(
        'shopping-mall' => 'ショッピングモール',
        'supermarket' => 'スーパーマーケット',
        'convenience-store' => 'コンビニ',
        'park' => '公園',
        'restaurant' => 'レストラン',
        'hospital' => '病院',
        'school' => '学校',
        'kindergarten' => '幼稚園・保育園',
        'bus-stop' => 'バス停',
        'station' => '駅'
    );
    
    echo '<div style="display: flex; gap: 40px;">';
    
    // 設備セクション
    echo '<div style="flex: 1;">';
    echo '<h3 style="margin-top: 0; color: #333; border-bottom: 2px solid #0073aa; padding-bottom: 5px;">設備</h3>';
    echo '<div style="display: grid; grid-template-columns: 1fr; gap: 8px;">';
    
    foreach ($facilities as $slug => $label) {
        $term = get_term_by('slug', $slug, 'project_features');
        if (!$term) {
            $term_result = wp_insert_term($label, 'project_features', array('slug' => $slug));
            if (!is_wp_error($term_result)) {
                $term = get_term($term_result['term_id'], 'project_features');
            }
        }
        
        if ($term) {
            $checked = in_array($term->term_id, $selected_terms) ? 'checked' : '';
            echo '<label style="display: flex; align-items: center; padding: 5px 0; cursor: pointer;">';
            echo '<input type="checkbox" name="project_features[]" value="' . esc_attr($term->term_id) . '" ' . $checked . ' style="margin-right: 8px;" />';
            echo '<span>' . esc_html($label) . '</span>';
            echo '</label>';
        }
    }
    
    echo '</div>';
    echo '</div>';
    
    // 施設セクション
    echo '<div style="flex: 1;">';
    echo '<h3 style="margin-top: 0; color: #333; border-bottom: 2px solid #0073aa; padding-bottom: 5px;">施設</h3>';
    echo '<div style="display: grid; grid-template-columns: 1fr; gap: 8px;">';
    
    foreach ($amenities as $slug => $label) {
        $term = get_term_by('slug', $slug, 'project_features');
        if (!$term) {
            $term_result = wp_insert_term($label, 'project_features', array('slug' => $slug));
            if (!is_wp_error($term_result)) {
                $term = get_term($term_result['term_id'], 'project_features');
            }
        }
        
        if ($term) {
            $checked = in_array($term->term_id, $selected_terms) ? 'checked' : '';
            echo '<label style="display: flex; align-items: center; padding: 5px 0; cursor: pointer;">';
            echo '<input type="checkbox" name="project_features[]" value="' . esc_attr($term->term_id) . '" ' . $checked . ' style="margin-right: 8px;" />';
            echo '<span>' . esc_html($label) . '</span>';
            echo '</label>';
        }
    }
    
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
    echo '<p class="description">該当する設備・施設にチェックを入れてください。複数選択可能です。</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// プロジェクト詳細情報のコールバック関数
function project_details_callback($post) {
    $total_units = get_post_meta($post->ID, '_project_total_units', true);
    $land_area = get_post_meta($post->ID, '_project_land_area', true);
    $location = get_post_meta($post->ID, '_project_location', true);
    
    echo '<table class="form-table">';
    
    // 総戸数
    echo '<tr>';
    echo '<th scope="row"><label for="project_total_units">総戸数</label></th>';
    echo '<td>';
    echo '<input type="number" id="project_total_units" name="project_total_units" value="' . esc_attr($total_units) . '" style="width: 200px;" />';
    echo '<span style="margin-left: 10px;">戸</span>';
    echo '<p class="description">プロジェクト全体の総戸数を入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    // 耕作面積
    echo '<tr>';
    echo '<th scope="row"><label for="project_land_area">耕作面積</label></th>';
    echo '<td>';
    echo '<input type="number" id="project_land_area" name="project_land_area" value="' . esc_attr($land_area) . '" style="width: 200px;" step="0.01" />';
    echo '<span style="margin-left: 10px;">m²</span>';
    echo '<p class="description">プロジェクトの耕作面積を平方メートルで入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    // 所在地
    echo '<tr>';
    echo '<th scope="row"><label for="project_location">所在地</label></th>';
    echo '<td>';
    echo '<textarea id="project_location" name="project_location" rows="3" style="width: 100%;">' . esc_textarea($location) . '</textarea>';
    echo '<p class="description">プロジェクトの詳細な所在地を入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
}

// プロジェクト画像のコールバック関数
function project_images_callback($post) {
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label>プロジェクト画像</label></th>';
    echo '<td>';
    
    // 画像カテゴリー
    $image_categories = array(
        'plan' => array(
            'title' => 'プロジェクト計画図',
            'fields' => array(
                'project_plan_1' => 'プロジェクト計画図1',
                'project_plan_2' => 'プロジェクト計画図2',
                'project_plan_3' => 'プロジェクト計画図3',
                'project_plan_4' => 'プロジェクト計画図4',
                'project_plan_5' => 'プロジェクト計画図5'
            )
        ),
        'facility' => array(
            'title' => 'プロジェクト施設',
            'fields' => array(
                'project_facility_1' => 'プロジェクト施設1',
                'project_facility_2' => 'プロジェクト施設2',
                'project_facility_3' => 'プロジェクト施設3',
                'project_facility_4' => 'プロジェクト施設4',
                'project_facility_5' => 'プロジェクト施設5'
            )
        ),
        'property' => array(
            'title' => 'プロジェクト物件',
            'fields' => array(
                'project_property_1' => 'プロジェクト物件1',
                'project_property_2' => 'プロジェクト物件2',
                'project_property_3' => 'プロジェクト物件3',
                'project_property_4' => 'プロジェクト物件4',
                'project_property_5' => 'プロジェクト物件5'
            )
        )
    );
    
    foreach ($image_categories as $category_key => $category) {
        echo '<div style="margin-bottom: 30px;">';
        echo '<h3 style="margin: 0 0 15px 0; color: #333; border-bottom: 2px solid #0073aa; padding-bottom: 5px;">' . esc_html($category['title']) . '</h3>';
        echo '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">';
        
        foreach ($category['fields'] as $field_key => $field_label) {
            $image_id = get_post_meta($post->ID, '_' . $field_key, true);
            $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
            
            echo '<div class="project-image-item" style="position: relative; border: 2px solid #ddd; border-radius: 8px; padding: 15px; text-align: center; min-height: 180px; background: #f9f9f9; display: flex; flex-direction: column; align-items: center; justify-content: center;">';
            echo '<input type="hidden" name="' . $field_key . '" value="' . esc_attr($image_id) . '" class="project-image-id">';
            
            echo '<h4 style="margin: 0 0 10px 0; color: #333; font-size: 12px;">' . esc_html($field_label) . '</h4>';
            
            if ($image_url) {
                echo '<img src="' . esc_url($image_url) . '" style="max-width: 100%; max-height: 80px; margin-bottom: 10px; border-radius: 4px;" />';
                echo '<button type="button" class="remove-project-image" style="position: absolute; top: 8px; right: 8px; background: #dc2626; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 14px; line-height: 1;">×</button>';
            } else {
                echo '<div style="color: #999; margin-bottom: 10px; font-size: 11px;">画像を追加</div>';
            }
            
            echo '<button type="button" class="upload-project-image" style="background: #0073aa; color: white; border: none; border-radius: 4px; padding: 6px 12px; cursor: pointer; font-size: 11px;">' . ($image_url ? '変更' : '追加') . '</button>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
    echo '<p class="description">各項目に画像を設定できます。必須ではありません。</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    
    // 画像アップロード用JavaScript
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var frame;
        
        $(".upload-project-image").on("click", function(e) {
            e.preventDefault();
            
            var button = $(this);
            var item = button.closest(".project-image-item");
            var imageIdInput = item.find(".project-image-id");
            var imageContainer = item.find("img").length ? item.find("img") : item.find("div");
            
            if (frame) {
                frame.open();
                return;
            }
            
            frame = wp.media({
                title: "画像を選択",
                button: {
                    text: "選択"
                },
                multiple: false
            });
            
            frame.on("select", function() {
                var attachment = frame.state().get("selection").first().toJSON();
                imageIdInput.val(attachment.id);
                
                if (imageContainer.is("div")) {
                    imageContainer.replaceWith("<img src=\"" + attachment.sizes.medium.url + "\" style=\"max-width: 100%; max-height: 80px; margin-bottom: 10px; border-radius: 4px;\" />");
                    // 削除ボタンを追加
                    $("<button type=\"button\" class=\"remove-project-image\" style=\"position: absolute; top: 8px; right: 8px; background: #dc2626; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 14px; line-height: 1;\">×</button>").insertAfter(imageContainer);
                } else {
                    imageContainer.attr("src", attachment.sizes.medium.url);
                }
                
                button.text("変更");
            });
            
            frame.open();
        });
        
        $(".remove-project-image").on("click", function(e) {
            e.preventDefault();
            
            var button = $(this);
            var item = button.closest(".project-image-item");
            var imageIdInput = item.find(".project-image-id");
            var uploadButton = item.find(".upload-project-image");
            
            imageIdInput.val("");
            item.find("img").replaceWith("<div style=\"color: #999; margin-bottom: 10px; font-size: 11px;\">画像を追加</div>");
            uploadButton.text("追加");
            button.remove();
        });
    });
    </script>
    <?php
}

// 物件の特徴・設備のコールバック関数
function property_features_callback($post) {
    // 物件の特徴・設備タクソノミーのデフォルトタームを作成
    create_default_property_features_terms();
    
    $selected_terms = wp_get_post_terms($post->ID, 'property_features', array('fields' => 'ids'));
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label>物件の特徴・設備</label></th>';
    echo '<td>';
    
    // 物件の特徴・設備の選択肢
    $feature_groups = array(
        'room' => array(
            'label' => '部屋',
            'features' => array(
                'fingerprint-key' => '指紋キー',
                'electronic-key' => '電子キー',
                'card-key' => 'カードキー',
                'renovated' => 'リノベーション済み',
                'concept-design' => 'コンセプトデザイン',
                'furnished' => '備え付け家具',
                'soundproof' => '防音部屋',
                'flooring' => 'フローリング',
                'carpet-floor' => '絨毯床',
                'floor-heating' => '床暖房',
                'walk-in-closet' => 'ウォークインクローゼット',
                'island-kitchen' => 'アイランドキッチン',
                'ih-kitchen' => 'IHキッチン',
                'water-purifier' => '浄水器',
                'double-window' => '二重窓',
                'security-window' => '防犯窓'
            )
        ),
        'bathroom' => array(
            'label' => 'トイレ・シャワールーム',
            'features' => array(
                'bathtub' => '浴槽あり',
                'sauna' => 'サウナ',
                'bathroom-dryer' => '浴室乾燥機'
            )
        ),
        'property' => array(
            'label' => '物件',
            'features' => array(
                'high-floor' => '高層階',
                'penthouse' => 'ペントハウス',
                'concierge-service' => 'コンシェルジュサービス',
                '24h-garbage' => '24時間ゴミ出し可能',
                'corner-room' => '角部屋',
                'pool-view' => '池が見える',
                'ocean-view' => '海が見える',
                'night-view' => '夜景が綺麗',
                'park-view' => '公園が見える'
            )
        )
    );
    
    foreach ($feature_groups as $group_key => $group_data) {
        echo '<div style="margin-bottom: 30px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">';
        echo '<h4 style="margin: 0 0 15px 0; color: #333; font-size: 16px; border-bottom: 2px solid #dc2626; padding-bottom: 5px;">' . esc_html($group_data['label']) . '</h4>';
        echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">';
        
        foreach ($group_data['features'] as $slug => $label) {
            // タームが存在しない場合は作成
            $term = get_term_by('slug', $slug, 'property_features');
            if (!$term) {
                $term_result = wp_insert_term($label, 'property_features', array('slug' => $slug));
                if (!is_wp_error($term_result)) {
                    $term = get_term($term_result['term_id'], 'property_features');
                }
            }
            
            if ($term) {
                $checked = in_array($term->term_id, $selected_terms) ? 'checked' : '';
                echo '<label style="display: flex; align-items: center; padding: 8px; border-radius: 3px; transition: background-color 0.2s;">';
                echo '<input type="checkbox" name="property_features[]" value="' . esc_attr($term->term_id) . '" ' . $checked . ' style="margin-right: 8px;">';
                echo '<span style="font-size: 14px;">' . esc_html($label) . '</span>';
                echo '</label>';
            }
        }
        
        echo '</div>';
        echo '</div>';
    }
    
    echo '<p class="description">該当する特徴・設備にチェックを入れてください。複数選択可能です。</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    
    // チェックボックスのスタイル
    echo '<style>
    .property-features label:hover {
        background-color: #f8f9fa;
    }
    .property-features input[type="checkbox"]:checked + span {
        font-weight: bold;
        color: #dc2626;
    }
    </style>';
}

// エリアタクソノミーのコールバック関数
function property_area_select_callback($post) {
    // エリアタクソノミーのデフォルトタームを作成
    create_default_area_terms();
    
    $selected_terms = wp_get_post_terms($post->ID, 'area', array('fields' => 'ids'));
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label for="property_area">エリア</label></th>';
    echo '<td>';
    
    // エリアの選択肢（ベトナム語表記）
    $area_options = array(
        'city' => array(
            'label' => 'ハノイ市内',
            'areas' => array(
                'ba-dinh' => 'Ba Đình',
                'hoan-kiem' => 'Hoàn Kiếm',
                'hai-ba-trung' => 'Hai Bà Trưng',
                'dong-da' => 'Đống Đa',
                'tay-ho' => 'Tây Hồ',
                'cau-giay' => 'Cầu Giấy',
                'thanh-xuan' => 'Thanh Xuân',
                'hoang-mai' => 'Hoàng Mai',
                'long-bien' => 'Long Biên',
                'nam-tu-liem' => 'Nam Từ Liêm',
                'bac-tu-liem' => 'Bắc Từ Liêm',
                'ha-dong' => 'Hà Đông'
            )
        ),
        'suburb' => array(
            'label' => 'ハノイ郊外',
            'areas' => array(
                'son-tay' => 'Sơn Tây',
                'dong-anh' => 'Đông Anh',
                'gia-lam' => 'Gia Lâm',
                'soc-son' => 'Sóc Sơn',
                'thanh-tri' => 'Thanh Trì',
                'me-linh' => 'Mê Linh',
                'hoai-duc' => 'Hoài Đức',
                'thuong-tin' => 'Thường Tín',
                'thanh-oai' => 'Thanh Oai',
                'phu-xuyen' => 'Phú Xuyên',
                'quoc-oai' => 'Quốc Oai',
                'chuong-my' => 'Chương Mỹ',
                'thach-that' => 'Thạch Thất',
                'dan-phuong' => 'Đan Phượng',
                'ung-hoa' => 'Ứng Hòa',
                'my-duc' => 'Mỹ Đức',
                'ba-vi' => 'Ba Vì'
            )
        )
    );
    
    echo '<select id="property_area" name="property_area[]" multiple style="width: 100%; height: 200px;">';
    echo '<option value="">選択してください</option>';
    
    foreach ($area_options as $group_key => $group_data) {
        echo '<optgroup label="' . esc_html($group_data['label']) . '">';
        
        foreach ($group_data['areas'] as $slug => $label) {
            // タームが存在しない場合は作成
            $term = get_term_by('slug', $slug, 'area');
            if (!$term) {
                $term_result = wp_insert_term($label, 'area', array('slug' => $slug));
                if (!is_wp_error($term_result)) {
                    $term = get_term($term_result['term_id'], 'area');
                }
            }
            
            if ($term) {
                $selected = in_array($term->term_id, $selected_terms) ? 'selected' : '';
                echo '<option value="' . esc_attr($term->term_id) . '" ' . $selected . '>' . esc_html($label) . '</option>';
            }
        }
        
        echo '</optgroup>';
    }
    
    echo '</select>';
    echo '<p class="description">複数選択可能です。Ctrlキー（MacではCommandキー）を押しながらクリックしてください。</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// 状態タクソノミーのコールバック関数
function property_condition_callback($post) {
    // 状態タクソノミーのデフォルトタームを作成
    create_default_condition_terms();
    
    $selected_terms = wp_get_post_terms($post->ID, 'property_condition', array('fields' => 'ids'));
    $selected_term_id = !empty($selected_terms) ? $selected_terms[0] : '';
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label>物件状態</label></th>';
    echo '<td>';
    
    // 状態の選択肢
    $condition_options = array(
        'new' => '新築',
        'used' => '中古',
        'planned' => '計画中'
    );
    
    foreach ($condition_options as $slug => $label) {
        // タームが存在しない場合は作成
        $term = get_term_by('slug', $slug, 'property_condition');
        if (!$term) {
            $term_result = wp_insert_term($label, 'property_condition', array('slug' => $slug));
            if (!is_wp_error($term_result)) {
                $term = get_term($term_result['term_id'], 'property_condition');
            }
        }
        
        if ($term) {
            $checked = ($selected_term_id == $term->term_id) ? 'checked' : '';
            echo '<label style="display: block; margin-bottom: 10px;">';
            echo '<input type="radio" name="property_condition" value="' . esc_attr($term->term_id) . '" ' . $checked . ' style="margin-right: 8px;">';
            echo esc_html($label);
            echo '</label>';
        }
    }
    
    echo '<p class="description">物件の状態を選択してください。</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// 物件タイプタクソノミーのコールバック関数
function property_type_select_callback($post) {
    // 物件タイプタクソノミーのデフォルトタームを作成
    create_default_property_type_terms();
    
    $selected_terms = wp_get_post_terms($post->ID, 'property_type', array('fields' => 'ids'));
    $selected_term_id = !empty($selected_terms) ? $selected_terms[0] : '';
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label>物件タイプ</label></th>';
    echo '<td>';
    
    // 物件タイプの選択肢
    $property_type_options = array(
        'apartment' => 'アパート',
        'service-apartment' => 'サービスアパート',
        'house' => '戸建て住宅',
        'villa' => 'ヴィラ',
        'land' => '土地'
    );
    
    foreach ($property_type_options as $slug => $label) {
        // タームが存在しない場合は作成
        $term = get_term_by('slug', $slug, 'property_type');
        if (!$term) {
            $term_result = wp_insert_term($label, 'property_type', array('slug' => $slug));
            if (!is_wp_error($term_result)) {
                $term = get_term($term_result['term_id'], 'property_type');
            }
        }
        
        if ($term) {
            $checked = ($selected_term_id == $term->term_id) ? 'checked' : '';
            echo '<label style="display: block; margin-bottom: 10px;">';
            echo '<input type="radio" name="property_type" value="' . esc_attr($term->term_id) . '" ' . $checked . ' style="margin-right: 8px;">';
            echo esc_html($label);
            echo '</label>';
        }
    }
    
    echo '<p class="description">物件のタイプを選択してください。</p>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// 価格帯タクソノミーのコールバック関数

// ギャラリー画像のコールバック関数
function property_gallery_callback($post) {
    // 固定の画像タイプとラベル
    $image_types = array(
        'main' => 'メイン写真',
        'exterior' => '建物外観',
        'view1' => '部屋からの景色1',
        'view2' => '部屋からの景色2',
        'balcony1' => 'ベランダ・バルコニー1',
        'balcony2' => 'ベランダ・バルコニー2',
        'living1' => 'リビング1',
        'living2' => 'リビング2',
        'living3' => 'リビング3',
        'entrance' => '玄関',
        'kitchen' => 'キッチン',
        'bedroom1' => '寝室1',
        'bedroom2' => '寝室2',
        'bedroom3' => '寝室3',
        'bedroom4' => '寝室4',
        'bedroom5' => '寝室5',
        'bedroom6' => '寝室6',
        'storage1' => '収納1',
        'storage2' => '収納2',
        'bathroom1' => 'シャワー・トイレ1',
        'bathroom2' => 'シャワー・トイレ2',
        'bathroom3' => 'シャワー・トイレ3',
        'facility1' => 'その他設備1',
        'facility2' => 'その他設備2',
        'facility3' => 'その他設備3',
        'facility4' => 'その他設備4',
        'facility5' => 'その他設備5'
    );
    
    echo '<div id="property-gallery-container">';
    echo '<p><strong>各項目に画像を設定できます。必須ではありません。</strong></p>';
    echo '<div id="gallery-images" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">';
    
    foreach ($image_types as $type_key => $type_label) {
        $image_id = get_post_meta($post->ID, '_property_gallery_' . $type_key, true);
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
        
        echo '<div class="gallery-item" style="position: relative; border: 2px solid #ddd; border-radius: 8px; padding: 20px; text-align: center; min-height: 250px; background: #f9f9f9; display: flex; flex-direction: column; align-items: center; justify-content: center;">';
        echo '<input type="hidden" name="property_gallery_' . $type_key . '" value="' . esc_attr($image_id) . '" class="gallery-image-id">';
        
        echo '<h4 style="margin: 0 0 15px 0; color: #333; font-size: 14px;">' . esc_html($type_label) . '</h4>';
        
        if ($image_url) {
            echo '<img src="' . esc_url($image_url) . '" style="max-width: 100%; max-height: 120px; margin-bottom: 15px; border-radius: 4px;" />';
            echo '<button type="button" class="remove-gallery-image" style="position: absolute; top: 10px; right: 10px; background: #dc2626; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; font-size: 16px; line-height: 1;">×</button>';
        } else {
            echo '<div style="color: #999; margin-bottom: 15px; font-size: 12px;">画像を追加</div>';
        }
        
        echo '<button type="button" class="upload-gallery-image" style="background: #0073aa; color: white; border: none; border-radius: 4px; padding: 8px 16px; cursor: pointer; font-size: 12px;">' . ($image_url ? '変更' : '追加') . '</button>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
    
    echo '<style>
    .gallery-item:hover { border-color: #0073aa; background: #f0f8ff; }
    .upload-gallery-image:hover { background: #005177; }
    .remove-gallery-image:hover { background: #b91c1c; }
    </style>';
    
    echo '<script>
    jQuery(document).ready(function($) {
        var frame;
        
        $(".upload-gallery-image").on("click", function(e) {
            e.preventDefault();
            
            var button = $(this);
            var item = button.closest(".gallery-item");
            var imageIdInput = item.find(".gallery-image-id");
            var imageContainer = item.find("img").length ? item.find("img") : item.find("div");
            
            if (frame) {
                frame.open();
                return;
            }
            
            frame = wp.media({
                title: "画像を選択",
                button: {
                    text: "選択"
                },
                multiple: false
            });
            
            frame.on("select", function() {
                var attachment = frame.state().get("selection").first().toJSON();
                imageIdInput.val(attachment.id);
                
                if (imageContainer.is("div")) {
                    imageContainer.replaceWith("<img src=\"" + attachment.sizes.medium.url + "\" style=\"max-width: 100%; max-height: 120px; margin-bottom: 15px; border-radius: 4px;\" />");
                    // 削除ボタンを追加
                    $("<button type=\"button\" class=\"remove-gallery-image\" style=\"position: absolute; top: 10px; right: 10px; background: #dc2626; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; font-size: 16px; line-height: 1;\">×</button>").insertAfter(imageContainer);
                } else {
                    imageContainer.attr("src", attachment.sizes.medium.url);
                }
                
                button.text("変更");
            });
            
            frame.open();
        });
        
        $(".remove-gallery-image").on("click", function(e) {
            e.preventDefault();
            
            var button = $(this);
            var item = button.closest(".gallery-item");
            var imageIdInput = item.find(".gallery-image-id");
            var uploadButton = item.find(".upload-gallery-image");
            
            imageIdInput.val("");
            item.find("img").replaceWith("<div style=\"color: #999; margin-bottom: 15px; font-size: 12px;\">画像を追加</div>");
            uploadButton.text("追加");
            button.remove();
        });
    });
    </script>';
}

// 物件価格・費用のコールバック関数
function property_pricing_callback($post) {
    $price = get_post_meta($post->ID, '_property_price', true);
    $area_size = get_post_meta($post->ID, '_property_area_size', true);
    $management_fee = get_post_meta($post->ID, '_property_management_fee', true);
    $car_parking_fee = get_post_meta($post->ID, '_property_car_parking_fee', true);
    $bike_parking_fee = get_post_meta($post->ID, '_property_bike_parking_fee', true);
    
    echo '<table class="form-table">';
    
    // 価格
    echo '<tr>';
    echo '<th scope="row"><label for="property_price">価格</label></th>';
    echo '<td>';
    echo '<input type="number" id="property_price" name="property_price" value="' . esc_attr($price) . '" style="width: 200px;" />';
    echo '<span style="margin-left: 10px;">VND（ベトナムドン）</span>';
    echo '<p class="description">物件の価格をベトナムドンで入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    // 平米数
    echo '<tr>';
    echo '<th scope="row"><label for="property_area_size">平米数</label></th>';
    echo '<td>';
    echo '<input type="number" id="property_area_size" name="property_area_size" value="' . esc_attr($area_size) . '" style="width: 200px;" step="0.01" />';
    echo '<span style="margin-left: 10px;">m²</span>';
    echo '<p class="description">物件の面積を平方メートルで入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    // 物件共益費・管理費
    echo '<tr>';
    echo '<th scope="row"><label for="property_management_fee">物件共益費・管理費</label></th>';
    echo '<td>';
    echo '<input type="number" id="property_management_fee" name="property_management_fee" value="' . esc_attr($management_fee) . '" style="width: 200px;" />';
    echo '<span style="margin-left: 10px;">VND（ベトナムドン）/月</span>';
    echo '<p class="description">月額の共益費・管理費をベトナムドンで入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    // 自動車駐車場費用
    echo '<tr>';
    echo '<th scope="row"><label for="property_car_parking_fee">自動車駐車場費用</label></th>';
    echo '<td>';
    echo '<input type="number" id="property_car_parking_fee" name="property_car_parking_fee" value="' . esc_attr($car_parking_fee) . '" style="width: 200px;" />';
    echo '<span style="margin-left: 10px;">VND（ベトナムドン）/月</span>';
    echo '<p class="description">月額の自動車駐車場費用をベトナムドンで入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    // バイク駐車場費用
    echo '<tr>';
    echo '<th scope="row"><label for="property_bike_parking_fee">バイク駐車場費用</label></th>';
    echo '<td>';
    echo '<input type="number" id="property_bike_parking_fee" name="property_bike_parking_fee" value="' . esc_attr($bike_parking_fee) . '" style="width: 200px;" />';
    echo '<span style="margin-left: 10px;">VND（ベトナムドン）/月</span>';
    echo '<p class="description">月額のバイク駐車場費用をベトナムドンで入力してください。</p>';
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
    
}

// YouTube動画のコールバック関数
function property_video_callback($post) {
    wp_nonce_field('property_video_nonce', 'property_video_nonce_field');
    
    $youtube_id = get_post_meta($post->ID, 'property_youtube_id', true);
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th scope="row"><label for="property_youtube_id">YouTube動画ID</label></th>';
    echo '<td>';
    echo '<input type="text" id="property_youtube_id" name="property_youtube_id" value="' . esc_attr($youtube_id) . '" style="width: 100%;" placeholder="例: dQw4w9WgXcQ" />';
    echo '<p class="description">YouTubeのURLから動画IDを入力してください。例: https://www.youtube.com/watch?v=dQw4w9WgXcQ の場合、「dQw4w9WgXcQ」を入力</p>';
    
    if ($youtube_id) {
        echo '<div style="margin-top: 15px;">';
        echo '<h4>プレビュー:</h4>';
        echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . esc_attr($youtube_id) . '" frameborder="0" allowfullscreen></iframe>';
        echo '</div>';
    }
    
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

// 平米数タクソノミーのコールバック関数


// カスタムフィールドの保存
function save_property_meta($post_id) {
    // エリアタクソノミーの保存
    if (isset($_POST['property_area']) && is_array($_POST['property_area'])) {
        $area_terms = array_map('intval', $_POST['property_area']);
        $area_terms = array_filter($area_terms); // 空の値を除去
        
        if (!empty($area_terms)) {
            wp_set_post_terms($post_id, $area_terms, 'area');
        } else {
            wp_set_post_terms($post_id, array(), 'area');
        }
    } else {
        wp_set_post_terms($post_id, array(), 'area');
    }
    
    // 状態タクソノミーの保存
    if (isset($_POST['property_condition']) && !empty($_POST['property_condition'])) {
        $condition_term_id = intval($_POST['property_condition']);
        wp_set_post_terms($post_id, array($condition_term_id), 'property_condition');
    } else {
        wp_set_post_terms($post_id, array(), 'property_condition');
    }
    
    // 物件タイプタクソノミーの保存
    if (isset($_POST['property_type']) && !empty($_POST['property_type'])) {
        $property_type_term_id = intval($_POST['property_type']);
        wp_set_post_terms($post_id, array($property_type_term_id), 'property_type');
    } else {
        wp_set_post_terms($post_id, array(), 'property_type');
    }
    
    
    // 間取りタイプタクソノミーの保存
    if (isset($_POST['property_layout_type']) && is_array($_POST['property_layout_type'])) {
        $layout_type_terms = array_map('intval', $_POST['property_layout_type']);
        $layout_type_terms = array_filter($layout_type_terms); // 空の値を除去
        
        if (!empty($layout_type_terms)) {
            wp_set_post_terms($post_id, $layout_type_terms, 'property_tag');
        } else {
            wp_set_post_terms($post_id, array(), 'property_tag');
        }
    } else {
        wp_set_post_terms($post_id, array(), 'property_tag');
    }
    
    // 物件の特徴・設備タクソノミーの保存
    if (isset($_POST['property_features']) && is_array($_POST['property_features'])) {
        $feature_terms = array_map('intval', $_POST['property_features']);
        $feature_terms = array_filter($feature_terms); // 空の値を除去
        
        if (!empty($feature_terms)) {
            wp_set_post_terms($post_id, $feature_terms, 'property_features');
        } else {
            wp_set_post_terms($post_id, array(), 'property_features');
        }
    } else {
        wp_set_post_terms($post_id, array(), 'property_features');
    }
    // ギャラリー画像の保存（固定フィールド）
    $image_types = array(
        'main', 'exterior', 'view1', 'view2', 'balcony1', 'balcony2',
        'living1', 'living2', 'living3', 'entrance', 'kitchen',
        'bedroom1', 'bedroom2', 'bedroom3', 'bedroom4', 'bedroom5', 'bedroom6',
        'storage1', 'storage2', 'bathroom1', 'bathroom2', 'bathroom3',
        'facility1', 'facility2', 'facility3', 'facility4', 'facility5'
    );
    
    foreach ($image_types as $type) {
        $field_name = 'property_gallery_' . $type;
        if (isset($_POST[$field_name]) && !empty($_POST[$field_name])) {
            update_post_meta($post_id, '_property_gallery_' . $type, intval($_POST[$field_name]));
        } else {
            delete_post_meta($post_id, '_property_gallery_' . $type);
        }
    }
    
    // YouTube動画IDの保存
    if (isset($_POST['property_video_nonce_field']) && wp_verify_nonce($_POST['property_video_nonce_field'], 'property_video_nonce')) {
        if (isset($_POST['property_youtube_id'])) {
            $youtube_id = sanitize_text_field($_POST['property_youtube_id']);
            update_post_meta($post_id, 'property_youtube_id', $youtube_id);
        } else {
            delete_post_meta($post_id, 'property_youtube_id');
        }
    }
    
    // 物件価格・費用の保存
    if (isset($_POST['property_price']) && !empty($_POST['property_price'])) {
        update_post_meta($post_id, '_property_price', intval($_POST['property_price']));
    } else {
        delete_post_meta($post_id, '_property_price');
    }
    
    if (isset($_POST['property_area_size']) && !empty($_POST['property_area_size'])) {
        update_post_meta($post_id, '_property_area_size', floatval($_POST['property_area_size']));
    } else {
        delete_post_meta($post_id, '_property_area_size');
    }
    
    if (isset($_POST['property_management_fee']) && !empty($_POST['property_management_fee'])) {
        update_post_meta($post_id, '_property_management_fee', intval($_POST['property_management_fee']));
    } else {
        delete_post_meta($post_id, '_property_management_fee');
    }
    
    if (isset($_POST['property_car_parking_fee']) && !empty($_POST['property_car_parking_fee'])) {
        update_post_meta($post_id, '_property_car_parking_fee', intval($_POST['property_car_parking_fee']));
    } else {
        delete_post_meta($post_id, '_property_car_parking_fee');
    }
    
    if (isset($_POST['property_bike_parking_fee']) && !empty($_POST['property_bike_parking_fee'])) {
        update_post_meta($post_id, '_property_bike_parking_fee', intval($_POST['property_bike_parking_fee']));
    } else {
        delete_post_meta($post_id, '_property_bike_parking_fee');
    }
    
    // 関連プロジェクトの保存
    if (isset($_POST['property_project_id']) && !empty($_POST['property_project_id'])) {
        update_post_meta($post_id, '_property_project_id', intval($_POST['property_project_id']));
    } else {
        delete_post_meta($post_id, '_property_project_id');
    }
    
    // 関連開発会社の保存
    if (isset($_POST['property_company_id']) && !empty($_POST['property_company_id'])) {
        update_post_meta($post_id, '_property_company_id', intval($_POST['property_company_id']));
    } else {
        delete_post_meta($post_id, '_property_company_id');
    }
    
}
add_action('save_post', 'save_property_meta');

// プロジェクト用のメタデータ保存
function save_project_meta($post_id) {
    // エリアタクソノミーの保存
    if (isset($_POST['project_area']) && is_array($_POST['project_area'])) {
        $area_terms = array_map('intval', $_POST['project_area']);
        $area_terms = array_filter($area_terms); // 空の値を除去
        
        if (!empty($area_terms)) {
            wp_set_post_terms($post_id, $area_terms, 'area');
        } else {
            wp_set_post_terms($post_id, array(), 'area');
        }
    } else {
        wp_set_post_terms($post_id, array(), 'area');
    }
    
    // プロジェクトの特徴・設備タクソノミーの保存
    if (isset($_POST['project_features']) && is_array($_POST['project_features'])) {
        $feature_terms = array_map('intval', $_POST['project_features']);
        $feature_terms = array_filter($feature_terms); // 空の値を除去
        
        if (!empty($feature_terms)) {
            wp_set_post_terms($post_id, $feature_terms, 'project_features');
        } else {
            wp_set_post_terms($post_id, array(), 'project_features');
        }
    } else {
        wp_set_post_terms($post_id, array(), 'project_features');
    }
    
    // プロジェクト詳細情報の保存
    if (isset($_POST['project_total_units']) && !empty($_POST['project_total_units'])) {
        update_post_meta($post_id, '_project_total_units', intval($_POST['project_total_units']));
    } else {
        delete_post_meta($post_id, '_project_total_units');
    }
    
    if (isset($_POST['project_land_area']) && !empty($_POST['project_land_area'])) {
        update_post_meta($post_id, '_project_land_area', floatval($_POST['project_land_area']));
    } else {
        delete_post_meta($post_id, '_project_land_area');
    }
    
    if (isset($_POST['project_location']) && !empty($_POST['project_location'])) {
        update_post_meta($post_id, '_project_location', sanitize_textarea_field($_POST['project_location']));
    } else {
        delete_post_meta($post_id, '_project_location');
    }
    
    // プロジェクト画像の保存
    $image_fields = array(
        'project_plan_1', 'project_plan_2', 'project_plan_3', 'project_plan_4', 'project_plan_5',
        'project_facility_1', 'project_facility_2', 'project_facility_3', 'project_facility_4', 'project_facility_5',
        'project_property_1', 'project_property_2', 'project_property_3', 'project_property_4', 'project_property_5'
    );
    
    foreach ($image_fields as $field) {
        if (isset($_POST[$field]) && !empty($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, intval($_POST[$field]));
        } else {
            delete_post_meta($post_id, '_' . $field);
        }
    }
}
add_action('save_post_project', 'save_project_meta');

// 開発会社用のメタデータ保存
function save_company_meta($post_id) {
    // エリアタクソノミーの保存
    if (isset($_POST['company_area']) && is_array($_POST['company_area'])) {
        $area_terms = array_map('intval', $_POST['company_area']);
        $area_terms = array_filter($area_terms); // 空の値を除去
        
        if (!empty($area_terms)) {
            wp_set_post_terms($post_id, $area_terms, 'area');
        } else {
            wp_set_post_terms($post_id, array(), 'area');
        }
    } else {
        wp_set_post_terms($post_id, array(), 'area');
    }
    
    // 事業分野タクソノミーの保存
    if (isset($_POST['company_sector']) && is_array($_POST['company_sector'])) {
        $sector_terms = array_map('intval', $_POST['company_sector']);
        $sector_terms = array_filter($sector_terms); // 空の値を除去
        
        if (!empty($sector_terms)) {
            wp_set_post_terms($post_id, $sector_terms, 'company_sector');
        } else {
            wp_set_post_terms($post_id, array(), 'company_sector');
        }
    } else {
        wp_set_post_terms($post_id, array(), 'company_sector');
    }
    
    // 会社規模タクソノミーの保存
    if (isset($_POST['company_size']) && !empty($_POST['company_size'])) {
        $size_term_id = intval($_POST['company_size']);
        wp_set_post_terms($post_id, array($size_term_id), 'company_size');
    } else {
        wp_set_post_terms($post_id, array(), 'company_size');
    }
    
    // 会社詳細情報の保存
    if (isset($_POST['company_established_year']) && !empty($_POST['company_established_year'])) {
        update_post_meta($post_id, '_company_established_year', intval($_POST['company_established_year']));
    } else {
        delete_post_meta($post_id, '_company_established_year');
    }
    
    if (isset($_POST['company_employees']) && !empty($_POST['company_employees'])) {
        update_post_meta($post_id, '_company_employees', intval($_POST['company_employees']));
    } else {
        delete_post_meta($post_id, '_company_employees');
    }
    
    if (isset($_POST['company_capital']) && !empty($_POST['company_capital'])) {
        update_post_meta($post_id, '_company_capital', intval($_POST['company_capital']));
    } else {
        delete_post_meta($post_id, '_company_capital');
    }
    
    if (isset($_POST['company_website']) && !empty($_POST['company_website'])) {
        update_post_meta($post_id, '_company_website', esc_url_raw($_POST['company_website']));
    } else {
        delete_post_meta($post_id, '_company_website');
    }
    
    // 連絡先情報の保存
    if (isset($_POST['company_phone']) && !empty($_POST['company_phone'])) {
        update_post_meta($post_id, '_company_phone', sanitize_text_field($_POST['company_phone']));
    } else {
        delete_post_meta($post_id, '_company_phone');
    }
    
    if (isset($_POST['company_email']) && !empty($_POST['company_email'])) {
        update_post_meta($post_id, '_company_email', sanitize_email($_POST['company_email']));
    } else {
        delete_post_meta($post_id, '_company_email');
    }
    
    if (isset($_POST['company_address']) && !empty($_POST['company_address'])) {
        update_post_meta($post_id, '_company_address', sanitize_textarea_field($_POST['company_address']));
    } else {
        delete_post_meta($post_id, '_company_address');
    }
    
    if (isset($_POST['company_contact_person']) && !empty($_POST['company_contact_person'])) {
        update_post_meta($post_id, '_company_contact_person', sanitize_text_field($_POST['company_contact_person']));
    } else {
        delete_post_meta($post_id, '_company_contact_person');
    }
}
add_action('save_post_company', 'save_company_meta');

// フロントエンド表示用のヘルパー関数
function get_property_gallery($post_id) {
    $image_types = array(
        'main' => 'メイン写真',
        'exterior' => '建物外観',
        'view1' => '部屋からの景色1',
        'view2' => '部屋からの景色2',
        'balcony1' => 'ベランダ・バルコニー1',
        'balcony2' => 'ベランダ・バルコニー2',
        'living1' => 'リビング1',
        'living2' => 'リビング2',
        'living3' => 'リビング3',
        'entrance' => '玄関',
        'kitchen' => 'キッチン',
        'bedroom1' => '寝室1',
        'bedroom2' => '寝室2',
        'bedroom3' => '寝室3',
        'bedroom4' => '寝室4',
        'bedroom5' => '寝室5',
        'bedroom6' => '寝室6',
        'storage1' => '収納1',
        'storage2' => '収納2',
        'bathroom1' => 'シャワー・トイレ1',
        'bathroom2' => 'シャワー・トイレ2',
        'bathroom3' => 'シャワー・トイレ3',
        'facility1' => 'その他設備1',
        'facility2' => 'その他設備2',
        'facility3' => 'その他設備3',
        'facility4' => 'その他設備4',
        'facility5' => 'その他設備5'
    );
    
    $result = array();
    foreach ($image_types as $type_key => $type_label) {
        $image_id = get_post_meta($post_id, '_property_gallery_' . $type_key, true);
        if (!empty($image_id)) {
            $image_url = wp_get_attachment_image_url($image_id, 'large');
            $thumbnail_url = wp_get_attachment_image_url($image_id, 'thumbnail');
            $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            
            if ($image_url) {
                $result[] = array(
                    'id' => $image_id,
                    'url' => $image_url,
                    'thumbnail' => $thumbnail_url,
                    'alt' => $alt_text,
                    'type' => $type_key,
                    'type_label' => $type_label
                );
            }
        }
    }
    
    return $result;
}

function get_property_youtube_id($post_id) {
    return get_post_meta($post_id, 'property_youtube_id', true);
}

// 物件価格・費用の取得関数
function get_property_price($post_id) {
    return get_post_meta($post_id, '_property_price', true);
}

function get_property_area_size($post_id) {
    return get_post_meta($post_id, '_property_area_size', true);
}

function get_property_management_fee($post_id) {
    return get_post_meta($post_id, '_property_management_fee', true);
}

function get_property_car_parking_fee($post_id) {
    return get_post_meta($post_id, '_property_car_parking_fee', true);
}

function get_property_bike_parking_fee($post_id) {
    return get_post_meta($post_id, '_property_bike_parking_fee', true);
}

// ベトナムドン形式での価格表示関数
function format_vnd_price($price) {
    if (empty($price)) {
        return '';
    }
    
    // 3桁区切りでカンマを追加
    return number_format($price, 0, ',', '.') . ' VND';
}

// プロジェクトの特徴・設備取得関数
function get_project_features($post_id) {
    return wp_get_post_terms($post_id, 'project_features', array('fields' => 'all'));
}

// プロジェクトのエリア取得関数
function get_project_areas($post_id) {
    return wp_get_post_terms($post_id, 'area', array('fields' => 'all'));
}

// プロジェクト詳細情報取得関数
function get_project_total_units($post_id) {
    return get_post_meta($post_id, '_project_total_units', true);
}

function get_project_land_area($post_id) {
    return get_post_meta($post_id, '_project_land_area', true);
}

function get_project_location($post_id) {
    return get_post_meta($post_id, '_project_location', true);
}

// プロジェクト画像取得関数
function get_project_images($post_id) {
    $image_types = array(
        'plan' => array(
            'title' => 'プロジェクト計画図',
            'fields' => array(
                'project_plan_1', 'project_plan_2', 'project_plan_3', 'project_plan_4', 'project_plan_5'
            )
        ),
        'facility' => array(
            'title' => 'プロジェクト施設',
            'fields' => array(
                'project_facility_1', 'project_facility_2', 'project_facility_3', 'project_facility_4', 'project_facility_5'
            )
        ),
        'property' => array(
            'title' => 'プロジェクト物件',
            'fields' => array(
                'project_property_1', 'project_property_2', 'project_property_3', 'project_property_4', 'project_property_5'
            )
        )
    );
    
    $result = array();
    foreach ($image_types as $category_key => $category) {
        $category_images = array();
        foreach ($category['fields'] as $field) {
            $image_id = get_post_meta($post_id, '_' . $field, true);
            if (!empty($image_id)) {
                $image_url = wp_get_attachment_image_url($image_id, 'large');
                $thumbnail_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                
                if ($image_url) {
                    $category_images[] = array(
                        'id' => $image_id,
                        'url' => $image_url,
                        'thumbnail' => $thumbnail_url,
                        'alt' => $alt_text,
                        'field' => $field
                    );
                }
            }
        }
        
        if (!empty($category_images)) {
            $result[$category_key] = array(
                'title' => $category['title'],
                'images' => $category_images
            );
        }
    }
    
    return $result;
}

function display_property_gallery($post_id, $show_thumbnails = true) {
    $gallery_images = get_property_gallery($post_id);
    
    if (empty($gallery_images)) {
        return '';
    }
    
    $output = '<div class="property-gallery">';
    
    if ($show_thumbnails && count($gallery_images) > 1) {
        $output .= '<div class="gallery-thumbnails" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)); gap: 10px; margin-bottom: 20px;">';
        foreach ($gallery_images as $index => $image) {
            $active_class = $index === 0 ? 'active' : '';
            $output .= '<img src="' . esc_url($image['thumbnail']) . '" alt="' . esc_attr($image['alt']) . '" class="gallery-thumb ' . $active_class . '" data-gallery-index="' . $index . '" style="cursor: pointer; border: 2px solid transparent; border-radius: 5px; transition: border-color 0.3s ease;">';
        }
        $output .= '</div>';
    }
    
    $output .= '<div class="gallery-main">';
    foreach ($gallery_images as $index => $image) {
        $display_style = $index === 0 ? 'block' : 'none';
        $output .= '<div class="gallery-slide" data-gallery-index="' . $index . '" style="display: ' . $display_style . '; position: relative;">';
        
        if (!empty($image['type_label'])) {
            $output .= '<div class="image-type-label" style="position: absolute; top: 15px; left: 15px; background: rgba(0,0,0,0.7); color: white; padding: 8px 12px; border-radius: 5px; font-size: 14px; z-index: 2; font-weight: 600;">' . esc_html($image['type_label']) . '</div>';
        }
        
        $output .= '<img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '" style="width: 100%; height: auto; border-radius: 10px;">';
        $output .= '</div>';
    }
    $output .= '</div>';
    
    if (count($gallery_images) > 1) {
        $output .= '<div class="gallery-nav" style="text-align: center; margin-top: 15px;">';
        $output .= '<button class="gallery-prev" style="background: #dc2626; color: white; border: none; padding: 8px 15px; border-radius: 5px; margin-right: 10px; cursor: pointer;">← ' . __('前へ', 'nhatoidayroi') . '</button>';
        $output .= '<span class="gallery-counter" style="margin: 0 15px; color: #666;">1 / ' . count($gallery_images) . '</span>';
        $output .= '<button class="gallery-next" style="background: #dc2626; color: white; border: none; padding: 8px 15px; border-radius: 5px; margin-left: 10px; cursor: pointer;">' . __('次へ', 'nhatoidayroi') . ' →</button>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    
    // ギャラリー用のJavaScript
    $output .= '<script>
    document.addEventListener("DOMContentLoaded", function() {
        const galleryContainer = document.querySelector(".property-gallery");
        if (!galleryContainer) return;
        
        const slides = galleryContainer.querySelectorAll(".gallery-slide");
        const thumbs = galleryContainer.querySelectorAll(".gallery-thumb");
        const prevBtn = galleryContainer.querySelector(".gallery-prev");
        const nextBtn = galleryContainer.querySelector(".gallery-next");
        const counter = galleryContainer.querySelector(".gallery-counter");
        
        if (slides.length <= 1) return;
        
        let currentIndex = 0;
        
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.display = i === index ? "block" : "none";
            });
            
            thumbs.forEach((thumb, i) => {
                thumb.style.borderColor = i === index ? "#dc2626" : "transparent";
            });
            
            if (counter) {
                counter.textContent = (index + 1) + " / " + slides.length;
            }
            
            currentIndex = index;
        }
        
        function nextSlide() {
            const nextIndex = (currentIndex + 1) % slides.length;
            showSlide(nextIndex);
        }
        
        function prevSlide() {
            const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
            showSlide(prevIndex);
        }
        
        if (prevBtn) prevBtn.addEventListener("click", prevSlide);
        if (nextBtn) nextBtn.addEventListener("click", nextSlide);
        
        thumbs.forEach((thumb, index) => {
            thumb.addEventListener("click", () => showSlide(index));
        });
    });
    </script>';
    
    return $output;
}

function display_property_youtube_video($post_id, $width = 560, $height = 315) {
    $youtube_id = get_property_youtube_id($post_id);
    
    if (!$youtube_id) {
        return '';
    }
    
    $output = '<div class="property-video" style="margin: 20px 0;">';
    $output .= '<h3 style="margin-bottom: 15px; color: #333;">' . __('物件動画', 'nhatoidayroi') . '</h3>';
    $output .= '<div class="video-container" style="position: relative; width: 100%; max-width: ' . $width . 'px; margin: 0 auto;">';
    $output .= '<iframe width="' . $width . '" height="' . $height . '" src="https://www.youtube.com/embed/' . esc_attr($youtube_id) . '" frameborder="0" allowfullscreen style="width: 100%; border-radius: 10px;"></iframe>';
    $output .= '</div>';
    $output .= '</div>';
    
    return $output;
}

// 管理画面でのカスタムフィールド（後で実装予定）
// ここにカスタムフィールドの設定を追加
?>
