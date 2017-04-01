<?php
/**
 * Created by IntelliJ IDEA.
 * User: Green
 * Date: 2013/7/17
 * Time: 下午 12:09
 */
class CreatePersonalImageModel{
	public function createImage($uid){
		$data = $this->getActiveStyleData($uid);

		// Create the main
		$mainImage= imagecreatefrompng("./file/img/profile/main.png");

		foreach($data as $dataRow){
			$partImage = imagecreatefrompng('./file/img/style/'.$dataRow['sid'].'.png');
			imagecopyresized ($mainImage, $partImage, $dataRow['src_x'], $dataRow['src_y'], 0, 0, $dataRow['part_width'], $dataRow['part_height'], imagesx($partImage), imagesy($partImage));
			imagedestroy($partImage);
		}
		imagepng($mainImage, './file/img/personal/' . $uid .'.png');
		imagedestroy($mainImage);
	}

	public function getActiveStyleData($uid){
		$connection = Yii::app()->db;
		$sql = "SELECT *
				FROM `game_owned_style`
				INNER JOIN `game_shop_style`
					ON `game_owned_style`.`sid` = `game_shop_style`.`sid`
				WHERE `game_owned_style`.`uid` = :uid
					AND `game_owned_style`.`active` = '1'";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$dataReader = $command->query();
		$data = $dataReader->readAll();

		return $data;
	}
}