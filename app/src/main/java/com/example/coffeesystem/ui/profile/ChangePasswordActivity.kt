package com.example.coffeesystem.ui.profile

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.widget.Toast
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.JsonObjectRequest
import com.android.volley.toolbox.Volley
import com.example.coffeesystem.R
import com.example.coffeesystem.databinding.ActivityChangePasswordBinding
import com.example.coffeesystem.network.requestUpdatePass
import com.example.coffeesystem.network.requestUpdateProfile
import com.example.coffeesystem.ui.authencation.LoginFragment
import org.json.JSONObject

class ChangePasswordActivity : AppCompatActivity() {

    private lateinit var binding: ActivityChangePasswordBinding
    private var requestQueue: RequestQueue? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_change_password)

        binding = ActivityChangePasswordBinding.inflate(layoutInflater)
        val view = binding.root
        setContentView(view)

        binding.buttonChangePassword.setOnClickListener(){
            requestEdit()
        }
    }
    private fun requestEdit() {
        requestQueue = Volley.newRequestQueue(this)
        val params: MutableMap<String?, String?> = HashMap()
        params["password"] = binding.txtNewPassword.text.toString()
        params["re_password"] = binding.txtConfirmNewPassword.text.toString()
        val objRegData = JSONObject(params as Map<*, *>)

        val request: JsonObjectRequest = object : JsonObjectRequest(Method.PUT, requestUpdatePass,objRegData, Response.Listener { response ->
            Log.e("responseupdatepass", response.toString())
            Toast.makeText(this,"Đổi mật khẩu thành công",Toast.LENGTH_SHORT).show()
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