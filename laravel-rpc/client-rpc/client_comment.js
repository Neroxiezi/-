window.onload = function(){
    if(typeof jQuery == 'undefined'){
        var script_jquery = document.createElement('script');
        script_jquery.type="text/javascript";
        script_jquery.src='http://dev.jwt_test.com/js/jquery-2.2.4.min.js';
        document.body.appendChild(script_jquery);
        var data=''
        var ajaxObj=new XMLHttpRequest();
        ajaxObj.open("GET","http://dev.jwt_test.com/api/comment_client",true);
        ajaxObj.onreadystatechange = function(){
            if (ajaxObj.readyState == 4) {
                var data = ajaxObj.responseText
                console.log(JSON.parse(data).code==200);
                if(JSON.parse(data).code==200) {
                    let frag = document.createRange().createContextualFragment(JSON.parse(data)['data']);
                    document.getElementById("comment").appendChild(frag)
                }
            }
        }
        ajaxObj.send()
    
    }else {
        
    }
}