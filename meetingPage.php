<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!--redirect to login page if user did not login-->
<?php
	session_start();
	if(!isset($_SESSION["user_id"])) {
		header("Location:login.php");
	} 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="js/google-chart.js"></script>
        <script src='js/jquery-1.10.2.min.js'></script>
        <script src='js/timer.js'></script>
        
        <!--redirect to specific page depending on what user clicked-->
        <script>
            function redirect1(id){
                var link = "php/votingRelated/createVotingPopup.php?meetingId=" + id ;
                window.open(link, "createVoting", "height=450,width=600");  
            }

            function redirect2(id){
                var link = "votingPage.php?votingId=" + id ;
                window.open(link, "vote", "height=450,width=600");  
            }
        </script>		
	    <!-- default css -->
        <link rel="stylesheet" media="all" type="text/css" href="css/s.css" />
        <!-- Bootstrap -->
        <link href="css/b.min.css" rel="stylesheet">
		<style type="text/css">
            #meeting{
                margin: 150px auto;
            }
			.section {
			    width:500px;
			    float:left;
			    padding:25px;
                margin-right: 20px;         
                border-style: solid;
                background-color: white	 	 
			}
			#sortable{
				list-style-type: none;
				padding:0px;
				margin:0px;
			}
			.resizable{
				padding:10px;
				background: #16a085;
				margin:5px;
				color:white;
				font-weight: bold;
				cursor:pointer;
			}
			#timeleft {
			    display:block;
			    margin-right: auto;
			    margin-left: auto;
			    margin-top: 30px;
			    height: 30px;
			    font-size: 20px; 
                text-align:center;	 
			}
			#footer {
			    background-color:black;
			    color:white;
			    clear:both;
			    text-align:center;
			   padding:5px;	 	 
			}
			.modal-title{
				color:black;
			}
		</style>
		<?php
			session_start();
			/*this function returns end date by using duration and start date*/
			function endDate($date, $duration){
				$startSec = strtotime($date);
				$durSec = explode(":", $duration);
				$sec =  (intval($durSec[0]) * 3600) + (intval($durSec[1]) * 60) + intval($durSec[2]);
				$temp = intval($startSec) + $sec;
				$date = new DateTime("@$temp");
				$end = date('Y-m-d H:i:s', strval($temp));
				return $date->format('Y-m-d H:i:s');
			}
			
	  		/*initial connection to database*/
			$host="localhost"; // Host name 
			$username='root'; // Mysql username 
			$password='Menu6Rainy*guilt'; // Mysql password 
			$db_name='meetrix_database'; // Database name 
			$tbl_name='meeting'; // Table name 
			$pdo = new PDO("mysql: host=$host; dbname=$db_name", "$username", "$password");
			$meetingId = $_GET['meetingId'];
			
			/*get meeting from meeting id*/
			$st1 = $pdo->query("SELECT *
							FROM `meeting`
							INNER JOIN `room` ON `meeting`.room_id=`room`.room_id
							INNER JOIN `employee` ON `meeting`.creator_id=`employee`.employee_id
							INNER JOIN `department` ON `meeting`.department_id=`department`.department_id
							WHERE `meeting`.meeting_id=". $meetingId . ";");
			
			/*get groups involving in meeting using meeting id*/			
			$st2 = $pdo->query("SELECT `group`.group_name
							FROM `group`
							INNER JOIN `meeting_group` ON `group`.group_id=`meeting_group`.group_id
							INNER JOIN `meeting` ON `meeting_group`.meeting_id=`meeting`.meeting_id
							WHERE `meeting`.meeting_id=". $meetingId . ";");
			
			/*get all voting information by meeting id*/
			$st3 = $pdo->query("SELECT `votes`.vote_id, `votes`.title
							FROM `meeting`
							INNER JOIN `votes_meeting` ON `meeting`.meeting_id=`votes_meeting`.meeting_id
							INNER JOIN `votes` ON `votes_meeting`.vote_id=`votes`.vote_id
							WHERE `meeting`.meeting_id=". $meetingId . ";");
			
			$posts = $st1->fetchAll();
			$posts2 = $st2->fetchAll();
			$posts3 = $st3->fetchAll();
			
			$end = endDate($posts[0]['date'], $posts[0]['duration']);
			date_default_timezone_set('Australia/Brisbane');
			$current = date('Y-m-d H:i:s');
  		?>		
		<script>
			/*start timer*/
	  		$(document).ready(function(){
	  			timer('<?php echo $current;?>', '<?php echo $end;?>');
	  		})
  		</script>
	</head>
	
	<body onload="count" style="height: 478px">
        <!--sidebar and content-->
        <div id="wrapper">
             <!--sidebar-->
            <div id="sidebar-wrapper">
                <!--logo-->
                <div class="navbar-header">
                    <a class="navbar-brand" href="#"><img src="img/logo.jpg" ></a>
                </div>
                <ul class="sidebar-nav">                                      
                    
                </ul>
            </div>
            <!--content-->
            <div id="page-content-wrapper">
                <!--top nav bar-->
                <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                    <div class="container">
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav left">
                                <h3>WELCOME TO <span style="color:green">MEETRIX</span></h3>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="index.php">HOME</a>
                                </li>
                                <li>
                                    <a href="#">HELP</a>
                                </li>
                                <?php
                                    if(isset($_SESSION["user_id"])) {
                                        echo "<li><a href=\"php/logout.php\">LOGOUT</a></li>";
                                        //echo "<button type='button' class='account_nav' onclick='location.href = \"php/logout.php\";'>Logout</button>";
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!--Main contents comes in side here please edit or enter contents in here-->
                <div id="main" style="width:1100px; background-color:inherit; border-style: none; margin:100px auto">
                <h1 style="height: 33px; text-align:center; font-weight:bold"><?php echo $posts[0]['name'];?></h1>
        <div id="timeleft">
            Time Left: 00:00:00
        </div>
        <hr>
        <div class="section">
            <button type="button" id="createAgenda">Add an agenda</button>
            <!--Display Agenda-->
            <ul id="sortable">
                <?php
                    $con = mysqli_connect("localhost","root","Menu6Rainy*guilt","meetrix_database"); 
                    $result = mysqli_query($con,"select * from agenda where meeting_id=$meetingId order by `agenda_order`");
                    while($row=mysqli_fetch_array($result)){
                        $order=$row['agenda_order'];
                        $title=$row['title'];
                        $value=$row['content'];
                        $duration=$row['duration'] * 10;
                        $agenda_time = $row['duration'];
                        $agenda_item=$row['id'];
                        echo "<li class='".$meetingId."' data-id='".$agenda_item."'>";
                        echo "<div style=\"display:block; height:".$duration."px;\" class=\"resizable\">";
                        echo "<button type=\"button\" class=\"close delete\">";
                        echo "<span aria-hidden=\"true\">&times;</span>";
                        echo "<span class=\"sr-only\">Close</span></button>";
                        echo "<h4 data-toggle=\"modal\" data-target=\"#title".$agenda_item."\" class=\"agendaTitle\">".$title."</h4>";
                        echo "<p style=\"margin:0 0 0px\" class=\"agendaTime\">(Approx. time: ".$agenda_time."min)</p>";
                        echo "<div class=\"modal fade\" id=\"title".$agenda_item."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">";
                        echo "<div class=\"modal-dialog\">";
                        echo "<div class=\"modal-content\">";
                        echo "<div class=\"modal-header\">";
                        echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>";
                        echo "<h4 class=\"modal-title\" id=\"myModalLabel\">Change the title of the agenda</h4>";
                        echo "</div>";
                        echo "<div class=\"modal-body\">";
                        echo "<textarea class=\"form-control\" id=\"changeTitle".$agenda_item."\" rows=\"3\">".$title."</textarea>";
                        echo "</div>";
                        echo "<div class=\"modal-footer\">";
                        echo "<button type=\"button\" class=\"btn btn-default exitTitle\" data-dismiss=\"modal\">Close</button>";
                        echo "<button type=\"button\" class=\"btn btn-primary saveAgendaTitle\" data-dismiss=\"modal\">Save changes</button>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "<p data-toggle=\"modal\" data-target=\"#content".$agenda_item."\" class=\"agendaContent\">".$value."</p>";
                        echo "<div class=\"modal fade\" id=\"content".$agenda_item."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">";
                        echo "<div class=\"modal-dialog\">";
                        echo "<div class=\"modal-content\">";
                        echo "<div class=\"modal-header\">";
                        echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>";
                        echo "<h4 class=\"modal-title\" id=\"myModalLabel\">Change the content of the agenda</h4>";
                        echo "</div>";
                        echo "<div class=\"modal-body\">";
                        echo "<textarea class=\"form-control\" id=\"changeContent".$agenda_item."\" rows=\"3\">".$value."</textarea>";
                        echo "</div>";
                        echo "<div class=\"modal-footer\">";
                        echo "<button type=\"button\" class=\"btn btn-default exitContent\" data-dismiss=\"modal\">Close</button>";
                        echo "<button type=\"button\" class=\"btn btn-primary saveAgendaContent\" data-dismiss=\"modal\">Save changes</button>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</li>";
                    }
                     
                ?>
            </ul>
        </div>
        <div class="section">
        	<!--Display all meeting information and voting that was created-->
            <?php
                echo "<table>";
                    echo "<tr>";
                        echo "<td><label for='meeting_title'>Meeting ID: </label></td>";
                        echo "<td>". $posts[0]['meeting_id'] ."</td>";
                    echo "</tr>";
                    
                    echo "<tr>";
                        echo "<td><label for='department'>Department: </label></td>";
                        echo "<td>". $posts[0]['department_name'] ."</td>";
                    echo "</tr>";
                    
                    echo "<tr>";
                        echo "<td><label>Supervisor: </label></td>";
                        echo "<td>". $posts[0]['first_name']. " ". $posts[0]['last_name'] . "</td>";
                    echo "</tr>";
                    
                    echo "<tr>";
                        echo "<td><label>Start: </label></td>";
                        echo "<td>". $posts[0]['date'] ."</td>";
                    echo "</tr>";
                    
                    echo "<tr>";
                        echo "<td><label>Duration: </label></td>";
                        echo "<td>". $posts[0]['duration'] ."</td>";
                    echo "<tr>";
                    
                    echo "<tr>";
                        echo "<td><label>End: </label></td>";
                        echo "<td>". $end ."</td>";
                    echo "<tr>";
                    
                    echo "<tr>";
                        echo "<td><label>Description: </label></td>";
                        echo "<td>". $posts[0]['description'] ."</td>";
                    echo "</tr>";
                    
                    echo "<tr>";
                        echo "<td><label>Group: </label></td>";
                        echo "<td>";
                        
                        foreach($posts2 as $post){
                            echo "<li>". $post['group_name']."</li>";
                        }
                        echo "</td>";
                    echo "</tr>";
                    
                    echo "<tr>";
                        echo "<td><label>Room: </label></td>";
                        echo "<td>". $posts[0]['room_name'] ."</td>";
                    echo "</tr>";
                echo "</table>";
            ?>
            <?php
            	/*show all the voting that meeting have*/
                $votingNum = 1;
                
                foreach($posts3 as $post){
                    echo "Voting ". $votingNum .": ";
                    echo "<span style='cursor:pointer; color:blue; text-decoration: underline' onclick='redirect2("; 
                    echo $post['vote_id'];
                    echo ")'>";
                    echo $post['title'];
                    echo "</span>";
                    echo "<br/>";
                    $votingNum++;
                }
            ?>
            <br />
            <input id="Button1" type="button" onclick= "redirect1(<?php echo $posts[0]['meeting_id']; ?>)" value="Create New Vote" /><br />
        </div>
        </div>

            
                <!--Main contents ends here-->
            <!--end of content-->
            </div>
        <!--end of sidebar and content-->            
        </div>
  		
		<!-- jQuery-->    
	    <script src="http://code.jquery.com/jquery-2.1.1-rc2.min.js"></script>
	    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
	    <script type="text/javascript">var meetingId = <?php echo $meetingId; ?>;</script>
	    <!--Sortable-->
	    <script src="js/sortable.js"></script>
	    <link rel="stylesheet" href="css/jquery-ui.css">
	    <!--Resizable-->
	    <script src="js/resizable.js"></script>
		<!--Update/Add agenda content-->
		<script src="js/addAgendaContent.js"></script>
		<!--Edit Agenda content-->
		<script src="js/changeAgenda.js"></script>
		<!--Delete Agenda-->
		<script src="js/deleteAgenda.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>	
	</body>
	
</html>
