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
     * @param  mixed  $idObject
     * @param  string  $rating
     * @param  mixed  $user_id
     * @return bool
     * @throws InvalidArgumentException
     */
    public function makeVote($idObject, $rating, $userId)
    {
        if('up'==$rating){
            ObjectsList::where('id', $idObject)->increment('rating_good');
            $ratingGood = 1;   
            $ratingBad  = 0;   
        }elseif('down'==$rating){
            ObjectsList::where('id', $idObject)->increment('rating_bad');
            $ratingGood = 0;   
            $ratingBad  = 1;
        }

        $user = new UsersVotes();
        $user->id_user   = $userId;
        $user->id_object = $idObject;
        $user->rating_good = $ratingGood;
        $user->rating_bad  = $ratingBad;
        $user->save();

        return true;    
    }

    /**
     * check may whether vote
     *
     * @param  mixed  $idObject
     * @param  mixed  $user_id
     * @return bool
     * @throws RuntimeException
     */
    public function canVote($idObject, $userId)
    {
        $existingUser = UsersVotes::where('id_user', $userId)->where('id_object', $idObject)->get();
        
        if($existingUser->isEmpty()){
            return true;
        }else{
            return false;
        }
    }
}
