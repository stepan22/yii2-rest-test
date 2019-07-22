<?php
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;
//use yii\imagine\Image;


class UploadFile extends Model
{
	/**
	 * @var UploadedFile
	 */
	public $imageFile;
	public function rules()
	{
		return [
			// [['imageFile'], 'safe']
			[['imageFile'], 'file', 'skipOnEmpty' => true],
			// [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
			//[['imageFile'], 'file', 'extensions' => 'jpg, jpeg, png'],	// 'gif, jpg, jpeg, png'
			[['imageFile'], 'file', 'maxSize' => '5000000'],
			[['imageFile'], 'image', 'extensions' => 'jpg, jpeg, png',	// gif
				'minWidth' => 50, 'maxWidth' => 1600,
				'minHeight' => 50, 'maxHeight' => 1600,
			],
		];
	}

	public function upload($id = null, $folder = null)
	{
		$path_img = '/var/www/smartypanel.ru/frontend/web/assets/images/'; //	\Yii::$app->basePath
		$path_thumb = $path_img.'thumbnails/';
		
		if ($folder != null) {
			$path_img .= $folder;
		}

		if ($this->imageFile) {
			if ($this->validate()) {
				if ($id !== null) {
					$img = $id . '-' . $this->imageFile->baseName . '.' . mb_strtolower($this->imageFile->extension, 'UTF-8');
					if ($this->imageFile->saveAs($path_img . $img)) {
						if ($this->imageFile->extension == 'jpg' || $this->imageFile->extension =='png') {
							\yii\imagine\Image::thumbnail($path_img . $img, 120, 120)
								->save(\Yii::getAlias($path_thumb . $img), ['quality' => 80]);
						}
						return true;
					} else {
						return false;
					}
				} else {
					$img = $this->imageFile->baseName . '.' . mb_strtolower($this->imageFile->extension, 'UTF-8');
					if ($this->imageFile->saveAs($path_img . $img)) {
						if ($this->imageFile->extension == 'jpg' || $this->imageFile->extension =='png') {
							\yii\imagine\Image::thumbnail($path_img . $img, 120, 120)
								->save(\Yii::getAlias($path_thumb . $img), ['quality' => 80]);
						}
						return true;
					} else {
						return false;
					}
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}