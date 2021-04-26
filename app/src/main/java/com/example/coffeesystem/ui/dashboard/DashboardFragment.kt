package com.example.coffeesystem.ui.dashboard

import android.content.Context
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.toolbox.JsonArrayRequest
import com.android.volley.toolbox.Volley
import com.example.coffeesystem.databinding.FragmentDashboardBinding
import com.example.coffeesystem.model.Category
import com.example.coffeesystem.model.Product
import com.example.coffeesystem.network.requestCategory
import com.example.coffeesystem.network.url
import org.json.JSONException


class DashboardFragment : Fragment() {
    private var _binding: FragmentDashboardBinding? = null
    private val binding get() = _binding
    private lateinit var mAdapter: CategoryAdapter
    private val mCategoryList = ArrayList<Category>()
    private var requestQueue: RequestQueue? = null
    private val mAdapterProduct = ProductCategoryAdapter(arrayListOf())
    private val mProduct = ArrayList<Product>()



    override fun onCreateView(
            inflater: LayoutInflater,
            container: ViewGroup?,
            savedInstanceState: Bundle?
    ): View? {
        _binding = FragmentDashboardBinding.inflate(inflater, container, false)
        return binding?.root
    }
    companion object{
        fun jsonParse(id: Int, activity: Context, mAdapter: ProductCategoryAdapter) {
            var requestQueue: RequestQueue? = null
            val mReceiveOderList = ArrayList<Product>()
            requestQueue = Volley.newRequestQueue(activity)
            val request = JsonArrayRequest(Request.Method.GET, "http://45.77.29.150/data/json/$id/one-cate-all-product", null, { response ->
                try {
                    for (i in 0 until response.length()) {
                        val product = response.getJSONObject(i)
                        val id = product.getInt("id")
                        val name = product.getString("name")
                        val description = product.getString("description")
                        val image = url + product.getString("image")
                        val price = product.getDouble("price")
                        val idcategory = product.getInt("id_category")
                        val status = product.getString("status")
                        mReceiveOderList.add(Product(id, name, image, description, price, idcategory))
                    }
                    Log.e("reponsecategory", "success")
                    mAdapter.addItems(mReceiveOderList)

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

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        mAdapter = CategoryAdapter(arrayListOf())
        jsonParse()
        mAdapter.addItems(mCategoryList)
        val layoutManager = CustomLinearLayoutManager(requireContext())
        binding?.rvCategory?.layoutManager = layoutManager
        binding?.rvCategory?.adapter = mAdapter
    }

    private fun jsonParse() {
        requestQueue = Volley.newRequestQueue(activity)
        val request = JsonArrayRequest(Request.Method.GET, "http://45.77.29.150/api/product/filter/category/4", null, { response ->
            Log.e("category", response.toString())
            try {
                for (i in 0 until response.length()) {
                    val product = response.getJSONObject(i)
                    val id = product.getInt("id")
                    val name = product.getString("name")
                    val description = product.getString("description")
                    val image = url + product.getString("image")
                    val listProductJson = product.getJSONArray("product")
                    for (i in 0 until listProductJson.length()) {
                        // getting each object from our json array.
                        try {
                            val id = product.getInt("id")
                            val name = product.getString("name")
                            val description = product.getString("description")
                            val image = url  + product.getString("image")
                            val price = product.getDouble("price")
                            val idcategory = product.getInt("id_category")
                            val status = product.getString("status")
                            mProduct.add(Product(id, name, image, description, price, idcategory))
                        } catch (e: JSONException) {
                            e.printStackTrace()
                        }
                    }
                    mCategoryList.add(Category(id, name, image, description,mProduct))
                }
                Log.e("categorylist", mCategoryList.toString())
                mAdapter.addItems(mCategoryList)

            } catch (e: JSONException) {
                e.printStackTrace()
                Log.e("categorylistexcpetion", e.message.toString())
            }
        }, { error ->
            error.printStackTrace()
            Log.e("categorylisterror", error.message.toString())
        })
        requestQueue?.add(request)
    }
}