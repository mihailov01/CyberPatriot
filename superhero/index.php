
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/adaptive.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SuperHero</title>
    <script src="jquery.min.js"></script>

</head>
<body>
  <header>
    <br/>
    <br/>
    <p class="hed">МОЯ <strong>СУПЕР КОМАНДА</strong></p>
    <hr class="hr-line">
    <hr class="hr-line-2">
  </header>
  
  <div id="sliderShow" class="slideshow-container">
    <div id="mySlide" class="mySlides fade">

    <?php
// Подключение к БД.
$dbh = new PDO('mysql:dbname=shero;host=localhost', 'root', '');
 
$sth = $dbh->prepare("SELECT * FROM `reviews` ORDER BY `date_add` DESC");
$sth->execute();
$items = $sth->fetchAll(PDO::FETCH_ASSOC);
 
if (!empty($items)) {
	?>


		<?php
		foreach ($items as $row) {
			$sth = $dbh->prepare("SELECT * FROM `reviews_images` WHERE `reviews_id` = ?");
			$sth->execute(array($row['id']));
			$images = $sth->fetchAll(PDO::FETCH_ASSOC);
			?>
			
      
     
				<?php if (!empty($images)): ?>
				
					<?php foreach($images as $img): ?>
						<?php 
						$name = pathinfo($img['filename'], PATHINFO_FILENAME);
						$ext = pathinfo($img['filename'], PATHINFO_EXTENSION);
						?>
            <div class="block">
						<a href="/uploads/<?php echo $img['filename']; ?>" target="_blank">
							<img style="border-radius: 50%;width: 100px;height: 100px;" src="/uploads/<?php echo $name . '-thumb.' . $ext; ?>">
						</a>
            <div class="name"><strong><?php echo $row['name']; ?></strong></div>
            <div class="name2"><?php echo $row['text']; ?></div>
            <br>
            <div class="name2">Дата вступления в команду:<br>
              <?php echo $row['mydate']; ?>
              </div> 
            </div>
					<?php endforeach; ?>
				
				<?php endif; ?>
			
			<?php
		}
		?>
	
	<?php
}
?>
 
    






      <!-- <div class="block1_1">
        <img src="img/kosmodem.jpg" alt="" width="100" height="100" >
        <div class="name">Зоя Космодемьянская</div>
        <div class="name2">Партизан</div>
      </div> -->
    










    </div>
    <br>
  <!-- The dots/circles -->
  <div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
  </div>
  <script src="js/slider.js"></script>
  </div>


     


  <div class="my_hero1">
    <p class="hed">ДОБАВЬ СВОЕГО <strong>ГЕРОЯ</strong></p>
    <hr class="hr-line">
    <hr class="hr-line-2">
    
<!--     <div class="form">
      <form method="POST" action="save_reviews.php">
        <div class="container">
          <div class="left">Имя</div>
          <div class="right">Титул</div>
        </div>
        <lable><input type="text" name="name" required></lable>
        <lable><input type="text" name="text" required></lable><br>

        <div id="upload-container">
        <div>
          <p id= 'left_text'></p>
          <input id="js-file" type="file" name="file[]" multiple>
          <span> Чтобы добавить фото героя перетащите изображение в это поле или просто</span><label for="js-file"> кликнете сюда</label> 
        </div>
        
        <div class="js-file" id="js-file-list"></div>
		    <input id="js-file"  type="file" name="file[]" multiple accept=".jpg,.jpeg,.png,.gif">
        <input id="btn" type="submit" name="send" value="ПРИНЯТЬ ">
        
       
      </form>   
    </div>  -->
    <div class="form">
      <form method="POST" action="save_reviews.php">
        <div class="container">
          <div class="left">Имя</div>
          <div class="right">Титул</div>
        </div>
        <lable><input type="text" name="name" required></lable>
        <lable><input type="text" name="text" required></lable><br>


        <div id="upload-container">
        <div>
          <p id= 'left_text'></p>
          <input id="js-file" type="file" name="file[]" multiple>
          <span><strong> Чтобы добавить фото героя перетащите изображение в это поле или просто</span><label for="js-file"> кликнете сюда</label></span> 
        </div>
        </div>

        <div class="js-file" id="js-file-list"></div>
<!-- 		    <input id="js-file"  type="file" name="file[]" multiple accept=".jpg,.jpeg,.png,.gif">
 -->        <input id="btn" type="submit" name="send" value="ПРИНЯТЬ ">
      </form>   
    </div>  

  </div>      
   
  <footer id="footer" >
    <div class="fname">КЕЙС ВЫПОЛНИЛА КОМАНДА <strong >CYBERPATRIOT</strong></div>
    <div class="footer_social">
      <a class="footer_link" href="#">
        <img src="img/facebook_icon.png" alt="">
      </a>
      <a class="footer_link" href="#">
        <img src="img/twitter_icon.png" alt="">
      </a>
      <a class="footer_link" href="#">
        <img src="img/instagram_icon.png" alt="">
      </a>
      <a class="footer_link" href="#">
        <img src="img/linkedin_icon.png" alt="">
      </a>
    </div>         
  </footer>   

</body>
</html>

<script>
$("#js-file").change(function(){
	if (window.FormData === undefined) {
		alert('В вашем браузере загрузка файлов не поддерживается');
	} else {
		var formData = new FormData();
		$.each($("#js-file")[0].files,function(key, input){
			formData.append('file[]', input);
		});
 
		$.ajax({
			type: 'POST',
			url: 'upload_image.php',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			dataType : 'json',
			success: function(msg){
				msg.forEach(function(row) {
					if (row.error == '') {
						$('#js-file-list').append(row.data);
					} else {
						alert(row.error);
					}
				});
				$("#js-file").val(''); 
			}
		});
	}
});

/* Удаление загруженной картинки */
function remove_img(target){
	$(target).parent().remove();
}
</script>