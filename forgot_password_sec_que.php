<?php
  require("library/conn.php");
  extract($_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- <php require("library/head.php"); ?> -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>INVENTORY SYSTEM</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
</head>
  <body>
    <div class="l-form">
      <form action="" method="post" class="form">
        <h1 class="form__title">Secret Question</h1>

          <div class="form__div">
            <input type="text" name="sec_ans" autocomplete="off" class="form__input" placeholder=" " required>
            <label for="" class="form__label"><?php echo $sec_question; ?></label>
          </div>

          <!-- <input type="submit" class="form__button" onclick="cc()" value="Back"> -->
          <a href="forgot_password.php" class="form__button" style="color: white;">Back</a>
          <button type="submit" name="btnreg" class="form__button1 float-right">Next</button>
          
          <?php
          require("library/conn.php");
          if (isset($_POST['btnreg'])) {
          $sec_ans = $_POST['sec_ans'];

          $sql = mysqli_query($conn, "SELECT u.user_id,u.username,e.email,e.tell,u.sec_question,u.sec_answer FROM users u LEFT JOIN employee e ON e.emp_id=u.emp_id WHERE u.sec_answer = '$sec_ans' AND u.user_id = '$id';");

          if (mysqli_num_rows($sql) > 0) {
            // $ress = mysqli_fetch_array($sql);
            echo "<script> window.location='recover_password.php?user_id=$id'; </script>";
          }else{
            echo "<input type='submit' class='form__button2' value='Waa Qalad Jawaabta Sirta ah'>";
          }
        }
          ?>
      </form>
    </div>
  </body>
</html>



<style type="text/css">
  /*===== GOOGLE FONTS =====*/
/*@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap");*/
/*===== VARIABLES CSS =====*/
:root{
  /*===== Colores =====*/
  --first-color: #1A73E8;
  --input-color: #80868B;
  --border-color: #DADCE0;

  /*===== Fuente y tipografia =====*/
  --body-font: 'Roboto', sans-serif;
  --normal-font-size: 1rem;
  --small-font-size: .75rem;
}

/*===== BASE =====*/
*,::before,::after{
  box-sizing: border-box;
}
body{
  margin: 0;
  padding: 0;
  font-family: var(--body-font);
  font-size: var(--normal-font-size);
  background-color: #143650;
}
h1{
  margin: 0;
}

/*===== FORM =====*/
.l-form{
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
.form{
  width: 360px;
  padding: 4rem 2rem;
  border-radius: 1rem;
  /*box-shadow: 0 1px 0px 9px rgba(10,10,100,.8);rgba(0,0,0,.4);*/
  box-shadow: 0 5px 25px rgba(0,0,0,.7);
  background-color: #143655;
}
.form__title{
  font-weight: 400;
  margin-bottom: 2rem;
  color: white;
}
.form__div{
  position: relative;
  height: 48px;
  margin-bottom: 1.5rem;
}
.form__input{
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  color: white;
  font-size: var(--normal-font-size);
  border: 1px solid var(--border-color);
  border-radius: .5rem;
  outline: none;
  padding: 1rem;
  background: none;
  z-index: 1;
}
.form__label{
  position: absolute;
  left: 1rem;
  top: 1.3rem;
  padding: 0 .25rem;
  background-color: #143655;
  color: var(--input-color);
  font-size: var(--normal-font-size);
  transition: .3s;
}

/*.form__button{
  /*display: block;*/
  /*margin-left: auto;
  padding: .75rem 2rem;
  outline: none;
  border: none;*/
  /*background-color: var(--first-color);
  color: #fff;
  font-size: var(--normal-font-size);
  border-radius: .5rem;
  cursor: pointer;
  transition: .3s;*/
  /*width: 100%;*/
  /*margin-bottom: 1rem;*/
/*}*/

.form__button2{
  display: block;
  /*margin-left: auto;*/
  padding: .75rem 1rem;
  outline: none;
  border: none;
  background-color: red;
  color: #fff;
  font-size: var(--normal-font-size);
  border-radius: .5rem;
  cursor: pointer;
  transition: .3s;
  width: 100%;
  /*margin-top: 10px;*/
  /*margin-bottom: 1rem;*/
}

.form__button{
  position: absolute;
  margin-left: auto;
  padding: .75rem 2rem;
  outline: none;
  border: none;
  background-color: var(--first-color);
  color: #fff;
  font-size: var(--normal-font-size);
  border-radius: .5rem;
  cursor: pointer;
  transition: .3s;
  margin-top: 1px;
  margin-bottom: 1rem;
}


.form__button1{
  /*display: block;*/
  margin-left: 235px;
  padding: .75rem 2rem;
  outline: none;
  border: none;
  background-color: var(--first-color);
  color: #fff;
  font-size: var(--normal-font-size);
  border-radius: .5rem;
  cursor: pointer;
  transition: .3s;
  /*width: 100%;*/
  margin-bottom: 1rem;
}
.form__button:hover{
  box-shadow: 0 10px 36px rgba(0,0,0,.20);
}
.form__button1:hover{
  box-shadow: 0 10px 36px rgba(0,0,0,.20);
}

/*Input focus move up label*/
.form__input:focus + .form__label{
  top: -.8rem;
  left: .8rem;
  /*color: var(--first-color);*/
  color: white;
  font-size: /*var(--normal-font-size)*/16px;
  font-weight: 500;
  z-index: 10;
}

/*Input focus sticky top label*/
.form__input:not(:placeholder-shown).form__input:not(:focus)+ .form__label{
  top: -.5rem;
  left: .8rem;
  font-size: var(--normal-font-size);
  font-weight: 500;
  z-index: 10;
}

/*Input focus*/
.form__input:focus{
  border: 1.5px solid var(--first-color);
}
a{
  margin-left: 32%;
  border: none;
  outline: none;
  text-decoration: none;
  color:#007bff;
  text-decoration:none;
  background-color:transparent
}
a:hover{
  color:#0056b3;
  text-decoration:none
}
</style>





<!-- 
<script type="text/javascript">
  function cc(){
    // alert(1);
    window.location='index.php';
  }
</script> -->