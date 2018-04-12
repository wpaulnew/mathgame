<div class="wrapper">
    <div class="main">
        <!--Меняеться только эта часть всегда-->
        <div class="login">
            <div class="sign-in">
                <input type="text" name="login" id="login" placeholder="Login">
                <input type="password" name="password" id="password" placeholder="Password">
                <button id="sign-in">SIGN IN</button>
            </div>
        </div>
        <!--/-->
    </div>
</div>

<script>
    $('#sign-in').click(function () {
        $.ajax({
            type: 'POST',
            url: 'login/',
            data: {'login': $('#login').val(), 'password': $('#password').val()},
            success: function (response) {
                var reply = JSON.parse(response);
                console.log(reply);
                console.log(response);
                if (reply.correct) {
                    window.location.href = "/home/id/" + reply.id;
                }
                if (!reply.correct) {
                    $('#sign-in').css('background', '#ff3333');
                }
            }
        });
    });
</script>