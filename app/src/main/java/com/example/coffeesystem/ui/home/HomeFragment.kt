package com.example.coffeesystem.ui.home

import android.app.Activity
import android.app.Dialog
import android.content.Context
import android.content.Intent
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.util.Log
import android.view.*
import android.widget.*
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import com.android.volley.AuthFailureError
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.JsonArrayRequest
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.coffeesystem.R
import com.example.coffeesystem.cart.CartActivity
import com.example.coffeesystem.databinding.FragmentHomeBinding
import com.example.coffeesystem.model.Product
import com.example.coffeesystem.network.requestProduct
import com.example.coffeesystem.network.url
import com.example.coffeesystem.ui.authencation.EMAIL_PATTERN
import org.json.JSONArray
import org.json.JSONException
import java.sql.BatchUpdateException
import java.text.DecimalFormat
import java.util.regex.Matcher
import java.util.regex.Pattern


class HomeFragment : Fragment() {

    private var _binding: FragmentHomeBinding? = null
    private val binding get() = _binding!!
    private val mAdapter = ProductAdapter(arrayListOf())
    private val mReceiveOderList = ArrayList<Product>()
    private var mReceiveOderListCopy = ArrayList<Product>()
    private var requestQueue: RequestQueue? = null

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        _binding = FragmentHomeBinding.inflate(inflater, container, false)
        return binding.root

    }


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        //Menu
        binding.toolbarHome.setOnMenuItemClickListener { item ->
            when (item.itemId) {
                R.id.navigation_cart -> {
                    activity?.startActivity(Intent(activity, CartActivity::class.java))
                }
                R.id.navigation_filter -> {
                   eventDialog()
                }
            }
            true
        }

        //jsonParse()
        jsonParseProduct()
        mAdapter.addItems(mReceiveOderList)
        val layoutManager = LinearLayoutManager(requireContext())
        binding.rvListProduct.layoutManager = layoutManager
        binding.rvListProduct.adapter = mAdapter

        searchEvent()

    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }

    private fun searchEvent() {
        binding.searchBar.queryHint
        binding.searchBar.setOnQueryTextListener(object : SearchView.OnQueryTextListener,
            androidx.appcompat.widget.SearchView.OnQueryTextListener {
            override fun onQueryTextSubmit(p0: String?): Boolean {
                return false
            }

            override fun onQueryTextChange(p0: String?): Boolean {
                //Start filtering the list as user start entering the characters
                if (p0 != null) {
                    mAdapter.filterName(p0)
                }
                return false
            }
        })
    }

    private fun jsonParse() {
        requestQueue = Volley.newRequestQueue(activity)
        val request: StringRequest = object : StringRequest(
            Request.Method.POST,
            "http://45.77.29.150/api/filter/result",
            Response.Listener { response ->
                val array = JSONArray(response)
                try {
                    for (i in 0 until array.length()) {
                        val product = array.getJSONObject(i)
                        val id = product.getInt("id")
                        val name = product.getString("name")
                        val description = product.getString("description")
                        val image =
                            com.example.coffeesystem.network.url + "/" + product.getString("image")
                        val price = product.getDouble("price")
                        val idcategory = product.getInt("id_category")
                        val status = product.getString("status")
                        mReceiveOderList.add(
                            Product(
                                id,
                                name,
                                image,
                                description,
                                price,
                                idcategory,
                                status
                            )
                        )
                        mAdapter.addItems(mReceiveOderList)
                        Log.e("response",mReceiveOderList.toString())
                    }
                } catch (e: JSONException) {
                    e.printStackTrace()
                }
            },
            Response.ErrorListener {
                Log.e("response", it.message.toString())
            }) {
            override fun getHeaders(): MutableMap<String, String> {
                val params: MutableMap<String, String> = HashMap()
                params["X-Requested-With"] = "XMLHttpRequest"
                return params
            }
            override fun getBodyContentType(): String? {
                return "application/json; charset=utf-8"
            }
            @Throws(AuthFailureError::class)
            override fun getBody(): ByteArray {
                val str ="{}"
                    //"{\"name\":\"" + "fr" + "\",\"category\":\"" +"5"+ "\"}"
                return str.toByteArray()
            }
        }
        requestQueue?.add(request)
    }

    private fun jsonParseProduct() {
        requestQueue = Volley.newRequestQueue(activity)
        val request = JsonArrayRequest(Request.Method.GET, requestProduct, null, { response ->
            try {
                for (i in 0 until response.length()) {
                    val product = response.getJSONObject(i)
                    val id = product.getInt("id")
                    val name = product.getString("name")
                    val description = product.getString("description")
                    val image = url + "/" + product.getString("image")
                    val price = product.getDouble("price")
                    val idcategory = product.getInt("id_category")
                    val status = product.getString("status")
                    mReceiveOderList.add(Product(id, name, image, description, price, idcategory,status))
                    Log.e("response",mReceiveOderList.toString())
                }
                mReceiveOderListCopy =mReceiveOderList
                mAdapter.addItems(mReceiveOderList)
            } catch (e: JSONException) {
                e.printStackTrace()
            }
        }, { error ->
            error.printStackTrace()
        })
        requestQueue?.add(request)
    }
    fun eventDialog() {
        //Create Dialog
        val dialog = Dialog(activity as Context)
        dialog?.setCancelable(true);
        dialog?.setContentView(R.layout.dialog_filter)
        dialog?.show()
        var dismiss = dialog.findViewById<ImageButton>(R.id.img_btn_dismiss)
        var edt_min = dialog.findViewById<EditText>(R.id.edittext_min)
        var edt_max = dialog.findViewById<EditText>(R.id.edittext_max)
        var buttonFilter = dialog.findViewById<Button>(R.id.bnt_accept)
        var buttonCancel = dialog.findViewById<Button>(R.id.btn_cancel)
        var spinner = dialog.findViewById<Spinner>(R.id.spinner)

        dismiss.setOnClickListener(){
            dialog.dismiss()
        }
        buttonFilter.setOnClickListener(){
            if(edt_max.text.toString().toInt()<edt_min.text.toString().toInt()){
                Toast.makeText(activity,"Vui lòng nhập lại khoảng giá",Toast.LENGTH_SHORT).show()
            }else{
                var mlist = mReceiveOderList.filter {
                    it.price<=edt_max.text.toString().toInt()&&it.price>=edt_min.text.toString().toInt()
                } as ArrayList<Product>
                searchEvent()
                mAdapter.addItems(mlist)
                dialog.dismiss();
            }
        }
        buttonCancel.setOnClickListener(){
            mAdapter.addItems(mReceiveOderListCopy)
            dialog.dismiss()
        }
//        edt_max.addTextChangedListener(object : TextWatcher {
//            override fun beforeTextChanged(s: CharSequence, start: Int, count: Int, after: Int) {
//                if(edt_max.text.toString()!=""){
//                    val decimalFormat = DecimalFormat("###,###,###")
//                    Log.d("dddddd",decimalFormat.format(edt_max.text.toString()))
//                    //edt_max.setText(decimalFormat.format(edt_max.text.toString().toInt()).toString())
//                }
//            }
//            override fun onTextChanged(s: CharSequence, start: Int, before: Int, count: Int) {
//                val decimalFormat = DecimalFormat("###,###,###")
//                if(edt_max.text.toString()!=""){
//                  //  edt_max.setText(decimalFormat.format(edt_max.text.toString().toInt()).toString())
//                }
//            }
//            override fun afterTextChanged(s: Editable) {
//                val decimalFormat = DecimalFormat("###,###,###")
//                if(edt_max.text.toString()!=""){
//                  //  edt_max.setText(decimalFormat.format(edt_max.text.toString().toInt()).toString())
//                }
//            }
//        })

    }


}