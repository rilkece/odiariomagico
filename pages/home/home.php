<!-- home/home.php -->
<main class="mt-5">
<div class="container h-100 border-top-0">
    <div class="row">
        <div class="col-12 col-sm-4">
            <div class="d-flex flex-row">
                <?php
                if($user->profile_pic==''){
                    echo '<img class="rounded-circle z-depth-2 profile-pic" alt="200x200" src="'.INCLUDE_PATH.'imgs/profile_pic.png'.'" data-holder-rendered="true">';
                }else{
                    echo '<img class="rounded-circle z-depth-2 profile-pic" alt="200x200" src="data:image/jpg;charset=utf8;base64,'.base64_encode($user->profile_pic).'" data-holder-rendered="true">';
                }                
                ?>             
                <a id="edit_profile_pic">
                    <i class="fas fa-edit "></i>
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-8 home-info">
            <p>Olá, <?php echo $basic_user->nome; ?></p>
            <?php if($user->cargo == 'estudante'): ?>
            <p class="w-100 text-left text-secondary">Você está no nível 7</p>
            <div class="w-100 text-left">
                <img src="<?php echo INCLUDE_PATH.'imgs/medal_1.png' ?>" class="img-fluid img_medal" alt="">
                <img src="<?php echo INCLUDE_PATH.'imgs/medal_2.png' ?>" class="img-fluid img_medal" alt="">
                <img src="<?php echo INCLUDE_PATH.'imgs/medal_3.png' ?>" class="img-fluid img_medal" alt="">
                <img src="<?php echo INCLUDE_PATH.'imgs/medal_4.png' ?>" class="img-fluid img_medal" alt="">
            </div>
            <?php endif?>             
        </div>       
    </div>  
    <?php include 'home_menu.php'; ?>  
    
</div>
</main>
<!-- END/ home/home.php -->