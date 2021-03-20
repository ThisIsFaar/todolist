<?php

require "connect.php";

$sql = "SELECT * FROM list";
$stmt = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
	<title>To Do List</title>

	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="css/index.css">

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poiret+One&display=swap?family=Modak&display=swap" rel="stylesheet">

</head>
<body>

	<!-- Simple Text Navbar -->
	<nav class="navbar navbar-light p-0" id="NavBg">
	  <span class="navbar-brand text-white mx-auto p-0" id="NavHeading">To Do List</span>
	</nav>

	<div class="col-6 p-5 " id="LeftSideDiv">
		<!-- Add New Task Form -->
		<form action="AddTask.php" method="POST" id="AddTaskForm d-flex justify-content-center">
			<div class="form-group">
				<label id="AddTaskFormHeading" class="text-center" for="InputTask">MAKE YOUR LIST</label>
				<input type="text" name="about_task" class="form-control" id="InputTask"  placeholder="Type Your Tasks Here...">
				<?php if (isset($_GET['mess'])) {
					if ($_GET['mess'] == 'blank') {
						?>
						<div id="blank_message" class="alert alert-warning alert-dismissible fade show" role="alert">Task cannot be blank.
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>
						<?php
					} elseif ( $_GET['mess'] == 'success' ) {
						?><div id="success_message" class="alert alert-warning alert-dismissible fade show" role="alert">Successfully added.
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div><?php
					}
				} ?>
				<small class="d-block font-italic text-muted text-center">Live every day like it's your last</small>
			</div>
			<div class="mx-auto" id="AddTaskFormButtonId">
				<button id="AddTaskFormButton" type="submit" class="btn btn-primary mx-auto">Add Task</button>	
			</div>
			
		</form>
	</div>

	<!-- To Do list -->
	<div class="col-6 justify-content-center" id="RightSideDiv"  >
		
		<?php
		if ( $stmt->rowcount() <= 0 ) {
			?>
			<img style="width: 550px;height: 340px;" src="https://cdn2.hubspot.net/hubfs/2814970/Blog%20Media/Blog%20images/image001.gif">
			<p class="text-center" id="pheading">No list is created.So what are you waiting for?</p>
			<?php
		} else {
			$AllTask = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($AllTask as $Task) {
			?>
			<div class="card m-3 <?php if ( $Task['task_status'] ) { ?> TaskIsDone<?php }?>" >
			  <div class="row no-gutters" <?php if ( $Task['task_status'] ) { ?>id="<?php echo $Task['id']; ?>"<?php } ?>>
			    	<div class="col-md-1 d-inline-flex DoneTask" id ="<?php echo $Task['id']; ?>">
					      <img id="TaskImage" <?php if ( $Task['task_status'] ) { ?>src="img/done.svg"<?php } else { ?> src="img/notdone.svg" <?php } ?> class="card-img p-1" alt="...">
			    	</div>
			    <div class="col-md-11">
			      <div class="card-body">
			        <h5 class="card-title"><?php echo $Task['about_task']; ?></h5>
			        <p id="<?php echo $Task['id']; ?>" class="card-text float-right m-2 RemoveTask"><small class="text-muted"><img src="img/remove.svg"> </small></p>
			      </div>
			    </div>
			  </div>
			</div>
			<?php	
			}
		}
		?>
	</div>

	<footer class="footer">
      <div class="container">
        <span class="text-muted">Developed By Mohammad Farhan, ContactMail : Thisisfarhan99@gmail.com</span>
      </div>
    </footer>

	<!-- jQuery and Bootstrap Bundle (for Popper JS) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>	
    <script>
        $(document).ready(function(){
            $('.RemoveTask').click(function(){
                const id = $(this).attr('id');
                
                $.post("RemoveTask.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().parent().parent().hide(600);
                         }
                      }
                );
            });

            $(".DoneTask").click(function(e){
                const id = $(this).attr('id');
                var temp = id;
                $.post('DoneTask.php', 
                      {
                          id: id
                      },
                      (data) => {
                          if(data != 'error'){
                              const h2 = $(this).next();
                              if(data === '1'){
                                  h2.removeClass('TaskIsDone');
                              }else {
                                  h2.addClass('TaskIsDone');
                              }
                          }
                      }
                );
            });
        });
    </script>

</body>
</html>