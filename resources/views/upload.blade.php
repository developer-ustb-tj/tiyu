
@extends('nginx.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Upload') }}</div>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <span class="navbar-brand" onclick="downloadExcel()">上传之前务必点此<a href="/download">下载示例文档</a></span>
                    </div>
                    <div class="col-md-6 offset-md-3">
                        <form  method="POST" action="/a" enctype="multipart/form-data">
                        {{ csrf_field() }}        
					    <div class="custom-file">
                            <input type="file" class="custom-file-input" name="table" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                                
                        </div>
                        <div class="col-md-6 offset-md-5 card-body">
                            <button type="submit" class="btn btn-primary">{{ __('上传') }}</button>
                        </div>
                        </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection