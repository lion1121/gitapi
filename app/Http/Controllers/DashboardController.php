<?php

namespace App\Http\Controllers;

use App\Repo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function showRepo(Request $request)
    {
//        dd($request->route()->parameters());
        $owner = $request->route()->parameters()['owner'];
        $name = $request->route()->parameters()['name'];
        $endpoint = "http://api.github.com/repos/" . $owner . "/" . $name;
//        return response()->json($endpoint);

        return view('dashboard.reposinfo',compact('endpoint'));




    }
}
