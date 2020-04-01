<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Daily_scrum;   
use Illuminate\Support\Facades\Validator;
// use DB;

class DailyScrumController extends Controller
{

    public function index()
    {
    	try{
            $data = Auth::user()->daily_scrums()->paginate(10);
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }   


    public function store(Request $request)
    {
      try{
    		$validator = Validator::make($request->all(), [
    			'team'                  => 'required|string|max:255',
				'activity_yesterday'    => 'required|string',
                'activity_today'		=> 'required|string',
                'problem_yesterday'		=> 'required|string',
				'solution'		        => 'required|string',

    		]);

    		if($validator->fails()){
    			return response()->json([
    				'status'	=> 0,
    				'message'	=> $validator->errors()
    			]);
    		}

            $data = new Daily_scrum();
            $data->id_users = Auth::user()->id;
	        $data->team = $request->input('team');
	        $data->activity_yesterday = $request->input('activity_yesterday');
            $data->activity_today = $request->input('activity_today');
            $data->problem_yesterday = $request->input('problem_yesterday');
            $data->solution = $request->input('solution');
	        $data->save();

    		return response()->json([
    			'status'	=> '1',
    			'message'	=> 'Data daily scrum berhasil ditambahkan!'
    		], 201);

      } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }
  	}
      
      public function delete($id)
    {
        try{

            $delete = Daily_scrum::where("id", $id)->delete();

            if($delete){
              return response([
              	"status"	=> 1,
                  "message"   => "Data daily scrum berhasil dihapus."
              ]);
            } else {
              return response([
                "status"  => 0,
                  "message"   => "Data daily scrum gagal dihapus."
              ]);
            }
        } catch(\Exception $e){
            return response([
            	"status"	=> 0,
                "message"   => $e->getMessage()
            ]);
        }
    }
}

