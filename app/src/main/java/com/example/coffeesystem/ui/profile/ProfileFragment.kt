package com.example.coffeesystem.ui.profile

import android.content.Intent
import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.JsonArrayRequest
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.coffeesystem.MainActivity
import com.example.coffeesystem.R
import com.example.coffeesystem.databinding.FragmentLoginBinding
import com.example.coffeesystem.databinding.FragmentProfileBinding
import com.example.coffeesystem.model.Product
import com.example.coffeesystem.model.User
import com.example.coffeesystem.network.requestLogout
import com.example.coffeesystem.network.requestProduct
import com.example.coffeesystem.network.url
import com.example.coffeesystem.ui.authencation.LoginActivity
import com.example.coffeesystem.ui.authencation.LoginFragment
import com.example.coffeesystem.ui.home.HomeFragment
import org.json.JSONException
import org.json.JSONObject

class ProfileFragment : Fragment() {
    private var _binding: FragmentProfileBinding? = null
    private val binding get() = _binding!!
    private var requestQueue: RequestQueue? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

    }

    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?,
                              savedInstanceState: Bundle?): View? {
        _binding = FragmentProfileBinding.inflate(inflater, container, false)
        return binding.root


    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        binding.btnProfile.setOnClickListener() {
            startActivity(Intent(activity, ProfileActivity::class.java))
        }
        binding.btnLogout.setOnClickListener {
            requestLogout()
            startActivity(Intent(activity, MainActivity::class.java))

        }
        binding.btnPass.setOnClickListener(){
            startActivity(Intent(activity, ChangePasswordActivity::class.java))
        }
//        if(isLogin()){
//            binding.btnLogout.text = "Đăng nhập"
//            startActivity(Intent(activity,LoginActivity::class.java))
//        }else{
//            binding.btnLogout.text = "Đăng xuất"
//        }
    }
    private fun requestLogout() {
        requestQueue = Volley.newRequestQueue(activity)
        val request: StringRequest = object : StringRequest(Request.Method.POST, requestLogout, Response.Listener { response ->
            Log.e("responselogout", response)
        }, Response.ErrorListener {
            Log.e("responselogouterror", it.message.toString())
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