<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Auth\AuthLogic;
use App\Repositories\Users\VoteRepository;

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
	 * vote up for interesting object
	 *
	 * @param Illuminate\Http\Request $request
	 */
	public function makeVoting(Request $request)
	{
		$id_object = $request->input('id_object');
		$rating = $request->input('rating');  
		$user = $this->auth_logic->getAuthenticatedUser();

		if($this->vote_repository->canVote($id_object, $user['id'])){
			$this->vote_repository->makeVote($id_object, $rating, $user['id']);
			return response()->json('vote was successful'); 
		}else{		
			return response()->json('you have already voted', 400);
		}	

		return response()->json('vote error', 500);  		
	}

}
