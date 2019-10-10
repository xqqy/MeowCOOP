setTimeout(function() {
    document.getElementById("warn").innerHTML="";//删除过时的便利贴
}, 4001);
    function choose() {
        if(getcookie("DATE")==getcookie("NOW")){
            edit(getcookie("PATH"));
            return;
        }
        document.getElementById("meowModalLabel").innerHTML="书写日志"
        document.getElementById("button").innerHTML=
        '<button type="button" class="btn btn-default" data-dismiss="meowModal" id="hi">关闭</button>'+
        '<button type="button" class="btn btn-primary" id="up" onclick="insert()">提交更改</button>';
        show();
    }

    function auth() {//授权
        $("#authmodal").modal("show");
}

    function show() {//显示输入框
        var height=window.innerHeight;
        $('#meowModal').on('hidden.bs.modal', hide);
        $('#meowModal').modal('show');
        $('#summernote').summernote({
            lang: 'zh-CN', // default: 'en-US'
            height: height*0.55,
            focus: true,
            toolbar: [
                ['style', ['bold', 'strikethrough', 'underline', 'clear']],
                ['font', ['fontsize', 'color', 'clear']],
                ['paragraph', ['paragraph', 'ol', 'ul','hr']],
                ['msic', ['codeview']]
            ],
            placeholder: '喵'
        })
    }

    function hide() {//隐藏输入框
        $('#summernote').summernote('destroy');
        document.getElementById("code").innerHTML="<div id='summernote'></div>"
    }
    function insert(){//刷新日记
        var code=$('#summernote').summernote('code');
        var form=new FormData();
        var xhr=new XMLHttpRequest();
        form.append("CODE",code);
        xhr.open("post","insert.php",true);
        xhr.send(form);
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 ){
                if(xhr.status==200){
                    if(xhr.responseText=='done'){
                        document.location="./index.php?success=设置成功"
                    } else{
                        document.location="./index.php?error="+xhr.responseText;
                    }
                } else{
                    document.location="./index.php?error="+"网络错误"+xhr.status
                }
            }
        }
    }
    function edit(data){//更改日记
        setcookie("DATE",data,1);//设置应更改的日期
        var xhr=new XMLHttpRequest;
        xhr.open("get",data+"?"+new Date(),true);
        xhr.send();
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 ){
                if(xhr.status==200){
                    document.getElementById("summernote").innerHTML=xhr.responseText;
                    //document.getElementById("myModalLabel").innerHTML="修改日志";
                    show();
                    document.getElementById("button").innerHTML=
                        '<button type="button" class="btn btn-default" data-dismiss="modal" id="hi">关闭</button>'+
                        '<button type="button" class="btn btn-primary" id="up" onclick="update()">提交更改</button>';
                } else{
                    document.location="./index.php?error="+"网络错误"+xhr.status
                }
            }
        }
    }
    function update(){//更新日记
        var code=$('#summernote').summernote('code');//获取html代码
        var form=new FormData();
        var xhr=new XMLHttpRequest();
        form.append("CODE",code);
        xhr.open("post","update.php",true);
        xhr.send(form);
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 ){
                if(xhr.status==200){
                    switch (xhr.responseText){
                        case "done":
                        document.location="./index.php?success=设置成功";
                        break;
                        case "deld":
                        document.location="./index.php?warning=删除成功";
                        break;
                        default:
                        document.location="./index.php?error="+xhr.responseText;
                    };
                } else{
                    document.location="./index.php?error="+"网络错误"+xhr.status
                }
            }
        }
    }
    function look(data){//查看日记
        var xhr=new XMLHttpRequest;
        xhr.open("get",data+"?"+new Date(),true);//确保日记更新
        xhr.send();
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 ){
                if(xhr.status==200){
                    document.getElementById("meowModalLabel").innerHTML=data;
                    document.getElementById("code").innerHTML=xhr.responseText;
                    document.getElementById("button").innerHTML=
                        '<button type="button" class="btn btn-default" data-dismiss="modal" id="hi">关闭</button>';//设置按钮
                        $('#meowModal').on('hidden.bs.modal', hide);//设置关闭按钮
                        $('#meowModal').modal('show');
                } else{
                    document.location="./index.php?error="+"网络错误"+xhr.status
                }
            }
        }
    }
