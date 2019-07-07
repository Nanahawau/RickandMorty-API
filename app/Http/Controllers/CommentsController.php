<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    /**
     * Returns comments of an episode
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function show($episode_id)
    {

        $comments = DB::table('comments')
            ->selectRaw('id, episode_id, comment, ip_address, created_at')
            ->where('episode_id', '=', $episode_id)
            ->orderBy('created_at', 'DESC')
            ->get();


        if (!$comments) {

            return response()->json([
                'status' => 404,
                'message' => 'Resource not Found',
                'error' => "There is no comment for this episode"
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $comments
        ]);
    }


    /**
     * Add a comment to an episode
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */


    public function create(Request $request, $episode_id)
    {

        $validation = validator::make($request->all(), [
            'comment' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Bad Request',
                'errors' => $validation->errors()

            ]);

        }

        $ip = request()->ip();



        try {
            $comment = Comment::create([
                'episode_id' => $episode_id,
                'comment' => $request->comment,
                'ip_address'=>$ip
            ]);


            $response = [
                'status' => 200,
                'message' => $comment
            ];

        } catch (\Exception $e) {

            $response = [
                'status' => 500,
                'message' => 'Something went wrong'
            ];
        } finally {
            return response()->json($response);
        }


    }

    /**
     * Update an existing comment
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, $id)
    {

        $validation = validator::make($request->all(), [
            'comment' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Bad Request',
                'errors' => $validation->errors()

            ]);
        }


        try {

            $comment = Comment::findOrFail($id);

            $comment->comment = $request->comment;

            $comment->save();

            $response = [
                'status' => 200,
                'message' => 'Comment Successfully Updated',
                'data' => $comment
            ];

        } catch (\Exception $e) {
            $response = [
                'status' => 500,
                'message' => 'Something went wrong'

            ];
        } finally {

            return response()->json($response);
        }

    }

    /**
     * Delete an existing comment
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {


        $comment = Comment::find($id);

        if (!$comment) {

            return response()->json([
                'status' => 404,
                'message' => "Resource not Found"
            ]);
        }

        $comment->delete();

        return response()->json([
            'status' => 200,
            'message' => "Comment successfully deleted"
        ]);
    }


}
