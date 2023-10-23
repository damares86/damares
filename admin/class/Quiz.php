<?php 

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Quiz extends Common{

    public $quiz_name ;
    public $quiz_id ;
    public $relation_id ;
    public $active ;
    public $winner_id ;
    public $counter ;
    public $answer ;
  
    public function checkScore()
    {

        $path = '../../quiz/q_'.$this->quiz_id.'/score/*';
        $scoreArr = [] ;

        $ans_0 = 0;
        $ans_1 = 0;
        $ans_2 = 0;
        $ans_3 = 0;
        foreach (glob($path) as $row) 
        {
            $item=pathinfo($row);

            
            $data = file_get_contents($row);
            $dataArr = json_decode($data);
            $score = (array)$dataArr[0];
            
            // ##### winner check ##### 
            // $ans = 0 ;
            // $time = 0 ;
                       
            for($i=1; $i<=count($score); $i++)
            {
                $label = 'ans_'.$score[$i];
                
                $$label++;               

                // ##### winner check ##### 
                // if(!$score[$i] == 0){
                //     $ans++;
                //     $time = $score[$i];
                // }                
            }

            // ##### winner check ##### 
            // if($ans > 0)
            // {
            //     $scoreArr[]=[ 'id' => $item['filename'], 'ans' => $ans, 'time' => $time ] ;
            // }

        }

        // ##### winner check ##### 
        // $winner = '' ;
        // $ans_ok = 0 ;
        // $best_time = 0 ;
                
        // ##### winner check ##### 
        // foreach($scoreArr as $s)
        // {
            // ##### winner check ##### 
            // if($best_time == 0 ){
                //     $best_time = $s['time']+1;
            // }
            
            // if( $s['ans'] >= $ans_ok && $s['time'] < $best_time){
                //     $ans_ok = $s['ans'] ;
                //     $best_time = $s['time'] ;
                //     $winner = $s['id'];
                // }             
        // }
            
        // ##### winner check ##### 
        // return $winner ;

        $ansArray = [
            '0' => $ans_0,
            '1' => $ans_1,
            '2' => $ans_2,
            '3' => $ans_3
        ] ;

        $ansStr = serialize($ansArray);
            
        return $ansStr ;

    }


}

?>