<?php
/**
 * Created by IntelliJ IDEA.
 * User: asus
 * Date: 2013/7/20
 * Time: 上午 11:54
 * To change this template use File | Settings | File Templates.
 */

class GiftModel {

	public function getGiftQuery($uid, $received = 0){
		$connection = Yii::app()->db;
		$sql = "SELECT `game_gift_query`.`pid`, `game_gift_query`.`cid`, `general_user_profile`.`nickname`
				FROM `game_gift_query`
				INNER JOIN `general_user_profile`
					ON `game_gift_query`.`send_uid` = `general_user_profile`.`uid`
				WHERE `game_gift_query`.`receive_uid` = :uid
					AND `game_gift_query`.`received` = :received";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":received", $received, PDO::PARAM_STR);

		$dataReader = $command->query();
		$data = $dataReader->readAll();

		return $data;
	}

	public function sendGiftTo($uid_from, $uid_to, $cid){
		$gameModel = new GameModel;
		if($gameModel->getIsFriend($uid_from, $uid_to) != NULL){
			$row = $this->getSendTime($uid_from, $uid_to);
			$dbTime = strtotime(($row['last_send'])) + 28800;
			$nowTime = time();
			if((floor ($nowTime/86400) - floor($dbTime/86400)) > 0){
				$this->addGiftToQuery($uid_from, $uid_to, $cid);
				return true;
			}else{
				return false;
			}
		}else{
			if($uid_from == Yii::app()->params['game']['gifter_id']){
				$this->addGiftToQuery(Yii::app()->params['game']['gifter_id'], $uid_to, $cid);
			}else{
				return false;
			}
		}
	}

	private function getSendTime($uid_from, $uid_to){
		$connection = Yii::app()->db;
		$sql = "SELECT `last_send`
				FROM `general_friend`
				WHERE `general_friend`.`uid_me` = :uid_from
					AND `general_friend`.`uid_him` = :uid_to";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid_from", $uid_from, PDO::PARAM_STR);
		$command->bindParam(":uid_to", $uid_to, PDO::PARAM_STR);

		$dataReader = $command->queryRow();

		return $dataReader;
	}

	public function getCidByGiftPid($pid){
		$connection = Yii::app()->db;
		$sql = "SELECT `cid`, `receive_uid`
				FROM `game_gift_query`
				WHERE `game_gift_query`.`pid` = :pid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":pid", $pid, PDO::PARAM_STR);

		$dataReader = $command->queryRow();

		return $dataReader;

	}

	public function deliverGift($pid, $uid, $cid){
		$gameModel = new GameModel;

		$connection = Yii::app()->db;
		$sql = "UPDATE `game_gift_query`
				SET `received` = '1'
				WHERE `game_gift_query`.`pid` = :pid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":pid", $pid, PDO::PARAM_STR);

		$command->query();

		if($cid != 12){
			$gameModel->addPlayerCard($uid, $cid);
		}else{
			$gameModel->addPlayerEnergy($uid);
		}
	}

	public function addGiftToQuery($uid_from, $uid_to, $cid){
		$connection = Yii::app()->db;
		$sql = "INSERT INTO  `game_gift_query`
				(`pid`, `send_uid`, `receive_uid`, `cid`, `received`)
				VALUES
				(NULL, :uid_from, :uid_to, :cid, '0')";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid_from", $uid_from, PDO::PARAM_STR);
		$command->bindParam(":uid_to", $uid_to, PDO::PARAM_STR);
		$command->bindParam(":cid", $cid, PDO::PARAM_STR);
		$command->execute();

		$sql = "UPDATE `general_friend`
				SET `last_send` = NOW()
				WHERE `uid_me` = :uid_from
				AND `uid_him` = :uid_to";
		$command = $connection->createCommand($sql);
		$command->bindParam(":uid_from", $uid_from, PDO::PARAM_STR);
		$command->bindParam(":uid_to", $uid_to, PDO::PARAM_STR);
		$command->execute();
	}
}