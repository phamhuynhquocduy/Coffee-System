package com.example.coffeesystem

import android.app.Activity
import android.content.Context
import android.content.Intent
import android.content.SharedPreferences
import android.os.Bundle
import android.util.Log
import com.google.android.material.bottomnavigation.BottomNavigationView
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.ContextCompat.startActivity
import androidx.fragment.app.Fragment
import com.android.volley.Request
import com.android.volley.RequestQueue
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.coffeesystem.model.User
import com.example.coffeesystem.ui.authencation.ForgotActivity
import com.example.coffeesystem.ui.authencation.LoginActivity
import com.example.coffeesystem.ui.authencation.LoginFragment
import com.example.coffeesystem.ui.authencation.LoginFragment.Companion.token
import com.example.coffeesystem.ui.dashboard.DashboardFragment
import com.example.coffeesystem.ui.home.HomeFragment
import com.example.coffeesystem.ui.notifications.NotificationsFragment
import com.example.coffeesystem.ui.profile.ProfileFragment
import org.json.JSONObject

class MainActivity : AppCompatActivity() {
    private var requestQueue: RequestQueue? = null
    private lateinit var authen :String

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        //first fragment
        loadFragment(HomeFragment())
        val sharedPref = getSharedPreferences("preference_login_key", Context.MODE_PRIVATE)
        with(
            sharedPref.getString(
                "preference_login_status",
                null
            )
        ) {
            if (this != null) {
                getPerson()
            }
        }


        val navView: BottomNavigationView = findViewById(R.id.nav_view)
        navView.setOnNavigationItemSelectedListener {
            when(it.itemId){
                R.id.navigation_home-> {
                    loadFragment(HomeFragment())
                    return@setOnNavigationItemSelectedListener true
                }

                R.id.navigation_notifications-> {
                    loadFragment(NotificationsFragment())
                    return@setOnNavigationItemSelectedListener true
                }

                R.id.navigation_dashboard-> {
                    loadFragment(DashboardFragment())
                    return@setOnNavigationItemSelectedListener true
                }
                R.id.navigation_profile-> {
                    loadFragment(ProfileFragment())
                    return@setOnNavigationItemSelectedListener true
                }
            }
            false
        }
    }


    private fun loadFragment(fragment: Fragment) {
        // load fragment
        val transaction = supportFragmentManager.beginTransaction()
        transaction.replace(R.id.nav_host_fragment, fragment)
        transaction.commit()
    }
    private fun getPerson() {
        val sharedPref = getSharedPreferences("preference_login_key", Context.MODE_PRIVATE)
        authen = sharedPref.getString("preference_login_status", null)!!
        token = authen
        requestQueue = Volley.newRequestQueue(this)
        val request: StringRequest = object : StringRequest(
            Request.Method.GET,
            com.example.coffeesystem.network.getAccount, Response.Listener { response ->
                val userObject = JSONObject(response)
                val id = userObject.getInt("id")
                val username = userObject.getString("username")
                val name = userObject.getString("name")
                val phone = userObject.getString("phone")
                val address = userObject.getString("address")
                val email = userObject.getString("email")
                LoginFragment.person = User(id, username, name, email, phone, address)
                Log.e("responseaccount", response)
                Log.e("responseaccount", authen)

        }, Response.ErrorListener {
            Log.e("responseerror", it.message.toString()+ sharedPref )
        }) {
            override fun getHeaders(): MutableMap<String, String> {
                val params: MutableMap<String, String> = HashMap()
                params["Authorization"] = "Bearer $authen"
                return params
            }
        }
        requestQueue?.add(request)
    }
}