<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>上传成绩</title>
</head>
<body>
@extends('nginx.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('上传文件') }}</div>

                    <div class="card-body">

                            <div class="col-md-12 col-sm-8">
                                <div class="links"  style="float: left; margin-top: 1%;margin-left:35%;" >
                                    <div class="add_box" style="margin-left: 20px; margin-top: 28px;">
                                        <span  onclick="downloadExcel()">上传之前务必点此<a href="/download">下载示例文档</a></span>
                                    </div>
                                    <br>
                                    <form  method="POST" action="/a" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                        <label for="table" style="margin-left: 20px;">请选择excle文件</label>

                                        <center>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="table" id="customFile">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                            <br><br>
                                            <button class="btn btn-primary" style="width: 100%;">提交</button>
                                        </center>
                                    </form>

                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

</body>
</html>