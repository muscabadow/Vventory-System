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
    <div class="" id="blur">
      <div class="l-form">
        <form action="" method="post" class="form">
          <h1 class="form__title">Recover Password</h1>

            <div class="form__div">
              <input type="password" name="pass" autocomplete="off" id="password" class="form__input" placeholder=" " required>
              <label for="" class="form__label">Password</label>
              <span class="fas fa-eye form__label2" id="e" onclick="pass()"></span>
            </div>
            <div class="form__div">
              <input type="password" name="cpass" autocomplete="off" id="cpassword" class="form__input" placeholder=" " required>
              <label for="" class="form__label">Confirm Password</label>
              <span class="fas fa-eye form__label2" id="ee" onclick="cpass()"></span>
            </div>

            <!-- <input type="submit" class="form__button" onclick="cc()" value="Back"> -->
            <a href="forgot_password.php" class="form__button" style="color: white;">Back</a>
            <button type="submit" name="btnreg" id="toggle" user_id="<?php echo $_GET['user_id']; ?>" class="form__button1 float-right">Change</button>
        </form>
      </div>
    </div>

    <div class="popup" id="popup">
      <img src="images\404-tick.png">
      <h2 class="h2">Mahadsanid!</h2>
      <p>Waad ku guuleysatay inaad badasho<br> 
        Password-kaaga!</p>
      <button type="button" id="btn">Ok</button>        
    </div>

  </body>
</html>



<style type="text/css">
  .popup{
    width: 400px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0px 5px 25px rgba(0, 0, 0, .8);
    position: absolute;
    top: 28%;
    left: 34.6%;
    text-align: center;
    padding: 10px 5px 10px 5px;
    visibility: hidden;
  }
  .actives{
    visibility: visible;
  }
  img{
    width: 70px;
    margin-top: -50px;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  }
  #btn{
    width: 80%;
    margin-top: 20px;
    margin-bottom: 20px;
    background: #6fd649;
    outline: none;
    border: 0;
    border-radius: 6px;
    padding: 8px 0;
    font-size: 15px;
    cursor: pointer;
    box-shadow: 0 5px 5px rgba(0, 0, 0, 0.2);
  }
  .h2{
    font-size: 38px;
  }
  p{
    font-size: 22px;
  }
  .active{
      filter: blur(20px);
    }
</style>



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
  top: 1.2rem;
  padding: 0 .25rem;
  background-color: #143655;
  color: var(--input-color);
  font-size: var(--normal-font-size);
  transition: .3s;
}

.form__label2{
  position: absolute;
  top: 1.3rem;
  left: 22rem;
  /*width: 100%;*/
  /*height: 100%;*/
  color: var(--input-color);
  font-size: var(--normal-font-size);
  /*border: 1px solid var(--border-color);*/
  /*border-radius: .5rem;*/
  outline: none;
  /*padding: 0rem;*/
  background: none;
  z-index: 1;
  cursor: pointer;
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
  margin-left: 216px;
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
  top: -.5rem;
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

<script type="text/javascript">
  document.getElementById("btn").addEventListener("click",function(){
    // alert(1);
    window.location='index.php';
  })
</script>



<!-- 
<script type="text/javascript">
  function cc(){
    // alert(1);
    window.location='index.php';
  }
</script> -->
<script src="plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
  // var eyee = document.getElementById("e").getAttribute('class');
  function pass(){
    var mypass = document.getElementById("password");
    var mycla = document.getElementById("e").getAttribute('class');
    // alert(mycla);
    if (mypass.type == "password") {
      mypass.type = "text";
      document.getElementById("e").setAttribute('class',"fas fa-eye-slash form__label2");
    }else{
      mypass.type = "password";
      document.getElementById("e").setAttribute('class',"fas fa-eye form__label2");
    }
  }

  function cpass(){
    var cpass = document.getElementById("cpassword");
    var ceye = document.getElementById("ee").getAttribute("class");
    // alert(ceye);
    if (cpass.type == "password") {
      cpass.type = "text";
      document.getElementById("ee").setAttribute("class","fas fa-eye-slash form__label2");
    }else{
      cpass.type = "password";
      document.getElementById("ee").setAttribute("class","fas fa-eye form__label2");
    }
  }



  document.getElementById("toggle").addEventListener("click",function(e){
    e.preventDefault();
    var pass = document.getElementById("password").value;
    var cpass = document.getElementById("cpassword").value;
    if (pass == '' || cpass == '') {
      alert('Fadlan wax soo geli');
    }else if (pass != cpass) {
      alert("Si iskumid ah uma gelin Password-ka Fadlan iska hubi");
    }else{
      var passs = document.getElementById("password").value;
      var user_id = toggle.getAttribute("user_id");
      var data = "pass="+passs+"&user_id="+user_id;
      $.post("password_changed.php",data,function(){

      });

      var blur = document.getElementById("blur");
      blur.classList.toggle("active");
      var popup = document.getElementById("popup");
      popup.classList.add("actives");
    }
  });
</script>