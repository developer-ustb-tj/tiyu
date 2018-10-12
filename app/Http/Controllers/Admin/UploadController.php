<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Auth;
class UploadController extends Controller
{
    public function upload()
    {
        if (!Auth::check()){
            return view('auth.login');
        }
        return view('upload');
    }


    public function a(Request $request)//导入的时候  上传文件
    {
        if (!Auth::check()){
            return view('auth.login');
        }
        DB::delete('delete from score');
        if (!$request->hasFile('table')) {
            return [
            'success' => false,
            'message' => '上传文件为空'
            ];
        }
        $file = $request->file('table');
        if (!$file->isValid()) {
        return [
            'success' => false,
            'message' => '文件上传出错'
            ];
        }
        $extension = $file->getClientOriginalExtension();//获取文件后缀名
        $storage_path = storage_path('app/public/excel');//上传文件保存的路径
        if (!file_exists($storage_path)) {//如果$storage_path（文件保存的目录）不存在
            mkdir($storage_path, 0777, true);//创建一个目录
        }
        $filename = md5(ceil(microtime(true) * 1000)).'.' . $extension;
        if ($file->move($storage_path, $filename) == false) {//移动一个已上传的文件
            echo '上传失败！';
        }else{
            $write = $this->write($filename);
            echo '上传成功！';
            return view('upload');
        }
    }



    public function write($filename)
    {
        if (!Auth::check()){
            return view('auth.login');
        }
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('../storage/app/public/excel/'.$filename);//读取文件
        $content = $spreadsheet->getActiveSheet()->rangeToArray('A1:C100',NULL,TRUE,TRUE,TRUE);  //取出Excel内容
        for($i=2;;){
            $student_id=$content[$i]['A'];
            $student_name=$content[$i]['B'];
            $student_score=$content[$i]['C'];
            $bool = DB::table('score')->insert(['student_id'=>$student_id,'student_name'=>$student_name,'student_score'=>$student_score]);
            $i++;
            if($student_id==NULL){
                break;
            }
        }
    /**
     * TODO: 可以改为指向 CDN 
     */
    public function sample(){
        return response()->download(storage_path('sample/slwd.xlsx'));
    }
}