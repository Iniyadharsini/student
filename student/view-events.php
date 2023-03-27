<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();
include('include/functions.php');
//  include('include/sidebar.php'); 

    $eventname=$organizer=$type=$description=$fromdate=$todate=$file=$file_loc=$final_file=$msg="";
    $sql="SELECT * FROM events";
    $result=mysqli_query($con,$sql);
    $count=$result->num_rows;
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(isset($_POST['submit'])){
            $eventname=test_input($_POST["eventname"]);
            $organizer=test_input($_POST["organizer"]);
            $event_type=test_input($_POST["event-type"]);
            $type=test_input($_POST["type"]);
            // $description=test_input($_POST["description"]);
            $fromdate=test_input($_POST["fromdate"]);
            $todate=test_input($_POST["todate"]);
            if(isset($_FILES['submit'])){}            
            $file=$_FILES['file']['name'];
            $file_loc=$_FILES['file']['tmp_name'];
            $folder="./uploaded_certificates/";
            // making file name in lowercase
            $new_file_name=strtolower($file);
            $final_file=str_replace(' ','-',$new_file_name);
            if(move_uploaded_file($file_loc,$folder.$final_file)){
                $query = "INSERT INTO events(id, eventname, organizer, event_type,  e_type,  fromdate, todate, file_name) VALUES (Null, '$eventname', '$organizer','$event_type', '$type', '$fromdate', '$todate', '$final_file')";
                if(mysqli_query($con,$query)){
                    $msg="Event Added Successfully!";
                }
                else{
                    echo "error";
                }
            }
        }
        /*
        if(isset($_POST['delete'])){
            $eventid=test_input($_POST["eventid"]);
            $sql="DELETE from events where id='$eventid'";
            if(mysqli_query($con,$sql)){
                $msg="Event Deleted Successfully!";
            };
        }*/
    }
    function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
     
   } 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
   <link rel="stylesheet" type="text/css" href="./assets/css/style_events.css" />
    <!-- <link rel="stylesheet" type="text/css" href="./assests/css/styles.css"> -->
</head>
<body>
    <div class="bg-modal">
            <div class="modal-content">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                    <span class="close">&times;</span>
                    Event ID                   <input type="text" placeholder="Enter event ID" name="eventid" autocomplete="off"  required>
                <center><button type="submit" class="delbtn" name="delete" value="delete">DELETE</button>
            </form>
        </div>
    </div> 
    <div class="bg-modal1">
        <div class="modal-content1">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" enctype="multipart/form-data" method="post">
            <span class="close1" onclick="close1()">&times;</span>
            <center><h2>Add Events</h1></center>
            Event Name
            <input type="text" placeholder="Enter event name" name="eventname" autocomplete="off"  required><br>
            Organizer/Institution name <br>
            <input type="text" placeholder="Enter organizer name" name="organizer"  autocomplete="off"  required><br>
            <input type="radio" id="event-type" name="event-type" value="inter-college">INTER-COLLEGE   &nbsp&nbsp&nbsp&nbsp
            <input type="radio" id="event-type" name="event-type" value="intra-college">INTRA-COLLEGE
            <br>
            Event Type 
            <select name="type" id="type" required>
                <option value="" disabled selected>Select type</option>
                <option value="hackathon">Hackathon</option>
                <option value="webinar">Webinar</option>
                <option value="Quiz">Quiz</option> 
                <option value="seminar">Seminar</option>
                <option value="Other">Other</option>
            </select>       
            <!-- <br>
            If other, please mention here<br>
            <input type="text" placeholder="" name="type"  autocomplete="off"  > -->
            <br>                                                       
            From &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTo&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <input type="date" name="fromdate" required>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            <input type="date" name="todate"  required><br>
            Upload Certificate
            <input type="file"  name="file" required>
            <button type="submit" class="add-btn" name="submit" value="submit">ADD</button>
        </form>
        </div>
    </div>
    <div class="adminmain">
        <div class="head">
            ADD EVENTS
        </div>
        <button class="open-button" id="addbtn" onclick="add()">Add Events</button>
        <br><br>
        <div class="head">
            UPCOMING EVENTS
        </div>
        <div class="message">
            <?php
                if($msg!=""){
                    echo $msg;
                }
            ?>
        </div>
        <table class="tablecontainer" id="table" border=black width=90% height=60%>
            <div class="tableheader">
                <tr>
                <th>ID</th>
                <th>EVENT NAME</th>
                <th>ORGANIZER / INSTITUTION NAME </th>
                <th> INTRA / INTER COLLEGE </th>
                <th>EVENT TYPE </th>
                <th>FROM DATE&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                <th>TO DATE&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                <th>CERTIFICATE&nbsp&nbsp</th>
                </tr>
            </div>            
            <?php
                while($count>0){
                    $row=mysqli_fetch_array($result);
                    echo "<tr><td>".$row["id"]."</td><td>".$row["eventname"]."</td><td>".$row["organizer"]."</td><td>".$row["event_type"]."</td><td>".$row["e_type"]."</td><td>".$row["fromdate"]."</td><td>".$row["todate"]."</td><td><a href='./uploaded_certificates/".$row["file_name"]."' target='_blank'>VIEW</a></td></tr>";
                    $count=$count-1;
                }            
            ?>
        </table>  
        <br><br>      
    </div> 
    <script>
        function add(){
            document.querySelector('.bg-modal1').style.display='flex';
        }
        function del(){
            document.querySelector('.bg-modal').style.display='flex';
        }
        function close1(){
            document.querySelector('.bg-modal1').style.display="none";
        }
        function close(){
            document.querySelector('.bg-modal').style.display="none";
        }
    </script>
    
</body>
</html>
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>