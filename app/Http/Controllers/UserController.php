<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

        switch (\Auth::user()->division_id) {
            case 1:
                $data['users'] = User::where([
                    ['division_id' , '!=', 1],
                ])->with('division')->orderBy('id', 'asc')->get();
                break;
            case 2:
                $data['users'] = User::where([
                    ['division_id' , '!=', 1],
                    ['division_id' , '!=', 2],
                ])->with('division')->orderBy('id', 'asc')->get();
                break;
        }

        return view('user.index',$data);
    }

    public function create(){
        switch (\Auth::user()->division_id) {
            case 1:
                $data['divisions'] = Division::all();
                break;
            case 2:
                $data['divisions'] = Division::where([
                    ['id', '!=', 1],
                    ['id', '!=', 2],
                ])->get();
                break;
        }
        return view('user.create',$data);
    }
    public function edit($id){
        switch (\Auth::user()->division_id) {
            case 1:
                $data['divisions'] = Division::all();
                break;
            case 2:
                $data['divisions'] = Division::where([
                    ['id', '!=', 1],
                    ['id', '!=', 2],
                ])->get();
                break;
        }

        $data['user'] = User::findOrFail($id);
        
        return view('user.edit',$data);
    }

    public function post(Request $request){
        $request->validate([
            'name' => 'required',
            'division' => 'required|numeric',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed|min:3',
        ]);

        $user               = new User;
        $user->name         = $request->name;
        $user->division_id  = $request->division;
        $user->username     = $request->username;
        $user->password     = Hash::make($request->password);
        $user->phone_number = $request->phone_number;
        
        if($user->save())
        {
            $alert = [
                "type" => "alert-success",
                "msg"  => "Data barang berhasil ditambahkan!"
            ];
            return redirect()->route('user')->with($alert);
        }
        $alert = [
            "type" => "alert-danger",
            "msg"  => "Data user gagal ditambahkan!"
        ];
        return redirect()->back()->with($alert);
    }

    public function put(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'division' => 'required|numeric',
            'username' => 'required',
        ]);

        $user               = User::findOrFail($id);
        $user->name         = $request->name;
        $user->division_id  = $request->division;
        $user->username     = $request->username;
        $user->phone_number = $request->phone_number;
        
        try {
            if($user->save())
            {
                $alert = [
                    "type" => "alert-success",
                    "msg"  => "Data user berhasil diubah!"
                ];
                return redirect()->route('user')->with($alert);
            }
            $alert = [
                "type" => "alert-danger",
                "msg"  => "Data user gagal diubah!"
            ];
            return redirect()->back()->with($alert);
        } catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                return back()->withErrors(['username' => 'The username has already been taken.']);
            }
        }
        
    }
    public function changePassword(Request $request, $id){
        $request->validate([
            'password' => 'required',
            'password_baru' => 'required|confirmed',
        ]);
        $current_user = User::findOrFail(\Auth::user()->id);
        if(!Hash::check($request->password, $current_user->password)){
            return back()->withErrors(['password' => 'The password you entered does not match.']);
        }

        $user           = User::findOrFail($id);
        $user->password = Hash::make($request->password_baru);
        
        if($user->save())
        {
            $alert = [
                "type" => "alert-success",
                "msg"  => "Password berhasil diubah!"
            ];
            return redirect()->route('user')->with($alert);
        }
        $alert = [
            "type" => "alert-danger",
            "msg"  => "Password gagal diubah!"
        ];
        return back()->with($alert);
        
    }

    public function delete($id){
        $user = User::findOrFail($id);
        
        try {
            if($user->delete())
            {
                $alert = [
                    "type" => "alert-success",
                    "msg"  => "Data user berhasil dihapus!"
                ];
                
                return redirect()->route('user')->with($alert);
            }
            $alert = [
                "type" => "alert-danger",
                "msg"  => "Data user gagal dihapus!"
            ];
            return redirect()->route('user')->with($alert);
            
        } catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1451'){
                // return ResponseFormatter::error($product, "Data barang tidak dapat dihapus! $product->name memiliki relasi dengan data transaksi.", 200);
                $alert = [
                    "type" => "alert-danger",
                    "msg"  => "Data user tidak dapat dihapus! $user->name memiliki relasi dengan data transaksi."
                ];
                return redirect()->route('user')->with($alert);
            }
        }


    }

    public function access(Request $request, $id){
        $user = User::findOrFail($id);

        if($user->status == 'active')
        {
            $user->status = 'unactive';
        }
        else{
            $user->status = 'active';
        }

        if($user->Save())
        {
            $alert = [
                "type" => "alert-success",
                "msg"  => "Akses user berhasil diubah!"
            ];
            
            return redirect()->route('user')->with($alert);
        }
        $alert = [
            "type" => "alert-success",
            "msg"  => "Akses user gagal diubah!"
        ];
        
        return redirect()->route('user')->with($alert);
    }
}