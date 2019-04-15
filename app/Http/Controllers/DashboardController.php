<?php

namespace App\Http\Controllers;

use App\Repo;
use App\User;
use Github\Exception\ApiLimitExceedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dashboard.index');
    }

    public function getUserRepos(Request $request)
    {
        if (Auth::user() !== null) {
            $repos = User::findOrFail(Auth::id())->repos()->get();

            return response()->json($repos);
        }
    }

    public function likeRepo(Request $request)
    {
        $repo = Repo::where(['full_name' => $request->repoName, 'user_id' => Auth::id()])->first();

        if ($repo === null) {
            $repo = new Repo();
            $input['full_name'] = $request->repoName;
            $input['user_id'] = Auth::id();
            $input['is_liked'] = 1;
            $repo->create($input);
            return response()->json($request->repoName);
        }
        if ($repo->is_liked !== 1) {
            $repo->is_liked = 1;
            $repo->save();
            return response()->json($request->repoName);
        } else {
            $repo->is_liked = 0;
            $repo->save();
            return response()->json($request->repoName);
        }
    }

    public function diselikeRepo(Request $request)
    {
        $repo = Repo::where(['full_name' => $request->repoName, 'user_id' => Auth::id()])->first();
        if ($repo->is_liked === 1) {
            $repo->is_liked = 0;
            $repo->save();
            return response()->json($request->repoName);
        } else {
            $repo->is_liked = 1;
            $repo->save();
        }
    }

    public function showRepo($id)
    {
        $repoId = filter_var($id, FILTER_VALIDATE_INT);

        $client = new \Github\Client();

        try {
            $repository =  $client->api('repo')->showById($repoId);
            if(!is_array($repository)){
                throw new Exception("You can make 60 requests in hour");
            }
        }catch (ApiLimitExceedException $e){
            echo $e->getMessage();
        }

        $id = $repository['id'];
        $name = $repository['name'];
        $owner = $repository['owner']['login'];
        $stars = $repository['stargazers_count'];
        return view('dashboard.reposinfo', compact('id','name','owner','stars'));




    }
}
