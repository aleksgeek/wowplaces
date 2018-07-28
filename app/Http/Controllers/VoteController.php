<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Auth\AuthLogic;
use App\Repositories\Users\VoteRepository;
use InvalidArgumentException;

class VoteController extends Controller
{
    /**
     * @var VoteRepository
     */
    protected $voteRepository;

    /**
     * @var AuthLogic
     */
    protected $authLogic;

    public function __construct(VoteRepository $vote, AuthLogic $auth)
    {
        $this->voteRepository = $vote;
        $this->authLogic = $auth;
    }

    /**
     * voting for interesting object
     *
     * @param Illuminate\Http\Request $request
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function makeVoting(Request $request)
    {
        try{
            $idObject  = $request->input('id_object');
            $rating    = $request->input('rating');  
            $user      = $this->authLogic->getAuthenticatedUser();

            if(!in_array($rating, ['up', 'down'])){
                throw new InvalidArgumentException('argument $rating is not correct', 400);
            }

            if($this->voteRepository->canVote($idObject, $user['id'])){
                $this->voteRepository->makeVote($idObject, $rating, $user['id']);
                return response()->json('vote was successful'); 
            }else{      
                return response()->json('you have already voted', 400);
            }   
        }catch(InvalidArgumentException $e){
            return response()->json('bad enter data', $e->getCode());
        }
    }

}
