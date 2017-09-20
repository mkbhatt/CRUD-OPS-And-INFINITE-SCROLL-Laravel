<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Log;
use Validator;
use Session;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Route;
use File;
use CurlFile;

class Crud extends Controller
{

  protected $crud_title="SAMPLE CRUD OPERATIONS - LARAVEL APP";


  function Index(Request $request){
      
      return view('crud.modify',['crud_title'=>$this->crud_title]);

    }

  function AddMenu(Request $request){
    
    return view('crud.insert',['crud_title'=>$this->crud_title]);
  }

  function Insert(Request $request){
                    
     if ($request->isMethod('post')) {

        $input = $request->all();
        $rules=array(
            'post_t' => 'required|max:30',
            'post_d' => 'required',
              );

        $messages=array(
                    'post_t.required'=>'Post Title Is Required !',
                    'post_d.required'=>'Post Description Is Required !',
            );

    $validator = Validator::make($input, $rules,$messages);

    $err_messages = $validator->errors();

        if ($validator->fails()) 
        {
          $request->flash();
          return redirect('crud-add-menu')->withInput($request->all())->withErrors($validator);
        }

          try{

            $stamp = gmdate("Y-m-d H:i:s", time());
            $title = $input['post_t'];
            $desc = $input['post_d'];
            $slug_key = strtolower((string)(str_replace(' ','-',$input['post_t'])));
           
          DB::table('crud_content')->insert(
          ['title' => ucwords($title), 'description' =>ucwords($desc), 'slug_key' => $slug_key, 'created_on' =>$stamp, 'modified_on' =>$stamp]
          );

          $request->session()->flash('status_s', 'Post Added Successfully !');

          }
          catch(\Exception $e){

                      
            if ($e->getCode()==23000){
              
              $request->flash();
              $request->session()->flash('status_e', 'Duplicate Entry !');
              return redirect('crud-add-menu')->withInput($request->all())->withErrors($validator);

            }

            return "Error : ".$e->getMessage();

          }

          return redirect('crud-add-menu');

        }

        }


function GetAll(Request $request){

  $input = $request->all();

    $key = $request->input('key');

    $sess_key = session('key');

     try{

          if($request->ajax()==1) {

             
              //  Custom Manual Paginator Instance Laravel
             // use Illuminate\Pagination\LengthAwarePaginator as Paginator;

            if ($key=='ajax-content'){ 

            $year = $input['year'];
             
            $query =  DB::select("select id,title,description,created_on,modified_on,slug_key 
                                  from crud_content where DATE_FORMAT(created_on,'%Y') = $year order by created_on desc");


            
            $pageStart = request()->get('page', 1);
            
            $perPage = 3;
            $offset = ($pageStart * $perPage) - $perPage;

            $paginator = new Paginator (
                       
                       // RETURNS DATA IN ARRAY FORMAT
                       array_slice($query, $offset, $perPage, false),
                       
                       // RETURN DATA IN OBJECT FORMAT
                       // array_slice($query, $offset, $perPage, true),

                       count($query), $perPage, $pageStart, 
                       ['path' => $request->url(), 'query' => $request->query()]);


             return response()->json($paginator);

           }

           else if($key=='ajax-delete'){

            $input = $request->all();

            try{

              if($request->has('id')){

                $id = $input['id'];
    
                DB::table('crud_content')->where('id',$id)->delete();

                return "Deleted Successfully !";

              }

              if($request->has('bulk_id')){

                $bulk_id = $input['bulk_id'];

                foreach ($bulk_id as $value) {
                  DB::table('crud_content')->where('id',$value)->delete();
                }

                return "Bulk Delete, Successful !";

              }
  
            }
            catch(\Exception $e){
    
              return "Error : ".$e->getMessage();
            }

           }

           else if($key=='ajax-modify'){

            $input = $request->all();

            $id = $input['mod_id'];

            try{
    
              $data = DB::table('crud_content')->where('id',$id)->get();

              return response()->json(['data'=>$data[0]]);
  
            }
            catch(\Exception $e){
    
              return "Error : ".$e->getMessage();
            }

           }

           else if($key=='ajax-modify-update'){

            $input = $request->all();

            try{

              $post_id = $input['post_id'];
              $post_title = ucwords($input['post_title']);
              $post_description = ucwords($input['post_description']);
              $date = date_create();
              $stamp = date_timestamp_get($date);
              $slug_key = strtolower((string)(str_replace(' ','-',$input['post_title'])));

              DB::table('crud_content')->where('id',$post_id)->update(['title' =>ucwords($post_title),'description'=>ucwords($post_description),'slug_key'=>$slug_key,'modified_on'=>$stamp]);

              // return response()->json(['data'=>$request->all()]);

              return "Post Updated Successfully !";
  
            }
            catch(\Exception $e){
    
              return "Error : ".$e->getMessage();
            }

           }

           else{

              return 'Error : Unknown Ajax Key !';

           }


          }
        }
        catch(\Exception $e){
          Log::error($e->getMessage());
          return "Error : <br>".$e->getMessage();
        }


    return view('crud.modify',['crud_title'=>$this->crud_title]);

}


}
