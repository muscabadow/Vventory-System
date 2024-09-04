function isChecked(){
    if (document.getElementById("iclick").checked){
      // var che
      alert('checked');
      var data = "theme_type="+"checked";
      // alert(data);
      $.post("theme.php",data,function(){

      });
      $(".wrapper").parent().addClass("dark-mode");
    }else{
      alert('un-checked');
      $(".wrapper").parent().removeClass("dark-mode");
      var data = 'theme_type='+"un-checked";
      $.post("theme.php",data,function(){

      });
    }
}

