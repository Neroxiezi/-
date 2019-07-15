var editor2 = '';
var csrf_token = '';

function foo(data) {
    csrf_token = data['csrf_token']
}

function addScriptTag(src) {
    var script = document.createElement('script');
    script.setAttribute("type", "text/javascript");
    script.src = src;
    document.body.appendChild(script);
}

// window.onload = function () {
//     addScriptTag('http://dev.jwt_test.com/csrf_token?callback=foo');
// };
$(document).ready(function () {
    $("#comment_editor input").on("focus", function () {
        //addScriptTag('http://dev.jwt_test.com/csrf_token?callback=foo');
        $(".photo").css('margin', '0');
        $(".photo").css('height', '15%');
        $("#comment_editor").empty().append("<div id='comment_send_editor' style='height:30%;'></div>");
        editor2 = new wangEditor('#comment_send_editor');
        editor2.customConfig.menus = [
            'head', // 标题
            'bold', // 粗体
            'fontSize', // 字号
            'fontName', // 字体
            'italic', // 斜体
            'underline', // 下划线
            'strikeThrough', // 删除线
            'foreColor', // 文字颜色
            'backColor', // 背景颜色
            'emoticon', // 表情
        ];
        editor2.customConfig.height = '30%';
        editor2.create()
    });

    $(document).on("click", '#comment_save_btn', function () {
        var content = editor2.txt.html();
        var member_id = 1;
        var parent_id = 0;
        var send_url = 'http://dev.jwt_test.com/api/comment_save';
        $.ajax({
            type: 'post',
            url: send_url,
            dataType: 'json',
            data: {
                'member_id': member_id,
                'content': content,
                'parent_id': parent_id,
                'obj_id': 1,
                'referer_url': window.location.href,
            },
            headers: {
                'X-CSRF-TOKEN': csrf_token,
            },
            success: function (res) {
                if (res.code == 200) {
                    console.log(res);
                    $("#msg_popover").append('<div class="alert alert-success alert-dismissible" role="alert"><b>' + res.msg + '</b></div>').popover('toggle');
                    setTimeout(function () {
                        $("#msg_popover").popover('disable');
                        window.location.href = res.data['referer_url'];
                    }, 1000)
                } else {
                    $("#msg_popover").append('<div class="alert alert-danger alert-dismissible" role="alert"><b>' + res.msg + '</b></div>').popover('toggle');
                    setTimeout(function () {
                        $("#msg_popover").popover('disable');
                        window.location.href = res.data['referer_url'];
                    }, 1000)
                }
            }
        });
        return false;
    })
})
