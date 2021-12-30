<?php
session_start();
error_reporting(0);
include "includes/dbconnection.php";
if (strlen($_SESSION["trmsaid"] == 0)) {
    header("location:logout.php");
} else {
    if (isset($_POST["submit"])) {
        $trmsaid = $_SESSION["trmsaid"];
        $tname = $_POST["tname"];
        $admnumb = $_POST["admissionno"];
        $admdate = $_POST["admissiondate"];
        $gender = $_POST["gender"];
        $email = $_POST["email"];
        $mobnum = $_POST["mobilenumber"];
        $address = $_POST["address"];
        $propic = $_FILES["propic"]["name"]; //????
        $extension = substr($propic, strlen($propic) - 4, strlen($propic));
        $allowed_extensions = [".jpg", "jpeg", ".png", ".gif"];

        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Profile Pics has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            $propic = md5($propic) . time() . $extension;
            move_uploaded_file(
                $_FILES["propic"]["tmp_name"],
                "images/" . $propic
            );
            $sql =
                "insert into tblstudents(name, admission_no, admission_date, gender, email, mobile, current_address, photo)values(:tname, :admnumb, :admdate, :gender, :email, :mobnum, :address, :propic)";

            $query = $dbh->prepare($sql);
            $query->bindParam(":tname", $tname, PDO::PARAM_STR);
            $query->bindParam(":admnumb", $admnumb, PDO::PARAM_STR);
            $query->bindParam(":admdate", $admdate, PDO::PARAM_STR);
            $query->bindParam(":gender", $gender, PDO::PARAM_STR);
            $query->bindParam(":email", $email, PDO::PARAM_STR);
            $query->bindParam(":mobnum", $mobnum, PDO::PARAM_STR);
            $query->bindParam(":address", $address, PDO::PARAM_STR);
            $query->bindParam(":propic", $propic, PDO::PARAM_STR);
            $query->execute();

            $LastInsertId = $dbh->lastInsertId();
            if ($LastInsertId > 0) {
                echo '<script>alert("Student Detail has been added.")</script>';
                echo "<script>window.location.href ='add-student.php'</script>";
            } else {
                echo '<script>alert("Something Went Wrong. Please try again")</script>';
            }
        }
    } ?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <title>Add Student</title>
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body>
    <!-- Left Panel -->
    <?php include_once "includes/sidebar.php"; ?>
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include_once "includes/header.php"; ?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Student Details</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="add-student.php">Student Details</a></li>
                            <li class="active">Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <!--/.col-->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header"><strong>Student </strong><small> Details</small></div>
                                <form name="" method="post" action="" enctype="multipart/form-data">
                                    <div class="card-body card-block">
                                        <!-- name -->
                                        <div class="form-group"><label for="tname" class=" form-control-label">Name</label><input type="text" name="tname" value="" class="form-control" id="tname" required="true"></div>

                                        <!-- admission no -->
                                        <div class="form-group"><label for="admissionno" class=" form-control-label">Admission Number</label><input type="number" name="admissionno" value="" class="form-control" id="admissionno" required="true"></div>

                                        <!-- admission date -->
                                        <div class="form-group"><label for="admissiondate" class=" form-control-label">Admission Date</label><input type="date" name="admissiondate" id="admissiondate" value="" class="form-control" required="true"></div>

                                        <!-- gender -->
                                        <div class="form-group">
                                            <label for="">Gender</label><br>
                                            <input type="radio" name="gender" value="Male" id="male">
                                            <label for="male">Male</label> <br>
                                            <input type="radio" name="gender" value="Female" id="female">
                                            <label for="female">Female</label>
                                        </div>
                                        
                                        <!-- email -->
                                        <div class="form-group"><label for="email" class=" form-control-label">Email</label><input type="email" name="email" value="" id="email" class="form-control" required="true"></div>

                                        
                                        <!-- mobile number -->
                                        <div class="row form-group">
                                            <div class="col-12">
                                                <div class="form-group"><label for="mobilenumber" class=" form-control-label">Phone Number</label><input type="text" name="mobilenumber" id="mobilenumber" value="" class="form-control" required="true" maxlength="15" pattern="[0-9]+"></div>
                                            </div>
                                        </div>
                                        
                                        
                                        <!-- current address -->
                                        <div class="row form-group">
                                            <div class="col-12">
                                                <div class="form-group"><label for="address" class=" form-control-label">Current Address</label><textarea type="text" name="address" id="address" value="" class="form-control" rows="4" cols="12" required="true"></textarea></div>
                                            </div>
                                        </div>
                                        
                                        <!-- picture -->
                                        <div class="form-group"><label for="profic" class=" form-control-label">Picture</label><input type="file" name="propic" value="" class="form-control" id="propic" required="true"></div>
                                        
                                        <p style="text-align: center;">
                                        <button type="submit" class="btn btn-primary btn-sm" name="submit" id="submit"><i class="fa fa-dot-circle-o"></i>   Add   </button></p>
                                                            
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div><!-- /#right-panel -->
    <!-- Right Panel -->


                            <script src="vendors/jquery/dist/jquery.min.js"></script>
                            <script src="vendors/popper.js/dist/umd/popper.min.js"></script>

                            <script src="vendors/jquery-validation/dist/jquery.validate.min.js"></script>
                            <script src="vendors/jquery-validation-unobtrusive/dist/jquery.validate.unobtrusive.min.js"></script>

                            <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
                            <script src="assets/js/main.js"></script>
</body>
</html>
<?php
} ?>
