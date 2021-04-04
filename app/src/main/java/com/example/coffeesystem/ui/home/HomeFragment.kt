package com.example.coffeesystem.ui.home

import android.os.Build
import android.os.Bundle
import android.view.*
import android.widget.SearchView
import androidx.annotation.RequiresApi
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.toolbox.JsonArrayRequest
import com.android.volley.toolbox.Volley
import com.example.coffeesystem.R
import com.example.coffeesystem.databinding.FragmentHomeBinding
import com.example.coffeesystem.model.Product
import org.json.JSONException

class HomeFragment : Fragment() {

    private var _binding: FragmentHomeBinding? = null
    private val binding get() = _binding!!
    private val mAdapter = ProductAdapter(arrayListOf())
    private val mReceiveOderList = ArrayList<Product>()
    private var requestQueue: RequestQueue? = null
    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        _binding = FragmentHomeBinding.inflate(inflater, container, false)
        return binding.root
    }

    @RequiresApi(Build.VERSION_CODES.LOLLIPOP)
    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        //Menu
        setHasOptionsMenu(true)

         jsonParse()
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
        val url = "http://45.77.29.150/product/data/all/json"
        val request = JsonArrayRequest(Request.Method.GET, url, null, { response ->
            try {
                for (i in 0 until response.length()) {
                    val product = response.getJSONObject(i)
                    val id = product.getInt("id")
                    val name = product.getString("name")
                    val description = product.getString("description")
                    val image =
                        "http://45.77.29.150/public/save/images/product/" + product.getString("image")
                    val price = product.getDouble("price")
                    val idcategory = product.getInt("id_category")
                    val status = product.getString("status")
                    mReceiveOderList.add(Product(id, name, image, description, price, idcategory))
                    mAdapter.addItems(mReceiveOderList)
                }
            } catch (e: JSONException) {
                e.printStackTrace()
            }
        }, { error ->
            error.printStackTrace()
        })
        requestQueue?.add(request)
}
    override fun onCreateOptionsMenu(menu: Menu, inflater: MenuInflater) {
        inflater.inflate(R.menu.home_menu, menu)
        super.onCreateOptionsMenu(menu, inflater)
    }
}