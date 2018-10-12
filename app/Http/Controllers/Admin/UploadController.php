<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\File\File;
use Auth;

use App\Jobs\ParseScoreSheet;

class UploadController extends Controller
{

    public function create() {
        return view('upload.upload');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'score_sheet' => 'required|mimes:xlsx'
        ]);
        if($this->processStorage($request->score_sheet)){
            return redirect('/admin/upload/success');
        } else {
            return redirect('/admin/upload')->withErrors("上传失败");
        }
    }

    /**
     * TODO: 客户端 ajax 轮询处理状态
     * @param File $file
     * @return boolean
     */
    protected function processStorage(File $file) {
        $extension = $file->getClientOriginalExtension();//获取文件后缀名
        $filename = md5(ceil(microtime(true)*1000)).'.'.$extension;
        $storage_path = storage_path('app/public/excel/');//上传文件保存的路径
        if (!file_exists($storage_path)) {//如果$storage_path（文件保存的目录）不存在
            mkdir($storage_path, 0777, true);//创建一个目录
        }
        if ($file->move($storage_path, $filename) == false) {//移动一个已上传的文件
            throw new \Exception("无法保存文件");
        }else{
            ParseScoreSheet::dispatch($storage_path, $filename);
            return true;
        }
    }

    public function success(){
        return view('upload.success');
    }

    /**
     * TODO: 可以改为指向 CDN 
     */
    public function sample(){
        return response()->download(storage_path('sample/slwd.xlsx'));
    }
}