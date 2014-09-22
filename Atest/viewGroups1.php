<!DOCTYPE html>
<html>
	<?php 
		if(strpos($_SERVER['HTTP_USER_AGENT'], "iPhone") || strpos($_SERVER['HTTP_USER_AGENT'], "Android")){
			header( 'Location: sp/index.php' ) ;
		}
	?>
	<head>
		<!--Load the AJAX API-->
    	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    	<script type="text/javascript" src="js/google-chart.js"></script>
    	<script type="text/javascript">
      		// Load the Visualization API and the piechart package.
      		google.load('visualization', '1.0', {'packages':['corechart']});

      		// Set a callback to run when the Google Visualization API is loaded.
      		google.setOnLoadCallback(drawChart_at_home);
      	</script>
   		<meta charset="utf-8">
    	<!-- default css -->
    	<link rel="stylesheet" media="all" type="text/css" href="css/style.css" />
    	<!-- tablest css -->
    	<link rel="stylesheet" media="all" type="text/css" href="css/tablet.css" />
		<!-- accordion css -->
    	<link rel="stylesheet" media="all" type="text/css" href="css/accordion.css" />
    	<!-- smartphones css -->
    	<link rel="stylesheet" media="all" type="text/css" href="css/smart.css" />
    	<title>Meetrix "Meeting Management System"</title>
    	<!-- Bootstrap -->
    	<link href="css/bootstrap.min.css" rel="stylesheet">
    	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    	<!--[if lt IE 9]>
      		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    	<![endif]-->
  	</head>
	<body onload="drawChart_at_home()">
		<!--Header on top of the page where all user account setting navigation should be done-->
		<div id ="profile_header">
			<!-- Meetrix typography div-->
			<div id="app_name"> 
				<a class="name" href="#">Meetrix</a>
			</div>
			<!--Account navigation bars-->
			<div id="account_nav">
				<ul class="account_nav">
					<li class="account_nav"><a href="#" class="account">Profile</a></li>
					<li class="account_nav"><a href="#" class="account">Setting</a></li>
					<li class="account_nav"><a href="#" class="account">Help</a></li>
				<ul>
			</div>
		</div>
		<!--main contents comes inside here-->
		<div id ="contents">
			<!--left side of the contents such as icon and navigation bar-->
			<div id ="left">
				<!--icon img-->
				<div id="icon">
					<img class="logo" src="img/testlogo2.png"/>
				</div>
				<!--navigation bars-->
				<div id="navigation">
					<ul class="navigation">
						<li class="navigation"><p class="nav_man">Meetings</p></li>
							<ul class="sub_navigation">
								<li class="sub_navigation"><p class="sub_nav_man"><a href="viewMeeting.php">View Meetings</a></p></li>
								<li class="sub_navigation"><p class="sub_nav_man"><a href="createMeeting.php">Create Meeting</a></p></li>
								<li class="sub_navigation"><p class="sub_nav_man">Delete Meeting</p></li>
							</ul>
						<li class="navigation"><p class="nav_man">Groups</p></li>
							<ul class="sub_navigation">
								<li class="sub_navigation"><p class="sub_nav_man">View Groups</p></li>
								<li class="sub_navigation"><p class="sub_nav_man"><a href="createGroup.php">Create Group</a></p></li>
								<li class="sub_navigation"><p class="sub_nav_man">Delete Group</p></li>
							</ul>
					</ul>
				</div>
			</div>
					
					
					 <!--start of accordion-->
	
                 <!--end of accordion-->
                 <div id="main">
		 <div class="accordion vertical">
    <ul>		 
		<?php            
            $mysqlserver="localhost";
            $mysqlusername="root";
            $mysqlpassword="Menu6Rainy*guilt";
            $link=mysql_connect(localhost, $mysqlusername, $mysqlpassword) or die ("Error connecting to mysql server: ".mysql_error());
            $int = 1;
            $dbname = 'meetrix_database';
            mysql_select_db($dbname, $link) or die ("Error selecting specified database on mysql server: ".mysql_error());
            
            $cdquery="SELECT * FROM `group`";
            $cdresult=mysql_query($cdquery) or die ("Query to get data from firsttable failed: ".mysql_error());
            
            while ($cdrow=mysql_fetch_array($cdresult)) {
              $Title=$cdrow["group_name"];
              $Supervisor=$cdrow["supervisor_id"];
			  $Employee=$cdrow["employee_id"];
			  $Email=$cdrow["supervisor_id"];
			  $Description=$cdrow["description"];
			  

			echo "<li>";
           echo "<input type=\"radio\" id=$int name=\"radio-accordion\">";
            echo "<label for=$int>$Title</label>";
            echo "<div class=\"content\">";
			echo "<h3>Department: Information Technology </h3>";
			echo "<p>Employees: John,Joseph,Mary,Gerald</p>";
			echo "<p>Description: This is Group 5 of the IT department. This group aims to resolve issues of the company's system </p>";
			echo "</div>";
			echo "</li>";
			$int = $int +1;
			  
            }
                
          ?>
		  </ul>
		  </div>
				 
				</div> 
               </div>
	</body>
</html>