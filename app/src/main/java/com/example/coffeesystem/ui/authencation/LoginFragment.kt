package com.example.coffeesystem.ui.authencation

import android.content.Context
import android.content.Intent
import android.net.Uri
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.coffeesystem.MainActivity
import com.example.coffeesystem.R
import com.example.coffeesystem.databinding.FragmentLoginBinding
import com.example.coffeesystem.model.User
import org.json.JSONException
import org.json.JSONObject


class LoginFragment : Fragment() {
    private var _binding: FragmentLoginBinding? = null
    private val binding get() = _binding!!
    private var requestQueue: RequestQueue? = null

    override fun onCreateView(
            inflater: LayoutInflater, container: ViewGroup?,
            savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        _binding = FragmentLoginBinding.inflate(inflater, container, false)
        return binding.root
    }

    companion object{
        @JvmStatic lateinit var person : User
        @JvmStatic lateinit var token :String
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        view.findViewById<TextView>(R.id.txt_sign_in).setOnClickListener {
            findNavController().navigate(R.id.action_FirstFragment_to_SecondFragment)
        }
        //login
        binding.buttonLogin.setOnClickListener(){
            requestLogin()
        }
        //forgot password
        binding.txtForgotPassword.setOnClickListener(){
            val intent = Intent(Intent.ACTION_VIEW).setData(Uri.parse("http://45.77.29.150/customer/send-mail-api"))
            startActivity(intent)
//            startActivity(Intent(activity, ForgotActivity::class.java))
        }
    }
    private fun requestLogin() {
        requestQueue = Volley.newRequestQueue(activity)
        val url = "http://45.77.29.150/api/customer/login"
        val request: StringRequest = object : StringRequest(Request.Method.POST, url, Response.Listener { response ->
            if (response != null) {
                try {
                    val jsonObject = JSONObject(response)
                    token = jsonObject.getString("access_token")
                    val userObject = jsonObject.get("user") as JSONObject
                    val id = userObject.getInt("id")
                    val username = userObject.getString("username")
                    val name = userObject.getString("name")
                    val phone = userObject.getString("phone")
                    val address = userObject.getString("address")
                    val email = userObject.getString("email")
                    person = User(id, username, name, email, phone, address)
                    with(
                        requireContext().getSharedPreferences(
                            "preference_login_key", Context.MODE_PRIVATE
                        ).edit()
                    ) {
                        putString(
                            "preference_login_status",
                            token
                        )
                        commit()
                    }
                    Log.e("response", response)
                    startActivity(Intent(activity, MainActivity::class.java))
                    activity?.finish()
                } catch (e: JSONException) {
                    binding.textviewNotification.text = "Đăng nhập không thành công"
                }
            } else {
                Log.e("response", "Data Null")
            }
        }, Response.ErrorListener {
            Log.e("response", it.message.toString())
        }) {
            override fun getParams(): Map<String, String>? {
                val params: MutableMap<String, String> = HashMap()
                params["username"] = binding.edittextEmail.text.toString()
                params["password"] = binding.edittextPass.text.toString()
                return params
            }
        }
        requestQueue?.add(request)
    }
}