var isEnded = false;
var end = false;

function scrollMore(){
    var $target = $('#showmore-trigger');

    if (isEnded) {
        return false;
    }

    var wt = $(window).scrollTop();
    var wh = $(window).height();
    var et = $target.offset().top;
    var eh = $target.outerHeight();
    var dh = $(document).height();

    if (wt + wh >= et || wh + wt == dh || eh + et < wh){
        var page = $target.attr('data-page');
        page++;
        isEnded = true;

        if (!end) {
            $.ajax({
                url: '/feed/load?page=' + page,
                dataType: 'json',
                success: function(data) {
                    $('.row .feed-list').append(data.html);
                    isEnded = false;
                }
            });
        }

        $target.attr('data-page', page);
        if (page == $target.attr('data-max')) {
            $target.remove();
            end = true;
        }
    }
}

$(window).scroll(function() {
    scrollMore();
});

$(document).ready(function() {
    scrollMore();
});
