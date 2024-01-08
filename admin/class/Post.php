<?php 

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Post extends Common{

    public $title ;
    public $content ;
    public $limit ;
    public $author ;
    public $modified ;
    public $main_img ;
    public $gall ;
    public $category_id ;
    public $category_name ;
    public $post_link ;

    public function readMore()
    {
        $this->content = substr($this->content, 0, $this->limit) ;
        $this->content = substr($this->content, 0, strrpos($this->content, ' ')) ;
        $this->content = $this->content . "... <a href='$this->post_link?id=$this->id'>Read more -></a>" ;
        return $this->content ;
    }
    

}

?>