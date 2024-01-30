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
            $this->id = $id_cat ;
            $this->table = "calendar_cat" ;
            $stmt2 = $this->showAllWhere('id',['id']) ;
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ;
            extract($row2) ;

            // check if isset the url in calendarSettings
            $url = $events['url'] ? $events['url'].$item['id'] : '' ;
            
            // set start date if set to true
            $start = '' ;
            $end = '' ;
            if($events['start'])
            {
                $start = $item['st'] ;
                $end = $item['et'] ;
            }
            else
            {
                $start = $item['et'] ;
                $end = $item['et'] ;
            }

            // check if there is an external table for the title
            $title = '' ;
            if( $events['title_table'] )
            {
                // get the record from the title_table
                $this->id = $item[''.$events['title_id'].''] ;
                $this->table = $events['title_table'] ;
                $stmt1 = $this->showAllWhere('id',['id']) ;
                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) ;
                extract($row1) ;
                $title = $row1[''.$events['title'].''] ;
            }
            else
            {
                $title = $row[''.$events['title'].''] ;
            }
            // create the event element
            $ev = array(
                'title'	          => $title,
                'color'           => ''.$row2['cat_color'].'',
                'url'             => $url,
                'start'           => $start,
                'end'             => $end
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