<?php

namespace vendor;

use app\controller\Session;

//make the display for all views !! all methods com controller calls this class to display any view

class Template
{
    protected $template_dir = __DIR__.'/resources/views/';    //views locations

    public function __construct($template_dir = null)
    {   
        //necessary replace because visibility(scope) of the project, to replace the folder /vendor with the correct
        if($template_dir == null)
        {
            $this->template_dir = str_replace("/vendor", "", $this->template_dir); 
        }else
        {
            $this->template_dir = $template_dir;
        }
         
    }

    //render the view and also include the $object with the results, and $object2 is another object with different results
    public function render($template_file,$object=null,$object2=null) 
    {   
        //check for session , since it uses class session
        $session = new Session();

        //include header file
        //include(__DIR__.'/resources/views/header');   //need to replace the /vendor 
        if (file_exists($this->template_dir.$template_file)) 
        {
            include $this->template_dir.$template_file;             //include view specific location
        } else 
        {
            die('Error '. $this->template_dir.$template_file);
        }
        //include footer file
        //include(__DIR__.'/resources/views/footer');   //need to replace the /vendor 
    }

    public function get_template_dir()
    {
        return $this->template_dir;
    }

}

?>