@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">上传学生成绩</div>

                <div class="card-body">
                    <form action="/admin/upload" method="POST" enctype="multipart/form-data">
                        @if($errors->any())
                        {{-- TODO: 选中文件后，input 的文字修改为文件名 --}}
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                        @endif
                        <div class="alert alert-dark" role="alert">
                            下载 <a href="/admin/upload/sample">示例表格</a>
                        </div>
                        <div class="form-group form-check">
                            {{ csrf_field() }}
                            <div class="custom-file">
                                <input type="file" name="score_sheet" class="custom-file-input" id="customFile" required>
                                <label class="custom-file-label" for="customFile">选择 EXCEL 表格文件</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">上传</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection