<?php


include('config/db_connect.php');


$title = $email = $ingredient = '';
$errors = array('email'=>'', 'title'=> '', 'ingredient'=>'');



if(isset($_POST['submit'])){
    
    // check email
    if(empty($_POST['email'])){
        $errors['email'] =  'An email is required  <br />';
    } else {
       $email = $_POST['email'];
       if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
       $errors['email'] = 'email must be a valid email address';
       }
   
    }
        
    //check title
    if(empty($_POST['title'])){
        $errors['title'] = 'A title is required  <br />';
    } else {
       $title = $_POST['title'];
       if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
        $errors['title'] = 'Titles must be letters and spaces only';
       }

}
  // check ingredient
if(empty($_POST['ingredient'])){
    $errors['ingredient']=  'At least one ingredient is required  <br />';
} else {
    $ingredient = $_POST['ingredient'];
    if(!preg_match('/^([a-zA-Z\s]+)(, \s*[a-zA-Z\s]*)*$/', $ingredient)){
     $errors['ingredient']= 'Ingredient must be a comma separated list';
    }
}

if(array_filter($errors)){
   // echo "There are errors in the form";

} else {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    
    $ingredient = mysqli_real_escape_string($conn, $_POST['ingredient']);

    $sql = "INSERT INTO pizzas(title, email, ingredient) VALUES('$title', '$email', '$ingredient')";

    if(mysqli_query($conn, $sql)){

        header('Location: index.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
    // echo "form is valid";

    
}


}
// this is the end of the post check




?>

<!DOCTYPE html>
<html lang="en">

<?php include('template/header.php');?>
  
<section class="container grey-text">
    <h4 class="center">Add a Pizza</h4>
    <form action="add.php" method="POST" class="white">
        <label for=""> Your Email</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <div class="red-text"><?php echo $errors['email'];?></div>
        <label for="">Pizza Titlel</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
        <div class="red-text"><?php echo $errors['title'];?></div>
        <label for="" >Ingredients (comma separated)</label>
        <input type="text" name="ingredient" value="<?php echo htmlspecialchars($ingredient); ?>">
        <div class="red-text"><?php echo $errors['ingredient'];?></div>
        <div class="center">
            <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>


<?php include('template/footer.php');?>
  

</html>