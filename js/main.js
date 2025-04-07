$(document).ready(function () {

    $("#loginForm").submit(function (event) {
      event.preventDefault();
  
      var username = $.trim($('input[name="username"]').val()); 
      var password = $.trim($('input[name="password"]').val());
       //console.log("console evento", "user", username, " pas", password);
  
    
        // Sanitizar datos antes de enviarlos (opcional, solo como precaución adicional)
        password = encodeURIComponent(password);
  
        loginUser(username,password)
  
  
    });
  });
  
  
  
  function loginUser(username, password) {
    
      //console.log("console función , user", username ,  "pass " , password);
      //return;
      
      $.ajax({
        url: "./backend/login.php",
        method: "POST",
        data: { username: username, password: password },
        dataType: "json",
        success: function (response) {
          console.log("Respuesta nuevo user");
          console.log(response);
    
          if (response.status === "success") {
            //alertify.success("Login successful");
            window.location.href = "./views/home.php";
          } else if (response.status === "error") {
            if (response.message === "El usuario está inactivo") {
              alertify.error(response.message);
            } else {
              console.log("Error: " + response.message);
              $('input[name="username"]').val("");
              $('input[name="password"]').val("");
            }
          } else {
            console.log("Otro error");
            $("#result").html("<p>Error in AJAX call</p>");
          }
        },
      });
    }



    {
      $("#registerForm").submit(function (event) {
        event.preventDefault();
    
        var username = $.trim($('input[name="username2"]').val()); 
        var name = $.trim($('input[name="name2"]').val());
        var lastname = $.trim($('input[name="lastname2"]').val());
        var email = $.trim($('input[name="email2"]').val());
        var password = $.trim($('input[name="password2"]').val());
        var role = $.trim($('input[name="role2"]').val());
         //console.log("console evento", "user", username, " pas", password);
    
      
          password = encodeURIComponent(password);
    
          registerUser(username, name, lastname, email, password, role)
    
    
      });
    };
    
    
    
    function registerUser(username, name, lastname, email, password, role) {
      
      //console.log("console función , user", username , "name" , name, "lastname", lastname, "email" , email, "pass " , password);
      //return; 
        
        $.ajax({
          url: "./backend/register.php",
          method: "POST",
          data: { username: username, name: name, lastname:lastname, email:email, password: password , role:role},
          dataType: "json",
          success: function (response) {
            console.log("Respuesta nuevo user");
            console.log(response);
      
            if (response.status === "success") {
              //alertify.success("Login successful");
              window.location.href = "./views/home.php";
            } else if (response.status === "error") {
              if (response.message === "El usuario está inactivo") {
                alertify.error(response.message);
              } else {
                console.log("Error: " + response.message);
                $('input[name="username"]').val("");
                $('input[name="email"]').val("");
                $('input[name="password"]').val("");
              }
            } else {
              console.log("Otro error");
              $("#result").html("<p>Error in AJAX call</p>");
            }
          },
        });
      }