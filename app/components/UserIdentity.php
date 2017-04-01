<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_uid;

	/**GeneralUser
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$record=GeneralUserProfile::model()->findByAttributes(array('username'=>$this->username));
		if($record===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($record->password!==$this->password)
		// else if($record->password!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{ 
			$this->_uid=$record->uid;
			$this->setState('username', $record->username);
			$this->setState('nickname', $record->nickname);
			if(in_array($record->username,Yii::app()->params['admin']))
				$this->setState('admin',1);
			else
				$this->setState('admin',0);
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}

	// *
	//  * @return integer the ID of the user record
	 
	public function getId()
	{
		return $this->_uid;
	}
}