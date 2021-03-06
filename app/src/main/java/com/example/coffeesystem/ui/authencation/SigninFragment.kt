package com.example.coffeesystem.ui.authencation

import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.coffeesystem.R
import com.example.coffeesystem.databinding.FragmentSigninBinding
import java.util.regex.Matcher
import java.util.regex.Pattern

const val EMAIL_PATTERN="^[A-Z0-9._%+-]+@[A-Z0-9.-]+\\.[A-Z]{2,6}$";
const val PHONE_PATTERN="^0[0-9]{9,10}$";
const val PASS_PATTERN="^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*+=?/-]).{8,15}$";
const val USER_PATTERN="[a-zA-Z0-9]{6,15}";


class SigninFragment : Fragment() {
    private var _binding: FragmentSigninBinding? = null
    private val binding get() = _binding!!
    private var requestQueue: RequestQueue? = null
    private var checkName = false
    private  var checkUserName = false
    private  var checkAddress = false
    private  var checkEmail= false
    private  var checkPhone = false
    private  var checkPass = false

    override fun onCreateView(
            inflater: LayoutInflater, container: ViewGroup?,
            savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        _binding = FragmentSigninBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        view.findViewById<TextView>(R.id.txt_sign_in).setOnClickListener {
            findNavController().navigate(R.id.action_SecondFragment_to_FirstFragment)
        }
        binding.buttonSignin.setOnClickListener(){
            jsonParse()
        }
        //check Input
        checkInput()
    }
    private fun jsonParse() {
        requestQueue = Volley.newRequestQueue(activity)
        val url = "http://45.77.29.150/api/customer/register"
        val request: StringRequest = object : StringRequest(Method.POST, url, Response.Listener { response ->
            if (response == "Success!") {
                Toast.makeText(activity, "????ng k?? th??nh c??ng", Toast.LENGTH_SHORT).show()
            } else {
                binding.textviewNotification.text = response
            }
        }, Response.ErrorListener {
            Log.e("response", it.message + "")
            Toast.makeText(activity, "????ng k?? kh??ng th??nh c??ng", Toast.LENGTH_SHORT).show()
        }) {
            override fun getParams(): Map<String, String>? {
                val params: MutableMap<String, String> = HashMap()
                params["username"] = binding.edittextUserName.text.toString()
                params["name"] = binding.edittextName.text.toString()
                params["password"] = binding.edittextPass.text.toString()
                params["email"]=binding.edittextEmail.text.toString()
                params["phone"] =binding.edittextPhone.text.toString()
                params["address"] = binding.edittextAddress.text.toString()
                return params
            }
        }
        requestQueue?.add(request)
    }
    private fun checkInput() {
        binding.edittextEmail.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(s: Editable) {
                val patternDate: Pattern = Pattern.compile(EMAIL_PATTERN, Pattern.CASE_INSENSITIVE)
                val matcher: Matcher = patternDate.matcher(binding.edittextEmail.text.toString().trim())
                if (binding.edittextEmail.text.isEmpty()) {
                    binding.tilEmail.error = "Kh??ng ???????c ????? tr???ng"
                    binding.buttonSignin.isEnabled = false
                    checkEmail = false
                } else if (!matcher.matches()) {
                    binding.tilEmail.error = "Email kh??ng h???p l???"
                    binding.buttonSignin.isEnabled = false
                    checkEmail = false
                } else {
                    binding.tilEmail.error = null
                    checkEmail = true
                    checkError()
                }
            }
        })
        binding.edittextUserName.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(s: Editable) {
                val patternDate: Pattern = Pattern.compile(USER_PATTERN, Pattern.CASE_INSENSITIVE)
                val matcher: Matcher = patternDate.matcher(binding.edittextUserName.text.toString().trim())
                if (binding.edittextUserName.text.isEmpty()) {
                    binding.tilUserName.error = "Kh??ng ???????c ????? tr???ng"
                    binding.buttonSignin.isEnabled = false
                    checkUserName = false
                }
                else if (!matcher.matches()) {
                    binding.tilUserName.error = "T??n t??i kho???n t??? 6 k?? t??? v?? kh??ng ch??? k?? t??? ?????c bi???t"
                    binding.buttonSignin.isEnabled = false
                    checkUserName = false
                } else {
                    binding.tilUserName.error = null
                    checkUserName = true
                    checkError()
                }
            }
        })
        binding.edittextName.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(s: Editable) {
                if (binding.edittextName.text.isEmpty()) {
                    binding.tilName.error = "Kh??ng ???????c ????? tr???ng"
                    checkName = false
                    binding.buttonSignin.isEnabled = false
                } else {
                    binding.tilName.error = null
                    checkName = true
                    checkError()
                }
            }
        })
        binding.edittextPhone.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(s: Editable) {
                val patternDate: Pattern = Pattern.compile(PHONE_PATTERN, Pattern.CASE_INSENSITIVE)
                val matcher: Matcher = patternDate.matcher(binding.edittextPhone.text.toString().trim())
                if (binding.edittextPhone.text.isEmpty()) {
                    binding.tilPhone.error = "Kh??ng ???????c ????? tr???ng"
                    checkPhone = false
                    binding.buttonSignin.isEnabled = false
                } else if (!matcher.matches()) {
                    binding.tilPhone.error = "S??? ??i???n tho???i kh??ng h???p l???"
                    checkPhone = false
                    binding.buttonSignin.isEnabled = false
                } else {
                    binding.tilPhone.error = null
                    checkPhone = true
                    checkError()
                }
            }
        })
        binding.edittextAddress.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(s: Editable) {
                if (binding.edittextAddress.text.isEmpty()) {
                    binding.tilAddress.error="Kh??ng ???????c ????? tr???ng"
                    checkAddress = false
                    binding.buttonSignin.isEnabled = false
                } else {
                    binding.tilAddress.error=null
                    checkAddress = true
                    checkError()
                }
            }
        })
        binding.edittextPass.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence, start: Int, count: Int, after: Int) {}
            override fun onTextChanged(s: CharSequence, start: Int, before: Int, count: Int) {}
            override fun afterTextChanged(s: Editable) {
                val pass: String = binding.edittextPass.text.toString().trim()
                val patternDate: Pattern = Pattern.compile(PASS_PATTERN, Pattern.CASE_INSENSITIVE)
                val matcher: Matcher = patternDate.matcher(binding.edittextPass.text.toString().trim())
                if (binding.edittextPass.text.isEmpty()) {
                    binding.tilPass.error = "Kh??ng ???????c ????? tr???ng"
                    checkPass = false
                    binding.buttonSignin.isEnabled = false
                } else if (!matcher.matches()) {
                    binding.tilPass.error ="M???t m???u ph???i t??? 8 k?? t??? bao g???m ch??? hoa, ch??? th?????ng, k?? t??? ?????c bi???t"
                    checkPass = false
                    binding.buttonSignin.isEnabled = false
                } else {
                    binding.tilPass.error = null
                    checkPass = true
                    checkError()
                }
            }
        })
    }
    private fun checkError() {
        binding.buttonSignin.isEnabled = checkName  && checkUserName  && checkPass && checkEmail && checkAddress && checkPhone
    }
}