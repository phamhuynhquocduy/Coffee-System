package com.example.coffeesystem.ui.dashboard

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import androidx.recyclerview.widget.LinearLayoutManager
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.toolbox.JsonArrayRequest
import com.android.volley.toolbox.Volley
import com.example.coffeesystem.R
import com.example.coffeesystem.databinding.ActivityDetailProductBinding
import com.example.coffeesystem.databinding.ActivityListProductBinding
import com.example.coffeesystem.model.Product
import com.example.coffeesystem.network.requestProduct
import com.example.coffeesystem.network.url
import com.example.coffeesystem.ui.home.ProductAdapter
import org.json.JSONException

class ListProductActivity : AppCompatActivity(){

    private lateinit var binding: ActivityListProductBinding
    private var requestQueue: RequestQueue? = null
    private val mAdapter = ProductAdapter(arrayListOf())
    private val mReceiveOderList = ArrayList<Product>()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_list_product)
        binding = ActivityListProductBinding.inflate(layoutInflater)
        val view = binding.root
        setContentView(view)

        var id = intent.getIntExtra("id",1)
        jsonParse(id)
        mAdapter.addItems(mReceiveOderList)
        val layoutManager = LinearLayoutManager(this)
        binding.rvListProductCategory.layoutManager = layoutManager
        binding.rvListProductCategory.adapter = mAdapter

    }
    private fun jsonParse(id: Int) {
        requestQueue = Volley.newRequestQueue(this)
        val request = JsonArrayRequest(Request.Method.GET, "http://45.77.29.150/data/json/$id/one-cate-all-product", null, { response ->
            try {
                for (i in 0 until response.length()) {
                    val product = response.getJSONObject(i)
                    val id = product.getInt("id")
                    val name = product.getString("name")
                    val description = product.getString("description")
                    val image = url  + product.getString("image")
                    val price = product.getDouble("price")
                    val idcategory = product.getInt("id_category")
                    val status = product.getString("status")
                    mReceiveOderList.add(Product(id, name, image, description, price, idcategory))
                    mAdapter.addItems(mReceiveOderList)
                }
            } catch (e: JSONException) {
                e.printStackTrace()
                Log.e("reponsecategory", e.message.toString())
            }
        }, { error ->
            error.printStackTrace()
            Log.e("reponsecategoryerror", error.message.toString())
        })
        requestQueue?.add(request)
    }
}