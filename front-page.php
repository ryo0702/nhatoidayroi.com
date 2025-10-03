<?php
if(!empty($_GET['page'])){
    if($_GET['page'] == 'user-login'){
        include get_template_directory() . '/controllers/user-login.php';
    }
    elseif($_GET['page'] == 'user-register'){
        include get_template_directory() . '/controllers/user-register.php';
    }
    elseif($_GET['page'] == 'user-logout'){
        include get_template_directory() . '/controllers/user-logout.php';
    }
}
elseif(empty($_GET)){
    include get_template_directory() . '/controllers/front-page.php';
}