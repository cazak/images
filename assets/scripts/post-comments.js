$(document).ready(function () {

    $('#form-create').submit(function (e) {
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
                    $('.comment-likes-count').html(response.commentsCount);

                    $('.comment-update').click(commentUpdate);

                } else if (response.errors) {
                    console.log(response.errors);
                }
            }
        });
    });

    $('.comment-update').click(commentUpdate);

    function commentUpdate() {
        var button = $(this);
        var commentText = $(this).closest('.comment-info').find('.comment-text');
        var commentUpdated = $(this).closest('.comment-info').find('.comment-is-updated');
        var commentFormDiv = $(this).siblings('.for-comment-update');

        var params = {
            'comment_id': button.attr('data-comment_id'),
            'author_id': button.attr('data-author_id')
        };
        $.ajax({
            type: 'GET',
            url: '/comment/update-form',
            data: params,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    button.siblings('.for-comment-update').html(response.html);
                    $('.comment-update-reset').click(function () {
                        $(this).closest('.for-comment-update').html('');
                    });

                    $('.comment-update-form').submit(function (e) {
                        e.preventDefault();
                        var form = $(this);
                        $.ajax({
                            type: 'POST',
                            url: '/comment/update',
                            data: form.serialize(),
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    $(commentText).html(response.text);
                                    $(commentUpdated).html(' updated');
                                    $(commentFormDiv).html('');
                                } else if (response.errors) {
                                    console.log(response.errors);
                                }
                            }
                        });
                    });
                }
            }
        });
    }

});
