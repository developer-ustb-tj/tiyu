<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>上传成绩</title>
</head>
<body>
<div class="links">
<div class="add_box">
            <span  onclick="downloadExcel()">上传之前务必点此<a href="/download">下载示例文档</a></span>
        </div>
    <form  method="POST" action="/a" enctype="multipart/form-data">
        {{ csrf_field() }}           
        <label for="table">请选择excle文件</label>
        <input type="file" name="table" required>    
        <button type="submit">提交</button>
    </form>
    </div>
</body>
</html>