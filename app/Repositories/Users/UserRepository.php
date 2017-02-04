<?php
namespace App\Repositories\Users;

use App\Models\Users;
use App\Exceptions\SaveToDBException;

class UserRepository
{
	/**
     * create not approved user
     *
     * @return object
     * @throws SaveToDBException
	 */
	public function save($request)
	{
        $user = new Users();
        $user->name = $request['login_name'];
        $user->email    = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->approve  = 0;
        
        if($user->save()){
        	return $user;	
        }else{
        	throw new SaveToDBException("user saving error", 500);	
        }
	}
	
	/**
     * approve user
     *
     * @param  array $credentails
     * @return bool
	 */	
	public function confirm($credentails)
	{
        return Users::where('email', $credentails['email'])->update('approve', 1);
	}

	/**
     * get user data by email
     *
     * @param  mixed $email
     * @return array
	 */	
	public function getByEmail($email)
	{
		$user = Users::where('email', '=', $email)->first();
		
		if($user){
			return ['name'=>$user->name, 'email'=>$user->email];	
		}else{
			return [];
		}
	}
}
