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
    protected $vote_repository;

    /**
     * @var AuthLogic
     */
    protected $auth_logic;

    public function __construct(VoteRepository $vote, AuthLogic $auth)
    {
    	$this->vote_repository = $vote;
        $this->auth_logic = $auth;
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
			$id_object = $request->input('id_object');
			$rating    = $request->input('rating');  
			$user      = $this->auth_logic->getAuthenticatedUser();

			if(!in_array($rating, ['up', 'down'])){
				throw new InvalidArgumentException('argument $rating is not correct', 400);
			}

			if($this->vote_repository->canVote($id_object, $user['id'])){
				$this->vote_repository->makeVote($id_object, $rating, $user['id']);
				return response()->json('vote was successful'); 
			}else{		
				return response()->json('you have already voted', 400);
			}	
		}catch(InvalidArgumentException $e){
			return response()->json('bad enter data', $e->getCode());
		}
	}

}
