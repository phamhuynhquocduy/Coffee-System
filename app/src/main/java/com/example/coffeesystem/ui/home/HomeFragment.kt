package com.example.coffeesystem.ui.home

import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.view.*
import android.widget.SearchView
import android.widget.Toast
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
import com.example.coffeesystem.databinding.FragmentHomeBinding
import com.example.coffeesystem.model.Product
import com.example.coffeesystem.network.requestProduct
import com.example.coffeesystem.network.url
import org.json.JSONArray
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


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        //Menu
        setHasOptionsMenu(true)

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
            "http://45.77.29.150/api/product/filter",
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
                                idcategory
                            )
                        )
                        mAdapter.addItems(mReceiveOderList)
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
                val str =
                    "{\"name\":\"" + "fr" + "\",\"category\":\"" +"5"+ "\"}"
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
        binding.toolbarHome.inflateMenu(R.menu.home_menu)
        super.onCreateOptionsMenu(menu, inflater)
    }

    override fun onOptionsItemSelected(item: MenuItem): Boolean {
        return when (item.itemId) {
            R.id.navigation_cart -> {
                Toast.makeText(activity, "click on setting", Toast.LENGTH_LONG).show()
                true
            }
            R.id.navigation_filter -> {
                activity?.startActivity(Intent(activity, FilterActivity::class.java))
                true
            }
            else -> {
                Toast.makeText(activity, "click on setting", Toast.LENGTH_LONG).show()
                true
               // super.onOptionsItemSelected(item)
            }
        }
    }
}