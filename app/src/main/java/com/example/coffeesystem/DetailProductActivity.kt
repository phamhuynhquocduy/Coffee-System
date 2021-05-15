package com.example.coffeesystem

import android.R.attr.name
import android.R.id
import android.content.Context
import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.example.coffeesystem.cart.CartActivity
import com.example.coffeesystem.databinding.ActivityDetailProductBinding
import com.example.coffeesystem.model.Cart
import com.example.coffeesystem.model.Product
import com.example.coffeesystem.ui.authencation.LoginActivity
import com.example.coffeesystem.ui.authencation.LoginFragment
import com.squareup.picasso.Picasso
import java.text.DecimalFormat


class DetailProductActivity : AppCompatActivity() {
    private lateinit var binding: ActivityDetailProductBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityDetailProductBinding.inflate(layoutInflater)
        val view = binding.root

        setContentView(view)

        var count = binding.buttonValues.text.toString().toInt()
        setValueCount(count)


        val product = intent.getSerializableExtra("Detail") as? Product
        binding.textviewName.text = product?.name
        binding.textviewDescription.text = product?.description
        val dec = DecimalFormat("###,###.#")
        val price = dec.format(product?.price)
        binding.textviewPrice.text = price
        Picasso.get().load(product?.image)
                .into(binding.imageview)

        var priceproduct = product?.price?.times(count)
        binding.txtTotal.text = dec.format(priceproduct) + " đ"

        binding.buttonMinus.setOnClickListener() {
            var count = binding.buttonValues.text.toString().toInt()
            if (count > 1) {
                count -= 1
                setValueCount(count)
                binding.buttonValues.text = count.toString()
                var priceproduct = product?.price?.times(count)
                binding.txtTotal.text = dec.format(priceproduct) + " đ"

            }
        }
        binding.buttonPlus.setOnClickListener() {
            var count = binding.buttonValues.text.toString().toInt()
            if (count < 20) {
                count += 1
                setValueCount(count)
                binding.buttonValues.text = count.toString()
                var priceproduct = product?.price?.times(count)
                binding.txtTotal.text = dec.format(priceproduct) + " đ"
            }
        }
        binding.buttonAddCart.setOnClickListener() {
            val sharedPref = getSharedPreferences("preference_login_key", Context.MODE_PRIVATE)
            val account = sharedPref.getString("preference_login_status", null)
            if (account != null) {
                val databaseHandler: DatabaseHandler = DatabaseHandler(this)
                if (databaseHandler.viewCart().size > 0) {
                    var count = binding.buttonValues.text.toString().toInt()
                    var exits = false
                    for (i in 0 until databaseHandler.viewCart().size) {
                        if (databaseHandler.viewCart()[i].idProduct === product?.id) {
                            if (databaseHandler.viewCart()[i].count + count <= 20) {
                                databaseHandler.updateCart(databaseHandler.viewCart()[i], databaseHandler.viewCart()[i].count + count)
                            }else{
                                databaseHandler.updateCart(databaseHandler.viewCart()[i], 20)
                            }
                            exits = true
                            break
                        }
                    }
                    if (exits === false) {
                        var cart = Cart(LoginFragment.person.id, product?.id!!, product.name!!, product.image!!, product.description, product.price, product.idcategory, binding.buttonValues.text.toString().toInt())
                        databaseHandler.addCart(cart)
                    }
                }else{
                    var cart = Cart(LoginFragment.person.id, product?.id!!, product.name!!, product.image!!, product.description, product.price, product.idcategory, binding.buttonValues.text.toString().toInt())
                    databaseHandler.addCart(cart)
                }
                startActivity(Intent(this, CartActivity::class.java))
            }
            else {
                    startActivity(Intent(this, LoginActivity::class.java))
            }
        }
    }
    private fun setValueCount(value: Int){
        when (value) {
            1 -> {
                binding.buttonMinus.isEnabled = false
                binding.buttonMinus.setBackgroundResource(R.drawable.custom_border_enable);
            }
            20 -> {
                binding.buttonPlus.isEnabled = false
                binding.buttonPlus.setBackgroundResource(R.drawable.custom_border_enable);

            }
            else -> {
                binding.buttonMinus.isEnabled=true
                binding.buttonPlus.isEnabled=true
                binding.buttonPlus.setBackgroundResource(R.drawable.custom_border_radius);
                binding.buttonMinus.setBackgroundResource(R.drawable.custom_border_radius);
            }
        }
    }
}
