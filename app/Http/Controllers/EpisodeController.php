<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Episode;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        //

        $validation = Validator::make($request->all(), [

            'page' => 'sometimes|required|numeric'
        ]);



        $page = $request->page ?? 1;

        $https = new Client();

        $response = $https->get("rickandmortyapi.com/api/episode/?page=$page");


        $api_results = json_decode($response->getBody()->getContents());


        $episodes = $api_results->results;



        $new_episodes = [];


        foreach ($episodes as $episode) {

            $new_episode = [

                'id' => $episode->id,
                'name' => $episode->name,
                'comment_count' => $commentCount = Comment::where('episode_id', $episode->id)->count()
            ];

            $new_episodes[] = $new_episode;


        }


        return response()->json([
            'status' => 200,
            'data' => $new_episodes,
        ]);

    }

    public function getCharacterList(Request $request)
    {


        $validation = Validator::make($request->all(), [

            'episode_id' => 'required|numeric'
        ]);

        $episode_id = $request->episode_id;

        $https = new Client();
        $response = $https->get("rickandmortyapi.com/api/episode/$episode_id");


        $episode = json_decode($response->getBody()->getContents());

        $characters = $episode->characters;

        $character_detail = [];

        foreach ($characters as $character){

            $https = new Client();
            $response = $https->get("$character");
            $char = json_decode($response->getBody()->getContents());

            $character_details = [
                'id' => $char->id,
                'name'=> $char->name,
                'status'=>$char->status,
                'species'=>$char->species,
                'gender'=>$char->gender
            ];


            $character_detail[] = $character_details;
        }

        return response()->json([
            'status' => 200,
            'data' => $character_detail
        ]);

    }


}

