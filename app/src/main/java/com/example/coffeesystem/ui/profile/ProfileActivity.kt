package com.example.coffeesystem.ui.profile

import android.os.Bundle
import android.util.Log
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.JsonObjectRequest
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.coffeesystem.databinding.ActivityProfileBinding
import com.example.coffeesystem.network.requestUpdateProfile
import com.example.coffeesystem.ui.authencation.LoginFragment
import com.example.coffeesystem.ui.authencation.LoginFragment.Companion.person
import org.json.JSONObject


class ProfileActivity : AppCompatActivity() {

    private lateinit var binding: ActivityProfileBinding
    private var requestQueue: RequestQueue? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityProfileBinding.inflate(layoutInflater)
        val view = binding.root
        setContentView(view)

        binding.edittextEmail.setText(LoginFragment.person.email)
        binding.edittextName.setText(LoginFragment.person.name)
        binding.edittextPhone.setText(LoginFragment.person.phone)
        binding.edittextUserName.setText(LoginFragment.person.username)
        binding.edittextAddress.setText(LoginFragment.person.address)

        binding.buttonUpdate.setOnClickListener {
            if (binding.edittextName.text.toString().isNotEmpty()|| binding.edittextAddress.text.toString().isNotEmpty()){
                requestEdit()
            }else{
                Toast.makeText(this,"Cần nhập đầy đủ thông tin", Toast.LENGTH_SHORT).show()
            }
        }
    }
    private fun requestEdit() {
        requestQueue = Volley.newRequestQueue(this)
        val params: MutableMap<String?, String?> = HashMap()
        params["name"] = binding.edittextName.text.toString()
        params["address"] = binding.edittextAddress.text.toString()
        val objRegData = JSONObject(params as Map<*, *>)

        val request: JsonObjectRequest = object : JsonObjectRequest(Method.PUT, requestUpdateProfile,objRegData,Response.Listener { response ->
            if(response!=null){
                Log.e("responseupdateprofile", response.toString())
                Toast.makeText(this,"Sửa thông tin thành công", Toast.LENGTH_SHORT).show()
                person.address = binding.edittextAddress.text.toString()
                person.name = binding.edittextName.text.toString()
            }else{
            }
        }, Response.ErrorListener {
            Log.e("responseupdateerrorr", it.message.toString())
        }) {
            override fun getHeaders(): MutableMap<String, String> {
                val params: MutableMap<String, String> = HashMap()
                params["X-Requested-With"] = "XMLHttpRequest"
                params["Authorization"] =  "Bearer "+ LoginFragment.token
                return params
            }
        }
        requestQueue?.add(request)
    }
}