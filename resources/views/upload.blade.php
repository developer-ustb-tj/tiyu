<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>上传成绩</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/component.css')}}" />
    <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

</head>
    <style type="text/css">
        body{
            background: #f1e5e6;
        }
        a{
            color: #d3394c;/*正常显示的*/
        }
        a:visited {
            color:#00A600;
            text-decoration:none;
        }
        a:hover {
            color:#000000;/*鼠标移过去的*/
            text-decoration:none;
        }
    </style>
</head>
<body>
<div class="links"  style="float: left; margin-top: 10%;margin-left:35%; width: 400px; height: 300px; background: rgba(225,0,0,0.1)" >

    <div class="add_box" style="margin-left: 20px; margin-top: 28px;">
        <span  onclick="downloadExcel()">上传之前务必点此<a href="/download">下载示例文档</a></span>
    </div>
    <br>
    <form  method="POST" action="/a" enctype="multipart/form-data">
        {{ csrf_field() }}
        <label for="table" style="margin-left: 20px;">请选择excle文件</label>
        <br><br>
        <center>
        <div class="box">
            <input hidden="hidden" required type="file" name="table" id="file-4" class="inputfile inputfile-3" data-multiple-caption="{count} files selected" multiple />
            <label for="file-4"><span>Choose a file&hellip;</span></label>
        </div>
        <br><br>
        <input hidden="hidden" type="submit" name="file-1[]" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
        <label for="file-1"><span>提交</span></label>
        </center>
    </form>

</div>
<script src="{{asset('js/custom-file-input.js')}}"></script>
</body>
</html>