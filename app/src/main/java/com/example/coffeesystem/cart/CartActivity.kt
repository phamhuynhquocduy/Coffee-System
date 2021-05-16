package com.example.coffeesystem.cart

import android.content.Context
import android.os.Bundle
import android.view.View
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import com.android.volley.RequestQueue
import com.example.coffeesystem.DatabaseHandler
import com.example.coffeesystem.databinding.ActivityCartBinding
import java.text.DecimalFormat


class CartActivity : AppCompatActivity() {
    private lateinit var binding: ActivityCartBinding
    private val mAdapter = CartAdapter(arrayListOf())
    private var requestQueue: RequestQueue? = null
    private val databaseHandler: DatabaseHandler= DatabaseHandler(this)

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityCartBinding.inflate(layoutInflater)
        val view = binding.root
        setContentView(view)


        mAdapter.addItems(databaseHandler.viewCart())
        val layoutManager = LinearLayoutManager(this)
        binding.recyclerviewCart.layoutManager = layoutManager
        binding.recyclerviewCart.adapter = mAdapter

        val decimalFormat = DecimalFormat("###,###,###")
        binding.txtTotal.text = decimalFormat.format(eventTotal(this)).toString() + " đ"

        checkData()
        setActionBar()

    }
    companion object{
        fun eventTotal(context: Context): Int {
            val databaseHandler: DatabaseHandler= DatabaseHandler(context)

            var total = 0
            for (i in 0 until databaseHandler.viewCart().size) {
                total += (databaseHandler.viewCart()[i].price*databaseHandler.viewCart()[i].count).toInt()
            }
            return  total
        }
    }

    private fun checkData() {
        if (databaseHandler.viewCart().size <= 0) {
            binding.textviewNotification.visibility = View.VISIBLE
            binding.recyclerviewCart.visibility = View.INVISIBLE
        } else {
            binding.textviewNotification.visibility = View.INVISIBLE
            binding.recyclerviewCart.visibility = View.VISIBLE
        }
    }
    private fun setActionBar() {
        setSupportActionBar(binding.toolbar)
        supportActionBar!!.title = ""
        supportActionBar!!.setDisplayHomeAsUpEnabled(true)
        binding.toolbar.setNavigationOnClickListener(View.OnClickListener { finish() })
    }

}