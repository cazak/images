$(document).ready(function() {
    $('#form').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: 'POST',
            url: '/comment/create?postId=' + $(this).attr('data-id'),
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('.comment-list').prepend(response.html);
                    $('.comment-likes-count').html(response.commentsCount)
                } else if (response.errors) {
                    console.log(response.errors);
                }
            }
        });
    })
})
