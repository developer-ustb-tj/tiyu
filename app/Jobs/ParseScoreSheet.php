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
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        $sheet = $reader->load($this->path.$this->filename)->getActiveSheet();
        $cells = $sheet->getCellCollection();
        $columns=collect([
            'student_id' => 'A',
            'student_name' => 'B',
            'student_score' => 'C'
        ]);
        DB::table('score')->delete();
        for($index=2; ;$index++){
            if($cells->get('A'.$index)==NULL || $cells->get('A'.$index)->getValue()==NULL){
                break;
            }
            $record = [];
            foreach($columns as $key => $col){
                $value = $cells->get($col.$index)->getValue();
                $record[$key]=$value;
            }
            $record = new \App\Score($record);
            $record->save();
        }
    }
}
