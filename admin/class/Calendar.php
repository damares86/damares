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

        if(copy('../inc/calendar.json', '../inc/calendar.json.bck'))
        {

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

        } 
        else 
        {
            header("Location: ../index.php?p=".$this->page_origin."&err=calNotUp");
            exit;
        }
        

    }

   
}

?>