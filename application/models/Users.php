<?php

class Application_Model_Users
{

    public function insertData($email, $password)
    {
        $usersModel = new Application_Model_DbTable_Users();

        $user = $usersModel->createRow();

        $user->email = $email;
        $passwordSalt = Application_Model_Users::passwordSalt(32);
        $user->password = MD5($password.$passwordSalt);
        $user->password_salt = $passwordSalt;

        return $user->save();
    }

    protected function passwordSalt($length)
    {
        $random = '';
        // 48 - 57, 65 - 90, 97 - 122
        for ($i = 0; $i < $length; $i++) {
            $n = mt_rand(0, 10 + 26 + 26 - 1);
            $random .= chr($n < 10 ? 48 + $n : ($n - 10 < 26 ? 65 + ($n - 10) : 97 + ($n - 10 - 26)));
        }
        return $random;
    }

    function checkUnique($email)
    {
        $usersModel = new Application_Model_DbTable_Users();

        $userEmail = $usersModel->fetchRow(
            $usersModel->select()->where('email=?',$email));

        if($userEmail)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    /**
     * Get the user detail of logged in user
     *
     * @param string $name
     * @return false|string
     */
    public static function getLoggedInUserField($email)
    {
        if(!$email) {
            return false;
        }

        //load user auth details
        $user = Zend_Auth::getInstance()->getIdentity();

        //if field is defined in auth identity
        if($user && isset($user->$email)) {
            return $user->$email;
        }

        return false;
    }


    /**
     * Check if the user is an administrator
     *
     * @return bool
     */
    public static function isAdmin()
    {
        return 'admin' == self::getLoggedInUserField('role');
    }

    /**
     * Check if user is logged in
     * @return bool
     */
    public static function isLoggedIn()
    {
        return Zend_Auth::getInstance()->hasIdentity();
    }

}