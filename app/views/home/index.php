<div class="wrapper">
    <div class="main">
        <!--Меняеться только эта часть всегда-->
        <div class="home">
            <div class="about-profile">
                <img src="http://localhost/public/img/<?=$info['photo']?>" class="profile-icon" alt="">
                <p class="name"><?=$info['login']?></p>
            </div>
            <div class="points">
                <p class="wins">
                    <span>
                        <i class="fa fa-trophy" id="count-win" aria-hidden="true"></i>
                    </span>
                    <span class="point-number"><?=$info['win']?></span>
<!--                    --><?php //print_r($_SESSION) ?>
                </p>
            </div>
        </div>
        <!--/-->
    </div>
</div>