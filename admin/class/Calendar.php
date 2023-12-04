<?php 

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Calendar extends Common{

    public $table = "calendar_cat" ;
    public $event_title ;
    public $page_origin ;
    public $cat_id ;
    public $cat_name ;
    public $cat_color ;

    public function updateCalendar(){

        require_once '../inc/func/calendarSettings.php' ;

        $this->table = $events['table'];
        $allEvents = $this->showAll('st') ; 

        $events_arr = [] ;
        
        foreach($allEvents as $item)
        {
            // check calendar category for color
            $id_cat = $item['id_calendar_cat'] ?  $item['id_calendar_cat'] : 1 ;
            $stmt = $this->showAllWhere('id',['id']) ;
            $row = $stmt->fetch(PDO::FETCH_ASSOC) ;
            extract($row) ;
            
            // check if isset the url in calendarSettings
            $url = $events['url'] ? ",\n'url' => ".$events['url'].$item['id']."" : '' ;

            // create the event element
            $ev = array(
                'title'	          => $item[''.$evnts['title'].''],
                'start'           => $item['st'],
                'end'             => $item['et'],
                'color'           => $row['cat_color'].$url
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