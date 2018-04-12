<div class="wrapper">
    <div class="main">
        <!--Меняеться только эта часть всегда-->
        <div class="play">
            <div class="buttons-play">
                <button id="btn-x2" class="btn-select-room">x2</button>
                <button id="btn-x3" class="btn-select-room">x3</button>
            </div>
        </div>
        <!--/-->
    </div>
</div>

<script>
$('#btn-x2').click(function () {
    $.ajax({
        type: 'POST',
        url: '/room/menu/',
        data: '2',
        success: function (id) {
//            console.log(id);
            if (id) {
                window.location.href = "/room/id/" + id + "/waiting";
            }
        }
    });
});

$('#btn-x3').click(function () {
    $.ajax({
        type: 'POST',
        url: '/room/menu/',
        data: '3',
        success: function (id) {
//            console.log(id);
            if (id) {
                window.location.href = "/room/id/" + id + "/waiting";
            }
        }
    });
});




//    $('#play-game').click(function () {
//        $.ajax({
//            type: 'POST',
//            url: '/room/menu/',
//            data: {'command': 'true'},
//            success: function (id) {
//                console.log(id);
//                if (id) {
//                    window.location.href = "/room/id/" + id + "/waiting";
//                }
//            },
//            error: function (xhr, status, error) {
//                alert(xhr.responseText + '|\n' + status + '|\n' + error);
//            }
//        });
//    });
</script>