<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>PCinemaU</title>
  <link rel="stylesheet" href="./style.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
  $(document).ready(function(){
        $('.submitButton').click(function(){
            let password = $('#password').val();
            let confirmPassword = $('#confirmPassword').val();
            //check if password match the confirmPassword
            if (password!== confirmPassword){
                $('.warning').css('display', 'inline-block');
                $('.warning').html('<p>Password and Confirm Password don`t match</p>');
            }
            //check if password doesn't meet the minimum length required
            else if (password.length < 8){
                $('.warning').css('display', 'inline-block');
                $('.warning').html('<p>Password at least 8 character</p>');
            }else{
                $('.warning').html('');
            }
        });
  })
  </script>
  <style>
  @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');
*
{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	font-family: 'Quicksand', sans-serif;
}
body 
{
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	background: #000;
}
section 
{
	position: absolute;
	width: 100vw;
	height: 100vh;
	display: flex;
	justify-content: center;
	align-items: center;
	gap: 2px;
	flex-wrap: wrap;
	overflow: hidden;
}
section::before
{
	content: '';
	position: absolute;
	width: 100%;
	height: 100%;
	background: linear-gradient(#000,rgb(0, 62, 125),#000);
	animation: animate 5s linear infinite;
}
/*Jalan dari atas ke bawah*/
@keyframes animate 
{
	0%
	{
		transform: translateY(-100%); 
	}
	100%
	{
		transform: translateY(100%);
	}
}
section span 
{
	position: relative;
	display: block;
	width: calc(6.25vw - 2px);
	height: calc(6.25vw - 2px);
	background: #181818;
	z-index: 2;
	transition: 1.5s; /*delay nya*/
}
section span:hover 
{
	background: rgb(0, 170, 255);
	transition: 0s;
}

section .signin
{
	position: absolute;
	width: 400px;
    background: #222;  
	z-index: 1000;
	display: flex;
	justify-content: center;
	align-items: center;
	padding: 40px;
	border-radius: 4px;
	box-shadow: 0 15px 35px rgba(0,0,0,9);
}
section .signin .content 
{
	position: relative;
	width: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	gap: 40px;
}
section .signin .content h2 
{
	font-size: 2em;
	color: rgb(0, 170, 255);
	text-transform: uppercase;
}
section .signin .content .form 
{
	width: 100%;
	display: flex;
	flex-direction: column;
	gap: 25px;
}
section .signin .content .form .inputBox
{
	position: relative;
	width: 100%;
}
section .signin .content .form .inputBox input 
{
	position: relative;
	width: 100%;
	background: #333;
	border: none;
	outline: none;
	padding: 25px 10px 7.5px;
	border-radius: 4px;
	color: #fff;
	font-weight: 500;
	font-size: 1em;
}
section .signin .content .form .inputBox i 
{
	position: absolute;
	left: 0;
	padding: 15px 10px;
	font-style: normal;
	color: #aaa;
	transition: 0.5s;
	pointer-events: none; /*placeholder*/
}
.signin .content .form .inputBox input:focus ~ i,
.signin .content .form .inputBox input:valid ~ i
{
	transform: translateY(-7.5px);
	font-size: 0.8em;
	color: #fff;
}/*kalau lagi fokus maka tulisan di naikkan 7.5px ke atas dan warna nya jadi putih*/
.signin .content .form .links 
{
	position: relative;
	width: 100%;
	display: flex;
	justify-content: space-between;
}
.signin .content .form .links a 
{
	color: #fff;
	text-decoration: none;
}/*forgot password*/
.signin .content .form .links a:nth-child(2)
{
	color: rgb(0, 183, 255);
	font-weight: 600;
}/*signup*/
.signin .content .form .inputBox input[type="button"]
{
	padding: 10px;
	background: rgb(0, 208, 255);
	color: #000;
	font-weight: 600;
	font-size: 1.35em;
	letter-spacing: 0.05em;
	cursor: pointer;
}/*button*/
input[type="button"]:hover
{
	opacity: 0.75;
}
input[type="button"]:active
{
	opacity: 0.6;
}/*button on click*/
.warning{
    color:rgb(240, 126, 126);
}
@media (max-width: 900px)
{
	section span 
	{
		width: calc(10vw - 2px);
		height: calc(10vw - 2px);
	}
}
@media (max-width: 600px)
{
	section span 
	{
		width: calc(20vw - 2px);
		height: calc(20vw - 2px);
	}
} /*responsiveness*/
</style>
</head>

<body>
<section>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span> <!--ini dibuat kotak kotak e-->

    <div class="signin">
      <div class="content">
        <h2>Sign Up</h2>
        <form action="process-signup.php" method="post" class="form">
          <div class="inputBox">
            <input type="text" id="username" name="username" required>
            <i>Username</i>
          </div>
          <div class="inputBox">
            <input id ="password" type="password" name="password" required>
            <i>Password</i>
          </div>
          <div class="inputBox">
            <input id="confirmPassword" type="password" name="confirmPassword" required>
            <i>Confirm Password</i>
          </div>
          <div class="links">
            <!-- <a href="pcucinemasiginpage.html">Sign in</a> -->
            <a href="signin-page.html">Sign in</a> <!--ini signin pageku-->
          </div>
          <div class="warning" style="display:none;">
          </div>
          <div class="inputBox">
            <button>Confirm</button>
            <!-- <input class = "submitButton" type="submit" value="Confirm"> -->
          </div>
        </form>
      </div>
    </div>
  </section>
<!-- partial -->
  
</body>
</html>