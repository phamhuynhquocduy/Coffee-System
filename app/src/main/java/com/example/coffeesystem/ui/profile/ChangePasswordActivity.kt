package com.example.coffeesystem.ui.profile

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.util.Log
import android.widget.Toast
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.JsonObjectRequest
import com.android.volley.toolbox.Volley
import com.example.coffeesystem.R
import com.example.coffeesystem.databinding.ActivityChangePasswordBinding
import com.example.coffeesystem.network.requestUpdatePass
import com.example.coffeesystem.ui.authencation.LoginFragment
import org.json.JSONObject
import java.lang.Exception
import java.util.regex.Matcher
import java.util.regex.Pattern

const val PASS_PATTERN="^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*+=?/-]).{8,15}$";

class ChangePasswordActivity : AppCompatActivity() {

    private lateinit var binding: ActivityChangePasswordBinding
    private var requestQueue: RequestQueue? = null
    private var checkNewPass =false
    private var checkConfirmPass = false

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_change_password)

        binding = ActivityChangePasswordBinding.inflate(layoutInflater)
        val view = binding.root
        setContentView(view)

        binding.buttonChangePassword.setOnClickListener(){
            if(binding.txtNewPassword.text.toString().isNotEmpty()||binding.txtConfirmNewPassword.text.toString().isNotEmpty()||binding.txtOldPassword.text.isNotEmpty()){
                requestEdit()
            }else{
                Toast.makeText(this,"Cần nhập đầy đủ thông tin",Toast.LENGTH_SHORT).show()
            }
        }
    }
    private fun requestEdit() {
        requestQueue = Volley.newRequestQueue(this)
        val params: MutableMap<String?, String?> = HashMap()
        params["password"] = binding.txtNewPassword.text.toString()
        params["re_password"] = binding.txtConfirmNewPassword.text.toString()
        params["old_password"] = binding.txtOldPassword.text.toString()
        val objRegData = JSONObject(params as Map<*, *>)

        val request: JsonObjectRequest = object : JsonObjectRequest(Method.PUT, requestUpdatePass,objRegData, Response.Listener { response ->
            try {
                Log.e("responseupdatepass", response.toString())
                Toast.makeText(this,"Đổi mật khẩu thành công",Toast.LENGTH_SHORT).show()
            }catch (e :Exception){
                Log.e("responseupdateerrorr", response.toString())
                Toast.makeText(this,"Đổi mật khẩu  không thành công",Toast.LENGTH_SHORT).show()
            }
        }, Response.ErrorListener {
            Log.e("responseupdateerrorr", it.message.toString())
            Toast.makeText(this,"Đổi mật khẩu không thành công",Toast.LENGTH_SHORT).show()
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
    fun checkInput(){
        binding.txtNewPassword.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(s: Editable) {
                val patternDate: Pattern = Pattern.compile(com.example.coffeesystem.ui.authencation.PASS_PATTERN, Pattern.CASE_INSENSITIVE)
                val matcher: Matcher = patternDate.matcher(binding.txtNewPassword.text.toString().trim())
                if (binding.txtNewPassword.text.isEmpty()) {
                    binding.newPassWord.error = "Không được để trống"
                    checkNewPass = false
                    binding.buttonChangePassword.isEnabled = false
                } else if (!matcher.matches()) {
                    binding.newPassWord.error ="Mật mẩu phải từ 8 ký tự bao gồm chữ hoa, chữ thường, ký tự đặc biệt"
                    checkNewPass = false
                    binding.buttonChangePassword.isEnabled = false
                } else {
                    binding.newPassWord.error = null
                    checkNewPass = true
                    checkError()
                }
            }
        })
    }
    private fun checkError() {
        binding.buttonChangePassword.isEnabled = checkConfirmPass  && checkNewPass
    }


}