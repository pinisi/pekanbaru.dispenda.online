<?php

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tax Monitoring System | Dashboard </title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">	
<?php
include "navi.php";
?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>TAX MONITORING SYSTEM</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="main.php">Home</a>
                        </li>
                        <li class="active">
                            <strong>User</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
					<small>Didukung oleh</small>
                        <img alt="image" src="img/Logo-Bank-Riau-Kepri-transparent-bg.png" width='280' height='50' align='center'/>
                    </div>
                </div>
            </div>


            <div class="passwordBox animated fadeInDown">
            <div class="row">

                <div class="col-md-12">
                    <div class="ibox-content">

                        <h2 class="font-bold">Reset password</h2>

                        <p>
                            Reset your password with new one.
                        </p>

                        <div class="row">

                            <div class="col-lg-12">
                                <form role="form" id="form">
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Enter Your New Password" name="password" id="password">
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Retype" name="repassword" id="repassword">
                                    </div>
                                    <input type="hidden" class="form-control" placeholder="Retype" name="obj_id" id="obj_id" value="<?php echo $_SESSION['id'];?>">

                                    <button type="button" class="btn btn-primary block full-width m-b reset-button">Set new password</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="footer">
               
                <div>
                    <strong>Copyright</strong> LuxTax &copy; 2016
                </div>
            </div>


        </div>
        </div>

     <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

	    <!-- jQuery UI -->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jquery Validate -->
    <script src="js/plugins/validate/jquery.validate.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

	<script>
      $(document).ready(function() {

            $("#form").validate({
             rules: {
                 password: {
                    required: true
                 },
                 repassword: {
                    equalTo: "#password"
                 }
             }
            });        

            $('.reset-button').on('click', function (e) { 
                var postData = {
                        'password': $('#password').val(), 
                        'id': $("#obj_id").val(),
                        'oper': 'upassword'
                    };  

                if ( $("#form").valid() ) {
                    $.ajax({
                      method:'POST',
                      data: postData,
                      url:'crud_user.php',
                      success:function(data) {     
                        console.log(data);                    
                        alert('Action Succedeed.');

                      }
                    });                 
                }                    
            });
            

        });
    </script>    
	
	



</body>



</html>
