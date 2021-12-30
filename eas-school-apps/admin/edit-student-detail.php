<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['trmsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {
$eid=$_GET['editid'];
$tname = $_POST["tname"];
$admnumb = $_POST["admissionno"];
$admdate = $_POST["admissiondate"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$mobnum = $_POST["mobilenumber"];
$address = $_POST["address"];
$propic = $_FILES["propic"]["name"];

$sql="update tblstudents 
        set name=:tname, admission_no=:admnumb, admission_date=:admdate, gender=:gender, email=:email, mobile=:mobnum, current_address=:address, photo=:propic
        where id=:eid";

$query = $dbh->prepare($sql);
$query->bindParam(":tname", $tname, PDO::PARAM_STR);
$query->bindParam(":admnumb", $admnumb, PDO::PARAM_STR);
$query->bindParam(":admdate", $admdate, PDO::PARAM_STR);
$query->bindParam(":gender", $gender, PDO::PARAM_STR);
$query->bindParam(":email", $email, PDO::PARAM_STR);
$query->bindParam(":mobnum", $mobnum, PDO::PARAM_STR);
$query->bindParam(":address", $address, PDO::PARAM_STR);
$query->bindParam(":propic", $propic, PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();

    echo '<script>alert("Student detail has been updated")</script>';

    }
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
   
    <title>Update Student</title>
  
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

    <?php include_once('includes/sidebar.php');?>

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php include_once('includes/header.php');?>

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Update Student Detail</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="manage-student.php">Update Student</a></li>
                            <li class="active">Update</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">


                <div class="row">
                    <div class="col-lg-6">
                       <!-- .card -->

                    </div>
                    <!--/.col-->

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header"><strong>Student</strong><small> Detail</small></div>
                            <form name="" method="post" action="" enctype="multipart/form-data">
                                
                            <div class="card-body card-block">
 <?php
$eid=$_GET['editid'];
$sql="SELECT * from  tblstudents where id=$eid";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
<!-- picture -->
<div class="form-group">
    <label for="profic" class=" form-control-label">Picture</label><br>
    <img src="images/<?php echo $row->photo;?>" width="100px" value="<?php  echo $row->photo;?>"><br>
    <a href="changeimage-student.php?editid=<?php echo $row->id;?>"> Edit Picture</a>
</div>

 <!-- name -->
 <div class="form-group"><label for="tname" class=" form-control-label">Name</label><input type="text" name="tname" value="<?php  echo $row->name;?>" class="form-control" id="tname" required="true"></div>

<!-- admission no -->
<div class="form-group"><label for="admissionno" class=" form-control-label">Admission Number</label><input type="number" name="admissionno" value="<?php  echo $row->admission_no;?>" class="form-control" id="admissionno" required="true"></div>

<!-- admission date -->
<div class="form-group"><label for="admissiondate" class=" form-control-label">Admission Date</label><input type="date" name="admissiondate" id="admissiondate" value="<?php  echo $row->admission_date;?>" class="form-control" required="true"></div>

<!-- gender -->
<div class="form-group">
    <label for="">Gender</label><br>
    <input type="radio" name="gender" value="Male" id="male" <?php if($row->gender == "Male") { echo "checked"; } ?> >
    <label for="male">Male</label> <br>
    <input type="radio" name="gender" value="Female" id="female" <?php if($row->gender == "Female") { echo "checked"; } ?> >
    <label for="female">Female</label>
</div>

<!-- email -->
<div class="form-group"><label for="email" class=" form-control-label">Email</label><input type="email" name="email" value="<?php  echo $row->email;?>" id="email" class="form-control" required="true"></div>


<!-- mobile number -->
<div class="row form-group">
    <div class="col-12">
        <div class="form-group"><label for="mobilenumber" class=" form-control-label">Phone Number</label><input type="text" name="mobilenumber" id="mobilenumber" value="<?php  echo $row->mobile;?>" class="form-control" required="true" maxlength="15" pattern="[0-9]+"></div>
    </div>
</div>


<!-- current address -->
<div class="row form-group">
    <div class="col-12">
        <div class="form-group">
            <label for="address" class=" form-control-label">Current Address</label>
            <textarea type="text" name="address" id="address" value="" class="form-control" rows="4" cols="12" required="true"><?php  echo $row->current_address;?></textarea>
        </div>
    </div>
</div>

<?php $cnt=$cnt+1;}} ?>

<p style="text-align: center;"><button type="submit" class="btn btn-primary btn-sm" name="submit" id="submit"><i class="fa fa-dot-circle-o"></i> Update</button></p> 
                                                     
                                                </div>
                                                </form>
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
<?php }  ?>