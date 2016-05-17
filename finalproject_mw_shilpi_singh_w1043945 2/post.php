<?php
    session_start();
    if(isset($_SESSION['name'])){
        $text = $_POST['text'];
        $username = $_POST['username'];
        $user=$_SESSION['name'];
        

        //this file based on selected values of users creates a filename and then write the contents in the logfile for the pair of users

        
        if(($username=="friend1"  && $user=="friend2") || ($username=="friend2" && $user=="friend1"))
        {
            
          
            $filename= "filename12";
            
        }
        
        
        if(($username=="friend1"  && $user=="friend3") || ($username=="friend3" && $user=="friend1"))
        {
            
            
            $filename= "filename13";
            
        }
        
        
        if(($username=="friend1"  && $user=="friend4" || $username=="friend4" && $user=="friend1"))
        {
            
           
            $filename= "filename14";
            
        }
        
        
        if(($username=="friend2"  && $user=="friend3" || $username=="friend3" && $user=="friend2"))
        {
            $filename= "filename23";
            
        }
        
        
        if(($username=="friend2"  && $user=="friend4") || ($username=="friend4" && $user=="friend2"))
        {
            $filename= "filename24";
            
        }
        
        
        if(($username=="friend3"  && $user=="friend4") || ($username=="friend4" && $user=="friend3"))
        {
            $filename= "filename34";
            
        }

        
        
        $fp = fopen($filename. '.html', 'a');
        fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
        fclose($fp);
    }
    ?>