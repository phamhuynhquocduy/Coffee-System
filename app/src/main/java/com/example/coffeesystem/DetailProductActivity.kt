package com.example.coffeesystem

import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import com.example.coffeesystem.databinding.ActivityDetailProductBinding
import com.example.coffeesystem.model.Product
import com.squareup.picasso.Picasso
import java.text.DecimalFormat

class DetailProductActivity : AppCompatActivity() {
    private lateinit var binding: ActivityDetailProductBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityDetailProductBinding.inflate(layoutInflater)
        val view = binding.root
        setContentView(view)

        val product = intent.getSerializableExtra("Detail") as? Product
        binding.textviewName.text = product?.name
        binding.textviewDescription.text=product?.description
        val dec = DecimalFormat("###,###.#")
        val price = dec.format(product?.price)
        binding.textviewPrice.text=price
        Picasso.get().load(product?.image)
                .into(binding.imageview)
        }
    }
