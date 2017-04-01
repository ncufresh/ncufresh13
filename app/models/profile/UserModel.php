<?php
/**
 * Created by IntelliJ IDEA.
 * User: Green
 * Date: 2013/7/25
 * Time: 上午 11:06
 */

class UserModel{

	public function getPublicUserProfile($uid){
		$connection = Yii::app()->db;

		$sql = "SELECT `general_user_profile`.`uid` , `general_user_profile`.`name`, `general_user_profile`.`nickname`, `game_user_profile`.`money`, `general_user_profile`.`username`, `general_department`.`department_name`, `general_user_profile`.`grade`, `general_user_profile`.`high_school`, `general_user_profile`.`birthday`, `general_user_profile`.`skin_id`
				FROM `general_user_profile`
				INNER JOIN `general_department`
					ON `general_user_profile`.`department_id` = `general_department`.`department_id`
				INNER JOIN `game_user_profile`
					ON `general_user_profile`.`uid` = `game_user_profile`.`uid`
				WHERE `general_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);

		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$row = $command->queryRow();
		return $row;
	}

	public function updateUserProfile($uid, $column, $to){
		$connection = Yii::app()->db;

		$sql = "UPDATE `general_user_profile`
				SET `general_user_profile`.`".$column."` = :to
				WHERE `general_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);

		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":to", $to, PDO::PARAM_STR);

		$command->execute();
	}
}