<?php
/**
 * Created by IntelliJ IDEA.
 * User: Green
 * Date: 2013/7/29
 * Time: 下午 7:18
 */

class SkinModel{

	public function getShopSkinList(){
		$connection = Yii::app()->db;

		$sql = "SELECT `game_shop_style`.`sid`, `game_shop_style`.`cost`, `game_shop_style`.`name`, `game_shop_style`.`message`
				FROM `game_shop_style` ORDER BY `sid` ASC";

		$command = $connection->createCommand($sql);
		$dataReader = $command->query();
		$data = $dataReader->readAll();
		return $data;
	}

	public function getOwnedSkinList($uid){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `game_owned_style`
				WHERE `game_owned_style`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$dataReader = $command->query();
		$data = $dataReader->readAll();
		return $data;
	}

	public function getShopSkinBySid($sid){
		$connection = Yii::app()->db;

		$sql = 'SELECT `game_shop_style`.`sid`, `game_shop_style`.`cost`
				FROM `game_shop_style`
				WHERE `game_shop_style`.`sid` = :sid';

		$command = $connection->createCommand($sql);
		$command->bindParam(":sid", $sid, PDO::PARAM_STR);
		return $command->queryRow();
	}

	public function getSkinByPid($pid){
		$connection = Yii::app()->db;

		$sql = 'SELECT `game_owned_style`.`sid`, `game_owned_style`.`uid`
				FROM `game_owned_style`
				WHERE `game_owned_style`.`pid` = :pid';

		$command = $connection->createCommand($sql);
		$command->bindParam(":pid", $pid, PDO::PARAM_STR);
		return $command->queryRow();
	}

	public function addSkinToUser($uid, $sid){
		$connection = Yii::app()->db;

		$sql = "INSERT INTO  `game_owned_style`
				(`pid`, `uid`, `sid`, `active`)
				VALUES
				(NULL, :uid, :sid, '0')";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":sid", $sid, PDO::PARAM_STR);
		$command->execute();
	}

	public function changeUserSkin($uid, $sid){
		$connection = Yii::app()->db;

		$sql = "UPDATE `general_user_profile`
				SET `general_user_profile`.`skin_id` = :sid
				WHERE `general_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":sid", $sid, PDO::PARAM_STR);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$dataReader = $command->execute();
	}
}