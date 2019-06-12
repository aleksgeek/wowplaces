<?php
namespace App\Repositories\Users;

use App\Models\Users;
use App\Exceptions\SaveToDBException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository
{
    /**
     * create not approved user
     *
     * @param App\Http\Requests\AuthRegister $request
     * @return object
     */
    public function createFromRequest($request)
    {
        $user = new Users();
        $user->name = $request['name'];
        $user->email    = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->approve  = '0';
        $user->save();

        return $user;              
    }
    
    /**
     * approve user
     *
     * @param  array $credentails
     * @return bool
     */ 
    public function confirm($credentails)
    {
        return Users::where('email', $credentails['email'])->update(['approve'=>1]);
    }

    /**
     * get user data by email
     *
     * @param string $email
     * @param integer $isApproved
     * @return User
     * 
     * @throws AuthorizationException
     */ 
    public function getByEmail($email, $isApproved = null)
    {
        $user = Users::select('name', 'email', 'password', 'approve')
			->where('email', '=', $email);
			
		if($isApproved!=null){
			$user = $user->where('approve', '=', $isApproved);
		}	
		$user = $user->first();	
	
		if($user){
			return $user;
		}
        
        throw new ModelNotFoundException("cannot find user by email - $email", 400);
    }
}
