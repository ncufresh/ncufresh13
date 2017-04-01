<?php
/**
 * Created by IntelliJ IDEA.
 * User: Green
 * Date: 2013/7/20
 * Time: 下午 1:25
 */

class HomeModel {

	public function getShopFurnitureTypeList(){
		$connection = Yii::app()->db;

		$sql = "SELECT `game_shop_furniture_type`.`type`, `game_shop_furniture_type`.`type_name`
				FROM `game_shop_furniture_type`
				ORDER BY `game_shop_furniture_type`.`fid` ASC";

		$command = $connection->createCommand($sql);
		$dataReader = $command->query();
		$data = $dataReader->readAll();
		return $data;
	}

	public function getShopFurnitureList(){
		$connection = Yii::app()->db;

		$sql = "SELECT `game_shop_furniture`.`fid`, `game_shop_furniture`.`cost`, `game_shop_furniture`.`name`, `game_shop_furniture`.`message`, `game_shop_furniture_type`.`type`, `game_shop_furniture_type`.`type_name`
				FROM `game_shop_furniture`
				INNER JOIN `game_shop_furniture_type`
					ON `game_shop_furniture`.`type` = `game_shop_furniture_type`.`type`
					ORDER BY `game_shop_furniture`.`fid`";

		$command = $connection->createCommand($sql);
		$dataReader = $command->query();
		$data = $dataReader->readAll();
		return $data;
	}

	public function getOwnedFurnitureList($uid, $active = false){
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

	public function getShopFurnitureByFid($fid){
		$connection = Yii::app()->db;

		$sql = 'SELECT `game_shop_furniture`.`fid`, `game_shop_furniture`.`cost`, `game_shop_furniture`.`type`
				FROM `game_shop_furniture`
				WHERE `game_shop_furniture`.`fid` = :fid';

		$command = $connection->createCommand($sql);
		$command->bindParam(":fid", $fid, PDO::PARAM_STR);
		return $command->queryRow();
	}

	private function getOwnedFurnitureByPid($pid){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `game_owned_furniture`
				WHERE `game_owned_furniture`.`pid`";

		$command = $connection->createCommand($sql);
		$command->bindParam(":pid", $pid, PDO::PARAM_STR);

		$row = $command->queryRow();
		return $row;
	}

	/**
	 * @param $pid
	 * @param $active     0:no 1:yes
	 */
	public function updateFurnitureActiveByPid($pid, $active){
		$connection = Yii::app()->db;

		$sql = "UPDATE `game_owned_furniture`
				SET `game_owned_furniture`.`active` = :active
				WHERE `game_owned_furniture`.`pid` = :pid";

		$command = $connection->createCommand($sql);
		$command->bindParam(":pid", $pid, PDO::PARAM_STR);
		$command->bindParam(":active", $active, PDO::PARAM_STR);

		$command->execute();
	}

	public function updateFurnitureActive($uid, $pid_before, $pid_after){
		if($pid_after == "-1"){
			if($pid_after == '-1'){
				return false;
			}else{
				$this->updateFurnitureActiveByPid($pid_before, 1);
				return true;
			}
		}else{
			if($pid_before == '-1'){
				$this->updateFurnitureActiveByPid($pid_after, 1);
				return true;
			}else{
				$beforeFurniture = $this->getOwnedFurnitureByPid($pid_before);
				$afterFurniture = $this->getOwnedFurnitureByPid($pid_after);
				if($beforeFurniture['uid'] == $uid && $afterFurniture['uid'] == $uid && $beforeFurniture['fid'] == $afterFurniture['fid']){
					$this->updateFurnitureActiveByPid($pid_before, 0);
					$this->updateFurnitureActiveByPid($pid_after, 1);
				}else{
					return false;
				}
			}
		}
		return false;
	}

	public function addFurnitureToUser($uid, $fid, $active = 0){
		$connection = Yii::app()->db;

		$sql = "INSERT INTO  `game_owned_furniture`
				(`pid`, `uid`, `fid`, `active`)
				VALUES
				(NULL, :uid, :fid, :active)";

		$command = $connection->createCommand($sql);
		$command->bindParam(":uid", $uid, PDO::PARAM_STR);
		$command->bindParam(":fid", $fid, PDO::PARAM_STR);
		$command->bindParam(":active", $active, PDO::PARAM_STR);
		$command->execute();
	}
}