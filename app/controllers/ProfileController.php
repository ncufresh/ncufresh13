<?php
/**
 * Created by IntelliJ IDEA.
 * User: Green
 * Date: 2013/7/17
 * Time: 下午 12:06
 */

class ProfileController extends Controller{


	private $ajaxAction = array("get_display_furniture_list" => "ajaxHome",
								"get_owned_furniture_list" => "ajaxHome",
								"update_furniture_status" => "ajaxHome",
								"buy_furniture" => "ajaxHome",
								"get_friend_list" => "ajaxGetFriendList",
								"get_check_code" => "ajaxGetCheckCode",
								"get_message" => "ajaxGetMessage",
								"add_message" => "ajaxAddMessage",
								"buy_skin" => "ajaxBuySkin",
								"get_owned_skin_list" => "ajaxGetOwnedSkinList",
								"change_skin" => "ajaxChangeSkin",
							//	"update_user_profile" => "ajaxUpdateUserProfile",
								"get_daily_active" => "ajaxGetDailyActive",
								"add_friend" => "ajaxAddFriend",
								"remove_friend" => "ajaxRemoveFriend",
								"delete_message" => "ajaxRemoveMessage",
		);

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array_values($this->ajaxAction),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex(){
		$data['secret'] = md5(time());
		Yii::app()->session['profile_secret'] = $data['secret'];
		$data['ajaxAction'] = $this->ajaxAction;
		$data['homeModel'] = new HomeModel;
		$data['userModel'] = new UserModel;
		$data['skinModel'] = new SkinModel;

		if(Yii::app()->request->getQuery('select') == NULL){
			// user itself
			if($this->checkLogin()){
				//有登入 看自己的
				$data['login'] = '1';
				$data['itself'] = '1';
				$data['isFriend'] = '0';
				$data['visitUid'] = Yii::app()->user->getId();
				//$this->render('index', $data);
				$this->redirect(array('profile/index/'.Yii::app()->user->getId()));
			}else{
				$data['login'] = '0';
				$data['itself'] = '0';
				$data['isFriend'] = '0';
				//沒登入 想看自己的
				//TODO
				$this->redirect('/');
			}
		}else{
			$visitUid = Yii::app()->request->getQuery('select');
			$userModel = new UserModel;
			$userProfile = $userModel->getPublicUserProfile($visitUid);
			$friendModel = new FriendModel;
			if($userProfile == false){
				//沒人的QAQ
				//TODO
				$this->redirect('/');
				echo "NOBODY!";
			}else{
				// other person
				if(Yii::app()->user->isGuest){
					//沒登入 看別人
					$data['login'] = '0';
					$data['itself'] = '0';
					$data['isFriend'] = '0';
					$data['visitUid'] = $visitUid;
					$this->render('index', $data);
				}else{
					if(Yii::app()->request->getQuery('select') == Yii::app()->user->getId()){
						//有登入 看別人
						$data['login'] = '1';
						$data['itself'] = '1';
						$data['isFriend'] = '0';
						$data['visitUid'] = $visitUid;
						$this->render('index', $data);
					}else{
						//有登入 看別人
						$uid_me = Yii::app()->user->getId();
						if($friendModel->getIsFriend($uid_me, $visitUid) == NULL){
							$data['isFriend'] = "0";
						}else{
							$data['isFriend'] = "1";
						}

						$data['login'] = '1';
						$data['itself'] = '0';
						$data['visitUid'] = $visitUid;
						$this->render('index', $data);
					}
				}

			}
		}
	}

	public function actionAjaxGetCheckCode(){
		if($this->checkSecretLogin()){
			$data[0] = md5(time() + rand());
			Yii::app()->session['profile_secret'] = $data[0];
			$this->renderPartial('_ajaxArray', array('data' =>$data) ,false,true);
		}else{
			$this->renderPartial('_ajaxError', null ,false,true);
		}
	}

	public function actionAjaxUpdateUserProfile(){
		if($this->checkSecretLogin()){
			$array = array('nickname');
			if(Yii::app()->request->getPost('uid') == Yii::app()->user->getId() && Yii::app()->request->getPost('column') != NULL && Yii::app()->request->getPost('to') != NULL){

			}else{
				$this->renderPartial('_ajaxError', NULL);
			}
		}else{
			$this->renderPartial('_ajaxError', NULL);
		}
	}

	public function actionAjaxHome(){
		if($this->checkSecretLogin()){
			$action = Yii::app()->request->getPost('a');
			$uid_post = Yii::app()->request->getPost('uid');
			$uid = Yii::app()->user->getId();
			$homeModel = new HomeModel;
			switch($action){
				case "get_display_furniture_list":
					$data['displayFurnitureList'] = $homeModel->getOwnedFurnitureList($uid, true);
					$this->renderPartial('_ajaxArray', $data, false, true);
					break;
				case "get_owned_furniture_list":
					if($uid == $uid_post){
						$data['ownedFurnitureList'] = $homeModel->getOwnedFurnitureList($uid, false);
						$this->renderPartial('_ajaxArray', $data, false, true);
					}else{
						$this->renderPartial('_ajaxError', null ,false,true);
					}
					break;
				case "update_furniture_status":
					if($uid == $uid_post){
						if(Yii::app()->request->getPost('pid_before') != NULL && Yii::app()->request->getPost('pid_after') != NULL){
							$pid_before = Yii::app()->request->getPost('pid_before');
							$pid_after = Yii::app()->request->getPost('pid_after');
							$homeModel->updateFurnitureActive($uid, $pid_before, $pid_after);
							$data['ownedFurnitureList'] = $homeModel->getOwnedFurnitureList($uid, false);
							$this->renderPartial('_ajaxArray', $data, false, true);
						}else{
							$this->renderPartial('_ajaxError', null ,false,true);
						}
					}else{
						$this->renderPartial('_ajaxError', null ,false,true);
					}
					break;
				case "buy_furniture":
					if($uid == $uid_post){
						if(Yii::app()->request->getPost('fid') != NULL){
							$fid = Yii::app()->request->getPost('fid');
							$gameModel = new GameModel;
							$userModel = new UserModel;
							$userProfile = $userModel->getPublicUserProfile($uid);
							$thisFurniture = $homeModel->getShopFurnitureByFid($fid);
							if($userProfile['money'] >= $thisFurniture['cost']){
								$gameModel->addPlayerMoney($uid, ($thisFurniture['cost'])*(-1));
								$homeModel->addFurnitureToUser($uid, $fid, 1);
								$data['userProfile'] =$userModel->getPublicUserProfile($uid);
								$data['ownedFurnitureList'] = $homeModel->getOwnedFurnitureList($uid, false);
								$this->renderPartial('_ajaxArray',  array('data' => $data), false, true);
							}else{
								$this->renderPartial('_ajaxError', null ,false,true);
							}
						}else{
							$this->renderPartial('_ajaxError', null ,false,true);
						}
					}else{
						$this->renderPartial('_ajaxError', null ,false,true);
					}
					break;
			}
		}else{
			$this->renderPartial('_ajaxError', null ,false,true);
		}
	}

	public function actionAjaxGetFriendList(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('uid') != NULL && Yii::app()->request->getPost('uid') == Yii::app()->user->getId()){
				$uid = Yii::app()->user->getId();
				$friendModel = new FriendModel;
				$data['friendList'] = $friendModel->getFriendList($uid);
				$this->renderPartial('_ajaxArray', array('data' => $data) ,false,true);
			}else{
				$this->renderPartial('_ajaxError', null ,false,true);
			}
		}
	}

	public function actionAjaxGetMessage(){
		if(Yii::app()->request->getPost("uid") != NULL){
			$uid = Yii::app()->request->getPost("uid");
			$messageModel = new MessageModel;
			$data['message'] = $messageModel->getMessageByUid($uid);
			$this->renderPartial('_ajaxArray', array('data' => $data) ,false,true);
		}
	}

	public function actionAjaxAddMessage(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('message') != NULL){
				$uid = Yii::app()->user->getId();
				$uid_to = Yii::app()->request->getPost("uid");
				if(time() - Yii::app()->user->getState('profileMessageTime'.$uid_to, 0) >= 120 ){
					$message = Yii::app()->request->getPost('message');
					Yii::app()->user->setState('profileMessageTime'.$uid_to, time());
					$messageModel = new MessageModel;
					$messageModel->addMessage($uid, $uid_to, $message);
				}else{
					echo "time";
				}
			}else{
				$this->renderPartial('_ajaxError', NULL, false, true);
			}
		}else{
			$this->renderPartial('_ajaxError', NULL, false, true);
		}
	}

	public function actionAjaxGetDailyActive(){
		$uid = Yii::app()->request->getPost('uid');
		// TODO
		// find the active and render. QAQ
	}

	public function actionAjaxAddFriend(){
		if($this->checkSecretLogin()){
			$uid_me = Yii::app()->user->getId();
			$uid_friend = Yii::app()->request->getPost('uid_friend');
			if($uid_me == Yii::app()->user->getId() && $uid_friend != NULL){
				$friendModel = new FriendModel;
				$friendModel->addFriend($uid_me, $uid_friend);
				$this->renderPartial('_ajaxArray', array('data' => $friendModel->getFriendList($uid_me)), false, true);
			}else{
				$this->renderPartial('_ajaxError', NULL, false, true);
			}
		}else{
			$this->renderPartial('_ajaxError', NULL, false, true);
		}
	}

	public function actionAjaxRemoveFriend(){
		if($this->checkSecretLogin()){
			$uid_me = Yii::app()->request->getPost('uid');
			$uid_friend = Yii::app()->request->getPost('uid_friend');
			if($uid_me == Yii::app()->user->getId() && $uid_friend != NULL){
				$friendModel = new FriendModel;
				$friendModel->removeFriend($uid_me, $uid_friend);
				$this->renderPartial('_ajaxArray', array('data' => $friendModel->getFriendList($uid_me)), false, true);
			}else{
				$this->renderPartial('_ajaxError', NULL, false, true);
			}
		}else{
			$this->renderPartial('_ajaxError', NULL, false, true);
		}
	}

	public function actionAjaxBuySkin(){
		if($this->checkSecretLogin()){
			$uid = Yii::app()->request->getPost('uid');
			if($uid == Yii::app()->user->getId() && Yii::app()->request->getPost('sid') != NULL){
				$sid = Yii::app()->request->getPost('sid');
				$skinModel = new SkinModel;
				$gameModel = new GameModel;
				$skinModel->getShopSkinBySid($sid);
				$userProfile = $gameModel->getPlayerDetail($uid);
				$thisSkin = $skinModel->getShopSkinBySid($sid);
				if($userProfile['money'] >= $thisSkin['cost']){
					$gameModel->addPlayerMoney($uid, ($thisSkin['cost'])*(-1));
					$skinModel->addSkinToUser($uid, $sid);
					$userModel = new UserModel;
					$data['userProfile'] = $userModel->getPublicUserProfile($uid);
					$data['ownedSkinList'] = $skinModel->getOwnedSkinList($uid);
					$this->renderPartial('_ajaxArray',  array('data' => $data), false, true);
				}else{
					echo "1";
					$this->renderPartial('_ajaxError', null ,false,true);
				}
			}else{
				echo "2";
				$this->renderPartial('_ajaxError', NULL, false, true);
			}
		}else{
			echo "3";
			$this->renderPartial('_ajaxError', NULL, false, true);
		}
	}

	public function actionAjaxChangeSkin(){
		if($this->checkSecretLogin()){
			$uid = Yii::app()->request->getPost('uid');
			if($uid == Yii::app()->user->getId() && Yii::app()->request->getPost('pid')){
				$pid = Yii::app()->request->getPost('pid');
				$skinModel = new SkinModel;
				$thisSkin = $skinModel->getSkinByPid($pid);
				if($uid == $thisSkin['uid']){
					$skinModel->changeUserSkin($uid, $thisSkin['sid']);
					$userModel = new UserModel;
					$data['userProfile'] = $userModel->getPublicUserProfile($uid);
					$data['ownedSkinList'] = $skinModel->getOwnedSkinList($uid);
					$this->renderPartial('_ajaxArray', array('data' => $data), false, true);
				}else{
					$this->renderPartial('_ajaxError', null ,false,true);
				}
			}else{
				$this->renderPartial('_ajaxError', NULL, false, true);
			}
		}else{
			$this->renderPartial('_ajaxError', NULL, false, true);
		}
	}

	public function actionAjaxGetOwnedSkinList(){
		if($this->checkSecretLogin()){
			$uid = Yii::app()->request->getPost('uid');
			if($uid == Yii::app()->user->getId()){
				$skinModel = new SkinModel;
				$data['ownedSkinList'] = $skinModel->getOwnedSkinList($uid);
				$this->renderPartial('_ajaxArray',  array('data' => $data), false, true);
			}else{
				$this->renderPartial('_ajaxError', NULL, false, true);
			}
		}else{
			$this->renderPartial('_ajaxError', NULL, false, true);
		}
	}

	public function actionAjaxRemoveMessage(){
		if($this->checkSecretLogin()){
			if(Yii::app()->request->getPost('pid') != NULL){
				$pid = Yii::app()->request->getPost('pid');
				$uid = Yii::app()->user->getId();
				$uidVisit = Yii::app()->request->getPost('uid');
				$messageModel = new MessageModel;
				if($messageModel->deleteMessageByPid($pid, $uid)){
					$this->renderPartial('_ajaxArray', array('data' => array('message' => $messageModel->getMessageByUid($uidVisit))), false, true);
				}else{
					$this->renderPartial('_ajaxError', NULL, false, true);
				}
			}else{
				$this->renderPartial('_ajaxError', NULL, false, true);
			}
		}else{
			$this->renderPartial('_ajaxError', NULL, false, true);
		}
	}

	public function actionTest(){
//		echo Yii::app()->request->getRequestUri();
		$uid = '009a5e8a57d46f916d9c9f036817c12d';
//		$MessageModel = new MessageModel;
//		//$homeModel->addFurnitureToUser($uid, 1);
//		//$homeModel->updateFurnitureActive($uid, -1, 1);
//		$MessageModel->addMessage($uid, $uid, "LLL");
//		print_r($MessageModel->getMessageByUid($uid));
		$fm = new FriendModel;
		echo Html::getPersonalImgUrl($uid);
	}

	public function checkLogin(){
		if(Yii::app()->user->isGuest){
			if(!Yii::app()->request->isAjaxRequest && $this->action->id != "index"){
				// Not ajax, No login
				//$this->redirect($this->createUrl("profile/index"));
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
				if(isset(Yii::app()->session['profile_secret']) && Yii::app()->request->getPost('s') != NULL && Yii::app()->request->getPost('a') != NULL && Yii::app()->request->getPost('uid') != NULL && Yii::app()->request->getPost('s') == Yii::app()->session['profile_secret']){
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
