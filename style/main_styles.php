<?php



//MDB
$link_md_bootstrap = '<link href="'.INCLUDE_PATH.'bootstrap-4.5.3-dist/css/mdb.css" rel="stylesheet" />';

// JQuery UI
$link_jquery_ui = '<link rel="stylesheet" href="'.INCLUDE_PATH.'jquery/jquery-ui-1.12.1.custom/jquery-ui.css" />';

//bootstrap style
$link_bootstrap = '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"/>';

//swiper
//$link_swiper = '<link rel="stylesheet" href="'.INCLUDE_PATH.'style/swiper-bundle.min.css" />';

//styles
$main_styles = '<link rel="stylesheet" href="'.INCLUDE_PATH.'style/main_styles.css" />';
$login_styles = '<link rel="stylesheet" href="'.INCLUDE_PATH.'style/login.css" />';
$home_styles = '<link rel="stylesheet" href="'.INCLUDE_PATH.'style/home.css" />';
$room_styles = '<link rel="stylesheet" href="'.INCLUDE_PATH.'style/room.css" />';
$mission_styles = '<link rel="stylesheet" href="'.INCLUDE_PATH.'style/mission.css" />';
$diary_styles = '<link rel="stylesheet" href="'.INCLUDE_PATH.'style/diary.css" />';




echo $link_bootstrap;
echo $link_md_bootstrap;
echo $link_jquery_ui;
//echo $link_swiper;

echo $main_styles;

switch ($url) {
    case 'login':
        echo $login_styles;
        break;
    case 'home':
        echo $home_styles;
        break;
    case 'room':
        echo $room_styles;
        break;
    case 'mission':
        echo $mission_styles;
        break;
    case 'diary':
        echo $diary_styles;
        break;

}

?>