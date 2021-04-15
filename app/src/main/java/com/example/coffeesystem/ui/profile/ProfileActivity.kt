package com.example.coffeesystem.ui.profile

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import com.example.coffeesystem.databinding.ActivityProfileBinding
import com.example.coffeesystem.ui.authencation.LoginFragment

class ProfileActivity : AppCompatActivity() {

    private lateinit var binding: ActivityProfileBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityProfileBinding.inflate(layoutInflater)
        val view = binding.root
        setContentView(view)

        binding.edittextEmail.setText( LoginFragment.person.email)
        binding.edittextName.setText(LoginFragment.person.name)
        binding.edittextPhone.setText(LoginFragment.person.phone)
        binding.edittextUserName.setText(LoginFragment.person.username)
        binding.edittextAddress.setText(LoginFragment.person.address)
    }

}