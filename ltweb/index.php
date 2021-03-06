<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head> 
   <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Bookstore</title>
	<meta name="description" content="fly to jquery plugin">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	
    <link href="css/templatemo_style.css" rel="stylesheet" type="text/css" />
    <link href="css/modal.css" rel="stylesheet" type="text/css" />
    <script>
    function logout() {
        $.ajax({
            type:"GET",
            url:"xllogout.php",
            success:function (kq) {
            if(kq==1)
            {
                alert("Dang xuat thanh cong");
                location.href="index.php";
            }
            }
           
        });
        
    }
    function moformlogin() {
        $("#myModal").css("display","block");
    }
    function login() {
      var re=$.ajax({
        type:"POST",
        url:"xllogin.php",
        data:{
          "email":$("#txtEmail").val(),
          "pass":$("#txtPass").val()
        },
        dataType:"text",
        success:function(kq)
        {
            //$("#kqlogin").html(kq);
            if(kq==0)
                $("#kqlogin").html("Đăng nhập không thành công");
            else
            {
                alert("Đăng nhập thành công");
                document.getElementById('myModal').style.display="none";
                $("#myBtn").html("Dang xuat");
                $("#myBtn").unbind("click");
                $("#myBtn").bind("click",logout);
            }    
                
        }
      });
      re.error(function() {
        alert("Có lỗi trong đăng nhập");
      });
    }
    </script>
</head>
<body>
<?php
include "config/config.php";
    function myautoload($classname)
    {
        include "classes/".$classname.".class.php";
    }
    spl_autoload_register("myautoload");
    $db=new Db();
    if(isset($_POST['mo'])&&$_POST['mo']=='login')
    {
        $khDB=new KhachHang();
        if($khDB->login($_POST['txtEmail'],$_POST['txtPass']))
        {
            $message="Dang nhap thanh cong";
            $_SESSION['user']=$_POST['txtEmail'];
        }else
            $message="Dang nhap khong thanh cong";
    }
?>
<!--  Free CSS Templates from www.templatemo.com -->
<div id="templatemo_container">
	<div id="templatemo_menu">
    	<ul>
            <li><a href="index.php" class="current">Trang chủ</a></li>
            <li><a href="subpage.html">Sách</a></li>            
            <li><a href="subpage.html">Truyện</a></li>  
            <li><a href="#">Tạp chí</a></li> 
            <li><a href="#">Liên hệ</a></li>
            <li>
            <?php 
                if(isset($_SESSION['user']))
                    echo "Xin chao ",$_SESSION['user'];
                else
                    echo '<a href="#" id="myBtn" onclick="moformlogin()">Đăng nhập</a>';
            ?>
            </li>
        </ul>
        <div id="cartinfo">1</div>
        <div id="cart-box">
            <a href="index.php?mo=cart"><img width="30" class="cart" src="images/cart-lrg.png"  alt="Cart" /></a>      
        </div>
        
    </div> <!-- end of menu -->
    
    <div id="templatemo_header">
    	<div id="templatemo_special_offers">
        	<p>
                <span>25%</span> discounts for
        purchase over $80
        	</p>
			<a href="subpage.html" style="margin-left: 50px;">Read more...</a>
        </div>
        
        
        <div id="templatemo_new_books">
        	<ul>
                <li>Suspen disse</li>
                <li>Maece nas metus</li>
                <li>In sed risus ac feli</li>
            </ul>
            <a href="subpage.html" style="margin-left: 50px;">Read more...</a>
        </div>
    </div> <!-- end of header -->
    
    <div id="templatemo_content">
    	
        <div id="templatemo_content_left">
        	<div class="templatemo_content_left_section">
            	<h1>Loại sách</h1>
                <ul>
                <?php
                //$loais=$db->exeQuery("select * from loai");
                $loaiDB=new Loai();
                $loais=$loaiDB->tatCa();
                foreach($loais as $loai)
                {
                ?>
                    <li><a href="index.php?loai=<?php echo $loai['maloai']; ?>"><?php echo $loai['tenloai']; ?></a></li>
                <?php } ?>
            	</ul>
            </div>
			<div class="templatemo_content_left_section">
            	<h1>Sách mới</h1>
                <ul>
                    <li><a href="#">Vestibulum ullamcorper</a></li>
                    <li><a href="#">Maece nas metus</a></li>
                    <li><a href="#">In sed risus ac feli</a></li>
                    <li><a href="#">Praesent mattis varius</a></li>
                    <li><a href="#">Maece nas metus</a></li>
                    <li><a href="#">In sed risus ac feli</a></li>
                    <li><a href="#">Flash Templates</a></li>
                    <li><a href="#">CSS Templates</a></li>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="http://www.photovaco.com" target="_parent">Free Photos</a></li>
            	</ul>
            </div>
            
            
        </div> <!-- end of content left -->
        
        <div id="templatemo_content_right">
            <div><?php if(isset($message))
                    echo $message;
                ?>
            </div>
            <?php include "sach.php"; ?>
        
        </div>
        
    </div> <!-- end of content -->
    
    <div id="templatemo_footer">
    
	       <a href="subpage.html">Home</a> | <a href="subpage.html">Search</a> | <a href="subpage.html">Books</a> | <a href="#">New Releases</a> | <a href="#">FAQs</a> | <a href="#">Contact Us</a><br />
        Copyright © 2024 <a href="#"><strong>Your Company Name</strong></a> 
        <!-- Credit: www.templatemo.com -->	
    </div> 
    <!-- end of footer -->
<!--  Free CSS Template www.templatemo.com -->
</div> <!-- end of container -->

<!-- Trigger/Open The Modal -->


<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">&times;</span>
        <h2>Đăng nhập</h2>
      </div>
      <div class="modal-body">
      <form action="index.php" method="post">
      <input type="hidden" name="mo" value="login">
      <table>
          <tr>
              <td>Email</td>
              <td><input type="email" id="txtEmail" name="txtEmail"></td>
          </tr>
          <tr>
              <td>Password</td>
              <td><input type="password" id="txtPass" name="txtPass" ></td>
          </tr>
          <tr>
              <td colspan="2" align="center">
                <!--  <input type="button" id="btnLogin" name="btnLogin" value="Dang nhap" onclick="login()" > -->
                <input type="submit" id="btnLogin" name="btnLogin" value="Dang nhap" >
              </td>
          </tr>
      </table>
      <div id="kqlogin"></div>
  </form>
      </div>
    
    </div>
  </div>
    



<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/flyto.js"></script>
    <script>
        $('#templatemo_content_right').flyto({
            item      : '.templatemo_product_box',
            target    : '.cart',
            button    : '.my-btn'
        });

         /*$('.items').flyto({
            item      : 'li',
            target    : '.cart',
            button    : '.my-btn'
        });*/
	
// $(document).ready(function(e) {
// 	$("#msg").get("asdjda.php");
// 	$(document).ajaxError(function( event, request, settings ) {
// 	alert("colo");
//   $("#msg").append("<li>Error requesting page " + settings.url + "</li>");
// });

// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
// btn.onclick = function() {
    
//     modal.style.display = "block";
// }
function momodal()
{
    modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

    </script>
</body>
</html>