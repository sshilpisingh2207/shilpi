
<!DOCTYPE html>
<html>
<head>
<title>chat</title>
<link type="text/css" rel="stylesheet" href="style.css" />
</head>



<?php
    
    //starting the session
    $user_name = "root";
    $password = "root";
    $database = "chat";
    $server = "127.0.0.1";
    
    //connecting to the database
    
    $db_handle=mysql_connect($server, $user_name, $password);
    $db_found = mysql_select_db($database, $db_handle);
    
    

    session_start();

    
    if(isset($_GET['logout']))
    {
        $fp = fopen("log.html", 'a');
        fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has left the 4chat session.</i><br></div>");
        fclose($fp);
        
        //on logout deleting the record of user from the database on redirecting the user to login page
        $usern=$_SESSION['name'];
        $passw=$_SESSION['password'];
        $no="no";
        
        $sql22=" DELETE FROM chat.profile  WHERE name='".$usern."'";
        $result22=mysql_query($sql22);
        mysql_close($db_handle);

        loginForm();
        echo nl2br( "\n");
        echo nl2br( "\n");
        

        echo '<span style="color:#ffffff;' . $usern .'">' . $usern. '</span>'; echo nl2br( "  ");

  echo'<span style="color:#ffffff;font size:40;text-align:center;">LOGGED OUT</span>' ;

        session_destroy();
         // header("Location: index.php"); //Redirect the user
        
        return 0;
    }
    
    //login form information
    
    function loginForm(){
        echo'
        <div id="loginform">
        <form action="index.php" method="post">
        <p>Please enter your name and password to continue:</p>
        
        <label for="name">Name:</label>
            <input type="text" name="name" id="name" />
            <label> password: </label>
            <input type="password" name="password" id="password">
            <input type="submit" name="enter" id="enter" value="Enter" />
            
            
            
            </form>
            </div>
            ';
            }
    
    
    
    if(isset($_POST['enter'])){
        if($_POST['name'] != "" && $_POST['password'] != "")
        {
            $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
            $_SESSION['password'] = stripslashes(htmlspecialchars($_POST['password']
           //storing the logged in user in sessions
                                                                  
                                                                  
                                                                  ));
            
        }
        else
        {
            echo '<span class="error">Please type in a name and password</span>';
        }
    }
    
    ?>




<?php
    
    if(!isset($_SESSION['name'])&& !isset($_SESSION['password']))
    {
        
        
        
        
        loginForm();
    }
    else{
        

        
        $i=0;$k=1;
        
        $no="no";
        $usern=$_SESSION['name'];
        $passw=$_SESSION['password'];
        $yes="yes";
        if ($db_found) {
            //if database is found we check if the user record exists and the session is yes which means the user is logged in so redirect the user to login page when trying to login from another browser
            
            $query = "SELECT * FROM chat.profile" ;
            $result1=mysql_query($query);
            
            $num_rows = mysql_num_rows($result1);
            
            while ( $db_field = mysql_fetch_assoc($result1) )
                
            {
                
                
                
                if( $usern=== $db_field['name'] &&  $yes===$db_field['session'])
                {
                    loginForm();
                    
                    echo nl2br( "\n");
                    echo nl2br( "\n");echo nl2br( "\n");
                    echo nl2br( "\n");
                    echo'<span style="color:#ffffff;font size:40;text-align:center;"> "YOU ARE ALLREADY SIGNED IN FROM ANOTHER BROWSER"</span>' ;
                    return 0;
                    break;
                    
                }
                
                $i++;
                
                
            }
            
            
            
            
            
            
            
            //if the value of i is equal to number of rows which means the whole database table was checked and the user not found so we insert the user ecord in databse and let the user login
            
            if($i===$num_rows )
                
            {
                $SQL = "INSERT INTO chat.profile (name, password, session) VALUES ('$usern','$passw', 'yes')";
                
                $result = mysql_query($SQL);
                
                mysql_close($db_handle);
                
                $i=0;
                
            }
            
            
        }
        
        
        
        
        ?>

//after login you see this page of user logged in and friends online

<div id="wrapper">
<div id="menu">
<p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
<label for="name1">how are you doing?:</label>
<input type="text" name="name1" id="name1" value="<?php echo $_SESSION['name'];?>"  />
<br><br><br><br>
<label for="addfriend1">please enter friend name to add:</label>

<input type="text" name="addfirend1" id="addfriend1"   />
<button id="addfriend">add friend</button>
<p class="logout"><a id="exit" href="#">Exit Chat</a></p>
<div style="clear:both"></div>
<ul id="friendlist"><li id="friend1">friend1</li> <br><li id="friend2">friend2</li><br/><li id="friend3">friend3</li> <br/><li id="friend4">friend4</li></ul>
</div>
<div id="friendstatus"></div>
</div>



<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js">
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">



$(document).ready(function(){
                  
                  var username; var usr;var filename;
                  
                  
                  
                  var usr = document.getElementById('name1').value;
                  
                  
                  
                  
                  $("#addfriend").click(function(){
                                   var addfriend=document.getElementById('addfriend1').value;
                                       $("#friendlist").append('<li>'+addfriend+'</li>');

                                   });
                  //document.getElementById('wrapper1').innerHTML += usr;
                  
                  
                  
                  $("#exit").click(function(){
                                   
                                   var exit = confirm("Are you sure you want to end the session?");
                                   if(exit==true)
                                   {
                                   
                                   window.location = 'index.php?logout=true';
                                   
                                   
                                   
                                   }
                                   });
                  
            //when click on send button it sends the message and post.php writes the contents in the respective log file
                  $('#wrapper').on('click', '#submitmsg', function(e){
                                   var clientmsg = $("#usermsg").val();
                                   $.post("post.php", {text: clientmsg, username:username});
                                   $("#usermsg").attr("value", "");
                                   
//                                        e.preventDefault();
                                   });
                  
                  setInterval(loadLog, 2500);
/*
 <div id="chatbox"></div>
 
 <form name="message" action="">
 <input name="usermsg" type="text" id="usermsg" size="63">
 <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
 </form>
 
 */
               
                  
              //whomsoever friend you click the chtbox os opened to talk to that friend ie friend1 friend 2 friend3 friend4
           
                  
                  $('li').click(function() {
                                
                              
                                if($('#chatbox'))
                                {
                                $('#chatbox').remove();
                                $('#usermsg').remove();
                                $('#submitmsg').remove();
                                $('#submitmsg').remove();

                                }
                                $('#wrapper').append('<div id="chatbox"></div>');
                                //                   $('#wrapper').append('<form name="message" action="">');
                                $('#wrapper').append('<input name="usermsg" type="text" id="usermsg" size="63" />');
                                $('#wrapper').append(' <input name="submitmsg" type="submit"  id="submitmsg" value="Send" />');
                                
                                username= $(this).text();
                                $('#talkingto').remove();
                                $('#wrapper').append('<li id =talkingto>you are now talking to '+username+'</li>')
                                //window.open("c","hello",  "height=200,width=200");
                                });
                  
                  
                  
                  
                  function loadLog(){
                  var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
    
                  var filename;
                  
                  
                  
            

      //this is for specifying the filename in which log will be stored when two people chat with each other
 //while logging in two browsers the login person name and friend name get interchanged respectively we chose this or condition so that the two users have common log file name

                  if((username==="friend2"  && usr==="friend1") || (username==="friend1" && usr==="friend2"))
                  {
                   filename= "filename12";
                 
                  
                  }
                  
                  
                  if((username=="friend1"  && usr=="friend3") || (username=="friend3"  && usr=="friend1"))
                  {

                   filename= "filename13";
                  
                  }
                  
                  
                  if((username=="friend1"  && usr=="friend4") || (username=="friend4"  && usr=="friend1"))
                  {
                  
                   filename= "filename14";
        
                  }
                  
                  
                  if((username=="friend2"  && usr=="friend3") || (username=="friend3" && usr=="friend2"))
                  {
                   filename= "filename23";
                  
                  
                  }
                  
                  
                  if((username=="friend2"  && usr=="friend4") || (username=="friend4"  && usr=="friend2"))
                  {
                  
                  
                  filename= "filename24";
                  
                  }
                  
                  
                  if((username=="friend3"  && usr=="friend4") || (username=="friend4"&& usr=="friend3"))
                  {
                  
                   filename= "filename34";
                  
                  
                  }
                  //we load the log file based on selected users and load in chatbox
                  $.ajax({ url: filename + ".html",
                         cache: false,
                         success: function(html){
                         $("#chatbox").html(html);
                         var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
                         if(newscrollHeight > oldscrollHeight)
                         {
                         $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal');
                         }
                         },
                         });
                  


                  
                  
                  }
                  });
</script>
<?php
    
    
    
    
    }
    
    
    ?>


</body>
</html>