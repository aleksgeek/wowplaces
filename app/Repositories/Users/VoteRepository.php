<?php
namespace App\Repositories\Users;

use App\Models\UsersVotes;
use App\Models\ObjectsList;
use App\Exceptions\SaveToDBException;
use RuntimeException;
use InvalidArgumentException;

class VoteRepository
{
	/**
     * create not approved user
     *
     * @param  mixed  $id_object
     * @param  string  $rating
     * @param  mixed  $user_id
     * @return bool
     * @throws InvalidArgumentException
	 */
	public function makeVote($id_object, $rating, $user_id)
	{
		if('up'==$rating){
			ObjectsList::where('id', $id_object)->increment('rating_good');
			$rating_good = 1;	
			$rating_bad  = 0;	
		}elseif('down'==$rating){
			ObjectsList::where('id', $id_object)->increment('rating_bad');
			$rating_good = 0;	
			$rating_bad  = 1;
		}else{
			throw new InvalidArgumentException('argument $rating is not correct', 500);
		}

		$user = new UsersVotes();
		$user->id_user   = $user_id;
		$user->id_object = $id_object;
		$user->rating_good = $rating_good;
		$user->rating_bad  = $rating_bad;
		$user->save();

		return true;	
	}

	/**
     * check may whether vote
     *
     * @param  mixed  $id_object
     * @param  mixed  $user_id
     * @return bool
     * @throws RuntimeException
	 */
	public function canVote($id_object, $user_id)
	{
		$existing_user = UsersVotes::where('id_user', $user_id)->where('id_object', $id_object)->get();
		
		if($existing_user->isEmpty()){
			return true;
		}

		throw new RuntimeException("you have already voted", 405);
	}
}