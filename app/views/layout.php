<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="<?= $description ?>"/>
    <meta name="author" content="<?= $author ?>">
    <meta name="keywords" content="<?= $keywords ?>"/>

    <link rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/public/css/normalize.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/public/css/main.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/public/awesome/css/font-awesome.min.css">
</head>
<body>

<div class="header">
    <div class="menu">
        <?php
        if (isset($_SESSION['login'])) {
            if (isset($_SESSION['current_room'])) {
                ?>
                <div class="left-menu">
                    <a href="/room/exit" id="begin">Leave the game</a>
<!--                    <a href="/room/update" id="begin">Update</a>-->
                </div>
                <?php
            } else {
                ?>
                <div class="left-menu">
                    <a href="/room/menu" id="begin">In a game</a>
<!--                    <a href="/room/update" id="begin">Update</a>-->
                </div>
                <?php
            }
        } else {
            ?>
            <div class="left-menu">
                <a href="" id="begin">Wellcome</a>
            </div>
            <?php
        }
        ?>
        <?php
        if (isset($_SESSION['login'])) {
            ?>
            <div class="right-menu">
                <a href="/home/id/<?=$_SESSION['id']?>"><?=$_SESSION['login'];?></a>
                <a href="/exit">Exit</a>
            </div>
            <?php
//            print_r($_SESSION);
        }
        ?>
    </div>
</div>

<script src="/public/js/jquery.min.js"></script>

<?= $content ?>

</body>

</html>