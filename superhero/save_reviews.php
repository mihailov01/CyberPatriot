<?php
ini_set('display_errors', 1); 
 
// Временная директория.
$tmp_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/tmp/';
 
// Постоянная директория.
$path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
 
// Подключение к БД.


$dbh = new PDO('mysql:dbname=shero;host=localhost', 'root', '');
 
if (isset($_POST['send'])) {
	$name = htmlspecialchars($_POST['name'], ENT_QUOTES);	
	$text = htmlspecialchars($_POST['text'], ENT_QUOTES);
	
	$sth = $dbh->prepare("INSERT INTO `reviews` SET `name` = ?, `text` = ?, `date_add` = UNIX_TIMESTAMP()");
	$sth->execute(array($name, $text));
 
	// Получаем id вставленной записи.
	$insert_id = $dbh->lastInsertId();
	
	// Сохранение изображений в БД и перенос в постоянную папку.
	if (!empty($_POST['images'])) {
		foreach ($_POST['images'] as $row) {
			$filename = preg_replace("/[^a-z0-9\.-]/i", '', $row);
			if (!empty($filename) && is_file($tmp_path . $filename)) {
				$sth = $dbh->prepare("INSERT INTO `reviews_images` SET `reviews_id` = ?, `filename` = ?");
				$sth->execute(array($insert_id, $filename));
				
				// Перенос оригинального файла
				rename($tmp_path . $filename, $path . $filename);
				
				// Перенос превью
				$file_name = pathinfo($filename, PATHINFO_FILENAME);				
				$file_ext = pathinfo($filename, PATHINFO_EXTENSION);
				$thumb = $file_name . '-thumb.' . $file_ext;
				rename($tmp_path . $thumb, $path . $thumb);
			}
		}
	}
}
 
// Редирект, чтобы предотвратить повторную отправку по F5.
header('Location: index.php', true, 301);
exit();