package com.example.coffeesystem

import android.os.Bundle
import com.google.android.material.bottomnavigation.BottomNavigationView
import androidx.appcompat.app.AppCompatActivity
import androidx.fragment.app.Fragment
import com.example.coffeesystem.ui.dashboard.DashboardFragment
import com.example.coffeesystem.ui.home.HomeFragment
import com.example.coffeesystem.ui.notifications.NotificationsFragment

class MainActivity : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

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

            }
            false

        }
    }
    private fun loadFragment(fragment: Fragment) {
        // load fragment
        val transaction = supportFragmentManager.beginTransaction()
        transaction.replace(R.id.nav_host_fragment, fragment)
        transaction.addToBackStack(null)
        transaction.commit()
    }
}