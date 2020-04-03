<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
// use Users;
use App\Daily_scrum;   
use Illuminate\Support\Facades\Validator;
use DB;

class DailyScrumController extends Controller
{
 
    
    public function getAll($limit = 10, $offset = 0, $id_users)
    {
    	try{
	        $data["count"] = Daily_scrum::count();
	        $daily_scrums = array();
	        $dataDaily_scrum = DB::table('daily_scrums')->join('users','users.id','=','daily_scrums.id_users')
                                               ->select('daily_scrums.id', 'users.Firstname','users.Lastname','users.email', 
                                               'daily_scrums.team','daily_scrums.id_users','daily_scrums.activity_yesterday',
                                               'daily_scrums.activity_today','daily_scrums.problem_yesterday','daily_scrums.solution','daily_scrums.created_at')
                                               ->skip($offset)
                                               ->take($limit)
                                               ->where('daily_scrums.id_users', $id_users)
	                                           ->get();

	        foreach ($dataDaily_scrum as $p) {
	            $item = [
                    "id"          		      => $p->id,
                    "id_users"              => $p->id_users,
	                  "Firstname"  		        => $p->Firstname,
	                  "Lastname"  			      => $p->Lastname,
	                  "email"    	  		      => $p->email,
	                  "team"  		            => $p->team,
                    "activity_yesterday"  	=> $p->activity_yesterday,
                    "activity_today"  	    => $p->activity_today,
	                  "problem_yesterday"	    => $p->problem_yesterday,
                    "solution"              => $p->solution,
                    "created_at"            =>$p->created_at,
                    "tanggal"               => date('D, j F Y', strtotime($p->created_at)),
	            ];

	            array_push($daily_scrums, $item);
	        }
	        $data["daily_scrums"] = $daily_scrums;
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
        'activity_today'		    => 'required|string',
        'problem_yesterday'		  => 'required|string',
				'solution'		          => 'required|string',

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

