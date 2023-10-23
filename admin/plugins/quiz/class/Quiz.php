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
  
    public function checkScore()
    {

        $path = '../../quiz/q_'.$this->quiz_id.'/score/*';

        $scoreArr = [] ;
        

        foreach (glob($path) as $row) 
        {
            $item=pathinfo($row);

            $data = file_get_contents($row);
            $dataArr = json_decode($data);
            $score = (array)$dataArr[0];
            
            $ans = 0 ;
            $time = 0 ;

            for($i=0; $i<=count($score); $i++)
            {
                if(!$score[$i] == 0){
                    $ans++;
                    $time = $score[$i];
                }                
            }

            if($ans > 0)
            {
                $scoreArr[]=[ 'id' => $item['filename'], 'ans' => $ans, 'time' => $time ] ;
            }

        }

        $winner = '' ;
        $ans_ok = 0 ;
        $best_time = 0 ;

        foreach($scoreArr as $s)
        {
            if($best_time == 0 ){
                $best_time = $s['time']+1;
            }
            
            if( $s['ans'] >= $ans_ok && $s['time'] < $best_time){
                $ans_ok = $s['ans'] ;
                $best_time = $s['time'] ;
                $winner = $s['id'];
            }
            
        }
        
        return $winner ;
        
    }

}

?>