$(".user_language").change(function() {
    var language = this.value;
    $.ajax({
        url: '/language/change',
        type: 'GET',
        data: { 'language': language },
        success:function (result) {
            location.reload();
        },
    });
});
