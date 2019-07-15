window.onload = function(){
    if(typeof jQuery == 'undefined'){
        var data=''
        var ajaxObj=new XMLHttpRequest();
        ajaxObj.open("GET","http://dev.jwt_test.com/api/comment_client",true);
        ajaxObj.onreadystatechange = function(){
            if (ajaxObj.readyState == 4) {
                var data = ajaxObj.responseText
                let frag = document.createRange().createContextualFragment(data);
                document.getElementById("comment").appendChild(frag)
                
            }
        }
        ajaxObj.send()
    
    }else {
        
    }
}