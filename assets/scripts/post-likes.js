$(document).ready(function() {
    $('body').on('click', '.button-like', function() {
        var button = $(this);
        var params = {
            'postId': $(this).attr('data-id'),
            'credentials': "same-origin"
        }

        $.post('/post/like', params, function (data) {
            if (data.success) {
                button.hide();
                button.siblings('.button-unlike').show();
                button.siblings('.likes-count').html(data.likesCount);
            }
        });
        return false;
    });

    $('body').on('click', '.button-unlike', function() {
        var button = $(this);
        var params = {
            'postId': $(this).attr('data-id'),
            'credentials': "same-origin"
        }

        $.post('/post/unlike', params, function (data) {
            if (data.success) {
                button.hide();
                button.siblings('.button-like').show();
                button.siblings('.likes-count').html(data.likesCount);
            }
        });
        return false;
    });
});
