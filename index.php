<?php
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tax Monitoring System | Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
		<img alt="image" src="img/LogoKabupatenKarawang.png" width='120' height='140'/>

            <div>

      <h2>TAX MONITORING SYSTEM</h2>
<h3>KABUPATEN KARAWANG</h3>
            </div>
           BADAN PENDAPATAN DAERAH
            <br>
			<br>
            <p><small>Masukkan username dan password Anda</small></p>
            <form class="m-t" role="form" action="act_login.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="txtUser" name="txtUser" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" id="txtPassword" name="txtPassword" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
<br>
<br>
                <p>Didukung oleh:</p>
           <img alt="image" src="img/LOGOBANKBJB.png" width='220' height='60' align='center'/>
		  <br>
		  <br>
		  <br>
		  <br>
		  <p><strong>Copyright</strong> PT Pinisi Elektra	&copy; 2016</p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>



</html>
