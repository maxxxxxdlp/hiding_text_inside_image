<!DOCTYPE html>
<html>
	<head>
		<title>Hiding Text in Image</title>
		<link href="https://mambo.in.ua/map/data/bootstrap4/bootstrap.min.css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<style>
			.l {
				float: left;
			}
			.r {
				float: right;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-12 col-sm-6">
					<h2 class="text-center">Text into image</h2>
					<form method="post" enctype="multipart/form-data" class="full-width">
						<div class="col-12 mb-4"><input type="file" accept="image/*" id="intoImage" name="intoImage"></div>
						<div class="col-12 mb-2">
							<textarea id="inputText" class="form-control" placeholder="Text" name="inputText"></textarea>
							<span class="form-text text-mutted" id="maxLength"></span>
						</div>
						<div class="col-12 mb-2"><input type="submit" name="intoSubmit" value="Proceed" class="btn btn-lg btn-primary"></div>
						<script>
							var _URL = window.URL || window.webkitURL;
							$("#intoImage").change(function(e){
								var image, file;
								if ((file = this.files[0])) {
									image = new Image();
									image.onload = function() {

										maxTextSize = parseInt(this.width * this.height * 0.375) - 1;// wh * 3 / 8.   3 - rgb   8 - bits in 1 charheight);
										
								  $('#inputText').attr('maxlength',maxTextSize);
								  $('#maxLength').text('Max text length: '+maxTextSize);

									};
									image.src = _URL.createObjectURL(file);
								}
							});

						</script>
					</form>
				</div>
				<div class="col-12 col-sm-6">
					<h2 class="text-center">Text from image</h2>
					<form method="post" enctype="multipart/form-data" class="full-width">
						<div class="col-12 mb-4"><input type="file" accept="image/*" name="fromImage"></div>
						<div class="col-12 mb-2"><input type="submit" name="fromSubmit" value="Proceed" class="btn btn-lg btn-primary"></div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-sm-6"> <?php

					function separator(){
						echo '<h2 class="mb-4">Result:</h2>';
					}
					function stringBase64toStringBin($input){
						$data = '';
						for($i = 0; $i < strlen($input); $i++){
							$buf = decbin(ord($input[$i]));
							if(strlen($buf)<9)
								$data .= str_repeat('0',8 - strlen($buf)).$buf/*.' '*/;
						}
						/*$arr = unpack("C*",$input);
						$str = '';
						foreach($arr as $v)
							$str .= decbin($v);*/
						return $data;
					}
					function bin2ascii($input){
						for($output = '',$i=0; $i<strlen($input); $i+=8)
							$output .= chr(intval(substr($input, $i, 8), 2));
						return $output;
					}
					/*function bin2ascii($input){
						return pack('H*', base_convert($input, 2, 16));
					}*/
					/*function base64toBin($character){
							return sprintf("%08b", ord($character));
					}
					function stringBase64toArrBin($input){
						$b = NULL;
						for($i = 0; $i < strlen($input); $i++ )
							$b[] = base64toBin($input[$i]);
						return $b;
					}
					function base2toBase64($bin) {
						$str = '';
						for($i = 0; $i < strlen($bin); $i++)
						 $str .= chr(bindec($bin[$i]));
						return base64_encode($str);
					}
					function bin2base64($bin) {
						$arr = str_split($bin, 8);
						$str = '';
						foreach ( $arr as $binNumber ){
						 $str .= chr(bindec($binNumber));
						 //echo var_dump(chr(bindec($binNumber)));
						}
						return $str;
					}*/

					//echo var_dump(getimagesize($_FILES['intoImage']['tmp_name']));
					//echo var_dump($_FILES['intoImage']['tmp_name']);
					//echo var_dump($_POST['intoImage']);
					if(getimagesize($_FILES['intoImage']['tmp_name'])){
						separator();

						$tempPos = $_FILES['intoImage']['tmp_name'];
						//$imageData = file_get_contents($tempPos);
						$ext = pathinfo($_FILES['intoImage']['name'], PATHINFO_EXTENSION);
						switch($ext){
							case 'jpeg':
							case 'jpg':
							case 'jfjf': $image = imagecreatefromjpeg($tempPos); break;
							case 'png': $image = imagecreatefrompng($tempPos); break;
							//case 'bmp':
							case 'wbmp': $image = imagecreatefromwbmp($tempPos); break;
							case 'bmp': $image = imagecreatefrombmp($tempPos); break;
							case 'gif': $image = imagecreatefromgif($tempPos); break;
							case 'gd2': $image = imagecreatefromgd2($tempPos); break;
							case 'gd': $image = imagecreatefromgd($tempPos); break;
							case 'webp': $image = imagecreatefromwebp($tempPos); break;
							case 'xbm': $image = imagecreatefromxbm($tempPos); break;
							default: $image = imagecreatefromjpeg($tempPos); break;
							//case 'xpm': $image = imagecreatefromxpm($tempPos); break;
						}

						//$image = imagecreatefromjpeg($_FILES['intoImage']['tmp_name']);
						//$image = imagecreatefromstring($imageData);

						//echo var_dump($ext);
						//echo var_dump($image==$tempImg);
						//echo var_dump($image);
						//echo var_dump($tempImg);

						$width = imagesx($image);
						$height = imagesy($image);
						$maxTextLength = $width * $height * 0.375;
						$colors = array();

						//echo var_dump($image);
						//echo var_dump($width);
						//echo var_dump($height);

						//$imageData = base64_encode($imageData);
						//$oldImageData = $imageData;

						//$b = stringBase64toArrBin($imageData);

						//$oldB = $b;

//0         1         2         3
//☺☻♥♦♣♠•◘○◙♂♀♪♫☼►◄↕‼¶§▬↨↑↓→←∟↔▲▼
//                  ‼  ▬↨     ↔  

						$inputText = $_POST['inputText'];
						//$inputText .= '↔';//29
						//echo var_dump($inputText);
						$inputBin = stringBase64toStringBin($inputText);
						$inputBin .= '00000000';
						if(strlen($inputBin)%3 != 0)
							$inputBin .= '0';
						if(strlen($inputBin)%3 != 0)
							$inputBin .= '0';
						//echo var_dump($inputBin);

						//echo var_dump($inputBin);

						/*for($i = 200; $i+200 < count($b); $i++ ){
							//echo var_dump(floor($i/8));
							//echo var_dump($i%8);
							$b[$i][7]=$inputBin[floor($i/8)][$i%8];

						}*/
						$resImg = imagecreatetruecolor($width, $height);
						//imagealphablending($resImg, false);
						//imagesavealpha($resImg,true);
						$color = imagecolorallocate($res, 255, 255, 255);
						//imagefilledrectangle($res, 0, 0, $wi, $he, $color);
						imagefill($res, 0, 0, $color);

						//if(strlen($inputBin) > $maxTextLength)
						//	$inputBin = substr($inputBin,0,$maxTextLength);

						/*function b($v){
							if($v === "1")
								return 1;
							else
								return 0;
						}*/

						$i = 0;
						echo var_dump($inputBin).'<br>';
						for ($y = 0; $y < $height; $y++) {
							//$y_array = array();
							for ($x = 0; $x < $width; $x++) {
								$rgb = imagecolorat($image, $x, $y);
								$colorInfo = imagecolorsforindex($image, $rgb);
								//echo $rgb." = ".decbin($rgb),"<br>";
								//$r = ($rgb >> 16) & 0xFF;
								//$g = ($rgb >> 8) & 0xFF;
								//$b = $rgb & 0xFF;
								//$transparency = ($color >> 24) & 0x7F;
								//echo var_dump($colorInfo).' ';
								$r = $colorInfo['red'];
								$g = $colorInfo['green'];
								$b = $colorInfo['blue'];
								$transparency = $colorInfo['alpha'];
								//echo $transparency. ' ' ;
								if($transparency == 127){
									$r = 255;
									$g = 255;
									$b = 255;
								}

								if($i < strlen($inputBin)){
									$binR = decbin($r);
									$binG = decbin($g);
									$binB = decbin($b);

									$binR = str_repeat('0', 8 - strlen($binR)) . $binR;
									$binG = str_repeat('0', 8 - strlen($binG)) . $binG;
									$binB = str_repeat('0', 8 - strlen($binB)) . $binB;

									//echo $y . 'x' . $x . '=' . $i.' | '.$r.' '. $g . ' ' . $b . ' ' . $binR. ' '. $binG. ' '. $binB. ' '. $inputBin[$i] .' '. $inputBin[$i + 1] .' '. $inputBin[$i + 2] .' ';

									$binR[7] = $inputBin[$i];
									$binG[7] = $inputBin[$i + 1];
									$binB[7] = $inputBin[$i + 2];

									$r = bindec($binR);
									$g = bindec($binG);
									$b = bindec($binB);
									//echo $r . ' ' . $g . ' ' . $b . '<br>';
									$i += 3;
								}

								//echo var_dump(b($inputBin[$i*3]));
								//echo var_dump($rgb);
								//echo var_dump($r);
								//echo var_dump($b + b($inputBin[$i*3 + 2]));

								//$newColor = imagecolorallocate($resImg, $r + b($inputBin[$i*3]), $g + b($inputBin[$i*3 + 1]), $b + b($inputBin[$i*3 + 2]));
								//$newColor = imagecolorallocate($resImg, $r + $inputBin[$i*3], $g + $inputBin[$i*3 + 1], $b + $inputBin[$i*3 + 2]);
								$newColor = imagecolorallocate($resImg, $r, $g, $b);
								imagesetpixel($resImg,$x,$y,$newColor);

								//$x_array = array($r, $g, $b);
								//echo var_dump($x_array)."<br>";
								//$y_array[] = $x_array;
							}
							//$colors[] = $y_array;
						}

						//header('Content-Type: image/'.$ext);

						ob_start();
						//imagepng($png);

						switch($ext){
							case 'jpeg':
							case 'jpg':
							case 'jfjf': $image = imagejpeg($resImg,NULL,100); break;
							case 'png': $image = imagepng($resImg,NULL,9,PNG_NO_FILTER); break;
							//case 'bmp':
							case 'wbmp': $image = imagewbmp($resImg); break;
							//case 'bmp': $image = imagebmp($resImg,NULL,false); break;
							case 'gif': $image = imagegif($resImg); break;
							case 'gd2': $image = imagegd2($resImg); break;
							case 'gd': $image = imagegd($resImg); break;
							case 'webp': $image = imagewebp($resImg,NULL,100); break;
							case 'xbm': $image = imagexbm($resImg); break;
							//case 'xpm': $image = imagexpm($resImg,NULL,0); break;
							default: $image = imagejpeg($resImg,NULL,100); break;
						}
						//imagepng($img);
						$imagedata = ob_get_contents();
						ob_end_clean();
						imagedestroy($resImg);
						echo '<a download="result.'.$ext.'" href="data:image/'.$ext.';base64,' . base64_encode($imagedata) . '">
							<img src="data:image/'.$ext.';base64,' . base64_encode($imagedata) . '">
						</a>';
						//echo '<img style="	max-width: 100%; max-height: 100vh;" src="data:image/'.$ext.';base64,' . base64_encode($imagedata) . '">';


						/*for ($y = 0; $y < $height; $y++) {
							for ($x = 0; $x < $width; $x++) {

							}
						}*/

						/*for($i=0; $i < strlen($inputBin) / 3; $i++){
							if(base64toBin($imageData[$i])[7]!=$inputBin[floor($i/8)][$i%8])
								$imageData[$i]=bin2base64(substr(base64toBin($imageData[$i]),0,-1).$inputBin[floor($i/8)][$i%8]);
						}*/

						//echo '<img src="data:image/bmp;base64,' . $imageData . '" />';


						/*for($i=0; $i < count($inputBin)*8; $i++)
							if(base64toBin($imageData[$i])[7]!=$inputBin[floor($i/8)][$i%8]){
								//echo $imageData[$i].' --> ';
								$imageData[$i]=bin2base64(substr(base64toBin($imageData[$i]),0,-1).$inputBin[floor($i/8)][$i%8]);
								//echo $imageData[$i].'<br>';
							}

						//echo '<pre style="
	//overflow:  visible;
//">';
						//echo var_dump($b[0]);

						//$newBase64 = base2toBase64(implode('',$b));
						//echo var_dump(implode('',$b));
						//echo var_dump(implode('',$oldB));
						//echo var_dump($imageData);
						//$newBase64 = bin2base64(implode('',$b));
						//echo var_dump($newBase64);

						//echo var_dump($imageData);
						echo '<img src="data:image/bmp;base64,' . $imageData . '" />';


						/*for($i = 0; $i < count($b);$i++){
							echo $oldB[$i].' ==> '.$oldB[$i].' _ '.(intval($oldB[$i][7],10) - intval($b[$i][7],10)).'<br>';
							if(intval($oldB[$i][7],10) - intval($b[$i][7],10))
								echo '<br>Bingo<br><br>';
						}*/
						/*for($i = 0; $i < strlen($newBase64);$i++){
							echo $imageData[$i].' ==> '.$imageData[$i].'<br>';
							if(base64toBin($imageData[$i]) != base64toBin($newBase64[$i]))
								echo '<br>'.base64toBin($imageData[$i]).' ___ '.base64toBin($newBase64[$i]).'<br>';
						}*/
						//echo var_dump($imageData);
						//echo var_dump($oldImageData);
						//echo '</pre>';

						//echo var_dump($b);
						} ?>
				</div>
				<div class="col-12 col-sm-6"><?php
					if(getimagesize($_FILES['fromImage']['tmp_name'])){
						separator();

						//$imageData = file_get_contents($_FILES['fromImage']['tmp_name']);
						//$imageData = base64_encode($imageData);

						$tempPos = $_FILES['fromImage']['tmp_name'];
						$ext = pathinfo($_FILES['fromImage']['name'], PATHINFO_EXTENSION);
						switch($ext){
							case 'jpeg':
							case 'jpg':
							case 'jfjf': $image = imagecreatefromjpeg($tempPos); break;
							case 'png': $image = imagecreatefrompng($tempPos); break;
							case 'wbmp': $image = imagecreatefromwbmp($tempPos); break;
							//case 'bmp': $image = imagecreatefrombmp($tempPos); break;
							case 'gif': $image = imagecreatefromgif($tempPos); break;
							case 'gd2': $image = imagecreatefromgd2($tempPos); break;
							case 'gd': $image = imagecreatefromgd($tempPos); break;
							case 'webp': $image = imagecreatefromwebp($tempPos); break;
							case 'xbm': $image = imagecreatefromxbm($tempPos); break;
							default: $image = imagecreatefromjpeg($tempPos); break;
						}

						$binMessage = '';
						$width = imagesx($image);
						$height = imagesy($image);
						$i = 0;
						$was = false;
						$nulls = 0;
						for ($y = 0; $y < $height; $y++) {
							for ($x = 0; $x < $width; $x++) {
								$rgb = imagecolorat($image, $x, $y);
								$colorInfo = imagecolorsforindex($image, $rgb);
								$r = $colorInfo['red'];
								$g = $colorInfo['green'];
								$b = $colorInfo['blue'];
								/*$r = ($rgb >> 16) & 0xFF;
								$g = ($rgb >> 8) & 0xFF;
								$b = $rgb & 0xFF;*/

								$binR = substr(decbin($r),-1);
								$binG = substr(decbin($g),-1);
								$binB = substr(decbin($b),-1);
								$binMessage .= $binR. $binG. $binB;
								if($binR === '0')
									$nulls++;
								else
									$nulls = 0;
								if($binG === '0')
									$nulls++;
								else
									$nulls = 0;
								if($binB === '0')
									$nulls++;
								else
									$nulls = 0;


								//if($i%8 < 3)
								//if($i < 500)
									//echo '<br>'.$binMessage  . ' ' . $i  . ' ' . $r . ' ';
								//if(strlen($binMessage)%8 == 0)
								//	echo substr($binMessage, $i - 8, 8);

								//if($i%8 == 0 && /*strlen(substr($binMessage, $i - 8, 8)) == 8 &&*/ substr($binMessage, $i - 8, 8) == "00000000")
								if(/*strpos($binMessage, "00000000") !== false*/ $nulls == 8){
									$was = true;
									break 2;
								}
								$i++;
							}
						}
						if(!$was)
							$message = "It looks like this image does not have encrypted text : ";
						$binMessage = substr($binMessage,0,strpos($binMessage,'00000000'));

						/*$binMessage='';
						for($i = 0; $i < strlen($imageData); $i++)
							$binMessage.=base64toBin($imageData[$i])[7];*/

						//$binMessage = '011100010111011101100101011100100111010001111001';
						//echo var_dump($i);
						echo var_dump($binMessage);
						$message = bin2ascii($binMessage);

						echo '<textarea style="margin-bottom: 100px;"class="form-control">'.$message.'</textarea>';

					} ?>
				</div>
			</div>
		</div>
	</body>
</html>
