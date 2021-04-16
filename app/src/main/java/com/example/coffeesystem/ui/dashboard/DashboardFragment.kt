package com.example.coffeesystem.ui.dashboard

import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.fragment.app.Fragment
import androidx.lifecycle.Observer
import androidx.lifecycle.ViewModelProvider
import androidx.recyclerview.widget.LinearLayoutManager
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.toolbox.JsonArrayRequest
import com.android.volley.toolbox.Volley
import com.example.coffeesystem.R
import com.example.coffeesystem.databinding.FragmentDashboardBinding
import com.example.coffeesystem.databinding.FragmentHomeBinding
import com.example.coffeesystem.model.Category
import com.example.coffeesystem.model.Product
import com.example.coffeesystem.network.requestCategory
import com.example.coffeesystem.network.requestProduct
import com.example.coffeesystem.network.url
import com.example.coffeesystem.ui.home.ProductAdapter
import org.json.JSONException

class DashboardFragment : Fragment() {
    private var _binding: FragmentDashboardBinding? = null
    private val binding get() = _binding!!
    private val mAdapter = CategoryAdapter(arrayListOf())
    private val mCategoryList = ArrayList<Category>()
    private var requestQueue: RequestQueue? = null

    override fun onCreateView(
            inflater: LayoutInflater,
            container: ViewGroup?,
            savedInstanceState: Bundle?
    ): View? {
        _binding = FragmentDashboardBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        jsonParse()
        mAdapter.addItems(mCategoryList)
        val layoutManager = LinearLayoutManager(requireContext())
        binding.rvCategory.layoutManager = layoutManager
        binding.rvCategory.adapter = mAdapter

    }
    private fun jsonParse() {
        requestQueue = Volley.newRequestQueue(activity)
        val request = JsonArrayRequest(Request.Method.GET, requestCategory, null, { response ->
            Log.e("category",response.toString())
            try {
                for (i in 0 until response.length()) {
                    val product = response.getJSONObject(i)
                    val id = product.getInt("id")
                    val name = product.getString("name")
                    val description = product.getString("description")
                    val image = url  + product.getString("image")
                    mCategoryList.add(Category(id, name, image, description))
                    mAdapter.addItems(mCategoryList)
                }
            } catch (e: JSONException) {
                e.printStackTrace()
            }
        }, { error ->
            error.printStackTrace()
        })
        requestQueue?.add(request)
    }
}