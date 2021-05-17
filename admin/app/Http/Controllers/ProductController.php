<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(empty(Auth::check())){
            Session::put('message', '<p style="color: red;">Bạn cần phải đăng nhập</p>');
            return redirect('login');
        }
        $list_cate = Category::all();
        $list_product = Product::paginate(10);
        return view('page.product.all', compact(['list_cate', 'list_product']));
    }
    // convert json product
    public function conver_product_json(){
        $product = Product::all();
        return response()->json($product);
    }

    public function get_all()
    {
        $products = Product::with('attrs')->get();

        return $products;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(empty(Auth::check())){
            Session::put('message', '<p style="color: red;">Bạn cần phải đăng nhập</p>');
            return view('login');
        }

        $attrs = Attribute::all();

        $list_cate = Category::all();
        return view('page.product.create', compact(['list_cate', 'attrs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());

        $image = $request->file('inputImage');
        $name_image = $image->getClientOriginalName();
        $image->move('public/save/images/product/', $name_image );
        $like = Product::where('name', $request->inputName)->get();
        if(!empty($like[0]->name)){
            Session::put('message', '<p style="color:red;">Sản phẩm đã tồn tại, vui lòng nhập sản phẩm khác!!</p>');
            return redirect('product/create');
        }
        $arr = array();
        $arr['name'] = $request->inputName;
        $arr['description'] = $request->inputDescription;
        $arr['image'] = 'public/save/images/product/'.$name_image;
        $arr['price'] = $request->inputPrice;
        $arr['id_category'] = $request->inputCategory;
        $arr['status'] = $request->inputStatus;

        $product = Product::create($arr);

        // add attr
        $this->saveAttr($product, $request);

        Session::put('message', '<p style="color:green;">Thêm sản phẩm thành công</p>');
        return redirect('product/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
        $info_pro = Product::where('id', $id)->get();
        return view('page.product.view',compact(['info_pro']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if(empty(Auth::check())){
            Session::put('message', '<p style="color: red;">Bạn cần phải đăng nhập</p>');
            return view('login');
        }
        
        // attr
        $attrs = Attribute::all();

        $list_cate = Category::all();
        $edit_pro = Product::with('attrs')->where('id', $id)->get();

        // return response()->json($edit_pro[0]->attrs[0]->pivot->name_attr_value);
        return view('page.product.edit', compact(['list_cate','edit_pro', 'attrs']));
    }
    public function editjson($id){
        $edit_pro = Product::where('id', $id)->get(['id','name']);
        return response()->json($edit_pro);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $arr =array();
        
        $image = $request->file('inputImage');
        if($image){
            $name_image = rand(0,200).$image->getClientOriginalName();
            $image->move('public/save/images/product',  $name_image);
            $arr['image'] = 'public/save/images/product/'.$name_image;
        }
        
        $arr['name'] = $request->inputName;
        $arr['description'] = $request->inputDescription;
        $arr['price'] = $request->inputPrice;
        $arr['id_category'] = $request->inputCategory;
        
        $product = Product::find($id);

        $product->update($arr);

        $this->saveAttr($product, $request);

        Session::put('message', '<p style="color:green;">Cập nhật sản phẩm thành công</p>');
        return redirect('product');
    }

    protected function saveAttr($product, $request)
    {
        // attr name
        $attr_name = [];
        foreach($request->input('attr_name') as $attrId => $value)
        {
            if(!empty($value))
            {
                $attr_name[$attrId] = [
                    'name_attr_value' => $value
                ];
            }
        }
        // dd($attr_name);
        // attr price
        $attr_price = [];
        foreach($request->input('attr_price') as $attrId => $value)
        {
            if(!empty($value))
            {
                $attr_price[$attrId] = [
                    'price_attr_value' => $value
                ];
            }
        }

        $product->attrs()->sync($attr_name);
        $product->attrs()->sync($attr_price);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(empty(Auth::check())){
            Session::put('message', '<p style="color: red;">Bạn cần phải đăng nhập</p>');
            return view('login');
        }
        Product::where('id',$id)->delete();
        Session::put('message', '<p style="color:red;">Xóa sản phẩm thành công</p>');
        return redirect('product');
    }
    // get json theo nhóm 
    public function one_cate_all_pro($id)
    {
        $get_all_pro_one_cate = Product::where('id_category', $id)->get();

        return response()->json($get_all_pro_one_cate);
    }
    // them topping
    public function save_attribute(Request $request)
    {
        $arr = array();
        $arr['id_attribute'] = $request->id_attribute;
        $arr['id_product'] = $request->id_product;
        $arr['name'] = $request->topping;
        $arr['price'] = $request->topping_price;
        // dd($arr);
        AttributeValues::insert($arr);

        if($request->id_attribute == 1)
        {
            Session::put('message', '
            <div class="alert alert-success" role="alert">
                Thêm topping thành công
            </div>
            ');
        }
        else
        {
            Session::put('message', '
            <div class="alert alert-success" role="alert">
                Thêm size thành công
            </div>
            ');
        }
        return redirect()->back();
    }
    
    // thumbs down
    public function thumbs_down($id)
    {
        Product::find($id)->update(['status'=>'Hết']);

        Session::put('message', '<p style="color: red;">Thay đổi tình trạng "Hết" của sản phẩm thành công!</p>');

        return redirect()->back();
    }

    // thumbs up
    public function thumbs_up($id)
    {
        Product::find($id)->update(['status'=>'Còn']);

        Session::put('message', '<p style="color: green;">Thay đổi tình trạng "Còn" của sản phẩm thành công!</p>');

        return redirect()->back();
    }

    public function set_attr()
    {
        return view('page.product.create_attr');
    }

    public function get_attr(Request $request)
    {
        Attribute::create($request->only('name_attr'));

        return redirect()->back()->with('message','<p style="color:green;">Thêm thuộc tính thành công</p>');
    }
}
