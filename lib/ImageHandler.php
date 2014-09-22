<?php



class ImageHandler

{

	private $image;
	private $url;
	private $width;
	private $height;
	private $ratio;
	private $size;
	private $errors = Array();
	
	function __construct($url)
	{
		$this->url = $url;
		$this->success = $this->setupImage($this->url);
	}
	
	function setupImage($url)
	{
		$size = getimagesize($url);
		if($size){
			$this->image	= imagecreatefromstring(file_get_contents($url));
			$this->width 	= imagesx($this->image);
			$this->height 	= imagesy($this->image);
			$this->ratio	= $this->width/$this->height;
			$this->string 	= file_get_contents($url);
			return true;
		}
		else{
			$this->errors[] = "Error: File does not exist, or is not an image.";
			return false;
		}
	}
	
	function saveImage($name, $newWidth, $newHeight, $offsetX = 0, $offsetY = 0)
	{
		$new = imagecreatetruecolor($newWidth,$newHeight);
		
		imagecopyresampled( $new, $this->image,	0, 0, $offsetX, $offsetY, $newWidth, 
							$newHeight, ($this->width)-($offsetX*2), ($this->height)-($offsetY*2));
		
		if(imagejpeg($new, $name))
			return true;
		else
			return false;

	}

	

	public function scaleImage($name, $maxWidth, $maxHeight)
	{
		$scaleRatio = $maxWidth/$maxHeight;
	
		//kolla först om bilden är mindre än både maxbredd och maxhöjd, skala isf inte alls

		if($this->width <= $maxWidth && $this->height <= $maxHeight){
			$newHeight = $this->height;
			$newWidth  = $this->width;
		}

		else{
			//skala på maxbredden

			if($this->ratio < $scaleRatio){
				$newHeight = $maxHeight;
				$newWidth  = floor($this->width * ($maxHeight / $this->height));
			}

			//skala på maxhöjden
			else{
				$newWidth  = $maxWidth;
				$newHeight = floor($this->height * ($maxWidth / $this->width));
			}
		}

		if(($this->saveImage($name, $newWidth, $newHeight)) === false){
			$this->errors[] = "Error: Could not scale image.";
			return false;
		}

		else
			return true;

	}



	public function cropImage($name, $wantedWidth, $wantedHeight)
	{	
		$offsetX = 0;
		$offsetY = 0;
	
		$cropRatio = $wantedWidth/$wantedHeight;
		
		//originalet är bredare
		if ($this->ratio < $cropRatio){
			$newWidth 		= $this->width;
			$newHeight		= $this->width / $cropRatio;
			$offsetY		= ($this->height - $newHeight) / 2;
		}

		//originalet är smalare
		else{
			$newHeight 		= $this->height;
			$newWidth		= $this->height * $cropRatio;
			$offsetX		= ($this->width - $newWidth) / 2;
		}
		
		if(($this->saveImage($name, $wantedWidth, $wantedHeight, $offsetX, $offsetY)) === false){
				$this->errors[] = "Error: Could not crop image.";
				return false;
			}

		else
			return true;

	}			

	
	public function printImageInfo()
	{
		print_r($this->url);
	}


	public function hashImageName($name)
	{
		$hash = $this->string;

		return substr(md5($hash),8,8);
	}



	public function getErrors()
	{
		return $this->errors;
	}

}

