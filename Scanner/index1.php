<?php session_start(); ?>
<?php include 'header.php'; ?>
<style>
video{
  position:relative;
   width:480px;
   height:360px;
  margin: 2rem;
  /* transform: translateX(-80%);
  z-index:-1; */
}
.camera_container{
  position: relative;
}
.camera_container:before{
  content:attr(data-attach);
  position:absolute;
  top:0;
  left:0;
  padding:10px;
  font-size: 2.5rem;
  background-color:10px;
  text-transform:capitalize;
  font-weight:bold;
  color: white;
  background: rgba(0,0,0,0.5)
}
.img_result,img{
  visibility: hidden; 
  position: absolute;
  pointer-events:none;
}
</style>
<!-- <style> 
    body { text-align: center; } 
</style>  -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <!-- <link rel="stylesheet" type="text/css" href="./indexstyle.css"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js" rel="nofollow"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script src="captureImage.js" defer></script>
</head>
<body class="hold-transition login-page">
<!-- <div class="login-box">
  	<div class="login-logo">
  		<p id="date"></p><p id="time" class="bold"></p>
  	</div>
    <div class="login-logo-pic">
     <img src="images/QCU_Logo_2019.png" alt="QCU">
     <h2 style="color:blue"> Q </h2>
     <h2 style="color:yellow; margin-top:-43px; margin-left: -250px;">C</h2>
     <h2 style="color:red; margin-top:-43px; margin-left: -225px;"> U </h2>
    </div> -->
    
 

<script type="text/javascript">

    let video = document.querySelector('#scanner_camera')

    function toTextBox(qrID)
    {
      // var myelement = 
      // var test = document.getElementById("faculty").value;
      document.getElementById("faculty").value = qrID.toString();
      document.getElementById("subbtn").click();
      //window.alert(test.toString()); 
    }
    var scanner = new Instascan.Scanner({ video:video, scanPeriod: 5, mirror: false });

    scanner.addListener('scan',function(content){
        console.log(content.toString());
        toTextBox(content.toString());
        //window.location.href=content;
    });

    // let camera_scanner = 0;
    // setInterval(() => {

    Instascan.Camera.getCameras().then(function (cameras){

        let scanner_camera = cameras.splice((cameras.length - 1),1)[0]; //(cameras.length - 1)
        cameras.unshift(scanner_camera)

        if(cameras.length > 0){
            scanner.start(cameras[0]);
            $('[name="options"]').on('change',function(){
                if($(this).val()== 0){
                    if(cameras[1]!=""){
                        scanner.start(cameras[0]);
                    }else{
                        alert('No Front camera found!');
                    }
                }
            });
        }else{
            console.error('No cameras found.');
            alert('No cameras found.');
        }
    }).catch(function(e){
        console.error(e);
        alert(e);
    });
    // }, 1000);

</script>

<body class="px-4" >

<div class="container-fluid d-grid justify-content-center align-item-center" style="height:100vh">
<div class="container p-4 text-center">
  <div class="row">
    <div class="col">
    <div class="login-title">
       <h3>COMPUTER BASED FACULTY MONITORING SYSTEM FOR QUEZON CITY UNIVERSITY</h3>
     </div>
 
    <div class="camera-container  d-grid justify-content-center">
      <video id="scanner_camera" autoplay></video>
     <div id="scanner_result_container" class="img_result" ></div>
     <p>"Good life starts here."</p>
    </div>
 
    </div>
   <div class="row justify-content-center">
   <div class="col-8">
    <form id="attendance">
    <div class="login-box-body">
    	<h4 class="login-box-msg">Enter QR Code</h4>
          <div class="form-group">
            <select class="form-control" name="status">
              <option value="in">Time In</option>
              <option value="out">Time Out</option>
            </select>
          </div>
      		<div class="form-group has-feedback">
        		<input type="password" class="form-control input-lg" id="faculty" name="faculty" required>
      		</div>
      		<div class="row">
    			<div class="col-xs-4"> 
          			<button type="submit" id="subbtn" class="btn btn-primary btn-block btn-flat" name="signin"><i class="fa fa-sign-in"></i> Submit</button>
              </div>
      		</div>
          
    	</form>
  	</div>

		<div class="alert alert-success alert-dismissible mt30 text-center"  id="snapShot_container" style="display:none;position:absolute;z-index:5;bottom:10%"> <!-- style="display:none;position:absolute;z-index:5;bottom:10%"-->
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <span class="result"><i class="icon fa fa-check"></i> <span class="message"></span></span>
      <button type="button" id="snapShot" class="btn btn-primary"> Take a selfie </button>
    </div>
		<div class="alert alert-danger alert-dismissible text-center" style="display:none;position:absolute;z-index:5;bottom:10%">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <span class="result"><i class="icon fa fa-warning"></i> <span class="message"></span></span>
    </div>
    </div>
   </div>
  </div>
</div>
  <div class="container p-4 d-flex flex-wrap camera_list">

  </div>
</div>

	<script type="text/javascript">
		// let scanner = new Instacan.scanner({video:  document.getElementById('scanner_camera')});
    // let i = 0;
    // setInterval(() => {
    //   Instascan.Camera.getCameras().then(function(cameras){
    //   let scanner_camera = cameras.splice((cameras.length - 1),1)[0]; //instascan index (cameras.length - 1)
    //   cameras.unshift(scanner_camera)

		// 	if(cameras.length>0)
		// 	{
		// 		scanner.start(cameras[0]);
		// 	}
		// 	else
		// 	{
		// 		alert("no camera Found");
		// 	}

    //   scanner.addListener('scan',function(c){
		// 	document.getElementById("text").value = c;
		//   });
    //   }).catch(function(e)
		// {
		// 	console.error(e);
		// });

    // }, 1000);

	</script>
  
 </body>

	
<script type="text/javascript">

$(function() {
  var interval = setInterval(function() {
    var momentNow = moment();
    $('#date').html(momentNow.format('MMMM DD, YYYY'));  
    $('#time').html(' | ' + momentNow.format('hh:mm:ss A'));
  }, 100);

  $('#attendance').submit(function(e){
    e.preventDefault();
    var attendance = $(this).serialize();

    $.ajax({
      type: 'POST',
      url: 'attendance.php',
      data: attendance,
      dataType: 'json',
      success: function(response){
        if(response.error){
          $('.alert').hide();
          $('.alert-danger').show();
          $('.message').html(response.message);
        }
        else{
          $('.alert').hide();
          $('.alert-success').show();
          $('.message').html(response.message);
          $('#faculty').val('');
        }
      }
    });
  });
});


</script>


<script>
$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'attendance_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#datepicker_edit').val(response.date);
      $('#attendance_date').html(response.date);
      $('#edit_time_in').val(response.time_in);
      $('#edit_time_out').val(response.time_out);
      $('#attid').val(response.attid);
      $('#faculty_name').html(response.faculty_firstname+' '+response.faculty_lastname);
      $('#del_attid').val(response.attid);
      $('#del_faculty_name').html(response.faculty_firstname+' '+response.faculty_lastname);
    }
  });
}
</script>


</body>
</html>