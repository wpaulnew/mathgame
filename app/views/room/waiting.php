<div class="wrapper">
    <div class="main">
        <!--Меняеться только эта часть всегда-->
        <div class="waiting">
            <div class="profiles">

            </div>
        </div>
        <!--/-->
    </div>
</div>

<script>
    getAll();

    function getAll() {
        $.ajax({
            type: 'POST',
            url: window.location.href,
            dataType: 'json',
            data: {'waiting': window.location.href},
            success: function (response) {
//                console.log(response.correct);
                if (response.correct == true) {
//                    console.log(response.photos);
                    $('.profiles').html(response.photos);
                }
//                console.log(response);
                if (response.correct == false) {
                    window.location.href = '/room/id/' + response.id ;
                }

                setTimeout(getAll, 1000);
            }
        });
    }
</script>