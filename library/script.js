document.getElementById("signUpButton").addEventListener("click", function() {
    document.getElementById("signup").style.display = "block";
    document.getElementById("signIn").style.display = "none";
    document.getElementById("adminLogin").style.display = "none";
  });

  document.getElementById("signInButton").addEventListener("click", function() {
    document.getElementById("signup").style.display = "none";
    document.getElementById("signIn").style.display = "block";
    document.getElementById("adminLogin").style.display = "none";
  });

  document.getElementById("adminLoginButton").addEventListener("click", function() {
    document.getElementById("signup").style.display = "none";
    document.getElementById("signIn").style.display = "none";
    document.getElementById("adminLogin").style.display = "block";
  });

  document.getElementById("backToUserLogin").addEventListener("click", function() {
    document.getElementById("signup").style.display = "none";
    document.getElementById("signIn").style.display = "block";
    document.getElementById("adminLogin").style.display = "none";
  });