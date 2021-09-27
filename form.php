<?php
// Include config file
require_once "pconfig.php";
 
// Define variables and initialize with empty values
$name = $surname = $gender = $emailid = $mobileno = $course = "";
$name_err = $surname_err = $gender_er = $emailid_err = $mobileno_err = $course_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a name.";
    } elseif(!preg_match('/^[a-zA-Z\s]+$/', trim($_POST["name"]))){
        $name_err = "name can only contain letters.";
    } else{
        $name = trim($_POST["name"]);
            }

    // Validate surname
    if(empty(trim($_POST["surname"]))){
        $surname_err = "Please enter a surname.";
    } elseif(!preg_match('/^[a-zA-Z\s]+$/', trim($_POST["surname"]))){
        $surrname_err = "surname can only contain letters.";
    } else{
         $surname = trim($_POST["surname"]);
    }
    // Validate gender
    if(empty(trim($_POST["gender"]))){
        $gender_err = "Please enter a gender.";
    } elseif(!preg_match('/^[a-zA-Z\s]+$/', trim($_POST["gender"]))){
        $gender_err = "gender can only contain letters, numbers, and underscores.";
    } else{
        $gender = trim($_POST["gender"]);
               
    }
    // Validate emailid
    if(empty(trim($_POST["emailid"]))){
        $emailid_err = "Please enter a emailid.";
    } elseif(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", trim($_POST["emailid"]))){
        $emailid_err = "emailid can only contain letters, numbers, and underscores.";
    } else{
        $emailid = trim($_POST["emailid"]);
               
    }
    
    
    // Validate mobileno
    if(empty(trim($_POST["mobileno"]))){
        $mobileno_err = "Please enter a mobileno.";
    } elseif(!preg_match('/^[0-9_]+$/', trim($_POST["mobileno"]))){
        $mobileno_err = "mobileno can only contain  numbers.";
    } else{
         $mobileno = trim($_POST["mobileno"]);
    }


    // Validate course
    if(empty(trim($_POST["course"]))){
        $course_err = "Please enter a course.";
    } elseif(!preg_match('/^[a-zA-Z0-9\s]+$/', trim($_POST["course"]))){
        $course_err = "course can only contain letters, numbers, and underscores.";
    } else{
         $course = trim($_POST["course"]);
                
    }
    
    
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($surname_err) && empty($gender_err) && empty($emailid_err) && empty($mobileno_err) && empty($course_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO form (name, surname, gender, emailid, mobileno, course) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss",$param_name, $param_surname, $param_gender, $param_emailid, $param_mobileno, $param_course);
            
            // Set parameters
            $param_name = $name;
            $param_surname = $surname;
            $param_gender = $gender;
            $param_emailid = $emailid;
            $param_mobileno = $mobileno;
            $param_course = $course;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location:plogin.php");
            } else{
                echo "Oops! Something went wrong Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel = "icon" href = "logo.jpeg" 
        type = "image/x-icon">
        <style>
        body{ align-items :center ; font: 14px sans-serif;}
        .wrapper{ width: 360px; padding: 20px; text-align: center;border: 5px solid green;margin: 20px; }
    </style>
    
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group">
                <label>surname</label>
                <input type="text" name="surname" class="form-control <?php echo (!empty($surname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $surname; ?>">
                <span class="invalid-feedback"><?php echo $surname_err; ?></span>
            </div>
            <div class="form-group">
                <label>gender</label>
                <input type="text" name="gender" class="form-control <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $gender; ?>">
                <span class="invalid-feedback"><?php echo $gender_err; ?></span>
            </div>
            <div class="form-group">
                <label>emailid</label>
                <input type="text" name="emailid" class="form-control <?php echo (!empty($emailid_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $emailid; ?>">
                <span class="invalid-feedback"><?php echo $emailid_err; ?></span>
            </div>
            <div class="form-group">
                <label>mobileno</label>
                <input type="text" name="mobileno" class="form-control <?php echo (!empty($mobileno_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mobileno; ?>">
                <span class="invalid-feedback"><?php echo $mobileno_err; ?></span>
            </div>
            <div class="form-group">
                <label>course</label>
                <input type="text" name="course" class="form-control <?php echo (!empty($course_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $course; ?>">
                <span class="invalid-feedback"><?php echo $course_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
        </form>
    </div>    
</body>
</html>