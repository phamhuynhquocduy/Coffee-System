package com.example.coffeesystem.ui.profile

import android.content.Context
import android.content.Intent
import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.core.view.isGone
import androidx.core.view.isInvisible
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

    override fun onCreateView(inflater: LayoutInflater, container: ViewGroup?,
                              savedInstanceState: Bundle?): View? {
        _binding = FragmentProfileBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        val sharedPref = requireContext().getSharedPreferences("preference_login_key", Context.MODE_PRIVATE)
        with(
            sharedPref.getString(
                "preference_login_status",
                null
            )
        ) {
            if (this !=null) {
                Log.e("share",this)
                binding.btnPass.visibility= View.VISIBLE
                binding.btnLogout.text ="Đăng xuất"
                sharedPref.edit()
            }else{
                binding.btnPass.visibility = View.GONE
                binding.btnLogout.text ="Đăng nhập"
            }
        }
        binding.btnLogout.setOnClickListener {
            val sharedPref = requireContext().getSharedPreferences("preference_login_key", Context.MODE_PRIVATE)
            with(
                sharedPref.getString(
                    "preference_login_status",
                    null
                )
            ) {
                if (this !=null) {
                    requestLogout()
                }else{
                    startActivity(Intent(activity, LoginActivity::class.java))
                }
            }
        }
        binding.btnPass.setOnClickListener(){
                    startActivity(Intent(activity, ChangePasswordActivity::class.java))
            }
        binding.btnProfile.setOnClickListener() {
            val sharedPref = requireContext().getSharedPreferences("preference_login_key", Context.MODE_PRIVATE)
            with(
                    sharedPref.getString(
                            "preference_login_status",
                            null
                    )
            ) {
                if (this !=null) {
                    startActivity(Intent(activity, ProfileActivity::class.java))
                }else{
                    binding.btnPass.isInvisible = false
                }
            }

        }

    }
    private fun requestLogout() {
        requestQueue = Volley.newRequestQueue(activity)
        val request: StringRequest = object : StringRequest(Request.Method.POST, requestLogout, Response.Listener { response ->
            Log.e("responselogout", response)
            with(
                requireContext().getSharedPreferences(
                    "preference_login_key", Context.MODE_PRIVATE
                ).edit()
            ) {
                putString(
                    "preference_login_status",
                    null
                )
                commit()
            }
            binding.btnLogout.text ="Đăng nhập"
            val transaction = activity?.supportFragmentManager?.beginTransaction()
            transaction?.replace(R.id.nav_host_fragment, HomeFragment())
            transaction?.commit()
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