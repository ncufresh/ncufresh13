<?php


class GameModel{

	public static function firstTime($uid){
		$connection = Yii::app()->db;
		$sql = "INSERT INTO `game_user_profile`
				(`uid`)
				VALUES
				(:uid)";
		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->execute();
	}

	public function getDailyGift($uid){
		$connection = Yii::app()->db;
		$sql = "SELECT `login_time`
				FROM `game_user_profile`
				WHERE `game_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$row = $command->queryRow();

		$dbTime = strtotime(($row['login_time'])) + 28800;
		$nowTime = time();
		if((floor ($nowTime/86400) - floor($dbTime/86400)) > 0){
			$this->updateDailyGift($uid);
			return "TRUE";
		}else{
			return "FALSE";
		}
	}

	public function getMapData(){
		$connection = Yii::app()->db;
		$sql = "SELECT * FROM `game_map`";

		$command = $connection->createCommand($sql);
		$dataReader = $command->query();
		$data = $dataReader->readAll();

		return $data;
	}

	public function getPositionData($uid = 0){
		$connection = Yii::app()->db;
		$sql = "SELECT (`position`, `direction`) FROM `game_user_profile` WHERE `uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$row = $command->queryRow();

		$data['uid'] = $uid;
		$data['position'] = $row['position'];
		$data['direction'] = $row['direction'];

		return $data;
	}

	public function getPlayerDetail($uid = 0){
		$connection = Yii::app()->db;

		/*$sql = "SELECT `general_user_profile`.`uid` , `general_user_profile`.`nickname`, `game_user_profile`.`money`, `game_user_profile`.`energy`, `game_user_profile`.`position`, `game_user_profile`.`direction`, `game_user_profile`.`login_time`, `game_user_profile`.`data_chance`, `game_user_profile`.`data_money`, `game_user_profile`.`data_question`, `game_style`.`type`, `game_user_profile`.`bonus`, `game_user_profile`.`badgod`
				FROM `game_user_profile`
				INNER JOIN `general_user_profile`
					ON `game_user_profile`.`uid` = `general_user_profile`.`uid`
				INNER JOIN `game_style`
					ON `game_user_profile`.`uid` = `game_style`.`uid`
				WHERE `game_user_profile`.`uid` = :uid
				AND `game_style`.`active` = '1'";
*/

		$sql = "SELECT `general_user_profile`.`uid` , `general_user_profile`.`nickname`, `game_user_profile`.`money`, `game_user_profile`.`energy`, `game_user_profile`.`position`, `game_user_profile`.`direction`, `game_user_profile`.`login_time`, `game_user_profile`.`data_chance`, `game_user_profile`.`data_destiny`, `game_user_profile`.`data_money`, `game_user_profile`.`data_question`, `game_user_profile`.`bonus`, `game_user_profile`.`badgod`, `game_user_profile`.`all_achievement`, `general_user_profile`.`skin_id`
				FROM `game_user_profile`
				INNER JOIN `general_user_profile`
					ON `game_user_profile`.`uid` = `general_user_profile`.`uid`
				WHERE `game_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);

		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$row = $command->queryRow();

		return $row;
	}

	public function getFriendDetail($uid_me = 0){
		$connection = Yii::app()->db;

/*		$sql = "SELECT `general_user_profile`.`uid`, `game_user_profile`.`position`, `general_user_profile`.`nickname`, `general_user_profile`.`skin_id`
				FROM `general_friend`
				INNER JOIN `game_user_profile`
    				on `general_friend`.`uid_him` = `game_user_profile`.`uid`
				INNER JOIN `general_user_profile`
    				on `game_user_profile`.`uid` = `general_user_profile`.`uid`
    			INNER JOIN `game_style`
					ON `game_user_profile`.`uid` = `game_style`.`uid`
				WHERE `general_friend`.`uid_me` = :uid_me
				AND `game_style`.`active` = '1'";
	*/
		$sql = "SELECT `general_user_profile`.`uid`, `game_user_profile`.`position`, `general_user_profile`.`nickname`, `general_user_profile`.`skin_id`, `general_friend`.`last_send`
				FROM `general_friend`
				INNER JOIN `game_user_profile`
    				on `general_friend`.`uid_him` = `game_user_profile`.`uid`
				INNER JOIN `general_user_profile`
    				on `general_friend`.`uid_him` = `general_user_profile`.`uid`
				WHERE `general_friend`.`uid_me` = :uid_me";

		$command = $connection->createCommand($sql);

		$command->bindParam(":uid_me", $uid_me, PDO::PARAM_STR);
		$dataReader = $command->query();
		$data = $dataReader->readAll();
		return $data;

	}

	public function getOwnedFurnitureList($uid = 0, $active = false){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `game_owned_furniture`
				WHERE `game_owned_furniture`.`uid` = :uid
					AND `game_owned_furniture`.`active` LIKE :active";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		if($active){
			$command->bindValue(":active", 1, PDO::PARAM_STR);
		}else{
			$command->bindValue(":active", "%", PDO::PARAM_STR);
		}
		$dataReader = $command->query();
		$data = $dataReader->readAll();
		return $data;
	}

	public function getShopFurnitureList(){
		$connection = Yii::app()->db;

		$sql = "SELECT `game_shop_furniture`.`fid`, `game_shop_furniture`.`cost`, `game_shop_furniture`.`name`, `game_shop_furniture`.`message`
				FROM `game_shop_furniture`";

		$command = $connection->createCommand($sql);
		$dataReader = $command->query();
		$data = $dataReader->readAll();
		return $data;
	}

	public function getShopCardList(){
		$connection = Yii::app()->db;

		$sql = "SELECT `game_shop_card`.`cid`, `game_shop_card`.`cost`, `game_shop_card`.`name`, `game_shop_card`.`message`
				FROM `game_shop_card`";

		$command = $connection->createCommand($sql);
		$dataReader = $command->query();
		$data = $dataReader->readAll();
		return $data;
	}

	public function getOwnedCardList($uid = 0){
		$connection = Yii::app()->db;
		$sql = "SELECT `game_owned_card`.`pid`, `game_owned_card`.`type`
				FROM `game_owned_card`
				WHERE `game_owned_card`.`uid` = :uid
				AND `game_owned_card`.`available` = '1'";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$dataReader = $command->query();
		$data = $dataReader->readAll();

		return $data;
	}

	public function getMapUsingCard($uid = 0){
		$connection = Yii::app()->db;

		$sql = "SELECT `game_using_card`.`pid`, `game_using_card`.`mid`, `game_using_card`.`mid`
				FROM `game_using_card`
				INNER JOIN `general_friend`
					ON `game_using_card`.`uid` = `general_friend`.`uid_him`
				WHERE `general_friend`.`uid_me` = :uid
				AND `game_using_card`.`available` = '1'";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$dataReader = $command->query();
		$data = $dataReader->readAll();
		return $data;
	}

	public function getMapSpecial($uid, $type){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `game_special`
				WHERE `game_special`.`action_type` = :type";

		$command = $connection->createCommand($sql);
		$command->bindParam(":type", $type, PDO::PARAM_STR);

		$dataReader = $command->query();
		$data = $dataReader->readAll();

		$count = count($data);
		$randomNumber = rand(0, $count-1);

		$special = $data[$randomNumber];

		switch($type){
			case 0:
			case 1:
				$this->addPlayerDataChance($uid);
				break;
			case 2:
				$this->addPlayerDataDestiny($uid);
				break;
		}

		return $special;
	}

	public function getMapDataWithUsingCard($uid = 0){
		$mapData = $this->getMapData();
		$mapDataUsingCard = $this->getMapUsingCard($uid);
		foreach($mapDataUsingCard as $mapUsingCard){
			$mapData[$mapUsingCard['mid']]['usingCard'] = $mapUsingCard['type'];
			$mapData[$mapUsingCard['mid']]['usingCardPid'] = $mapUsingCard['pid'];
		}
		return $mapData;
	}

	public function getPidCardData($pid = 0){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `game_owned_card`
				WHERE `game_owned_card`.`pid` = :pid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":pid", $pid, PDO::PARAM_STR);

		$row = $command->queryRow();
		return $row;
	}

	public function getPidSpecialCardData($pid = 0){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `game_using_card`
				WHERE `game_using_card`.`pid` = :pid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":pid", $pid, PDO::PARAM_STR);

		$row = $command->queryRow();
		return $row;
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

	public function getChance(){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `game_special`
				WHERE `game_special`.`type` = '1'";

		$command = $connection->createCommand($sql);

		$dataReader = $command->query();
		$data = $dataReader->readAll();

		$count = count($data);

		$number = rand(0, $count-1);

		return $data[$number];
	}

	public function getDestiny(){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `game_special`
				WHERE `game_special`.`type` = '2'";

		$command = $connection->createCommand($sql);

		$dataReader = $command->query();
		$data = $dataReader->readAll();

		$count = count($data);

		$number = rand(0, $count-1);

		return $data[$number];
	}

	public function getQuestion(){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `game_special`
				WHERE `game_special`.`type` = '3'";

		$command = $connection->createCommand($sql);

		$dataReader = $command->query();
		$data = $dataReader->readAll();

		$count = count($data);

		$number = rand(0, $count-1);
		return $data[$number];
	}

	public function getSpecial($type){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `game_special`
				WHERE `game_special`.`type` = :type";

		$command = $connection->createCommand($sql);

		$command->bindParam(":type", $type, PDO::PARAM_STR);
		$dataReader = $command->query();
		$data = $dataReader->readAll();

		$count = count($data);

		$number = rand(0, $count-1);

		return $data[$number];
	}

	public function updatePlayerPosition($uid, $position, $direction){
		$connection = Yii::app()->db;

		$sql = "UPDATE `game_user_profile`
				SET `game_user_profile`.`position` = :position,
					`game_user_profile`.`direction` = :direction
				WHERE  `game_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":position", $position, PDO::PARAM_STR);
		$command->bindParam(":direction", $direction, PDO::PARAM_STR);

		$command->execute();
		return true;
	}

	public function checkAllAchievement($uid){
		$userProfile = $this->getPlayerDetail($uid);
		$data = 0;
		if($userProfile['data_chance'] >= 100){
			$data += 1;
		}
		if($userProfile['data_destiny'] >= 100){
			$data += 1;
		}
		if($userProfile['data_question'] >= 100){
			$data += 1;
		}
		if($userProfile['data_money'] >= 100){
			$data += 1;
		}

		if($userProfile['all_achievement'] == ($data+1) && $data >= 2){
			$db = $userProfile['all_achievement'];
			$giftModel = new GiftModel;
			for($i=1; $i<13; $i++){
				for ($j=0; $j<$data; $j++)
					$giftModel->addGiftToQuery(Yii::app()->params['game']['gifter_id'], $uid, $i);
			}
			$this->addPlayerDataAchievement($uid);
		}
	}

	public function addUsingCard($uid, $mid, $type){
		$connection = Yii::app()->db;

		$sql = "INSERT INTO  `game_using_card`
				(`pid`, `uid`, `type`, `mid`, `available`)
				VALUES
				(NULL, :uid, :type, :mid, '1')";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":type", $type, PDO::PARAM_STR);
		$command->bindParam(":mid", $mid, PDO::PARAM_STR);
		$command->execute();

	}

	public function addPlayerEnergy($uid){
		$beforeData = $this->getPlayerDetail($uid);

		$afterEnergy = $beforeData['energy'] + 1;

		if($afterEnergy > Yii::app()->params['game']['max_energy']){
			$afterEnergy = Yii::app()->params['game']['max_energy'];
		}

		$connection = Yii::app()->db;

		$sql = "UPDATE `game_user_profile`
				SET `game_user_profile`.`energy` = :afterEnergy
				WHERE `game_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":afterEnergy", $afterEnergy, PDO::PARAM_STR);
		$command->execute();
	}

	public function addPlayerMoney($uid, $addMoney){
		$beforeData = $this->getPlayerDetail($uid);

		$afterMoney = $beforeData['money'] + ($addMoney * $beforeData['bonus']);
		if($addMoney > 0){
			$afterDataMoney = $beforeData['data_money'] + ($addMoney * $beforeData['bonus']);
		}else{
			$afterDataMoney = $beforeData['data_money'];
		}

		if($afterMoney < -20){
			$afterMoney = -20;
		}

		$connection = Yii::app()->db;

		$sql = "UPDATE `game_user_profile`
				SET `game_user_profile`.`money` = :afterMoney,
					`game_user_profile`.`data_money` = :afterDataMoney
				WHERE `game_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":afterMoney", $afterMoney, PDO::PARAM_STR);
		$command->bindParam(":afterDataMoney", $afterDataMoney, PDO::PARAM_STR);
		$command->execute();
		if($beforeData['bonus'] == 2){
			$this->updatePlayerBonus($uid, 1);
		}

		$achievement = Yii::app()->params['game']['achievement']['money'];
		foreach($achievement as $key =>$thisAchievement){
			if(in_array($key, range($beforeData['data_money']+1, $afterDataMoney))){
				$giftModel = new GiftModel;
				$giftCardArray = $achievement[$key];
				foreach($giftCardArray as $goodCard){
					$giftModel->addGiftToQuery(Yii::app()->params['game']['gifter_id'], $uid, $goodCard);
				}
			}
		}
		$this->checkAllAchievement($uid);
		return $this->getPlayerDetail($uid);
	}

	public function addPlayerCard($uid, $type){
		$connection = Yii::app()->db;

		$sql = "INSERT INTO  `game_owned_card`
				(`pid`, `uid`, `type`, `available`)
				VALUES
				(NULL, :uid, :type, '1')";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":type", $type, PDO::PARAM_STR);
		$command->execute();

	}

	public function addPlayerDataChance($uid){
		$beforeData = $this->getPlayerDetail($uid);

		$afterDataChance = $beforeData['data_chance'] + 1;

		$connection = Yii::app()->db;

		$sql = "UPDATE `game_user_profile`
				SET `game_user_profile`.`data_chance` = :afterDataChance
				WHERE `game_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":afterDataChance", $afterDataChance, PDO::PARAM_STR);
		$command->execute();

		$achievement = Yii::app()->params['game']['achievement']['chance'];
		$key = array_key_exists($afterDataChance, $achievement);
		if ($key != false){
			$giftModel = new GiftModel;
			$giftCardArray = $achievement[$afterDataChance];
			foreach($giftCardArray as $goodCard){
				$giftModel->addGiftToQuery(Yii::app()->params['game']['gifter_id'], $uid, $goodCard);
			}
		}
		$this->checkAllAchievement($uid);
	}

	public function addPlayerDataDestiny($uid){
		$beforeData = $this->getPlayerDetail($uid);

		$afterDataDestiny = $beforeData['data_destiny'] + 1;

		$connection = Yii::app()->db;

		$sql = "UPDATE `game_user_profile`
				SET `game_user_profile`.`data_destiny` = :afterDataDestiny
				WHERE `game_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":afterDataDestiny", $afterDataDestiny, PDO::PARAM_STR);
		$command->execute();


		$achievement = Yii::app()->params['game']['achievement']['destiny'];
		$key = array_key_exists($afterDataDestiny, $achievement);
		if ($key != false){
			$giftModel = new GiftModel;
			$giftCardArray = $achievement[$afterDataDestiny];
			foreach($giftCardArray as $goodCard){
				$giftModel->addGiftToQuery(Yii::app()->params['game']['gifter_id'], $uid, $goodCard);
			}
		}
		$this->checkAllAchievement($uid);
	}

	public function addPlayerDataQuestion($uid){
	$beforeData = $this->getPlayerDetail($uid);

	$afterDataQuestion = $beforeData['data_question'] + 1;

	$connection = Yii::app()->db;

	$sql = "UPDATE `game_user_profile`
				SET `game_user_profile`.`data_question` = :afterDataQuestion
				WHERE `game_user_profile`.`uid` = :uid";

	$command = $connection->createCommand($sql);
	$command->bindParam(":uid", $uid, PDO::PARAM_STR);
	$command->bindParam(":afterDataQuestion", $afterDataQuestion, PDO::PARAM_STR);
	$command->execute();

	$achievement = Yii::app()->params['game']['achievement']['question'];
	$key = array_key_exists($afterDataQuestion, $achievement);
	if ($key != false){
		$giftModel = new GiftModel;
		$giftCardArray = $achievement[$afterDataQuestion];
		foreach($giftCardArray as $goodCard){
			$giftModel->addGiftToQuery(Yii::app()->params['game']['gifter_id'], $uid, $goodCard);
		}
	}
	$this->checkAllAchievement($uid);
}

	public function addPlayerDataAchievement($uid){
		$beforeData = $this->getPlayerDetail($uid);

		$afterData = $beforeData['all_achievement'] + 1;

		$connection = Yii::app()->db;

		$sql = "UPDATE `game_user_profile`
				SET `game_user_profile`.`all_achievement` = :afterData
				WHERE `game_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":afterData", $afterData, PDO::PARAM_STR);
		$command->execute();
	}

	public function updatePlayerUseCard($uid, $pid, $mid){

		$cardData = $this->getPidCardData($pid);

		if($cardData['type'] == Yii::app()->params['game']['stop_card_cid']){
			$this->addUsingCard($uid, $mid, Yii::app()->params['game']['stop_card_cid']);
		}

		if($cardData['uid'] == $uid){
			$connection = Yii::app()->db;

			$sql = "UPDATE `game_owned_card`
					SET `game_owned_card`.`available` = '0'
					WHERE  `game_owned_card`.`pid` = :pid";

			$command = $connection->createCommand($sql);
			$command->bindParam(":pid", $pid, PDO::PARAM_STR);

			$command->execute();

			return true;
		}else{
			return false;
		}
	}

	public function updateSpecialCardDestroy($uid, $pid){
		$cardData = $this->getPidSpecialCardData($pid);

		$friendData = $this->getIsFriend($uid, $cardData['uid']);
		if($friendData != false){
			$connection = Yii::app()->db;

			$sql = "UPDATE `game_using_card`
					SET `game_using_card`.`available` = '0'
					WHERE  `game_using_card`.`pid` = :pid";

			$command = $connection->createCommand($sql);
			$command->bindParam(":pid", $pid, PDO::PARAM_STR);

			$command->execute();
			return true;
		}else{
			return false;
		}

	}

	public function updateDailyGift($uid){
		$connection = Yii::app()->db;

		$sql = "UPDATE `game_user_profile`
				SET `game_user_profile`.`login_time` = :login_time
				WHERE  `game_user_profile`.`uid` = :uid";

		$time = time();
		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":login_time", $time, PDO::PARAM_STR);

		$command->execute();

		$this->addPlayerMoney($uid, Yii::app()->params['game']['daily_money']);
	}

	public function updateMinusEnergy($uid, $to){
		$connection = Yii::app()->db;

		$sql = "UPDATE `game_user_profile`
				SET `game_user_profile`.`energy` = :to
				WHERE  `game_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":to", $to, PDO::PARAM_STR);

		$command->execute();
	}

	public function updatePlayerBonus($uid, $to){
		$connection = Yii::app()->db;

		$sql = "UPDATE `game_user_profile`
				SET `game_user_profile`.`bonus` = :to
				WHERE  `game_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":to", $to, PDO::PARAM_STR);

		$command->execute();
		return true;
	}

	public function updatePlayerBadGod($uid_me, $uid_him, $to){
		if($this->getIsFriend($uid_me, $uid_him) > 0 || $uid_me == "%"){
			$connection = Yii::app()->db;

			$sql = "UPDATE `game_user_profile`
					SET `game_user_profile`.`badgod` = :to
					WHERE  `game_user_profile`.`position` = :uid_him";

			$command = $connection->createCommand($sql);
			$command->bindParam(":uid_him", $uid_him, PDO::PARAM_STR);
			$command->bindParam(":to", $to, PDO::PARAM_STR);

			$command->execute();
			return true;
		}else{
			return false;
		}
	}

	public function noBadGod($uid){
		$connection = Yii::app()->db;

		$sql = "UPDATE `game_user_profile`
				SET `game_user_profile`.`badgod` = '0'
				WHERE  `game_user_profile`.`uid` = :uid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);

		$command->execute();
	}
}