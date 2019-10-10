function ready(){
    setTimeout(function() {
        document.getElementById("warn").innerHTML="";//删除过时的便利贴
    }, 4001);
}
function edit() {
    var xhr=new XMLHttpRequest();
    xhr.open("get","now.html?"+(new Date()).valueOf(),true);
    xhr.send();
    xhr.onreadystatechange=function(){
        if(xhr.readyState==4 ){
            if(xhr.status==200){
                document.getElementById("summernote").innerHTML=xhr.responseText;
                document.getElementById("myModalLabel").innerHTML="修改内容";
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

function show() {//显示输入框
    var height=window.innerHeight;
    $('#myModal').on('hidden.bs.modal', hide);
    $('#myModal').modal('show');
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