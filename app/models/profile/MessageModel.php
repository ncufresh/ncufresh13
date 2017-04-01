<?php
/**
 * Created by IntelliJ IDEA.
 * User: Green
 * Date: 2013/7/24
 * Time: 下午 7:48
 */

class MessageModel{

	public function addMessage($uid_from, $uid_to, $message){
		if(stristr($message, "script") === false){
			$connection = Yii::app()->db;
			$sql = "INSERT INTO `profile_message`
					(`uid_from`, `uid_to`, `message`)
					VALUES
					(:uid_from, :uid_to, :message)";
			$command = $connection->createCommand($sql);

			$command->bindParam(":uid_from", $uid_from, PDO::PARAM_STR);
			$command->bindParam(":uid_to", $uid_to, PDO::PARAM_STR);
			$command->bindParam(":message", $message, PDO::PARAM_STR);

			$command->execute();
		}
	}

	public function getMessageByUid($uid){
		$connection = Yii::app()->db;
		$sql = "SELECT `profile_message`.`pid`, `profile_message`.`message`, `profile_message`.`time`, `profile_message`.`uid_from`, `general_user_profile`.`nickname`, `general_user_profile`.`fb`, `general_user_profile`.`skin_id`
				FROM `profile_message`
				INNER JOIN `general_user_profile`
					ON `profile_message`.`uid_from` = `general_user_profile`.`uid`
				WHERE `profile_message`.`uid_to` = :uid
					AND `profile_message`.`available` = '1'
				ORDER BY  `profile_message`.`time` DESC ";

		$command = $connection->createCommand($sql);

		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$dataReader = $command->query();
		$data = $dataReader->readAll();
		for($i = 0; $i < count($data); $i++){
			$data[$i]['message'] = CHtml::encode(nl2br($data[$i]['message']));
		}
		return $data;
	}

	public function deleteMessageByPid($pid, $uid){
		$connection = Yii::app()->db;
		$sql = "SELECT `profile_message`.`uid_to`, `profile_message`.`uid_from`
				FROM `profile_message`
				WHERE `profile_message`.`pid` = :pid";

		$command = $connection->createCommand($sql);

		$command->bindParam(":pid", $pid, PDO::PARAM_STR);
		$data = $command->queryRow();

		if($data['uid_from'] == $uid || $data['uid_to'] == $uid){
			$sql = "UPDATE `profile_message`
					SET `profile_message`.`available` = '0'
					WHERE `profile_message`.`pid` = :pid";

			$command = $connection->createCommand($sql);

			$command->bindParam(":pid", $pid, PDO::PARAM_STR);
			$command->query();
			return true;
		}
		return false;
	}
}