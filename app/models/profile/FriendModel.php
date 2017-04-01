<?php
/**
 * Created by IntelliJ IDEA.
 * User: Green
 * Date: 2013/7/23
 * Time: 下午 8:47
 */

class FriendModel{

	public function getFriendList($uid){
		$connection = Yii::app()->db;
		$sql = "SELECT `general_user_profile`.`uid`, `general_user_profile`.`nickname`, `general_user_profile`.`skin_id`, `general_user_profile`.`fb`
				FROM `general_friend`
				INNER JOIN `general_user_profile`
					ON `general_user_profile`.`uid` = `general_friend`.`uid_him`
				WHERE `general_friend`.`uid_me` = :uid_me";

		$command = $connection->createCommand($sql);

		$command->bindParam(":uid_me", $uid, PDO::PARAM_STR);
		$dataReader = $command->query();
		$data = $dataReader->readAll();
		return $data;
	}

	public function getIsFriend($uid_me, $uid_him){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `general_friend`
				WHERE `general_friend`.`uid_me` = :uid_me
				AND `general_friend`.`uid_him` = :uid_him";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid_me", $uid_me, PDO::PARAM_STR);
		$command->bindParam(":uid_him", $uid_him, PDO::PARAM_STR);

		$row = $command->queryRow();
		return $row;
	}

	public function updateFriendConfirm($uid_me, $uid_him, $confirm = 1){
		$connection = Yii::app()->db;

		$sql = "UPDATE `general_friend`
				SET `general_friend`.`confirm` = :confirm
				WHERE  `general_friend`.`uid_me` = :uid_me
					AND `general_friend`.`uid_him` = :uid_him";

		$command = $connection->createCommand($sql);
		$command->bindParam(":confirm", $confirm, PDO::PARAM_STR);
		$command->bindParam(":uid_me", $uid_me, PDO::PARAM_STR);
		$command->bindParam(":uid_him", $uid_him, PDO::PARAM_STR);

		$command->execute();
	}

	public function addFriend($uid_me, $uid_him){
		if($this->getIsFriend($uid_me, $uid_him) == false){
			if($this->getIsFriend($uid_him, $uid_me) == false){
				$this->addFriendToDB($uid_me, $uid_him);
			}else{
				$this->addFriendToDB($uid_me, $uid_him, 1);
				$this->updateFriendConfirm($uid_him, $uid_me, 1);
			}
			$userModel = new UserModel;
			$userProfile = $userModel->getPublicUserProfile($uid_me);

			$word = "安安你好，我是{{name}}，我加你好友嚕，很高興認識你:)";
			$word = str_replace("{{name}}",$userProfile['nickname'],$word);

			$messageModel = new MessageModel;
			$messageModel->addMessage($uid_me, $uid_him, $word);

		}else{

		}
	}

	public function addFriendToDB($uid_me ,$uid_him, $confirm = 0){
		$connection = Yii::app()->db;

		$sql = "INSERT INTO `general_friend`
				(`pid`, `uid_me`, `uid_him`, `last_send`, `confirm`)
				VALUES
				(NULL, :uid_me, :uid_him, NULL, :confirm)";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid_me", $uid_me, PDO::PARAM_STR);
		$command->bindParam(":uid_him", $uid_him, PDO::PARAM_STR);
		$command->bindParam(":confirm", $confirm, PDO::PARAM_STR);

		$command->execute();
	}

	public function removeFriend($uid_me, $uid_friend){
		$connection = Yii::app()->db;

		$sql = "DELETE FROM
				`general_friend`
				WHERE
				`general_friend`.`uid_me` = :uid_me
				AND `general_friend`.`uid_him` = :uid_him";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid_me", $uid_me, PDO::PARAM_STR);
		$command->bindParam(":uid_him", $uid_friend, PDO::PARAM_STR);

		$command->execute();
	}

	public function getSuggestFriendList($uid, $wantedRow=10){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `general_user_profile`
				WHERE `general_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);

		$userProfile = $command->queryRow();

		$sql = "SELECT *
				FROM `general_user_profile`
				WHERE
					`general_user_profile`.`level` > 50
					AND(
						`general_user_profile`.`department_id` = :department_id
						OR `general_user_profile`.`sex` = :sex
						OR `general_user_profile`.`high_school` = :high_school
					)
					AND `general_user_profile`.`uid` NOT IN (
						SELECT `uid_him`
						FROM `general_friend`
						WHERE `general_friend`.`uid_me` = :uid_me
					)
					AND `general_user_profile`.`uid` != :uid_me

				ORDER BY RAND()
				LIMIT 0 ,".$wantedRow;

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid_me", $uid, PDO::PARAM_STR);
		$command->bindParam(":department_id", $userProfile['department_id'], PDO::PARAM_STR);
		$command->bindParam(":sex", $userProfile['sex'], PDO::PARAM_STR);
		$command->bindParam(":high_school", $userProfile['high_school'], PDO::PARAM_STR);
		$command->bindValue(":wantedRow", $wantedRow, PDO::PARAM_STR);

		return $command->queryAll();


	}
}