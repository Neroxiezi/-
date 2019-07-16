<div class="card" style="border: none;padding-left: 1rem">
    <div class="comment-wrap">
        <div class="photo">
            <img class="avatar"
                 src="{!! $comment_resource['member']['avator']?:'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAyCAIAAACVqM/bAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7EAAAOxAGVKw4bAAABR0lEQVRYhWP8//8/w2ACLAwMDK/PXz7TNunJ3sN/vv8YGEdwcsg425pU5Yka6jK+Ondpg3PoQDkFzVkBe1czO779/e7arYF2DAMDA8O/P3++vXzDbP/8678/fwbaMVDw5fEzFjyRJbC9DJn7wbMLjyzxKtFkkcGf7z+YcMkNFBh1ECEw6BzEOI1DnkilxKdN4lVigkEXQqMOIgQGnYNISNRogPiSmiQw6EJo1EGEwKBzEPklNfFgtKSmKhh1ECGAkqjJTraUALQkP+hCaNRBhAAL2TqJb8KSBAZdCI06iBAYdRAhMOogQmDUQYQAviYsJWMGZJsz6EJo1EGEwKBzEPmDDTQCTCycHAPtBgRg4eRgknG2HWhnIICMsy2TSVXeIAkkFk4Ok6o8JlFD3YC9qxV8XAfQWSycHAo+rgF7V4sa6jIOtgk8AGBtYijRaAUyAAAAAElFTkSuQmCC' !!}"/>
            <span style="padding:0.3rem">{{$comment_resource['member']['name']}}</span>
        </div>
        <div class="comment-block">
            <div class="comment-text">{!!  $parent_name?'<i style="color:blue">@'.$parent_name.'</i>':''  !!} {!! htmlspecialchars_decode($comment_resource['content']) !!}</div>
            <div class="bottom-comment">
                <div class="comment-date">{{$comment_resource['created_at']}}</div>
                <ul class="comment-actions">
                    <li class="complain">点赞</li>
                    <a class="reply-btn" data-content="{{$comment_resource['id']}}">
                        <li class="reply"><i class="fa fa-reply-all"></i> 回复</li>
                    </a>
                </ul>
            </div>
        </div>
    </div>
</div>