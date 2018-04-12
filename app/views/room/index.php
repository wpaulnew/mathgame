<div class="wrapper">
    <div class="main">
        <!--Меняеться только эта часть всегда-->
        <div class="process">
            <div class="level">
                <!--                <p>1 of 3</p>-->
            </div>
            <div class="profiles">

            </div>
            <div class="example">
                <p class="example-question"><?= $question['question'] ?></p>
            </div>
            <div class="answer">
                <input type="hidden" name="question" value="<?= $question['id'] ?>">
                <!--                Хотя можно взять просто id пльзвателя из сесии-->
                <input type="hidden" name="answering" value="<?php echo $_SESSION['id'] ?>">
                <input type="number" name="answer" class="input-answer" value="" placeholder="?">
                <button id="send-answer" class="btn-answer">Answer</button>
            </div>
        </div>
        <!--/-->
    </div>
</div>

<script>
    NextQuestion();

    function NextQuestion() {
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {'oneexample': window.location.href},
            success: function (response) {
                var reply = JSON.parse(response);
                console.log(response);
                if (!reply.correct) {
//                    console.log(reply.winner);
                    window.location.href = "http://localhost/room/id/" + reply.id + "/winner"
                }

                if (reply.correct) {
                    $('.answer>input[name=question]').val(reply.question.id);
                    $(".example-question").html(reply.question.question);
                }

                setTimeout(NextQuestion, 1000);
            }
        });
    }

    $('#send-answer').click(function () {
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {
                'question': $('input[name=question]').val(),
                'answering': $('input[name=answering]').val(), // id пользвателя
                'answer': $('input[name=answer]').val()
            },
            success: function (response) {
//                var reply = JSON.parse(response);
//                console.log(reply);
//                console.log(response);
            }
        });
    });
</script>