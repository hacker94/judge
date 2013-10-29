<!DOCTYPE html>
<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8"); 
if (isset($_COOKIE['id'])) {
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='judgeindex.php'";
	echo "</script>";
}
?>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
		<style>
        body {
            background: url(2.jpg);
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-attachment:fixed;
        }
		p#bh {
			color: #FF0;
			font-size:34px;
			position: fixed;
			left: 100px;
			max-width: 34px;
			top: auto;
			bottom: auto;
			font-weight: bold;
			font-family: Microsoft YaHei;
		}
		h1#title {
			margin-top: 50px;
			color: #FF0;
			font-family: 'Arial Narrow',Arial,sans-serif;
			font-family: Microsoft YaHei;
			font-weight: bold;
		}
		</style>
		<script>
		function signUp() {
			var form = document.getElementById('signup');	
			var idRegu = /^\d{8}$/;
			if ((idRegu.test(form['id'].value)) &&
			    (form['name'].value.length != 0) &&
				(form['pw'].value == form['pw_confirm'].value) &&
				(form['phone'].value.length != 0) &&
				(form['ac'].value.length != 0) &&
				(form['grade'].value.length != 0)) {
				form.submit();
			} else {
				alert('Input error!');
			}
		}
		</script>
    <title></title>
    </head>
    <body>
        <div class="container">
            <header>
				<h1 id="title">信息基础部<br/>“沙航论剑”学生党的理论和历史知识知识竞赛网络初赛</h1>
            </header>
			<p id="bh">北京航空航天大学沙河校区</p>
            <section>				
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form action="judgeindex.php" method="post" autocomplete="on"> 
                                <h1>Log in</h1> 
                                <p> 
                                    <label for="id" class="uname" data-icon="u" > Your student ID </label>
                                    <input id="id" name="id" required type="text" pattern="\d{8}" placeholder="1206xxxx"/>
                                </p>
                                <p> 
                                    <label for="pw" class="youpasswd" data-icon="p"> Your password </label>
                                    <input id="pw" name="pw" required type="password" placeholder="eg. password" /> 
                                </p>
                                <p class="login button"> 
                                    <input type="submit" value="Login" /> 
								</p>
                                <p class="change_link">
									Not a member yet ?
									<a href="#toregister" class="to_register">Join us</a>
								</p>
                            </form>
                        </div>

                        <div id="register" class="animate form">
                            <form id="signup" action="register.php" method="post" autocomplete="on"> 
                                <h1> Sign up </h1> 
                                <p> 
                                    <label for="id" class="uname" data-icon="u">Your student ID</label>
                                    <input id="id" name="id" required type="text" placeholder="1206xxxx" pattern="^\d{8}$" />
                                </p>
                                <p> 
                                    <label for="name" class="uname" data-icon="u">Your name</label>
                                    <input id="name" name="name" required type="text" placeholder="冯如" />
                                </p>
                                <p> 
                                    <label for="pw" class="youpasswd" data-icon="p">Your password </label>
                                    <input id="pw" name="pw" required type="password" placeholder="eg. password"/>
                                </p>
                                <p> 
                                    <label for="pw_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <input id="pw_confirm" name="pw_confirm" required type="password" placeholder="eg. password"/>
                                </p>
								<p> 
                                    <label for="phone" class="youmail" > Your phone number</label>
                                    <input id="phone" name="phone" required type="text"  placeholder="13012345678"/> 
                                </p>
								<p> 
                                    <label for="grade" class="youmail" > Your grade</label>
                                    <input id="grade" name="grade" required type="text"  placeholder="大二"/> 
                                </p>
								<p> 
                                    <label for="ac" class="youmail" > Your acadamy</label>
                                    <input id="ac" name="ac" required type="text"  placeholder="6系"/> 
                                </p>
                                <p class="signin button"> 
									<input type="submit" onClick="signUp()" value="Sign up"/> 
								</p>
                                <p class="change_link">  
									Already a member ?
									<a href="#tologin" class="to_register"> Go and log in </a>
								</p>
                            </form>
                        </div>
						
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>