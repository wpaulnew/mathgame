<div class="wrapper">
    <div class="main">
        <!--Меняеться только эта часть всегда-->
        <div class="win">
            <div class="winner">
                <img src="http://localhost/public/img/<?=$winner['photo']?>"  class="winner-icon" alt="">
            </div>
            <div class="message">
                <p><a href="/home/id/<?=$winner['id']?>"><?=$winner['login']?></a></p>
            </div>
            <div class="controls">
                <a href="/room/exit" class="a-restart">AGAIN</a>
                <a href="/home/id/<?=$_SESSION['id']?>" class="a-home">HOME</a>
            </div>
        </div>
        <!--/-->
    </div>
</div>