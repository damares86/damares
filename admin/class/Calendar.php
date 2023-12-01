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

        require_once '../inc/func/calendarSettings.php' ;

        $this->table = $calendar['table'];
        $events = $this->showAll('st') ; 

        $events_arr = [] ;
        
        foreach($events as $item)
        {
            // check calendar category for color
            $id_cat = $item['id_calendar_cat'] ?  $item['id_calendar_cat'] : 0 ;
            
            // check if isset the url in calendarSettings
            $url = $calendar['url'] ? ",\n'url' => ".$calendar['url'].$item['id']."" : '' ;

            // create the event element
            $ev = array(
                'title'	        => $item[''.$this->event_title.''],
                'start'         => $item['st'],
                'end'           => $item['et'],
                'id_event_cat'	=> $id_cat.$url
            );
            
            $events_arr[] = $ev ;

            $idx++ ;

        }

        // create a backup of the existing calendar.json
        rename("../inc/calendar.json","../inc/calendar.json.bck");

        $file = "../inc/calendar.json" ;
        
        $json=json_encode($events_arr);
        
        $resp="";

        if(file_put_contents($file, $json, FILE_APPEND)){
            // if creates the new file, delete the backup and resp success
            chmod($file,0777);
            unlink("../inc/calendar.json.bck");
            $resp = '&msg=calUp';
        }
        else 
        {
            // if doesn't creates the new file, change back the name to the backup file and resp error
            rename("../inc/calendar.json.bck","../inc/calendar.json");
            $resp = '&err=calNotUp';
        }
        
        return $resp ;

    }

    // mng calendar?

   
}

?>