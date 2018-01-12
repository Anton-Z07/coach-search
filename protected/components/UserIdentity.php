<?php

class UserIdentity extends CUserIdentity
{
	public function authenticate()
	{
		$this->errorCode=self::ERROR_NONE;

		$name = '';
		$user = Admin::model()->findByAttributes(array('login'=>$this->username));
		if ($user) {
			$type = 'admin';
		}

		if (!$user)
		{
			$user = Coach::model()->findByAttributes(array('login'=>$this->username, 'deleted'=>0));
			if ($user) {
				$type = 'coach';
				$name = $user->first_name;
			}
		}

		if (!$user)
		{
			$user = Client::model()->findByAttributes(array('login'=>$this->username, 'deleted'=>0));
			if ($user) {
				$type = 'client';
			}
		}

		if(!$user || !CPasswordHelper::verifyPassword($this->password, $user->password)) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		else
		{
			$this->setState('type', $type);
			$this->setState('innerId', $user->id);
			$this->setState('name', $name ? $name : $user->name);
		}

		return !$this->errorCode;
	}
}