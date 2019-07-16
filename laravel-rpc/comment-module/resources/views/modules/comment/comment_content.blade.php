<style>
    .w-e-text-container {
        height: 8rem !important;
    }
</style>
<script src="http://dev.jwt_test.com/js/app.js" defer></script>
<script src="https://unpkg.com/wangeditor@3.1.1/release/wangEditor.min.js"></script>
<link href="http://dev.jwt_test.com/css/app.css" rel="stylesheet">
<link href="http://dev.jwt_test.com/css/style.css" rel="stylesheet">
<link href="https://cdn.bootcss.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
    <div class="card">
        <div class="card-header" style="border: none">
            <span><i class="fa fa-heart-o" style="color:red"></i> 推荐</span>
        </div>
        <div class="card-body">
            <div class="input-group mb-3">
                <div class="input-group-prepend col-md-1 photo" style="margin: auto!important;">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAyCAIAAACVqM/bAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7EAAAOxAGVKw4bAAABR0lEQVRYhWP8//8/w2ACLAwMDK/PXz7TNunJ3sN/vv8YGEdwcsg425pU5Yka6jK+Ondpg3PoQDkFzVkBe1czO779/e7arYF2DAMDA8O/P3++vXzDbP/8678/fwbaMVDw5fEzFjyRJbC9DJn7wbMLjyzxKtFkkcGf7z+YcMkNFBh1ECEw6BzEOI1DnkilxKdN4lVigkEXQqMOIgQGnYNISNRogPiSmiQw6EJo1EGEwKBzEPklNfFgtKSmKhh1ECGAkqjJTraUALQkP+hCaNRBhAAL2TqJb8KSBAZdCI06iBAYdRAhMOogQmDUQYQAviYsJWMGZJsz6EJo1EGEwKBzEPmDDTQCTCycHAPtBgRg4eRgknG2HWhnIICMsy2TSVXeIAkkFk4Ok6o8JlFD3YC9qxV8XAfQWSycHAo+rgF7V4sa6jIOtgk8AGBtYijRaAUyAAAAAElFTkSuQmCC"
                         alt="">
                </div>
                <div class="col-md-11" id="comment_editor" style="margin: auto!important;"><input
                            id="comment_editor input" type="text"
                            style="width: 100%;" class="form-control" placeholder="开始讨论" aria-label="Username"
                            aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="input-group row justify-content-end" style="display: none">
                <div class="col-md-11">
                    <button class="btn btn-outline-success btn-sm comment_save_btn" data-parent-content="0"
                            style="float: right">提交
                    </button>
                </div>
            </div>
            <div id="msg_popover"></div>
        </div>
    </div>
    <div class="card comment_list">
        <div class="card-header bg-transparent" style="border: none;text-align: center">
            <span><b>没有评论,赶快抢沙发吧!</b></span>
        </div>
    </div>
</div>
<script src="http://dev.jwt_test.com/js/comment.js?version={{time()}}"></script>
