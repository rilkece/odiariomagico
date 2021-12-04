<?php

//bootstrap
$script_bootstrap = '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous" ></script>';

//swiper
//$script_swiper = '<script src="'.INCLUDE_PATH.'script/swiper-bundle.min.js"></script>';

//jquery
$script_jquery_3_5_1 = '<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous" ></script>';
$script_jquery_ajax = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> ';

// Font Awesome 
$script_font_awesome = '<script src="https://kit.fontawesome.com/ad4fecfbfa.js" crossorigin="anonymous" ></script>';

// JQuery UI
$script_jquery_ui = '<script type="text/javascript" src="'.INCLUDE_PATH.'jquery/jquery-ui-1.12.1.custom/jquery-ui.js"></script>';

//AM CHARTS
$amchart_core = '<script src="https://cdn.amcharts.com/lib/4/core.js"></script>';
$amchart_charts = '<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>';
$amchart_timeline = '<script src="https://cdn.amcharts.com/lib/4/plugins/timeline.js"></script>';
$amchart_animated = '<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>';
$amchart_bullets = '<script src="https://cdn.amcharts.com/lib/4/plugins/bullets.js"></script>';
$amchart_maps = '<script src="https://cdn.amcharts.com/lib/4/maps.js"></script>';
$amchart_continents_low = '<script src="https://cdn.amcharts.com/lib/4/geodata/continentsLow.js"></script>';


//scripts
$main_script = '<script src="'.INCLUDE_PATH.'script/main_script.js"></script>';
$login_script = '<script src="'.INCLUDE_PATH.'script/login_script.js"></script>';
$home_script = '<script src="'.INCLUDE_PATH.'script/home_script.js"></script>';
$room_script = '<script src="'.INCLUDE_PATH.'script/room_script.js"></script>';
$mission_script = '<script src="'.INCLUDE_PATH.'script/mission_script.js"></script>';
$diary_script = '<script src="'.INCLUDE_PATH.'script/diary_script.js"></script>';


//echos
echo $script_jquery_3_5_1;
echo $script_jquery_ajax;
echo $script_jquery_ui;
echo $script_bootstrap;
echo $script_font_awesome;
echo $amchart_core;
echo $amchart_charts;
echo $amchart_timeline;
echo $amchart_animated;
echo $amchart_bullets;
echo $amchart_maps;
echo $amchart_continents_low;

//echo $script_swiper;

echo $main_script;

switch ($url) {
    case 'login':
        echo $login_script;
        break;
    case 'home':
        echo $home_script;
        break;
    case 'room':
        echo $room_script;
        break;
    case 'mission':
        echo $mission_script;
        break;
    case 'diary':
        echo $diary_script;
        break;

}


?>