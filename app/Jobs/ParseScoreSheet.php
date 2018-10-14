<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class ParseScoreSheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $filename;

    /**
     * Create a new job instance.
     * @param string $filename
     * @param string $path
     * @return void
     */
    public function __construct($path, $filename)
    {
        $this->path = $path;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $columns=collect([
            'student_id' => 'A',
            'student_name' => 'B',
            'student_score' => 'C'
        ]);
        $cells = IOFactory::createReader('Xlsx')
            ->setReadDataOnly(TRUE)
            ->load($this->path.$this->filename)
            ->getActiveSheet()
            ->getCellCollection();
        $result = collect();
        // 从第二行开始读，第一行是 column name
        for($i=2; $cells->get('A'.$i)==NULL || $cells->get('A'.$i)->getValue()==NULL ;$i++){ 
            $result->push($columns->map(function($item, $key) use (&$i, $cells){
                return $cells->get($item.$i)->getValue();   
            }));
        }
        DB::transaction(function() use (&$result) {
            DB::table('score')->delete();
            DB::table('score')->insert($result->toArray());
        });
    }
}
