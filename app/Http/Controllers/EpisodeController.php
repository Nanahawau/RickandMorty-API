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
     * Display a list of all episodes and their comment count.
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

        if (!$episodes) {

            return response()->json([
                'status' => 404,
                'message' => "Resource not Found"
            ]);
        }


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

    /**
     * Gets all characters in an episode
     * @param $episode
     * @return \Illuminate\Http\JsonResponse
     */

    public function show($episode)
    {

        $https = new Client();
        $response = $https->get("rickandmortyapi.com/api/episode/$episode");


        $episode = json_decode($response->getBody()->getContents());

        if (!$episode) {

            return response()->json([
                'status' => 404,
                'message' => "Resource not Found"
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => [
                'id' => $episode->id,
                'name' => $episode->name,
                'air_date' => $episode->air_date,
                'episode' => $episode->episode
            ]
        ]);

    }

    public function getCharacterList(Request $request, $episode)
    {
        $validation = Validator::make($request->all(), [
            'filterby' => 'nullable|in:status,species,type,gender',
            'keyword' => 'required_with:filterBy',
            'sortby' => 'nullable|in:name,gender,species',
            'order' => 'required_with:sortby|in:asc,desc'
        ]);


        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Bad Request',
                'errors' => $validation->errors()

            ]);

        }


        try {
            $https = new Client();
            $response = $https->get("rickandmortyapi.com/api/episode/$episode");

            $episode = json_decode($response->getBody()->getContents());

            $characters = collect([]);

            foreach ($episode->characters as $character) {
                $https = new Client();
                $response = $https->get("$character");
                $char = json_decode($response->getBody()->getContents());

                // Rebuild object
                $character_details = [
                    'id' => $char->id,
                    'name' => $char->name,
                    'status' => $char->status,
                    'species' => $char->species,
                    'gender' => $char->gender
                ];

                // Filter
                if ($request->has('filterby')) {
                    if (strtolower($request->keyword) === strtolower($character_details[$request->filterby])) {
                        $characters->push($character_details);
                    }
                } else {
                    $characters->push($character_details);
                }
            }

            if ($request->has('sortby')) {
                if ($request->order == 'asc') {
                    $characters = $characters->sortBy($request->sortby);
                } else {
                    $characters = $characters->sortByDesc($request->sortby);
                }
            }

            return response()->json([
                'status' => 200,
                'data' => $characters
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
        }
    }


}
