<?php
namespace App\Repositories\Users;

use App\Models\UsersVotes;
use App\Exceptions\SaveToDBException;

class VoteRepository
{
	/**
     * create not approved user
     *
     * @param  mixed  $id_object
     * @param  string  $rating
     * @param  mixed  $user_id
     * @return bool
     * @throws SaveToDBException
	 */
	public function makeVote($id_object, $rating, $user_id)
	{
		if('up'==$rating){

		}elseif('down'==$rating){

		}else{
			throw new InvalidArgumentException('argument $rating is not correct', 500);
		}

		return false;	
	}
}