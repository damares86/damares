<?php 

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Calendar extends Common{

    public $event_title ;
    public $page_origin ;

    public function updateCalendar(){

        // query sulla tabella degli eventi e ricreazione del json
        require_once '../inc/func/calendarSettings.php' ;
        $this->table = $calendar['table'];
        $events = $this->showAll('st') ; 

        /* STRUTTURA JSON
        - id
        - event_id
        - event_title
        - event_start_date
        - event_end_date
        - id_event_cat
        */

        $this->event_title = $calendar['title'];

        $events_arr = [] ;
        $idx = 0 ;
        
        foreach($events as $item)
        {

            $id_cat = $item['id_calendar_cat'] ?  $item['id_calendar_cat'] : 0 ;

            $ev = array(
                'id' 	          => $idx, 
                'event_id'		  => $item['id'],
                'event_title'	  => $item[''.$this->event_title.''],
                'event_start_date'=> $item['st'],
                'event_end_date'  => $item['et'],
                'id_event_cat'	  => $id_cat
            );
            
            $events_arr[] = $ev ;

            $idx++ ;

        }


        rename("../inc/calendar.json","../inc/calendar.json.bck");
        $file = "../inc/calendar.json" ;
        
        $json=json_encode($events_arr);
        
        $resp="";

        if(file_put_contents($file, $json, FILE_APPEND)){
            chmod($file,0777);
            unlink("../inc/calendar.json.bck");
            $resp = '&msg=calUp';
        }
        else 
        {
            rename("../inc/calendar.json.bck","../inc/calendar.json");
            $resp = '&err=calNotUp';
        }
        
        return $resp ;

    }

   
}

?>