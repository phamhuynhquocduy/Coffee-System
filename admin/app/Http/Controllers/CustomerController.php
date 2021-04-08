<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customer = Customer::paginate(10);
        return view('page.customer.all', compact(['customer']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('page.customer.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *///Save product method post
    public function store(Request $request)
    {
        //
        $arr = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => md5($request->password),
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];

        Customer::insert($arr);
        Session::put('message', '<p style="color: green;>Thêm tài khoản thành công</p>');
        return redirect('customer/create');
        
    }
    //trả dữ liệu ra json
    public function conver_customer_json(){
        return response()->json(Customer::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $edit_customer = Customer::where('id', $id)->get();
        return view('page.customer.edit', compact(['edit_customer']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $update = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => md5($request->password),
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
        
        Customer::where('id', $id)->update($update);
        Session::put('message', '<p style="color:green;">Cập nhật tài khoản người dùng thành công</p>');
        return redirect('customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Customer::where('id', $id)->delete();
        Session::put('message', '<p style="color: red;">Xóa tài khoản người dùng thành công</p>');
        return redirect('customer');
    }
}
