<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];

        // dd($credentials);

        if(Auth::attempt($credentials))
        {
            $products = Product::all()->count();
            $user=Auth::user();
            $success['token']=$user->createToken('laravel')->accessToken;
            $success['name']=$user->name;
            $name = $user->name;
            $id = $user->id;
            session(['name'=>$name]);
            session(['id'=>$id]);
            return response()->view('dashboard',compact('products'));
        }
        return response()->json('Unauthorized',401);

    }
    public function refreshToken(ServerRequestInterface $request)
    {
        try {
            $data = json_decode(parent::issueToken($request)->content(), true);
            return response()->json($data);

        } catch (ModelNotFoundException $e) {
            return response()->json(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                ),
            ), 401);
        } catch (OAuthServerException $e) {
            return response()->json(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                ),
            ), 401);
        } catch (Exception $e) {
            return response()->json(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                ),
            ), 500);
        }
    }
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'password'=>'required | min:3',
            'email'=>'required',
        ]);
        if($validator->fails())
        {
            return response()->json(['status'=>'failed','message'=>$validator->messages()],200);
        }

        $user=new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();
        return response()->json(['status'=>'success','message'=>''],200);

    }

    public function index()
    {

    }

}

?>
