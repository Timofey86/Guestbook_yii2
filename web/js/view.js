$(document).ready(function () {
    let count = 0;
    let feedback_id = document.querySelector('.feedback_id').getAttribute('data-attr');
    $('.form').submit(function (event) {
        event.preventDefault();
        //$('#comments').html('');
        count = count + 5;

        $.ajax({
            url: '/comment/allcomments',
            type: 'POST',
            dataType: 'json',
            data: {
                count: count,
                feedback_id: feedback_id
            },
            success(data) {
                if (data.status) {
                    let layout = '';
                    for (let i = 0; i < data.comment.length; i++) {
                        let images = '';
                        for (let j = 0; j < data.comment[i].imgforcomments.length; j++) {
                            images += `<li><img src="/images/` + data.comment[i].imgforcomments[j].name + `" width="150" height="120"></li>`
                        }
                        layout += `
<div>
    <p>` + (i+6) + `Автор: ` + data.comment[i].user.name + `</p>
    <p>Комментарий: <strong>` + data.comment[i].message + `</strong></p>
    <ul>                    
    ` + images + `
    </ul>    
    <hr>
</div>
                    `;
                    }
                    $('#comments').append(layout);
                    console.log(data);

                }
                if (!data.counts) {
                    $('#comment').fadeOut();
                    $('#comments').append('Комментарии закончились:(');
                }

            }
        })
    });
});