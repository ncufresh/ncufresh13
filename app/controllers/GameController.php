<?php
/**
 * Created by IntelliJ IDEA.
 * User: Green
 * Date: 2013/7/16
 * Time: 上午 9:41
 */

class GameController extends Controller{

	private $ajaxAction = array("using_card" => "ajaxUsingCard",
								"change_location" => "ajaxChangeLocation",
								"add_pu_pu" => "ajaxAddPuPu",
					//			"get_chance" => "ajaxGetChance",
					//			"get_destiny" => "ajaxGetDestiny",
								"get_question" => "ajaxGetQuestion",
								"get_special" => "ajaxGetSpecial",
								"get_check_code"=>"ajaxGetCheckCode",
								"get_user_profile" => "ajaxGetUserProfile",
								"get_gift_to" => "ajaxGiveGiftTo",
								"hit_stop" => "ajaxHitStop",
								"bad_god" => "ajaxBadGod",
								"return_receive_gift" => 'ajaxReceiveGift',);

	public function accessRules(){
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array_values($this->ajaxAction),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('op', 'ajaxOp'),
				'users'=>Yii::app()->params['admin'],
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex(){
		if($this->checkLogin()){
			$data['gameModel'] = new GameModel;
			$data['giftModel'] = new GiftModel;
			$data['secret'] = md5(time());
			$data['uid'] = Yii::app()->user->getId();
			$data['ajaxAction'] = $this->ajaxAction;
			Yii::app()->session['game_question_values'] = NULL;
			Yii::app()->session['game_secret'] = $data['secret'];
			Yii::app()->session['game_question_values'] = NULL;
			$this->render('index', $data);
		}else{
			// TODO
			$this->redirect('/');
		}
	}

	public function actionAjaxReceiveGift(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('pid') != NULL){
				$uid = Yii::app()->user->getId();
				$pid = Yii::app()->request->getPost('pid');
				$giftModel = new GiftModel;
				$card = $giftModel->getCidByGiftPid($pid);
				if($card['receive_uid'] == $uid ){
					$giftModel->deliverGift($pid, $uid, $card['cid']);
					$gameModel = new GameModel;
					$this->renderPartial('_ajaxArray', array('data' => array('userProfile' => $gameModel->getPlayerDetail($uid), 'userCard' =>  $gameModel->getOwnedCardList($uid)) ,false,true));
				}else{
					$this->renderPartial('_ajaxError', null ,false,true);
				}
			}else{
				$this->renderPartial('_ajaxError', null ,false,true);
			}
		}else{
			$this->renderPartial('_ajaxError', null ,false,true);
		}
	}

	public function actionAjaxUsingCard(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('pid') != NULL && Yii::app()->request->getPost('mid') != NULL){
				$uid = Yii::app()->user->getId();
				$pid = Yii::app()->request->getPost('pid');
				$mid = Yii::app()->request->getPost('mid');
				$gameModel = new GameModel;
				$card = $gameModel->getPidCardData($pid);
				if($card['available'] == 1){
					$ss = "X";
					switch($card['type']){
						case "1":
							// Gold Card
							// NO!!
							break;
						case "2":
							// Double Card
							$gameModel->updatePlayerBonus($uid, 2);
							$gameModel->updatePlayerUseCard($uid, $pid, $mid);
							break;
						case "3":
							// Dice Card
							$gameModel->updatePlayerUseCard($uid, $pid, $mid);
							break;
						case "4":
							// Lotto
							$lottoMin = Yii::app()->params['game']['lotto_card_min'];
							$lottoMax = Yii::app()->params['game']['lotto_card_max'];
							$addMoney = rand($lottoMin, $lottoMax);
							$gameModel->updatePlayerUseCard($uid, $pid, $mid);
							$gameModel->addPlayerMoney($uid, $addMoney);
							break;
						case "5":
							// 路障
							$type = Yii::app()->params['game']['stop_card_cid'];
							$gameModel->addUsingCard($uid, $mid, $type);
							$gameModel->updatePlayerUseCard($uid, $pid, $mid);
							$ss = $gameModel->getMapUsingCard($uid);
							// special
							break;
						case "6":
							// 磚地
							$gameModel->updateSpecialCardDestroy($uid, $mid);
							$gameModel->updatePlayerUseCard($uid, $pid, $mid);
							$ss = $gameModel->getMapUsingCard($uid);
							// special
							break;
						case "7":
							// Teleportation
							$gameModel->updatePlayerUseCard($uid, $pid, $mid);
							Yii::app()->session['using_tele_card_check'] = Yii::app()->params['game']['using_tele_card_check'];
							// wait for change_location
							break;
						case "8":
							// Money god
							//$gameModel->updatePlayerUseCard($uid, $pid, $mid);
							$ss = md5(time().";alkgjr';armfk'lrmgfio");
							Yii::app()->session['game_secret_secret'] = $ss;
							$gameModel->updatePlayerUseCard($uid, $pid, $mid);
							break;
						case "9":
							// badGod
							$gameModel->updatePlayerBadGod($uid, $mid, 1);
							$gameModel->updatePlayerUseCard($uid, $pid, $mid);
							break;
						case "10":
							// robber
							if($gameModel->getIsFriend($uid, $mid) > 0){
								$friendCard = $gameModel->getOwnedCardList($mid);
								$haveDefendCard = false;
								foreach($friendCard as $thisCard){
									if($thisCard['type'] == Yii::app()->params['game']['defend_card_cid']){
										$haveDefendCard = true;
										break;
									}
									$gameModel->updatePlayerUseCard($thisCard['uid'], $thisCard['pid'], '0');
								}
								if($haveDefendCard == true){
									$friendData = $gameModel->getPlayerDetail($mid);
									$gainedMoney = $friendData['money'];
									if($gainedMoney >= Yii::app()->params['game']['robber_card_max']){
										$gainedMoney = Yii::app()->params['game']['robber_card_max'];
									}
									$gameModel->addPlayerMoney($uid, $gainedMoney);
									$gameModel->addPlayerMoney($mid, $gainedMoney*(-1));
								}
								$gameModel->updatePlayerUseCard($uid, $pid, $mid);
							}else{
								$this->renderPartial('_ajaxError', null ,false,true);
								Yii::app()->end();
							}
							break;
						case "11":
							//防盜
							break;
						case "12":
							//energy
							break;
					}
					$this->renderPartial('_ajaxArray', array('data' => array('userProfile' => $gameModel->getPlayerDetail($uid), 'userCard' =>  $gameModel->getOwnedCardList($uid), 'ss' => $ss) ,false,true));
				}else{
					$this->renderPartial('_ajaxError', null ,false,true);
				}
			}else{
				$this->renderPartial('_ajaxError', null ,false,true);
			}
		}else{
			$this->renderPartial('_ajaxError', null ,false,true);
		}
	}

	public function actionAjaxChangeLocation(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('location') != NULL && Yii::app()->request->getPost('direction') != NULL){
				$uid = Yii::app()->user->getId();
				$location = Yii::app()->request->getPost('location');
				$direction = Yii::app()->request->getPost('direction');
				$gameModel = new GameModel;
				$userData = $gameModel->getPlayerDetail($uid);
				if(Yii::app()->session['using_tele_card_check'] != Yii::app()->params['game']['using_tele_card_check']){
					//No using teleport card minus energy
					if($userData['energy'] <= 0){
						// Cheat energy!!
						$this->renderPartial('_ajaxError', null ,false,true);
					}else{
						$gameModel->updateMinusEnergy(Yii::app()->user->getId(), $userData['energy']-1);
					}
				}else{
					Yii::app()->session['using_tele_card_check'] = NULL;
					unset(Yii::app()->session['using_tele_card_check']);
				}
				if($gameModel->updatePlayerPosition($uid, $location, $direction)){
					$this->renderPartial('_ajaxArray', array('data' => array('friendData' => $gameModel->getFriendDetail($uid), 'userProfile' =>  $gameModel->getPlayerDetail($uid)) ,false,true));
				}else{
					$this->renderPartial('_ajaxError', null ,false,true);
				}
			}else{
				$this->renderPartial('_ajaxError', null ,false,true);
			}
		}else{
			$this->redirect("game/index");
		}
	}

	public function actionAjaxBadGod(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('money') != NULL){
				$uid = Yii::app()->user->getId();
				$money = Yii::app()->request->getPost('money');
				if($money < 0){
					$gameModel = new GameModel;
					$gameModel->addPlayerMoney($uid, $money);
					$gameModel->noBadGod($uid);
					$this->renderPartial('_ajaxArray', array('data' => $gameModel->getPlayerDetail($uid) ,false,true));
				}else{
					$this->renderPartial('_ajaxError', null ,false,true);
				}
			}else{
				$this->renderPartial('_ajaxError', null ,false,true);
			}
		}
	}

	public function actionAjaxAddPuPu(){
		if($this->checkSecretLogin()){
			if(	Yii::app()->session['game_secret_secret'] != NULL &&
				Yii::app()->request->getPost('ss') != NULL &&
				Yii::app()->request->getPost('pupu') != NULL &&
				Yii::app()->request->getPost('ss') == Yii::app()->session['game_secret_secret']){
				if(time() - Yii::app()->user->getState('gamePuPuTime') > 5){
					$uid = Yii::app()->user->getId();
					$money =  Yii::app()->request->getPost('pupu');
					if(Yii::app()->session['game_question_values'] == NULL){
						if(abs($money) < Yii::app()->params['game']['max_pu_pu']){
							$gameModel = new GameModel;
							$gameModel->addPlayerMoney($uid, $money);
							$this->renderPartial('_ajaxArray', array('data' => $gameModel->getPlayerDetail($uid) ,false,true));
							Yii::app()->user->setState('gamePuPuTime' , time());
						}else{
							$this->renderPartial('_ajaxError', null ,false,true);
						}
					}else{
						if($money == (Yii::app()->session['game_question_values'])){
							$gameModel = new GameModel;
							$gameModel->addPlayerMoney($uid, $money);
							Yii::app()->session['game_question_values'] = NULL;
							$this->renderPartial('_ajaxArray', array('data' => $gameModel->getPlayerDetail($uid) ,false,true));
							Yii::app()->user->setState('gamePuPuTime' , time());
						}else{
							$this->renderPartial('_ajaxError', null ,false,true);
						}
					}
				}else{
					$this->renderPartial('_ajaxError', null ,false,true);
				}
			}else{
				$this->renderPartial('_ajaxError', null ,false,true);
			}
		}else{
			$this->renderPartial('_ajaxError', null ,false,true);
		}
	}

	public function actionAjaxGetChance(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('mid') != NULL){
				$mid = Yii::app()->request->getPost('mid');
				$gameModel = new GameModel;
				$this->renderPartial('_ajaxArray', array('data' => $gameModel->getChance()) ,false,true);
				$uid = Yii::app()->user->getId();
				$userProfile = $gameModel->getPlayerDetail($uid);
				switch($userProfile['data_chance']){
					case 0:
						break;
				}
			}else{
				$this->renderPartial('_ajaxError', null ,false,true);
			}
		}
	}

	public function actionAjaxGetDestiny(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('mid') != NULL){
				$mid = Yii::app()->request->getPost('mid');
				$gameModel = new GameModel;
				$this->renderPartial('_ajaxArray', array('data' => $gameModel->getDestiny()) ,false,true);
			}else{
				$this->renderPartial('_ajaxError', null ,false,true);
			}
		}
	}

	public function actionAjaxGetQuestion(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('mid') != NULL){
				$uid = Yii::app()->user->getId();
				$mid = Yii::app()->request->getPost('mid');
				$gameModel = new GameModel;
				$question = $gameModel->getQuestion();
				$ss = md5(time().";alkgjr';armfk'lrmgfio");
				Yii::app()->session['game_secret_secret'] = $ss;
				Yii::app()->session['game_question_values'] = $question['values'];
				$question['ss'] = $ss;
				$this->renderPartial('_ajaxArray', array('data' => $question) ,false,true);
				$gameModel->addPlayerDataQuestion($uid);
			}else{
				$this->renderPartial('_ajaxError', null ,false,true);
			}
		}
	}

	public function actionAjaxGetSpecial(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('type') != NULL){
				$uid = Yii::app()->user->getId();
				$type = Yii::app()->request->getPost('type');
				$gameModel = new GameModel;
				$special =  $gameModel->getSpecial($type);
				if($special['damage'] != '1'){
					if($special['action_type'] == '2'){
						$data =  $gameModel->getPlayerDetail($uid);
						$gameModel->updatePlayerPosition($uid, $special['values'], $data['direction']);
					}
					$this->renderPartial('_ajaxArray', array('data' => $special) ,false,true);
				}else{
					$userCard = $gameModel->getOwnedCardList($uid);
					$goldCard = 0;
					foreach($userCard as $thisCard){
						if($thisCard["type"] == Yii::app()->params['game']['golden_card_type']){
							$goldCard = 1;
							$gameModel->updatePlayerUseCard($uid, $thisCard['pid'], 0);
							break;
						}
					}
					$special['useGoldCard'] = $goldCard;
					if($goldCard == 0){
						// No Gold Card DO!
						switch($special['action_type']){
							case 1:
								$gameModel->addPlayerMoney($uid, $special['values']);
								break;
							case 2:
								$userData = $gameModel->getPlayerDetail($uid);
								$gameModel->updatePlayerPosition($uid, $special['values'], $userData['direction']);
								break;
						}
					}
					$this->renderPartial('_ajaxArray', array('data' => $special) ,false,true);
				}

				switch($type){
					case 1:
						//chance
						$gameModel->addPlayerDataChance($uid);
						break;
					case 2:
						//Destiny
						$gameModel->addPlayerDataDestiny($uid);
						break;
					case 3:
				}

			}else{
				$this->renderPartial('_ajaxError', null ,false,true);
			}
		}else{
			$this->renderPartial('_ajaxError', null ,false,true);
		}
	}

	public function actionAjaxGetCheckCode(){
		if($this->checkSecretLogin()){
			$data[0] = md5(time() + rand());
			Yii::app()->session['game_secret'] = $data[0];
			$this->renderPartial('_ajaxArray', array('data' =>$data) ,false,true);
		}else{
			$this->renderPartial('_ajaxError', null ,false,true);
		}
	}

	public function actionAjaxGetUserProfile(){
		if($this->checkSecretLogin()){
			$uid = Yii::app()->user->getId();
			$gameModel = new GameModel;
			$this->renderPartial('_ajaxArray', array('data' => $gameModel->getPlayerDetail($uid) ,false,true));
		}else{
			$this->renderPartial('_ajaxError', null ,false,true);
		}
	}

	public function actionAjaxGiveGiftTo(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('uid_to') != NULL && Yii::app()->request->getPost('cid') != NULL){
				$uid = Yii::app()->user->getId();
				$uid_to = Yii::app()->request->getPost('uid_to');
				$cid = Yii::app()->request->getPost('cid');
				$gameModel = new GameModel;
				$giftModel = new GiftModel;
				$giftModel->sendGiftTo($uid, $uid_to, $cid);
				$this->renderPartial('_ajaxArray', array('data' => $gameModel->getFriendDetail($uid) ,false,true));
			}
		}else{
			$this->renderPartial('_ajaxError', null ,false,true);
		}
	}

	public function actionAjaxHitStop(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('location') != NULL && Yii::app()->request->getPost('direction') != NULL){
				$uid = Yii::app()->user->getId();
				$location = Yii::app()->request->getPost('location');
				$direction = Yii::app()->request->getPost('direction');
				$gameModel = new GameModel;
				$userData = $gameModel->getPlayerDetail($uid);
				$allCard = $gameModel->getMapUsingCard($uid);
				for ($i = 0; $i<count($allCard); $i++){
					if($allCard[$i]['mid'] == $location){
						$gameModel->updateSpecialCardDestroy($uid, $allCard[$i]['pid']);
					}
				}
				if(Yii::app()->session['using_tele_card_check'] != Yii::app()->params['game']['using_tele_card_check']){
					//No using teleport card minus energy
					if($userData['energy'] <= 0){
						// Cheat energy!!
						$this->renderPartial('_ajaxError', null ,false,true);
					}else{
						$gameModel->updateMinusEnergy(Yii::app()->user->getId(), $userData['energy']-1);
					}
				}else{
					Yii::app()->session['using_tele_card_check'] = NULL;
					unset(Yii::app()->session['using_tele_card_check']);
				}
				if($gameModel->updatePlayerPosition($uid, $location, $direction)){
					$this->renderPartial('_ajaxArray', array('data' => array('friendData' => $gameModel->getFriendDetail($uid), 'userProfile' =>  $gameModel->getPlayerDetail($uid)) ,false,true));
				}else{
					$this->renderPartial('_ajaxError', null ,false,true);
				}
			}else{
				$this->renderPartial('_ajaxError', null ,false,true);
			}
		}else{
			$this->redirect("game/index");
		}
	}

	public function checkLogin(){
		if(Yii::app()->user->isGuest){
			if(!Yii::app()->request->isAjaxRequest && $this->action->id != "index"){
				// Not ajax, No login
				$this->redirect($this->createUrl("game/index"));
			}else{
				$this->renderPartial('_ajaxError', null ,false,true);
			}
			return false;
		}else{
			return true;
		}
	}

	public function checkSecretLogin(){
		if($this->checkLogin()){
			if(Yii::app()->request->isAjaxRequest){
				$pos = strpos(Yii::app()->request->urlReferrer, Yii::app()->params['web_base']);
				if($pos === false && Yii::app()->params['check_web_base']){
					return false;
				}
				if(isset(Yii::app()->session['game_secret']) && Yii::app()->request->getPost('s') != NULL && Yii::app()->request->getPost('s') == Yii::app()->session['game_secret']){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function actionTest(){
		$giftModel = new GiftModel;
		print_r($giftModel->getGiftQuery(Yii::app()->user->getId()));
	}

	public function actionOP(){
		$gameModel = new GameModel;
		$uid = Yii::app()->user->getId();
		$data['model'] = $gameModel;
		$data['shop'] = $gameModel->getShopCardList();
		$this->render("opView", $data);
	}

	public function actionAjaxOp(){
		$type = $_GET['id'];
		$uid = Yii::app()->user->getId();
		$giftModel = new GiftModel;
		$giftModel->sendGiftTo(Yii::app()->params['game']['gifter_id'], $uid, $type);
		echo $type;
	//	$this->renderPartial("_ajaxArray", $gameModel->getOwnedCardList($uid));
	}

	//==============================================================================================================================
	public function actionAddQuestionChoose(){
		$array['model'] = new FormModelChoose;

		if(isset($_POST['FormModelChoose'])){
			$array['model']->attributes = $_POST['FormModelChoose'];
			$message  = $array['model']->message.'|';
			$message .= $array['model']->actionType.'|4|';
			$message .= $array['model']->correct.'|';
			$message .= $array['model']->answer1.'|';
			$message .= $array['model']->answer2.'|';
			$message .= $array['model']->answer3.'|';
			$message .= $array['model']->answer4;

			$db = new GameSpecial;
			$db->type=3;
			$db->message=$message;
			$db->action_type=1;
			$db->values=$array['model']->values;
			$db->damage=0;
			$db->save();
			echo "<script>alert('成功加入\\n".$message."')</script>";
		}
		$array['model'] = new FormModelChoose;
		$this->render("questionChoose", $array);
	}

	public function actionAddQuestionOne(){
		$array['model'] = new FormModelOne;

		if(isset($_POST['FormModelOne'])){
			$array['model']->attributes = $_POST['FormModelOne'];
			$message  = $array['model']->message.'|';
			$message .= 't|';
			$message .= $array['model']->correct;

			$db = new GameSpecial;
			$db->type=3;
			$db->message=$message;
			$db->action_type=1;
			$db->values=$array['model']->values;
			$db->damage=0;
			$db->save(false);
			echo "<script>alert('成功加入\\n".$message."')</script>";
		}
		$array['model'] = new FormModelOne;
		$this->render("questionOne", $array);
	}

	public function actionAddQuestionList(){
		$connection = Yii::app()->db;

		$sql = "SELECT *
				FROM `game_special`
				WHERE `game_special`.`type` = '3'";

		$command = $connection->createCommand($sql);

		$dataReader = $command->query();
		$data = $dataReader->readAll();
		$this->render('_ajaxArray', array('data' => $data));
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}