package com.example.coffeesystem

import android.app.Activity
import android.content.Intent
import android.content.SharedPreferences
import android.os.Bundle
import com.google.android.material.bottomnavigation.BottomNavigationView
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.ContextCompat.startActivity
import androidx.fragment.app.Fragment
import com.example.coffeesystem.ui.authencation.ForgotActivity
import com.example.coffeesystem.ui.authencation.LoginActivity
import com.example.coffeesystem.ui.authencation.LoginFragment
import com.example.coffeesystem.ui.authencation.LoginFragment.Companion.token
import com.example.coffeesystem.ui.dashboard.DashboardFragment
import com.example.coffeesystem.ui.home.HomeFragment
import com.example.coffeesystem.ui.notifications.NotificationsFragment
import com.example.coffeesystem.ui.profile.ProfileFragment

class MainActivity : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        //first fragment
        loadFragment(HomeFragment())

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
    companion object{
//        lateinit var share : SharedPreferences
//        fun isLogin(): Boolean{
//            if (share.getString("token",null)==null){
//                return true
//            }
//            return false
//        }
    }

    private fun loadFragment(fragment: Fragment) {
        // load fragment
        val transaction = supportFragmentManager.beginTransaction()
        transaction.replace(R.id.nav_host_fragment, fragment)
        transaction.commit()
    }
}