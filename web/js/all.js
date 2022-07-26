$(document).ready(function () {
    let count = 0;
    $('.form').submit(function (event) {
        event.preventDefault();
        $('#feedbacks').html('');
        count = count + 5;
        $.ajax({
            url: '/feedback/all',
            type: 'POST',
            dataType: 'json',
            data: {
                count: count
            },
            success(data) {
                if (data.status) {
                    let layout = '';
                    for (let i = 0; i < data.feedback.length; i++) {
                        let images = '';

                        for (let j = 0; j < data.feedback[i].images.length; j++) {
                            images += `<li><img src="/images/` + data.feedback[i].images[j].name + `" width="150" height="120"></li>`
                        }
                        layout += `
<div>
    <p>` + data.feedback[i].id + `. Автор: ` + data.feedback[i].user.name + `</p>
    <p>Отзыв: <strong>` + data.feedback[i].message + `</strong></p>
    <ul>                    
    ` + images + `
    </ul>             
                        `;
                        if (data.feedback[i].comments.length > 0) {
                            layout += `
    <h4><strong>Комментарии: </strong></h4>                            
                            `;
                            for (let n = 0; n < data.feedback[i].comments.length; n++) {
                                let id = data.feedback[i].comments[n].id;

                                layout += `<br><p>Комментарий: <strong>` + data.feedback[i].comments[n].message + `</strong></p><ul>`
                                for (let m = 0; m < data.feedback[i].imgforcomments.length; m++) {
                                    let comment_id = data.feedback[i].imgforcomments[m]['comment_id'];

                                    if (comment_id === id) {
                                        layout += `<li><img src="/images/` + data.feedback[i].imgforcomments[m].name + `" width="75" height="60"></li>`
                                    }
                                }
                                layout += `    
    </ul>
    `;
                            }
                        } else {
                            layout += `<p><strong>` + "Комментарии отсутствуют :(" + `</strong></p>`

                        }
                        layout += `
</div>
<div>
    <a href="/feedback/view/?id=` + data.feedback[i].id + `" class="btn btn-outline-success">Комментировать</a>
    </div>
    <hr>
`;
                    }
                    $('#feedbacks').append(layout);
                    console.log(data);
                }
                if (!data.counts) {
                    $('#feedback').fadeOut();
                    $('#feedbacks').append("Отзывы закончились :(");
                }
            }
        })
    });
});