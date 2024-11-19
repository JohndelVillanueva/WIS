<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>WIS Internet Voucher Kiosk</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<section class="main-content">
		<div class="container">
			<form method="post" action="voucher.php">
				<div class="row">
					<div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6">
						<div class="profile-card card rounded-lg shadow p-4 p-xl-5 mb-4 text-center position-relative overflow-hidden">
							<img src="img/logo.png" alt="" class="mx-auto mb-3">
							<h3 class="mb-4">Westfields International School</h3>
							<h4 class="mb-4">Internet Voucher Kiosk</h4>
							<div class="text-left mb-4">
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></div>
									</div>
									<input type="text" name="name" class="form-control form-control-lg" id="inlineFormInputGroup" tabindex="0" autofocus placeholder="Full Name">
								</div><br>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="fa fa-users" aria-hidden="true"></i></div>
									</div>
									<select name="type" class="form-control form-control-lg">
										<option value="Student" selected>Student</option>
										<option value="Guest">Guest</option>
									</select>
								</div><br>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="fa fa-clock" aria-hidden="true"></i></div>
									</div>
									<input type="text" name="time" class="form-control form-control-lg" id="inlineFormInputGroup" placeholder="Time Limit" value="525600">
								</div><br>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="fa fa-upload" aria-hidden="true"></i></div>
									</div>
									<input type="text" name="upload_limit" class="form-control form-control-lg" placeholder="Upload Limit (MB)">
								</div><br>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="fa fa-download" aria-hidden="true"></i></div>
									</div>
									<input type="text" name="download_limit" class="form-control form-control-lg" placeholder="Download Limit (MB)">
								</div><br>
								<div class="input-group mb-2">
									<button type="submit" class="btn btn-success btn-lg btn-block">Generate</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
